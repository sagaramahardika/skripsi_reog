@extends("layouts.app")

@section('title')
    Rencana
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Pengajar</div>
                    
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

                        <form class="form-horizontal" action="{{ route('submatkul.dosen_store') }}" method="POST">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />
                            <input type="hidden" value="{{ $submatkul->id }}" name="id_sub_matkul" id="id_sub_matkul" />

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Dosen</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="nik" name="nik" placeholder="Enter Dosen">
                                        @foreach ( $allDosen as $dosen )
                                            <option value="{{ $dosen->nik }}"> {{ $dosen->nama }} </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('nik'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nik') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                        <table id="mengajar" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <th>NIK</th>
                                <th>Nama Dosen</th>
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
    <script src="{{ asset('js/kaprodi.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endsection