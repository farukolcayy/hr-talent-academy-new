<?php

$emailAddress = $_POST['emailAddress'];
$token = $_POST['token'];
$isLogin = $_POST['isLogin'];

$data = array();

$conn = new PDO(-);
$query = $conn->prepare("UPDATE canli_yayin_kullanicilar SET token=?, isLogin=?, loginDate=? WHERE emailAddress=? ");

$insert = $query->execute(array($token, $isLogin, date("Y-m-d H:i:s"), $emailAddress));

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
