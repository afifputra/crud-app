$(document).ready(function() {

    $("#tambah").click(function () {
        $('#textTambah').text('Tambah Data');
        $('#formTambah')[0].reset();
        $('#aksi').val("insert");
    })

    $(".edit").click(function() {
        $('#textTambah').text('Edit Data');
        $('#aksi').val("edit");
        let id = $(this).data("id");
        let aksi = "getdata";
        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                id: id,
                aksi: aksi
            },
            dataType: "json",
            success: function(dataResult) {
                $('#id').val(dataResult[0].id);
                $('#nama').val(dataResult[0].nama);
                $('#tmptlahir').val(dataResult[0].tmptlahir);
                $('#tgllahir').val(dataResult[0].tgllahir);
                $('#jabatan').val(dataResult[0].jabatan);
                $('#foto').val(dataResult[0].foto);
            }
        })
    });

    // $('#btn-tambah').on('click', function() {
    // $("#btn-tambah").attr("disabled", "disabled");
    // let id = $("#id").val();
    // let nama = $("#nama").val();
    // let tmptlahir = $("#tmptlahir").val();
    // let tgllahir = $("#tgllahir").val();
    // let jabatan = $("#jabatan").val();
    // let foto = $("#foto").val();
    // let aksi = $("#aksi").val();
    // if(nama!="" && tmptlahir!="" && tgllahir!="" && jabatan!="" && foto!="" && aksi!=""){
    //     $.ajax({
    //         url: "functions.php",
    //         type: "POST",
    //         data: {
    //             id: id,
    //             nama: nama,
    //             tmptlahir: tmptlahir,
    //             tgllahir: tgllahir,
    //             jabatan: jabatan,
    //             foto: foto,
    //             aksi: aksi				
    //         },
    //         dataType: "json",
    //         cache: false,
    //         success: function(dataResult){
    //             if(dataResult.statusCode==200){
    //                 $("#btn-tambah").removeAttr("disabled");
    //                 $('#formTambah').find('input:text').val('');
    //                 $("#success").show();
    //                 $('#success').html('Data added successfully !'); 						
    //             }
    //             else if(dataResult.statusCode==201){
    //                 alert("Error occured !");
    //             }
                
    //         }
    //     });
    // }
    // else{
    //     alert('Please fill all the field !');
    // }
    // });

    $(".hapus").click(function () {
        let id = $(this).data("id");
        let aksi = "hapusdata";
        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                id: id,
                aksi: aksi
            },
            dataType: "json",
            success: function(dataResult) {
                if(dataResult.statusCode==200){
                    $('#hapusModal').modal('toogle');			
                }
                else if(dataResult.statusCode==201){
                    alert("Error occured !");
                }
            }
        })
    })

    $('#formTambah').on('submit', function (e) {

        e.preventDefault();
        let form = new FormData(this);
        console.log(form);

        $.ajax({
        type: 'post',
        url: 'functions.php',
        data: form,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function () {
            alert('formTambah was submitted');
        }
        });

    });
});