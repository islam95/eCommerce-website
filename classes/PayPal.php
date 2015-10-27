<?php
	
class PayPal {
	
	private $sandbox = 'sandbox'; //environment
	// urls
	private $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
	private $sandbox_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	private $url;
	private $return_url; //return url
	private $cancel_url; //cancel url
	private $notify_url; //notify url for IPN (Instant payment notification)
	// transaction type: _xclick = buy now button; _cart = basket.
	private $_cmd;
	private $products = array(); //all products
	private $fields = array(); //all input fields
	private $paypal_email = 'acjx557-merchant@gmail.com'; //paypal merchant email address for business property
	private $currency = 'GBP'; //currency code
	private $ipn_data = array(); //data received from paypal
	private $ipn_result; //result of sending data back to paypal after ipn
	private $page_style = 'Khizir'; //page styles, used for paypal payment page styles
	//prepopulating checkout pages
	//first_name*, last_name*, address1*, address2, city*, postcode*, country*, email*, 
	public $populate = array(); //so user will not have to retype all his/her info at PayPal
	
	
	public function __construct($cmd = '_cart'){
		$this->url = $this->sandbox == 'sandbox' ? $this->sandbox_url : $this->paypal_url;
		$this->_cmd = $cmd;
		$this->return_url = WEBSITE_URL.DIR_SEP."kh".DIR_SEP."?page=payment_successful";
		$this->cancel_url = WEBSITE_URL.DIR_SEP."kh".DIR_SEP."?page=payment_cancelled";
		$this->notify_url = WEBSITE_URL.DIR_SEP."kh".DIR_SEP."?page=ipn";
	}
	
	public function addProduct($number, $name, $price = 0, $qty = 1){
		switch($this->_cmd){
			case '_cart':
			$id = count($this->products) + 1; //number of items in products array
			$this->products[$id]['item_number_'.$id] = $number;
			$this->products[$id]['item_name_'.$id] = $name;
			$this->products[$id]['amount_'.$id] = $price;
			$this->products[$id]['quantity_'.$id] = $qty;
			break;
			//buy now button. Only 1 item can be here. Not used now but can be used anytime
			case '_xclick':
			if(empty($this->products)){
				$this->products[0]['item_number'] = $number;
				$this->products[0]['item_name'] = $name;
				$this->products[0]['amount'] = $price;
				$this->products[0]['quantity'] = $qty;
			}
			break;
		}
		
	}
	
	// Contain all input fields that are called when ever PayPal is contacted
	private function standardFields(){
		$this->addField('cmd', $this->_cmd);
		$this->addField('business', $this->paypal_email);
		// For formatting the page as admin likes
		if($this->page_style != null) {
			$this->addField('page_style', $this->page_style);
		}
		$this->addField('return', $this->return_url);
		$this->addField('notify_url', $this->notify_url);
		$this->addField('cancel_payment', $this->cancel_url);
		$this->addField('currency_code', $this->currency);
		$this->addField('rm', 2);  // POSTing to PayPal
		
		switch($this->_cmd){
			case '_cart':
			$this->addField('upload', 1); // custom third party shopping cart.
			break;
			case '_xclick':
			//not using this yet.
			break;
		}
		
	}
	
	private function inserts(){
		if(!empty($this->populate)){
			foreach($this->populate as $key => $value){
				$this->addField($key, $value);
			}
		}
	}
	
	private function processFields(){
		$this->standardFields(); //fields called when ever PayPal is contacted
		// add custom fields
		if(!empty($this->products)){
			foreach($this->products as $product){
				foreach($product as $key => $value){
					$this->addField($key, $value);
				}
			}
		}
		$this->inserts(); // populate all details of the user 
	}
	
	private function addField($name = null, $value = null){
		if(!empty($name) && !empty($value)){
			$field  = '<input type="hidden" name="'.$name.'" '; 
			$field .= 'value="'.$value.'" />';
			$this->fields[] = $field;
		}
	}
	
	private function getFields(){
		$this->processFields();
		if(!empty($this->fields)){
			return implode("", $this->fields);
		}
	}
	
	private function transfer(){	
		$printout  = '<form action="'.$this->url.'" method="post" id="formPP">';
		$printout .= $this->getFields();
		$printout .= '<input type="submit" value="Submit" />';
		$printout .= '</form>';
		return $printout;
	}
	
	// run() method used in modules/paypal.php file to redirect the user to PayPal
	public function run($id = null){		
		if(!empty($id)){
			$this->addField('custom', $id);
		}
		return $this->transfer();
	}
	
	private function validIpn(){
		$host = gethostbyaddr($_SERVER['REMOTE_ADDR']); //host by address
		//check if post has been received from paypal.com
		if(!preg_match('/paypal\.com$/', $host)){
			return false;
		}
		// get all posted variables and put them to array
		$form = new Form();
		$this->ipn_data = $form->getPostArray();
		// check if email of the business matches the email received in post from IPN
		if(!empty($this->ipn_data) && 
			array_key_exists('receiver_email', $this->ipn_data) && 
			strtolower($this->ipn_data['receiver_email']) != 
			strtolower($this->paypal_email)){
				return false;
			}
		return true;
	}
	
	private function getReturnParams(){
		//notify-validate - need to send back to PayPal after ipn response.
		$print = array('cmd=notify-validate');
		if(!empty($this->ipn_data)){
			foreach($this->ipn_data as $key => $value){
				$value = function_exists('get_magic_quotes_gpc') ? 
							urlencode(stripcslashes($value)) : 
							urldecode($value);
				$print[] = "{$key}={$value}";
			}
		}
		return implode("&", $print);
	}
	
	// Sending data back to PayPal after istant payment notification
	private function sendCurl(){
		$response = $this->getReturnParams();
		
		$curl = curl_init(); //inistialising the curl
		curl_setopt($curl, CURLOPT_URL, $this->url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $response);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/x-www-form-urlencoded",
			"Content-Length: ".strlen($response)
		));
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		// Response from this call will be stored within ipn_result parameter
		$this->ipn_result = curl_exec($curl); 
		curl_close($curl);
	}
	
	//Instant Paypemnt Notification
	public function ipn(){
		if($this->validIpn()){
			$this->sendCurl(); //using php curl library
			//string compare with verified order from PayPal
			if (strcmp($this->ipn_result, "VERIFIED") == 0) {
				$order = new Order();
				// update order status
				if (!empty($this->ipn_data)) {
					//identifying the specific order by following
					$order->approve($this->ipn_data, $this->ipn_result);
				}
			}
			
		}
	}
	
	
	
}


