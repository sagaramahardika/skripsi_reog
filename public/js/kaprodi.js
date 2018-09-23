$(document).ready(function () {

    if ( $('table#submatkul').length > 0 ) {
        $('#submatkul').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.kaprodi.submatkul,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "nama_matkul" },
                { "data": "grup" },
                { "data": "options" },
            ]
        });
    }

    if ( $('div#timepicker_periode').length > 0 ) {
        $('#timepicker_periode').datetimepicker({
            viewMode: "years", 
            format: 'YYYY',
        });
    }

    if ( $('table#mengajar').length > 0 ) {
        $('#mengajar').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.kaprodi.mengajar,
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

    if ( $('table#periode').length > 0 ) {
        $('#periode').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.kaprodi.periode,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "thn_ajaran" },
                { "data": "semester" },
                { "data": "options" },
            ]
        });
    }

});