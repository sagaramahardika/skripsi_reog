<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dosen;
use Exception;

class AdminDosenController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        return view( 'admin.dosen.index' );
    }

    public function edit($nik) {
        try {
            $dosen = Dosen::findOrFail($nik);
        } catch ( Exception $e ) {
            return redirect()->route( 'admin_dosen.index' )
                ->with('error', "Failed to view dosen with nik {$nik}");
        }

        return view( 'admin.dosen.edit' )
            ->with( 'dosen', $dosen );
    }

    public function update($nik, Request $request ) {
        try {
            $dosen = Dosen::findOrFail($nik);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update dosen with nik {$nik}!"
            );
            return redirect()->route( 'admin_dosen.index' );
        }

        $this->validate($request, [
            'jabatan' => 'required|check_kaprodi',
        ]);

        $nama_dosen = $dosen->nama;
        $dosen->jabatan = $request->input('jabatan');
        $dosen->save();

        $request->session()->flash(
            'success', "Dosen {$nama_dosen} successfully updated!"
        );
        return redirect()->route( 'admin_dosen.index' );
    }

    public function delete($nik, Request $request) {
        try {
            $dosen = Dosen::findOrFail($nik);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete dosen with nik {$nik}!"
            );
            return redirect()->route( 'admin_dosen.index' );
        }

        $nama_dosen = $dosen->nama;
        $fakultas->delete();

        $request->session()->flash(
            'success', "Dosen {$nama_dosen} successfully deleted!"
        );
        return redirect()->route( 'admin_dosen.index' );
    }

    // get all fakultas for Datatable
    public function all( Request $request ) {
        $columns = array(
            0   => 'nik', 
            1   => 'nama',
            1   => 'jabatan',
            2   => 'nik',
        );

        $totalData = Dosen::count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $dosens = Dosen::offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $dosens = Dosen::where('nik','LIKE',"%{$search}%")
            ->orWhere('nama', 'LIKE',"%{$search}%")
            ->orWhere('jabatan', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Dosen::where('nik','LIKE',"%{$search}%")
            ->orWhere('nama', 'LIKE',"%{$search}%")
            ->orWhere('jabatan', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($dosens)) {
            foreach ($dosens as $dosen) {
                $edit = route( 'admin_dosen.edit', $dosen->nik );
                $delete =  route( 'admin_dosen.delete', $dosen->nik );

                $nestedData['nik'] = $dosen->nik;
                $nestedData['nama'] = $dosen->nama;
                $nestedData['jabatan'] = ucfirst($dosen->jabatan);
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