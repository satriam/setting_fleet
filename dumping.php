<?php include 'template/header.php';?>

<?php 
if(!empty($_POST['add_barang'])){
    // $id = $_POST['id_barang'];
    $unit = $_POST['unit'];
    $mitra = $_POST['mitra'];
    // $tgl = $_POST['tgl_input'];
    
    mysqli_query($conn,"insert into unit_exca values('','$unit','$mitra')")
    or die(mysqli_error($conn));
    echo '<script>window.location="unit.php"</script>';
}

?>

  <div class="col-md-9 mb-2">
  
    <div class="row">
    
    <!-- barang -->
  
    
  <div class="col-md-12 mb-3">
  <?php 
	include 'config.php';
	if(!empty($_GET['id'])){
		$id= $_GET['id'];
		$hapus_data = mysqli_query($conn, "DELETE FROM unit_exca WHERE id_unit ='$id'");
		// echo '<script>window.location="unit.php"</script>';
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>YESS!</strong> data berhasil dihapus.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>";
	}

?>
</div>
<div class="col-md-12 mb-3">
        <div class="card">
    
        <div class="card-header bg-purple">
     
                <div class="card-tittle text-white"><i class="fa fa-plus-square"></i> <b>Tambah Unit Exca</b></div>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-row">

                        <div class="form-group col-md-6">
                        <label><b>Loading</b></label>
                        <input type="text" name="loading" class="form-control" required>
                        </div>
                    
                        <div class="form-group col-md-6">
                                    <button name="add_barang" value="simpan" class="btn btn-purple" type="submit">
                                    <i class="fa fa-plus mr-2"></i>Tambah</button>
                                
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
                <div class="card-tittle text-white"><i class="fa fa-table"></i> <b>Data Unit Exca</b></div>
            </div>
            <div class="card-body">
            <table class="table table-striped table-bordered table-sm dt-responsive nowrap" id="table_data" width="100%">
                        <thead class="thead-purple">
                            <tr>
                                <th>No</th>
                                <th>Nama Unit Exca</th>
                                <th>Mitra</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        $data_barang = mysqli_query($conn,"select * from unit_exca order by id_unit DESC");
                        while($d = mysqli_fetch_array($data_barang)){
                            ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['unit']; ?></td>
                            <td><?php echo $d['mitra']; ?></td>
                            <td>
                                <a class="btn btn-primary btn-xs" href="edit.php?id=<?php echo $d['id_unit']; ?>">
                                <i class="fa fa-pen fa-xs"></i> Edit</a>
                                <a class="btn btn-danger btn-xs" href="?id=<?php echo $d['id_unit']; ?>" 
                                onclick="javascript:return confirm('Hapus Data Unit Exca ?');">
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
    
    </div><!-- end row col-md-9 -->
  </div>
  
 
<?php include 'template/footer.php';?>
