<?php
    require 'functions.php ';
    $employees = query("SELECT * FROM karyawan");
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
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
            <div class="row d">
                <div class="col">
                <button type="button" class="btn btn-sm btn-outline-primary">Tambah Data</button>
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
                            <td><?= $employee["jabatan"];?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>
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
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="datatables.js"></script>
</html>