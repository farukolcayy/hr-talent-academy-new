
<?php

$link = mysqli_connect("localhost", "hrtalent_live", "!hrt!2021!", "hrtalent_live");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security

$nameSurname = mysqli_real_escape_string($link, $_REQUEST['nameSurname']);
$question = mysqli_real_escape_string($link, $_REQUEST['question']);
$streamId = mysqli_real_escape_string($link, $_REQUEST['streamId']);

if (!empty($nameSurname) && !empty($question)) {

    $sql = "INSERT INTO $streamId (nameSurname, question) VALUES ('$nameSurname', '$question')";

    mysqli_set_charset($link, "utf8");
    if (mysqli_query($link, $sql)) {
        echo "Sorunuz iletildi";
    } else {
        echo "Hata: Sorunuz iletilemedi!";
    }
} else {
    echo "Tüm alanlar doldurulmalı!";
}

// Close connection
mysqli_close($link);


?>