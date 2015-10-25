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
	private $log_file = null; //path to the log file for ipn response
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
		$this->log_file = ROOT_PATH.DIR_SEP."log".DIR_SEP."ipn.log";
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
	
	
	
	
}


