$(document).ready( function () {
    $('#dataKaryawan').DataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
                    "url" : "functions.php?action=table_data",
                    "dataType" : "json",
                    "type" : "POST"
                },
        "columns" : [
            {"data" : "no"},
            {"data" : "nama"},
            {"data" : "tmptlahir"},
            {"data" : "tgllahir"},
            {"data" : "jabatan"},
            {"data" : "action"},
        ]
    });
} );