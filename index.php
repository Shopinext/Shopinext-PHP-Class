<?php

require_once 'shopinext.php';
$shopinext = new Shopinext('Shopinext ID','API Anahtarı','Gizli Anahtar','test','http://localhost/return.php');

$examplecart = array(
	array(
		'name' => 'Shopinext Entegrasyon Hizmeti',
		'price' => 2.75,
		'quantity' => 3
	),
	array(
		'name' => 'Shopinext Ürün Hizmeti',
		'price' => 10,
		'quantity' => 1
	),
	array(
		'name' => 'Kargo Ücreti',
		'price' => 10,
		'quantity' => 1
	)
);

$price = 0;
foreach($examplecart as $product) {
	$shopinext->addProduct(array(
		'name'=>$product['name'],
		'price'=>$product['price'],
		'quantity'=>$product['quantity']
	));
	$price += $product['price']*$product['quantity'];
}

$shopinext->createToken(array(
	'customerName' => 'Shopinext Test',
	'customerMail' => 'it@shopinext.com',
	'customerPhone' => '08503057717', //SMS doğrulama aktif ise bu numaraya doğrulama kodu gönderilir. Boş gönderildiği takdirde ödeme sırasında alınır.
	'price' => $price,
	'currency' => 'TRY', //USD, EUR, GBP
	'shipCode' => false, // true gönderildiği takdirde ödeme ekranında adres bilgileri alınacaktır. Ödeme sonrası tanımladığınız firmadan kargo kodu oluşturulur.
	'customerCountry' => 'TR', // Ülke kodu gönderilmelidir. Örneğin Azerbaijan => AZ, Australia => AU vb.
	'customerCity' => 'İstanbul', // Şehir adı tam ve doğru şekilde gönderilmelidir.
	'customerTown' => 'Maltepe', // İlçe adı tam ve doğru şekilde gönderilmelidir.
	'customerAddress' => 'İdealtepe, Dik Sk. 13/2, 34841', // Adres bilgisi eksiksiz gönderilmelidir.
));

echo '<pre>';
print_r($shopinext->output);
echo '</pre>';

$shopinext->getPaymentForm(array(
	'sessionToken' => $shopinext->output->sessionToken
));

if($shopinext->output->responseCode == 00) {
	echo $shopinext->output->iframeData;
} else {
	echo $shopinext->output->responseMsg;
}

$shopinext->checkOrder(array(
	'orderId' => 'Sipariş Numarası'
));

echo '<pre>';
print_r($shopinext->output);
echo '</pre>';

$shopinext->getInstallment();

echo '<pre>';
print_r($shopinext->output);
echo '</pre>';

$shopinext->getCommission();

echo '<pre>';
print_r($shopinext->output);
echo '</pre>';

?>