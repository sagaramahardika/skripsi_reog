$(document).ready(function () {

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