<?php

$question = $_POST['_question'];
$questionOptions = $_POST['_questionOptions'];
$questionAnswer = $_POST['_questionAnswer'];

$conn = new PDO('mysql:host=localhost;dbname=hrtalent_live;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

$query = $conn->prepare("INSERT INTO oturum_sinav_soru SET question= ?,questionOption= ?,answer= ?");

$insert = $query->execute(array($question, $questionOptions,$questionAnswer));

if ($insert) {
    echo "Sorunuz iletildi";
} else {
    echo "Hata: Sorunuz iletilemedi!";
}


