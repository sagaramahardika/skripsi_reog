<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fakultas;
use App\Prodi;
Use Exception;

class ProdiController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        return view( 'admin.prodi.index' );
    }
    
    public function create() {
        $allFakultas = Fakultas::all();

        return view( 'admin.prodi.create', [ 
            'allFakultas'   => $allFakultas,
        ]);
    }

    public function edit($kd_prodi) {
        try {
            $prodi = Prodi::findOrFail($kd_prodi);
        } catch ( Exception $e ) {
            return redirect()->route( 'prodi.index' )
                ->with('error', "Failed to view Prodi with kode prodi {$kd_prodi}");
        }

        $allFakultas = Fakultas::all();

        return view( 'admin.prodi.edit', [
            'allFakultas'   => $allFakultas,
        ])->with( 'prodi', $prodi );
    }

    public function store( Request $request ) {
        $this->validate($request, [
            'kd_fakultas'   => 'required',
            'nama_prodi'    => 'required|string', 
        ]);

        $prodi = new Prodi();
        $prodi->kd_fakultas = $request->input('kd_fakultas');
        $prodi->nama_prodi = $request->input('nama_prodi');
        $prodi->save();

        $request->session()->flash(
            'success', "Prodi {$prodi->nama_prodi} successfully added!"
        );
        return redirect()->route( 'prodi.index' );
    }

    public function update($kd_prodi, Request $request ) {
        try {
            $prodi = Prodi::findOrFail($kd_prodi);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update Prodi with kd_prodi {$kd_prodi}!"
            );
            return redirect()->route( 'prodi.index' );
        }

        $this->validate($request, [
            'nama_prodi'    => 'required|string',
        ]);

        $current_prodi_nama_prodi = $prodi->nama_prodi;
        $prodi->nama_prodi = $request->input('nama_prodi');
        $prodi->save();

        $request->session()->flash(
            'success', "Prodi {$current_prodi_nama_prodi} successfully updated!"
        );
        return redirect()->route( 'prodi.index' );
    }

    public function delete($kd_prodi, Request $request) {
        try {
            $prodi = prodi::findOrFail($kd_prodi);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete Prodi with kd_prodi {$kd_prodi}!"
            );
            return redirect()->route( 'prodi.index' );
        }

        $current_prodi_nama_prodi = $prodi->nama_prodi;
        $prodi->delete();

        $request->session()->flash(
            'success', "Prodi {$current_prodi_nama_prodi} successfully deleted!"
        );
        return redirect()->route( 'prodi.index' );
    }

    // get all prodi for Datatable
    public function all( Request $request ) {
        $columns = array(
            0   => 'kd_prodi', 
            1   => 'nama_fakultas',
            2   => 'nama_prodi',
            3   => 'kd_prodi',
        );

        $totalData = prodi::count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $prodis = prodi::with('fakultas')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $prodis = prodi::with('fakultas')
            ->where('kd_prodi','LIKE',"%{$search}%")
            ->orWhere('nama_prodi', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = prodi::with('fakultas')
            ->where('kd_prodi','LIKE',"%{$search}%")
            ->orWhere('nama_prodi', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($prodis)) {
            foreach ($prodis as $prodi) {
                $edit = route( 'prodi.edit', $prodi->kd_prodi );
                $delete =  route( 'prodi.delete', $prodi->kd_prodi );

                $nestedData['kd_prodi'] = $prodi->kd_prodi;
                $nestedData['nama_fakultas'] = $prodi->fakultas->nama_fakultas;
                $nestedData['nama_prodi'] = $prodi->nama_prodi;
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
