<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transales extends MY_Controller {
	private $any_error = array();
	public $tbl = 'transaless';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,79);
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
			'title_page' 	=> 'Transaksi / Biaya-Sales',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('transales_v', $data);
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
		$tbl = 'transaless';
		$select = '*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'transales_id',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->transales_id>0) {
					$response['data'][] = array(
						$val->transales_periode,
						$val->transales_code,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->transales_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->transales_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
				'column' => 'transales_id',
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

			$data2['transales_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'transales_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('transaless_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function get_code_transales(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(transales_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(transales_code,1,8)',
            'param'     => 'TR'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'transales_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('TR',$query);
        return $new_code;
    }


	function general_post_data($id){

		if (!$id) {
			$data['transales_code'] = $this->get_code_transales();
		}

		$data['transales_periode'] = $this->format_date_day_mid($this->input->post('i_date', TRUE));
		$data['cash_id'] = $this->input->post('i_cash', TRUE);
		/*$data = array(
			'purchase_date' 		=> $this->format_date_day_mid($this->input->post('i_date_purchase', TRUE)),
			'partner_id' 		=> $this->input->post('i_partner', TRUE),
			'purchase_tempo' 	=> $this->format_date_day_mid($this->input->post('i_date_tempo', TRUE)),
			'purchase_desc' 		=> $this->input->post('i_desc', TRUE)
			);*/
			

		return $data;
	}

	public function load_data_where(){
		$select = 'a.*,b.cash_code';
		$tbl = 'transaless a';
		//WHERE
		$where['data'][] = array(
			'column' => 'transales_id',
			'param'	 => $this->input->get('id')
		);

		$join['data'][] = array(
			'table' => 'cashs b',
			'join'	=> 'b.cash_id=a.cash_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'transales_id'			=> $val->transales_id,
					'cash_id'			=> $val->cash_id,
					'cash_code'			=> $val->cash_code,
					'transales_periode' 		=>$this->format_date_day_mid2($val->transales_periode)
				);
			}

			echo json_encode($response);
		}
	}

  public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'transales_id',
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

	public function load_data_detail($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'transaless_details a';
		$select = 'a.*,b.sales_name,warehouse_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'sales_name',
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
			'column' => 'transales_id',
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
			'table' => 'saless b',
			'join'	=> 'b.sales_id=a.sales_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'cashs c',
			'join'	=> 'c.cash_id=a.cash_id',
			'type'	=> ''
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'warehouses d',
			'join'	=> 'd.warehouse_id=c.warehouse_id',
			'type'	=> 'inner'
		);

		
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->transales_detail_id>0) {
					$response['data'][] = array(
						$val->transales_detail_id,
						$val->sales_name,
						$val->transales_detail_cost_arround,
						$val->transales_detail_cost_additional,
						$val->warehouse_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->transales_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->transales_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function action_data_detail(){
		$id = $this->input->post('i_detail');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'transales_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('transaless_details', $where, $data);
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
			$insert = $this->g_mod->insert_data_table('transaless_details', NULL, $data);
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
			'transales_id' 			=> $this->input->post('i_transales', TRUE),
			'sales_id' 						=> $this->input->post('i_sales', TRUE),
			'user_id' 						=> $this->user_id,
			'transales_detail_cost_arround' 				=> $this->input->post('i_arround', TRUE),
			'transales_detail_cost_additional' 				=> $this->input->post('i_additional', TRUE),
			'cash_id' 				=> $this->input->post('i_origin', TRUE),
			);
			

		return $data;
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.sales_name,d.warehouse_name';
		$tbl = 'transaless_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'transales_detail_id',
			'param'	 => $this->input->get('id')
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'saless b',
			'join'	=> 'b.sales_id=a.sales_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'cashs c',
			'join'	=> 'c.cash_id=a.cash_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'warehouses d',
			'join'	=> 'd.warehouse_id=c.warehouse_id',
			'type'	=> 'inner'
		);

		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'transales_detail_id'	=> $val->transales_detail_id,
					'sales_id' 			=> $val->sales_id,
					'sales_name' 			=> $val->sales_name,
					'transales_detail_cost_arround' 	=> $val->transales_detail_cost_arround,
					'transales_detail_cost_additional'=> $val->transales_detail_cost_additional,
					'cash_id' 	=> $val->cash_id,
					'warehouse_name' 	=> $val->warehouse_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function delete_data_detail(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'transales_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('transaless_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	
}