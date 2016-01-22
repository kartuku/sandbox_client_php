<?php
/**
 * Description of KartukuDirectAPI
 *
 * @author mfachri
 */
class KartukuDirectAPI {


    public static $MERCHANT_TOKEN = "your merchant token here";
    public static $SECRET_KEY     = "your secret key here";
	
    // ipgUrl
    const IPG_DIRECT_BASE_URL_SANDBOX    = "https://ipg-test.kartuku.com/";
    const IPG_DIRECT_BASE_URL_PRODUCTION = "https://ipg.kartuku.com/";

    // timeout in second
    private $timeOut = 30;

    public static $production = false;
    // constant
    const COMMAND_PURCHASE = "purchase";
    const COMMAND_AUTHORIZE = "authorize";
    const COMMAND_CAPTURE = "capture";
    const COMMAND_QUERY = "query";
    const COMMAND_VOID_AUTHORIZE = "voidAuthorize";
    const COMMAND_VOID_CAPTURE = "voidCapture";
    const COMMAND_VOID_PURCHASE = "voidPurchase";
    const COMMAND_REFUND = "refund";
    const COMMAND_VOID_REFUND = "voidRefund";

    const COMMAND_TOKEN_STORE = "store";
    const COMMAND_TOKEN_REMOVE = "remove";
    const COMMAND_TOKEN_LIST = "list";

    public function setProduction($val) {
        self::$production = $val;
    }

    public function isProduction() {
        return self::$production;
    }

    public function purchase($json_data) {
        return $this->wrapAndSend($json_data, $this->getTransactionUrl(self::COMMAND_PURCHASE));
    }

    public function authorize($json_data) {
        return $this->wrapAndSend($json_data, $this->getTransactionUrl(self::COMMAND_AUTHORIZE));
    }

    public function capture($json_data) {
        return $this->wrapAndSend($json_data, $this->getTransactionUrl(self::COMMAND_CAPTURE));
    }

    public function query($json_data) {
        return $this->wrapAndSend($json_data, $this->getTransactionUrl(self::COMMAND_QUERY));
    }

    public function refund($json_data) {
        return $this->wrapAndSend($json_data, $this->getTransactionUrl(self::COMMAND_REFUND));
    }

    public function voidCapture($json_data) {
        return $this->wrapAndSend($json_data, $this->getTransactionUrl(self::COMMAND_VOID_CAPTURE));
    }

    public function voidAuthorize($json_data) {
        return $this->wrapAndSend($json_data, $this->getTransactionUrl(self::COMMAND_VOID_AUTHORIZE));
    }

    public function voidRefund($json_data) {
        return $this->wrapAndSend($json_data, $this->getTransactionUrl(self::COMMAND_VOID_REFUND));
    }
    public function voidPurchase($json_data) {
        return $this->wrapAndSend($json_data, $this->getTransactionUrl(self::COMMAND_VOID_PURCHASE));
    }

    public function tokenStore($json_data){
        return $this->wrapAndSend($json_data, $this->getTokenUrl(self::COMMAND_TOKEN_STORE));
    }

    public function tokenRemove($json_data){
        return $this->wrapAndSend($json_data, $this->getTokenUrl(self::COMMAND_TOKEN_REMOVE));
    }

    public function tokenList($json_data){
        return $this->wrapAndSend($json_data, $this->getTokenUrl(self::COMMAND_TOKEN_LIST));
    }

    private function transformData($data) {
        return base64_encode($data);
    }

    private function calculateHash($key, $data) {
        return strtoupper(hash_hmac("SHA256", $data, $key));
    }

    private function sendMessageUsingStreamContext($url, $data) {
        $http_data = array("http" => array(
                "header" => "Content-type: application/json",
                "method" => "POST",
                "content" => $data
        ));
		var_dump($data);
        try {
            $context = stream_context_create($http_data);
            $use_include_path = false;
            return file_get_contents($url, $use_include_path, $context);
        } catch (Exception $e) {
            throw new Exception("Error while connecting to server", 0, $e);
        }
    }

    private function sendMessage($url, $data){
        return $this->isCurlAvailable()? $this->sendMessageUsingCurl($url, $data) : $this->sendMessageUsingStreamContext($url, $data);
    }

    private function wrapAndSend($json_data, $url) {
        $data = $this->transformData($json_data);
        $hash = $this->calculateHash(self::$SECRET_KEY, $data);
        $messageWrapper = array();
        $messageWrapper["message"] = $data;
        $messageWrapper["messageDigest"] = $hash;
        $raw_result = $this->sendMessage($url, json_encode($messageWrapper));
        $result = json_decode($raw_result, true);
        // unwrap
        if($this->checkMessageIntegrity($raw_result)){
            return base64_decode($result["message"]);
        }else{
           throw new Exception("Failed to check message integrity.");
        }
    }

    private function getTransactionUrl($command){
        return (self::$production ? self::IPG_DIRECT_BASE_URL_PRODUCTION : self::IPG_DIRECT_BASE_URL_SANDBOX) . "direct/" . $command;
    }

    private function getTokenUrl($command){
        return (self::$production ? self::IPG_DIRECT_BASE_URL_PRODUCTION : self::IPG_DIRECT_BASE_URL_SANDBOX) . "card/token/" . $command;
    }

    // need testing
    public function checkMessageIntegrity($raw_result) {
        $result = json_decode($raw_result, true);
        $message = $result['message'];
        if($this->isMessageError($result)){
            return true;
        } else if(array_key_exists("messageDigest", $result) && (strcmp($result['messageDigest'], $this->calculateHash(self::$SECRET_KEY, $message)) === 0)){
            return true;
        } else{
            return false;
        }
    }

    public function isMessageError($result) {
        $message = base64_decode($result["message"]);
        $json = json_decode($message, true);
        return is_null($json) || (array_key_exists("ipgResponseCode", $json) && $json["ipgResponseCode"] !== "0") ;
    }


    public static function getIPGUrl(){
        return self::$production ? self::IPG_DIRECT_BASE_URL_PRODUCTION : self::IPG_DIRECT_BASE_URL_SANDBOX;
    }

    private function isCurlAvailable() {
        if (in_array('curl', get_loaded_extensions())) {
            return true;
        } else {
            return false;
        }
    }

    private function sendMessageUsingCurl($url, $json){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeOut);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeOut);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($ch, CURLOPT_CAINFO, getcwd() . $this->IPG_TRUSTED_CERTIFICATE);
        $result = curl_exec($ch); // $info = curl_getinfo($ch);
        if (curl_errno($ch)) {
            throw new Exception("Connection failure : " . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function setTimeOut($param) {
        $this->timeOut = $param;
    }

    public function getTimeOut(){
        return $this->timeOut;
    }


}
