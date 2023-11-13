<?php include 'template/header.php';?>
<?php
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM laporan WHERE id_laporan=$id");
// var_dump($result);die;
while($data = mysqli_fetch_array($result))
{
    $shift = $data['shift'];
    $grup = $data['grup'];
    $tanggal = $data['tanggal_shift'];
    $total = $data['total_tonase'];
    
   

}
?>


  <div class="col-md-9 mb-2">
    <div class="row">

    <!-- barang -->
    <div class="col-md-12 mb-2">
        

        <div class="card">
        <div class="card-header bg-purple">
                <div class="card-tittle text-white"><i class="fa fa-shopping-cart"></i> <b>Edit Unit</b></div>
            </div>
            <div class="card-body">
            
            <div class="form-row">
                <div class="form-group col-md-4">
                   <input type="text" class="form-control" name="tgl_input" value="<?php echo  $tanggal;?>" readonly>
                </div>
                <div class="form-group col-md-4">
                   <input type="text" class="form-control" name="tgl_input" value="<?php echo  $grup;?>" readonly>
                </div>
                <div class="form-group col-md-4">
                   <input type="text" class="form-control" name="tgl_input" value="<?php echo  $shift;?>" readonly>
                </div>
            </div>

            <hr>

            <div class= col-md-4>
                <b>total tonase</b> : <?php echo $total?>
            </div>
           </div>
            </div>
        </div>
    </div>
    <!-- end barang -->

    </div><!-- end row col-md-9 -->
  </div>
<?php include 'template/footer.php';?>
