@extends("layouts.app")

@section('title')
    Tambah Mata Kuliah per Periode
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Matakuliah per Periode</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('submatkul.update', $submatkul->id) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Periode</label>
                                <div class="col-md-3">
                                    <select class="form-control" id="id_periode" name="id_periode" placeholder="Enter Prodi">
                                        @foreach ( $allPeriode as $periode )
                                            @php
                                                if ( $submatkul->id_periode == $periode->id ) {
                                                    $selected = "selected='selected'";
                                                } else {
                                                    $selected = '';
                                                }

                                                $thn_ajaran = intval(date('Y', $periode->thn_ajaran));
                                                $thn_ajaran = $thn_ajaran . "/" . ($thn_ajaran+1);
                                                $thn_ajaran .= " (" . ucfirst($periode->semester) . ")";
                                            @endphp
                                            <option value="{{ $periode->id }}" {{ $selected }}> 
                                                {{ $thn_ajaran }} 
                                            </option>
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
                                            @if ( $submatkul->kd_matkul == $matakuliah->kd_matkul )
                                                {{ $selected = "selected='selected'" }}
                                            @else
                                                {{ $selected = "" }}
                                            @endif
                                            <option value="{{ $matakuliah->kd_matkul }}" {{ $selected }}> 
                                                {{ $matakuliah->nama_matkul }} 
                                            </option>
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
                                <label for="name" class="col-md-4 control-label">Jabatan</label>
                                <div class="col-md-2">
                                    <select class="form-control" id="grup" name="grup" placeholder="Enter Grup">
                                        <option value="1" {{ ($submatkul->grup == "A") ? "selected='selected'" : "" }} > 
                                            A 
                                        </option>
                                        <option value="2" {{ ($submatkul->grup == "B") ? "selected='selected'" : "" }} > 
                                            B 
                                        </option>
                                        <option value="3" {{ ($submatkul->grup == "C") ? "selected='selected'" : "" }} > 
                                            C 
                                        </option>
                                        <option value="4" {{ ($submatkul->grup == "D") ? "selected='selected'" : "" }} > 
                                            D 
                                        </option>
                                        <option value="5" {{ ($submatkul->grup == "E") ? "selected='selected'" : "" }} > 
                                            E 
                                        </option>
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
                                <a href="{{ route('submatkul.index') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@endsection