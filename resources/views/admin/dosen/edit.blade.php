@extends("layouts.app")

@section('title')
    Edit Dosen
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Dosen {{ $dosen->nama }}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('admin_dosen.update', $dosen->nik) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label class="col-md-4 control-label">NIK</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" value="{{ $dosen->nik }}" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" value="{{ $dosen->nama }}" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" value="{{ $dosen->email }}" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">No Tlpn</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" value="{{ $dosen->no_tlpn }}" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Jabatan</label>
                                <div class="col-md-2">
                                    <select class="form-control" id="jabatan" name="jabatan" placeholder="Enter Jabatan">
                                        @for( $i = 0; $i < count($jabatan); $i++ )
                                            <option value="{{ $jabatan[$i]['value'] }}" {{ $jabatan[$i]['label'] == $dosen->jabatan }}>
                                                {{ ucfirst($jabatan[$i]['label']) }}
                                            </option>
                                        @endfor
                                    </select>

                                    @if ($errors->has('jabatan'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('jabatan') }}</strong>
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