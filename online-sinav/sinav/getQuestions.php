
<?php

$data = array();
$data['status'] = 'ok';
$data['result'] = [];

if (!$link = mysql_connect('localhost', 'hrtalent_basvuru', '!hrt!2021!')) {
    echo 'mysql\'e bağlanamadı';
    exit;
}

if (!mysql_select_db('hrtalent_basvuru', $link)) {
    echo 'Veritabanı seçilemedi';
    $data['status'] = 'error';
    $data['result'] = [];
    exit;
}

$sql    = 'SELECT * FROM `sinav_soru` where type=1 ORDER BY RAND() LIMIT 10;';
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
    $userData = $row;
    array_push($data['result'], array($row['Id'], $row['type'], $row['question'], $row['questionOption'], base64_encode($row['questionImage']), base64_encode($row['optionImage1']), base64_encode($row['optionImage2']), base64_encode($row['optionImage3']), base64_encode($row['optionImage4']), base64_encode($row['optionImage5']), $row['answer'], $row['addTime']));
}

$sql2    = 'SELECT * FROM `sinav_soru` where type=3 ORDER BY RAND() LIMIT 10;';
mysql_set_charset('utf8', $link);
$result2 = mysql_query($sql2, $link);

if (!$result2) {
    echo "Veritabanı hatası, veritabanı sorgulanamıyor\n";
    echo 'MySQL Hatası: ' . mysql_error();
    $data['status'] = 'error';
    $data['result'] = [];
    exit;
}

while ($row2 = mysql_fetch_assoc($result2)) {
    $userData2 = $row2;
    array_push($data['result'], array($row2['Id'], $row2['type'], $row2['question'], $row2['questionOption'], base64_encode($row2['questionImage']), base64_encode($row2['optionImage1']), base64_encode($row2['optionImage2']), base64_encode($row2['optionImage3']), base64_encode($row2['optionImage4']), base64_encode($row2['optionImage5']), $row2['answer'], $row2['addTime']));
}

$sql3    = 'SELECT * FROM `sinav_soru` where type=2 ORDER BY RAND() LIMIT 10;';
mysql_set_charset('utf8', $link);
$result3 = mysql_query($sql3, $link);

if (!$result3) {
    echo "Veritabanı hatası, veritabanı sorgulanamıyor\n";
    echo 'MySQL Hatası: ' . mysql_error();
    $data['status'] = 'error';
    $data['result'] = [];
    exit;
}

while ($row3 = mysql_fetch_assoc($result3)) {
    $userData3 = $row3;
    array_push($data['result'], array($row3['Id'], $row3['type'], $row3['question'], $row3['questionOption'], base64_encode($row3['questionImage']), base64_encode($row3['optionImage1']), base64_encode($row3['optionImage2']), base64_encode($row3['optionImage3']), base64_encode($row3['optionImage4']), base64_encode($row3['optionImage5']), $row3['answer'], $row3['addTime']));
}


echo json_encode($data);
mysql_free_result($result);
?>

    