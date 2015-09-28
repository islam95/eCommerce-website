<?php
	
class Select {
	
	
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
	
	
	public function getPost($field = null){
		if(!empty($field)){
			return $this->isPost($field) ? strip_tags($_POST[$field]) : null;
			
		}
	}
	
	
	
	
	public function selectField($field, $value, $default = null){
		
		if($this->isPost($field) && $this->getPost($field) == $value) {
			return " selected=\"selected\"";
		} else {
			return !empty($default) && $default == $value ? " selected=\"selected\"" : null;
		}
	}
	
	
	
	public function textField($field, $value = null){
		// stripslashes method used to avoid different kinds of characters in a
		// textfield with slashes.
		if($this->isPost($field)){
			return stripslashes($this->getPost($field));
		} else {
			return !empty($value) ? $value : null;
		}
	}
	
	
	
	
	// Colour table will be created in a database if I have time before submitting. Also size table.
	public function getColour($record = null){
		$colourObject = new Colour();
		$colours = $colourObject->getColours();
		
		if(!empty($colours)){
			$print = "<select name=\"colour\" id=\"colour\" class=\"selectOption\">";
			
			if(empty($record)){
				$print .= "<option value=\"\">Select</option>";
			}
			foreach($colours as $colour){
				$print .= "<option value=\"";
				$print .= $colour['id'];
				$print .= "\"";
				$print .= $this->selectField('colour', $colour['id'], $record);
				$print .= ">";
				$print .= $colour['name'];
				$print .= "</option>";
			}
			$print .= "</select>";
			return $print;
		}
	}
	
	public function postList($expect = null){
		
		$print = array();
		
		if($this->isPost()){
			foreach($_POST as $key => $value){
				
				if(!empty($expect)){
					if(in_array($key, $expect)){
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