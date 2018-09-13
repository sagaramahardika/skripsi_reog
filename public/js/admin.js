$(document).ready(function () {
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
            { "data": "nama" },
            { "data": "options" },
        ]
    });

});