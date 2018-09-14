@extends("layouts.admin")

@section('title')
    Tambah Prodi
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

                <form action="{{ route('prodi.store') }}" method="POST">
                    <input type="hidden" value="{{ Session::token() }}" name="_token" />

                    <div class="form-group">
                        <label for="name">Fakultas</label>
                        <select class="form-control" id="kd_fakultas" name="kd_fakultas" placeholder="Enter Fakultas">
                            @foreach ( $allFakultas as $fakultas )
                                <option value="{{ $fakultas->kd_fakultas }}"> {{ $fakultas->nama_fakultas }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Prodi</label>
                        <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" placeholder="Enter Nama Prodi">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection