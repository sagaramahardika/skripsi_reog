@extends("layouts.app")

@section('title')
    Tambah Mata Kuliah per Periode
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Matakuliah per Periode</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('submatkul.store') }}" method="POST">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Periode</label>
                                <div class="col-md-3">
                                    <select class="form-control" id="id_periode" name="id_periode" placeholder="Enter Prodi">
                                        @foreach ( $allPeriode as $periode )
                                            @php
                                                $thn_ajaran = intval(date('Y', $periode->thn_ajaran));
                                                $thn_ajaran = $thn_ajaran . "/" . ($thn_ajaran+1);
                                                $thn_ajaran .= " (" . ucfirst($periode->semester) . ")";
                                            @endphp
                                            <option value="{{ $periode->id }}"> {{ $thn_ajaran }} </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('id_periode'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('id_periode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Matakuliah</label>
                                <div class="col-md-3">
                                <select class="form-control" id="kd_matkul" name="kd_matkul" placeholder="Enter Matakuliah">
                                        @foreach ( $allMatakuliah as $matakuliah )
                                            <option value="{{ $matakuliah->kd_matkul }}"> {{ $matakuliah->nama_matkul }} </option>
                                        @endforeach
                                    </select>
                                    
                                    @if ($errors->has('kd_matkul'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('kd_matkul') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Grup</label>
                                <div class="col-md-1">
                                    <select class="form-control" id="grup" name="grup" placeholder="Enter Grup">
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">C</option>
                                        <option value="4">D</option>
                                        <option value="5">E</option>
                                    </select>

                                    @if ($errors->has('grup'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('grup') }}</strong>
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