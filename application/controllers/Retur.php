<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur extends MY_Controller {
	private $any_error = array();
	public $tbl = 'returs_suppliers';
	public $tbl1 = 'purchases_details';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,77);
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
			'title_page' 	=> 'Transaksi / Return Supplier',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('retur_v', $data);
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
		$tbl = 'returs_suppliers a';
		$select = 'a.*,b.purchase_code';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'purchase_code',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'purchases b',
			'join'	=> 'b.purchase_id=a.purchase_id',
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
						$val->retur_supplier_date,
						$val->retur_supplier_code,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->retur_supplier_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->retur_supplier_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
				'column' => 'retur_supplier_id',
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

			$data2['retur_supplier_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'retur_supplier_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('returs_suppliers_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function get_code_retur_supplier(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(retur_supplier_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(retur_supplier_code,1,8)',
            'param'     => 'RS'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'retur_supplier_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('RS',$query);
        return $new_code;
    }


	function general_post_data($id){

		if (!$id) {
			$data['retur_supplier_code'] = $this->get_code_retur_supplier();
		}

		$data['purchase_id'] = $this->input->post('i_code', TRUE);
		$data['retur_supplier_date'] = $this->format_date_day_mid($this->input->post('i_date', TRUE));
		/*$data = array(
			'purchase_date' 		=> $this->format_date_day_mid($this->input->post('i_date_purchase', TRUE)),
			'partner_id' 		=> $this->input->post('i_partner', TRUE),
			'purchase_tempo' 	=> $this->format_date_day_mid($this->input->post('i_date_tempo', TRUE)),
			'purchase_desc' 		=> $this->input->post('i_desc', TRUE)
			);*/
			

		return $data;
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
		$tbl = 'returs_suppliers_details a';
		$select = 'a.*,c.item_name';
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
		
		
		
		//JOIN
		$join['data'][] = array(
			'table' => 'purchases_details b',
			'join'	=> 'b.purchase_detail_id=a.purchase_detail_id',
			'type'	=> 'inner'
		);

		//where
		
		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=b.item_id',
			'type'	=> 'inner'
		);

		/*//JOIN
		$join['data'][] = array(
			'table' => 'units e',
			'join'	=> 'e.unit_id=a.unit_id',
			'type'	=> 'inner'
		);*/
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->retur_supplier_id>0) {
					$response['data'][] = array(
						$val->retur_supplier_detail_id,
						$val->item_name,
						$val->retur_supplier_detail_qty,
						
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="edit_data_detail('.$val->retur_supplier_detail_id.')"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->retur_supplier_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'retur_supplier_id',
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

	public function load_data_where(){
		$select = 'a.*,b.purchase_code';
		$tbl = 'returs_suppliers a';
		//WHERE
		$where['data'][] = array(
			'column' => 'retur_supplier_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'purchases b',
			'join'	=> 'b.purchase_id=a.purchase_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'retur_supplier_id'			=> $val->retur_supplier_id,
					'purchase_id'			=>$val->purchase_id,
					'purchase_code' 		=> $val->purchase_code,
					'retur_supplier_date' 		=>$this->format_date_day_mid2($val->retur_supplier_date),
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'retur_supplier_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('returs_suppliers_details', $where, $data);
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
			$insert = $this->g_mod->insert_data_table('returs_suppliers_details', NULL, $data);
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
			'retur_supplier_id' 			=> $this->input->post('i_retur', TRUE),
			'user_id' 						=> $this->user_id,
			'purchase_detail_id' 						=> $this->input->post('i_item',TRUE),
			'retur_supplier_detail_qty' 				=> $this->input->post('i_qty', TRUE),
			);
			

		return $data;
	}

	public function load_data_where_detail(){
		$select = 'a.*,c.item_name';
		$tbl = 'returs_suppliers_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'retur_supplier_detail_id',
			'param'	 => $this->input->get('id')
		);

		

		//JOIN
		$join['data'][] = array(
			'table' => 'purchases_details b',
			'join'	=> 'b.purchase_detail_id=a.purchase_detail_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=b.item_id',
			'type'	=> 'inner'
		);

		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'retur_supplier_detail_id'	=> $val->retur_supplier_detail_id,
					'item_name' 	=> $val->item_name,
					'retur_supplier_detail_qty' 	=> $val->retur_supplier_detail_qty,
				);
			}

			echo json_encode($response);
		}
	}

	public function delete_data_detail(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'retur_supplier_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('returs_suppliers_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function load_data_retur_detail($id){
		$select = '*';
		$tbl2 = 'purchases_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_detail_id',
			'param'	 => $id
		);/*

		$join['data'][] = array(
			'table' => 'purchases_details b',
			'join'	=> 'b.purchase_detail_id=a.purchase_detail_id',
			'type'	=> 'inner'
		);*/

		



		$query = $this->g_mod->select($select,$tbl2,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'purchase_detail_qty'	=> $val->purchase_detail_qty,
					
				);
			}

			echo json_encode($response);
		}
	}

}