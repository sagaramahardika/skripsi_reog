<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fakultas;
Use Exception;

class FakultasController extends Controller
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
            return redirect()->route( 'fakultas.index' )
                ->with('error', "Failed to view fakultas with kode fakultas {$kd_fakultas}");
        }

        return view( 'admin.fakultas.edit' )
            ->with( 'fakultas', $fakultas );
    }

    public function store( Request $request ) {
        $this->validate($request, [
            'nama'          => 'required|string', 
        ]);

        $fakultas = new Fakultas();
        $fakultas->kd_fakultas = $request->input('');
        $fakultas->nama = $request->input('nama');
        $fakultas->save();

        $request->session()->flash(
            'success', "fakultas {$fakultas->nama} successfully added!"
        );
        return redirect()->route( 'fakultas.index' );
    }

    public function update($kd_fakultas, Request $request ) {
        try {
            $fakultas = Fakultas::findOrFail($kd_fakultas);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update fakultas with kd_fakultas {$kd_fakultas}!"
            );
            return redirect()->route( 'fakultas.index' );
        }

        $this->validate($request, [
            'nama'      => 'required|alpha', 
        ]);

        $current_fakultas_nama = $fakultas->nama;
        $fakultas->nama = $request->input('nama');
        $fakultas->save();

        $request->session()->flash(
            'success', "fakultas {$current_fakultas_nama} successfully updated!"
        );
        return redirect()->route( 'fakultas.index' );
    }

    public function delete($kd_fakultas, Request $request) {
        try {
            $fakultas = Fakultas::findOrFail($kd_fakultas);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete fakultas with kd_fakultas {$kd_fakultas}!"
            );
            return redirect()->route( 'fakultas.index' );
        }

        $current_fakultas_nama = $fakultas->nama;
        $fakultas->delete();

        $request->session()->flash(
            'success', "fakultas {$current_fakultas_nama} successfully deleted!"
        );
        return redirect()->route( 'fakultas.index' );
    }

    // get all fakultas for Datatable
    public function all( Request $request ) {
        $columns = array(
            0   => 'kd_fakultas', 
            1   => 'nama',
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
            ->orWhere('nama', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Fakultas::where('kd_fakultas','LIKE',"%{$search}%")
            ->orWhere('nama', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($fakultass)) {
            foreach ($fakultass as $fakultas) {
                $edit = route( 'fakultas.edit', $fakultas->kd_fakultas );
                $delete =  route( 'fakultas.delete', $fakultas->kd_fakultas );

                $nestedData['kd_fakultas'] = $fakultas->kd_fakultas;
                $nestedData['nama'] = $fakultas->nama;
                $nestedData['options'] = "
                    <a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                    <form action='{$delete}' method='POST' style='display:inline-block'>
                        <input type='hidden' nama='_method' value='DELETE'>
                        <input type='hidden' value='" . $request->session()->token() . "' nama='_token' />
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
