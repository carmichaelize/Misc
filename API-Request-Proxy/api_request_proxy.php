<?php

/* 
* Project: API Request Proxy
* URL: https://github.com/scottyc1000/API-Request-Proxy
* Author: Scott Carmichael
* Version: 1.0
*/

class ajax_curl_proxy {

	//Determine if REQUEST is AJAX
	public function is_ajax(){
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
   			return true;
		}
		return false;
	}

	//Build Query String (GET REQUEST)
	public function build_query($params){
    	$url = ltrim($params['url'],'/').'?';
		foreach($params as $item => $value) {
			if($item != 'url'){
				$url = $url.''.$item.'='.$value.'&';
			}
		}
		return $url = rtrim($url, "&");
	}

	//Build Data Array (POST REQUEST)
	public function build_data($params){
		$data_array = array();
		foreach($params as $item => $value) {
			if($item != 'url'){
				$data_array[$item] = $value;
			}
		}
		return $data_array;
	}

	public function execute($data = array()){
		
		//Method type - GET or POST
		if( $this->is_ajax() ){
			if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
				$method = 'post';
				$data = $_POST;
			} else {
				$method = 'get';
				$data = $_GET;
			}
		} else if( isset($data['method']) ) {
			if( $data['method'] == 'POST' ){
				$method = 'post';
			} else {
				$method = 'get';
			}
		} else {
			return 'Method Not Provided';
		}

		if( !isset($data['url']) ){
			return 'URL Not Provided';
		}

		$ch = curl_init();  
	  
		if($method === 'post'){
			$query = $this->build_data($data);
			curl_setopt_array($ch, array(
				CURLOPT_URL => $data['url'],
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_POST => TRUE,
			    CURLOPT_POSTFIELDS => $query,
			    CURLOPT_SSL_VERIFYHOST => 0,
			    CURLOPT_SSL_VERIFYPEER => 0
			));
		} else {
			$query = $this->build_query($data);
			curl_setopt_array($ch, array(
				CURLOPT_URL => $query,
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_HEADER => 0,
			    CURLOPT_SSL_VERIFYHOST => 0,
			    CURLOPT_SSL_VERIFYPEER => 0
			));
		}
		
		// Execute/Parse resulting HTML output  
		$output = curl_exec($ch);

		// Check for Curl Error 
		if ($output === FALSE) {  
		    return "cURL Error: " . curl_error($ch);  
		}  
		  
		//Close Curl Handle
		curl_close($ch); 

		//Return Request Data
		if( $this->is_ajax() ){
			return $output;
		}
		return json_decode($output);

	}

}

//Run and return request
if ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' ){
	$request = new ajax_curl_proxy;
	echo $request->execute();
}

?>