
    <?php

	require_once __DIR__ . '/vendor/autoload.php';

	use Parasut\Client;

	## 2. ADIM için örnek kodlar ##

	## ÖNEMLİ UYARILAR ##
	## 1) Bu sayfaya oturum (SESSION) ile veri taşıyamazsınız. Çünkü bu sayfa müşterilerin yönlendirildiği bir sayfa değildir.
	## 2) Entegrasyonun 1. ADIM'ında gönderdiğniz merchant_oid değeri bu sayfaya POST ile gelir. Bu değeri kullanarak
	## veri tabanınızdan ilgili siparişi tespit edip onaylamalı veya iptal etmelisiniz.
	## 3) Aynı sipariş için birden fazla bildirim ulaşabilir (Ağ bağlantı sorunları vb. nedeniyle). Bu nedenle öncelikle
	## siparişin durumunu veri tabanınızdan kontrol edin, eğer onaylandıysa tekrar işlem yapmayın. Örneği aşağıda bulunmaktadır.

	$post = $_POST;

	####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
	#
	## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
	$merchant_key 	= 'Wm3MhpuDeJL9pmkb';
	$merchant_salt	= 'zFWTJFxETm9336sK';
	###########################################################################

	####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
	#
	## POST değerleri ile hash oluştur.
	$hash = base64_encode(hash_hmac('sha256', $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'], $merchant_key, true));
	#
	## Oluşturulan hash'i, paytr'dan gelen post içindeki hash ile karşılaştır (isteğin paytr'dan geldiğine ve değişmediğine emin olmak için)
	## Bu işlemi yapmazsanız maddi zarara uğramanız olasıdır.

	// foreach ($post as $key => $value) {
	// 	echo "$key is at $value";
	// }

	if ($hash != $post['hash']) {
		die('PAYTR notification failed: bad hash');
	}
	###########################################################################

	## BURADA YAPILMASI GEREKENLER
	## 1) Siparişin durumunu $post['merchant_oid'] değerini kullanarak veri tabanınızdan sorgulayın.
	## 2) Eğer sipariş zaten daha önceden onaylandıysa veya iptal edildiyse  echo "OK"; exit; yaparak sonlandırın.

	/* Sipariş durum sorgulama örnek
 	   $durum = SQL
	   if($durum == "onay" || $durum == "iptal"){
			echo "OK";
			exit;
		}
	 */
	$siparisno = $post['merchant_oid'];
	$toplamtutar = $post['total_amount'];

	$totalAmountFormat = floatval($post['total_amount'] / 100);

	if ($post['status'] == 'success') {

		$userIdentificationNumber = "";
		$userName = "";
		$userEmail = "";
		$userPhone = "";
		$userAddress = "";
		$totalAmountPrice = ($totalAmountFormat / 1.08);
		// $totalAmountPrice = "1.99";
		$selectProgramLabel = "";
		$userCity = "";
		$userDistrict = "";
		$basketContent = "";
		$paymentType = "";
		$yeaOldVideos = "";
		$discount = "";


		$link22 = mysqli_connect("localhost", "hrtalent_odeme", "!hrt!2021!", "hrtalent_odeme");

		if ($link22 != false) {
			$sql22 = "SELECT * FROM odeme_ilk_adim WHERE siparisNo='$siparisno' GROUP BY siparisNo";
			mysqli_set_charset($link22, "utf8");
			if ($res22 = mysqli_query($link22, $sql22)) {
				if (mysqli_num_rows($res22) > 0) {
					while ($row22 = mysqli_fetch_array($res22)) {
						$userIdentificationNumber = $row22["userIdentificationNumber"];
						$userName = $row22["userName"];
						$userEmail = $row22["userEmail"];
						$userPhone = $row22["userPhone"];
						$userAddress = $row22["userAddress"];
						$userCity = $row22["userCity"];
						$userDistrict = $row22["userDistrict"];
						$basketContent = $row22["basketContent"];
						$paymentType = $row22["paymentType"];
						$discount = $row22["discount"];
					}
				}
			}
		}

		mysqli_close($link22);


		//MParaşüt Token Alma
		$client = new Client([
			"client_id" => "cb9496e648b4aea348e315430e52ac454ec2b5c0e812da929285c83eafce04a9",
			"username" => "yilmaz@badiworks.com",
			"password" => "olnuakyı",
			"grant_type" => "password",
			"redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
			'company_id' => "245212"
		]);

		//Paraşüt Müşteri Oluşturma
		$customer = array(
			'data' =>
			array(
				'type' => 'contacts',
				'attributes' => array(
					'email' => $userEmail,
					'name' => $userName, // REQUIRED
					'short_name' => '',
					'contact_type' => 'person', // or company
					'district' => $userDistrict,
					'city' => $userCity,
					'address' => $userAddress,
					'phone' => $userPhone,
					'account_type' => 'customer', // REQUIRED
					'tax_number' => $userIdentificationNumber, // TC no for person
					'tax_office' => ''
				)
			),
		);

		try {
			$uye = $client->call(Parasut\Account::class)->create($customer);
			$uyeid = $uye['data']['id'];
			// echo $uyeid;
		} catch (Exception $e) {
			// echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
		}


		//Paraşüt Fatura Oluşturma
		$invoice = array(
			'data' => array(
				'type' => 'sales_invoices', // Required
				'attributes' => array(
					'item_type' => 'invoice', // Required
					'description' => 'HR Talent Eğitim Ücreti',
					'issue_date' => date("Y-m-d"), // Required
					'due_date' => date("Y-m-d"),
					'invoice_series' => 'Sertifika',
					// 'invoice_id' => 15454656,
					'currency' => 'TRL'
				),
				'relationships' => array(
					'details' => array(
						'data' => array(
							0 => array(
								'type' => 'sales_invoice_details',
								'attributes' => array(
									'quantity' => 1,
									'unit_price' => $totalAmountPrice,
									'vat_rate' => 8,
									'description' => $basketContent
								),
								"relationships" => array(
									"product" => array(
										"data" => array(
											"id" => 43822111,
											"type" => "products"
										)
									)
								)
							)
						),
					),
					'contact' => array(
						'data' => array(
							'id' => $uyeid,
							'type' => 'contacts'
						)
					),
					'category' => array(
						'data' => array(
							'id' => 5708003,
							'type' => 'item_categories'
						)
					)
				),
			)
		);

		try {
			$fatura = $client->call(Parasut\Invoice::class)->create($invoice);
			$faturaid = $fatura['data']['id'];
		} catch (Exception $e) {
			// echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
		}

		$_paymentType = "KREDIKARTI/BANKAKARTI";
		if ($paymentType === "Havale/EFT") {
			$_paymentType = "EFT/HAVALE";
		}

		//Paraşüt E-Arşiv Oluşturma
		$invArr = array(
			"data" => array(
				"type" => "e_archives",
				'attributes' => array(
					'internet_sale' => array(
						'url' => 'https://hrtalent.academy/',
						'payment_type' => $_paymentType,
						'payment_platform' => 'PayTR',
						'payment_date' => date("Y-m-d")
					)
				),
				"relationships" => array(
					"sales_invoice" => array(
						"data" => array(
							"id" => $faturaid, // Invoice Id
							"type" => "sales_invoices"
						)
					)
				)
			)
		);

		try {
			$client->call(Parasut\Invoice::class)->create_e_archive($invArr);
		} catch (Exception $e) {
			// echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
		}


		$payArr = array(
			"data" => array(
				"type" => "payments",
				"attributes" => array(
					"description" => "Tahsil Edilmiştir.",
					"account_id" => 380313, // bank account id on Parasut
					"date" => date("Y-m-d"),
					"amount" => $totalAmountFormat,
					"exchange_rate" => 1.0
				)
			)
		);

		try {
			$payy = $client->call(Parasut\Invoice::class)->pay($faturaid, $payArr);
			// echo $uyeid;
		} catch (Exception $e) {
			// echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
		}


		##ödemeyi veritabanına kaydetme kısmı
		$link = mysqli_connect("localhost", "hrtalent_odeme", "!hrt!2021!", "hrtalent_odeme");
		$sql = "INSERT INTO odeme_krediKarti (siparisNo,totalAmount,discount,userIdentificationNumber,userName,userEmail,userPhone,userAddress,userCity,userDistrict,basketContent,paymentType) VALUES ('$siparisno','$totalAmountFormat','$discount','$userIdentificationNumber','$userName','$userEmail','$userPhone','$userAddress','$userCity','$userDistrict','$basketContent','$paymentType')";

		mysqli_set_charset($link, "utf8");
		if (mysqli_query($link, $sql)) {
		} else {
		}
		mysqli_close($link);
		##endregion

		##mesaj gönderme kısmı
		$message = urlencode('Ödemeniz başarılı bir şekilde gerçekleşmiştir. Akademi bilgileriniz tarafınıza gönderilecektir. 08508882234');
		// $message = str_replace(' ', '%20', $sss);

		$postUrl = "http://panel.1sms.com.tr:8080/api/smsget/v1?username=bw&password=9bcd9b9d53b99ea8d54e7b2d5e006626&header=BadiWorks&gsm=" . substr($userPhone, 1) . "&message=" . $message;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $postUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);
		curl_close($ch);

		## Ödeme Onaylandı
		## BURADA YAPILMASI GEREKENLER
		## 1) Siparişi onaylayın.
		## 2) Eğer müşterinize mesaj / SMS / e-posta gibi bilgilendirme yapacaksanız bu aşamada yapmalısınız.

		## 3) 1. ADIM'da gönderilen payment_amount sipariş tutarı taksitli alışveriş yapılması durumunda
		## değişebilir. Güncel tutarı $post['total_amount'] değerinden alarak muhasebe işlemlerinizde kullanabilirsiniz.

	} else { ## Ödemeye Onay Verilmedi

		## BURADA YAPILMASI GEREKENLER
		## 1) Siparişi iptal edin.
		## 2) Eğer ödemenin onaylanmama sebebini kayıt edecekseniz aşağıdaki değerleri kullanabilirsiniz.
		echo $post['failed_reason_code'] . " başarısız hata kodu";
		echo $post['failed_reason_msg'] . " başarısız hata mesajı";
	}

	## Bildirimin alındığını PayTR sistemine bildir.
	echo "OK";
	exit;
	?>