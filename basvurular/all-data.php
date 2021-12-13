<?php

$data = array();
$temp = array();

try {

    $conn = new PDO('mysql:host=localhost;dbname=hrtalent_basvuru_2021;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

    $query = $conn->query('SELECT Id,concat(name," ",surname),emailAddress,phoneNumber,university,department,class,
    case 
        when  isStartQuiz =0 then "Hayır"
        when  isStartQuiz= 1 then "Evet"
        end as isStartQuiz,applyDate
    FROM basvuru GROUP by emailAddress order by applyDate desc', PDO::FETCH_ASSOC);
    $result1 = $query->fetchAll();


    $query2 = $conn->query("SELECT COUNT(*) as 'todayApply' FROM `basvuru` where DATE(applyDate)=CURDATE() GROUP by emailAddress", PDO::FETCH_ASSOC);
    $result2 =$query2->rowCount();

    $data['status'] = 'ok';
    $data['data1'] = $result1;
    $data['total1'] = $result2;

    echo json_encode($data);
} catch (PDOexception $exe) {

    $data['status'] = 'err';
    $data['result'] = $exe->getMessage();
    echo json_encode($data);
}
