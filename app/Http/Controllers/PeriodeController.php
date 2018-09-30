<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Periode;
Use Exception;

class PeriodeController extends Controller
{
    public function __construct() {
        $this->middleware('auth:dosen');
    }

    public function index() {
        return view('kaprodi.periode.index');
    }
    
    public function create() {
        return view('kaprodi.periode.create');
    }

    public function edit($id) {
        try {
            $periode = Periode::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'periode.index' )
                ->with('error', "Failed to view Periode with ID {$id}");
        }

        return view( 'kaprodi.periode.edit')
            ->with( 'periode', $periode );
    }

    public function store( Request $request ) {
        $this->validate($request, [
            'thn_ajaran'   => 'required',
            'semester'    => 'required', 
        ]);

        // Convert input to proper timestamp
        $tahun = $request->input('thn_ajaran');
        $tahun = '1/1/' . $tahun;
        $thn_ajaran = strtotime($tahun);
        
        $periode = new Periode();
        $periode->thn_ajaran = $thn_ajaran;
        $periode->semester = $request->input('semester');
        $periode->save();

        $request->session()->flash(
            'success', "periode {$periode->nama_periode} successfully added!"
        );
        return redirect()->route( 'periode.index' );
    }

    public function update($id, Request $request ) {
        try {
            $periode = Periode::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update periode with kd_periode {$id}!"
            );
            return redirect()->route( 'periode.index' );
        }

        $this->validate($request, [
            'thn_ajaran'   => 'required',
            'semester'    => 'required',
        ]);

        // Convert input to proper timestamp
        $tahun = $request->input('thn_ajaran');
        $tahun = '1/1/' . $tahun;
        $thn_ajaran = strtotime($tahun);

        $periode->thn_ajaran = $thn_ajaran;
        $periode->semester = $request->input('semester');
        $periode->save();

        $request->session()->flash(
            'success', "Periode with ID $periode->id successfully updated!"
        );
        return redirect()->route( 'periode.index' );
    }

    public function delete($id, Request $request) {
        try {
            $periode = Periode::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete periode with kd_periode {$id}!"
            );
            return redirect()->route( 'periode.index' );
        }

        $current_periode_nama_periode = $periode->nama_periode;
        $periode->delete();

        $request->session()->flash(
            'success', "periode {$current_periode_nama_periode} successfully deleted!"
        );
        return redirect()->route( 'periode.index' );
    }

    // get all periode for Datatable
    public function all( Request $request ) {
        $columns = array(
            0   => 'id', 
            1   => 'thn_ajaran',
            2   => 'semester',
            3   => 'id',
        );

        $totalData = Periode::count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $periodes = Periode::offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $periodes = Periode::where('semester', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Periode::where('semester', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($periodes)) {
            foreach ($periodes as $periode) {
                $edit = route( 'periode.edit', $periode->id );
                $delete =  route( 'periode.delete', $periode->id );

                $thn_ajaran = intval(date('Y', $periode->thn_ajaran));
                $thn_ajaran = $thn_ajaran . "/" . ($thn_ajaran+1);

                $nestedData['id'] = $periode->id;
                $nestedData['thn_ajaran'] = $thn_ajaran;
                $nestedData['semester'] = ucfirst($periode->semester);
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
