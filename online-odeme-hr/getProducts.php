
<?php

$liveId = $_POST['liveId'];
$data = array();

//database details
$dbHost     = 'localhost';
$dbUsername = 'hrtalent_odeme';
$dbPassword = '!hrt!2021!';
$dbName     = 'hrtalent_odeme';
$result_array = array();

//create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Bağlantı hatası: " . $db->connect_error);
}

//get user data from the database
$query = $db->query("SELECT * FROM products order by createDate desc");

if ($query->num_rows > 0) {

    while ($row = $query->fetch_assoc()) {
        array_push($result_array, $row);
    }

    $data['status'] = 'ok';
    $data['result'] = $result_array;
} else {
    $data['status'] = 'err';
    $data['result'] = '';
}

//returns data as JSON format
echo json_encode($data);

?>

    