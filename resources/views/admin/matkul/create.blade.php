@extends("layouts.app")

@section('title')
    Tambah Mata Kuliah
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Mata Kuliah</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('matkul.store') }}" method="POST">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Prodi</label>
                                <div class="col-md-6">
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

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Kode Matakuliah</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="kd_matkul" name="kd_matkul" placeholder="Enter Kode Mata Kuliah">
                                    
                                    @if ($errors->has('kd_matkul'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('kd_matkul') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Nama Mata Kuliah</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="nama_matkul" name="nama_matkul" placeholder="Enter Nama Mata Kuliah">
                                    
                                    @if ($errors->has('nama_matkul'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nama_matkul') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">SKS</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="sks" name="sks" placeholder="Enter SKS">
                                
                                    @if ($errors->has('sks'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('sks') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Harga</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="harga" name="harga" placeholder="Enter Harga">

                                    @if ($errors->has('harga'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('harga') }}</strong>
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
@endsection