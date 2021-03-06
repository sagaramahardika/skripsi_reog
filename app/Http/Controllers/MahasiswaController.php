<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mahasiswa;
use App\Prodi;
use Auth;
Use Exception;

class MahasiswaController extends Controller
{
    public function __construct() {
        $this->middleware('auth:dosen');
    }

    public function index() {
        return view('kaprodi.mahasiswa.index');
    }
    
    public function create() {
        return view('kaprodi.mahasiswa.create');
    }

    public function edit($nim) {
        try {
            $mahasiswa = Mahasiswa::findOrFail($nim);
        } catch ( Exception $e ) {
            return redirect()->route( 'mahasiswa.index' )
                ->with('error', "Failed to view Mahasiswa with NIM {$nim}");
        }

        $allProdi = Prodi::all();

        return view( 'kaprodi.mahasiswa.edit')->with( 'mahasiswa', $mahasiswa );
    }

    public function store( Request $request ) {
        $kaprodi = Auth::guard('dosen')->user();
        $this->validate($request, [
            'nim'           => 'required|digits:8|unique:mahasiswa',
            'nama'          => 'required|string',
            'password'      => 'required|string|confirmed',
        ]);

        $mahasiswa = new Mahasiswa();
        $mahasiswa->kd_prodi = $kaprodi->kd_prodi;
        $mahasiswa->nim = $request->input('nim');
        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->password = bcrypt($request->input('password'));
        $mahasiswa->save();

        $request->session()->flash(
            'success', "mahasiswa {$mahasiswa->nama} successfully added!"
        );
        return redirect()->route( 'mahasiswa.index' );
    }

    public function update($nim, Request $request ) {
        try {
            $mahasiswa = Mahasiswa::findOrFail($nim);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update mahasiswa with nim {$nim}!"
            );
            return redirect()->route( 'mahasiswa.index' );
        }

        $this->validate($request, [
            'nama'          => 'required|string',
        ]);

        $current_mahasiswa_nama = $mahasiswa->nama;
        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->save();

        $request->session()->flash(
            'success', "Mahasiswa {$current_mahasiswa_nama} successfully updated!"
        );
        return redirect()->route( 'mahasiswa.index' );
    }

    public function delete($nim, Request $request) {
        try {
            $mahasiswa = Mahasiswa::findOrFail($nim);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete Mahasiswa with nim {$nim}!"
            );
            return redirect()->route( 'mahasiswa.index' );
        }

        $current_mahasiswa_nama = $mahasiswa->nama;
        $mahasiswa->delete();

        $request->session()->flash(
            'success', "Mahasiswa {$current_mahasiswa_nama} successfully deleted!"
        );
        return redirect()->route( 'mahasiswa.index' );
    }

    // get all mahasiswa for Datatable
    public function all( Request $request ) {
        $kaprodi = Auth::guard('dosen')->user();
        $kd_prodi = $kaprodi->kd_prodi;

        $columns = array(
            0   => 'nim', 
            1   => 'nama',
            3   => 'nim',
        );

        $totalData = Mahasiswa::where('kd_prodi', $kd_prodi)->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $mahasiswas = Mahasiswa::where('kd_prodi', $kd_prodi)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $mahasiswas = Mahasiswa::where('kd_prodi', $kd_prodi)
            ->where('nim','LIKE',"%{$search}%")
            ->orWhere('nama', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Mahasiswa::where('kd_prodi', $kd_prodi)
            ->where('nim','LIKE',"%{$search}%")
            ->orWhere('nama', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($mahasiswas)) {
            foreach ($mahasiswas as $mahasiswa) {
                $edit = route( 'mahasiswa.edit', $mahasiswa->nim );
                $delete =  route( 'mahasiswa.delete', $mahasiswa->nim );

                $nestedData['nim'] = $mahasiswa->nim;
                $nestedData['nama'] = $mahasiswa->nama;
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
