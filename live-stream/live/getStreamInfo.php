
<?php

$liveId = $_POST['liveId'];
$data = array();
$dataUser= array();

try {

    $conn = new PDO('mysql:host=localhost;dbname=hrtalent_live;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

    $query = $conn->prepare("SELECT * FROM canli_yayin c left join canli_yayin_program p on c.instructorId=p.Id where c.Id=?");
    $query->execute(array($liveId));

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