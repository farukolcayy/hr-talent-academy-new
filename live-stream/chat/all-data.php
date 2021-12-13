<?php

$data = array();
$temp = array();

try {

    $conn = new PDO('mysql:host=localhost;dbname=hrtalent_live;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

    $query1 = $conn->query("SELECT * FROM canli_yayin_sorular ORDER BY `canli_yayin_sorular`.`dateTime` DESC", PDO::FETCH_ASSOC);
    $result1 = $query1->fetchAll();

    $query2 = $conn->query("SELECT * FROM canli_yayin_sorular_old ORDER BY `canli_yayin_sorular_old`.`dateTime` DESC", PDO::FETCH_ASSOC);
    $result2 = $query2->fetchAll();


    $data['status'] = 'ok';
    $data['data1'] = $result1;
    $data['data2'] = $result2;

    echo json_encode($data);
} catch (PDOexception $exe) {

    $data['status'] = 'err';
    $data['result'] = $exe->getMessage();
    echo json_encode($data);
}
