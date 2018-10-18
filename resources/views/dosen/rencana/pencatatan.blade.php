@extends("layouts.app")

@section('title')
    Tambah Rencana
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"/>
@endsection

@section('content')
    <div class="container" id="create-rencana">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Pencatatan</div>

                    <div class="panel-body">
                        <div class="row">
                            @php
                                $thn_ajaran = intval(date('Y', $rencana->submatkul->periode->thn_ajaran));
                                $thn_ajaran = $thn_ajaran . "/" . ($thn_ajaran+1);
                            @endphp

                            <div class="col-md-8">{{ $rencana->submatkul->matkul->kd_matkul . "-" . $rencana->submatkul->matkul->nama_matkul }}</div>
                            <div class="col-md-4 text-right">{{ "Periode : " . $thn_ajaran . " " . ucfirst($rencana->submatkul->periode->semester) }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">{{ $rencana->submatkul->matkul->sks . " SKS" }}</div>
                            <div class="col-md-4 text-right">Waktu Mulai : {{ date('d/m/Y H:i', $rencana->waktu_mulai ) }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">{{ "Grup-" . $rencana->submatkul->grup }}</div>
                            <div class="col-md-4 text-right">Waktu Selesai : {{ date('d/m/Y H:i', $rencana->waktu_selesai ) }}</div>
                        </div>

                        <hr>

                        <form class="form-horizontal" action="{{ route('rencana.kuliah_store') }}" method="POST">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />
                            <input type="hidden" value="{{ $rencana->id }}" name="id_rencana" />

                            <div class="form-group">
                                <label for="nim" class="col-md-4 control-label">Pertemuan</label>
                                <div class='col-md-6'>
                                    <input type='text' class="form-control" value="{{ $rencana->pertemuan }}" disabled />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nim" class="col-md-4 control-label">RPP</label>
                                <div class='col-md-6'>
                                    <textarea disabled>{{ $rencana->pembelajaran }}</textarea>

                                    @if ($errors->has('nim'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nim') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="catatan" class="col-md-4 control-label">Catatan</label>
                                <div class='col-md-6'>
                                    <textarea name="catatan"></textarea>

                                    @if ($errors->has('catatan'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('catatan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if ( Session::has('error') )
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4 alert alert-danger">
                                        <p> {{ Session::get('error') }} </p>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="nim" class="col-md-4 control-label">NIM Mahasiswa</label>
                                <div class='col-md-6'>
                                    <input type='text' class="form-control" name="nim" />

                                    @if ($errors->has('nim'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nim') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>
                                <div class='col-md-6'>
                                    <input type='password' class="form-control" name="password" />
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('rencana.rps', $rencana->id_sub_matkul) }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dosen.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
@endsection