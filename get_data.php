<?php
// Sambungkan ke database
$conn = mysqli_connect("localhost", "root", "", "dispatcher");

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Dapatkan nilai "nama_dt" dari permintaan
$nama_dt = $_GET['nama_dt'];

// Buat query MySQL untuk mengambil data sesuai dengan nama_dt
$query = "SELECT 
            CONCAT(Nama_loading, '') AS loading, 
            CONCAT(Nama_dumping, '') AS dumping 
          FROM setting_fleet 
          WHERE Id_setting = (
            SELECT id_setting_fleet 
            FROM setting_dt 
            WHERE id_setting_dt = '$nama_dt'
          ) 
          UNION 
          SELECT 
            CONCAT(Loading_pengalihan_1, '') AS loading, 
            CONCAT(Dumping_pengalihan_1, '') AS dumping 
          FROM setting_fleet 
          WHERE Id_setting = (
            SELECT id_setting_fleet 
            FROM setting_dt 
            WHERE id_setting_dt = '$nama_dt'
          ) 
          UNION 
          SELECT 
            CONCAT(Loading_pengalihan_2, '') AS loading, 
            CONCAT(Dumping_pengalihan_2, '') AS dumping 
          FROM setting_fleet 
          WHERE Id_setting = (
            SELECT id_setting_fleet 
            FROM setting_dt 
            WHERE id_setting_dt = '$nama_dt'
          );";
$result = mysqli_query($conn, $query);

// Buat query MySQL untuk mengambil data jenis pengukuran
$pengukuran = "SELECT setting_fleet.Pengukuran FROM setting_dt 
               INNER JOIN setting_fleet ON setting_dt.id_setting_fleet = setting_fleet.Id_setting 
               WHERE id_setting_dt = '$nama_dt'";
$result_ukur = mysqli_query($conn, $pengukuran);

$row1 = mysqli_fetch_assoc($result_ukur);
$jenisPengukuran = $row1['Pengukuran']; // Perbaikan kunci kolom menjadi 'Pengukuran'

$data = array();
$data[] = $row1;


if (mysqli_num_rows($result) > 0) {
    // Tangani data yang ditemukan
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
   
}

mysqli_close($conn);

// Mengirimkan data sebagai respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
