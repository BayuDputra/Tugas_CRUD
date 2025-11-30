<?php
// Alamat server database (biasanya localhost)
$host = "localhost";
// Username MySQL
$user ="root";
// Password MySQL (kosong jika default XAMPP)
$pass ="";
// Nama database yang digunakan
$db ="tugas_crud";

// Membuat koneksi ke database MySQL
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die ("Tidak Bisa Terhubung Ke Database"); // Jika koneksi gagal, hentikan program dan tampilkan pesan
}

// Variabel untuk menampung input dari form
$nama_karyawan      ="";
$jenis_kelamin      ="";
$divisi_karyawan    ="";
$position           ="";
// Variabel untuk menampilkan pesan sukses atau error
$sukses             ="";
$error              ="";

// Mengecek apakah tombol Simpan ditekan
if (isset($_POST['simpan'])){
    // Mengambil value input dari form dengan metode POST
    $nama_karyawan      = $_POST['nama_karyawan'];
    $jenis_kelamin      = $_POST['jenis_kelamin'];
    $divisi_karyawan    = $_POST['divisi_karyawan'];
    $position           = $_POST['position'];

    if ($nama_karyawan && $jenis_kelamin && $divisi_karyawan && $position){ // Mengecek apakah semua field sudah diisi
 // Query SQL untuk memasukkan data baru ke tabel karyawan
        $sql1 = "insert into karyawan (nama_karyawan,jenis_kelamin,divisi_karyawan,position) values ('$nama_karyawan','$jenis_kelamin','$divisi_karyawan','$position')";
        $q1 = mysqli_query($koneksi,$sql1); // Menjalankan query insert
        if ($q1){
            $sukses = "Data Berhasil Disimpan"; // Jika query berhasil, tampilkan pesan sukses
        } else{
            $error = "Gagal Memasukkan Data"; // Jika query gagal, tampilkan pesan error
        }
    } else{
        $error  = "Mohon Mengisi Semua Data"; // Menampilkan error jika ada kolom yang kosong
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .mx-auto {width:800px}
        .card {margin-top: 10px;}
    </style>
</head>
<body>
   <div class="mx-auto">
    <!-- Perintah Memasukkan Data -->
    <div class="card">
  <div class="alert alert-primary" role="alert">
    <center><b> Data Karyawan Sinarmas</b></center>
  </div>
  <div class="card-body">
<!-- Menampilkan Pesan Error/Sukses -->
    <?php
        if ($error){ ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
        </div>
         <?php
            header("refresh:10;url=index.php");
        }  
        ?>
        <?php
        if ($sukses){ ?>
            <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
            </div>
        <?php
                header("refresh:10;url=index.php");
        }  
        ?>
    <form action="" method="POST">
        <div class="mb-3 row">
  <label for="nama_karyawan" class="col-sm-2 col-form-label">Nama</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" value="<?php echo $nama_karyawan?>"> <!-- Input field untuk memasukkan nama karyawan -->
  </div>
</div>

    <div class="mb-3 row">
  <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
  <div class="col-sm-10">
    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin"> <!-- Dropdown untuk memilih jenis kelamin -->
        <option value="">- Pilih Jenis Kelamin -</option>
        <option value="L">Laki-Laki</option>
        <option value="P">Perempuan</option>
    </select>
  </div>
</div>

    <div class="mb-3 row">
  <label for="divisi_karyawan" class="col-sm-2 col-form-label">Divisi</label>
  <div class="col-sm-10">
    <select class="form-control" id="divisi_karyawan" name="divisi_karyawan">
        <option value="">- Pilih Divisi -</option>
        <option value="BTG">Boiler Turbine Generator</option>
        <option value="WTP">Water Treatment Plant</option>
        <option value="CHS">Coal Handling System</option>
        <option value="ADMIN">Administrasi</option>
        <option value="MAINTENANCE">Maintenance</option>
        <option value="SBO">Support Boiler Operation</option>
    </select>
  </div>
</div>

    <div class="mb-3 row">
  <label for="position" class="col-sm-2 col-form-label">Position</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="position" name="position" value="<?php echo $position?>">
  </div>
</div>
    <div class="col-12">
        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary"/>
</form>

</div>
   </div> 
<!-- Perintah Mengeluarkan Data -->
<div class="card">
  <div class="card-header text-white bg-danger">
    Data Karyawan
  </div>
  <div class="card-body">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Divisi</th>
                <th scope="col">Position</th>
            </tr>
            <tbody>
                <?php
                $sql2 ="SELECT *FROM karyawan ORDER BY id_karyawan desc"; // Query mengambil semua data karyawan, urut dari yang terbaru
                $sq2 = mysqli_query($koneksi, $sql2); // Menjalankan query select
                $urut = 1; // Variabel untuk nomor urut tabel
                while ($r2= mysqli_fetch_array($sq2)) { // Mengambil setiap baris data dari hasil query
                    // Menyimpan data dari setiap kolom tabel ke variabel
                    $id_karyawan        =$r2 ['id_karyawan'];
                    $nama_karyawan      =$r2 ['nama_karyawan'];
                    $jenis_kelamin      =$r2 ['jenis_kelamin'];
                    $divisi_karyawan    =$r2 ['divisi_karyawan'];
                    $position           =$r2 ['position'];

                ?>
                <tr>
                   <th scope="row"><?php echo $urut++ ?></th> 
                   <td scope="row"><?php echo $nama_karyawan ?></td>
                   <td scope="row"><?php echo $jenis_kelamin ?></td>
                   <td scope="row"><?php echo $divisi_karyawan ?></td>
                   <td scope="row"><?php echo $position ?></td>
                   <td scope="row"><?php echo $nama_karyawan ?>
                   <td scope="row">
                    <!-- Tombol Edit: mengarahkan ke halaman index dengan parameter op=edit -->
                        <a href="index.php?op=edit&id_karyawan=<?php echo $id_karyawan ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                    <!-- Tombol Delete: menghapus data dengan konfirmasi popup -->    
                        <a href="index.php?op=delete&id_karyawan=<?php echo $id_karyawan ?>" onclick="return confirm('Apakah Yakin Ingin Menghapus Data ?')"><button type="button" class="btn btn-danger">Delete</button></a>
                    </td>
                </tr>
                
                <?php
                }
                ?>
            </tbody>
        </thead>
    </table>
    </div>
</div>

</body>
</html>