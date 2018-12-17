@extends("layouts.app")

@section('title')
    Edit Prodi
@endsection

@section('content')
    <div class="container" id="prodi-edit">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Prodi {{ $prodi->nama_prodi }} </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('admin_prodi.update', $prodi->kd_prodi) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="kd_fakultas" class="col-md-4 control-label">Fakultas</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="kd_fakultas">
                                        @foreach ( $allFakultas as $fakultas )
                                            @if ( $prodi->kd_fakultas == $fakultas->kd_fakultas )
                                                {{ $selected = "selected='selected'" }}
                                            @else
                                                {{ $selected = "" }}
                                            @endif
                                            <option value="{{ $fakultas->kd_fakultas }}" {{ $selected }}> 
                                                {{ $fakultas->nama_fakultas }} 
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('kd_fakultas'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('kd_fakultas') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="kd_prodi" class="col-md-4 control-label">Kode Prodi</label>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" name="kd_prodi" value="{{ ( (string) $prodi->kd_prodi)[1] }}">

                                    @if ($errors->has('kd_prodi'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('kd_prodi') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nama_prodi" class="col-md-4 control-label">Nama Prodi</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="nama_prodi" value="{{ $prodi->nama_prodi }}" placeholder="Enter Nama Prodi">

                                    @if ($errors->has('nama_prodi'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nama_prodi') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin_prodi.index') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
@endsection