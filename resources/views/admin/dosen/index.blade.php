@extends("layouts.app")

@section('title')
    Dosen
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
@endsection

@section('content')
    <div class="container" id="dosen-index">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Dosen
                        <select id="kd_prodi">
                            <option>- Choose Prodi -</option>
                            @foreach ( $allProdi as $prodi )
                                <option value="{{ $prodi->kd_prodi }}"> {{ $prodi->nama_prodi }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="panel-body" id="dosen-data" style="visibility:hidden">
                        @if( Session::has('error') )
                            <div class="alert alert-danger">
                                <p> {{ Session::get('error') }} </p>
                            </div>
                        @elseif ( Session::has('success') )
                            <div class="alert alert-success">
                                <p> {{ Session::get('success') }} </p>
                            </div>
                        @endif

                        <table id="admin-dosen" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Options</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endsection