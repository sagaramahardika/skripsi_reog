$(document).ready(function () {

    if ( $('table#rencana_submatkul').length > 0 ) {
        $('#rencana_submatkul').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.dosen.submatkul,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            "columns": [
                { "data": "kd_matkul" },
                { "data": "nama_matkul" },
                { "data": "grup" },
                { "data": "sks" },
                { "data": "harga" },
                { "data": "options" },
            ]
        });
    }
    
    if ( $('table#rencana').length > 0 ) {
        var id_sub_matkul = $("#id_sub_matkul").val();

        $('#rencana').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.dosen.rencana_submatkul,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token,
                    id_sub_matkul: id_sub_matkul
                }
            },
            "columns": [
                { "data": "pertemuan" },
                { "data": "pembelajaran" },
                { "data": "waktu_mulai" },
                { "data": "waktu_selesai" },
                { "data": "options" },
            ]
        });
    }

    if ( $('div#create-rencana').length > 0 ) {
        $('#timepicker_waktu_mulai').datetimepicker();
        $('#timepicker_waktu_selesai').datetimepicker();
    }

});