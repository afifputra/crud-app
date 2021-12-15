<?php
    error_reporting(E_ERROR | E_PARSE);
    $conn = mysqli_connect("localhost", "root", "", "crud-app");

    $aksi = $_POST['aksi'];

    // var_dump($aksi);

    if ($aksi=="insert") {
        TambahData($_POST);
    } elseif ($aksi=="getdata") {
        $getdata = GetData($_POST);
        echo json_encode($getdata);
        // var_dump($getdata);
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

    function TambahData($data)
    {
        global $conn;

        // return var_dump($data);

        $nama = htmlspecialchars($data["nama"]);
        $tmptlahir = htmlspecialchars($data["tmptlahir"]);
        $tgllahir = $data["tgllahir"];
        $jabatan = htmlspecialchars($data["jabatan"]);
        $foto = $data["foto"];

        $query = "INSERT INTO karyawan
                    VALUES
                    ('', '$nama', '$tmptlahir', '$tgllahir', '$jabatan', '$foto')
        ";

        if(mysqli_query($conn, $query)){
            return json_encode(array("statusCode"=>200));
        } else {
            return json_encode(array("statusCode"=>201));
        }
        // return mysqli_affected_rows($conn);
    }

    function HapusData($id)
    {
        global $conn;
        mysqli_query($conn, "DELETE FROM karyawan WHERE id=$id");
        return mysqli_affected_rows($conn);

    }

    function EditData($data)
    {
        global $conn;

        // return var_dump($data);

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

        $result = mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

?>