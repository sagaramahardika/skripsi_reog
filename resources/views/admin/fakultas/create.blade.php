@extends("layouts.app")

@section('title')
    Tambah Fakultas
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Fakultas</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('fakultas.store') }}" method="POST">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="kd_fakultas" class="col-md-4 control-label">Kode Fakultas</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="kd_fakultas" placeholder="Enter Kode Fakultas">

                                    @if ($errors->has('kd_fakultas'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('kd_fakultas') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nama_fakultas" class="col-md-4 control-label">Nama Fakultas</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nama_fakultas" placeholder="Enter Nama Fakultas">
                                
                                    @if ($errors->has('nama_fakultas'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nama_fakultas') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection