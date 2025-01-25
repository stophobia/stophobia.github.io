<?php
/*
An XML-RPC implementation by Keith Devens, version 2.5f.
http://www.keithdevens.com/software/xmlrpc/

Release history available at:
http://www.keithdevens.com/software/xmlrpc/history/

This code is Open Source, released under terms similar to the Artistic License.
Read the license at http://www.keithdevens.com/software/license/

Note: this code requires version 4.1.0 or higher of PHP.
*/

function & XML_serialize(&$data, $level = 0, $prior_key = NULL){
	$xml_serialized_string = "";
	while(list($key, $value) = each($data)){
		$inline = false;
		$numeric_array = false;
		$attributes = "";
		if(!strstr($key, " attr")){ #if it's not an attribute
			if(array_key_exists("$key attr", $data)){
				while(list($attr_name, $attr_value) = each($data["$key attr"])){
					$attr_value = &htmlspecialchars($attr_value, ENT_QUOTES);
					$attributes .= " $attr_name=\"$attr_value\"";
				}
			}

			if(is_numeric($key)){
				$key = $prior_key;
			}else{
				if(is_array($value) and array_key_exists(0, $value)){
					$numeric_array = true;
					$xml_serialized_string .= XML_serialize($value, $level, $key);
				}
			}

			if(!$numeric_array){
				$xml_serialized_string .= str_repeat("\t", $level) . "<$key$attributes>";

				if(is_array($value)){
					$xml_serialized_string .= "\r\n" . XML_serialize($value, $level+1);
				}else{
					$inline = true;
					$xml_serialized_string .= htmlspecialchars($value);
				}

				$xml_serialized_string .= (!$inline ? str_repeat("\t", $level) : "") . "</$key>\r\n";
			}
		}else{
		}
	}
	if($level == 0){
		$xml_serialized_string = "<?xml version=\"1.0\" ?>\r\n" . $xml_serialized_string;
		return $xml_serialized_string;
	}else{
		return $xml_serialized_string;
	}
}

class XML {
	var $parser;
	var $document;
	var $current;
	var $parent;
	var $parents;

	var $last_opened_tag;

	function XML($data=null){
		$this->parser = xml_parser_create();

		xml_parser_set_option ($this->parser, XML_OPTION_CASE_FOLDING, 0);
		xml_set_object($this->parser, &$this);
		xml_set_element_handler($this->parser, "open", "close");
		xml_set_character_data_handler($this->parser, "data");
	}

	function destruct(){
		xml_parser_free($this->parser);
	}

	function parse($data){
		$this->document = array();
		$this->parent = &$this->document;
		$this->parents = array();
		$this->last_opened_tag = NULL;
		xml_parse($this->parser, $data);
		return $this->document;
	}

	function open($parser, $tag, $attributes){
		$this->data = "";
		$this->last_opened_tag = $tag; #tag is a string
		if(array_key_exists($tag, $this->parent)){
			if(is_array($this->parent[$tag]) and array_key_exists(0, $this->parent[$tag])){ #if the keys are numeric
				$key = count_numeric_items($this->parent[$tag]);
			}else{
				$temp = &$this->parent[$tag];
				unset($this->parent[$tag]);
				$this->parent[$tag][0] = &$temp;

				if(array_key_exists("$tag attr", $this->parent)){
					#shift the attributes around too if they exist
					$temp = &$this->parent["$tag attr"];
					unset($this->parent["$tag attr"]);
					$this->parent[$tag]["0 attr"] = &$temp;
				}
				$key = 1;
			}
			$this->parent = &$this->parent[$tag];
		}else{
			$key = $tag;
		}
		if($attributes){
			$this->parent["$key attr"] = $attributes;
		}

		$this->parent[$key] = array();
		$this->parent = &$this->parent[$key];
		array_unshift($this->parents, &$this->parent);
	}

	function data($parser, $data){
		if($this->last_opened_tag != NULL){
			$this->data .= $data;
		}
	}

	function close($parser, $tag){
		if($this->last_opened_tag == $tag){
			$this->parent = $this->data;
			$this->last_opened_tag = NULL;
		}
		array_shift($this->parents);
		$this->parent = &$this->parents[0];
	}
}

function & XML_unserialize(&$xml){
	$xml_parser = new XML();
	$data = &$xml_parser->parse(&$xml);
	$xml_parser->destruct();
	return $data;
}

function & XMLRPC_parse(&$request){
	if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
		XMLRPC_debug('XMLRPC_parse', "<p>Received the following raw request:</p>" . XMLRPC_show($request, 'print_r', true));
	}
	$data = &XML_unserialize(&$request);
	if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
		XMLRPC_debug('XMLRPC_parse', "<p>Returning the following parsed request:</p>" . XMLRPC_show($data, 'print_r', true));
	}
	return $data;
}

function & XMLRPC_prepare($data, $type = NULL){
	if(is_array($data)){
		$num_elements = count($data);
		if((array_key_exists(0, $data) or !$num_elements) and $type != 'struct'){
			if(!$num_elements){ 
				$returnvalue =  array('array' => array('data' => NULL));
			}else{
				$returnvalue['array']['data']['value'] = array();
				$temp = &$returnvalue['array']['data']['value'];
				$count = count_numeric_items($data);
				for($n=0; $n<$count; $n++){
					$type = NULL;
					if(array_key_exists("$n type", $data)){
						$type = $data["$n type"];
					}
					$temp[$n] = XMLRPC_prepare(&$data[$n], $type);
				}
			}
		}else{ 
			if(!$num_elements){
				$returnvalue = array('struct' => NULL);
			}else{
				$returnvalue['struct']['member'] = array();
				$temp = &$returnvalue['struct']['member'];
				while(list($key, $value) = each($data)){
					if(substr($key, -5) != ' type'){ 
						$type = NULL;
						if(array_key_exists("$key type", $data)){
							$type = $data["$key type"];
						}
						$temp[] = array('name' => $key, 'value' => XMLRPC_prepare(&$value, $type));
					}
				}
			}
		}
	}else{
		if(!$type){
			if(is_int($data)){
				$returnvalue['int'] = $data;
				return $returnvalue;
			}elseif(is_float($data)){
				$returnvalue['double'] = $data;
				return $returnvalue;
			}elseif(is_bool($data)){
				$returnvalue['boolean'] = ($data ? 1 : 0);
				return $returnvalue;
			}elseif(preg_match('/^\d{8}T\d{2}:\d{2}:\d{2}$/', $data, $matches)){ #it's a date
				$returnvalue['dateTime.iso8601'] = $data;
				return $returnvalue;
			}elseif(is_string($data)){
				$returnvalue['string'] = htmlspecialchars($data);
				return $returnvalue;
			}
		}else{
			$returnvalue[$type] = htmlspecialchars($data);
		}
	}
	return $returnvalue;
}

function & XMLRPC_adjustValue(&$current_node){
	if(is_array($current_node)){
		if(isset($current_node['array'])){
			if(!is_array($current_node['array']['data'])){
				return array();
			}else{
				$temp = &$current_node['array']['data']['value'];
				if(is_array($temp) and array_key_exists(0, $temp)){
					$count = count($temp);
					for($n=0;$n<$count;$n++){
						$temp2[$n] = &XMLRPC_adjustValue(&$temp[$n]);
					}
					$temp = &$temp2;
				}else{
					$temp2 = &XMLRPC_adjustValue(&$temp);
					$temp = array(&$temp2);
				}
			}
		}elseif(isset($current_node['struct'])){
			if(!is_array($current_node['struct'])){
				return array();
			}else{
				$temp = &$current_node['struct']['member'];
				if(is_array($temp) and array_key_exists(0, $temp)){
					$count = count($temp);
					for($n=0;$n<$count;$n++){
						$temp2[$temp[$n]['name']] = &XMLRPC_adjustValue(&$temp[$n]['value']);
					}
				}else{
					$temp2[$temp['name']] = &XMLRPC_adjustValue(&$temp['value']);
				}
				$temp = &$temp2;
			}
		}else{
			$types = array('string', 'int', 'i4', 'double', 'dateTime.iso8601', 'base64', 'boolean');
			$fell_through = true;
			foreach($types as $type){
				if(array_key_exists($type, $current_node)){
					$temp = &$current_node[$type];
					$fell_through = false;
					break;
				}
			}
			if($fell_through){
				$type = 'string';
			}
			switch ($type){
				case 'int': case 'i4': $temp = (int)$temp;    break;
				case 'string':         $temp = (string)$temp; break;
				case 'double':         $temp = (double)$temp; break;
				case 'boolean':        $temp = (bool)$temp;   break;
			}
		}
	}else{
		$temp = (string)$current_node;
	}
	return $temp;
}

function XMLRPC_getParams($request){
	if(!is_array($request['methodCall']['params'])){
		return array();
	}else{
		$temp = &$request['methodCall']['params']['param'];
		if(is_array($temp) and array_key_exists(0, $temp)){
			$count = count($temp);
			for($n = 0; $n < $count; $n++){
				$temp2[$n] = &XMLRPC_adjustValue(&$temp[$n]['value']);
			}
		}else{
			$temp2[0] = &XMLRPC_adjustValue($temp['value']);
		}
		$temp = &$temp2;
		return $temp;
	}
}

function XMLRPC_getMethodName($methodCall){
	return $methodCall['methodCall']['methodName'];
}

function XMLRPC_request($site, $location, $methodName, $params = NULL, $user_agent = NULL){
	$site = explode(':', $site);
	if(isset($site[1]) and is_numeric($site[1])){
		$port = $site[1];
	}else{
		$port = 80;
	}
	$site = $site[0];

	$data["methodCall"]["methodName"] = $methodName;
	$param_count = count($params);
	if(!$param_count){
		$data["methodCall"]["params"] = NULL;
	}else{
		for($n = 0; $n<$param_count; $n++){
			$data["methodCall"]["params"]["param"][$n]["value"] = $params[$n];
		}
	}
	$data = XML_serialize($data);

	if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
		XMLRPC_debug('XMLRPC_request', "<p>Received the following parameter list to send:</p>" . XMLRPC_show($params, 'print_r', true));
	}
	$conn = fsockopen ($site, $port);
	if(!$conn){ 
		if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
			XMLRPC_debug('XMLRPC_request', "<p>Connection failed: Couldn't make the connection to $site.</p>");
		}
		return array(false, array('faultCode'=>10532, 'faultString'=>"Connection failed: Couldn't make the connection to $site."));
	}else{
		$headers =
			"POST $location HTTP/1.0\r\n" .
			"Host: $site\r\n" .
			"Connection: close\r\n" .
			($user_agent ? "User-Agent: $user_agent\r\n" : '') .
			"Content-Type: text/xml\r\n" .
			"Content-Length: " . strlen($data) . "\r\n\r\n";

		fputs($conn, "$headers");
		fputs($conn, $data);

		if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
			XMLRPC_debug('XMLRPC_request', "<p>Sent the following request:</p>\n\n" . XMLRPC_show($headers . $data, 'print_r', true));
		}

		#socket_set_blocking ($conn, false);
		$response = "";
		while(!feof($conn)){
			$response .= fgets($conn, 1024);
		}
		fclose($conn);

		#strip headers off of response
		$data = XML_unserialize(substr($response, strpos($response, "\r\n\r\n")+4));

		if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
			XMLRPC_debug('XMLRPC_request', "<p>Received the following response:</p>\n\n" . XMLRPC_show($response, 'print_r', true) . "<p>Which was serialized into the following data:</p>\n\n" . XMLRPC_show($data, 'print_r', true));
		}
		if(isset($data['methodResponse']['fault'])){
			$return =  array(false, XMLRPC_adjustValue(&$data['methodResponse']['fault']['value']));
			if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
				XMLRPC_debug('XMLRPC_request', "<p>Returning:</p>\n\n" . XMLRPC_show($return, 'var_dump', true));
			}
			return $return;
		}else{
			$return = array(true, XMLRPC_adjustValue(&$data['methodResponse']['params']['param']['value']));
			if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
				XMLRPC_debug('XMLRPC_request', "<p>Returning:</p>\n\n" . XMLRPC_show($return, 'var_dump', true));
			}
			return $return;
		}
	}
}

function XMLRPC_response($return_value, $server = NULL){
	$data["methodResponse"]["params"]["param"]["value"] = &$return_value;
	$return = XML_serialize(&$data);

	if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
		XMLRPC_debug('XMLRPC_response', "<p>Received the following data to return:</p>\n\n" . XMLRPC_show($return_value, 'print_r', true));
	}

	header("Connection: close");
	header("Content-Length: " . strlen($return));
	header("Content-Type: text/xml");
	header("Date: " . date("r"));
	if($server){
		header("Server: $server");
	}

	if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
		XMLRPC_debug('XMLRPC_response', "<p>Sent the following response:</p>\n\n" . XMLRPC_show($return, 'print_r', true));
	}
	echo $return;
}

function XMLRPC_error($faultCode, $faultString, $server = NULL){
	$array["methodResponse"]["fault"]["value"]["struct"]["member"] = array();
	$temp = &$array["methodResponse"]["fault"]["value"]["struct"]["member"];
	$temp[0]["name"] = "faultCode";
	$temp[0]["value"]["int"] = $faultCode;
	$temp[1]["name"] = "faultString";
	$temp[1]["value"]["string"] = $faultString;

	$return = XML_serialize($array);

	header("Connection: close");
	header("Content-Length: " . strlen($return));
	header("Content-Type: text/xml");
	header("Date: " . date("r"));
	if($server){
		header("Server: $server");
	}
	if(defined('XMLRPC_DEBUG') and XMLRPC_DEBUG){
		XMLRPC_debug('XMLRPC_error', "<p>Sent the following error response:</p>\n\n" . XMLRPC_show($return, 'print_r', true));
	}
	echo $return;
}

function XMLRPC_convert_timestamp_to_iso8601($timestamp){
	return date("Ymd\TH:i:s", $timestamp);
}

function XMLRPC_convert_iso8601_to_timestamp($iso8601){
	return strtotime($iso8601);
}

function count_numeric_items(&$array){
	return is_array($array) ? count(array_filter(array_keys($array), 'is_numeric')) : 0;
}

function XMLRPC_debug($function_name, $debug_message){
	$GLOBALS['XMLRPC_DEBUG_INFO'][] = array($function_name, $debug_message);
}

function XMLRPC_debug_print(){
	if($GLOBALS['XMLRPC_DEBUG_INFO']){
		echo "<table border=\"1\" width=\"100%\">\n";
		foreach($GLOBALS['XMLRPC_DEBUG_INFO'] as $debug){
			echo "<tr><th style=\"vertical-align: top\">$debug[0]</th><td>$debug[1]</td></tr>\n";
		}
		echo "</table>\n";
		unset($GLOBALS['XMLRPC_DEBUG_INFO']);
	}else{
		echo "<p>No debugging information available yet.</p>";
	}
}

function XMLRPC_show($data, $func = "print_r", $return_str = false){
	ob_start();
	$func($data);
	$output = ob_get_contents();
	ob_end_clean();
	if($return_str){
		return "<pre>" . htmlspecialchars($output) . "</pre>\n";
	}else{
		echo "<pre>", htmlspecialchars($output), "</pre>\n";
	}
}
?>