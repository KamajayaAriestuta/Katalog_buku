<?php

include('../koneksi/koneksi.php');
$nama = $_POST['nama'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$level = $_POST['level'];
$lokasi_file = $_FILES['foto']['tmp_name'];
$nama_file = $_FILES['foto']['name'];
$direktori = 'admin/foto/' . $nama_file;

if (empty($nama)) {
   header("Location:tambahuser.php?notif=tambahkosong&
      jenis=nama");
} else if (empty($email)) {
   header("Location:tambahuser.php?notif=tambahkosong&
      jenis=email");
} else if (empty($username)) {
   header("Location:tambahuser.php?notif=tambahkosong&
      jenis=username");
} else if (empty($password)) {
   header("Location:tambahuser.php?notif=tambahkosong&
      jenis=password");
} else if (empty($level)) {
   header("Location:tambahuser.php?notif=tambahkosong&
      jenis=level");
} else {

   $sql = "INSERT INTO `user` 
      (`id_user`,`nama`,`email`,`username`,
   `password`,`level`,`foto`)
      VALUES (NULL,'$nama','$email','$username',
   '$password','$level','$nama_file')";
   //echo $sql;
   mysqli_query($koneksi, $sql);
   $id_buku = mysqli_insert_id($koneksi);

   header("Location:user.php?notif=tambahberhasil");
}
