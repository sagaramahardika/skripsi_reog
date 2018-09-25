<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dosen;
use App\Mengajar;
use App\Periode;
use App\SubMatkul;
Use Exception;

class MengajarController extends Controller
{
    public function __construct() {
        $this->middleware('auth:dosen');
    }

    public function index() {
        return view( 'kaprodi.pengajar.index' );
    }

    public function dosen() {
        return view( 'kaprodi.pengajar.dosen' );
    }

    public function create() {
        $kaprodi = Auth::guard('dosen')->user();
        
        $allDosen = Dosen::where('kd_prodi', $kaprodi->kd_prodi)->get();
        $allPeriode = Periode::all();

        return view( 'kaprodi.pengajar.create', [
            'allDosen'      => $allDosen,
            'allPeriode'    => $allPeriode,
        ]);
    }

    public function edit($id) {
        $kaprodi = Auth::guard('dosen')->user();

        $allDosen = Dosen::where('kd_prodi', $kaprodi->kd_prodi)->get();
        $allPeriode = Periode::all();

        try {
            $mengajar = Mengajar::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'mengajar.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'kaprodi.pengajar.edit', [
            'allDosen'      => $allDosen,
            'allPeriode'    => $allPeriode,
        ])->with( 'mengajar', $mengajar );
    }

    public function store( Request $request ) {
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
        return redirect()->route( 'mengajar.index' );
    }

    public function update($id, Request $request ) {
        try {
            $mengajar = Mengajar::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update Mata Kuliah with kode matakuliah {$id}!"
            );
            return redirect()->route( 'mengajar.index' );
        }

        $this->validate($request, [
            'id_sub_matkul' => 'required',
            'nik'           => 'required',
        ]);

        $mengajar->id_sub_matkul = $request->input('id_sub_matkul');
        $mengajar->nik = $request->input('nik');
        $mengajar->save();

        $request->session()->flash(
            'success', "Sub Matakuliah {$mengajar->id} successfully updated!"
        );
        return redirect()->route( 'mengajar.index' );
    }

    public function delete($id, Request $request) {
        try {
            $mengajar = Mengajar::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete Pengajar with ID {$id}!"
            );
            return redirect()->route( 'mengajar.index' );
        }

        $mengajar->delete();

        $request->session()->flash(
            'success', "Pengajar {$mengajar->id} successfully deleted!"
        );
        return redirect()->route( 'mengajar.index' );
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

                $manageDosen = route( 'mengajar.dosen', $submatkul->id );
                $laporan =  route( 'mengajar.laporan', $submatkul->id );

                if ( !$submatkul->pengajar->isEmpty() ) {

                    foreach( $submatkul->pengajar as $pengajar ) {
                        $nestedData['kd_matkul'] = $submatkul->kd_matkul;
                        $nestedData['nama_matkul'] = $submatkul->matkul->nama_matkul;
                        $nestedData['grup'] = $submatkul->grup;
                        $nestedData['dosen'] = $pengajar->dosen->nama;
                        $nestedData['options'] = "
                            <a href='{$manageDosen}' title='EDIT' >Manage Dosen</a>
                            <a href='{$laporan}' title='EDIT' >Laporan</a>  
                        ";

                        $data[] = $nestedData;    
                    }

                } else {
                    $nestedData['kd_matkul'] = $submatkul->kd_matkul;
                    $nestedData['nama_matkul'] = $submatkul->matkul->nama_matkul;
                    $nestedData['grup'] = $submatkul->grup;
                    $nestedData['dosen'] = '-';
                    $nestedData['options'] = "
                        <a href='{$manageDosen}' title='EDIT' >Manage Dosen</a>
                        <a href='{$laporan}' title='EDIT' >Laporan</a>
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

    // get all submatkuk based on choosen periode
    public function subMatkulPeriode( Request $request ) {

        $allSubMatkul = SubMatkul::whereHas('matkul', function($query) use ($request) {
            $kaprodi = Auth::guard('dosen')->user();
            $q = $request->input('query');

            $query->where('kd_prodi', $kaprodi->kd_prodi)
            ->where('nama_matkul', 'LIKE', "%$q%");
        })->with('matkul')
        ->where('id_periode', $request->input('id_periode') )
        ->get();

        $data = array();
        if ( !empty($allSubMatkul) ) {
            foreach( $allSubMatkul as $submatkul ) {
                $data[] = array(
                    'id'    => $submatkul->id,
                    'label' => $submatkul->matkul->nama_matkul . " (" . $submatkul->grup . ")",
                ); 
            }
        }
        
        return response()->json( $data );
    }
}
