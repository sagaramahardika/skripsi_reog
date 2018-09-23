@extends("layouts.app")

@section('title')
    Edit Fakultas {{ $fakultas->nama_fakultas }}
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

                <form action="{{ route('fakultas.update', $fakultas->kd_fakultas) }}" method="POST">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" value="{{ Session::token() }}" name="_token" />

                    <div class="form-group">
                        <label for="name">Nama Fakultas</label>
                        <input type="text" class="form-control" id="nama_fakultas" name="nama_fakultas" value="{{ $fakultas->nama_fakultas }}" placeholder="Enter Nama Fakultas">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection