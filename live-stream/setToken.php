<?php

$link = mysqli_connect("localhost", "hrtalent_live", "!hrt!2021!", "hrtalent_live");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security

$emailAddress = mysqli_real_escape_string($link, $_POST['emailAddress']);
$token = mysqli_real_escape_string($link, $_POST['token']);
$isLogin = mysqli_real_escape_string($link, $_POST['isLogin']);

$sql = "UPDATE canli_yayin_kullanicilar  SET token='$token',isLogin=$isLogin,loginDate=now() where emailAddress='$emailAddress'";

mysqli_set_charset($link, "utf8");
if (mysqli_query($link, $sql)) {
    echo "Sonuçlar Kaydedildi";
} else {
    echo 'MySQL Hatası: ' . mysql_error();
}

// Close connection
mysqli_close($link);
