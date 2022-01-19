<?php
/**
 * Created by Shopinext.
 * User: Onur Adalı
 * Date: 01/01/2021
 * Time: 12:24
 */

class Shopinext
{
	public $code = '';
	public $message = '';
	public $token = '';
	public $output = [];
	private $auth = '';
	private $snid = '';
	private $apikey = '';
	private $secret = '';
	private $salt = '';
	private $note = '';
	private $data = [];
    private $returnurl = '';
    private $app_url = '';
	private $cart = [];
	private $snpoint = [];
    private $headers = [
        'Accept: application/json',
        'Content-Type: application/json'
    ];
	public function __construct($snid, $apikey, $secret, $status, $return) {
		if($status == 'test') {
			$this->app_url = "https://www.shopinext.com/api/t2/";
		} else {
			$this->app_url = "https://www.shopinext.com/api/v2/";
		}
		$this->snid = $snid;
		$this->apikey = $apikey;
		$this->secret = $secret;
        $this->returnurl = $return;
        $this->snpoint = [
            'create_token' => $this->app_url . 'createToken',
            'get_payment' => $this->app_url .'getPaymentForm',
            'get_installment' => $this->app_url . 'getInstallment',
            'get_commission' => $this->app_url .'getCommission',
            'check_order' => $this->app_url.'checkOrder',
            'get_balance' => $this->app_url.'getBalance',
            'get_shipcode' => $this->app_url.'getShipcode',
            'get_delivery' => $this->app_url.'getDelivery',
            'get_currency' => $this->app_url.'getCurrency',
            'check_currency' => $this->app_url.'checkCurrency',
            'refund_order' => $this->app_url.'refundOrder',
            'get_card' => $this->app_url.'getCard',
            'save_card' => $this->app_url.'saveCard',
            'delete_card' => $this->app_url.'deleteCard'
        ];
		$this->headers[] = 'X-Forwarded-For: '.$this->getIp();
		$this->headers[] = 'REMOTE_ADDR: '.$this->getIp();
		$this->headers[] = 'HTTP_X_FORWARDED_FOR: '.$this->getIp();
	}
	public function addProduct($product) {
		array_push($this->cart,$product);
	}
	private function getIp() {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		} else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
			$ip = getenv("REMOTE_ADDR");
		} else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip = "unknown";
		}
		if(strstr($ip, ',')) {
			$tmp = explode (',', $ip);
			$ip = trim($tmp[0]);
		}
		return $ip;
	}
	private function generateHash() {
		$pass = $this->apikey.$this->secret.$this->snid;
		$this->salt = hash('sha512', uniqid(mt_rand()));
		$hash = base64_encode(hash_pbkdf2("sha256", md5($pass), $this->salt, 20000));
		$this->headers[] = "Authorization: Bearer {$hash}";
		$this->auth = 'yes';
	}
	public function createToken($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
        $this->data = $input;
        $this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->data['cart'] = $this->cart;
        $this->data['return'] = $this->returnurl;
        $this->app_url = $this->snpoint["create_token"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function getPaymentForm($input, $iframe = true) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
        $this->data = $input;
        $this->data['iframe'] = $iframe;
        $this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["get_payment"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function getInstallment($html = false) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
        $this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["get_installment"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function getCommission($html = false) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
        $this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["get_commission"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function checkOrder($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data = $input;
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["check_order"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function getBalance($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data = $input;
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["get_balance"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function getShipcode($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data = $input;
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["get_shipcode"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function getDelivery($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data = $input;
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["get_delivery"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function getCurrency() {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["get_currency"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function checkCurrency($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data = $input;
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["check_currency"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function refundOrder($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data = $input;
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["refund_order"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function getCard($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data = $input;
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["get_card"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function saveCard($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data = $input;
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["save_card"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
	public function deleteCard($input) {
		if(empty($this->auth)) {
			$this->generateHash();
		}
		$this->data = $input;
		$this->data['snid'] = $this->snid;
        $this->data['apikey'] = $this->apikey;
        $this->data['secret'] = $this->secret;
        $this->data['salt'] = $this->salt;
        $this->app_url = $this->snpoint["delete_card"];
        $response = $this->callApiByCurl();
        $this->output = '';
        if ($response->responseCode == 00) {
            $this->code = $response->responseCode;
            $this->message = 'success';
            $this->output = $response;
        }else{
            $this->code = $response->responseCode;
            $this->message = $response->responseMsg;
        }
	}
    private function callApiByCurl()
    {
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $ch = curl_init($this->app_url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_REFERER, $actual_link);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $this->headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $output = curl_exec($ch);
        $output = json_decode($output);
        curl_close($ch);
        return $output;
    }
}
