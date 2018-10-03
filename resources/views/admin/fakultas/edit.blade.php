@extends("layouts.app")

@section('title')
    Edit Fakultas
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Fakultas {{ $fakultas->nama_fakultas }} </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('fakultas.update', $fakultas->kd_fakultas) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="kd_fakultas" class="col-md-4 control-label">Kode Fakultas</label>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" name="kd_fakultas" value="{{ $fakultas->kd_fakultas }}">

                                    @if ($errors->has('kd_fakultas'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('kd_fakultas') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nama_fakultas" class="col-md-4 control-label">Nama Fakultas</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="nama_fakultas" value="{{ $fakultas->nama_fakultas }}" placeholder="Enter Nama Fakultas">
                                
                                    @if ($errors->has('nama_fakultas'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nama_fakultas') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('fakultas.index') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection