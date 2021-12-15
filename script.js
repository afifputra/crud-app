$(document).ready(function() {
    $("#tambah").click(function () {
        $('#textTambah').text('Tambah Data');
        // $('#formTambah').text('Tambah Data');
        $('#formTambah')[0].reset();
    })
    $( ".edit" ).click(function() {
        $('#textTambah').text('Edit Data');
        let id = $(this).data("id");
        let aksi = "getdata";
        // alert(id);
        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                id: id,
                aksi: aksi
            },
            dataType: "json",
            success: function(dataResult) {
                // console.log(dataResult);
                // alert(dataResult);
                $('#nama').val(dataResult[0].nama);
                $('#tmptlahir').val(dataResult[0].tmptlahir);
                $('#tgllahir').val(dataResult[0].tgllahir);
                $('#jabatan').val(dataResult[0].jabatan);
                $('#foto').val(dataResult[0].foto);
            }
        })
      });
	$('#btn-tambah').on('click', function() {
		$("#btn-tambah").attr("disabled", "disabled");
		let nama = $("#nama").val();
        let tmptlahir = $("#tmptlahir").val();
        let tgllahir = $("#tgllahir").val();
        let jabatan = $("#jabatan").val();
        let foto = $("#foto").val();
        let aksi = "insert";
		if(nama!="" && tmptlahir!="" && tgllahir!="" && jabatan!="" && foto!="" && aksi!=""){
			$.ajax({
				url: "functions.php",
				type: "POST",
				data: {
					nama: nama,
					tmptlahir: tmptlahir,
					tgllahir: tgllahir,
					jabatan: jabatan,
                    foto: foto,
                    aksi: aksi				
				},
                dataType: "json",
				cache: false,
				success: function(dataResult){
					// var dataResult = JSON.parse(dataResult);
                    console.log(dataResult);
					if(dataResult.statusCode==200){
						$("#btn-tambah").removeAttr("disabled");
						$('#formTambah').find('input:text').val('');
						$("#success").show();
						$('#success').html('Data added successfully !'); 						
					}
					else if(dataResult.statusCode==201){
					   alert("Error occured !");
					}
					
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
});