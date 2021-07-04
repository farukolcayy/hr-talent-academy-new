<?php

$link = mysqli_connect("localhost", "hrtalent_basvuru", "!hrt!2021!", "hrtalent_basvuru");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security

$email = mysqli_real_escape_string($link, $_POST['email']);

$sql = "call changeStartQuiz('" . $email . "')";

mysqli_set_charset($link, "utf8");
if (mysqli_query($link, $sql)) {
    echo "Sonuçlar Kaydedildi";
} else {
    echo 'MySQL Hatası: ' . mysql_error();
}

// Close connection
mysqli_close($link);
