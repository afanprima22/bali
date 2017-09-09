<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foreman extends MY_Controller {
	private $any_error = array();
	public $tbl = 'foremans';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,74);
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

		//WHERE
		$where['data'][] = array(
			'column' => 'user_id',
			'param'	 => $this->user_id
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'employees b',
			'join'	=> 'b.employee_id=a.employee_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select('b.employee_name,b.employee_id','users a',NULL,NULL,NULL,$join,$where);
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$employee_name = $val->employee_name;
				$employee_id = $val->employee_id;
			}
		}else{
			$employee_name = '';
			$employee_id = '';
		}
		

		$data = array(
			'aplikasi'		=> 'Bali System',
			'title_page' 	=> 'Setup Data / Mandor Gudang',
			'title' 		=> 'Kelolah Data',
			'mandor' 		=> $employee_name,
			'employee_id' 	=> $employee_id,
			'c'				=> $c
			);

		$this->open_page('foreman/foreman_v', $data);
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
		$tbl = 'foremans a';
		$select = 'a.*,b.employee_name,c.delivery_detail_code,d.warehouse_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'foreman_date,delivery_detail_code,warehouse_name,employee_name',
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
			'table' => 'employees b',
			'join'	=> 'b.employee_id=a.employee_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'delivery_details c',
			'join'	=> 'c.delivery_detail_id=a.delivery_detail_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'warehouses d',
			'join'	=> 'd.warehouse_id=c.warehouse_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->foreman_id>0) {
					$response['data'][] = array(
						$val->foreman_date,
						$val->employee_name,
						$val->warehouse_name,
						$val->delivery_detail_code,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->foreman_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->foreman_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;<button class="btn btn-info btn-xs" type="button" onclick="specifik_data('.$val->delivery_detail_id.')" '.$u.'><i class="glyphicon glyphicon-search"></i></button>'
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
		$select = 'a.*,b.delivery_detail_code';
		$tbl = 'foremans a';
		//WHERE
		$where['data'][] = array(
			'column' => 'foreman_id',
			'param'	 => $this->input->get('id')
		);
		$join['data'][] = array(
			'table' => 'delivery_details b',
			'join'	=> 'b.delivery_detail_id=a.delivery_detail_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'foreman_id'			=> $val->foreman_id,
					'employee_id' 			=> $val->employee_id,
					'delivery_detail_id' 			=> $val->delivery_detail_id,
					'delivery_detail_code' 		=> $val->delivery_detail_code
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
				'column' => 'foreman_id',
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
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			$foreman_id = $insert->output;

			$join['data'][] = array(
				'table' => 'delivery_details b',
				'join'	=> 'b.delivery_detail_id=a.delivery_detail_id',
				'type'	=> 'inner'
			);
			//WHERE
			$where['data'][] = array(
				'column' => 'a.delivery_detail_id',
				'param'	 => $data['delivery_detail_id']
			);
			$query = $this->g_mod->select('a.*,b.delivery_detail_type','delivery_sends a',NULL,NULL,NULL,$join,$where);
			$qty_send = 0;
			$qty_form = 0;
			foreach ($query->result() as $val) {
				$data2 = array(
					'foreman_id' => $foreman_id,
					'delivery_send_id' => $val->delivery_send_id,
					'foreman_detail_qty' => $this->input->post('i_qty'.$val->delivery_send_id, TRUE),
					'user_id' => $this->user_id
					);
				$this->g_mod->insert_data_table('foreman_details', NULL, $data2);
				if ($val->delivery_detail_type == 1) {
					$this->g_mod->update_data_stock('nota_detail_orders','accumulation_qty','nota_detail_order_id',-$data2['foreman_detail_qty'],$val->nota_detail_order_id);
				}else{
					$this->g_mod->update_data_stock('nota_detail_orders','accumulation_now','nota_detail_order_id',-$data2['foreman_detail_qty'],$val->nota_detail_order_id);
				}
				
				$qty_send += $val->delivery_send_qty;
				$qty_form += $data2['foreman_detail_qty'];
			}

			if ($qty_send != $qty_form) {
				$data3['delivery_detail_status'] = 2;
			}else{
				$data3['delivery_detail_status'] = 1;
			}
			$this->g_mod->update_data_table('delivery_details a', $where, $data3);

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
			'column' => 'foreman_id',
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

	/* Saving $data as array to database */
	function general_post_data(){
		/*$data = array(
			'foreman_date' 				=> date('Y-m-d'),
			'employee_id' 				=> $this->input->post('i_employee', TRUE),
			'delivery_detail_id' 		=> $this->input->post('i_code_do', TRUE)
			);*/
		$data['foreman_date'] 			= date('Y-m-d');
		$data['employee_id'] 			= $this->input->post('i_employee', TRUE);
		$data['delivery_detail_id'] 	= $this->input->post('i_code_do', TRUE);

		return $data;
	}

	public function load_view_detail($id,$type_list) {
		
		//echo $id;
		$tbl  = 'delivery_sends a';
		$select = 'a.*,c.item_id,c.item_barcode,c.item_name,item_per_unit,d.unit_name,e.foreman_detail_qty,e.foreman_detail_id,f.warehouse_id';
		//ORDER
		$order['data'][] = array(
			'column' => 'a.delivery_send_id',
			'type'	 => 'ASC'
		);
		
		//JOIN
		$join['data'][] = array(
			'table' => 'nota_detail_orders b',
			'join'	=> 'b.nota_detail_order_id=a.nota_detail_order_id',
			'type'	=> 'inner'
		);	

		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=b.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'units d',
			'join'	=> 'd.unit_id=c.unit_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'foreman_details e',
			'join'	=> 'e.delivery_send_id=a.delivery_send_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'delivery_details f',
			'join'	=> 'f.delivery_detail_id=a.delivery_detail_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.delivery_detail_id',
			'param'	 => $id
		);	

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,$order,$join,$where);

		$tbl2  = 'delivery_details a';
		$select2 = 'a.*,c.warehouse_name,d.foreman_id,f.nota_code';
		
		//JOIN
		$join2['data'][] = array(
			'table' => 'warehouses c',
			'join'	=> 'c.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join2['data'][] = array(
			'table' => 'foremans d',
			'join'	=> 'd.delivery_detail_id=a.delivery_detail_id',
			'type'	=> 'left'
		);	

		//JOIN
		$join2['data'][] = array(
			'table' => 'deliveries e',
			'join'	=> 'e.delivery_id=a.delivery_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join2['data'][] = array(
			'table' => 'notas f',
			'join'	=> 'f.nota_id=e.nota_id',
			'type'	=> 'inner'
		);
		
		$query2 = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,$join2,$where);
		if ($query2<>false) {
			foreach ($query2->result() as $val) {
				$delivery_detail_code 	= $val->delivery_detail_code;
				$warehouse_name 		= $val->warehouse_name;
				$foreman_id 			= $val->foreman_id;
				$nota_code 				= $val->nota_code;
				if ($val->delivery_detail_type == 1) {
			      $type = "Kirim";
			    }else{
			      $type = "Ambil";
			    }
			}
		}else{
			$delivery_detail_code 	= '';
			$warehouse_name 		= '';
			$type 					= '';
			$foreman_id 			= '';
			$nota_code 				= '';
		}
		
		if ($type_list == 1) {
			$this->load->view('foreman/foreman_d',array('query' => $query,'delivery_detail_code' => $delivery_detail_code,'warehouse_name' => $warehouse_name,'type' => $type,'foreman_id' => $foreman_id,'nota_code' => $nota_code));
		}else{
			$this->load->view('foreman/foreman_s',array('query' => $query,'delivery_detail_code' => $delivery_detail_code,'warehouse_name' => $warehouse_name,'type' => $type,'foreman_id' => $foreman_id,'nota_code' => $nota_code));
		}
		
			
 	}

 	public function action_data_spesifik() {
 		$foreman_id = $this->input->post('i_foreman_id', TRUE);

 		$tbl  = 'foreman_details a';
		$select = 'a.*,c.item_id,c.warehouse_id,d.rack_id,e.item_per_unit,f.foreman_rack_id,f.foreman_rack_qty';
		
		//JOIN
		$join['data'][] = array(
			'table' => 'delivery_sends b',
			'join'	=> 'b.delivery_send_id=a.delivery_send_id',
			'type'	=> 'inner'
		);	

		//JOIN
		$join['data'][] = array(
			'table' => 'nota_detail_orders c',
			'join'	=> 'c.nota_detail_order_id=b.nota_detail_order_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'racks d',
			'join'	=> 'd.warehouse_id=c.warehouse_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'items e',
			'join'	=> 'e.item_id=c.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'foreman_racks f',
			'join'	=> 'f.foreman_detail_id=a.foreman_detail_id and f.rack_id = d.rack_id and f.item_id = e.item_id',
			'type'	=> 'left'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.foreman_id',
			'param'	 => $foreman_id
		);	

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$qty = $this->input->post('i_qty_spesifik'.$val->foreman_detail_id.$val->rack_id.$val->item_id, TRUE);
				if ($qty) {
					if (!$val->foreman_rack_qty) {
						$data = array(
							'foreman_detail_id' => $val->foreman_detail_id,
							'rack_id'			=> $val->rack_id,
							'item_id'			=> $val->item_id,
							'foreman_rack_qty'	=> $qty,
							);

						$this->g_mod->insert_data_table('foreman_racks', NULL, $data);

						//stock
						$qty_stock = $qty * $val->item_per_unit;
						$where2 = "and item_id = $val->item_id";
						$this->g_mod->update_data_stock('stocks','stock_qty','rack_id',$qty_stock,$val->rack_id,$where2);
					}else{
						$old_qty_stock 	= $val->foreman_rack_qty * $val->item_per_unit;
						$new_qty_stock 	= $qty * $val->item_per_unit;

						$qty_stock = $new_qty_stock - $old_qty_stock;
						$where3 = "and item_id = $val->item_id";
						$this->g_mod->update_data_stock('stocks','stock_qty','rack_id',$qty_stock,$val->rack_id,$where3);

						$data2['foreman_rack_qty'] = $qty;
						$where2 = "foreman_rack_id = $val->foreman_rack_id";
						$this->g_mod->update_data_table('foreman_racks', NULL, $data2,$where2);
					}
					
				}
				
			}
		}

		$response['status'] = 200;

		echo json_encode($response);
 	}
	/* end Function */

}
