<?php
    error_reporting(E_ERROR | E_PARSE);
    $conn = mysqli_connect("localhost", "root", "", "crud-app");

    $aksi = $_POST['aksi'];

    if($aksi=="insert") {
        TambahData($_POST, $_FILES);
    } elseif($aksi=="getdata") {
        $getdata = GetData($_POST);
        echo json_encode($getdata);
    } elseif($aksi=="edit"){
        EditData($_POST);
    } elseif($aksi=="hapusdata"){
        HapusData($_POST);
    }

    function GetData($id)
    {
        global $conn;

        $id = $id["id"];
        // var_dump($id);
        $query = "SELECT * FROM karyawan WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ( $row = mysqli_fetch_assoc($result) ){
            $rows[] = $row;
        }
        // var_dump(json_encode($rows));
        return $rows;

    }

    function BuatQuery($query)
    {
        global $conn;

        $result = mysqli_query($conn, $query);
        $rows = [];
        while ( $row = mysqli_fetch_assoc($result) ){
            $rows[] = $row;
        }
        return $rows;
    }

    function TambahData($data, $foto)
    {
        global $conn;

        $nama = htmlspecialchars($data["nama"]);
        $tmptlahir = htmlspecialchars($data["tmptlahir"]);
        $tgllahir = $data["tgllahir"];
        $jabatan = htmlspecialchars($data["jabatan"]);

        $ekstensi_diperbolehkan = array('jpg','jpeg','png');
        $namafoto = $foto['foto']['name'];
        $x = explode('.', $namafoto);
        $ekstensi = strtolower(end($x));
        $ukuran = $foto['foto']['size'];
        $file_tmp = $foto['foto']['tmp_name'];
        $acak = rand(1,99);
        $nama_unik = $acak.'-'.$namafoto;

        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if($ukuran < 1044070){
                move_uploaded_file($file_tmp, 'img/'.$nama_unik);
                $query = "INSERT INTO karyawan
                            VALUES
                            ('', '$nama', '$tmptlahir', '$tgllahir', '$jabatan', '$nama_unik')
                ";
            }
        }

        if(mysqli_query($conn, $query)){
            return json_encode(array("statusCode"=>200));
        } else {
            return json_encode(array("statusCode"=>201));
        }
    }

    function HapusData($id)
    {
        global $conn;

        $id = $id["id"];

        if(mysqli_query($conn, "DELETE FROM karyawan WHERE id=$id")){
            return json_encode(array("statusCode"=>200));
        } else {
            return json_encode(array("statusCode"=>201));
        }
    }

    function EditData($data)
    {
        global $conn;

        $id = $data["id"];
        $nama = htmlspecialchars($data["nama"]);
        $tmptlahir = htmlspecialchars($data["tmptlahir"]);
        $tgllahir = $data["tgllahir"];
        $jabatan = htmlspecialchars($data["jabatan"]);
        $foto = $data["foto"];

        $query = " UPDATE karyawan SET
                    id = '$id',
                    nama = '$nama',
                    tmptlahir = '$tmptlahir',
                    tgllahir = '$tgllahir',
                    jabatan = '$jabatan',
                    foto = '$foto'
                    WHERE id =  $id";

        if(mysqli_query($conn, $query)){
            return json_encode(array("statusCode"=>200));
        } else {
            return json_encode(array("statusCode"=>201));
        }
    }

?>