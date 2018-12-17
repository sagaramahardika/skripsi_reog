$(document).ready(function () {

    if ( $('table#submatkul').length > 0 ) {
        $('#submatkul').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.kaprodi.submatkul,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            rowsGroup: [0,1,2,4,5],
            columns: [
                { "data": "kd_matkul" },
                { "data": "nama_matkul" },
                { "data": "grup" },
                { "data": "dosen" },
                { "data": "total_pertemuan" },
                { "data": "options" },
            ],
            "language": {
                "search": "Search Kode Matkul:"
            }
        });
    }

    if ( $('#create-pertemuan').length > 0 ) {
        $('#timepicker_waktu_mulai').datetimepicker();
        $('#timepicker_waktu_selesai').datetimepicker();
    }

    if ( $('table#mengajar').length > 0 ) {
        var id_sub_matkul = $("#id_sub_matkul").val();

        $('#mengajar').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.kaprodi.pengajar,
                "dataType": "json",
                "type": "POST",
                "data": {
                    id_sub_matkul: id_sub_matkul,
                    _token: config.token
                }
            },
            columns: [
                { "data": "nik" },
                { "data": "nama" },
                { "data": "options" },
            ]
        });
    }

    if ( $('table#laporan').length > 0 ) {
        var id_sub_matkul = $("#id_sub_matkul").val();

        $('#laporan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.kaprodi.laporan,
                "dataType": "json",
                "type": "POST",
                "data": {
                    id_sub_matkul: id_sub_matkul,
                    _token: config.token
                }
            },
            columns: [
                { "data": "pertemuan" },
                { "data": "pembelajaran" },
                { "data": "waktu_mulai_rencana" },
                { "data": "waktu_selesai_rencana" },
                { "data": "waktu_mulai_kuliah" },
                { "data": "waktu_selesai_kuliah" },
                { "data": "catatan" },
                { "data": "nim" },
                { "data": "keterangan" },
                { "data": "acara" }
            ],
            paging: false,
            searching: false,
        });
    }

    if ( $('div#timepicker_periode').length > 0 ) {
        $('#timepicker_periode').datetimepicker({
            viewMode: "years", 
            format: 'YYYY',
        });
    }

    if ( $('div#mengajar').length > 0 ) {

        $('#id_sub_matkul').typeahead({
            source: function( query, process) {
                submatkuls = [];
                map = {};

                var id_periode = $("#id_periode").val();
                $.ajax({
                    url: config.routes.kaprodi.submatkul_data,
                    data : {
                        query : query,
                        id_periode : id_periode,
                        _token : config.token
                    },
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        $.each(data, function (i, submatkul) {
                            map[submatkul.label] = submatkul;
                            submatkuls.push(submatkul.label);
                        });

                        process(submatkuls);
                    }
                });
            },
            updater: function(item) {
                $('#hidden_id_sub_matkul').val(map[item].id);
                return item;
            }
        });

    }

    if ( $('table#periode').length > 0 ) {
        $('#periode').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.kaprodi.periode,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            columns: [
                { "data": "thn_ajaran" },
                { "data": "semester" },
                { "data": "options" },
            ]
        });
    }

    if ( $('table#fakultas').length > 0 ) {
        $('#fakultas').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.kaprodi.fakultas,
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

    if ( $('table#prodi').length > 0 ) {
        $('#prodi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.kaprodi.prodi,
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

    if ( $('#dosen-index').length > 0 ) {
        $('#dosen').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.kaprodi.dosen,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            columns: [
                { "data": "nik" },
                { "data": "nama" },
                { "data": "jabatan" },
                { "data": "options" },
            ]
        });
    }

    if ( $('#mahasiswa-index').length > 0 ) {
        $('#mahasiswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": config.routes.kaprodi.mahasiswa,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            columns: [
                { "data": "nim" },
                { "data": "nama" },
                { "data": "options" },
            ]
        });
    }

});