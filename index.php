<?php include 'template/header.php'; ?>

<div class="col-md-9 mb-2">

<?php
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

 $tonase = mysqli_query($conn,"SELECT tanggal, SUM(temporary.tonase) AS Total_Tonase FROM temporary where tanggal = '$Tanggal' && Grup = '$Grup' && Shift = '$Shift';");
 
 if(mysqli_num_rows($tonase)>0){
    if ($row = mysqli_fetch_assoc($tonase)) {
        $tt = $row['Total_Tonase'];
        // var_dump($tt);die;
        
    }
 }


  
if(!empty($_POST['add_data'])){
    if(isset($_POST['DT']) && isset($_POST['loading']) && isset($_POST['dumping']) && isset($_POST['jarak']) && isset($_POST['jam'])&& isset($_POST['waktu'])){
        $unit = $_POST['DT'];
        $lp = $_POST['loading'];
        $dp = $_POST['dumping'];
        $jarak = $_POST['jarak'];
        $tonase = $_POST['tonase'];
        $jam = $_POST['jam'];
        $waktu = $_POST['waktu'];
        $exca = $_POST['exca'];
        $bb = $_POST['bb'];
        $ukur = $_POST['pengukuran'];
        $status = $_POST['status'];
        $lokasi = $_POST['lokasi'];                     

        // Periksa apakah kedua data sudah dipilih
        if (empty($unit) || empty($lp) || empty($dp)) {
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
            // $cek = mysqli_query($conn, "SELECT * FROM temporary WHERE id_setting_fleet = '$unit' AND Nama_DT = '$unit'");
            // if (mysqli_num_rows($cek) > 0) {
            //     echo "
            //     <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            //         <strong>NOOO!</strong> Data yang diinput sudah ada.
            //         <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            //             <span aria-hidden='true'>&times;</span>
            //         </button>
            //     </div>
            //     ";
            // }else{
                mysqli_query($conn, "insert into temporary values('', '$Tanggal','$Shift','$Grup', '$unit','$tonase','$lp','$dp','$jarak','$bb','$lokasi','$ukur','$status','$jam','$waktu',NULL)")
                or die(mysqli_error($conn));
                mysqli_query($conn, "insert into detail_input values('', '$Tanggal','$Shift','$Grup', '$unit','$exca','$tonase','$lp','$dp','$jarak','$bb','$lokasi','$ukur','$status','$jam','$waktu',NULL)")
                or die(mysqli_error($conn));
          
                
                echo '<script>window.location="index.php"</script>';
                echo "
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>YESS!</strong> WKWKWKWKWK.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                ";
            
        // }
    }
    } else {

        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>NOOO!</strong> SERVER ERROR.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        ";
    }
}


//simpan info
if(!empty($_POST['simpan_laporan'])){
    $cek = mysqli_query($conn, "SELECT * FROM laporan WHERE grup = '$Grup' AND shift = '$Shift' AND tanggal_shift ='$Tanggal'");
    $cek2 = mysqli_query($conn, "SELECT * FROM temporary");
    if (mysqli_num_rows($cek) > 0) {
        // var_dump($cek);die;
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>NOOO!</strong> Data yang diinput Shift saat ini sudah ada.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        ";
    }else{
        if(mysqli_num_rows($cek2)>0){
            mysqli_query($conn, "insert into laporan values('','$Grup','$Shift','$tt','$Tanggal',NULL)")
            or die(mysqli_error($conn));
        
            mysqli_query($conn, "DELETE FROM temporary")
            or die(mysqli_error($conn));
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>YESS!</strong> DATA BERHASIL TERSIMPAN.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            ";
        }else{
            echo "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>NOO!</strong> DATA KOSONG!.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            ";
    }
}
}


?>
    <div class="row">

        <!-- barang -->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header bg-purple">
                    <div class="card-title text-white"><i class="fa fa-plus-square"></i> <b>Tambah Jarak</b></div>
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
                                        $query = mysqli_query($conn, "SELECT Nama_DT from setting_dt");
                                        while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                            <option value="<?=$data['Nama_DT'];?>"><?php echo $data['Nama_DT'];?></option>
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
                                <input type="text" id="jarakk" name="jarak" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label><b>Jam Dumping</b></label>
                                <input type="time"  name="jam" class="form-control" >
                            </div>
                            <div class="form-group col-md-6">
                                <label><b>Waktu</b></label>
                                <input type="number"  name="waktu" class="form-control" >
                            </div>
                            <input type="text"  id="exca" name="exca" class="form-control" hidden>
                            <input type="text"  id="bb" name="bb" class="form-control" hidden>
                            <input type="text"  id="ukur" name="pengukuran" class="form-control"hidden >
                            <input type="text"  id="status" name="status" class="form-control"  hidden>
                            <input type="text"  id="lokasi" name="lokasi" class="form-control"  hidden>
                           
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
               
                ?>
                    <div class="form-row">
                       

                        <div class="form-group col-md-4">
                        <input type="text" class="form-control" name="tgl_input" value="<?php echo  $Tanggal;?>" readonly>
                        </div>

              
                        <div class="form-group col-md-4">
                        <input type="text" class="form-control" name="tgl_input" value="<?php echo  $Grup;?>" readonly>
                        </div>
 
        
                        <div class="form-group col-md-4">
                        <input type="text" class="form-control" name="tgl_input" value="<?php echo  $Shift;?>" readonly>
                        </div>
                    </div>
            </div>

            <div class="card-body">
            <table class="table table-striped table-bordered table-sm dt-responsive nowrap" id="table_data" width="100%">
                        <thead class="thead-purple">
                            <tr>
                                <th>No</th>
                                <th>DT</th>
                                <th>Nama Loading</th>
                                <th>Nama Dumping</th>
                                <th>Jarak</th>
                                <th>Tonase</th>
                                <th>Publish</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        $data_barang = mysqli_query($conn,"select * from temporary where tanggal='$Tanggal'  order by id_temporary DESC");
                        while($d = mysqli_fetch_array($data_barang)){
                            $timestamp_diff = time() - strtotime($d['created']);
    
                            // Check if the data is more than half a day old (43200 seconds = 12 hours)
                            $is_old_data = $timestamp_diff > 43200;
                            ?>
                        <tr>
                            <td><?php echo $no++; ?></td> 
                            <td><?php echo $d['setting_dt']; ?></td> 
                            <td><?php echo $d['loading_point']; ?></td>
                            <td><?php echo $d['dumping_point']; ?></td>
                            <td><?php echo $d['jarak']; ?></td>
                            <td><?php echo $d['tonase']; ?></td>
                            <td><?php echo $d['created']; ?></td>
                            <td>
                               

                                <?php
                                    // Only allow deletion if the data is not more than half a day old
                                    if (!$is_old_data) {
                                        ?>
                                        <a class="btn btn-primary btn-xs" href="edit_jarak.php?id=<?php echo $d['id_temporary']; ?>">
                                        <i class="fa fa-pen fa-xs"></i> Edit</a>

                                        <a class="btn btn-danger btn-xs" href="?id=<?php echo $d['id_temporary']; ?>"
                                        onclick="javascript:return confirm('Hapus Data Jarak ?');">
                                            <i class="fa fa-trash fa-xs"></i> Hapus
                                        </a>
                                        <?php
                                    }
                                    ?>

                            </td>
						</tr>
                        <?php }?>
					</tbody>
                    <tfoot>
                        <tr>
                        <th colspan="5" class="text-right"><b>TOTAL TONASE :</b></th>
                        <th><b><?php echo $tt ?></b></th>
                        <th></th>
                        <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <form method="POST" class="d-flex justify-content-end">
    <button name="simpan_laporan" value="simpan" class="btn btn-purple m-2" type="submit">
        <i class="fa fa-plus mr-2"></i>SIMPAN
    </button>
</form>
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
                document.getElementById('jarakk').value = jarak;
                console.log(jarak);
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
    var tonaseInput = document.getElementById('tonase');
    var excas = document.getElementById('exca');
    var bbs = document.getElementById('bb');
    var ukurs= document.getElementById('ukur');
    var statuss = document.getElementById('status');
    var lokasis = document.getElementById('lokasi');

    // Tambahkan event listener untuk mengidentifikasi perubahan nilai pada elemen "dt"
    selectElement.addEventListener('change', function() {
        // Dapatkan nilai yang dipilih
        var selectedValue = selectElement.value;
        var encodedValue = btoa(selectedValue);

        console.log(encodedValue);
        

        // Kirim permintaan ke server untuk mengambil data sesuai dengan nilai yang dipilih
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_data.php?nama_dt=' + encodedValue, true);

        xhr.onload = function () {
    if (xhr.status === 200) {
        // Parsing data yang diterima dari server
        var data = JSON.parse(xhr.responseText);
        console.log(data);


        var jenisPengukuran = data[0].Pengukuran;
        var exca = data[0].Exca;
        var bb = data[0].Jenis_BB;
        var lokasi = data[0].Lokasi;
        var status = data[0].Status;
        excas.value = exca;
        bbs.value = bb;
        ukurs.value = jenisPengukuran;
        statuss.value = status;
        lokasis.value = lokasi;
      
        
  

        // Mengisi elemen "loadingSelect" dengan opsi yang diterima
        loadingSelect.innerHTML = ''; // Menghapus opsi yang sudah ada

        var defaultOption = document.createElement('option');
        defaultOption.text = 'Pilih';
        defaultOption.value = '';
        loadingSelect.appendChild(defaultOption);

        for (var i = 1; i < data.length; i++) {
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

        for (var i = 1; i < data.length; i++) {
            var option = document.createElement('option');
            option.text = data[i].dumping;
            option.value = data[i].dumping;
            dumpingSelect.appendChild(option);
            console.log(data[i].dumping);
        }
        // console.log(data[i].dumping);

        if (jenisPengukuran === 'Bypass') {
            tonaseInput.disabled = true;
            tonaseInput.value = 0;
        } else {
            tonaseInput.disabled = false;
        }
    }
};

        xhr.send();
    });


    
</script>
<!-- <script>
        $(document).ready(function () {
            $('#exca, #bb, #ukur, #status').hide();
        });
    </script> -->




<?php include 'template/footer.php'; ?>
