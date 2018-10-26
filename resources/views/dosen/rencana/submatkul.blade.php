@extends("layouts.app")

@section('title')
    RPS
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">RPS {{ $submatkul->matkul->nama_matkul . " (" . $submatkul->grup . ")" }}</div>

                    <div class="panel-body">
                        @if( Session::has('error') )
                            <div class="alert alert-danger">
                                <p> {{ Session::get('error') }} </p>
                            </div>
                        @elseif ( Session::has('success') )
                            <div class="alert alert-success">
                                <p> {{ Session::get('success') }} </p>
                            </div>
                        @endif

                        <div class="row">
                            @php
                                $thn_ajaran = intval(date('Y', $submatkul->periode->thn_ajaran));
                                $thn_ajaran = $thn_ajaran . "/" . ($thn_ajaran+1);
                            @endphp

                            <div class="col-md-8">{{ $submatkul->matkul->kd_matkul . "-" . $submatkul->matkul->nama_matkul }}</div>
                            <div class="col-md-4 text-right">{{ "Periode : " . $thn_ajaran . " " . ucfirst($submatkul->periode->semester) }}</div>
                        </div>

                        <p style="margin: 3px 0px">{{ $submatkul->matkul->sks . " SKS" }}</p>
                        <p style="margin: 3px 0px">{{ "Grup-" . $submatkul->grup }}</p>

                        <input type="hidden" id="id_sub_matkul" value="{{ $submatkul->id }}">

                        <table id="rencana" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <th>Pertemuan</th>
                                <th>Rencana Pembelajaran Semester</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Keterangan</th>
                                <th>Options</th>
                            </thead>
                        </table>
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dosen.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endsection