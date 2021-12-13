
<?php

$nameSurname = $_POST['nameSurname'];
$question = $_POST['question'];
$streamId = $_POST['streamId'];


$conn = new PDO('mysql:host=localhost;dbname=hrtalent_live;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

$query = $conn->prepare("INSERT INTO $streamId SET nameSurname= ?,question= ?");

$insert = $query->execute(array($nameSurname, $question));

if ($insert) {
    echo "Sorunuz iletildi";
} else {
    echo "Hata: Sorunuz iletilemedi!";
}


?>