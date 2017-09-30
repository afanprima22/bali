<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutation_recept extends MY_Controller {
	private $any_error = array();
	public $tbl = 'mutation_recepts';
	public $tbl2 = 'mutation_recept_details';
	public $tbl3 = 'items';
	public $tbl4 = 'mutation_rack_recepts';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,89);
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
			'title_page' 	=> 'Transaksi / Penerimaan-Mutasi',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('mutation_recept_v', $data);
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
		$tbl = 'mutation_recepts a';
		$select = 'a.*,b.mutation_code,c.warehouse_name as name1,d.warehouse_name as name2';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'mutation_code',
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
			'table' => 'mutations b',
			'join'	=> 'b.mutation_id=a.mutation_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'warehouses c',
			'join'	=> 'c.warehouse_id=b.warehouse_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'warehouses d',
			'join'	=> 'd.warehouse_id=b.warehouse_id2',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->mutation_recept_id>0) {
					$response['data'][] = array(
						$val->mutation_code,
						$val->mutation_recept_date,
						$val->name1,
						$val->name2,
						$val->mutation_recept_code,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->mutation_recept_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->mutation_recept_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'mutation_recept_details a';
		$select = 'a.*,d.mutation_detail_qty,b.item_id,b.item_barcode,b.item_name';
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
			'column' => 'mutation_recept_id',
			'param'	 => $id
		);

		if (!$id) {
			$where['data'][] = array(
				'column' => 'a.user_id',
				'param'	 => $this->user_id
			);
		}

		$join['data'][] = array(
			'table' => 'mutation_details d',
			'join'	=> 'd.mutation_detail_id=a.mutation_detail_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=d.item_id',
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
				if ($val->mutation_recept_detail_id>0) {

					$sql = "select sum(mutation_rack_recept_qty) as qty from mutation_rack_recepts where mutation_recept_detail_id = $val->mutation_recept_detail_id";
					$result = $this->g_mod->select_manual($sql);

					$response['data'][] = array(
						$val->item_barcode,
						$val->item_name,
						$val->mutation_detail_qty,
						'<a href="#myModal" onclick="get_mutation_detail('.$val->mutation_recept_detail_id.','.$val->mutation_detail_qty.','.$val->item_id.')" class="btn btn-info btn-xs" data-toggle="modal" ><i class="glyphicon glyphicon-list"></i></a>',
						$result['qty'],
						($val->mutation_detail_qty - $result['qty']),
						'<input type="text" class="form-control" name="i_desc<?='.$val->mutation_detail_id.'?>" onchange="save_desc(this.value,'.$val->mutation_recept_detail_id.')" value="">',


					
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
		$tbl = 'mutation_rack_recepts a';
		$select = 'a.*,b.rack_name';
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
			'column' => 'mutation_recept_detail_id',
			'param'	 => $id
		);

		$join['data'][] = array(
			'table' => 'racks b',
			'join'	=> 'b.rack_id=a.rack_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->mutation_rack_recept_id>0) {
					$response['data'][] = array(
						$val->rack_name,
						$val->mutation_rack_recept_qty,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_rack('.$val->mutation_rack_recept_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_rack('.$val->mutation_rack_recept_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
					
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
	    $select = 'a.*,b.mutation_code,c.warehouse_name as name1,d.warehouse_name as name2,b.warehouse_id2,e.mutation_detail_id';
	    $tbl = 'mutation_recepts a';
	    //WHERE
	    $where['data'][] = array(
	      'column' => 'mutation_recept_id',
	      'param'  => $this->input->get('id')
	    );
	    //JOIN
	    $join['data'][] = array(
	      'table' => 'mutations b',
	      'join'  => 'b.mutation_id=a.mutation_id',
	      'type'  => 'inner'
	    );
	    $join['data'][] = array(
	      'table' => 'warehouses c',
	      'join'  => 'c.warehouse_id=b.warehouse_id',
	      'type'  => 'inner'
	    );
	    $join['data'][] = array(
	      'table' => 'warehouses d',
	      'join'  => 'd.warehouse_id=b.warehouse_id2',
	      'type'  => 'inner'
	    );

	    $join['data'][] = array(
	      'table' => 'mutation_details e',
	      'join'  => 'e.mutation_id=b.mutation_id',
	      'type'  => 'inner'
	    );
	    $query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
	    if ($query<>false) {

	      foreach ($query->result() as $val) {
	        $response['val'][] = array(
	          'mutation_recept_id'     => $val->mutation_recept_id,
	          'mutation_id'    => $val->mutation_id,
	          'mutation_detail_id'    => $val->mutation_detail_id,
	          'mutation_code'    => $val->mutation_code,
	          'mutation_recept_date'     =>$this->format_date_day_mid2($val->mutation_recept_date),
	          'name1'    => $val->name1,
	          'name2'    => $val->name2,
	          'warehouse_id2'    => $val->warehouse_id2,
	        );
	      }

	      echo json_encode($response);
	    }
	}

  	public function load_data_where_mutation($id){
	    $select = 'a.*,b.warehouse_name as name1,b.warehouse_id as id1,c.warehouse_name as name2';
	    $tbl = 'mutations a';
	    //WHERE
	    $where['data'][] = array(
	      'column' => 'mutation_id',
	      'param'  => $id
	    );

	    $join['data'][] = array(
	      'table' => 'warehouses b',
	      'join'  => 'b.warehouse_id=a.warehouse_id',
	      'type'  => 'inner'
	    );
	    $join['data'][] = array(
	      'table' => 'warehouses c',
	      'join'  => 'c.warehouse_id=a.warehouse_id2',
	      'type'  => 'inner'
	    );
	    $query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
	    if ($query<>false) {

	      foreach ($query->result() as $val) {
	        $response['val'][] = array(
	          'mutation_id'     => $val->mutation_id,
	          'mutation_date'     =>$this->format_date_day_mid2($val->mutation_date),
	          'id1'    => $val->id1,
	          'name1'    => $val->name1,
	          'warehouse_id2'    => $val->warehouse_id2,
	          'name2'    => $val->name2,
	        );
	      }

	      echo json_encode($response);
	    }
	 }

	 public function load_data_where_rack($id){
		$tbl = 'mutation_rack_recepts a';
		$select = 'a.*,b.rack_name';
		
		//WHERE
		$where['data'][] = array(
			'column' => 'mutation_rack_recept_id',
			'param'	 => $id
		);
		
		$join['data'][] = array(
			'table' => 'racks b',
			'join'	=> 'b.rack_id=a.rack_id',
			'type'	=> 'inner'
		);
		
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'mutation_rack_recept_id'	=> $val->mutation_rack_recept_id,
					'rack_id' 	=> $val->rack_id,
					'rack_name' 	=> $val->rack_name,
					'mutation_rack_recept_qty' 	=> $val->mutation_rack_recept_qty
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data_detail(){
		$id = $this->input->post("id");
		$mutasi_id = $this->input->post("mutasi_id");

		$where2['data'][] = array(
			'column' => 'mutation_recept_id',
			'param'	 => $id
		);
		$where2['data'][] = array(
			'column' => 'user_id',
			'param'	 => $this->user_id
		);
		$delete = $this->g_mod->delete_data_table('mutation_recept_details', $where2);

		$tbl = 'mutation_details a';
		$select = 'a.*';
		//WHERE
		$where['data'][] = array(
			'column' => 'mutation_id',
			'param'	 => $mutasi_id
		);
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {
			foreach ($query->result() as $row){ 
				$data = array(
					'mutation_recept_id' 			=> $id,
					'mutation_detail_id' 			=> $row->mutation_detail_id,
					'user_id' 						=> $this->user_id
				);
				$this->g_mod->insert_data_table('mutation_recept_details', NULL, $data);
			}			
			
		}

		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}
			
		echo json_encode($response);
	}

	public function action_data_rack(){
		$id = $this->input->post('i_rack_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_rack($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'mutation_rack_recept_id',
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
			$data = $this->general_post_data_rack($id);
			//echo $data['purchase_img'];
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

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'mutation_recept_id',
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

	public function load_data_select_code(){
		
		
		$where_like['data'][] = array(
			'column' => 'mutation_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'mutation_id',
			'type'	 => 'ASC'
		);
		
		
		$query = $this->g_mod->select('*','mutations',NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->mutation_id,
					'text'	=> $val->mutation_code
				);
			}
			$response['status'] = '200';
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
				'column' => 'mutation_recept_id',
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
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['mutation_recept_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'mutation_recept_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('mutation_recept_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function get_code_mutation_recept(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(mutation_recept_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(mutation_recept_code,1,8)',
            'param'     => 'MT'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'mutation_recept_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('MT',$query);
        return $new_code;
    }


	function general_post_data($id){

		if (!$id) {
			$data['mutation_recept_code'] = $this->get_code_mutation_recept();
		}

		$data['mutation_id'] = $this->input->post('i_code', TRUE);
		$data['mutation_recept_date'] =$this->format_date_day_mid($this->input->post('i_date', TRUE));
		$data['mutation_recept_user'] = $this->user_id;
		
		return $data;
	}

	function general_post_data_rack($id){

		$data['mutation_rack_recept_qty'] 	= $this->input->post('i_qty_recept', TRUE);
		$data['rack_id'] 					= $this->input->post('i_rack', TRUE);
		$data['item_id'] 					= $this->input->post('i_item_detail_id', TRUE);
		$data['mutation_recept_detail_id'] 	= $this->input->post('i_detail_id', TRUE);
		
		return $data;
	}

	

	public function delete_data_rack(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'mutation_rack_recept_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('mutation_rack_recepts', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	
	function get_total(){
		$id = $this->input->post('id');
		$sql = "select sum(mutation_rack_recept_qty) as qty from mutation_rack_recepts where mutation_recept_detail_id = $id";
		$result = $this->g_mod->select_manual($sql);

		$response['total'] = $result['qty'];

		echo json_encode($response);
	}

	function save_desc(){
		$id = $this->input->post('id');

		//WHERE
		$where['data'][] = array(
			'column' => 'mutation_recept_detail_id',
			'param'	 => $id
		);

		$data['mutation_recept_detail_desc'] = $this->input->post('value');

		$update = $this->g_mod->update_data_table($this->tbl2, $where, $data);

		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}


}