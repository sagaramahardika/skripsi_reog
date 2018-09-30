@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Profile {{ Auth::user()->nama }}</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('dosen.update', $dosen->nik) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" value="{{ Session::token() }}" name="_token" />

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Prodi</label>
                            <div class="col-md-6">
                                <select class="form-control" id="kd_prodi" name="kd_prodi" placeholder="Enter Prodi">
                                    @foreach ( $allProdi as $prodi )
                                        @if ( $prodi->kd_prodi == $dosen->kd_prodi )
                                            {{ $selected = "selected='selected'" }}
                                        @else
                                            {{ $selected = "" }}
                                        @endif
                                        <option value="{{ $prodi->kd_prodi }}" {{ $selected }} > 
                                            {{ $prodi->nama_prodi }} 
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('prodi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prodi') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nik') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">NIK</label>

                            <div class="col-md-6">
                                <input id="nik" type="text" class="form-control" name="nik" value="{{ $dosen->nik }}" required>

                                @if ($errors->has('nik'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nik') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                            <label for="nama" class="col-md-4 control-label">Nama</label>

                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control" name="nama" value="{{ $dosen->nama }}" required>

                                @if ($errors->has('nama'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $dosen->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('no_tlpn') ? ' has-error' : '' }}">
                            <label for="no_tlpn" class="col-md-4 control-label">No Telephone</label>

                            <div class="col-md-6">
                                <input id="no_tlpn" type="no_tlpn" class="form-control" name="no_tlpn" value="{{ $dosen->no_tlpn }}" required>

                                @if ($errors->has('no_tlpn'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('no_tlpn') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
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

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
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
