<?php

    $conn = mysqli_connect("localhost", "root", "", "crud-app");

    function query($query)
    {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ( $row = mysqli_fetch_assoc($result) ){
            $rows[] = $row;
        }
        return $rows;
    }

    function tambahData($data)
    {
        global $conn;
        $nama = htmlspecialchars($data["nama"]);
        $tmptlahir = htmlspecialchars($data["tmptlahir"]);
        $tgllahir = $data["tgllahir"];
        $jabatan = htmlspecialchars($data["jabatan"]);
        $foto = $data["foto"];

        $query = "INSERT INTO karyawan
                    VALUES
                    ('', '$nama', '$tmptlahir', '$tgllahir', '$jabatan', '$foto')
        ";

        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function hapusData($id)
    {
        global $conn;
        mysqli_query($conn, "DELETE FROM karyawan WHERE id=$id");
        return mysqli_affected_rows($conn);

    }

?>