<!-- Nama kelompok :
Salman Asis Parohi (220401010011)
Muhammad Sholehuddin Aziz (220401010027)

Kelas : IT - 403 -->


<?php

$hostname = "localhost";
$user = "root";
$pass = "";
$dbName = "db_stock_inventory";

//cara koneksi
$conn = new mysqli($hostname, $user, $pass, $dbName);
if ($conn->connect_error) { //cek koneksi
    die("Failed to Connect to Database: " . $conn->connect_error);
}

$kode_barang = "";
$nama_barang = "";
$jumlah_barang = "";
$satuan_barang = "";
$harga_beli = "";
$status_barang = "";
$succes = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if($op == "tambah"){
    $id_barang = $_GET['id_barang'];
    $sql1 = "UPDATE tb_stock_inventory SET jumlah_barang = jumlah_barang + 1 WHERE id_barang = '$id_barang'";
    $q1 = mysqli_query($conn, $sql1);
    if ($q1) {
        $succes = "jumlah barang ditambah 1";
    } else {
        $error = "Data gagal diupdate";
    }
}

if ($op == "pakai") {
    $id_barang = $_GET['id_barang'];
    $sql1 = "UPDATE tb_stock_inventory SET jumlah_barang = jumlah_barang - 1 WHERE id_barang = '$id_barang'";
    $q1 = mysqli_query($conn, $sql1);
    if ($q1) {
        $succes = "Jumlah barang berkurang 1";
    } else {
        $error = "Data gagal diupdate";
    }
}

if ($op == "delete") {
    $id_barang = $_GET['id_barang'];
    $sql1 = "DELETE FROM tb_stock_inventory WHERE id_barang = '$id_barang'";
    $q1 = mysqli_query($conn, $sql1);
    if ($q1) {
        $succes = "Data berhasil dihapus";
    } else {
        $error = "Data gagal dihapus";
    }
}

if ($op == "update") {
    $id_barang      = $_GET['id_barang'];
    $sql1           = "SELECT * from tb_stock_inventory WHERE id_barang = '$id_barang'";
    $q1             = mysqli_query($conn, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $kode_barang    = $r1['kode_barang'];
    $nama_barang    = $r1['nama_barang'];
    $jumlah_barang  = $r1['jumlah_barang'];
    $satuan_barang  = $r1['satuan_barang'];
    $harga_beli     = $r1['harga_beli'];
    $status_barang  = $r1['status_barang'];

    if ($kode_barang == "") {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['submit'])) { //untuk Create
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $satuan_barang = $_POST['satuan_barang'];
    $harga_beli = $_POST['harga_beli'];
    $status_barang = $_POST['status_barang'];

    if ($kode_barang && $nama_barang && $jumlah_barang && $satuan_barang && $harga_beli && $status_barang) {
        if ($op == 'update') { //untuk update
            $sql1   = "UPDATE tb_stock_inventory SET kode_barang = '$kode_barang', nama_barang = '$nama_barang', jumlah_barang = '$jumlah_barang', satuan_barang = '$satuan_barang', harga_beli = '$harga_beli', status_barang = '$status_barang' WHERE id_barang = '$id_barang'";
            $q1     = mysqli_query($conn, $sql1);
            if ($q1) {
                $succes = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            $sql1   = "INSERT INTO tb_stock_inventory(kode_barang,nama_barang,jumlah_barang,satuan_barang,harga_beli,status_barang) VALUES ('$kode_barang','$nama_barang','$jumlah_barang','$satuan_barang','$harga_beli','$status_barang')";
            $q1     = mysqli_query($conn, $sql1);
            if ($q1) {
                $succes = "Berhasil memasukan data baru";
            } else {
                $error = "Gagal memasukan data";
            }
        }
    } else {
        $error = "Data Tidak Boleh Kosong";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Stock Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/dataTables.css">
    <style>
        .mx-auto {
            width: 75%
        }

        .card {
            margin-top: 10px
        }

        .btn-group {
            margin-top: 5px;
            margin-bottom: 5px
        }

        .submit {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <h2>Data Stock Inventory</h2>
        <!-- untuk input data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php // untuk menampilkan pesan error
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <?php
                if ($succes) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $succes; ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>


                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang" placeholder="Kode Barang" name="kode_barang" value="<?php echo $kode_barang ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" placeholder="Nama Barang" name="nama_barang" value="<?php echo $nama_barang ?>">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jumlah_barang" placeholder="Jumlah Barang" name="jumlah_barang" value="<?php echo $jumlah_barang ?>">
                    </div>
                    <div class="form-group">
                        <label>Satuan Barang</label>
                        <select id="satuan_barang" name="satuan_barang" class="form-control">
                            <option value="kg" <?php if ($satuan_barang == "kg") echo "selected"; ?>>kg</option>
                            <option value="pcs" <?php if ($satuan_barang == "pcs") echo "selected"; ?>>pcs</option>
                            <option value="liter" <?php if ($satuan_barang == "liter") echo "selected"; ?>>liter</option>
                            <option value="meter" <?php if ($satuan_barang == "meter") echo "selected"; ?>>meter</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli" placeholder="Harga Beli" name="harga_beli" value="<?php echo $harga_beli ?>">
                    </div>
                    <div class="form-group">
                        <label>Status Barang</label>
                        <select id="status_barang" name="status_barang" class="form-control">
                            <option value="1">Available</option>
                            <option value="0">Not Available</option>
                        </select>
                    </div>
                    <div class="submit">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk output data-->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Stock Inventory
            </div>
            <div class="card-body">
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Jumlah Barang</th>
                            <th scope="col">Satuan Barang</th>
                            <th scope="col">Harga Beli</th>
                            <th scope="col">Status Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "SELECT * FROM tb_stock_inventory ORDER BY id_barang DESC";
                        $q2     = mysqli_query($conn, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id_barang          = $r2['id_barang'];
                            $kode_barang        = $r2['kode_barang'];
                            $nama_barang        = $r2['nama_barang'];
                            $jumlah_barang      = $r2['jumlah_barang'];
                            $satuan_barang      = $r2['satuan_barang'];
                            $harga_beli         = $r2['harga_beli'];
                            $status_barang      = $r2['status_barang'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $kode_barang ?></td>
                                <td scope="row"><?php echo $nama_barang ?></td>
                                <td scope="row"><?php echo $jumlah_barang ?></td>
                                <td scope="row"><?php echo $satuan_barang ?></td>
                                <td scope="row"><?php echo $harga_beli ?></td>
                                <td scope="row"><?php echo $status_barang ? "Available" : "Not Available" ?></td>
                                <td scope="row">
                                    <a href="index.php?op=update&id_barang=<?php echo $id_barang; ?>"> <button type="button" class="btn btn-success">Update</button></a>
                                    <a href="index.php?op=delete&id_barang=<?php echo $id_barang ?>" onclick="return confirm('Yakin mau delete data?')"> <button type="button" class="btn btn-danger">Hapus</button></a>
                                    <a href="index.php?op=pakai&id_barang=<?php echo $id_barang; ?>"> <button type="button" class="btn btn-warning">Pakai</button></a>
                                    <a href="index.php?op=tambah&id_barang=<?php echo $id_barang; ?>"> <button type="button" class="btn btn-info">Tambah</button></a>
                                    
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</html>

