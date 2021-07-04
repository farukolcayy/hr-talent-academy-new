
<?php

$email = $_POST['emailAddress'];
$data = array();

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
    alert('Geçersiz Email adresi girdiniz!');
    </script>";
    return;
} else {
    //database details
    $dbHost     = 'localhost';
    $dbUsername = 'hrtalent_live';
    $dbPassword = '!hrt!2021!';
    $dbName     = 'hrtalent_live';

    //create connection and select DB
    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if ($db->connect_error) {
        die("Bağlantı hatası: " . $db->connect_error);
    }

    try
    {
        $query = $db->query("SELECT emailAddress,count(*) as 'countEmail',isLogin FROM canli_yayin_kullanicilar where emailAddress='$email' and isStartQuiz=0");

        if ($query->num_rows > 0) {
            
            while ($row = $query->fetch_assoc()) {
                $userData = $row;
                $data['status'] = 'ok';
                $data['result'] = $userData;
            }
            
        } else {
            $data['status'] = 'err';
            $data['result'] = '';
        }
    }
    catch(Exception $e)
    {
            $data['status'] = 'err';
            $data['result'] = $e;
    }

    //returns data as JSON format
    echo json_encode($data);
}

?>

    