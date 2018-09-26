<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dosen;
use App\MataKuliah;
use App\Mengajar;
use App\Periode;
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
        $allDosen = Dosen::where('kd_prodi', $kaprodi->kd_prodi)->get();

        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'submatkul.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'kaprodi.matkul.dosen', [
            'allDosen'  => $allDosen
        ])->with( 'submatkul', $submatkul );
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
        })->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $submatkuls = SubMatkul::whereHas('matkul', function ($query) use ($kaprodi) {
                $query->where('kd_prodi', $kaprodi->kd_prodi);
            })->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $submatkuls = SubMatkul::whereHas('matkul', function ($query) use ($kaprodi, $search) {
                $query->where('kd_prodi', $kaprodi->kd_prodi)
                ->orWhere('kd_matkul', 'LIKE', "%$search%")
                ->orWhere('nama_matkul', 'LIKE', "%$search%");
            })->where('grup', 'LIKE', "$$search%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = SubMatkul::whereHas('matkul', function ($query) use ($kaprodi, $search) {
                $query->where('kd_prodi', $kaprodi->kd_prodi)
                ->orWhere('kd_matkul', 'LIKE', "%$search%")
                ->orWhere('nama_matkul', 'LIKE', "%$search%");
            })->where('grup', 'LIKE', "$$search%")
            ->count();
        }

        $data = array();
        if(!empty($submatkuls)) {
            foreach ($submatkuls as $submatkul) {

                $edit = route( 'submatkul.edit', $submatkul->id );
                $delete =  route( 'submatkul.delete', $submatkul->id );
                $manageDosen = route( 'submatkul.dosen', $submatkul->id );
                $laporan =  route( 'submatkul.laporan', $submatkul->id );

                if ( !$submatkul->pengajar->isEmpty() ) {

                    foreach( $submatkul->pengajar as $pengajar ) {
                        $nestedData['kd_matkul'] = $submatkul->kd_matkul;
                        $nestedData['nama_matkul'] = $submatkul->matkul->nama_matkul;
                        $nestedData['grup'] = $submatkul->grup;
                        $nestedData['dosen'] = $pengajar->dosen->nama;
                        $nestedData['options'] = "
                            <form action='{$delete}' method='POST' style='display:inline-block'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <input type='hidden' value='" . $request->session()->token() . "' name='_token' />
                                <button class='button-options'>
                                    <i class='glyphicon glyphicon-remove'></i>
                                </button>
                            </form>
                            <a href='{$manageDosen}' title='Manage Dosen' class='btn btn-info' >Manage Dosen</a>
                            <a href='{$laporan}' title='Laporan' class='btn btn-info' >Laporan</a>  
                        ";

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
                            <button class='button-options'>
                                <i class='glyphicon glyphicon-remove'></i>
                            </button>
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
            0   => 'id', 
            1   => 'kd_matkul',
            2   => 'nama_matkul',
            3   => 'grup',
            4   => 'dosen',
            5   => 'id',
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

            $submatkuls = Mengajar::where('id_sub_matkul', $id_sub_matkul)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = SubMatkul::where('id_sub_matkul', $id_sub_matkul)
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
                        <button class='button-options'>
                            <i class='glyphicon glyphicon-remove'></i>
                        </button>
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
}