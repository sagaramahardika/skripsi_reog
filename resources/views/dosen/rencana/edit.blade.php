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
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Rencana</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('rencana.update', $rencana->id) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="pertemuan" class="col-md-4 control-label">Pertemuan</label>
                                <div class='col-md-2'>
                                    <input type='number' class="form-control" name="pertemuan" value="{{ $rencana->pertemuan }}" disabled/>

                                    @if ($errors->has('pertemuan'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('pertemuan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pembelajaran" class="col-md-4 control-label">Rencana Pembelajaran Semester</label>
                                <div class='col-md-6'>
                                    <textarea name="pembelajaran">{{ $rencana->pembelajaran }}</textarea>

                                    @if ($errors->has('pembelajaran'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('pembelajaran') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="waktu_mulai" class="col-md-4 control-label">Waktu Mulai</label>
                                <div class='input-group date col-md-3' id='timepicker_waktu_mulai'>
                                    <input type='text' class="form-control" name="waktu_mulai" value="{{ date('m/d/Y g:i A', $rencana->waktu_mulai ) }}" disabled/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>

                                    @if ($errors->has('waktu_mulai'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('waktu_mulai') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="waktu_selesai" class="col-md-4 control-label">Waktu Selsai</label>
                                <div class='input-group date col-md-3' id='timepicker_waktu_selesai'>
                                    <input type='text' class="form-control" name="waktu_selesai" value="{{ date('m/d/Y g:i A', $rencana->waktu_selesai ) }}" disabled/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>

                                    @if ($errors->has('waktu_selesai'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('waktu_selesai') }}</strong>
                                        </span>
                                    @endif
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