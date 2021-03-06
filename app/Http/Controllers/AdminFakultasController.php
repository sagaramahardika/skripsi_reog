<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Fakultas;
Use Exception;
use Validator;

class AdminFakultasController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        return view( 'admin.fakultas.index' );
    }

    public function create() {
        return view( 'admin.fakultas.create' );
    }

    public function edit($kd_fakultas) {
        try {
            $fakultas = Fakultas::findOrFail($kd_fakultas);
        } catch ( Exception $e ) {
            return redirect()->route( 'admin_fakultas.index' )
                ->with('error', "Failed to view Fakultas with kode fakultas {$kd_fakultas}");
        }

        return view( 'admin.fakultas.edit' )
            ->with( 'fakultas', $fakultas );
    }

    public function store( Request $request ) {
        $this->validate($request, [
            'kd_fakultas'   => 'required|digits:1|unique:fakultas',
            'nama_fakultas' => 'required|string',
        ]);

        $fakultas = new Fakultas();
        $fakultas->kd_fakultas = $request->input('kd_fakultas');
        $fakultas->nama_fakultas = $request->input('nama_fakultas');
        $fakultas->save();

        $request->session()->flash(
            'success', "fakultas {$fakultas->nama_fakultas} successfully added!"
        );
        return redirect()->route( 'admin_fakultas.index' );
    }

    public function update($kd_fakultas, Request $request ) {
        try {
            $fakultas = Fakultas::findOrFail($kd_fakultas);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update Fakultas with kode fakultas {$kd_fakultas}!"
            );
            return redirect()->route( 'admin_fakultas.index' );
        }

        $data['kd_fakultas'] = $request->input('kd_fakultas');
        $data['nama_fakultas'] = $request->input('nama_fakultas');

        Validator::make($data, [
            'kd_fakultas'   => [
                'required',
                'digits:1',
                Rule::unique('fakultas')->ignore($fakultas->kd_fakultas, 'kd_fakultas'),
            ],
            'nama_fakultas' => [
                'required',
                'string',
            ],
        ]);

        $current_nama_fakultas = $fakultas->nama_fakultas;
        $fakultas->kd_fakultas = $data['kd_fakultas'];
        $fakultas->nama_fakultas = $data['nama_fakultas'];
        $fakultas->save();

        $request->session()->flash(
            'success', "fakultas {$current_nama_fakultas} successfully updated!"
        );
        return redirect()->route( 'admin_fakultas.index' );
    }

    public function delete($kd_fakultas, Request $request) {
        try {
            $fakultas = Fakultas::findOrFail($kd_fakultas);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete Fakultas with kd_fakultas {$kd_fakultas}!"
            );
            return redirect()->route( 'admin_fakultas.index' );
        }

        $current_nama_fakultas = $fakultas->nama_fakultas;
        $fakultas->delete();

        $request->session()->flash(
            'success', "Fakultas {$current_nama_fakultas} successfully deleted!"
        );
        return redirect()->route( 'admin_fakultas.index' );
    }

    // get all fakultas for Datatable
    public function all( Request $request ) {
        $columns = array(
            0   => 'kd_fakultas', 
            1   => 'nama_fakultas',
            2   => 'kd_fakultas',
        );

        $totalData = Fakultas::count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $fakultass = Fakultas::offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $fakultass = Fakultas::where('kd_fakultas','LIKE',"%{$search}%")
            ->orWhere('nama_fakultas', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Fakultas::where('kd_fakultas','LIKE',"%{$search}%")
            ->orWhere('nama_fakultas', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($fakultass)) {
            foreach ($fakultass as $fakultas) {
                $edit = route( 'admin_fakultas.edit', $fakultas->kd_fakultas );
                $delete =  route( 'admin_fakultas.delete', $fakultas->kd_fakultas );

                $nestedData['kd_fakultas'] = $fakultas->kd_fakultas;
                $nestedData['nama_fakultas'] = $fakultas->nama_fakultas;
                $nestedData['options'] = "
                    <a href='{$edit}' title='EDIT' class='btn btn-info' > Edit </a>
                    <form action='{$delete}' method='POST' style='display:inline-block'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' value='" . $request->session()->token() . "' name='_token' />
                        <button class='btn btn-danger'> Delete </button>
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
