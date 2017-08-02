<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends MY_Controller {
	private $any_error = array();
	public $tbl = 'purchases';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,75);
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
			'title_page' 	=> 'Transaksi / Pembelian',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('purchase_v', $data);
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
		$tbl = 'purchases a';
		$select = 'a.*,b.partner_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'partner_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'partners b',
			'join'	=> 'b.partner_id=a.partner_id',
			'type'	=> 'inner'
		);
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->purchase_id>0) {
					$response['data'][] = array(
						$val->purchase_code,
						$val->purchase_date,
						$val->partner_name,
						$val->purchase_tempo,
						$val->purchase_desc,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->purchase_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->purchase_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'purchases_details a';
		$select = 'a.*,b.item_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name',
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
			'column' => 'purchase_id',
			'param'	 => $id
		);

		if (!$id) {
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
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->purchase_detail_id>0) {
					$response['data'][] = array(
						$val->purchase_detail_id,
						$val->item_name,
						$val->purchase_detail_qty,
						$val->purchase_detail_price,
						$val->purchase_detail_discount,
						$val->purchase_detail_cost_transport,
						$val->purchase_detail_cost_send,
						$val->purchase_detail_cost_etc,
						$val->purchase_detail_total,
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="edit_data_detail('.$val->purchase_detail_id.')"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->purchase_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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


	public function action_data(){
		$id = $this->input->post('i_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'purchase_id',
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
			//echo $data['purchase_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['purchase_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'purchase_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('purchases_details', $where2, $data2);
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
		$id = $this->input->post('i_purchase_detail_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'purchase_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('purchases_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
			
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			//echo $data['warehouse_img'];
			$insert = $this->g_mod->insert_data_table('purchases_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function general_post_data_detail(){

		$data = array(
			'purchase_id' 			=> $this->input->post('i_purchase_id', TRUE),
			'item_id' 						=> $this->input->post('i_item', TRUE),
			'user_id' 						=> $this->user_id,
			'purchase_detail_qty' 				=> $this->input->post('i_qty', TRUE),
			'purchase_detail_price' 				=> $this->input->post('i_price', TRUE),
			'purchase_detail_discount' 				=> $this->input->post('i_diskon', TRUE),
			'purchase_detail_cost_transport' 				=> $this->input->post('i_angkut', TRUE),
			'purchase_detail_cost_send' 				=> $this->input->post('i_send', TRUE),
			'purchase_detail_cost_etc' 				=> $this->input->post('i_etc', TRUE),
			'purchase_detail_total' 				=> $this->input->post('i_total', TRUE)
			);
			

		return $data;
	}

	function get_code_purchase(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(purchase_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(purchase_code,1,8)',
            'param'     => 'PU'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'purchase_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('PU',$query);
        return $new_code;
    }


	function general_post_data($id){

		if (!$id) {
			$data['purchase_code'] = $this->get_code_purchase();
		}

		$data['purchase_date'] =$this->format_date_day_mid($this->input->post('i_date_purchase', TRUE));
		$data['partner_id'] = $this->input->post('i_partner', TRUE);
		$data['purchase_tempo'] = $this->format_date_day_mid($this->input->post('i_date_tempo', TRUE));
		$data['purchase_desc'] = $this->input->post('i_desc', TRUE);
		/*$data = array(
			'purchase_date' 		=> $this->format_date_day_mid($this->input->post('i_date_purchase', TRUE)),
			'partner_id' 		=> $this->input->post('i_partner', TRUE),
			'purchase_tempo' 	=> $this->format_date_day_mid($this->input->post('i_date_tempo', TRUE)),
			'purchase_desc' 		=> $this->input->post('i_desc', TRUE)
			);*/
			

		return $data;
	}


	public function load_data_where(){
		$select = 'a.*,b.partner_name';
		$tbl = 'purchases a';
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'partners b',
			'join'	=> 'b.partner_id=a.partner_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'purchase_id'			=> $val->purchase_id,
					'purchase_date'			=>$this->format_date_day_mid2($val->purchase_date),
					'partner_id' 		=> $val->partner_id,
					'partner_name' 		=> $val->partner_name,
					'purchase_tempo' 		=>$this->format_date_day_mid2($val->purchase_tempo),
					'purchase_desc' 	=> $val->purchase_desc,
				);
			}

			echo json_encode($response);
		}
	}

	

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_id',
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
			'column' => 'purchase_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('purchases_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.item_name';
		$tbl = 'purchases_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'purchase_detail_id'		=> $val->purchase_detail_id,
					'item_id' 					=> $val->item_id,
					'item_name' 					=> $val->item_name,
					'purchase_detail_qty' 		=> $val->purchase_detail_qty,
					'purchase_detail_price' 	=> $val->purchase_detail_price,
					'purchase_detail_discount' 	=> $val->purchase_detail_discount,
					'purchase_detail_cost_transport' 	=> $val->purchase_detail_cost_transport,
					'purchase_detail_cost_send' 	=> $val->purchase_detail_cost_send,
					'purchase_detail_cost_etc' 	=> $val->purchase_detail_cost_etc,
					'purchase_detail_total' 	=> $val->purchase_detail_total,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_select_code(){
		//WHERE LIKE
		/*$sql="SELECT SUM(purchase_detail_qty)- SUM(purchase_detail_qty_akumulation)>0 as total FROM `purchases` JOIN purchases_details ON purchases_details.purchase_id=purchases.purchase_id ";
		$row = $this->g_mod->select_manual($sql);
		$value = $row['total'];
		if ($value==0) {
			
			echo "ggggg";
			}
		else{*/
		
		$where_like['data'][] = array(
			'column' => 'purchase_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'purchase_id',
			'type'	 => 'ASC'
		);
		/*$join['data'][] = array(
			'table' => 'purchases_details b',
			'join'	=> 'b.purchase_id=a.purchase_id',
			'type'	=> 'inner'
		);*/
		
		$query = $this->g_mod->select('*','purchases',NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->purchase_id,
					'text'	=> $val->purchase_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
		
		}

	public function load_data_select_detail(){
		$where_like['data'][] = array(
			'column' => 'item_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_id',
			'type'	 => 'ASC'
		);

		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select('a.*,b.item_name','purchases_details a',NULL,$where_like,$order,$join,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->purchase_detail_id,
					'text'	=> $val->item_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function action_data_item(){
		$id2 	= $this->input->post('i_item');

		$data = $this->general_post_data_item();
		//WHERE
		$where['data'][] = array(
			'column' => 'item_id',
			'param'	 => $id2
		);
		
		$update = $this->g_mod->update_data_table('items', $where, $data);
		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		
		echo json_encode($response);
	}
	function general_post_data_item(){

		$data = array(
			'item_price1' 			=> $this->input->post('i_price', TRUE));
			
			

		return $data;
	}


	
}