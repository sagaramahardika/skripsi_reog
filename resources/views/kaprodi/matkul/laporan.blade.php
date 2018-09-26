@extends("layouts.app")

@section('title')
    Laporan
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if( Session::has('error') )
                    <div class="alert alert-danger">
                        <p> {{ Session::get('error') }} </p>
                    </div>
                @elseif ( Session::has('success') )
                    <div class="alert alert-success">
                        <p> {{ Session::get('success') }} </p>
                    </div>
                @endif

                <input type="hidden" value="{{ $submatkul->id }}" name="id_sub_matkul" id="id_sub_matkul" />

                <table id="laporan" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <th>Pertemuan</th>
                        <th>Rencana Pembelajaran Semester</th>
                        <th>Waktu Mulai Rencana</th>
                        <th>Waktu Selesai Rencana</th>
                        <th>Waktu Mulai Validasi</th>
                        <th>Waktu Selesai Validasi</th>
                        <th>Catatan</th>
                        <th>Validasi</th>
                        <th>Keterangan</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/kaprodi.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endsection