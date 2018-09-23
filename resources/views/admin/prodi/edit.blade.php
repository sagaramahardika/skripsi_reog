@extends("layouts.app")

@section('title')
    Edit Fakultas {{ $prodi->nama_prodi }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ( count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('prodi.update', $prodi->kd_prodi) }}" method="POST">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" value="{{ Session::token() }}" name="_token" />

                    <div class="form-group">
                        <label for="name">Fakultas</label>
                        <select class="form-control" id="kd_fakultas" name="kd_fakultas" placeholder="Enter Fakultas">
                            @foreach ( $allFakultas as $fakultas )
                                @if ( $prodi->kd_fakultas == $fakultas->kd_fakultas )
                                    {{ $selected = "selected='selected'" }}
                                @else
                                    {{ $selected = "" }}
                                @endif
                                <option value="{{ $fakultas->kd_fakultas }}" {{ $selected }}> 
                                    {{ $fakultas->nama_fakultas }} 
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Prodi</label>
                        <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" value="{{ $prodi->nama_prodi }}" placeholder="Enter Fakultas Nama">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection