<?php

$streamLink = $_POST['streamLink'];
$instructorSelect = intval($_POST['instructorSelect']);
$streamLink2=str_replace("'",'"',$streamLink);

$data = array();

$conn = new PDO('mysql:host=localhost;dbname=hrtalent_live;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');
$query = $conn->prepare("UPDATE canli_yayin SET streamLink=?, instructorId=? WHERE Id=1");

$insert = $query->execute(array($streamLink2, $instructorSelect));

if ($insert) {

    $last_id = $conn->lastInsertId();
    $data['status'] = 'ok';
    $data['result'] = 'Güncelleme Başarılı';
    echo json_encode($data);

} else {

    $data['status'] = 'err';
    $data['result'] = $exe->getMessage();
    echo json_encode($data);
}

