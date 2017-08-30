<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota extends MY_Controller {
	private $any_error = array();
	public $tbl = 'notas';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,72);
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
			'title_page' 	=> 'Transaksi / Nota',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('nota/nota_v', $data);
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
		$tbl  = 'notas a';
		$select = 'a.*,b.customer_name,c.employee_name,(select sum(nota_detail_retail) from nota_details d where d.nota_id = a.nota_id) as retail';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_code,nota_date,customer_name,employee_name',
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
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'employees c',
			'join'	=> 'c.employee_id=a.employee_id',
			'type'	=> 'inner'
		);
		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->nota_id>0) {

					if ($val->nota_status == 0) {
						$status = 'Proses';
					}elseif ($val->nota_status == 1) {
						$status = 'Cancel';
					}

					if ($val->retail) {
						$retail = '&nbsp;&nbsp;<button class="btn btn-info btn-xs" type="button" onclick="get_data_retail('.$val->nota_id.')" '.$u.'><i class="glyphicon glyphicon-search"></i></button>';
					}else{
						$retail = '';
					}
					$response['data'][] = array(
						$val->nota_code,
						$val->nota_date,
						$val->customer_name,
						$val->employee_name,
						$status,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->nota_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->nota_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'.$retail.'&nbsp;&nbsp;<button class="btn btn-print btn-xs" type="button" onclick="printpdf('.$val->nota_id.')" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i>cetak</button>'
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
		$tbl = 'nota_details a';
		$select = 'a.*,b.item_name,b.item_barcode,c.unit_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_barcode,nota_detail_qty,nota_detail_price,nota_detail_promo',
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
			'column' => 'nota_id',
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
		$join['data'][] = array(
			'table' => 'units c',
			'join'	=> 'c.unit_id=b.unit_id',
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

					$sql = "SELECT SUM(nota_detail_order_now) as nota_detail_order_now,SUM(nota_detail_order_qty + nota_detail_order_now) as qty_order
							FROM nota_detail_orders a
							WHERE nota_detail_id = $val->nota_detail_id";

					$row = $this->g_mod->select_manual($sql);

					$order = $row['qty_order'] + $val->nota_detail_retail;
					$total = $val->nota_detail_price * $order - $val->nota_detail_promo;

					$response['data'][] = array(
						$val->item_barcode,
						$val->item_name,
						$val->unit_name,
						$val->nota_detail_qty,
						number_format($val->nota_detail_price),
						$order,
						'<input type="text" class="form-control" onchange="get_detail_update(this.value,'.$val->nota_detail_id.',1)" name="i_qty_retail" value="'.$val->nota_detail_retail.'">',
						'<input type="text" class="form-control money" onchange="get_detail_update(this.value,'.$val->nota_detail_id.',2)" name="i_qty_order" value="'.$val->nota_detail_promo.'">',
						number_format($total),
						$row['nota_detail_order_now'],
						'<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->nota_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_stock('.$val->item_id.','.$val->nota_detail_id.')"><i class="glyphicon glyphicon-search"></i></a>'
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

	public function load_data_stock($id,$detail_id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'warehouses a';
		$select = 'a.*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'warehouse_name',
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
				if ($val->warehouse_id>0) {

					$sql = "SELECT a.*,SUM(c.stock_qty) as stock,d.order_qty,d.order_now,d.qty_accumulation,e.item_per_unit,f.order_now as order_now_qty,f.order_qty as order_qty_qty
							FROM warehouses a
							JOIN racks b on b.warehouse_id = a.warehouse_id
							JOIN stocks c on c.rack_id = b.rack_id
							LEFT JOIN (SELECT z.*,SUM(z.nota_detail_order_qty) as order_qty,SUM(z.nota_detail_order_now) as order_now,SUM(z.accumulation_qty + z.accumulation_now) as qty_accumulation FROM nota_detail_orders z GROUP BY z.warehouse_id,z.item_id) d on d.warehouse_id = a.warehouse_id AND d.item_id = c.item_id 
							JOIN items e on e.item_id = c.item_id
							LEFT JOIN (SELECT z.*,SUM(z.nota_detail_order_qty) as order_qty,SUM(z.nota_detail_order_now) as order_now,SUM(z.accumulation_qty + z.accumulation_now) as qty_accumulation FROM nota_detail_orders z GROUP BY z.warehouse_id,z.item_id,z.nota_detail_id) f on f.warehouse_id = a.warehouse_id AND f.item_id = c.item_id AND f.nota_detail_id = $detail_id
							WHERE c.item_id = $id and a.warehouse_id = $val->warehouse_id";

					$row = $this->g_mod->select_manual($sql);

					$mod = fmod($row['stock'], $row['item_per_unit']);
					$stock = ($row['stock'] - $mod) / $row['item_per_unit'];

					$oc1 = $row['order_qty'] + $row['order_now'] - $row['qty_accumulation'];
					$mod2 = fmod($oc1, $row['item_per_unit']);
					$oc = ($oc1 - $mod2) / $row['item_per_unit'];

					$response['data'][] = array(
						$val->warehouse_name,
						$stock,
						$oc1,
						'<input type="text" class="form-control" onchange="get_qty_order(this.value,'.$val->warehouse_id.','.$id.',1)" name="i_qty_order" placeholder="Qty Order" value="'.$row['order_qty_qty'].'">',
						'<input type="text" class="form-control" onchange="get_qty_order(this.value,'.$val->warehouse_id.','.$id.',2)" name="i_qty_now" placeholder="Qty Order" value="'.$row['order_now_qty'].'">'
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
		$tbl = 'notas a';
		$select = 'a.*,b.customer_name,b.customer_address,b.customer_telp,c.employee_name,f.coa_name,g.warehouse_name,e.nota_code as code_referance';
		//WHERE
		$where['data'][] = array(
			'column' => 'a.nota_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'employees c',
			'join'	=> 'c.employee_id=a.employee_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'coa_details d',
			'join'	=> 'd.coa_detail_id=a.coa_detail_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'notas e',
			'join'	=> 'e.nota_id=a.nota_reference',
			'type'	=> 'left'
		);
		$join['data'][] = array(
			'table' => 'coas f',
			'join'	=> 'f.coa_id=d.coa_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'warehouses g',
			'join'	=> 'g.warehouse_id=d.warehouse_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'nota_id'				=> $val->nota_id,
					'nota_date' 			=> $this->format_date_day_mid2($val->nota_date),
					'customer_id' 			=> $val->customer_id,
					'customer_name' 		=> $val->customer_name,
					'employee_id' 			=> $val->employee_id,
					'employee_name' 		=> $val->employee_name,
					'coa_detail_id' 		=> $val->coa_detail_id,
					'coa_name' 				=> $val->coa_name.' '.$val->warehouse_name,
					'nota_credit_card' 		=> $val->nota_credit_card,
					'nota_desc' 			=> $val->nota_desc,
					'nota_type' 			=> $val->nota_type,
					'nota_tempo' 			=> $this->format_date_day_mid2($val->nota_tempo),
					'nota_reference' 		=> $val->nota_reference,
					'code_referance' 		=> $val->code_referance,
					'customer_address' 		=> $val->customer_address,
					'customer_telp' 		=> $val->customer_telp,
					'nota_member_card'		=> $val->nota_member_card
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
				'column' => 'nota_id',
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

			$sql = "select a.* from employees a 
					join users b on b.employee_id = a.employee_id
					where b.user_id = $this->user_id";
			$result = $this->g_mod->select_manual($sql);
			if ($result['warehouse_id']) {
				$data['warehouse_id'] = $result['warehouse_id'];
			}else{
				$data['warehouse_id'] = 1;
			}
			
			//echo $data['nota_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['nota_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'nota_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('nota_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_detail($id=0){
		
		$customer_id = $this->input->post('i_customer');
		$customer 	= $this->g_mod->read_data('*', 'customers', 'customer_id',$customer_id);

		if ($id == 1) {
			$item_id = $this->input->post('i_item');
			$item 		= $this->g_mod->read_data('*', 'items', 'item_id',$item_id);
		}else{
			$item_barcode = $this->input->post('i_barcode_scan');
			$item 		= $this->g_mod->read_data('*', 'items', 'item_barcode',$item_barcode);
			$data['nota_detail_retail'] 			= 1;
		}
		
		

		switch ($customer['category_price_id']) {
			case '1':
				$price = $item['item_price1'];
				break;
			case '2':
				$price = $item['item_price2'];
				break;
			case '3':
				$price = $item['item_price3'];
				break;
			case '4':
				$price = $item['item_price4'];
				break;
			case '5':
				$price = $item['item_price5'];
				break;
			default:
				$price = $item['item_price1'];
				break;
		}

		$data['nota_id'] 			= $this->input->post('i_id');
		$data['item_id'] 			= $item['item_id'];
		$data['nota_detail_qty'] 	= $item['item_per_unit'];
		$data['nota_detail_price'] 	= $price;
		$data['user_id'] 			= $this->user_id;

			$insert = $this->g_mod->insert_data_table('nota_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		
		
		echo json_encode($response);
	}

	public function action_data_order(){
		$value 			= $this->input->post('value');
		$warehouse_id 	= $this->input->post('warehouse_id');
		$item_id 		= $this->input->post('item_id');
		$detail_id 		= $this->input->post('detail_id');
		$type 			= $this->input->post('type');

		$select = '*';
		$tbl = 'nota_detail_orders';
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_detail_id',
			'param'	 => $detail_id
		);
		$where['data'][] = array(
			'column' => 'warehouse_id',
			'param'	 => $warehouse_id
		);
		$where['data'][] = array(
			'column' => 'item_id',
			'param'	 => $item_id
		);
		

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);

		if ($query<>false) {
			//UPDATE
			if ($type ==1) {
				$data['nota_detail_order_qty'] 	= $value;
			}else{
				$data['nota_detail_order_now'] 	= $value;
			}
			
			
			$update = $this->g_mod->update_data_table('nota_detail_orders', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			if ($type ==1) {
				$data['nota_detail_order_qty'] 	= $value;
			}else{
				$data['nota_detail_order_now'] 	= $value;
			}
			$data['nota_detail_id'] 		= $detail_id;
			$data['warehouse_id'] 			= $warehouse_id;
			$data['item_id'] 				= $item_id;
			//echo $data['nota_img'];
			$insert = $this->g_mod->insert_data_table('nota_detail_orders', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function get_detail_update(){
		$value 			= $this->input->post('value');
		$id 	= $this->input->post('id');
		$type 	= $this->input->post('type');
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_detail_id',
			'param'	 => $id
		);
		
		if ($type == 1) {
			$data['nota_detail_retail'] = $value;
		}else{
			$data['nota_detail_promo'] = $value;
		}
		
		$update = $this->g_mod->update_data_table('nota_details', $where, $data);
		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		
		echo json_encode($response);
	}

	public function action_data_reference(){
		$id 	= $this->input->post('id');
		$nota_id 	= $this->input->post('id_new');
		//WHERE
		$where = "nota_id = $id";

		$query = $this->g_mod->select('*','nota_details',NULL,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {
			foreach ($query->result() as $val) {
				
				$data['nota_id'] 			= $nota_id;
				$data['item_id'] 			= $val->item_id;
				$data['nota_detail_qty'] 	= $val->nota_detail_qty;
				$data['nota_detail_price'] 	= $val->nota_detail_price;
				$data['nota_detail_promo'] 	= $val->nota_detail_promo;
				$data['nota_detail_retail']	= $val->nota_detail_retail;
				$data['user_id'] 			= $this->user_id;

				$insert = $this->g_mod->insert_data_table('nota_details', NULL, $data);
				//WHERE
				$where2 = "nota_detail_id = $val->nota_detail_id";
				$query2 = $this->g_mod->select('*','nota_detail_orders',NULL,NULL,NULL,NULL,NULL,$where2);
				if ($query2<>false) {
					foreach ($query2->result() as $val2) {
						$data2['nota_detail_id'] 			= $insert->output;
						$data2['warehouse_id'] 				= $val2->warehouse_id;
						$data2['item_id'] 					= $val2->item_id;
						$data2['nota_detail_order_qty'] 	= $val2->nota_detail_order_qty;
						$data2['nota_detail_order_now'] 	= $val2->nota_detail_order_now;
						$data2['accumulation_qty'] 			= $val2->accumulation_qty;
						$data2['accumulation_now'] 			= $val2->accumulation_now;

						$insert2 = $this->g_mod->insert_data_table('nota_detail_orders', NULL, $data2);
					}
				}

			}
		}

		$where3['data'][] = array(
			'column' => 'nota_id',
			'param'	 => $id
		);
		$data3['nota_status'] = 1;
		$update = $this->g_mod->update_data_table('notas', $where3, $data3);
		
		if($query<>false) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_id',
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
			'column' => 'nota_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('nota_detail_orders', $where);
		$delete1 = $this->g_mod->delete_data_table('nota_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_nota(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(nota_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(nota_code,1,8)',
			'param'	 => 'NT'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'nota_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('NT',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		if (!$id) {
			$data['nota_code'] 		= $this->get_code_nota();
		}

		$data['customer_id'] 		= $this->input->post('i_customer', TRUE);
		$data['employee_id'] 			= $this->input->post('i_sales', TRUE);
		$data['nota_date'] 			= $this->format_date_day_mid($this->input->post('i_date', TRUE));
		$data['nota_type'] 			= $this->input->post('i_type', TRUE);
		$data['coa_detail_id'] 		= $this->input->post('i_coa', TRUE);
		$data['nota_tempo'] 		= $this->format_date_day_mid($this->input->post('i_date_tempo', TRUE));
		$data['nota_credit_card'] 	= $this->input->post('i_card', TRUE);
		$data['nota_desc'] 			= $this->input->post('i_desc', TRUE);
		$data['nota_member_card'] 	= $this->input->post('i_scan_card', TRUE);

		$nota = $this->input->post('i_nota_id', TRUE);
		if ($nota) {
			$data['nota_reference'] 	= $nota;
		}
		

		/*$data = array(
			'nota_name' 		=> $this->input->post('i_name', TRUE),
			'nota_telp' 		=> $this->input->post('i_telp', TRUE),
			'nota_address' 	=> $this->input->post('i_addres', TRUE),
			'nota_fax' 		=> $this->input->post('i_fax', TRUE),
			'nota_pic' 		=> $this->input->post('i_pic', TRUE)
			);*/
			

		return $data;
	}

	public function load_data_select_nota(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'nota_code',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->nota_id,
					'text'	=> $val->nota_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_nota_detail($id){
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
		//Join
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'a.nota_id',
			'param'	 => $id
		);

		$query = $this->g_mod->select('a.*,b.item_name','nota_details a',NULL,$where_like,$order,$join,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->nota_detail_id,
					'text'	=> $val->item_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function read_coa(){

		$id = $this->input->post('id');

		$tbl = 'coa_details a';
		$select = 'a.*,b.coa_name,c.warehouse_name';

		//JOIN
		$join['data'][] = array(
			'table' => 'coas b',
			'join'	=> 'b.coa_id=a.coa_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'warehouses c',
			'join'	=> 'c.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);

		if ($id == 1) {
			$where = 'a.coa_id <> 3';
		}elseif($id == 2){
			$where = 'a.coa_id = 1';
		}else{
			$where = 'a.coa_id = 3';
		}
		
		//echo $id;
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL,$where);
		$data = "<option value='0'>-- Pilih Coa --</option>";
		$response['notas'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$data .= '<option value="'.$val->coa_detail_id.'">'.$val->coa_name.' '.$val->warehouse_name.'</option>';
			}
		}

		echo json_encode($data);

	}

	public function load_view_retail($id) {
		
		//echo $id;
		$tbl  = 'nota_details a';
		$select = 'a.*,c.item_barcode,c.item_name,c.item_per_unit,d.warehouse_id';
		
		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=a.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'notas d',
			'join'	=> 'd.nota_id=a.nota_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.nota_id',
			'param'	 => $id
		);	

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);

		$tbl2  = 'notas a';
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
				$nota_code 				= $val->nota_code;
				$warehouse_name 		= $val->warehouse_name;
				$customer_name 			= $val->customer_name;
				$nota_id 				= $val->nota_id;
				
			}
		}else{
			$nota_code 					= '';
			$warehouse_name 			= '';
			$customer_name 				= '';
			$nota_id 					= '';
		}
		
		$this->load->view('nota/nota_r',array('query' => $query,'nota_code' => $nota_code,'warehouse_name' => $warehouse_name,'customer_name' => $customer_name,'nota_id' => $nota_id));
		
			
 	}

 	public function action_data_retail() {
 		$nota_id = $this->input->post('i_nota_id', TRUE);

 		$tbl  = 'nota_details a';
 		$select = 'a.*,c.item_barcode,c.item_name,c.item_per_unit,d.warehouse_id,e.rack_id,f.nota_detail_retail_qty,f.nota_detail_retail_id';
		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=a.item_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'notas d',
			'join'	=> 'd.nota_id=a.nota_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'racks e',
			'join'	=> 'e.warehouse_id=d.warehouse_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'nota_detail_retails f',
			'join'	=> 'f.nota_detail_id=a.nota_detail_id and f.rack_id = e.rack_id and f.item_id = c.item_id',
			'type'	=> 'left'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.nota_id',
			'param'	 => $nota_id
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);

		if ($query<>false) {
			foreach ($query->result() as $val) {
				$qty = $this->input->post('i_qty_retail'.$val->nota_detail_id.$val->rack_id.$val->item_id, TRUE);
				if ($qty) {

					if (!$val->nota_detail_retail_qty) {
						$data = array(
							'nota_detail_id' 			=> $val->nota_detail_id,
							'rack_id'					=> $val->rack_id,
							'item_id'					=> $val->item_id,
							'nota_detail_retail_qty'	=> $qty,
							);

						$this->g_mod->insert_data_table('nota_detail_retails', NULL, $data);

						//stock
						$qty_stock = $qty * $val->item_per_unit;
						$where2 = "and item_id = $val->item_id";
						$this->g_mod->update_data_stock('stocks','stock_qty','rack_id',$qty_stock,$val->rack_id,$where2);
					}else{
						$old_qty_stock 	= $val->nota_detail_retail_qty * $val->item_per_unit;
						$new_qty_stock 	= $qty * $val->item_per_unit;

						$qty_stock = $new_qty_stock - $old_qty_stock;
						$where3 = "and item_id = $val->item_id";
						$this->g_mod->update_data_stock('stocks','stock_qty','rack_id',$qty_stock,$val->rack_id,$where3);

						$data2['nota_detail_retail_qty'] = $qty;
						$where2 = "nota_detail_retail_id = $val->nota_detail_retail_id";
						$this->g_mod->update_data_table('nota_detail_retails', NULL, $data2,$where2);

					}
				}
			}
		}

		$response['status'] = 200;

		echo json_encode($response);
 	}

 	public function action_data_customer(){
 		$data['customer_name'] 				= $this->input->post('i_name', TRUE);
		$data['customer_address'] 			= $this->input->post('i_addres', TRUE);
		$data['customer_store'] 			= $this->input->post('i_store', TRUE);
		$data['customer_telp'] 				= $this->input->post('i_telp', TRUE);
		$data['customer_npwp'] 				= $this->input->post('i_no_npwp', TRUE);
		$data['customer_npwp_name'] 		= $this->input->post('i_name_npwp', TRUE);
		$data['city_id'] 					= $this->input->post('i_city', TRUE);
		$data['category_price_id'] 			= $this->input->post('i_category', TRUE);

		$insert = $this->g_mod->insert_data_table('customers', NULL, $data);
		if($insert->status) {
			$response['status'] = '200';
			$response['alert'] = '1';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
 	}

	/* end Function */

	function cetak_nota_pdf($id){
		$sql = "SELECT * FROM 'notas' join nota_details on nota_details.nota_id=notas.nota_id 
				join nota_detail_orders on nota_detail_orders.nota_detail_id=nota_details.nota_detail_id 
				join items on items.item_id=nota_details.item_id 
				join units on units.unit_id=items.unit_id where nota_id = $id";
		$row = $this->g_mod->select_manual($sql);
	}
}
