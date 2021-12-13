
<?php

$liveName = $_POST['liveName'];
$emailAddress = $_POST['emailAddress'];
$programSubject = $_POST['programSubjectRating'];
$instructor = $_POST['instructorRating'];
$ratingScore = $_POST['ratingScore'];
$ratingComment = $_POST['ratingComment'];


$conn = new PDO('mysql:host=localhost;dbname=hrtalent_live;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

$query = $conn->prepare("INSERT INTO live_rating SET 
liveName= ?,
emailAddress= ?,
programSubject=?,
instructor=?,
ratingScore=?,
ratingComment=?");

$insert = $query->execute(array($liveName,$emailAddress,$programSubject,$instructor,$ratingScore,$ratingComment));

if ($insert) {
    echo "Geri Bildiriminiz Kaydedildi";
} else {
    echo "Hata: Geri Bildiriminiz İletilemedi!";
}


?>