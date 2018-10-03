@extends("layouts.app")

@section('title')
    Tambah Mata Kuliah
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Mata Kuliah</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('matkul.store') }}" method="POST">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Prodi</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="kd_prodi">
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

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Kode Matakuliah</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="kd_matkul">
                                    
                                    @if ($errors->has('kd_matkul'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('kd_matkul') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama Mata Kuliah</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="nama_matkul" placeholder="Enter Nama Mata Kuliah">
                                    
                                    @if ($errors->has('nama_matkul'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nama_matkul') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">SKS</label>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" name="sks">
                                
                                    @if ($errors->has('sks'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('sks') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Harga</label>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" name="harga">

                                    @if ($errors->has('harga'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('harga') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('matkul.index') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@endsection