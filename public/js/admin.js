$(document).ready(function () {

    if ( $('table#dosen').length > 0 ) {
        $('#dosen').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.dosen,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            "columns": [
                { "data": "nik" },
                { "data": "nama" },
                { "data": "jabatan" },
                { "data": "options" },
            ]
        });
    }

    if ( $('table#fakultas').length > 0 ) {
        $('#fakultas').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.fakultas,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            "columns": [
                { "data": "kd_fakultas" },
                { "data": "nama_fakultas" },
                { "data": "options" },
            ]
        });
    }

    if ( $('table#matkul').length > 0 ) {
        $('#matkul').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.matkul,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            "columns": [
                { "data": "kd_matkul" },
                { "data": "nama_matkul" },
                { "data": "sks" },
                { "data": "harga" },
                { "data": "options" },
            ]
        });
    }

    if ( $('table#prodi').length > 0 ) {
        $('#prodi').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.prodi,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            "columns": [
                { "data": "kd_prodi" },
                { "data": "nama_fakultas" },
                { "data": "nama_prodi" },
                { "data": "options" },
            ]
        });
    }

});