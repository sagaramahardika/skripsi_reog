<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MataKuliah;
use App\Prodi;
Use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class MataKuliahController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $allProdi = Prodi::all();

        return view( 'admin.matkul.index', [
            'allProdi' => $allProdi,
        ]);
    }

    public function create() {
        $allProdi = Prodi::all();

        return view( 'admin.matkul.create', [
            'allProdi'  => $allProdi,
        ]);
    }

    public function edit($kd_matkul) {
        try {
            $allProdi = Prodi::all();
            $matkul = Matakuliah::findOrFail($kd_matkul);
        } catch ( Exception $e ) {
            return redirect()->route( 'matkul.index' )
                ->with('error', "Failed to view Mata Kuliah with kode matakuliah {$kd_matkul}");
        }

        return view( 'admin.matkul.edit', [
            'allProdi'  => $allProdi,
        ])->with( 'matkul', $matkul );
    }

    public function store( Request $request ) {
        $this->validate($request, [
            'kd_prodi'      => 'required',
            'kd_matkul'     => 'required|alpha_num|size:6|unique:matakuliah',
            'nama_matkul'   => 'required|string',
            'sks'           => 'required|digits_between:1,2',
            'harga'         => 'required|digits_between:1,2' 
        ]);

        $matkul = new Matakuliah();
        $matkul->kd_prodi = $request->input('kd_prodi');
        $matkul->kd_matkul = $request->input('kd_matkul');
        $matkul->nama_matkul = $request->input('nama_matkul');
        $matkul->sks = $request->input('sks');
        $matkul->harga = $request->input('harga');
        $matkul->save();

        $request->session()->flash(
            'success', "Mata Kuliah {$matkul->nama_matkul} successfully added!"
        );
        return redirect()->route( 'matkul.index' );
    }

    public function update($kd_matkul, Request $request ) {
        try {
            $matkul = Matakuliah::findOrFail($kd_matkul);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update Mata Kuliah with kode matakuliah {$kd_matkul}!"
            );
            return redirect()->route( 'matkul.index' );
        }

        $this->validate($request, [
            'kd_prodi'      => 'required',
            'kd_matkul'     => 'required|alpha_num|size:6',
            'nama_matkul'   => 'required|string',
            'sks'           => 'required|digits_between:1,2',
            'harga'         => 'required|digits_between:1,2' 
        ]);

        $current_matkul_nama_matkul = $matkul->nama_matkul;
        $matkul->kd_prodi = $request->input('kd_prodi');
        $matkul->kd_matkul = $request->input('kd_matkul');
        $matkul->nama_matkul = $request->input('nama_matkul');
        $matkul->sks = $request->input('sks');
        $matkul->harga = $request->input('harga');
        $matkul->save();

        $request->session()->flash(
            'success', "Mata Kuliah {$current_matkul_nama_matkul} successfully updated!"
        );
        return redirect()->route( 'matkul.index' );
    }

    public function delete($kd_matkul, Request $request) {
        try {
            $matkul = Matakuliah::findOrFail($kd_matkul);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete matakuliah with kd_matakuliah {$kd_kd_matkul}!"
            );
            return redirect()->route( 'matkul.index' );
        }

        $current_matkul_nama_matkul = $matkul->nama_matkul;
        $matakuliah->delete();

        $request->session()->flash(
            'success', "Mata Kuliah {$current_matkul_nama_matkul} successfully deleted!"
        );
        return redirect()->route( 'matkul.index' );
    }

    // get all matakuliah for Datatable
    public function all( Request $request ) {
        $kd_prodi = $request->input('kd_prodi');

        $columns = array(
            0   => 'kd_matkul', 
            1   => 'nama_matkul',
            2   => 'sks',
            3   => 'harga',
            4   => 'kd_matkul',
        );

        $totalData = Matakuliah::where('kd_prodi', $kd_prodi)->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $matakuliahs = Matakuliah::where('kd_prodi', $kd_prodi)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $matakuliahs = Matakuliah::where('kd_prodi', $kd_prodi)
            ->where('kd_matkul','LIKE',"%{$search}%")
            ->orWhere('nama_matkul', 'LIKE',"%{$search}%")
            ->orWhere('sks', 'LIKE',"%{$search}%")
            ->orWhere('harga', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Matakuliah::where('kd_prodi', $kd_prodi)
            ->where('kd_matkul','LIKE',"%{$search}%")
            ->orWhere('nama_matkul', 'LIKE',"%{$search}%")
            ->orWhere('sks', 'LIKE',"%{$search}%")
            ->orWhere('harga', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($matakuliahs)) {
            foreach ($matakuliahs as $matkul) {
                $edit = route( 'matkul.edit', $matkul->kd_matkul );
                $delete =  route( 'matkul.delete', $matkul->kd_matkul );

                $nestedData['kd_matkul'] = $matkul->kd_matkul;
                $nestedData['nama_matkul'] = $matkul->nama_matkul;
                $nestedData['sks'] = $matkul->sks;
                $nestedData['harga'] = $matkul->harga;
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

    function import(Request $request) {
        $this->validate($request, [
            'kd_prodi'         => 'required',
            'import_file'      => 'required', 
        ]);

        if ( $request->hasFile('import_file') ) {
            $path = $request->file('import_file')->getRealPath();
            Excel::load( $path, function($reader) use($request) {
                foreach ($reader->toArray() as $index => $row) {
                    $validator = Validator::make(
                        array(
                            'kd_matkul'     => $row['kd_matkul'],
                            'nama_matkul'   => $row['nama_matkul'],
                            'sks'           => $row['sks'],
                            'harga'         => $row['harga'],
                        ),
                        array(
                            'kd_matkul'     => 'required|alpha_num|size:6',
                            'nama_matkul'   => 'required|string',
                            'sks'           => 'required|digits_between:1,2',
                            'harga'         => 'required|digits_between:1,2',
                        )
                    );

                    if ( $validator->fails() ) {
                        $line_error_excel = $index + 2;
                        $additional_error = "Line $line_error_excel has an error";
                        
                        return redirect()->route( 'matkul.index' )
                        ->with('additional_error', $additional_error)
                        ->withErrors( $validator );
                    } else {
                        $matkul = Matakuliah::find($row['kd_matkul']);
                        if ( empty($matkul) ) {
                            $matkul = new Matakuliah();
                        }
                        $matkul->kd_prodi = $request->input('kd_prodi');
                        $matkul->kd_matkul = $row['kd_matkul'];
                        $matkul->nama_matkul = $row['nama_matkul'];
                        $matkul->sks = $row['sks'];
                        $matkul->harga = $row['harga'];
                        $matkul->save();
                    }           
                }
                $request->session()->flash(
                    'success', "Mata Kuliah successfully imported!"
                );
            });

        } else {
            $request->session()->flash(
                'error', "Mata Kuliah failed to import"
            );
        }

        
        return redirect()->route( 'matkul.index' );
    }
}
