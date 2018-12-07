<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SubMatkul;
use App\Periode;



class cobasaja extends Controller
{
    public function mencoba(){
       $latest_periode = Periode::max('id');
       $submatkuls = SubMatkul::where('id_periode', $latest_periode)->get();     
       
       return view ('coba',['submatkuls' => $submatkuls]);


        
    }
}
