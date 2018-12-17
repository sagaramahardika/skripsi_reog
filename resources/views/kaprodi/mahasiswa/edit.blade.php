@extends('layouts.app')

@section('title')
    Edit Mahasiswa
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Mahasiswa {{ $mahasiswa->nama }}</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('mahasiswa.update', $mahasiswa->nim ) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" value="{{ Session::token() }}" name="_token" />

                        <div class="form-group{{ $errors->has('nim') ? ' has-error' : '' }}">
                            <label for="nim" class="col-md-4 control-label">NIM</label>

                            <div class="col-md-2">
                                <input id="nim" type="text" class="form-control" name="nim" value="{{ $mahasiswa->nim }}" disabled>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                            <label for="nama" class="col-md-4 control-label">Nama</label>

                            <div class="col-md-3">
                                <input id="nama" type="text" class="form-control" name="nama" value="{{ $mahasiswa->nama }}" required>

                                @if ($errors->has('nama'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('mahasiswa.index') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
