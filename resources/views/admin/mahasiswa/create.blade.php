@extends('layouts.app')

@section('title')
    Tambah Mahasiswa
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tambah Mahasiswa</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('mahasiswa.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Prodi</label>
                            <div class="col-md-3">
                                <select class="form-control" id="kd_prodi" name="kd_prodi" placeholder="Enter Prodi">
                                    @foreach ( $allProdi as $prodi )
                                        <option value="{{ $prodi->kd_prodi }}"> {{ $prodi->nama_prodi }} </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('kd_prodi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kd_prodi') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nim') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">NIM</label>

                            <div class="col-md-2">
                                <input id="nim" type="text" class="form-control" name="nim" value="{{ old('nim') }}" required>

                                @if ($errors->has('nim'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nim') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                            <label for="nama" class="col-md-4 control-label">Nama</label>

                            <div class="col-md-3">
                                <input id="nama" type="text" class="form-control" name="nama" value="{{ old('nama') }}" required>

                                @if ($errors->has('nama'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-3">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-3">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
