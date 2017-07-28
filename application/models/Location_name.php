<?php

class Location_name extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	// konversi kode ke dalam bentuk nama wilayah

	//TABEL WILAYAH SAYA
	public function getNamaWil($id){

		$id = (string)$id;
		$n = strlen($id);

		switch ($n) {

			case '2':
			$table = 'provinces';
			break;
			case '4':
			$table = 'regencies';
			break;
			case '7':
			$table = 'districts';
			break;
			case '10':
			$table = 'villages';
			break;			
			default:
			return $id;
		}

		$this->db->select('name');
		$this->db->where('id', $id);
		$query = $this->db->get($table);
		if ($query->num_rows()>0) {

			$row = $query->row();
			return $row->name;
		} 
		else return 'N/A';
	}

	//TABEL WILAYAH FAQIH
	// public function getNamaWil($id){

	// 	$n = strlen($id);

	// 	switch ($n) {
	// 		case '2':
	// 		return $this->getProv($id);
	// 		break;
	// 		case '4':
	// 		return $this->getKab($id);
	// 		break;
	// 		case '7':
	// 		return $this->getKec($id);
	// 		break;
	// 		case '10':
	// 		return $this->getDes($id);
	// 		break;			
	// 		default:
	// 		return 'N/A';
	// 		break;
	// 	}
	// }

	// private function getProv($id){

	// 	$id = (string)$id;
	// 	$this->db->select('provinsi');
	// 	$this->db->where('id', $id);
	// 	$query = $this->db->get('provinsi');
	// 	if ($query->num_rows()>0) {

	// 		$row = $query->row();
	// 		return $row->provinsi;
	// 	} 
	// 	else return "N/A";
	// }

	// private function getKab($id){

	// 	$id = (string)$id;
	// 	$idProv = $id[0].$id[1];
	// 	$idKab = $id[2].$id[3];

	// 	$this->db->select('kabupaten');
	// 	$this->db->where(array(
	// 		'id_provinsi' => $idProv, 
	// 		'id' => $idKab
	// 		)
	// 	);
	// 	$query = $this->db->get('kabupaten');
	// 	if ($query->num_rows()>0) {

	// 		$row = $query->row();
	// 		return $row->kabupaten;
	// 	} 
	// 	else return "N/A";
	// }

	// private function getKec($id){

	// 	$id = (string)$id;
	// 	$idProv = $id[0].$id[1];
	// 	$idKab = $id[2].$id[3];
	// 	$idKec = $id[4].$id[5].$id[6];

	// 	$this->db->select('kecamatan');
	// 	$this->db->where(array(
	// 		'id_provinsi' => $idProv, 
	// 		'id_kabupaten' => $idKab,
	// 		'id' => $idKec
	// 		)
	// 	);
	// 	$query = $this->db->get('kecamatan');
	// 	if ($query->num_rows()>0) {

	// 		$row = $query->row();
	// 		return $row->kecamatan;
	// 	} 
	// 	else return "N/A";
	// }

	// private function getDes($id){

	// 	$id = (string)$id;
	// 	$idProv = $id[0].$id[1];
	// 	$idKab = $id[2].$id[3];
	// 	$idKec = $id[4].$id[5].$id[6];
	// 	$idDes = $id[7].$id[8].$id[9];

	// 	$this->db->select('desa');
	// 	$this->db->where(array(
	// 		'id_provinsi' => $idProv, 
	// 		'id_kabupaten' => $idKab,
	// 		'id_kecamatan' => $idKec,
	// 		'id' => $idDes
	// 		)
	// 	);
	// 	$query = $this->db->get('desa');
	// 	if ($query->num_rows()>0) {

	// 		$row = $query->row();
	// 		return $row->desa;
	// 	} 
	// 	else return "N/A";
	// }
}

?>