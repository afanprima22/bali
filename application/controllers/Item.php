<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends MY_Controller {
	private $any_error = array();
	public $tbl1 	= 'items';
	public $tbl2 	= 'item_clases';
	public $tbl3 	= 'item_sub_clases';
	public $tbl4 	= 'units';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();
        $this->load->library('PdfGenerator');

        $akses = $this->g_mod->get_user_acces($this->user_id,65);
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
			'title_page' 	=> 'Master Data / Pegawai',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('item/item_v', $data);
	}

	public function load_data_class(){
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
			'column' => 'item_clas_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);		

		$query_total = $this->g_mod->select($select,$this->tbl2,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$this->tbl2,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$this->tbl2,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->item_clas_id>0) {
					$response['data'][] = array(
						$val->item_clas_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_class('.$val->item_clas_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_class('.$val->item_clas_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_sub(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl3 = 'item_sub_clases a';
		$select = 'a.*,b.item_clas_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_clas_name,item_sub_clas_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);		

		//JOIN
		$join['data'][] = array(
			'table' => 'item_clases b',
			'join'	=> 'b.item_clas_id=a.item_clas_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl3,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl3,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl3,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->item_sub_clas_id>0) {
					$response['data'][] = array(
						$val->item_sub_clas_name,
						$val->item_clas_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_sub('.$val->item_sub_clas_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_sub('.$val->item_sub_clas_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_item(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl1 = 'items a';
		$select = 'a.*,b.item_clas_name,c.item_sub_clas_name,d.brand_name,e.unit_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_clas_name,item_sub_clas_name,brand_name,unit_name,item_last_price',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);		

		//JOIN
		$join['data'][] = array(
			'table' => 'item_clases b',
			'join'	=> 'b.item_clas_id=a.item_clas_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_sub_clases c',
			'join'	=> 'c.item_sub_clas_id=a.item_sub_clas_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'brands d',
			'join'	=> 'd.brand_id=a.brand_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'units e',
			'join'	=> 'e.unit_id=a.unit_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl1,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl1,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl1,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->item_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->item_clas_name,
						$val->item_sub_clas_name,
						$val->brand_name,
						$val->unit_name,
						number_format($val->item_last_price),
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_item('.$val->item_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_item('.$val->item_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;<button class="btn btn-warning btn-xs" type="button" onclick="print_pdf('.$val->item_id.')" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i></button>'
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

	public function load_galery($id){
		
		$select2 = '*';
		$tbl2 = 'item_galeries';
				
		//WHERE
		$where2['data'][] = array(
			'column' => 'item_id',
			'param'	 => $id
		);

		$query_galery = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where2);
		
		$this->load->view('item/item_g', array('query_galery' => $query_galery));
		//$this->load->view('layout/footer'); 
		
	}

	public function load_data_unit(){
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
			'column' => 'unit_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);		

		$query_total = $this->g_mod->select($select,$this->tbl4,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$this->tbl4,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$this->tbl4,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->unit_id>0) {
					$response['data'][] = array(
						$val->unit_id,
						$val->unit_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_unit('.$val->unit_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_unit('.$val->unit_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_where_class(){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'item_clas_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl2,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'item_clas_id'			=> $val->item_clas_id,
					'item_clas_name' 		=> $val->item_clas_name
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_sub(){
		$tbl3 = 'item_sub_clases a';
		$select = 'a.*,b.item_clas_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'item_sub_clas_id',
			'param'	 => $this->input->get('id')
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_clases b',
			'join'	=> 'b.item_clas_id=a.item_clas_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select($select,$tbl3,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'item_sub_clas_id'			=> $val->item_sub_clas_id,
					'item_sub_clas_name'		=> $val->item_sub_clas_name,
					'item_clas_id' 				=> $val->item_clas_id,
					'item_clas_name' 			=> $val->item_clas_name
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_item(){
		$tbl1 = 'items a';
		$select = 'a.*,b.item_clas_name,c.item_sub_clas_name,d.brand_name,e.unit_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'item_id',
			'param'	 => $this->input->get('id')
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_clases b',
			'join'	=> 'b.item_clas_id=a.item_clas_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_sub_clases c',
			'join'	=> 'c.item_sub_clas_id=a.item_sub_clas_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'brands d',
			'join'	=> 'd.brand_id=a.brand_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'units e',
			'join'	=> 'e.unit_id=a.unit_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select($select,$tbl1,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'item_id'					=> $val->item_id,
					'item_sub_clas_id'			=> $val->item_sub_clas_id,
					'item_sub_clas_name'		=> $val->item_sub_clas_name,
					'item_clas_id' 				=> $val->item_clas_id,
					'item_clas_name' 			=> $val->item_clas_name,
					'item_name'					=> $val->item_name,
					'brand_id'					=> $val->brand_id,
					'brand_name' 				=> $val->brand_name,
					'item_barcode' 				=> $val->item_barcode,
					'unit_id'					=> $val->unit_id,
					'unit_name'					=> $val->unit_name,
					'item_min' 					=> $val->item_min,
					'item_max' 					=> $val->item_max,
					'item_last_price'			=> $val->item_last_price,
					'item_price1'				=> $val->item_price1,
					'item_price2' 				=> $val->item_price2,
					'item_price3' 				=> $val->item_price3,
					'item_price4' 				=> $val->item_price4,
					'item_price5' 				=> $val->item_price5,
					'item_cost' 				=> $val->item_cost,
					'item_per_unit' 			=> $val->item_per_unit
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_unit(){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'unit_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl4,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'unit_id'			=> $val->unit_id,
					'unit_name' 		=> $val->unit_name
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data_class(){
		$id = $this->input->post('i_id_class');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_class($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'item_clas_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl2, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_class($id);
			//echo $data['item_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl2, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_sub(){
		$id = $this->input->post('i_id_sub');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_sub($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'item_sub_clas_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl3, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_sub($id);
			//echo $data['item_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl3, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_item(){
		$id = $this->input->post('i_id_item');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_item($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'item_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl1, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_item($id);
			//echo $data['item_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl1, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_unit(){
		$id = $this->input->post('i_unit_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_unit($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'unit_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl4, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_unit($id);
			//echo $data['item_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl4, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function delete_data_class(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'item_clas_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl2, $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_sub(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'item_sub_clas_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl3, $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_item(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'item_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl1, $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_unit(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'unit_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl4, $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	/* Saving $data as array to database */
	function general_post_data_class($id){

		$data = array(
			'item_clas_name' 			=> $this->input->post('i_name_class', TRUE)
			);
			
		return $data;
	}

	function general_post_data_sub($id){

		$data = array(
			'item_sub_clas_name' 			=> $this->input->post('i_name_sub', TRUE),
			'item_clas_id' 					=> $this->input->post('i_class_sub', TRUE)
		);
			
		return $data;
	}

	function general_post_data_item($id){

		$data = array(
			'item_clas_id' 			=> $this->input->post('i_class_item', TRUE),
			'item_sub_clas_id' 		=> $this->input->post('i_sub_class_item', TRUE),
			'item_name' 			=> $this->input->post('i_name_item', TRUE),
			'brand_id' 				=> $this->input->post('i_brand', TRUE),
			'item_barcode' 			=> $this->input->post('i_barcode', TRUE),
			'unit_id' 				=> $this->input->post('i_unit', TRUE),
			'item_min' 				=> $this->input->post('i_stok_min', TRUE),
			'item_max' 				=> $this->input->post('i_stok_max', TRUE),
			'item_last_price' 		=> $this->input->post('i_price_last', TRUE),
			'item_price1' 			=> $this->input->post('i_price1', TRUE),
			'item_price2' 			=> $this->input->post('i_price2', TRUE),
			'item_price3' 			=> $this->input->post('i_price3', TRUE),
			'item_price4' 			=> $this->input->post('i_price4', TRUE),
			'item_price5' 			=> $this->input->post('i_price5', TRUE),
			'item_cost' 			=> $this->input->post('i_cost', TRUE),
			'item_per_unit' 		=> $this->input->post('i_qty_unit', TRUE)
		);
			
		return $data;
	}

	function general_post_data_unit($id){

		$data = array(
			'unit_name' 			=> $this->input->post('i_unit_name', TRUE)
			);
			
		return $data;
	}
	
	public function load_data_select_class(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_clas_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_clas_name',
			'type'	 => 'ASC'
		);

		
		$query = $this->g_mod->select('*',$this->tbl2,NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->item_clas_id,
					'text'	=> $val->item_clas_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_sub_class(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_sub_clas_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_sub_clas_name',
			'type'	 => 'ASC'
		);

		
		$query = $this->g_mod->select('*',$this->tbl3,NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->item_sub_clas_id,
					'text'	=> $val->item_sub_clas_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_unit(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'unit_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'unit_name',
			'type'	 => 'ASC'
		);

		
		$query = $this->g_mod->select('*','units',NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->unit_id,
					'text'	=> $val->unit_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_item(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_name',
			'type'	 => 'ASC'
		);

		
		$query = $this->g_mod->select('*',$this->tbl1,NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->item_id,
					'text'	=> $val->item_barcode.'-'.$val->item_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_item_price(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'category_price_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'category_price_name',
			'type'	 => 'ASC'
		);

		
		$query = $this->g_mod->select('*','category_prices',NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->category_price_id,
					'text'	=> $val->category_price_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function action_galery(){
		$new_name = time()."_".$_FILES['i_galery']['name'];
			
		$configUpload['upload_path']    = './images/item/';                 #the folder placed in the root of project
		$configUpload['allowed_types']  = 'gif|jpg|png|bmp|jpeg';       #allowed types description
		$configUpload['max_size']	= 1024 * 8;
		$configUpload['encrypt_name']   = TRUE;   
		$configUpload['file_name'] 		= $new_name;                      	#encrypt name of the uploaded file

		$this->load->library('upload', $configUpload);                  #init the upload class
		$this->upload->initialize($configUpload);

		if(!$this->upload->do_upload('i_galery')){
			$uploadedDetails    = $this->upload->display_errors();
			$response['status'] = '204';
		}else{
			$uploadedDetails    = $this->upload->data(); 
			$response['status'] = '200';

			$data['item_id'] = $this->input->post('i_id_item', TRUE);
			$data['item_galery_file'] = $uploadedDetails['file_name'];

			$this->g_mod->insert_data_table('item_galeries', NULL, $data);
				//$this->_createThumbnail($uploadedDetails['file_name']);
	 
				//$thumbnail_name = $uploadedDetails['raw_name']. '_thumb' .$uploadedDetails['file_ext'];   
		}
		
		echo json_encode($response);
	}

	public function delete_galery(){

		$galery_id = $this->input->post('id_galery', TRUE);

		$select = '*';
		$tbl = 'item_galeries';
				
		//WHERE
		$where['data'][] = array(
			'column' => 'item_galery_id',
			'param'	 => $galery_id
		);

		$query_galery = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query_galery<>false) {
			foreach ($query_galery->result() as $val) {

				$oldfile   = "images/item/".$val->sales_galery_file;
				
				//DELETE IMAGE
				if( file_exists( $oldfile ) ){
		    		unlink( $oldfile );
				}

			}
		}

		//DELETE DATABASE
		//WHERE
		$where2['data'][] = array(
			'column' => 'item_galery_id',
			'param'	 => $galery_id
		);
		$delete = $this->g_mod->delete_data_table($tbl, $where2);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}


	public function load_data_item_detail($id){
		$select = '*';
		$tbl2 = 'items a';
		//WHERE
		$where['data'][] = array(
			'column' => 'item_id',
			'param'	 => $id
		);


		$query = $this->g_mod->select($select,$tbl2,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'item_id' 	=> $val->item_id,
					'item_price1' 	=> $val->item_price1,
					
				);
			}

			echo json_encode($response);
		}
	}

	function print_item_pdf(){

		$id = $this->input->get('id');

		$sql = "SELECT a.*,b.item_clas_id,c.item_sub_clas_id,d.brand_id,e.unit_id FROM items a
				Join item_clases b on b.item_clas_id = a.item_clas_id join item_sub_clases c on c.item_sub_clas_id=a.item_sub_clas_id
				join brands d on d.brand_id = a.brand_id join units e on e.unit_id = a.unit_id
				where a.item_id = $id";
		$result = $this->g_mod->select_manual($sql);

		$data = array(
			'item_report_date' 		=> date("Y/m/d"),
			'item_id' 				=> $result['item_id'],
			'item_barcode' 			=> $result['item_barcode'],
			'item_clas_id' 			=> $result['item_clas_id'], 
			'item_sub_clas_id' 		=> $result['item_sub_clas_id'],
			'brand_id' 				=> $result['brand_id'],
			'unit_id' 				=> $result['unit_id'],
			'item_per_unit' 		=> $result['item_per_unit'],
			'item_last_price'		=> $result['item_last_price'],
			'item_min'				=> $result['item_min'],
			'item_max'				=> $result['item_max'],
			'item_price1' 			=> $result['item_price1'],
			'item_price2' 			=> $result['item_price2'],
			'item_price3'			=> $result['item_price3'],
			'item_price4'			=> $result['item_price4'],
			'item_price5'			=> $result['item_price5'],
			);

		$insert = $this->g_mod->insert_data_table('item_reports', NULL, $data);

		$judul			= "Item Price List";
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/report_item', $data, true);//SEND DATA TO VIEW
	    $paper = 'A4';
    	$orientation = 'portraitid';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	/* end Function */

}
