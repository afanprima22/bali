<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutation extends MY_Controller {
	private $any_error = array();
	public $tbl = 'mutations';
	public $tbl1 = 'racks';

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
			'title_page' 	=> 'Transaksi / Mutasi',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('mutation_v', $data);
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
		$tbl = 'mutations a';
		$select = 'a.*,b.warehouse_name';
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
				if ($val->mutation_id>0) {
					$response['data'][] = array(
						$val->mutation_date,
						$val->warehouse_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->mutation_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->mutation_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
			'column' => 'mutation_id',
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
    $select = 'a.*,b.warehouse_name';
    $tbl = 'mutations a';
    //WHERE
    $where['data'][] = array(
      'column' => 'mutation_id',
      'param'  => $this->input->get('id')
    );

    $join['data'][] = array(
      'table' => 'warehouses b',
      'join'  => 'b.warehouse_id=a.warehouse_id',
      'type'  => 'inner'
    );
    $query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
    if ($query<>false) {

      foreach ($query->result() as $val) {
        $response['val'][] = array(
          'mutation_id'     => $val->mutation_id,
          'mutation_date'     =>$this->format_date_day_mid2($val->mutation_date),
          'warehouse_id'    => $val->warehouse_id,
          'warehouse_name'    => $val->warehouse_name,
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
				'column' => 'mutation_id',
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
			//echo $data['purchase_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['mutation_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'mutation_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('mutation_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	
	function general_post_data(){

		$data = array(
			'warehouse_id' 			=> $this->input->post('i_warehouse', TRUE),
			'mutation_date' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);
			

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
		$tbl = 'mutation_details a';
		$select = 'a.*,c.rack_name,d.item_name,d.item_barcode,d.item_per_unit,e.warehouse_name,b.unit_name,f.rack_name as name';
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
			'column' => 'mutation_id',
			'param'	 => $id
		);
		
		

		$join['data'][] = array(
			'table' => 'racks c',
			'join'	=> 'c.rack_id=a.rack_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'racks f',
			'join'	=> 'f.rack_id=a.rack_id2',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items d',
			'join'	=> 'd.item_id=a.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'warehouses e',
			'join'	=> 'e.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'units b',
			'join'	=> 'b.unit_id=d.unit_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->mutation_detail_id>0) {
					
					
					$response['data'][] = array(
						$val->item_barcode,
						$val->item_name,
						$val->unit_name,
						$val->item_per_unit,
						$val->mutation_detail_qty,
						$val->rack_name,
						$val->warehouse_name,
						$val->name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->mutation_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->mutation_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_item($id){
    $select = 'a.*,b.unit_name';
    $tbl = 'items a';
    //WHERE
    $where['data'][] = array(
      'column' => 'item_id',
      'param'  => $id
    );

    $join['data'][] = array(
			'table' => 'units b',
			'join'	=> 'b.unit_id=a.unit_id',
			'type'	=> 'inner'
		);
    $query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
    if ($query<>false) {

      foreach ($query->result() as $val) {
        $response['val'][] = array(
          'item_barcode'     =>$val->item_barcode,
          'unit_name'     =>$val->unit_name,
          'item_per_unit'     =>$val->item_per_unit,
          
		
        );
      }

      echo json_encode($response);
    }
  }

  public function load_data_select_rack($id){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'rack_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'rack_name',
			'type'	 => 'ASC'
		);
		$where['data'][]=array(
			'column'	=>'warehouse_id',
			'param'		=>$id
			);

		
		$query = $this->g_mod->select('*',$this->tbl1,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->rack_id,
					'text'	=> $val->rack_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail');
		if (strlen($id)>0) {
			$sql ="SELECT * FROM mutation_details";
			$row = $this->g_mod->select_manual($sql);
			$id3 = $row['mutation_detail_qty'];
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'mutation_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('mutation_details', $where, $data);

			$qty =$data['mutation_detail_qty']-$id3;
			$rack = $this->input->post('i_rack', TRUE);
			$rack2 = $this->input->post('i_rack2', TRUE);
			$update2 = $this->g_mod->update_data_stock('stocks', 'stock_qty','rack_id',$qty,$rack, 'and item_id = '. $this->input->post('i_item', TRUE));
			$update3 = $this->g_mod->update_data_Qty('stocks', 'stock_qty','rack_id',$qty,$rack2, 'and item_id = '. $this->input->post('i_item', TRUE));
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
			$insert = $this->g_mod->insert_data_table('mutation_details', NULL, $data);
			$data2 = $this->general_post_data_rack_detail();
			//echo $data['warehouse_img'];
			$insert2 = $this->g_mod->insert_data_table('rack_details', NULL, $data2);
			$rack = $this->input->post('i_rack', TRUE);
			$update = $this->g_mod->update_data_stock('stocks', 'stock_qty','rack_id',$this->input->post('i_qty_mutasi'),$rack, 'and item_id = '. $this->input->post('i_item', TRUE));
			$update2 = $this->g_mod->update_data_Qty('stocks', 'stock_qty','rack_id',$this->input->post('i_qty_mutasi'),$data2['rack_id'], 'and item_id = '. $this->input->post('i_item', TRUE));
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
			'mutation_id' 						=> $this->input->post('i_id', TRUE),
			'item_id' 						=> $this->input->post('i_item', TRUE),
			'user_id' 						=> $this->user_id,
			'mutation_detail_qty' 				=> $this->input->post('i_qty_mutasi', TRUE),
			'rack_id' 				=> $this->input->post('i_rack', TRUE),
			'warehouse_id' 				=> $this->input->post('i_warehouse2', TRUE),
			'rack_id2' 				=> $this->input->post('i_rack2', TRUE),
			);
			

		return $data;
	}

	function general_post_data_rack_detail(){

		$data2 = array(
			'rack_id' 				=> $this->input->post('i_rack2', TRUE),
			'item_id' 				=> $this->input->post('i_item', TRUE)
			);
		

		return $data2;
	}

	public function load_data_where_detail($id){
		$tbl = 'mutation_details a';
		$select = 'a.*,c.rack_name,d.item_name,d.item_barcode,d.item_per_unit,e.warehouse_name,b.unit_name,f.rack_name as name';
		
		//WHERE
		$where['data'][] = array(
			'column' => 'mutation_detail_id',
			'param'	 => $id
		);
		
		

		$join['data'][] = array(
			'table' => 'racks c',
			'join'	=> 'c.rack_id=a.rack_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'racks f',
			'join'	=> 'f.rack_id=a.rack_id2',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items d',
			'join'	=> 'd.item_id=a.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'warehouses e',
			'join'	=> 'e.warehouse_id=c.warehouse_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'units b',
			'join'	=> 'b.unit_id=d.unit_id',
			'type'	=> 'inner'
		);

		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'mutation_detail_id'	=> $val->mutation_detail_id,
					'item_barcode' 	=> $val->item_barcode,
					'item_id' 	=> $val->item_id,
					'item_name' 	=> $val->item_name,
					'unit_name' 	=> $val->unit_name,
					'item_per_unit' 	=> $val->item_per_unit,
					'mutation_detail_qty' 	=> $val->mutation_detail_qty,
					'rack_id' 	=> $val->rack_id,
					'rack_name' 	=> $val->rack_name,
					'warehouse_id' 	=> $val->warehouse_id,
					'warehouse_name' 	=> $val->warehouse_name,
					'rack_id2' 	=> $val->rack_id2,
					'name' 	=> $val->name,
				);
			}

			echo json_encode($response);
		}
	}

	public function delete_data_detail(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'mutation_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('mutation_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

}