<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stokopname extends MY_Controller {
	private $any_error = array();
	public $tbl = 'stok_opnames';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,82);
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
			'title_page' 	=> 'Transaksi / Stok-Opname',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('stok_opname_v', $data);
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
		$tbl = 'stok_opnames a';
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
				if ($val->stok_opname_id>0) {
					$response['data'][] = array(
						$val->stok_opname_id,
						$val->stok_opname_date,
						$val->warehouse_name,
						$val->stok_opname_code,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->stok_opname_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->stok_opname_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
			'column' => 'stok_opname_id',
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
    $tbl = 'stok_opnames a';
    //WHERE
    $where['data'][] = array(
      'column' => 'stok_opname_id',
      'param'  => $this->input->get('id')
    );
    //JOIN
    $join['data'][] = array(
      'table' => 'warehouses b',
      'join'  => 'b.warehouse_id=a.warehouse_id',
      'type'  => 'inner'
    );
    $query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
    if ($query<>false) {

      foreach ($query->result() as $val) {
        $response['val'][] = array(
          'stok_opname_id'     => $val->stok_opname_id,
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
			$data = $this->general_post_data($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'stok_opname_id',
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

			$data2['stok_opname_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'stok_opname_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('stok_opname_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function get_code_stok_opname(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(stok_opname_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(stok_opname_code,1,8)',
            'param'     => 'RE'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'stok_opname_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('ST',$query);
        return $new_code;
    }


	function general_post_data($id){

		if (!$id) {
			$data['stok_opname_code'] = $this->get_code_stok_opname();
		}

		$data['warehouse_id'] = $this->input->post('i_warehouse', TRUE);
			

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
		$tbl = 'stok_opname_details a';
		$select = 'a.*,c.rack_name,d.item_name,d.item_barcode,d.item_per_unit';
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
			'column' => 'stok_opname_id',
			'param'	 => $id
		);
		
		

		$join['data'][] = array(
			'table' => 'racks c',
			'join'	=> 'c.rack_id=a.rack_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items d',
			'join'	=> 'd.item_id=a.item_id',
			'type'	=> 'inner'
		);

		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->stok_opname_detail_id>0) {
					
					
					$response['data'][] = array(
						
						$val->item_barcode,
						$val->item_name,
						$val->stok_opname_detail_qty_old,
						$val->rack_name,
						$val->stok_opname_detail_qty_real,
						$val->stok_opname_detail_desc,
						$val->stok_opname_detail_qty_rusak,
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

	public function load_data_stok($id){
			
		
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'stocks a';
		$select = 'a.*,b.rack_name,c.item_name,c.item_barcode,c.item_per_unit,c.item_id,d.unit_id,d.unit_name';
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
			'column' => 'b.warehouse_id',
			'param'	 => $id
		);

		$join['data'][] = array(
			'table' => 'racks b',
			'join'	=> 'b.rack_id=a.rack_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=a.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'units d',
			'join'	=> 'd.unit_id=c.unit_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->stock_id>0) {
					$stock_id=$val->stock_id;
					$stok =$val->stock_qty%$val->item_per_unit;
					$stok2 = $val->stock_qty-$stok;
					$stok3 = $stok2/$val->item_per_unit;
					$response['data'][] = array(
						$val->item_barcode,
						$val->item_name,
						$val->unit_name,
						$val->item_per_unit,
						$stok3,
						$val->rack_name,
						'<input type="number"  class="form-control money"  name="i_qty_real<?='.$val->stock_id.'?>" id="i_qty_real">
						<input type="hidden" class="form-control money"  name="i_stok3<?='.$val->stock_id.'?>" id="i_stok3" value="'.$stok3.'">',
						'<input type="text"  class="form-control money"  name="i_desc<?='.$val->stock_id.'?>" id="i_desc">',
						'<input type="number" class="form-control money"  name="i_qty_broken<?='.$val->stock_id.'?>" id="i_qty_broken">',
						//'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="edit_data_detail('.$val->stock_id.')"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->stock_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		
		$id = $this->input->post('i_warehouse');
		$id2 = $this->input->post('i_rack');
		if ($id2==NULL) {
			$tbl = 'stocks a';
		$select = 'a.*,b.rack_name,c.item_name,c.item_barcode,c.item_per_unit,c.item_id,d.unit_id,d.unit_name';
		
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
		
		//WHERE
		$where['data'][] = array(
			'column' => 'b.warehouse_id',
			'param'	 => $id
		);

		$join['data'][] = array(
			'table' => 'racks b',
			'join'	=> 'b.rack_id=a.rack_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=a.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'units d',
			'join'	=> 'd.unit_id=c.unit_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,$order,$join,$where);
			
			
		foreach ($query->result() as $row){ 
			/*$where2['data'][]=array(
				'column'	=>'stock_id',
				'param'		=>$row->stock_id
				);
			$data2['stock_qty'] = $this->input->post('i_stok3<?='.$row->stock_id.'?>');
		$update = $this->g_mod->update_data_table('stocks', $where2, $data2);*/
		$row->stock_id;
		$data = array(
			'stok_opname_id' 			=> $this->input->post('i_id', TRUE),
			'item_id' 						=> $row->item_id,
			'user_id' 						=> $this->user_id,
			'rack_id' 					=> $row->rack_id,
			'stok_opname_detail_qty_old' 				=> $this->input->post('i_stok3<?='.$row->stock_id.'?>'),
			'stok_opname_detail_qty_real' 				=> $this->input->post('i_qty_real<?='.$row->stock_id.'?>'),
			'stok_opname_detail_desc' 				=> $this->input->post('i_desc<?='.$row->stock_id.'?>'),
			'stok_opname_detail_qty_rusak' 				=> $this->input->post('i_qty_broken<?='.$row->stock_id.'?>'),
			);
			
		$insert = $this->g_mod->insert_data_table('stok_opname_details', NULL, $data);
		}
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
			
		echo json_encode($response);
		}
		else{
		$tbl = 'stocks a';
		$select = 'a.*,b.rack_name,c.item_name,c.item_barcode,c.item_per_unit,c.item_id,d.unit_id,d.unit_name';
		
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
		
		//WHERE
		$where['data'][] = array(
			'column' => 'b.warehouse_id',
			'param'	 => $id
		);

		$where['data'][] = array(
			'column' => 'b.rack_id',
			'param'	 => $id2
		);

		$join['data'][] = array(
			'table' => 'racks b',
			'join'	=> 'b.rack_id=a.rack_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=a.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'units d',
			'join'	=> 'd.unit_id=c.unit_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,$order,$join,$where);
			
			
		foreach ($query->result() as $row){ 
			/*$where2['data'][]=array(
				'column'	=>'stock_id',
				'param'		=>$row->stock_id
				);
			$data2['stock_qty'] = $this->input->post('i_stok3<?='.$row->stock_id.'?>');
		$update = $this->g_mod->update_data_table('stocks', $where2, $data2);*/
		$row->stock_id;
		$data = array(
			'stok_opname_id' 			=> $this->input->post('i_id', TRUE),
			'item_id' 						=> $row->item_id,
			'user_id' 						=> $this->user_id,
			'rack_id' 					=> $row->rack_id,
			'stok_opname_detail_qty_old' 				=> $this->input->post('i_stok3<?='.$row->stock_id.'?>'),
			'stok_opname_detail_qty_real' 				=> $this->input->post('i_qty_real<?='.$row->stock_id.'?>'),
			'stok_opname_detail_desc' 				=> $this->input->post('i_desc<?='.$row->stock_id.'?>'),
			'stok_opname_detail_qty_rusak' 				=> $this->input->post('i_qty_broken<?='.$row->stock_id.'?>'),
			);
			
		$insert = $this->g_mod->insert_data_table('stok_opname_details', NULL, $data);
		}
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
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
		$where['data'][] = array(
			'column' => 'warehouse_id',
			'param'	 => $id
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'rack_name',
			'type'	 => 'ASC'
		);

		
		$query = $this->g_mod->select('*','racks',NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->rack_id, 
					'text'	=> $val->rack_name,
				);
			}
			$response['status'] = '200';
		}
		echo json_encode($response);
	}

	
	public function load_data_stok_rack($id){
			$id2 = $this->input->post('i_warehouse');
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'stocks a';
		$select = 'a.*,b.rack_name,c.item_name,c.item_barcode,c.item_per_unit,c.item_id,d.unit_id,d.unit_name';
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
			'column' => 'b.rack_id',
			'param'	 => $id
		);

		$join['data'][] = array(
			'table' => 'racks b',
			'join'	=> 'b.rack_id=a.rack_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=a.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'units d',
			'join'	=> 'd.unit_id=c.unit_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->stock_id>0) {
					$stock_id=$val->stock_id;
					$stok =$val->stock_qty%$val->item_per_unit;
					$stok2 = $val->stock_qty-$stok;
					$stok3 = $stok2/$val->item_per_unit;
					$response['data'][] = array(
						$val->item_barcode,
						$val->item_name,
						$val->unit_name,
						$val->item_per_unit,
						$stok3,
						$val->rack_name,
						'<input type="number" class="form-control money"  name="i_qty_real<?='.$val->stock_id.'?>" id="i_qty_real">
						<input type="hidden" class="form-control money"  name="i_stok3<?='.$val->stock_id.'?>" id="i_stok3" value="'.$stok3.'">',
						'<input type="text" class="form-control money"  name="i_desc<?='.$val->stock_id.'?>" id="i_desc">',
						'<input type="number" class="form-control money"  name="i_qty_broken<?='.$val->stock_id.'?>" id="i_qty_broken">',
						//'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="edit_data_detail('.$val->stock_id.')"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->stock_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

}