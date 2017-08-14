<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coa extends MY_Controller {
	private $any_error = array();
	public $tbl = 'coas';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,83);
		$this->permit = $akses['permit_acces'];
	}

	/* pages begin */
	public function index(){
		$this->view();
	}

	function check_user_access(){
		if(!$this->logged_in){
			redirect('Login');
		}

	}

	public function view(){

		if($this->permit == ''){
			redirect('Page-Unauthorized'); 
		}

		if (strpos($this->permit, 'c') !== false){
			$c = '';
		} else {
			$c = 'disabled';
		}

		$data = array(
			'aplikasi'		=> 'Bali System',
			'title_page' 	=> 'Master-Data / Coa',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('Coa_v', $data);
	}

	

	public function load_data(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$select = '*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'coa_name',
			'param'	 => $this->input->get('search[value]')
		);
		$where['data'][]=array(
			'column'	=>'coa_parent',
			'param'		=>0
			);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$query_total = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		$query_filter = $this->g_mod->select($select,$this->tbl,NULL,$where_like,$order,NULL,$where);
		$query = $this->g_mod->select($select,$this->tbl,$limit,$where_like,$order,NULL,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->coa_id>0) {
					$response['data'][] = array(
						$val->coa_id,
						$val->coa_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->coa_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>'
					);
					$no++;	
				}
			}
		}

		$response['recordsTotal'] = 0;
		if ($query_total<>false) {
			$response['recordsTotal'] = $query_total->num_rows();
		}
		$response['recordsFiltered'] = 0;
		if ($query_filter<>false) {
			$response['recordsFiltered'] = $query_filter->num_rows();
		}

		echo json_encode($response);
	}

	public function load_data_where($id){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'coa_id',
			'param'	 => $id
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'coa_id'			=> $val->coa_id,
					'coa_name' 		=> $val->coa_name,
					'coa_parent' 		=> $val->coa_parent,
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		$id2 = $this->input->post('i_coa');
		if (!$id2) {
			$id2 = 0;
		}
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data($id2);
			//WHERE
			$where['data'][] = array(
				'column' => 'coa_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data($id2);
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	

	/* Saving $data as array to database */
	function general_post_data($id2){
		if (!$id2) {
			$id2 = 0;
		}
		$data = array(
			'coa_name' 		=> $this->input->post('i_name', TRUE),
			'coa_parent' 		=> $id2,
			'coa_nomor' 		=> $this->input->post('i_nomor',TRUE)
			);

		return $data;
	}

	public function load_data_select_coa(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'coa_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'coa_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->coa_id,
					'text'	=> $val->coa_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_nomor($id){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'coa_id',
			'param'	 => $id
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'coa_nomor' 		=> $val->coa_nomor,
				);
			}

			echo json_encode($response);
		}
	}
	public function load_data_cek($id){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'coa_nomor',
			'param'	 => $id
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'coa_nomor' 		=> $val->coa_nomor,
				);
			}

			echo json_encode($response);
		}
	}
}