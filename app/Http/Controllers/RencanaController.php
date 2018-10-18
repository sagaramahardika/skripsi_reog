<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mengajar;
use App\Mahasiswa;
use App\Periode;
use App\Rencana;
use App\SubMatkul;
use App\Kuliah;

class RencanaController extends Controller
{
    public function __construct() {
        $this->middleware('auth:dosen');
    }

    public function index() {
        return view( 'dosen.rencana.index' );
    }

    public function submatkul($id) {
        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'mengajar.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'dosen.rencana.submatkul')->with( 'submatkul', $submatkul );
    }

    public function pencatatan($id) {
        try {
            $rencana = Rencana::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'mengajar.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'dosen.rencana.pencatatan')->with( 'rencana', $rencana );
    }

    public function create($id) {
        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'mengajar.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'dosen.rencana.create')->with( 'submatkul', $submatkul );
    }

    public function edit($id) {
        try {
            $rencana = Rencana::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'rencana.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'dosen.rencana.edit')->with( 'rencana', $rencana );
    }

    public function store( Request $request ) {

        $this->validate($request, [
            'id_sub_matkul' => 'required',
            'pertemuan'     => 'required',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
        ]);

        $total_pertemuan = $request->input('pertemuan');
        $id_sub_matkul = $request->input('id_sub_matkul');
        $waktu_mulai = strtotime( $request->input('waktu_mulai') );
        $waktu_selesai = strtotime( $request->input('waktu_selesai') );

        $max_pertemuan = Rencana::where('id_sub_matkul', $id_sub_matkul)->max('pertemuan');
        if ( empty($max_pertemuan) ) {
            $max_pertemuan = 0;
        }

        for( $i = 1; $i <= $total_pertemuan; $i++ ) {
            $rencana = new Rencana();
            $rencana->id_sub_matkul = $id_sub_matkul;
            $rencana->pertemuan = $max_pertemuan + $i;
            $rencana->waktu_mulai = $waktu_mulai + $i * 604800;
            $rencana->waktu_selesai = $waktu_selesai + $i * 604800;
            $rencana->save();
        }

        $request->session()->flash(
            'success', "$total_pertemuan Rencana successfully added!"
        );
        return redirect()->route( 'rencana.rps', $request->input('id_sub_matkul') );
    }

    public function kuliah_store( Request $request ) {

        $this->validate($request, [
            'id_rencana'    => 'required',
            'catatan'       => 'required',
            'nim'           => 'required',
        ]);

        $mahasiswa = Mahasiswa::where('nim', $request->input('nim') )
        ->first();

        if ( !Hash::check( $request->input('password'), $mahasiswa->password ) ) {
            $request->session()->flash(
                'error', "NIM / Password is wrong"
            );
            return redirect()->route( 'rencana.pencatatan', $request->input('id_rencana') );
        }

        $kuliah = Kuliah::where('id_rencana', $request->input('id_rencana') )->first();

        $kuliah->catatan = $request->input('catatan');
        $kuliah->nim = $request->input('nim');
        $kuliah->waktu_selesai = strtotime( date("Y-m-d H:i") );
        $kuliah->save();

        $request->session()->flash(
            'success', "Rencana successfully added!"
        );
        return redirect()->route( 'rencana.rps', $kuliah->rencana->id_sub_matkul );
    }

    public function start_session($id, Request $request ) {
        try {
            $rencana = Rencana::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'rencana.rps', $rencana->id_sub_matkul )
                ->with('error', "Failed to Start Session {$id}");
        }
        
        $kuliah = new Kuliah();
        $kuliah->id_rencana = $rencana->id;
        $kuliah->waktu_mulai = strtotime( date("Y-m-d H:i") );
        $kuliah->save();

        $request->session()->flash(
            'success', "Kelas pertemuan {$rencana->pertemuan} telah dimulai"
        );
        return redirect()->route( 'rencana.rps', $rencana->id_sub_matkul );
    }

    public function update($id, Request $request ) {
        try {
            $rencana = Rencana::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update Mata Kuliah with kode matakuliah {$id}!"
            );
            return redirect()->route( 'mengajar.index' );
        }

        $this->validate($request, [
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
        ]);

        $rencana->pembelajaran = $request->input('pembelajaran');
        $rencana->waktu_mulai = strtotime( $request->input('waktu_mulai') );
        $rencana->waktu_selesai = strtotime( $request->input('waktu_selesai') );
        $rencana->save();

        $request->session()->flash(
            'success', "Rencana {$id} successfully updated!"
        );
        return redirect()->route( 'rencana.rps', $rencana->id_sub_matkul );
    }

    public function delete($id, Request $request) {
        try {
            $rencana = Rencana::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete Rencana with ID {$id}!"
            );
            return redirect()->route( 'mengajar.index' );
        }

        $rencana->delete();

        $request->session()->flash(
            'success', "Rencana pertemuan {$rencana->pertemuan} has been deleted!"
        );
        return redirect()->route( 'rencana.index' );
    }

    public function rencanaSubMatkul( Request $request ) {
        $dosen = Auth::guard('dosen')->user();
        $id_sub_matkul = $request->input('id_sub_matkul');
        $max_pertemuan = Rencana::whereHas('kuliah', function ($query) {
            $query->whereNotNull('waktu_selesai');
        })->where('id_sub_matkul', $id_sub_matkul)
        ->max('pertemuan');

        if ( empty($max_pertemuan) ) {
            $max_pertemuan = 0;
        }

        $columns = array(
            0   => 'pertemuan', 
            1   => 'pembelajaran',
            2   => 'waktu_mulai',
            3   => 'waktu_selesai',
            4   => 'id',
        );

        $totalData = Rencana::where('id_sub_matkul', $id_sub_matkul)->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
                        
        $rencanas = Rencana::where('id_sub_matkul', $id_sub_matkul)
        ->orderBy($order,$dir)
        ->get();

        $data = array();
        if(!empty($rencanas)) {
            foreach ($rencanas as $rencana) {
                $edit = route( 'rencana.edit', $rencana->id );
                $delete = route( 'rencana.delete', $rencana->id );
                $pencatatan = route( 'rencana.pencatatan', $rencana->id );
                $start_session = route( 'rencana.start_session', $rencana->id );

                $nestedData['pertemuan'] = $rencana->pertemuan;
                $nestedData['pembelajaran'] = $rencana->pembelajaran;
                $nestedData['waktu_mulai'] = date('d/m/Y H:i', $rencana->waktu_mulai );
                $nestedData['waktu_selesai'] = date('d/m/Y H:i', $rencana->waktu_selesai );
                $nestedData['options'] = "";

                if ( is_null($rencana->kuliah) ) {
                    $nestedData['options'] .= "
                        <a href='{$edit}' title='EDIT' class='btn btn-info' > Edit </a>
                        <form action='{$delete}' method='POST' style='display:inline-block'>
                            <input type='hidden' name='_method' value='DELETE'>
                            <input type='hidden' value='" . $request->session()->token() . "' name='_token' />
                            <button class='btn btn-danger'> Delete </button>
                        </form>
                    ";

                    if ( $max_pertemuan + 1 == $rencana->pertemuan ) {
                        $nestedData['options'] .= "
                            <form action='{$start_session}' method='POST' style='display:inline-block'>
                                <input type='hidden' value='" . $request->session()->token() . "' name='_token' />
                                <button class='btn btn-info'> Mulai Kelas </button>
                            </form>
                        ";
                    }

                } elseif ( empty($rencana->kuliah->waktu_selesai) ) {
                    $nestedData['options'] .= "<a href='{$pencatatan}' title='RPS' class='btn btn-info' >Pencatatan</a>";
                }

                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        return response()->json( $json_data );
    }

    // get all matakuliah for Datatable
    public function subMatkulPeriode( Request $request ) {
        $dosen = Auth::guard('dosen')->user();
        $latest_periode = Periode::max('id');

        $columns = array(
            0   => 'id', 
            1   => 'kd_matkul',
            2   => 'nama_matkul',
            3   => 'grup',
            4   => 'dosen',
            5   => 'id',
        );

        $totalData = SubMatkul::whereHas('pengajar', function ($query) use ($dosen) {
            $query->where('nik', $dosen->nik );
        })->where('id_periode', $latest_periode)->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $submatkuls = SubMatkul::whereHas('pengajar', function ($query) use ($dosen) {
                $query->where('nik', $dosen->nik );
            })->where('id_periode', $latest_periode)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $submatkuls = SubMatkul::whereHas('pengajar', function ($query) use ($dosen, $search) {
                $query->where('nik', $dosen->nik );
            })->where('id_periode', $latest_periode)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = SubMatkul::whereHas('pengajar', function ($query) use ($dosen, $search) {
                $query->where('nik', $dosen->nik );
            })->where('id_periode', $latest_periode)
            ->count();
        }

        $data = array();
        if(!empty($submatkuls)) {
            foreach ($submatkuls as $submatkul) {
                $rps = route( 'rencana.rps', $submatkul->id );
                $laporan =  route( 'submatkul.laporan', $submatkul->id );

                $nestedData['kd_matkul'] = $submatkul->kd_matkul;
                $nestedData['nama_matkul'] = $submatkul->matkul->nama_matkul;
                $nestedData['grup'] = $submatkul->grup;
                $nestedData['sks'] = $submatkul->matkul->sks;
                $nestedData['harga'] = $submatkul->matkul->harga;
                $nestedData['options'] = "
                    <a href='{$rps}' title='RPS' class='btn btn-info' >RPS</a>
                ";

                if ( $dosen->jabatan == "dosen" ) {
                    $nestedData['options'] .= "
                        <a href='{$laporan}' title='Laporan' class='btn btn-info' >Laporan</a>
                    ";  
                }

                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        return response()->json( $json_data );
    }
}
