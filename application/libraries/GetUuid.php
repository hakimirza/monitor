<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GetUuid extends CI_Controller {

	// SET SUPER GLOBAL
	var $ci = NULL;

	public function __construct() {

		$this->ci =& get_instance();
	}

	public function getUuid($server, $form_id){

	//sample_url => http://localhost:8080/ODKAggregate/view/submissionList?formId=susenas_16
		$url = $server.'/view/submissionList?formId='.$form_id;

		$xml = simplexml_load_file($url);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);

		//array key based on odk xml
		return $array['idList']['id'];
	}
}