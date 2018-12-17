<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dosen;
use App\Prodi;
use Exception;

class AdminDosenController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $allProdi = Prodi::all();

        return view( 'admin.dosen.index', [
            'allProdi'  => $allProdi
        ]);
    }

    public function create() {
        $allProdi = Prodi::all();

        return view('admin.dosen.create', [
            'allProdi'  => $allProdi
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kd_prodi'  => 'required',
            'nik'       => 'required|string|size:7|unique:dosen',
            'nama'      => 'required|string',
            'email'     => 'required|string|email',
            'no_tlpn'   => 'required',
            'password'  => 'required|string|confirmed', 
        ]);

        $dosen = new Dosen();
        $dosen->kd_prodi = $request->input('kd_prodi');
        $dosen->nik = $request->input('nik');
        $dosen->nama = $request->input('nama');
        $dosen->email = $request->input('email');
        $dosen->no_tlpn = $request->input('no_tlpn');
        $dosen->jabatan = $request->input('jabatan');
        $dosen->password = bcrypt($request->input('password'));
        $dosen->save();
    
        $request->session()->flash(
            'success', "Dosen {$dosen->nama} successfully created!"
        );
        return redirect()->route( 'admin_dosen.index' );
    }

    public function edit($nik) {
        try {
            $dosen = Dosen::findOrFail($nik);
        } catch ( Exception $e ) {
            return redirect()->route( 'admin_dosen.index' )
                ->with('error', "Failed to view dosen with nik {$nik}");
        }

        $kaprodi = Dosen::where('kd_prodi', $dosen->kd_prodi)
        ->where('jabatan', 1)
        ->first();

        if ( empty($kaprodi) ) {
            $jabatan[] = array( "value" => 1, "label" => "kaprodi" );
        }

        $jabatan[] = array( "value" => 2, "label" => "dosen" );
        //$jabatan[] = array( "value" => 3, "label" => "guest" );

        return view( 'admin.dosen.edit', [
            'jabatan'   => $jabatan
        ])->with( 'dosen', $dosen );
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
            'jabatan' => 'required',
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
        $dosen->delete();

        $request->session()->flash(
            'success', "Dosen {$nama_dosen} successfully deleted!"
        );
        return redirect()->route( 'admin_dosen.index' );
    }

    // get all fakultas for Datatable
    public function all( Request $request ) {
        $kd_prodi = $request->input('kd_prodi');

        $columns = array(
            0   => 'nik', 
            1   => 'nama',
            1   => 'jabatan',
            2   => 'nik',
        );

        $totalData = Dosen::where('kd_prodi', $kd_prodi)->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $dosens = Dosen::where('kd_prodi', $kd_prodi)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $dosens = Dosen::where('kd_prodi', $kd_prodi)
            ->orWhere('nik','LIKE',"%{$search}%")
            ->orWhere('nama', 'LIKE',"%{$search}%")
            ->orWhere('jabatan', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Dosen::where('kd_prodi', $kd_prodi)
            ->orWhere('nik','LIKE',"%{$search}%")
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

    public function checkKaprodi( Request $request ) {
        $kaprodi = Dosen::where('kd_prodi', $request->input('kd_prodi'))
        ->where('jabatan', 1)
        ->first();

        if ( empty($kaprodi) ) {
            $jabatan[] = array( "value" => 1, "label" => "kaprodi" );
        }

        $jabatan[] = array( "value" => 2, "label" => "dosen" );
        return $jabatan;
    }
}
