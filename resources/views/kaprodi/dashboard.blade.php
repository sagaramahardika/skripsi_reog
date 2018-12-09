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
                        @foreach( $forgottenClass as $kelas )
                            <p><a href="{{ route('rencana.pencatatan', $kelas->id_rencana) }}">Test</a></p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
