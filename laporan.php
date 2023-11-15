<?php include 'template/header.php';?>

  <div class="col-md-9 mb-2">
    <div class="row">

    <!-- table barang -->
    <div class="col-md-12 mb-2">
        <div class="card">
        <div class="card-header bg-purple">
                <div class="card-tittle text-white"><i class="fa fa-table"></i> <b>Data Laporan</b></div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm dt-responsive nowrap" id="table" width="100%">
                        <thead class="thead-purple">
                            <tr>
                            <th>No</th>
                            <th>Grup</th>
                            <th>Shift</th>
                            <th>Total Tonase</th>
                            <th>Tanggal Shift</th>
                            <th>Publish</th>
                            <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1;
                        $data_barang = mysqli_query($conn,"SELECT * FROM laporan");
                        while($d = mysqli_fetch_array($data_barang)){
                            ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['grup']; ?></td>
                            <td><?php echo $d['shift']; ?></td>
                            <td><?php echo $d['total_tonase']; ?></td>
                            <td><?php echo $d['tanggal_shift']; ?></td>
                            <td><?php echo $d['tanggal']; ?></td>
                         
                            <td>
                            <a class="btn btn-primary btn-xs" href="detail_laporan.php?id=<?php echo $d['id_laporan']; ?>">
                                <i class="fa fa-pen fa-xs"></i> detail</a>
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
