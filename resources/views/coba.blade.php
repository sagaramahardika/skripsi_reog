<html>
<head>
<Title>Coba</Title>
</head>
<body>
<h1>
Coba View
</h1>
<hr>

@foreach ( $submatkuls as $submatkul )
    @php
        $pengajars = $submatkul->pengajar               
    @endphp
    @foreach ( $pengajars as $pengajar )
        <p> NIK : {{ $pengajar->dosen->nik }}, Nama  : {{$pengajar->dosen->nama}},  Jabatan : {{ $pengajar->dosen->jabatan }}  </p>
    @endforeach

@endforeach
</body>

</html>