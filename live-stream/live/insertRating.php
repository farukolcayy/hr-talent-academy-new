
<?php

$link = mysqli_connect("localhost", "hrtalent_live", "!hrt!2021!", "hrtalent_live");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security
$liveName = mysqli_real_escape_string($link, $_REQUEST['liveName']);
$emailAddress = mysqli_real_escape_string($link, $_REQUEST['emailAddress']);
$programSubject = mysqli_real_escape_string($link, $_REQUEST['programSubjectRating']);
$instructor = mysqli_real_escape_string($link, $_REQUEST['instructorRating']);
$ratingScore = mysqli_real_escape_string($link, $_REQUEST['ratingScore']);
$ratingComment = mysqli_real_escape_string($link, $_REQUEST['ratingComment']);

if (!empty($emailAddress) && !empty($programSubject) && !empty($instructor) && !empty($ratingScore)) {

    $sql = "INSERT INTO live_rating (liveName, emailAddress,programSubject,instructor,ratingScore,ratingComment) VALUES ('$liveName', '$emailAddress', '$programSubject', '$instructor', '$ratingScore','$ratingComment')";

    mysqli_set_charset($link, "utf8");
    if (mysqli_query($link, $sql)) {
        echo "Geri Bildiriminiz Kaydedildi";
    } else {
        echo "Hata: Geri Bildiriminiz İletilemedi!";
    }
} else {
    echo "Tüm alanlar doldurulmalı!";
}

// Close connection
mysqli_close($link);


?>