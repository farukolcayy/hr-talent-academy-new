<?php

$email = $_POST['emailAddress'];
$password = $_POST['password'];
$dataUser = array();

$data = array();

try {

    $conn = new PDO('mysql:host=localhost;dbname=hrtalent_live;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

    $query = $conn->prepare("SELECT Id,nameSurname,emailAddress,password,token,isLogin FROM canli_yayin_kullanicilar where emailAddress=? and password=? GROUP by emailAddress");
    $query->execute(array($email, $password));

    if ($query->rowCount()) {
        foreach ($query as $row) {
            array_push($dataUser, $row);
        }
    }

    $data['status'] = 'ok';
    $data['result'] = $dataUser[0];
    echo json_encode($data);

} catch (PDOexception $exe) {

    $data['status'] = 'err';
    $data['result'] = '';
    echo json_encode($data);

}

    