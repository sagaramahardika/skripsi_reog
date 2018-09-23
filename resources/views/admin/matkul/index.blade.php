@extends("layouts.app")

@section('title')
    Mata Kuliah
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Mata Kuliah</div>

                    <div class="panel-body">
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

                        <form action="{{ route('matkul.import') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <input type="file" name="import_file" />
                            <button type="submit" class="btn btn-primary">Import</button>
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