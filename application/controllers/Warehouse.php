<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends MY_Controller {
	private $any_error = array();
	public $tbl = 'warehouses';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();
        $this->load->library('PdfGenerator');

        $akses = $this->g_mod->get_user_acces($this->user_id,69);
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
			'title_page' 	=> 'Master Data / Gudang',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('warehouse_v', $data);
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
			'column' => 'warehouse_name,warehouse_telp,warehouse_fax,warehouse_pic',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
		
		$query_total = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$this->tbl,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->warehouse_id>0) {
					$response['data'][] = array(
						$val->warehouse_name,
						$val->warehouse_telp,
						$val->warehouse_fax,
						$val->warehouse_pic,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->warehouse_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->warehouse_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;<button class="btn btn-warning btn-xs" type="button" onclick="print_pdf('.$val->warehouse_id.')" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i></button>'
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

	public function load_data_rack($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'racks';
		$select = '*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'rack_name',
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
			'column' => 'warehouse_id',
			'param'	 => $id
		);

		if (!$id) {
			//WHERE
			$where['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
		}

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,NULL,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,NULL,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->rack_id>0) {
					$response['data'][] = array(
						$val->rack_id,
						$val->rack_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_rack('.$val->rack_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_rack('.$val->rack_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_rack_detail('.$val->rack_id.')"><i class="glyphicon glyphicon-list"></i></a>'
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

	public function load_data_rack_detail($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'rack_details a';
		$select = 'a.*,b.item_name,c.stock_qty';
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
			'column' => 'a.rack_id',
			'param'	 => $id
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'stocks c',
			'join'	=> 'c.item_id=a.item_id and c.rack_id=a.rack_id',
			'type'	=> 'inner'
		);


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->rack_detail_id>0) {
					$response['data'][] = array(
						$val->rack_detail_id,
						$val->item_name,
						$val->stock_qty,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_rack_detail('.$val->rack_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_rack_detail('.$val->rack_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_stock($id){
		$tbl = 'racks a';
		$select = 'a.*,b.rack_detail_id,c.item_name,c.item_per_unit,d.stock_qty';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'rack_name,item_name',
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
			'column' => 'warehouse_id',
			'param'	 => $id
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'rack_details b',
			'join'	=> 'b.rack_id=a.rack_id',
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
			'table' => 'stocks d',
			'join'	=> 'd.item_id=b.item_id and d.rack_id=b.rack_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->rack_detail_id>0) {

					if ($val->stock_qty == 0) {
						$stock = 0;
					}else{
						$mod = fmod($val->stock_qty, $val->item_per_unit);
						$stock = ($val->stock_qty - $mod) / $val->item_per_unit;

					}

					$response['data'][] = array(
						$val->rack_name,
						$val->item_name,
						$stock,
						$val->stock_qty
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
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'warehouse_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'warehouse_id'			=> $val->warehouse_id,
					'warehouse_name' 		=> $val->warehouse_name,
					'warehouse_telp' 		=> $val->warehouse_telp,
					'warehouse_address' 	=> $val->warehouse_address,
					'warehouse_fax' 		=> $val->warehouse_fax,
					'warehouse_pic' 		=> $val->warehouse_pic,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_rack(){
		$select = 'a.*';
		$tbl = 'racks a';
		//WHERE
		$where['data'][] = array(
			'column' => 'rack_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'rack_id'		=> $val->rack_id,
					'rack_name' 	=> $val->rack_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_rack_detail(){
		$select = 'a.*,b.item_name,c.stock_qty';
		$tbl = 'rack_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'rack_detail_id',
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
			'table' => 'stocks c',
			'join'	=> 'c.item_id=a.item_id and c.rack_id=a.rack_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'rack_detail_id'	=> $val->rack_detail_id,
					'item_id' 			=> $val->item_id,
					'item_name' 		=> $val->item_name,
					'stock_qty' 		=> $val->stock_qty,
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
				'column' => 'warehouse_id',
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
			//echo $data['warehouse_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['warehouse_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'warehouse_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('racks', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_rack(){
		$id = $this->input->post('i_rack_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_rack();
			//WHERE
			$where['data'][] = array(
				'column' => 'rack_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('racks', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_rack();
			//echo $data['warehouse_img'];
			$insert = $this->g_mod->insert_data_table('racks', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_rack_detail(){
		$id = $this->input->post('i_rack_detail_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_rack_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'rack_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('rack_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
				$response['id'] = $data['rack_id'];
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_rack_detail();
			//echo $data['warehouse_img'];
			$insert = $this->g_mod->insert_data_table('rack_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $data['rack_id'];
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
			'column' => 'warehouse_id',
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

	public function delete_data_rack(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'rack_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('racks', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_rack_detail(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'rack_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('rack_details', $where);
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

		$data = array(
			'warehouse_name' 		=> $this->input->post('i_name', TRUE),
			'warehouse_telp' 		=> $this->input->post('i_telp', TRUE),
			'warehouse_address' 	=> $this->input->post('i_addres', TRUE),
			'warehouse_fax' 		=> $this->input->post('i_fax', TRUE),
			'warehouse_pic' 		=> $this->input->post('i_pic', TRUE)
			);
			

		return $data;
	}

	function general_post_data_rack(){

		$data = array(
			'warehouse_id' 			=> $this->input->post('i_id', TRUE),
			'rack_name' 			=> $this->input->post('i_rack_name', TRUE),
			'user_id' 				=> $this->user_id
			);
			

		return $data;
	}

	function general_post_data_rack_detail(){

		$data = array(
			'rack_id' 				=> $this->input->post('i_detail_id', TRUE),
			'item_id' 				=> $this->input->post('i_item', TRUE)
			);
			
		
		//WHERE
		$where['data'][] = array(
			'column' => 'item_id',
			'param'	 => $this->input->post('i_item', TRUE)
		);
		$where['data'][] = array(
			'column' => 'rack_id',
			'param'	 => $this->input->post('i_detail_id', TRUE)
		);

		$query = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where);
		if ($query==false) {
			
			$data2['item_id'] = $this->input->post('i_item', TRUE);
			$data2['rack_id'] = $this->input->post('i_detail_id', TRUE);

			$this->g_mod->insert_data_table('stocks', NULL, $data2);
		}

		$data3['stock_qty'] = $this->input->post('i_stock_qty', TRUE);
		$this->g_mod->update_data_table('stocks', $where, $data3);

		return $data;
	}

	public function load_data_select_warehouse(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'warehouse_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'warehouse_name',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->warehouse_id,
					'text'	=> $val->warehouse_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	function print_stock_pdf(){

		$id = $this->input->get('id');
		$tbl = 'racks a';
		$select = 'a.*,b.rack_detail_id,c.item_id,c.item_per_unit,d.stock_qty';
				
		//WHERE
		$where['data'][] = array(
			'column' => 'warehouse_id',
			'param'	 => $id
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'rack_details b',
			'join'	=> 'b.rack_id=a.rack_id',
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
			'table' => 'stocks d',
			'join'	=> 'd.item_id=b.item_id and d.rack_id=b.rack_id',
			'type'	=> 'inner'
		);

		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		foreach ($query->result() as $row){ 
			if ($row->stock_qty == 0) {
						$stock = 0;
					}else{
						$mod = fmod($row->stock_qty, $row->item_per_unit);
						$stock = ($row->stock_qty - $mod) / $row->item_per_unit;

					}
					
			$data = array(
				'stock_report_date' 		=> date("Y/m/d"),
				'rack_id' 				=> $row->rack_id,
				'item_id' 		=> $row->item_id,
				'stock_report_qty' 			=> $stock, 
				'stock_qty' 		=> $row->stock_qty,
				'warehouse_id' 				=> $row->warehouse_id,

				);
			$insert = $this->g_mod->insert_data_table('stock_reports', NULL, $data);
		}
		$judul			= "Stock Barang Per Gudang";
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/report_stock', $data, true);//SEND DATA TO VIEW
	    $paper = 'A4';
    	$orientation = 'portraitid';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	/* end Function */

}
