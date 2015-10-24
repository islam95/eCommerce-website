<?php
	
class Form {
	
	public function isPost($field = null){
		if(!empty($field)){
			if(isset($_POST[$field])){
				return true;
			}
			return false;
		} else {
			if(!empty($_POST)){
				return true;
			}
			return false;
		}
	}
	
	// Used for security in forms, so that users cannot insert html and javascript code.
	public function getPost($field = null){
		if(!empty($field)){
			// If the POST has been set (if form is submitted) remove any html tags for security reasons.
			return $this->isPost($field) ? strip_tags($_POST[$field]) : null;
		}
	}
	
	public function selectField($field, $value, $default = null){
		// If the form has been submitted with the specified field name
		if($this->isPost($field) && $this->getPost($field) == $value) {
			return " selected=\"selected\"";
		} else {
			return !empty($default) && $default == $value ? " selected=\"selected\"" : null;
		}
	}
	
	// Method for all forms used to stripslashes and also to leave the values in the forms as they are
	public function textField($field, $value = null){
		// stripslashes method used to avoid different kinds of characters in a
		// textfield with slashes.
		if($this->isPost($field)){
			return stripslashes($this->getPost($field));
		} else {
			return !empty($value) ? $value : null;
		}
	}
	
	public function getSizeLetter($record = null){
		$sizeObj = new Size();
		$sizes = $sizeObj->getSizeLetters();
		
		if(!empty($sizes)){
			$print = "<select name=\"size_letter\" id=\"size\" class=\"select_size\">";
			
			if(empty($record)){
				$print .= "<option value=\"\">Select</option>";
			}
			foreach($sizes as $size){
				$print .= "<option value=\"";
				$print .= $size['id'];
				$print .= "\"";
				$print .= $this->selectField('size_letter', $size['id'], $record);
				$print .= ">";
				$print .= $size['size_letter'];
				$print .= "</option>";
			}
			$print .= "</select>";
			return $print;
		}
	}
	
	public function getSizeNumber($record = null){
		$sizeObj = new Size();
		$sizes = $sizeObj->getSizeNumbers();
		
		if(!empty($sizes)){
			$print = "<select name=\"size_number\" id=\"size\" class=\"select_size\">";
			
			if(empty($record)){
				$print .= "<option value=\"\">Select</option>";
			}
			foreach($sizes as $size){
				$print .= "<option value=\"";
				$print .= $size['id'];
				$print .= "\"";
				$print .= $this->selectField('size_number', $size['id'], $record);
				$print .= ">";
				$print .= $size['size_number'];
				$print .= "</option>";
			}
			$print .= "</select>";
			return $print;
		}
	}
	
	// Method for getting colours from the database.
	public function getColour($record = null){
		$colourObject = new Colour();
		$colours = $colourObject->getColours();
		
		if(!empty($colours)){
			$print = "<select name=\"colour\" id=\"colour\" class=\"select_colour\">";
			
			if(empty($record)){
				$print .= "<option value=\"\">Select</option>";
			}
			foreach($colours as $colour){
				$print .= "<option value=\"";
				$print .= $colour['id'];
				$print .= "\"";
				$print .= $this->selectField('colour', $colour['id'], $record);
				$print .= ">";
				$print .= $colour['colour'];
				$print .= "</option>";
			}
			$print .= "</select>";
			return $print;
		}
	}
	
	// See Valid.php process() method.
	public function getPostArray($expect = null){
		
		$print = array();
		// if post is submitted
		if($this->isPost()){
			foreach($_POST as $key => $value){
				
				if(!empty($expect)){
					if(in_array($key, $expect)){
						//removing the html tags using strip_tags
						$print[$key] = strip_tags($value);
					}
				} else {
					$print[$key] = strip_tags($value);
				}
			}
		}
		
		return $print;
	}
	
	
	
	
	
	
}