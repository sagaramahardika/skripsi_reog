@extends("layouts.admin")

@section('title')
    Edit Dosen
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Dosen {{ $dosen->nama }}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('admin_dosen.update', $dosen->nik) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label class="col-md-4 control-label">NIK</label>
                                <label class="col-md-6 control-label">{{ $dosen->nik }}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama</label>
                                <label class="col-md-6 control-label">{{ $dosen->nama }}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <label class="col-md-6 control-label">{{ $dosen->email }}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">No Tlpn</label>
                                <label class="col-md-6 control-label">{{ $dosen->no_tlpn }}</label>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Jabatan</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="jabatan" name="jabatan" placeholder="Enter Jabatan">
                                        <option value="1" {{ ($dosen->jabatan == "kaprodi") ? "selected='selected'" : "" }} > 
                                            Kaprodi 
                                        </option>
                                        <option value="2" {{ ($dosen->jabatan == "dosen") ? "selected='selected'" : "" }} > 
                                            Dosen 
                                        </option>
                                        <option value="3" {{ ($dosen->jabatan == "guest") ? "selected='selected'" : "" }} > 
                                            Guest 
                                        </option>
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