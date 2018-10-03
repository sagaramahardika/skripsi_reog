$(document).ready(function () {

    if ( $('#dosen-index').length > 0 ) {
        dosenDataTable = $('#dosen').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.admin.dosen,
                "dataType": "json",
                "type": "POST",
                "data": function (data) {
                    data.kd_prodi = $('#kd_prodi').val(),
                    data._token =  config.token
                }
            },
            columns: [
                { "data": "nik" },
                { "data": "nama" },
                { "data": "jabatan" },
                { "data": "options" },
            ]
        });

        $('#kd_prodi').on('change', function() {

            dosenDataTable.ajax.reload();
            if ( !$('#dosen-data').is(':hidden') ) {
                $('#dosen-data').css('visibility', 'visible');
            }

            return false;
        });
    }

    if ( $('table#fakultas').length > 0 ) {
        $('#fakultas').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.admin.fakultas,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            columns: [
                { "data": "kd_fakultas" },
                { "data": "nama_fakultas" },
                { "data": "options" },
            ]
        });
    }

    if ( $('#mahasiswa-index').length > 0 ) {
        mahasiswaDataTable = $('#mahasiswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.admin.mahasiswa,
                "dataType": "json",
                "type": "POST",
                "data": function (data) {
                    data.kd_prodi = $('#kd_prodi').val(),
                    data._token =  config.token
                }
            },
            columns: [
                { "data": "nim" },
                { "data": "nama" },
                { "data": "options" },
            ]
        });

        $('#kd_prodi').on('change', function() {

            mahasiswaDataTable.ajax.reload();
            if ( !$('#mahasiswa-data').is(':hidden') ) {
                $('#mahasiswa-data').css('visibility', 'visible');
            }

            return false;
        });
    }

    if ( $('#matkul-index').length > 0 ) {
        matkulDataTable = $('#matkul').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.admin.matkul,
                "dataType": "json",
                "type": "POST",
                "data": function (data) {
                    data.kd_prodi = $('#kd_prodi').val(),
                    data._token =  config.token
                }
            },
            columns: [
                { "data": "kd_matkul" },
                { "data": "nama_matkul" },
                { "data": "sks" },
                { "data": "harga" },
                { "data": "options" },
            ]
        });

        $('#kd_prodi').on('change', function() {

            matkulDataTable.ajax.reload();
            if ( !$('#matkul-data').is(':hidden') ) {
                $('#matkul-data').css('visibility', 'visible');
            }
            $("#kd_prodi_form").val( $(this).val() );

            return false;
        });
    }

    if ( $('table#prodi').length > 0 ) {
        $('#prodi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.admin.prodi,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            columns: [
                { "data": "kd_prodi" },
                { "data": "nama_fakultas" },
                { "data": "nama_prodi" },
                { "data": "options" },
            ]
        });
    }

});