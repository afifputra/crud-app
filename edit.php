<?php
    require 'functions.php';

    $id = $_GET['id'];

    $ambil_data_edit = query("SELECT * FROM karyawan WHERE id = $id");
?>