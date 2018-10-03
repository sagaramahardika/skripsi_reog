@extends("layouts.app")

@section('title')
    Tambah Periode
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"/>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Periode</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('periode.store') }}" method="POST">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="thn_ajaran" class="col-md-4 control-label">Tahun Ajaran</label>
                                <div class='input-group date col-md-2' id='timepicker_periode'>
                                    <input type='text' class="form-control" name="thn_ajaran" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>

                                    @if ($errors->has('thn_ajaran'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('thn_ajaran') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="semester" class="col-md-4 control-label">Semester</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="semester" placeholder="Enter Semester">
                                        <option value="1">Ganjil</option>
                                        <option value="2">Genap</option>
                                    </select>

                                    @if ($errors->has('semester'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('semester') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('periode.index') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/kaprodi.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
@endsection