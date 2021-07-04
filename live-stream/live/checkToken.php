
<?php
  
$emailAddress = $_POST['emailAddress'];
$token = $_POST['token'];
$data = array();

//database details
$dbHost     = 'localhost';
$dbUsername = 'hrtalent_live';
$dbPassword = '!hrt!2021!';
$dbName     = 'hrtalent_live';

//create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
$db->set_charset("utf8");
if ($db->connect_error) {
    die("Bağlantı hatası: " . $db->connect_error);
}

//get user data from the database
$query = $db->query("SELECT * FROM canli_yayin_kullanicilar where emailAddress='$emailAddress' and token='$token'");

if ($query->num_rows > 0) {
    $userData = $query->fetch_assoc();
    $data['status'] = 'ok';
    $data['result'] = $userData;
} else {
    $data['status'] = 'err';
    $data['result'] = '';
}

//returns data as JSON format
echo json_encode($data);

?>

    