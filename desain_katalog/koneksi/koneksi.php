<?php
$koneksi = mysqli_connect("sql110.epizy.com", "epiz_29940974", "jS2J25HKULcb1Cq", "epiz_29940974_katalog_buku");

if (!$koneksi) {
    die("Error koneksi :" . mysqli_connect_errno());
}
