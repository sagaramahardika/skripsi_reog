@extends("layouts.app")

@section('title')
    Mata Kuliah
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
@endsection

@section('content')
    <div class="container" id="matkul-index">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Mata Kuliah
                        <select id="kd_prodi">
                            <option>- Choose Prodi -</option>
                            @foreach ( $allProdi as $prodi )
                                <option value="{{ $prodi->kd_prodi }}"> {{ $prodi->nama_prodi }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="panel-body" id="matkul-data" style="visibility:hidden">
                        @if( Session::has('error') )
                            <div class="alert alert-danger">
                                <p> {{ Session::get('error') }} </p>
                            </div>
                        @elseif ( $errors->any() )
                            <div class="alert alert-danger">
                                {{ Session::get('additional_error') }}
                                <ul>
                                    @foreach ( $errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif ( Session::has('success') )
                            <div class="alert alert-success">
                                <p> {{ Session::get('success') }} </p>
                            </div>
                        @endif

                        <form action="{{ route('matkul.import') }}" method="POST" enctype="multipart/form-data" style="padding-bottom:10px">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />
                            <input type="hidden" id="kd_prodi_form" name="kd_prodi" />

                            <div class="form-group mb-2">
                                <label for="import_file">Import Excel Matakuliah</label>
                                <input type="file" class="form-control-file" name="import_file">
                            </div>
                            <button type="submit" class="btn-primary">Import</button>
                        </form>

                        <table id="matkul" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <th>Kode Matakuliah</th>
                                <th>Nama Matakuliah</th>
                                <th>SKS</th>
                                <th>Harga</th>
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