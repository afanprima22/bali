<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_cus extends MY_Controller {
	private $any_error = array();
	public $tbl = 'retur_cus';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,81);
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
			'title_page' 	=> 'Transaksi / Retur Customer',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('retur_cus_v', $data);
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
		$tbl  = 'retur_cus a';
		$select = 'a.*,b.nota_code,c.customer_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'retur_cus_code,retur_cus_date,customer_name,nota_code',
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
			'table' => 'notas b',
			'join'	=> 'b.nota_id=a.nota_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'customers c',
			'join'	=> 'c.customer_id=b.customer_id',
			'type'	=> 'inner'
		);
		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->retur_cus_id>0) {

					if ($val->retur_cus_status == 0) {
						$status = 'Belum Dipakai';
					}elseif ($val->retur_cus_status == 1) {
						$status = 'Sudah Dipakai';
					}
					
					$response['data'][] = array(
						$val->retur_cus_code,
						$val->retur_cus_date,
						$val->customer_name,
						number_format($val->retur_cus_total),
						$status,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->retur_cus_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->retur_cus_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'retur_cus_details a';
		$select = 'a.*,b.nota_detail_retail,c.item_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,retur_cus_detail_qty,retur_cus_detail_status,retur_cus_detail_desc',
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
			'column' => 'retur_cus_id',
			'param'	 => $id
		);

		if (!$id) {
			//WHERE
			$where['data'][] = array(
				'column' => 'a.user_id',
				'param'	 => $this->user_id
			);
		}

		//JOIN
		$join['data'][] = array(
			'table' => 'nota_details b',
			'join'	=> 'b.nota_detail_id=a.nota_detail_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=b.item_id',
			'type'	=> 'inner'
		);
		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->nota_detail_id>0) {

					$sql = "SELECT SUM(nota_detail_order_qty + nota_detail_order_now) as qty_order
							FROM nota_detail_orders a
							WHERE nota_detail_id = $val->nota_detail_id";

					$row = $this->g_mod->select_manual($sql);

					$order = $row['qty_order'] + $val->nota_detail_retail;

					$response['data'][] = array(
						$val->item_name,
						$order,
						$val->retur_cus_detail_qty,
						$val->retur_cus_detail_desc,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->retur_cus_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button  class="btn btn-danger btn-xs" onclick="delete_data_detail('.$val->retur_cus_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'retur_cus a';
		$select = 'a.*,b.nota_code,c.customer_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'a.retur_cus_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'notas b',
			'join'	=> 'b.nota_id=a.nota_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'customers c',
			'join'	=> 'c.customer_id=b.customer_id',
			'type'	=> 'inner'
		);
		

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'retur_cus_id'			=> $val->retur_cus_id,
					'retur_cus_date' 		=> $this->format_date_day_mid2($val->retur_cus_date),
					'customer_name' 		=> $val->customer_name,
					'nota_id' 				=> $val->nota_id,
					'nota_code' 			=> $val->nota_code,
					'retur_cus_desc' 		=> $val->retur_cus_desc,
					'retur_cus_total' 		=> $val->retur_cus_total
					
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_detail_where(){
		$tbl = 'retur_cus_details a';
		$select = 'a.*,c.item_name,b.nota_detail_retail';
		//WHERE
		$where['data'][] = array(
			'column' => 'a.retur_cus_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'nota_details b',
			'join'	=> 'b.nota_detail_id=a.nota_detail_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=b.item_id',
			'type'	=> 'inner'
		);
		

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$sql = "SELECT SUM(nota_detail_order_qty + nota_detail_order_now) as qty_order
						FROM nota_detail_orders a
						WHERE nota_detail_id = $val->nota_detail_id";

				$row = $this->g_mod->select_manual($sql);

				$order = $row['qty_order'] + $val->nota_detail_retail;

				$response['val'][] = array(
					'retur_cus_detail_id'				=> $val->retur_cus_detail_id,
					'nota_detail_id' 					=> $val->nota_detail_id,
					'retur_cus_detail_qty' 				=> $val->retur_cus_detail_qty,
					'retur_cus_detail_status' 			=> $val->retur_cus_detail_status,
					'retur_cus_detail_desc' 			=> $val->retur_cus_detail_desc,
					'item_name' 						=> $val->item_name,
					'order'								=> $order
					
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'retur_cus_id',
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
			$data = $this->general_post_data($id);

			//echo $data['retur_cu_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			$data2['retur_cus_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'retur_cus_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('retur_cus_details', $where2, $data2);

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
				'column' => 'retur_cus_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('retur_cus_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();

			//echo $data['retur_cu_img'];
			$insert = $this->g_mod->insert_data_table('retur_cus_details', NULL, $data);


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
			'column' => 'retur_cu_id',
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
			'column' => 'retur_cus_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('retur_cus_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_retur_cus(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(retur_cus_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(retur_cus_code,1,8)',
			'param'	 => 'RC'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'retur_cus_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('RC',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		if (!$id) {
			$data['retur_cus_code'] 		= $this->get_code_retur_cus();
			$where = "WHERE a.retur_cus_id = 0 and a.user_id = $this->user_id";
		}else{
			$where = "WHERE a.retur_cus_id = $id";
		}

		$sql = "SELECT SUM(retur_cus_detail_qty * nota_detail_price) as total from retur_cus_details a
 				JOIN nota_details b on b.nota_detail_id = a.nota_detail_id
				$where";

		$row = $this->g_mod->select_manual($sql);

		$data['nota_id'] 					= $this->input->post('i_nota', TRUE);
		$data['retur_cus_total'] 			= $row['total'];
		$data['retur_cus_date'] 			= $this->format_date_day_mid($this->input->post('i_date', TRUE));
		$data['retur_cus_desc'] 			= $this->input->post('i_desc', TRUE);
		
		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'retur_cus_id' 				=> $this->input->post('i_id', TRUE),
			'nota_detail_id' 			=> $this->input->post('i_nota_detail', TRUE),
			'retur_cus_detail_qty' 		=> $this->input->post('i_qty_retur', TRUE),
			'retur_cus_detail_desc' 	=> $this->input->post('i_detail_desc', TRUE),
			'user_id' 					=> $this->user_id
			);
			

		return $data;
	}

	public function load_data_select_retur_cu(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'retur_cu_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'retur_cu_code',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->retur_cu_id,
					'text'	=> $val->retur_cu_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}


	public function load_view_retail($id) {
		
		//echo $id;
		$tbl  = 'retur_cu_details a';
		$select = 'a.*,c.item_barcode,c.item_name,c.item_per_unit,d.warehouse_id';
		
		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=a.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'retur_cus d',
			'join'	=> 'd.retur_cu_id=a.retur_cu_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.retur_cu_id',
			'param'	 => $id
		);	

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);

		$tbl2  = 'retur_cus a';
		$select2 = 'a.*,c.warehouse_name,d.customer_name';
		
		//JOIN
		$join2['data'][] = array(
			'table' => 'warehouses c',
			'join'	=> 'c.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join2['data'][] = array(
			'table' => 'customers d',
			'join'	=> 'd.customer_id=a.customer_id',
			'type'	=> 'inner'
		);

		$query2 = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,$join2,$where);
		if ($query2<>false) {
			foreach ($query2->result() as $val) {
				$retur_cu_code 				= $val->retur_cu_code;
				$warehouse_name 		= $val->warehouse_name;
				$customer_name 			= $val->customer_name;
				$retur_cu_id 				= $val->retur_cu_id;
				
			}
		}else{
			$retur_cu_code 					= '';
			$warehouse_name 			= '';
			$customer_name 				= '';
			$retur_cu_id 					= '';
		}
		
		$this->load->view('retur_cu/retur_cu_r',array('query' => $query,'retur_cu_code' => $retur_cu_code,'warehouse_name' => $warehouse_name,'customer_name' => $customer_name,'retur_cu_id' => $retur_cu_id));
		
			
 	}

 	public function get_qty_order(){
 		$id = $this->input->post('id');

 		$sql = "SELECT (a.nota_detail_retail + b.qty_order) as total_order from nota_details a
 				JOIN 	(SELECT c.nota_detail_id,SUM(nota_detail_order_qty + nota_detail_order_now) as qty_order
						FROM nota_detail_orders c group by c.nota_detail_id) as b on b.nota_detail_id = a.nota_detail_id
				WHERE a.nota_detail_id = $id";

		$row = $this->g_mod->select_manual($sql);

		echo json_encode($row['total_order']);
 	}


	/* end Function */

}
