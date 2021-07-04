
<?php

$email = $_POST['emailAddress'];
$password = $_POST['password'];
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
$query = $db->query("SELECT Id,nameSurname,emailAddress,password,token,isLogin FROM canli_yayin_kullanicilar where emailAddress='$email' and password='$password' GROUP by emailAddress");

if ($query->num_rows > 0) {
    $userData = $query->fetch_assoc();
    $data['status'] = 'ok';
    $data['result'] = $userData;
    // $data['result'].selectedProgram = replace_tr($data['result']['selectedProgram']);
} else {
    $data['status'] = 'err';
    $data['result'] = '';
}

//returns data as JSON format
echo json_encode($data);

?>

    