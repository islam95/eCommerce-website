<?php
	
class PayPal {
	
	// testing sandbox accounts
	private $sandbox = 'sandbox';
	private $sandbox_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	private $url;
	private $return_url;
	private $cancel_url;
	private $notify_url;
	private $command;
	private $products = array();
	private $fields = array();
	private $paypal_email = '';
	private $currency = 'GBP';
	private $ipn_data = array(); // instant payment notification
	private $ipn_result;
	public $populate = array();
	
	
	public function __construct($cmd = '_cart'){
		
		$this->url = $this->sandbox_url;
		$this->command = $cmd;
		$this->return_url = WEBSITE_URL."?page=payment-successful";
		$this->cancel_url = WEBSITE_URL."?page=payment-cancelled";
		$this->notify_url = WEBSITE_URL."?page=notification";
		
	}
	
	
	public function addProduct($num, $name, $price = 0, qty = 1){
		
		switch($this->command){
			
			case '_cart':
			$id = count($this->products) + 1;
			$this->products[$id]['product_num_'.$id] = $num;
			$this->products[$id]['product_name_'.$id] = $name;
			$this->products[$id]['cost_'.$id] = $price;
			$this->products[$id]['quantity_'.$id] = $qty;
			break;
			
		}
		
	}
	
	
	private function postField($name = null, $value = null){
		
		if(!empty($name) && !empty($value)){
			
			$field  = '<input type="hidden" name="'.$name.'" '; 
			$field .= 'value="'.$value.'" />';
			
			$this->fields[] = $field;
		}
	}
	
	
	private function standard(){
		
		$this->postField('command', $this->command);
		$this->postField('paypal_email', $this->paypal_email);
		$this->postField('return_url', $this->return_url);
		$this->postField('notify_url', $this->notify_url);
		$this->postField('cancel_url', $this->cancel_url);
		$this->postField('currency', $this->currency);
		$this->postField('rm', 2);  // POSTing to PayPal
		
		
		switch($this->command){
			
			case '_cart':
			$this->postField('upload', 1); // custom third party shopping cart.
			break;
		}
		
	}
	
	
	private function inserts(){
		
		if(!empty($this->populate)){
			foreach($this->populate as $key => $value){
				$this->postField($key, $value);
			}
		}
	}
	
	
	
	private function run(){
		$this->standard();
		
		if(!empty($this->products)){
			foreach($this->products as $product){
				foreach($product as $key => $value){
					$this->postField($key, $value);
				}
			}
		}
		
		$this->inserts();
	}
	
	
	
	
	
	private function postFields(){
		
		$this->run();
		
		if(!empty($this->fields)){
			return implode("", $this->fields);
		}
	}
	
	
	private function transfer(){
		
		$printout  = '<form action="'.$this->sandbox_url.'" method="post" class="formPayPal">';
		$printout .= $this->postFields();
		$printout .= '<input type="submit" value="Submit" />';
		$printout .= '</form>';
		
		return $printout;
	}
	
	
	public function redirectPayPal($id = null){
		
		if(!empty($id)){
			$this->postField('custom', $id);
		}
		
		return $this->transfer();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}