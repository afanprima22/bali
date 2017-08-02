<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reception extends MY_Controller {
	private $any_error = array();
	public $tbl = 'Receptions';
	public $tbl2 = 'purchases_details';
	public $tbl3 = 'items';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,76);
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
			'title_page' 	=> 'Transaksi / Penerimaan-Barang',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('Reception_v', $data);
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
		$tbl = 'Receptions a';
		$select = 'a.*,b.purchase_code,c.warehouse_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'purchase_code,warehouse_name',
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
			'table' => 'purchases b',
			'join'	=> 'b.purchase_id=a.purchase_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'warehouses c',
			'join'	=> 'c.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->reception_id>0) {
					$response['data'][] = array(
						$val->purchase_code,
						$val->reception_date,
						$val->warehouse_name,
						$val->reception_code,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->reception_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->reception_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
			'column' => 'reception_id',
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
    $select = 'a.*,b.purchase_code,c.warehouse_name';
    $tbl = 'receptions a';
    //WHERE
    $where['data'][] = array(
      'column' => 'reception_id',
      'param'  => $this->input->get('id')
    );
    //JOIN
    $join['data'][] = array(
      'table' => 'purchases b',
      'join'  => 'b.purchase_id=a.purchase_id',
      'type'  => 'inner'
    );
    $join['data'][] = array(
      'table' => 'warehouses c',
      'join'  => 'c.warehouse_id=a.warehouse_id',
      'type'  => 'inner'
    );
    $query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
    if ($query<>false) {

      foreach ($query->result() as $val) {
        $response['val'][] = array(
          'reception_id'     => $val->reception_id,
          'purchase_id'    => $val->purchase_id,
          'purchase_code'    => $val->purchase_code,
          'reception_date'     =>$this->format_date_day_mid2($val->reception_date),
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
				'column' => 'Reception_id',
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

			$data2['reception_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'reception_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('receptions_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function get_code_reception(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(reception_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(reception_code,1,8)',
            'param'     => 'RE'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'reception_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('RE',$query);
        return $new_code;
    }


	function general_post_data($id){

		if (!$id) {
			$data['reception_code'] = $this->get_code_reception();
		}

		$data['purchase_id'] = $this->input->post('i_code', TRUE);
		$data['reception_date'] =$this->format_date_day_mid($this->input->post('i_date_reception', TRUE));
		$data['warehouse_id'] = $this->input->post('i_warehouse', TRUE);
		/*$data = array(
			'purchase_date' 		=> $this->format_date_day_mid($this->input->post('i_date_purchase', TRUE)),
			'partner_id' 		=> $this->input->post('i_partner', TRUE),
			'purchase_tempo' 	=> $this->format_date_day_mid($this->input->post('i_date_tempo', TRUE)),
			'purchase_desc' 		=> $this->input->post('i_desc', TRUE)
			);*/
			

		return $data;
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail_reception');
		
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'reception_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('receptions_details', $where, $data);
			$update1 = $this->g_mod->update_data_Qty('purchases_details', 'purchase_detail_qty_akumulation','purchase_detail_id',$this->input->post('i_Qty'),$data['purchase_detail_id']);

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
			$insert = $this->g_mod->insert_data_table('receptions_details', NULL,$data);
			
			$update = $this->g_mod->update_data_Qty('purchases_details', 'purchase_detail_qty_akumulation','purchase_detail_id',$this->input->post('i_Qty'),$data['purchase_detail_id']);
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
      'purchase_detail_id'      => $this->input->post('i_detail_id', TRUE),
      'Reception_id'      => $this->input->post('i_reception', TRUE),
      'reception_detail_order'         => $this->input->post('i_order', TRUE),
      'reception_detail_qty'         => $this->input->post('i_Qty', TRUE),
      'user_id'         => $this->user_id

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
		$tbl = 'receptions_details a';
		$select = 'a.*,b.purchase_detail_qty_akumulation,c.item_barcode,c.item_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_barcode',
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
			'column' => 'reception_id',
			'param'	 => $id
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
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->reception_detail_id>0) {
					
					
					$response['data'][] = array(
						$val->reception_detail_id,
						$val->item_barcode,
						$val->item_name,
						$val->reception_detail_order,
						'<input type="text" class="form-control money" onchange="get_detail_reception(this.value,'.$val->purchase_detail_id.')" name="i_qty" value="'.$val->reception_detail_qty.'">',
						'<input type="text" readonly class="form-control money"  name="i_detail_id" value="'.$val->purchase_detail_id.'">',
						$val->reception_detail_order-$val->purchase_detail_qty_akumulation,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->reception_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->reception_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_reception_detail('.$val->reception_detail_id.')"><i class="glyphicon glyphicon-list"></i></a>'
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

	public function load_data_where_detail(){
		$select = 'a.*,c.item_id,c.item_barcode,c.item_name';
		$tbl = 'receptions_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'reception_detail_id',
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
					'reception_id'			=> $val->reception_id,
					'purchase_detail_id'			=> $val->purchase_detail_id,
					'reception_detail_id'	=> $val->reception_detail_id,
					'item_barcode' 	=> $val->item_barcode,
					'item_id' 			=> $val->item_id,
					'item_name' 			=> $val->item_name,
					'reception_detail_order'=> $val->reception_detail_order,
					'reception_detail_qty' 	=> $val->reception_detail_qty,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_reception_detail($id){
		$select = 'a.*,b.item_barcode,b.item_name';
		$tbl2 = 'purchases_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_detail_id',
			'param'	 => $id
		);

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



		$query = $this->g_mod->select($select,$tbl2,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'purchase_detail_id' 	=> $val->purchase_detail_id,
					
				);
			}

			echo json_encode($response);
		}
	}


	public function delete_data_detail(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'reception_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('receptions_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}
	

	public function action_reception_detail(){
		$id = $this->input->post('i_detail_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_reception_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'reception_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('receptions_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_reception_detail();
			//echo $data['warehouse_img'];
			$insert = $this->g_mod->insert_data_table('receptions_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function general_post_reception_detail(){

    $data = array(
      'reception_detail_qty_batal'         => $this->input->post('i_batal', TRUE),
      'reception_detail_desc_batal'         => $this->input->post('i_desc_batal', TRUE),
      'reception_detail_qty_kembali'         => $this->input->post('i_kembali', TRUE),
      'reception_detail_desc_kembali'         => $this->input->post('i_desc_kembali', TRUE),

      );
      

    return $data;
  }

  public function load_reception_detail($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'receptions_details';
		$select = '*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'purchase_detail_id',
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
			'column' => 'reception_detail_id',
			'param'	 => $id
		);

		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,NULL,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,NULL,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->reception_detail_id>0) {
					$response['data'][] = array(
						$val->reception_detail_qty_batal,
						$val->reception_detail_desc_batal,
						$val->reception_detail_qty_kembali,
						$val->reception_detail_desc_kembali,
						'<button class="btn btn-danger btn-xs" type="button" onclick="delete_reception_data('.$val->reception_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	//
	public function action_data_reference($id){
		$select = 'a.*,b.item_barcode,b.item_name';
		$tbl2 = 'purchases_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_id',
			'param'	 => $id
		);

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



		$query = $this->g_mod->select($select,$tbl2,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {/*
			$oc1 = $row['purchase_detail_qty'] - $row['qty_accumulation'];*/
			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'purchase_detail_id' 	=> $val->purchase_detail_id,
					'item_barcode' 	=> $val->item_barcode,
					'item_id' 	=> $val->item_id,
					'item_name' 	=> $val->item_name,
					'purchase_detail_qty'	=> $val->purchase_detail_qty,
					'purchase_detail_qty_akumulation'	=>$val->purchase_detail_qty- $val->purchase_detail_qty_akumulation,

					
				);
				//WHERE
				$data['purchase_detail_id'] 			= $val->purchase_detail_id;
				$data['reception_detail_order'] 	=$val->purchase_detail_qty;
				$data['reception_detail_qty'] 	= 0;
				$data['user_id'] 			= $this->user_id;

				$insert = $this->g_mod->insert_data_table('receptions_details', NULL, $data);
			}
		}

		
		
		if($query<>false) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		
		echo json_encode($response);
	}

	public function action_data_reception($id){
		$value 			= $this->input->post('value');
		$value2 			= $this->input->post('value');
		$id 	= $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_detail_id',
			'param'	 => $id
		);
		
		$data['reception_detail_qty'] = $value;
		$update = $this->g_mod->update_data_table('receptions_details', $where, $data);
		$data2['purchase_detail_qty_akumulation'] = $data['reception_detail_qty'];
			
		/*$update1 = $this->g_mod->update_data_table('purchases_details',$where2, $data2,$data);*/
		$update1 = $this->g_mod->update_data_Qty('purchases_details', 'purchase_detail_qty_akumulation','purchase_detail_id',$data['reception_detail_qty'],$id	);
		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		
		echo json_encode($response);
	}

}