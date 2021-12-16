<?php
    error_reporting(E_ERROR | E_PARSE);
    $conn = mysqli_connect("localhost", "root", "", "crud-app");

    $aksi = $_POST['aksi'];


    if($_GET['action'] == "table_data"){
 
        $columns = array( 
                                 0 => 'id', 
                                 1 => 'nama',
                                 2 => 'tmptlahir',
                                 3 => 'tgllahir',
                                 4 => 'jabatan',
                                 5 => 'foto',
                                 6 => 'id',
                             );
   
        $querycount = mysqli_query($conn, "SELECT count(id) as jumlah FROM karyawan");
        $datacount = $querycount->fetch_array();
      
     
          $totalData = $datacount['jumlah'];
               
          $totalFiltered = $totalData; 
   
          $limit = $_POST['length'];
          $start = $_POST['start'];
          $order = $columns[$_POST['order']['0']['column']];
          $dir = $_POST['order']['0']['dir'];
               
          if(empty($_POST['search']['value']))
          {            
           $query = mysqli_query($conn, "SELECT id,nama,tmptlahir, tgllahir, jabatan, foto FROM karyawan order by $order $dir
                                                        LIMIT $limit
                                                        OFFSET $start");
          }
          else {
              $search = $_POST['search']['value']; 
              $query = mysqli_query($conn, "SELECT id,nama,tmptlahir, tgllahir, jabatan, foto FROM karyawan WHERE nama LIKE '%$search%'                               
                                                           order by $order $dir
                                                           LIMIT $limit
                                                           OFFSET $start");
   
   
             $querycount = mysqli_query($conn, "SELECT count(id) as jumlah FROM karyawan WHERE nama LIKE '%$search%'
                                                                          ");
           $datacount = $querycount->fetch_array();
             $totalFiltered = $datacount['jumlah'];
          }
   
          $data = array();
          if(!empty($query))
          {
              $no = $start + 1;
              while ($r = $query->fetch_array())
              {
                  $nestedData['no'] = $no;
                  $nestedData['nama'] = $r['nama'];
                  $nestedData['tmptlahir'] = $r['tmptlahir'];
                  $nestedData['tgllahir'] = $r['tgllahir'];
                  $nestedData['jabatan'] = $r['jabatan'];
                  $nestedData['foto'] = $r['foto'];
                  $nestedData['action'] = "<a href='#' class='btn-warning btn-sm'>Ubah</a>&nbsp; <a href='#' class='btn-danger btn-sm'>Hapus</a>";
                  $data[] = $nestedData;
                  $no++;
              }
          }
             
          $json_data = array(
                      "draw"            => intval($_POST['draw']),  
                      "recordsTotal"    => intval($totalData),  
                      "recordsFiltered" => intval($totalFiltered), 
                      "data"            => $data  
                      );
               
          echo json_encode($json_data); 
   
    }


    if($aksi=="insert") {
        TambahData($_POST, $_FILES);
    } elseif($aksi=="getdata") {
        $getdata = GetData($_POST);
        echo json_encode($getdata);
    } elseif($aksi=="edit"){
        $editdata = EditData($_POST, $_FILES);
        echo $editdata;
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

    function HapusData($data)
    {
        global $conn;

        $id = $data["id"];
        $foto = $data["foto"];

        if(mysqli_query($conn, "DELETE FROM karyawan WHERE id=$id")){
            unlink('img/'.$foto);
            return json_encode(array("statusCode"=>200));
        } else {
            return json_encode(array("statusCode"=>201));
        }
    }

    function EditData($data, $foto)
    {
        global $conn;

        // return var_dump($data, $foto);

        $id = $data["id"];
        $nama = htmlspecialchars($data["nama"]);
        $tmptlahir = htmlspecialchars($data["tmptlahir"]);
        $tgllahir = $data["tgllahir"];
        $jabatan = htmlspecialchars($data["jabatan"]);
        $foto_lama = $data["foto-lama"];

        $foto_baru = $foto["foto"];

        if ($foto_baru['error'] === 4) {
            $query = "UPDATE karyawan SET
                        id = '$id',
                        nama = '$nama',
                        tmptlahir = '$tmptlahir',
                        tgllahir = '$tgllahir',
                        jabatan = '$jabatan',
                        foto = '$foto_lama'
                        WHERE id =  $id";
        } else {
            $ekstensi_diperbolehkan = array('jpg','jpeg','png');
            $namafoto = $foto_baru['name'];
            $x = explode('.', $namafoto);
            $ekstensi = strtolower(end($x));
            $ukuran = $foto_baru['size'];
            $file_tmp = $foto_baru['tmp_name'];
            $acak = rand(1,99);
            $nama_unik = $acak.'-'.$namafoto;
            if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                if($ukuran < 1044070){
                    unlink('img/'.$foto_lama);
                    move_uploaded_file($file_tmp, 'img/'.$nama_unik);
                    $query = "UPDATE karyawan SET
                        id = '$id',
                        nama = '$nama',
                        tmptlahir = '$tmptlahir',
                        tgllahir = '$tgllahir',
                        jabatan = '$jabatan',
                        foto = '$nama_unik'
                        WHERE id =  $id";
                }
            }
        }

        if(mysqli_query($conn, $query)){
            return json_encode(array("statusCode"=>200));
        } else {
            return json_encode(array("statusCode"=>201));
        }
    }

?>