
<?php

$dataUser = array();
$data = array();

try {

    $conn = new PDO(-);

    $query = $conn->prepare("SELECT * FROM canli_yayin_program");
    $query->execute();

    if ($query->rowCount()) {
        foreach ($query as $row) {
            array_push($dataUser, $row);
        }
    }

    $data['status'] = 'ok';
    $data['result'] = $dataUser;
    echo json_encode($data);

} catch (PDOexception $exe) {

    $data['status'] = 'err';
    $data['result'] = '';
    echo json_encode($data);

}



    
