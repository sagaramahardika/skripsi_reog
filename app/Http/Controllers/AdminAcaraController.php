<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Acara;
Use Exception;
use Validator;

class AdminAcaraController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        return view( 'admin.acara.index' );
    }
    
    public function create() {
        return view( 'admin.acara.create' );
    }

    public function edit($id) {
        try {
            $acara = Acara::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'admin_acara.index' )
                ->with('error', "Failed to view Acara with id {$id}");
        }

        return view( 'admin.acara.edit' )->with( 'acara', $acara );
    }

    public function store( Request $request ) {
        $acara = new Acara();
        $acara->nama_acara = $request->input('nama_acara');
        $acara->waktu_mulai = strtotime( $request->input('waktu_mulai') );
        $acara->waktu_selesai = strtotime( $request->input('waktu_selesai') );
        $acara->save();

        $request->session()->flash(
            'success', "Acara {$acara->nama_acara} successfully added!"
        );
        return redirect()->route( 'admin_acara.index' );
    }

    public function update($id, Request $request ) {
        try {
            $acara = Acara::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update Acara with id {$id}!"
            );
            return redirect()->route( 'admin_acara.index' );
        }

        $current_acara_nama_acara = $acara->nama_acara;
        $acara->nama_acara = $request->input('nama_acara');
        $acara->waktu_mulai = strtotime( $request->input('waktu_mulai') );
        $acara->waktu_selesai = strtotime( $request->input('waktu_selesai') );
        $acara->save();

        $request->session()->flash(
            'success', "Acara {$current_acara_nama_acara} successfully updated!"
        );
        return redirect()->route( 'admin_acara.index' );
    }

    public function delete($id, Request $request) {
        try {
            $acara = Acara::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete Acara with id {$id}!"
            );
            return redirect()->route( 'admin_acara.index' );
        }

        $current_acara_nama_acara = $acara->nama_acara;
        $acara->delete();

        $request->session()->flash(
            'success', "acara {$current_acara_nama_acara} successfully deleted!"
        );
        return redirect()->route( 'admin_acara.index' );
    }

    // get all acara for Datatable
    public function all( Request $request ) {
        $columns = array(
            0   => 'nama_acara', 
            1   => 'waktu_mulai',
            2   => 'waktu_selesai',
            3   => 'id',
        );

        $totalData = Acara::count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $acaras = Acara::offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $acaras = acara::where('nama_acara','LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = acara::where('nama_acara', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($acaras)) {
            foreach ($acaras as $acara) {
                $edit = route( 'admin_acara.edit', $acara->id );
                $delete =  route( 'admin_acara.delete', $acara->id );

                $nestedData['nama_acara'] = $acara->nama_acara;
                $nestedData['waktu_mulai'] = date('d/m/Y H:i', $acara->waktu_mulai );
                $nestedData['waktu_selesai'] = date('d/m/Y H:i', $acara->waktu_selesai );
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
