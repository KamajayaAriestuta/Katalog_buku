<?php
include('../koneksi/koneksi.php');
if ((isset($_GET['aksi'])) && (isset($_GET['data']))) {
  if ($_GET['aksi'] == 'hapus') {
    $id_kategori_blog = $_GET['data'];
    //hapus kategori blog
    $sql_dh = "delete from `kategori_blog` 
		where `id_kategori_blog` = '$id_kategori_blog'";
    mysqli_query($koneksi, $sql_dh);
  }
}
?>


<!DOCTYPE html>
<html>

<head>
  <?php include("includes/head.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include("includes/header.php") ?>

    <?php include("includes/sidebar.php") ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3><i class="fas fa-address-book"></i> Kategori blog</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"> Kategori blog</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-list-ul"></i> Daftar Kategori blog</h3>
            <div class="card-tools">
              <a href="tambahkategoriblog.php" class="btn btn-sm btn-info float-right"><i class="fas fa-plus"></i> Tambah Kategori blog</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12">
              <form method="get" action="kategoriblog.php">
                <div class="row">
                  <div class="col-md-4 bottom-10">
                    <input type="text" class="form-control" id="kata_kunci" name="katakunci">
                  </div>
                  <div class="col-md-5 bottom-10">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-search"></i> Search</button>
                  </div>
                </div><!-- .row -->
              </form>
            </div><br>
            <div class="col-sm-12">
              <?php if (!empty($_GET['notif'])) { ?>
                <?php if ($_GET['notif'] == "tambahberhasil") { ?>
                  <div class="alert alert-success" role="alert">
                    Data Berhasil Ditambahkan</div>
                <?php } else if ($_GET['notif'] == "editberhasil") { ?>
                  <div class="alert alert-success" role="alert">
                    Data Berhasil Diubah</div>
                <?php } else if ($_GET['notif'] == "hapusberhasil") { ?>
                  <div class="alert alert-success" role="alert">
                    Data Berhasil Dihapus</div>
                <?php } ?>
              <?php  } ?>
            </div>

          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th width="80%">Kategori blog</th>
                <th width="15%">
                  <center>Aksi</center>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $batas = 2;
              if (!isset($_GET['halaman'])) {
                $posisi = 0;
                $halaman = 1;
              } else {
                $halaman = $_GET['halaman'];
                $posisi = ($halaman - 1) * $batas;
              }

              $sql_k = "SELECT `id_kategori_blog`,`kategori_blog` FROM `kategori_blog` ";
              if (isset($_GET["katakunci"])) {
                $katakunci_kategori = $_GET["katakunci"];
                $sql_k .= " where `kategori_blog` LIKE '%$katakunci_kategori%'";
              }
              $sql_k .= " ORDER BY `kategori_blog` limit $posisi, $batas";

              $query_k = mysqli_query($koneksi, $sql_k);
              $no = $posisi + 1;
              // $no = 1;
              while ($data_k = mysqli_fetch_row($query_k)) {
                $id_kategori_blog = $data_k[0];
                $kategori_blog = $data_k[1];
              ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $kategori_blog; ?></td>
                  <td align="center">
                    <a href="editkategoriblog.php?data=<?php echo $id_kategori_blog; ?>" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> Edit</a>
                    <a href="javascript:if(confirm('Anda yakin ingin menghapus data <?php echo $kategori_blog; ?>?'))window.location.href =  
                      'kategoriblog.php?aksi=hapus&data=<?php echo $id_kategori_blog; ?>&notif=hapusberhasil'" " class=" btn btn-xs btn-warning"><i class="fas fa-trash"></i> Hapus</a>
                  </td>
                </tr>
              <?php $no++;
              } ?>


            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <?php
        //hitung jumlah semua data 
        $sql_jum = "select `id_kategori_blog`, `kategori_blog` from `kategori_blog` ";
        if (isset($_GET["katakunci"])) {
          $katakunci_kategori = $_GET["katakunci"];
          $sql_jum .= " where `kategori_blog` LIKE '%$katakunci_kategori%'";
        }
        $sql_jum .= " order by `kategori_blog`";
        $query_jum = mysqli_query($koneksi, $sql_jum);
        $jum_data = mysqli_num_rows($query_jum);
        $jum_halaman = ceil($jum_data / $batas);
        ?>

        <div class="card-footer clearfix">
          <ul class="pagination pagination-sm m-0 float-right">
            <!-- <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li> -->
            <ul class="pagination pagination-sm m-0 float-right">
              <?php
              if ($jum_halaman == 0) {
                //tidak ada halaman
              } else if ($jum_halaman == 1) {
                echo "<li class='page-item'><a class='page-link'>1</a></li>";
              } else {
                $sebelum = $halaman - 1;
                $setelah = $halaman + 1;
                if (isset($_GET["katakunci"])) {
                  $katakunci_kategori = $_GET["katakunci"];
                  if ($halaman != 1) {
                    echo "<li class='page-item'>
                  <a class='page-link' 
                  href='kategoriblog.php?katakunci=$katakunci_kategori&halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link' 
                  href='kategoriblog.php?katakunci=$katakunci_kategori&halaman=$sebelum'>«</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i != $halaman) {
                      echo "<li class='page-item'><a class='page-link' 
                    href='kategoriblog.php?katakunci=$katakunci_kategori&halaman=$i'>$i</a></li>";
                    } else {
                      echo "<li class='page-item'><a class='page-link'>$i</a></li>";
                    }
                  }
                  if ($halaman != $jum_halaman) {
                    echo "<li class='page-item'>
                    <a class='page-link'  
                    href='kategoriblog.php?katakunci=$katakunci_kategori&halaman=$setelah'>»</a></li>";
                    echo "<li class='page-item'><a class='page-link' 
                    href='kategoriblog.php?katakunci=$katakunci_kategori&halaman=$jum_halaman'>
                    Last</a></li>";
                  }
                } else {
                  if ($halaman != 1) {
                    echo "<li class='page-item'><a class='page-link' 
                  href='kategoriblog.php?halaman=1'>First</a></li>";
                    echo "<li class='page-item'><a class='page-link' 
                  href='kategoriblog.php?
                  halaman=$sebelum'>«</a></li>";
                  }
                  for ($i = 1; $i <= $jum_halaman; $i++) {
                    if ($i > $halaman - 5 and $i < $halaman + 5) {
                      if ($i != $halaman) {
                        echo "<li class='page-item'><a class='page-link' 
                          href='kategoriblog.php?katakunci=$katakunci_kategori&halaman=$i'>
                          $i</a></li>";
                      } else {
                        echo "<li class='page-item'>
                          <a class='page-link'>$i</a></li>";
                      }
                    }
                  }

                  if ($halaman != $jum_halaman) {
                    echo "<li class='page-item'><a class='page-link' 
                    href='kategoriblog.php?halaman=$setelah'>
                    »</a></li>";
                    echo "<li class='page-item'><a class='page-link' 
                    href='kategoriblog.php?
                    halaman=$jum_halaman'>Last</a></li>";
                  }
                }
              } ?>
            </ul>

          </ul>

        </div>
    </div>
  </div>
  <!-- /.card -->

  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("includes/footer.php") ?>

  </div>
  <!-- ./wrapper -->

  <?php include("includes/script.php") ?>
</body>

</html>