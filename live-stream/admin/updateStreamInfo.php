<?php

$streamLink = $_POST['streamLink'];
$instructorSelect = $_POST['instructorSelect'];

$link = mysqli_connect("localhost", "hrtalent_live", "!hrt!2021!", "hrtalent_live");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security

$streamLink2=str_replace("'",'"',$streamLink);

$sql = "UPDATE canli_yayin SET streamLink='$streamLink2',instructorId=1 WHERE Id=1";

mysqli_set_charset($link, "utf8");
if (mysqli_query($link, $sql)) {
    echo "Bilgiler Güncellendi";
} else {
    //echo mysqli_error($link);
    echo "Bilgiler Güncellenemedi!";
}

// Close connection
mysqli_close($link);
