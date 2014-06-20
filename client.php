<?php

require_once "unirest-php/lib/Unirest.php";

class AtlasClient {
	private $baseurl;
	private $apikey;
	function __construct($baseurl, $apikey) {
		$this->baseurl = $baseurl;
		$this->apikey = $apikey;
	}

	function _get($path, $params) {
		$resp = Unirest::get($this->baseurl . $path, array("Accept" => "application/json", "Authorization" => "Token token=\"" . $this->apikey . "\""), $params);
		return $resp->raw_body;
	}

	function _post($path, $params) {
		$resp = Unirest::post($this->baseurl . $path, array("Accept" => "application/json", "Authorization" => "Token token=\"" . $this->apikey . "\""), $params);
		return $resp->raw_body;
	}

	function account_info() {
		return $this->_get("/api/v1/account", null);
	}

	function place_limit_order($item, $currency, $side, $quantity, $price) {
		return $this->_post("/api/v1/orders", array("item" => $item, "currency" => $currency, "side" => $side, "quantity" => $quantity, "type" => "limit", "price" => $price));
	}

	function place_market_order($item, $currency, $side, $quantity) {
		return $this->_post("/api/v1/orders", array("item" => $item, "currency" => $currency, "side" => $side, "quantity" => $quantity, "type" => "market"));
	}
}

$client = new AtlasClient("http://atlasats.eu", "8ffb026971471c0bfe3290ad39e205f9");

$acct_info = $client->account_info();

$order_buy = $client->place_limit_order("BTC", "EUR", "BUY", 0.1337, 609.0);

$order_sell = $client->place_limit_order("BTC", "EUR", "SELL", 0.7331, 611.59);

print "Account Info\n";
print "==================\n";
print $acct_info . "\n";
print "BUY: created\n";
print "==================\n";
print $order_buy . "\n";
print "SELL: created\n";
print $order_sell . "\n";
?>
