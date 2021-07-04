<?php

$link = mysqli_connect("localhost", "hrtalent_live", "!hrt!2021!", "hrtalent_live");


if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$question = mysqli_real_escape_string($link, $_REQUEST['_question']);
$questionOptions = mysqli_real_escape_string($link, $_REQUEST['_questionOptions']);
$questionAnswer = mysqli_real_escape_string($link, $_REQUEST['_questionAnswer']);


$sql = "INSERT INTO oturum_sinav_soru (question,questionOption,answer) VALUES ('$question','$questionOptions','$questionAnswer')";

mysqli_set_charset($link, "utf8");
if (mysqli_query($link, $sql)) {
    echo "Bilgiler Güncellendi";
} else {
    echo "Bilgiler güncellenemedi!";
}

// Close connection
mysqli_close($link);
