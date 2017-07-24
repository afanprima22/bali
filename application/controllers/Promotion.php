<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends MY_Controller {
	private $any_error = array();
	public $tbl = 'promotions';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,70);
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
			'title_page' 	=> 'Master Data / Promo',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('promotion_v', $data);
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
		$tbl = 'promotions a';
		$select = 'a.*,b.warehouse_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'promotion_name,warehouse_name,promotion_date1',
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
			'table' => 'warehouses b',
			'join'	=> 'b.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);
		
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->promotion_id>0) {
					$response['data'][] = array(
						$val->promotion_name,
						$val->promotion_date1.' - '.$val->promotion_date2,
						$val->warehouse_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->promotion_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->promotion_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_detail($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'promotion_details a';
		$select = 'a.*,b.item_name as item_promo,c.item_name as item_bonus';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'b.item_name,c.item_name,promotion_detail_price',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
		
		//WHERE
		$where['data'][] = array(
			'column' => 'promotion_id',
			'param'	 => $id
		);

		if (!$id) {
			//WHERE
			$where['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
		}

		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=a.promotion_detail_item',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->promotion_detail_id>0) {
					$response['data'][] = array(
						$val->promotion_detail_id,
						$val->item_promo,
						$val->promotion_detail_qty_min,
						$val->promotion_detail_price,
						$val->item_bonus,
						$val->promotion_detail_qty_bonus,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->promotion_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->promotion_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_where(){
		$tbl = 'promotions a';
		$select = 'a.*,b.warehouse_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'promotion_id',
			'param'	 => $this->input->get('id')
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'warehouses b',
			'join'	=> 'b.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'promotion_id'			=> $val->promotion_id,
					'promotion_name' 		=> $val->promotion_name,
					'warehouse_id' 			=> $val->warehouse_id,
					'warehouse_name' 		=> $val->warehouse_name,
					'promotion_date' 		=> $this->format_date_day_mid2($val->promotion_date1).' - '.$this->format_date_day_mid2($val->promotion_date2)
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$tbl = 'promotion_details a';
		$select = 'a.*,b.item_name as item_promo,c.item_name as item_bonus';
		//WHERE
		$where['data'][] = array(
			'column' => 'promotion_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=a.promotion_detail_item',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'promotion_detail_id'			=> $val->promotion_detail_id,
					'item_id' 						=> $val->item_id,
					'item_promo'					=> $val->item_promo,
					'promotion_detail_qty_min' 		=> $val->promotion_detail_qty_min,
					'promotion_detail_price'		=> $val->promotion_detail_price,
					'promotion_detail_item' 		=> $val->promotion_detail_item,
					'item_bonus'					=> $val->item_bonus,
					'promotion_detail_qty_bonus' 	=> $val->promotion_detail_qty_bonus,
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data();
			//WHERE
			$where['data'][] = array(
				'column' => 'promotion_id',
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
			$data = $this->general_post_data();
			//echo $data['promotion_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['promotion_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'promotion_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('promotion_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'promotion_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('promotion_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			//echo $data['promotion_img'];
			$insert = $this->g_mod->insert_data_table('promotion_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'promotion_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl, $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_detail(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'promotion_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('promotion_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	/* Saving $data as array to database */
	function general_post_data(){

		$date = $this->input->post('i_date');

		$date = str_replace(" ", "", $date);
		$date = explode("-", $date);
		$date1 = $date[0];
		$date2 = $date[1];

		$data = array(
			'promotion_name' 		=> $this->input->post('i_name', TRUE),
			'promotion_date1' 		=> $this->format_date_day_mid($date1),
			'promotion_date2' 		=> $this->format_date_day_mid($date2),
			'warehouse_id' 			=> $this->input->post('i_warehouse', TRUE)
			);
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'promotion_id' 						=> $this->input->post('i_id', TRUE),
			'item_id' 							=> $this->input->post('i_item', TRUE),
			'promotion_detail_qty_min' 			=> $this->input->post('i_detail_qty_min', TRUE),
			'promotion_detail_price' 			=> $this->input->post('i_detail_price', TRUE),
			'promotion_detail_item' 			=> $this->input->post('i_item_bonus', TRUE),
			'promotion_detail_qty_bonus' 		=> $this->input->post('i_detail_qty_bonus', TRUE),
			'user_id' 							=> $this->user_id
			);
			

		return $data;
	}

	public function load_data_select_promotion(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'promotion_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'promotion_name',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['promotions'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['promotions'][] = array(
					'id'	=> $val->promotion_id,
					'text'	=> $val->promotion_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
