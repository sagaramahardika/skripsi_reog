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
                        <form class="form-horizontal" action="{{ route('dosen.update', $dosen->nik) }}" method="POST">
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
                                    <input type="text" name="nama" class="form-control" value="{{ $dosen->nama }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <div class="col-md-4">
                                    <input type="text" name="email" class="form-control" value="{{ $dosen->email }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">No Tlpn</label>
                                <div class="col-md-2">
                                    <input type="text" name="no_tlpn" class="form-control" value="{{ $dosen->no_tlpn }}">
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('dosen.index') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection