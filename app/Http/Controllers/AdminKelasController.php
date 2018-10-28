<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Periode;
use App\Prodi;
use App\Rencana;
use App\SubMatkul;
Use Exception;

class AdminKelasController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }    

    public function index() {
        $allProdi = Prodi::all();

        return view( 'admin.kelas.index', [
            'allProdi'  => $allProdi
        ]);
    }

    public function create_session($id) {
        try {
            $submatkul = SubMatkul::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'mengajar.index' )
                ->with('error', "Failed to view Sub Matkul with ID {$id}");
        }

        return view( 'admin.kelas.create_session' )->with( 'submatkul', $submatkul );
    }

    public function store_session( Request $request ) {
        $this->validate($request, [
            'id_sub_matkul' => 'required',
            //'pertemuan'     => 'required',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
        ]);

        //$total_pertemuan = $request->input('pertemuan');
        $id_sub_matkul = $request->input('id_sub_matkul');
        $waktu_mulai = strtotime( $request->input('waktu_mulai') );
        $waktu_selesai = strtotime( $request->input('waktu_selesai') );

        $max_pertemuan = Rencana::where('id_sub_matkul', $id_sub_matkul)->max('pertemuan');
        if ( empty($max_pertemuan) ) {
            $max_pertemuan = 0;
        }

        for( $i = 1; $i <= 14; $i++ ) {
            $rencana = new Rencana();
            $rencana->id_sub_matkul = $id_sub_matkul;
            $rencana->pertemuan = $max_pertemuan + $i;
            if ( $i > 7 ) {
                $rencana->waktu_mulai = $waktu_mulai + ( $i + 2 ) * 604800;
                $rencana->waktu_selesai = $waktu_selesai + ( $i + 2 ) * 604800;
            } else {
                $rencana->waktu_mulai = $waktu_mulai + $i * 604800;
                $rencana->waktu_selesai = $waktu_selesai + $i * 604800;
            }
            $rencana->save();
        }

        $request->session()->flash(
            'success', "Rencana successfully added!"
        );
        return redirect()->route( 'admin_kelas.index' );
    }

    public function all( Request $request ) {
        $kd_prodi = $request->input('kd_prodi');
        $latest_periode = Periode::max('id');

        $columns = array(
            0   => 'id', 
            1   => 'kd_matkul',
            2   => 'nama_matkul',
            3   => 'grup',
            4   => 'dosen',
            5   => 'id',
        );

        $totalData = SubMatkul::whereHas('matkul', function ($query) use ($kd_prodi) {
            $query->where('kd_prodi', $kd_prodi);
        })->where('id_periode', $latest_periode)->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $submatkuls = SubMatkul::whereHas('matkul', function ($query) use ($kd_prodi) {
                $query->where('kd_prodi', $kd_prodi);
            })->where('id_periode', $latest_periode)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $submatkuls = SubMatkul::whereHas('matkul', function ($query) use ($kd_prodi, $search) {
                $query->where('kd_prodi', $kd_prodi);
                $query->where('kd_matkul', 'LIKE', "%$search%");
            })->where('id_periode', $latest_periode)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = SubMatkul::whereHas('matkul', function ($query) use ($kd_prodi, $search) {
                $query->where('kd_prodi', $kd_prodi);
                $query->where('kd_matkul', 'LIKE', "%$search%");
            })->where('id_periode', $latest_periode)
            ->count();
        }

        $data = array();
        if(!empty($submatkuls)) {
            foreach ($submatkuls as $submatkul) {
                $add_session = route( 'admin_kelas.create_session', $submatkul->id );

                if ( !$submatkul->rencana->isEmpty() ) {
                    $options = "";
                } else {
                    $options = "<a href='{$add_session}' title='Create Pertemuan' class='btn btn-info' > Create Pertemuan </a>";
                }

                if ( !$submatkul->pengajar->isEmpty() ) {
                    foreach( $submatkul->pengajar as $pengajar ) {
                        $nestedData['kd_matkul'] = $submatkul->kd_matkul;
                        $nestedData['nama_matkul'] = $submatkul->matkul->nama_matkul;
                        $nestedData['grup'] = $submatkul->grup;
                        $nestedData['dosen'] = $pengajar->dosen->nama;
                        $nestedData['options'] = $options;

                        $data[] = $nestedData;    
                    }
                } else {
                    $nestedData['kd_matkul'] = $submatkul->kd_matkul;
                    $nestedData['nama_matkul'] = $submatkul->matkul->nama_matkul;
                    $nestedData['grup'] = $submatkul->grup;
                    $nestedData['dosen'] = '-';
                    $nestedData['options'] = $options;

                    $data[] = $nestedData;
                }

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
