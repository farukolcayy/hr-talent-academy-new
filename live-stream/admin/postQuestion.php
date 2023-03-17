<?php

$question = $_POST['_question'];
$questionOptions = $_POST['_questionOptions'];
$questionAnswer = $_POST['_questionAnswer'];

$conn = new PDO(-);

$query = $conn->prepare("INSERT INTO oturum_sinav_soru SET question= ?,questionOption= ?,answer= ?");

$insert = $query->execute(array($question, $questionOptions,$questionAnswer));

if ($insert) {
    echo "Sorunuz iletildi";
} else {
    echo "Hata: Sorunuz iletilemedi!";
}


