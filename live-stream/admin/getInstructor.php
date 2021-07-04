
<?php

$data = array();
$data['status'] = 'ok';
$data['result'] = [];

if (!$link = mysql_connect('localhost', 'hrtalent_live', '!hrt!2021!')) {
    echo 'mysql\'e bağlanamadı';
    exit;
}

if (!mysql_select_db('hrtalent_live', $link)) {
    echo 'Veritabanı seçilemedi';
    $data['status'] = 'error';
    $data['result'] = [];
    exit;
}

$sql    = 'SELECT * FROM `canli_yayin_program`';
mysql_set_charset('utf8', $link);
$result = mysql_query($sql, $link);

if (!$result) {
    echo "Veritabanı hatası, veritabanı sorgulanamıyor\n";
    echo 'MySQL Hatası: ' . mysql_error();
    $data['status'] = 'error';
    $data['result'] = [];
    exit;
}

while ($row = mysql_fetch_assoc($result)) {
    array_push($data['result'], array($row['Id'], $row['instructorCompany'], $row['instructorName'], $row['instructorTitle'], $row['instructorLinkedin'], $row['instructorPicture'], $row['programSubject']));
}

echo json_encode($data);
mysql_free_result($result);
?>

    