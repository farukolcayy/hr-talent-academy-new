
    <?php

	require_once __DIR__ . '/vendor/autoload.php';

	use Parasut\Client;

	$post = $_POST;

	####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
	#
	## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
	$merchant_key 	= 'Wm3MhpuDeJL9pmkb';
	$merchant_salt	= 'zFWTJFxETm9336sK';
	###########################################################################

	$hash = base64_encode(hash_hmac('sha256', $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'], $merchant_key, true));


	if ($hash != $post['hash']) {
		die('PAYTR notification failed: bad hash');
	}
	###########################################################################

	$siparisno = $post['merchant_oid'];
	$toplamtutar = $post['total_amount'];

	$totalAmountFormat = floatval($post['total_amount'] / 100);

	if ($post['status'] == 'success') {

		$userIdentificationNumber = "";
		$userName = "";
		$userEmail = "";
		$userPhone = "";
		$userAddress = "";
		$totalAmountPrice = ($totalAmountFormat / 1.18);
		$selectProgramLabel = "";
		$userCity = "";
		$userDistrict = "";
		$basketContent = "";
		$paymentType = "";
		$yeaOldVideos = "";
		$discount = "";
		$discountValue = "";

		$conn = new PDO('mysql:host=localhost;dbname=hrtalent_basvuru_2021;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');

		$query = $conn->prepare("SELECT * FROM odeme_ilk_adim where siparisNo=? GROUP by siparisNo");
		$query->execute(array($siparisno));

		if ($query->rowCount()) {
			foreach ($query as $row) {
				$userIdentificationNumber = $row["userIdentificationNumber"];
				$userName = $row["userName"];
				$userEmail = $row["userEmail"];
				$userPhone = $row["userPhone"];
				$userAddress = $row["userAddress"];
				$userCity = $row["userCity"];
				$userDistrict = $row["userDistrict"];
				$basketContent = $row["basketContent"];
				$paymentType = $row["paymentType"];
				$discount = $row["discount"];
				$discountValue = $row["discountValue"];
			}
		}

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
					'description' => 'HR Talent Academy Eğitim Ücreti',
					'issue_date' => date("Y-m-d"), // Required
					'due_date' => date("Y-m-d"),
					'invoice_series' => 'Bilet',
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
									'vat_rate' => 18,
									'description' => $basketContent
								),
								"relationships" => array(
									"product" => array(
										"data" => array(
											"id" => 60984601,
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
							'id' => 6697531,
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
		$conn = new PDO('mysql:host=localhost;dbname=hrtalent_basvuru_2021;charset=utf8;port=3306', 'hrtalent_basvuru', '!hrt!2021!');
		$query = $conn->prepare("INSERT INTO odeme_krediKarti SET
			siparisNo= ?,totalAmount= ?,discount= ?,discountValue= ?,userIdentificationNumber= ?,userName= ?,userEmail= ?,userPhone= ?,
			userAddress= ?,userCity= ?,userDistrict= ?,basketContent= ?,paymentType= ?"
			);
	
		$insert = $query->execute(array(
			$siparisno,$totalAmountFormat,$discount,$discountValue,$userIdentificationNumber,$userName,
			$userEmail,$userPhone,$userAddress,$userCity,$userDistrict,$basketContent,$paymentType
		));

		##endregion

		##mesaj gönderme kısmı
		$message = urlencode('Ödemeniz başarılı bir şekilde gerçekleşmiştir. Akademi bilgileriniz en geç 1 hafta içerisinde tarafınıza gönderilecektir. 08508882234');
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