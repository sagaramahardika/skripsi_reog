@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <p>You are logged in!</p>     
                    @if ( !empty($forgottenClass) )
                        <p>List Kelas yang lupa ditutup : </p>
                        @foreach( $forgottenClass as $kelas )
                            <p><a href="{{ route('rencana.pencatatan', $kelas['id_rencana']) }}">{{ $kelas['matkul'] . " " . $kelas['grup'] . " pertemuan " . $kelas['pertemuan'] }}</a></p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
