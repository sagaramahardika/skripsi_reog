<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Dosen;
use App\MataKuliah;
use App\Mengajar;
use App\Periode;
use App\Rencana;
use App\SubMatkul;
Use Exception;

class SubMatkulController extends Controller
{
    public function __construct() {
        $this->middleware('auth:dosen');
    }

    public function index() {
        return view( 'kaprodi.matkul.index' );
    }

    public function dosen($id) {
        $kaprodi = Auth::guard('dosen')->user();
        $allDosenProdi = Dosen::where('kd_prodi', $kaprodi->kd_prodi)->get();

        $allDosenSubmatkul = Dosen::whereHas('mengajar', function ($query) use ($id) {
            $query->where('id_sub_matkul', '=', $id);
        })->get();

        $allDosen = $allDosenProdi->diff($allDosenSubmatkul);

        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'submatkul.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'kaprodi.matkul.dosen', [
            'allDosen'      => $allDosen,
            'submitDosen'   => ( $allDosenSubmatkul->isEmpty() ) ? true : false
        ])->with( 'submatkul', $submatkul );
    }

    public function laporan($id) {
        $kaprodi = Auth::guard('dosen')->user();

        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'submatkul.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'kaprodi.matkul.laporan' )->with( 'submatkul', $submatkul );
    }

    public function create() {
        $kaprodi = Auth::guard('dosen')->user();
        
        $allMatakuliah = MataKuliah::where('kd_prodi', $kaprodi->kd_prodi)->get();
        $allPeriode = Periode::all();

        return view( 'kaprodi.matkul.create', [
            'allMatakuliah' => $allMatakuliah,
            'allPeriode'    => $allPeriode,
        ]);
    }

    public function create_session($id) {
        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'submatkul.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'kaprodi.matkul.create_session' )->with( 'submatkul', $submatkul );
    }

    public function edit($id) {
        $kaprodi = Auth::guard('dosen')->user();

        $allMatakuliah = MataKuliah::where('kd_prodi', $kaprodi->kd_prodi)->get();
        $allPeriode = Periode::all();

        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'submatkul.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'kaprodi.matkul.edit', [
            'allMatakuliah' => $allMatakuliah,
            'allPeriode'    => $allPeriode,
        ])->with( 'submatkul', $submatkul );
    }

    public function store( Request $request ) {
        $this->validate($request, [
            'id_periode'    => 'required',
            'kd_matkul'     => 'required|alpha_num|size:6',
            'grup'          => 'required',
        ]);

        $submatkul = new SubMatkul();
        $submatkul->id_periode = $request->input('id_periode');
        $submatkul->kd_matkul = $request->input('kd_matkul');
        $submatkul->grup = $request->input('grup');
        $submatkul->save();

        $request->session()->flash(
            'success', "Sub Mata Kuliah successfully added!"
        );
        return redirect()->route( 'submatkul.index' );
    }

    public function store_session( Request $request ) {
        $this->validate($request, [
            'id_sub_matkul' => 'required',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
        ]);

        $id_sub_matkul = $request->input('id_sub_matkul');
        $waktu_mulai = strtotime( $request->input('waktu_mulai') );
        $waktu_selesai = strtotime( $request->input('waktu_selesai') );

        $max_pertemuan = Rencana::where('id_sub_matkul', $id_sub_matkul)->max('pertemuan');
        if ( empty($max_pertemuan) ) {
            $max_pertemuan = 0;
        }

        for( $i = 1; $i <= 14; $i++ ) {
            $rencana = new Rencana();
            $rencana->id_sub_matkul = $id_sub_matkul;
            $rencana->pertemuan = $max_pertemuan + $i;
            if ( $i > 7 ) {
                $rencana->waktu_mulai = $waktu_mulai + ( $i + 2 ) * 604800;
                $rencana->waktu_selesai = $waktu_selesai + ( $i + 2 ) * 604800;
            } else {
                $rencana->waktu_mulai = $waktu_mulai + $i * 604800;
                $rencana->waktu_selesai = $waktu_selesai + $i * 604800;
            }
            $rencana->save();
        }

        $request->session()->flash(
            'success', "Rencana successfully added!"
        );
        return redirect()->route( 'submatkul.index' );
    }

    public function dosen_store( Request $request ) {
        $this->validate($request, [
            'id_sub_matkul' => 'required',
            'nik'           => 'required',
        ]);

        $mengajar = new Mengajar();
        $mengajar->id_sub_matkul = $request->input('id_sub_matkul');
        $mengajar->nik = $request->input('nik');
        $mengajar->save();

        $request->session()->flash(
            'success', "Sub Mata Kuliah successfully added!"
        );
        return redirect()->route( 'submatkul.dosen', ['id' => $request->input('id_sub_matkul') ] );
    }

    public function update($id, Request $request ) {
        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update Mata Kuliah with kode matakuliah {$id}!"
            );
            return redirect()->route( 'submatkul.index' );
        }

        $this->validate($request, [
            'id_periode'    => 'required',
            'kd_matkul'     => 'required|alpha_num|size:6',
            'grup'          => 'required',
        ]);

        $submatkul->id_periode = $request->input('id_periode');
        $submatkul->kd_matkul = $request->input('kd_matkul');
        $submatkul->grup = $request->input('grup');
        $submatkul->save();

        $request->session()->flash(
            'success', "Sub Matakuliah {$submatkul->id} successfully updated!"
        );
        return redirect()->route( 'submatkul.index' );
    }

    public function delete($id, Request $request) {
        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete Sub Matakuliah with ID {$id}!"
            );
            return redirect()->route( 'submatkul.index' );
        }

        $submatkul->delete();

        $request->session()->flash(
            'success', "Sub Matakuliah {$submatkul->id} successfully deleted!"
        );
        return redirect()->route( 'submatkul.index' );
    }

    public function dosen_delete($id, Request $request) {
        try {
            $mengajar = Mengajar::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete Sub Matakuliah with ID {$id}!"
            );
            return redirect()->route( 'submatkul.dosen', ['id' => $mengajar->id_sub_matkul ] );
        }
        $mengajar->delete();

        $request->session()->flash(
            'success', "Mengajar {$id} successfully deleted!"
        );
        return redirect()->route( 'submatkul.dosen', ['id' => $mengajar->id_sub_matkul ] );
    }

    // get all matakuliah for Datatable
    public function all( Request $request ) {
        $kaprodi = Auth::guard('dosen')->user();
        $latest_periode = Periode::max('id');

        $columns = array(
            0   => 'id', 
            1   => 'kd_matkul',
            2   => 'nama_matkul',
            3   => 'grup',
            4   => 'dosen',
            5   => 'id',
        );

        $totalData = SubMatkul::whereHas('matkul', function ($query) use ($kaprodi) {
            $query->where('kd_prodi', $kaprodi->kd_prodi);
        })->where('id_periode', $latest_periode)->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $submatkuls = SubMatkul::whereHas('matkul', function ($query) use ($kaprodi) {
                $query->where('kd_prodi', $kaprodi->kd_prodi);
            })->where('id_periode', $latest_periode)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $submatkuls = SubMatkul::whereHas('matkul', function ($query) use ($kaprodi, $search) {
                $query->where('kd_prodi', $kaprodi->kd_prodi);
                $query->where('kd_matkul', 'LIKE', "%$search%");
            })->where('id_periode', $latest_periode)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = SubMatkul::whereHas('matkul', function ($query) use ($kaprodi, $search) {
                $query->where('kd_prodi', $kaprodi->kd_prodi);
                $query->where('kd_matkul', 'LIKE', "%$search%");
            })->where('id_periode', $latest_periode)
            ->count();
        }

        $data = array();
        if(!empty($submatkuls)) {
            foreach ($submatkuls as $submatkul) {

                $add_session = route( 'submatkul.create_session', $submatkul->id );
                $edit = route( 'submatkul.edit', $submatkul->id );
                $delete =  route( 'submatkul.delete', $submatkul->id );
                $manageDosen = route( 'submatkul.dosen', $submatkul->id );
                $laporan =  route( 'submatkul.laporan', $submatkul->id );
                $total_pertemuan = 0;

                if ( !$submatkul->rencana->isEmpty() ) {
                    $additional_options = "";
                    foreach( $submatkul->rencana as $rencana ) {
                        if ( !empty($rencana->kuliah->waktu_selesai) ) {
                            $total_pertemuan++;
                        }
                    }
                } else {
                    $additional_options = "<a href='{$add_session}' title='Create Pertemuan' class='btn btn-info' > Create Pertemuan </a>";
                }

                if ( !$submatkul->pengajar->isEmpty() ) {

                    foreach( $submatkul->pengajar as $pengajar ) {
                        $nestedData['kd_matkul'] = $submatkul->kd_matkul;
                        $nestedData['nama_matkul'] = $submatkul->matkul->nama_matkul;
                        $nestedData['grup'] = $submatkul->grup;
                        $nestedData['dosen'] = $pengajar->dosen->nama;
                        $nestedData['total_pertemuan'] = $total_pertemuan;
                        $nestedData['options'] = "
                            <form action='{$delete}' method='POST' style='display:inline-block'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <input type='hidden' value='" . $request->session()->token() . "' name='_token' />
                                <button class='btn btn-danger'>Delete</button>
                            </form>
                            <a href='{$manageDosen}' title='Manage Dosen' class='btn btn-info' >Manage Dosen</a>
                            <a href='{$laporan}' title='Laporan' class='btn btn-info' >Laporan</a> 
                        ";
                        $nestedData['options'] .= $additional_options;

                        $data[] = $nestedData;    
                    }

                } else {
                    $nestedData['kd_matkul'] = $submatkul->kd_matkul;
                    $nestedData['nama_matkul'] = $submatkul->matkul->nama_matkul;
                    $nestedData['grup'] = $submatkul->grup;
                    $nestedData['dosen'] = '-';
                    $nestedData['options'] = "
                        <form action='{$delete}' method='POST' style='display:inline-block'>
                            <input type='hidden' name='_method' value='DELETE'>
                            <input type='hidden' value='" . $request->session()->token() . "' name='_token' />
                            <button class='btn btn-danger'>Delete</button>
                        </form>
                        <a href='{$manageDosen}' title='Manage Dosen' class='btn btn-info' >Manage Dosen</a>
                        <a href='{$laporan}' title='Laporan' class='btn btn-info' >Laporan</a>
                    ";

                    $data[] = $nestedData;
                }

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
    public function dosenSubMatkul( Request $request ) {
        $id_sub_matkul = $request->input('id_sub_matkul');

        $columns = array(
            0   => 'nik',
            1   => 'nama',
            2   => 'nik',
        );

        $totalData = Mengajar::where('id_sub_matkul', $id_sub_matkul)->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $mengajars = Mengajar::where('id_sub_matkul', $id_sub_matkul)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $mengajars = Mengajar::whereHas('dosen', function ($query) use ($search) {
                $query->where('nama', 'LIKE', "%$search%");
                $query->orWhere('nik', 'LIKE', "%$search%");
            })->where('id_sub_matkul', $id_sub_matkul)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Mengajar::whereHas('dosen', function ($query) use ($search) {
                $query->where('nama', 'LIKE', "%$search%");
                $query->orWhere('nik', 'LIKE', "%$search%");
            })->where('id_sub_matkul', $id_sub_matkul)
            ->orWhere('nik', 'LIKE', "%$search%")
            ->count();
        }

        $data = array();
        if(!empty($mengajars)) {
            foreach ($mengajars as $mengajar) {
                $delete =  route( 'submatkul.dosen_delete', $mengajar->id );

                $nestedData['nik'] = $mengajar->nik;
                $nestedData['nama'] = $mengajar->dosen->nama;
                $nestedData['options'] = "
                    <form action='{$delete}' method='POST' style='display:inline-block'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' value='" . $request->session()->token() . "' name='_token' />
                        <button class='btn btn-danger'>Delete</button>
                    </form>
                ";

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

    public function laporanSubMatkul( Request $request ) {
        $id_sub_matkul = $request->input('id_sub_matkul');

        $columns = array(
            0   => 'id', 
            1   => 'kd_matkul',
            2   => 'nama_matkul',
            3   => 'grup',
            4   => 'dosen',
            5   => 'id',
        );

        $totalData = Rencana::whereHas('kuliah', function ($query) {
            $query->whereNotNull('nim');
        })->where('id_sub_matkul', $id_sub_matkul)
        ->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
                        
        $rencanas = Rencana::whereHas('kuliah', function ($query) {
            $query->whereNotNull('nim');
        })->where('id_sub_matkul', $id_sub_matkul)
        ->orderBy($order,$dir)
        ->get();

        $data = array();
        if(!empty($rencanas)) {
            foreach ($rencanas as $rencana) {

                $waktu_mulai_rencana = $rencana->waktu_mulai;
                $waktu_selesai_rencana = $rencana->waktu_selesai;
                $waktu_mulai_kuliah = $rencana->kuliah->waktu_mulai;
                $waktu_selesai_kuliah = $rencana->kuliah->waktu_selesai;

                if ( $waktu_mulai_kuliah - $waktu_mulai_rencana <= 900 && $waktu_mulai_kuliah - $waktu_mulai_rencana >= -1200 ) {
                    $keterangan = 'Normal'; //<-- diantara +15 menit sampai -20 menit dari waktu mulai rencana
                }  else {
                    $keterangan = 'Kuliah Pengganti'; //<-- selain aturan diatas 
                }

                $libur = DB::table('acara')->whereRaw( $rencana->waktu_mulai . " >= waktu_mulai ")
                ->whereRaw( $rencana->waktu_mulai . " <= waktu_selesai ")
                ->first();
                if ( empty($libur) ) {
                    $acara = "";
                } else {
                    $acara = " $libur->nama_acara";
                }

                $nestedData['pertemuan'] = $rencana->pertemuan;
                $nestedData['pembelajaran'] = $rencana->pembelajaran;
                $nestedData['waktu_mulai_rencana'] = date('d/m/Y H:i', $rencana->waktu_mulai );
                $nestedData['waktu_selesai_rencana'] = date('d/m/Y H:i', $rencana->waktu_selesai);
                $nestedData['waktu_mulai_kuliah'] = date('d/m/Y H:i', $rencana->kuliah->waktu_mulai);
                $nestedData['waktu_selesai_kuliah'] = date('d/m/Y H:i', $rencana->kuliah->waktu_selesai);
                $nestedData['catatan'] = $rencana->kuliah->catatan;
                $nestedData['nim'] = $rencana->kuliah->nim;
                $nestedData['keterangan'] = $keterangan;
                $nestedData['acara'] = $acara;

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
