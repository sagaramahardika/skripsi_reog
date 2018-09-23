<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\MataKuliah;
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
        $matkul->save();

        $request->session()->flash(
            'success', "Sub Matakuliah {$submatkul->id} successfully updated!"
        );
        return redirect()->route( 'submatkul.index' );
    }

    public function delete($id, Request $request) {
        try {
            $matkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete matakuliah with kd_matakuliah {$id}!"
            );
            return redirect()->route( 'submatkul.index' );
        }

        $matakuliah->delete();

        $request->session()->flash(
            'success', "Sub Matakuliah {$submatkul->id} successfully deleted!"
        );
        return redirect()->route( 'submatkul.index' );
    }

    // get all matakuliah for Datatable
    public function all( Request $request ) {
        $columns = array(
            0   => 'id', 
            1   => 'nama_matkul',
            2   => 'grup',
            4   => 'id',
        );

        $totalData = SubMatkul::count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $submatkuls = SubMatkul::with('matkul')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $submatkuls = SubMatkul::with('matkul')
            ->orWhere('nama_matkul', 'LIKE',"%{$search}%")
            ->orWhere('grup', 'LIKE', "${$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = SubMatkul::with('matkul')
            ->orWhere('nama_matkul', 'LIKE',"%{$search}%")
            ->orWhere('grup', 'LIKE', "${$search}%")
            ->count();
        }

        $data = array();
        if(!empty($submatkuls)) {
            foreach ($submatkuls as $submatkul) {
                $edit = route( 'submatkul.edit', $submatkul->id );
                $delete =  route( 'submatkul.delete', $submatkul->id );

                $nestedData['id'] = $submatkul->id;
                $nestedData['nama_matkul'] = $submatkul->matkul->nama_matkul;
                $nestedData['grup'] = ucfirst($submatkul->grup);
                $nestedData['options'] = "
                    <a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
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
