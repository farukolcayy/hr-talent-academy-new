<?php


$data = array();
$today = date("Ymd");
$rand = strtoupper(substr(uniqid(rand(), true), 0, 12));
$merchant_oid = $today . $rand;

$email = $_POST['email'];
$totalAmountPrice = $_POST['totalAmountPrice'];
$discountCode = $_POST['discountCode'];
$basketContent = $_POST['basketContent'];
$userName = $_POST['userName'];
$userPhone = $_POST['userPhone'];
$userAddress = $_POST['userAddress'];
$userIdentificationNumber = $_POST['userIdentificationNumber'];
$userCity = $_POST['userCity'];
$userDistrict = $_POST['userDistrict'];
$discountCodeValue = $_REQUEST['discountCodeValue'];

try {
    $conn = new PDO('mysql:host=localhost;dbname=hrtalent_basvuru_2021;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');
    $query = $conn->prepare("INSERT INTO odeme_krediKarti SET
        siparisNo= ?,totalAmount= ?,discount= ?,discountValue= ?,userIdentificationNumber= ?,userName= ?,userEmail= ?,userPhone= ?,
        userAddress= ?,userCity= ?,userDistrict= ?,basketContent= ?,paymentType= ?,isApproved= ?"
        );

    $insert = $query->execute(array(
        $merchant_oid,$totalAmountPrice,$discountCode,$discountCodeValue,$userIdentificationNumber,$userName,
        $email,$userPhone,$userAddress,$userCity,$userDistrict,$basketContent,'Havale/EFT',0
    ));

    if ($insert) {
        $last_id = $conn->lastInsertId();
        $data['status'] = 'ok';
        $data['result'] = $last_id;
        echo json_encode($data);
    } else {
        $data['status'] = 'err';
        $data['result'] = 'İşlem Başarısız!';
        echo json_encode($data);
    }
} catch (PDOexception $exe) {

    $data['status'] = 'err';
    $data['result'] = $exe->getMessage();
    echo json_encode($data);
}