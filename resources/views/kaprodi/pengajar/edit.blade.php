@extends("layouts.app")

@section('title')
    Tambah Pengajar
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Pengajar</div>

                    <div class="panel-body" id="mengajar">

                        <form class="form-horizontal" action="{{ route('mengajar.update', $mengajar->id) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Periode</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="id_periode" placeholder="Enter Prodi">
                                        @foreach ( $allPeriode as $periode )
                                            @php
                                                if ( $mengajar->submatkul->id_periode == $periode->id ) {
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
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Mata Kuliah</label>
                                <div class="col-md-6">
                                    @php
                                        $submatkul_label = $mengajar->submatkul->matkul->nama_matkul . " (" . $mengajar->submatkul->grup . ")"
                                    @endphp
                                    <input type="text" id="id_sub_matkul" class="typeahead" autocomplete="off" value="{{ $submatkul_label }}">
                                    <input type="hidden" name="id_sub_matkul" id="hidden_id_sub_matkul" value="{{ $mengajar->id_sub_matkul }}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Dosen</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="nik" name="nik" placeholder="Enter Prodi">
                                        @foreach ( $allDosen as $dosen )
                                            @if ( $mengajar->nik == $dosen->nik )
                                                {{ $selected = "selected='selected'" }}
                                            @else
                                                {{ $selected = '' }}
                                            @endif

                                            <option value="{{ $dosen->nik }}" {{ $selected }}> 
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
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

@section('scripts')
    <script src="{{ asset('js/kaprodi.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/3.1.1/bootstrap3-typeahead.min.js"></script>
@endsection