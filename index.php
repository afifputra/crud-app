<?php
    require 'functions.php ';
    
    $employees = query("SELECT * FROM karyawan");

    if (isset($_POST["submit"])) {

        if (tambahData($_POST) > 0) {
            echo "
                <script>
                    alert('data berhasil ditambahkan');
                    document.location.href = 'index.php';
                </script>                
            ";
        }
        else {
            echo "
                <script>
                    alert('data gagal ditambahkan');
                    document.location.href = 'index.php';
            ";
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
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
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Data</button>
                </div>
            </div>
            <div class="row">
                <div class="col ">
                <?php
                    $i = 1;
                ?>
                    <table id="table_id" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Jabatan</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($employees as $employee):
                            ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $employee['nama'];?></td>
                                <td><?= $employee["tmptlahir"].", ".date('h M Y', strtotime($employee["tgllahir"]));?></td>
                                <td><?= $employee['jabatan'];?></td>
                                <td>
                                    <img src="img/<?= $employee["foto"];?>" alt="">
                                </td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                        Edit
                                    </button>
                                    <a type="button" class="btn btn-sm btn-outline-danger" href="hapus.php?id=<?= $employee['id'] ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ?');">
                                        Delete
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

            <!-- Modal Tambah Data -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <label for="nama">Nama</label>
                                <input id="nama" name="nama" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                <label for="tmptlahir">Tempat Lahir</label>
                                <input id="tmptlahir" name="tmptlahir" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required> 
                                <label for="tgllahir">Tanggal Lahir</label>
                                <input id="tgllahir" name="tgllahir" type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                <label for="jabatan">Jabatan</label>
                                <input id="jabatan" name="jabatan" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                <label for="foto">Foto</label>
                                <input id="foto" name="foto" type="file" class="form-control" required>
                                <br>
                                <div class="modal-footer">
                                    <button type="close" name="close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <label for="nama">Nama</label>
                            <input id="nama" name="nama" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?= $employee['nama'];?>">
                            <label for="tmptlahir">Tempat Lahir</label>
                            <input id="tmptlahir" name="tmptlahir" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            <label for="tgllahir">Tanggal Lahir</label>
                            <input id="tgllahir" name="tgllahir" type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            <label for="jabatan">Jabatan</label>
                            <input id="jabatan" name="jabatan" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            <label for="foto">Foto</label>
                            <input id="foto" name="foto" type="file" class="form-control">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Tambah</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="datatables.js"></script>
    <script src="http://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>