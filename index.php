<?php include 'template/header.php'; ?>

<div class="col-md-9 mb-2">

<?php
if(!empty($_POST['add_data'])){
    if(isset($_POST['DT']) && isset($_POST['loading']) && isset($_POST['dumping']) && isset($_POST['jarak']) && isset($_POST['tonase']) && isset($_POST['kode'])){
        $unit = $_POST['id_exca'];
        $mitra = $_POST['dt'];

        // Periksa apakah kedua data sudah dipilih
        if (empty($unit) || empty($mitra)) {
            echo "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>NOOO!</strong> Harap pilih Exca dan Dump Truck terlebih dahulu.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            ";
        } else {
            // Data belum ada, lakukan penyisipan
            $cek = mysqli_query($conn, "SELECT * FROM setting_dt WHERE id_setting_fleet = '$unit' AND Nama_DT = '$mitra'");
            if (mysqli_num_rows($cek) > 0) {
                echo "
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>NOOO!</strong> Data yang diinput sudah ada.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                ";
            } else {
                mysqli_query($conn, "insert into setting_dt values('', '$unit', '$mitra')")
                or die(mysqli_error($conn));
                
                echo '<script>window.location="setting_dt.php"</script>';
                echo "
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>NOOO!</strong> Data yang diinput sudah ada.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                ";
            }
        }
    } else {
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>NOOO!</strong> Harap pilih Exca dan Dump Truck terlebih dahulu.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        ";
    }
}
?>
    <div class="row">

        <!-- barang -->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header bg-purple">
                    <div class="card-title text-white"><i class="fa fa-shopping-cart"></i> <b>Tambah Jarak</b></div>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><b>Dump Truck</b></label>
                                <div class="form-select">
                                    <select name="DT" id="dt" class="form-control">
                                        <option disabled selected> Pilih </option>
                                        <?php
                                        $query = mysqli_query($conn, "SELECT id_setting_dt,Nama_DT from setting_dt");
                                        while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                            <option value="<?=$data['id_setting_dt'];?>"><?php echo $data['Nama_DT'];?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" id="selectedDT" name="selectedDT">
                           
                            <div class="form-group col-md-6">
                                <label><b>Nama Loading</b></label>
                                <div class="form-select">
                                <select name="loading" id="loading" class="form-control">
                                    <option disabled selected> Pilih </option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label><b>Nama Dumping</b></label>
                                <div class="form-select">
                                <select name="dumping" id="dumping" class="form-control">
                                    <option disabled selected> Pilih </option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label><b>Jarak</b></label>
                                <input type="text" id="jarak" name="jarak" class="form-control" disabled>
                            </div>

                            <div class="form-group col-md-6">
                                <label><b>Tonase</b></label>
                                <div class="input-group">
                                <input type="number" id="tonase" name="tonase" class="form-control" required>
                                <div class="input-group-append">
                                    <button name="add_data" value="simpan" class="btn btn-purple" type="submit">
                                    <i class="fa fa-plus mr-2"></i>Tambah</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end barang -->

        <!-- table barang -->

    <div class="col-md-12 mb-2">
        <div class="card">
        <div class="card-header bg-purple">
                <div class="card-tittle text-white"><i class="fa fa-table"></i> <b>Data Jarak</b></div>
            </div>

            <div class="card-body">
            <?php 
                function generateRandomCode($length = 6) {
                    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $code = '';

                    for ($i = 0; $i < $length; $i++) {
                        $code .= $characters[rand(0, strlen($characters) - 1)];
                    }

                    return $code;
                }

              
                // Cek apakah kode acak sudah ada dalam sesi
                if (!isset($_SESSION['randomCode'])) {
                    // Jika tidak ada, maka hasilkan kode acak baru
                    $_SESSION['randomCode'] = generateRandomCode(6);
                }

                $toko = mysqli_query($conn,"SELECT * FROM fleet_info ");
                if (mysqli_num_rows($toko) > 0) {
                    // Data ditemukan, mengambil data
                    if ($row = mysqli_fetch_assoc($toko)) {
                        $Tanggal = $row['Tanggal'];
                        $Grup = $row['Grup'];
                        $Shift = $row['Shift'];

                    }
                } else {
                    // Tabel kosong, mengatur variabel menjadi null
                    $Tanggal = null;
                    $Grup = null;
                    $Shift = null;
                }
                ?>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                        <input type="text" class="form-control" name="tgl_input" value="<?php echo $_SESSION['randomCode'];?>" readonly>
                        </div>

                        <div class="form-group col-md-3">
                        <input type="text" class="form-control" name="tgl_input" value="<?php echo  $Tanggal;?>" readonly>
                        </div>

              
                        <div class="form-group col-md-3">
                        <input type="text" class="form-control" name="tgl_input" value="<?php echo  $Grup;?>" readonly>
                        </div>
 
        
                        <div class="form-group col-md-3">
                        <input type="text" class="form-control" name="tgl_input" value="<?php echo  $Shift;?>" readonly>
                        </div>
                    </div>
            </div>

            <div class="card-body">
            <table class="table table-striped table-bordered table-sm dt-responsive nowrap" id="table_data" width="100%">
                        <thead class="thead-purple">
                            <tr>
                                <th>No</th>
                                <th>Nama Loading</th>
                                <th>Nama Dumping</th>
                                <th>Jarak</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        $data_barang = mysqli_query($conn,"select * from temporary order by id_temporary DESC");
                        while($d = mysqli_fetch_array($data_barang)){
                            ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['Nama_loading']; ?></td>
                            <td><?php echo $d['Nama_dumping']; ?></td>
                            <td><?php echo $d['jarak']; ?></td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="edit_jarak.php?id=<?php echo $d['Id_jarak']; ?>">
                                <i class="fa fa-pen fa-xs"></i> Edit</a>
                                <a class="btn btn-danger btn-xs" href="?id=<?php echo $d['Id_jarak']; ?>" 
                                onclick="javascript:return confirm('Hapus Data Jarak ?');">
                                <i class="fa fa-trash fa-xs"></i> Hapus</a>
                            </td>
						</tr>
                        <?php }?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end table barang -->
    </div>
</div>


<script>
    // Fungsi untuk mengambil jarak berdasarkan nama loading dan nama dumping
    function getJarak() {
        var nama_loading = document.getElementById('loading').value;
        var nama_dumping = document.getElementById('dumping').value;

        // Kirim permintaan AJAX ke server untuk mengambil data jarak
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_test.php?nama_loading=' + nama_loading + '&nama_dumping=' + nama_dumping, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var jarak = xhr.responseText;
                document.getElementById('jarak').value = jarak;
            }
        };

        xhr.send();
    }

    // Memantau perubahan pada input
    document.getElementById('loading').addEventListener("change", getJarak);
    document.getElementById('dumping').addEventListener("change", getJarak);

    // Memanggil fungsi getJarak saat halaman dimuat
    getJarak();
</script>

<script>
    // Dapatkan elemen select
    var selectElement = document.getElementById('dt');
    var loadingSelect = document.getElementById('loading');
    var dumpingSelect = document.getElementById('dumping');

    // Tambahkan event listener untuk mengidentifikasi perubahan nilai pada elemen "dt"
    selectElement.addEventListener('change', function() {
        // Dapatkan nilai yang dipilih
        var selectedValue = selectElement.value;

        // Kirim permintaan ke server untuk mengambil data sesuai dengan nilai yang dipilih
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_data.php?nama_dt=' + selectedValue, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Parsing data yang diterima dari server
                var data = JSON.parse(xhr.responseText);

                // Mengisi elemen "loadingSelect" dengan opsi yang diterima
                loadingSelect.innerHTML = ''; // Menghapus opsi yang sudah ada

                var defaultOption = document.createElement('option');
                defaultOption.text = 'Pilih';
                defaultOption.value = '';
                loadingSelect.appendChild(defaultOption);

                for (var i = 0; i < data.length; i++) {
                    var option = document.createElement('option');
                    option.text = data[i].loading;
                    option.value = data[i].loading;
                    loadingSelect.appendChild(option);
                }

                 // Mengisi elemen "dumpingSelect" dengan opsi yang diterima
                 dumpingSelect.innerHTML = ''; // Menghapus opsi yang sudah ada

                    var defaultOptionDumping = document.createElement('option');
                    defaultOptionDumping.text = 'Pilih Dumping';
                    defaultOptionDumping.value = '';
                    dumpingSelect.appendChild(defaultOptionDumping);

                    for (var i = 0; i < data.length; i++) {
                        var option = document.createElement('option');
                        option.text = data[i].dumping; // Sesuaikan dengan nama kolom yang sesuai
                        option.value = data[i].dumping; // Sesuaikan dengan nama kolom yang sesuai
                        dumpingSelect.appendChild(option);
                    }
            }
        };

        xhr.send();
    });
</script>



<?php include 'template/footer.php'; ?>
