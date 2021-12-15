<?php
    require 'functions.php ';
    
    $employees = BuatQuery("SELECT * FROM karyawan");

    // if (isset($_POST["submit"])) {

    //     if (TambahData($_POST) > 0) {
    //         // echo "
    //         //     <script>
    //         //         $(document).ready(function() {
    //         //             $('#container').load('index.php');
    //         //         var refreshId = setInterval(function() {
    //         //             $('#container').load('index.php');
    //         //         }, 9000);
    //         //         $.ajaxSetup({ cache: false });
    //         //     </script>
    //         // ";
    //     }
    //     else {
    //         // echo "
    //         //     <script>
    //         //         notifSuksesModal.show();
    //         //     </script>
    //         // ";
    //     }
    // }

    if (isset($_POST["edit"])) {
        
        if (EditData($_POST) > 0) {
            echo "
                <script>
                    alert('data berhasil diedit');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('data gagal diedit');
                    document.location.href = 'index.php';
                </script>
            ";
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
        <title>CRUD App</title>
    </head>
    <body>
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="row">
                    <div class="col">
                    <h4>
                        CRUD APP
                    </h4>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="row mb-3 justify-content-center">
                    <div class="col">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahModal" id="tambah">Tambah Data</button>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-10">
                <?php
                    $i = 1;
                ?>
                    <table id="dataKaryawan" class="table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Tempat, Tanggal Lahir</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($employees as $employee):
                            ?>
                            <tr>
                                <td class="text-center"><?= $i; ?></td>
                                <td class="text-center"><?= $employee['nama'];?></td>
                                <td class="text-center"><?= $employee["tmptlahir"].", ".date('d F Y', strtotime($employee["tgllahir"]));?></td>
                                <td class="text-center"><?= $employee['jabatan'];?></td>
                                <td class="text-center">
                                    <img src="img/<?= $employee["foto"];?>" alt="">
                                </td>
                                <td class="text-center">
                                    <a id="edit" type="button" data-action="edit" data-id="<?= $employee['id']?>" class="btn btn-sm btn-outline-primary edit" data-placement="bottom" onclick="$('#tambahModal').modal('show');">
                                        Edit
                                    </a>
                                    <a id="hapus" type="button" data-action="hapus" data-id="<?= $employee['id']?>" class="btn btn-sm btn-outline-danger hapus" data-placement="bottom"onclick="$('#hapusModal').modal('show');">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $i++; 
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <!-- Modal Tambah Edit Data -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div id="success" class="alert alert-success alert-dismissible" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">X</a>
                    </div>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="textTambah">Tambah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data" id="formTambah">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id">
                                <label for="nama">Nama</label>
                                <input id="nama" name="nama" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <label for="tmptlahir">Tempat Lahir</label>
                                <input id="tmptlahir" name="tmptlahir" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"> 
                                <label for="tgllahir">Tanggal Lahir</label>
                                <input id="tgllahir" name="tgllahir" type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <label for="jabatan">Jabatan</label>
                                <input id="jabatan" name="jabatan" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <label for="foto">Foto</label>
                                <input id="foto" name="foto" type="file" class="form-control">
                                <input type="hidden" name="aksi" id="aksi" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="close" name="close" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="submit" id="btn-tambah" value="Save to database" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Hapus -->
            <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda Yakin untuk Menghapus Data ?</p>
                            <form action="" method="post" id="hapusForm">
                                <input type="hidden" name="id" id="id" value="">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="hapus" id="btn-hapus" class="btn btn-danger">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="datatables.js"></script>
</html>