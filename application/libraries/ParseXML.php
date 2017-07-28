<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ParseXML extends CI_Controller {

	// SET SUPER GLOBAL
	var $ci = NULL;
	private $namaVar = array();

	public function __construct() {

		$this->ci =& get_instance();
	}

	// parsing instance xml odk
	public function getInstance($server, $file, $tag = 'data', $uuids){

		$formId = $this->getFormId($file, $tag);
		$keys = $this->getNamaVar($file, $tag);

		$urls = array();
		$data = array();

		foreach ($uuids as $uuid) {

			$url = $server.'/view/downloadSubmission?formId='.$formId.'%5B%40version%3Dnull+and+%40uiVersion%3Dnull%5D%2F'.$tag.'%5B%40key%3D'.$uuid.'%5D';
			$urls[$uuid] = $url;
		}

		$tidy = new tidy;
		$config = array( 
			'indent' => true, 
			'input-xml' => true, 
			'output-xml' => true 
			);

		foreach ($urls as $uuid => $url) {

			$clean = $tidy->repairString(file_get_contents($url), $config);
			$xmlDoc = new DOMDocument();
			$xmlDoc->loadXML($clean);

			foreach ($keys as $key) {

				$nodes = $xmlDoc->getElementsByTagName($key);

				if ($nodes->length > 0) {
					
					if ($nodes->length > 1) {

						$data[$uuid][$key] = array();

						for ($i=0; $i < $nodes->length; $i++) { 

							$node = $nodes->item($i);
							array_push($data[$uuid][$key], $node->nodeValue);
						}
					}else{

						$node = $nodes->item(0);
						$data[$uuid][$key] = $node->nodeValue;
					}
				}else{

					$data[$uuid][$key] = '';
				}
			}
		}
		// data array 2 dimensi -> data[uuid][variabel]
		return $data;
	}

	// parsing file form XML odk to get variable names
	private function getNamaVar($file, $tag = 'data'){

		global $namaVar;

		$xmlDoc = new DOMDocument();
		$xmlDoc->load(base_url().'form/'.$file);
		$node = $xmlDoc->getElementsByTagName($tag)->item(0);

		foreach ($node->childNodes as $childNode) 
		{ 

			if ($childNode->nodeType != XML_TEXT_NODE && $childNode->nodeName!='meta') 
			{

				if ($childNode->hasChildNodes()) {

				//masuk lagi, sampai node terakhir -> ambil node name
					$namaTag = $this->getChildNode($childNode->childNodes);
					$namaVar[$namaTag] = $namaTag;
				}else{

					$namaVar[$childNode->nodeName] = $childNode->nodeName;
				} 
			} 
		}
		return $this->getCleanArray($namaVar);
	}

	// mengakses ke kedalaman struktur xml tree
	private function getChildNode($childNodes){

		global $namaVar;
		foreach ($childNodes as $childNode) {

			if ($childNode->hasChildNodes()) {

				$this->getChildNode($childNode->childNodes);
			}else if ($childNode->nodeType != XML_TEXT_NODE && $childNode->nodeName!='') {

				$namaVar[$childNode->nodeName] = $childNode->nodeName;
			}
		}
	}

	private function getFormId($file, $tag = 'data'){

		$xmlDoc = new DOMDocument();
		$xmlDoc->load(base_url().'form/'.$file);

		$node = $xmlDoc->getElementsByTagName($tag)->item(0);
		$attrNode = $node->getAttributeNode('id');
		return $attrNode->value;
	}

	//menghapus array yang berisi kosong
	private function getCleanArray($arr){

		$cleanArr = array();
		foreach ($arr as $key => $value) {

			if ($value != '') {

				$cleanArr[$key] = $value; 
			}
		}
		return $cleanArr;
	}

	

}
?>