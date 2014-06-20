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
		return $resp->body;
	}

	function _post($path, $params) {
		$resp = Unirest::post($this->baseurl . $path, array("Accept" => "application/json", "Authorization" => "Token token=\"" . $this->apikey . "\""), $params);
		return $resp->body;
	}

	function _delete($path, $params) {
		$resp = Unirest::delete($this->baseurl . $path, array("Accept" => "application/json", "Authorization" => "Token token=\"" . $this->apikey . "\""), $params);
		return $resp->body;
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

	function order_info($orderid) {
		return $this->_get("/api/v1/orders/" . $orderid);
	}

	function cancel_order($orderid) {
		return $this->_delete("/api/v1/orders/" . $orderid);
	}

	function recent_orders() {
		return $this->_get("/api/v1/orders");
	}

	function book($item, $currency) {
		return $this->_get("/api/v1/market/book", array("item" => $item, "currency" => $currency));
	}

	function recent_trades($item, $currency) {
		return $this->_get("/api/v1/market/trades/recent", array("item" => $item, "currency" => $currency));
	}
}

?>
