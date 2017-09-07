<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Price extends MY_Controller {
	private $any_error = array();
	public $tbl = 'change_prices';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,84);
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
			'title_page' 	=> 'Master-Data / Change Price',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('price_v', $data);
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
		$tbl = 'change_prices a';
		$select = 'a.*,b.brand_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'brand_name',
			'param'	 => $this->input->get('search[value]')
		);
		
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'brands b',
			'join'	=> 'b.brand_id=a.brand_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->change_price_id>0) {
					$response['data'][] = array(
						$val->brand_name,
						$val->change_price_type,
						$val->change_price_persentase,
						$val->change_price_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->change_price_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->change_price_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_where($id){
		$tbl = 'change_prices a';
		$select = 'a.*,b.brand_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'change_price_id',
			'param'	 => $id
		);
		$join['data'][] = array(
			'table' => 'brands b',
			'join'	=> 'b.brand_id=a.brand_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'change_price_id'			=> $val->change_price_id,
					'brand_id' 		=> $val->brand_id,
					'brand_name' 		=> $val->brand_name,
					'change_price_type' 		=> $val->change_price_type,
					'change_price_persentase' 		=> $val->change_price_persentase,
					'change_price_date' 		=> $val->change_price_date,
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		$id2 = $this->input->post('i_brand');
		$id3 = $this->input->post('i_type');
		$persen = $this->input->post('i_persentase');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data();
			//WHERE
			$where['data'][] = array(
				'column' => 'change_price_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			$this->action_data_item($id3);
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
			$this->action_data_item($id3);
			$data2['change_price_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'change_price_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('change_price_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	

	/* Saving $data as array to database */
	function general_post_data(){
		
		$data = array(
			'brand_id' 				=> $this->input->post('i_brand', TRUE),
			'change_price_type' 		=> $this->input->post('i_type',TRUE),
			'change_price_persentase' 		=> $this->input->post('i_persentase',TRUE),
			'change_price_date' 		=> $this->format_date_day_mid($this->input->post('i_date_price',TRUE))
			);

		return $data;
	}

	public function load_data_select_brand(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'brand_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'brand_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->brand_id,
					'text'	=> $val->brand_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_item($id,$type2){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'items';
		$select = '*';
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
		$where['data'][] = array(
			'column'	=>'brand_id',
			'param'	=>$id
			);
		
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
			
		
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,NULL,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,NULL,$where);
		if ($type2==1) {
			$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->item_id>0) {
					$response['data'][] = array(
						'<input type="checkbox"  class="form-control money"  name="item_id<?='.$val->item_id.'?>" id="item_id" value="'.$val->item_id.'">',
						$val->item_barcode,
						$val->item_name,
						$val->item_price1,
						$val->item_price2,
						$val->item_price3,
						$val->item_price4,
						$val->item_price5,
					);
					$no++;	
				}
			}
		}
		}
		else{
		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->item_id>0) {
					$response['data'][] = array(
						$val->item_id,
						$val->item_barcode,
						$val->item_name,
						'<input type="text"  class="form-control money"  name="item_price1<?='.$val->item_id.'?>" id="item_price1" value="'.$val->item_price1.'">
						<input type="hidden"  class="form-control money"  name="item_id<?='.$val->item_id.'?>" id="item_id" value="'.$val->item_id.'">',
						'<input type="text"  class="form-control money"  name="item_price2<?='.$val->item_id.'?>" id="item_price2" value="'.$val->item_price2.'">',
						'<input type="text"  class="form-control money"  name="item_price3<?='.$val->item_id.'?>" id="item_price3" value="'.$val->item_price3.'">',
						'<input type="text"  class="form-control money"  name="item_price4<?='.$val->item_id.'?>" id="item_price4" value="'.$val->item_price4.'">',
						'<input type="text"  class="form-control money"  name="item_price5<?='.$val->item_id.'?>" id="item_price5" value="'.$val->item_price5.'">',
					);
					$no++;	
				}
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
		$tbl = 'change_price_details a';
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

		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);
		$where['data'][] = array(
			'column' =>'change_price_id',
			'param'	 =>$id
			);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->change_price_detail_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->item_price1_old,
						$val->item_price1_new,
						$val->item_price2_old,
						$val->item_price2_new,
						$val->item_price3_old,
						$val->item_price3_new,
						$val->item_price4_old,
						$val->item_price4_new,
						$val->item_price5_old,
						$val->item_price5_new,
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
			'column' => 'change_price_id',
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

	public function action_data_detail(){
		$id2 = $this->input->post('i_brand');
		$type = $this->input->post('i_type');
		$persen = $this->input->post('i_persentase');
		$tbl = 'items';
		$select = '*';
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
		$where['data'][] = array(
			'column'	=>'brand_id',
			'param'	=>$id2
			);
		
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
			
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		foreach ($query->result() as $row){ 
			if ($type==2) {
			$row->item_id;
		$data2 = array(
			'item_id' 				=>  $this->input->post('item_id<?='.$row->item_id.'?>'),
			'item_price1_old' 				=>  $row->item_price1,
			'item_price1_new' 				=>  $this->input->post('item_price1<?='.$row->item_id.'?>'),
			'item_price2_old' 				=>  $row->item_price2,
			'item_price2_new' 				=>  $this->input->post('item_price2<?='.$row->item_id.'?>'),
			'item_price3_old' 				=>  $row->item_price3,
			'item_price3_new' 				=>  $this->input->post('item_price3<?='.$row->item_id.'?>'),
			'item_price4_old' 				=>  $row->item_price4,
			'item_price4_new' 				=>  $this->input->post('item_price4<?='.$row->item_id.'?>'),
			'item_price5_old' 				=>  $row->item_price5,
			'item_price5_new' 				=>  $this->input->post('item_price5<?='.$row->item_id.'?>'),
			'user_id' 				=> $this->user_id,
			);

		$insert = $this->g_mod->insert_data_table('change_price_details', NULL, $data2);
		
		if($insert->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}
		
		}else{
			if ($this->input->post('item_id<?='.$row->item_id.'?>',TRUE)) {
			$price1 = $row->item_price1;
			$price2 = $row->item_price2;
			$price3 = $row->item_price3;
			$price4 = $row->item_price4;
			$price5 = $row->item_price5;

			$value1 = $price1*$persen/100;
			$values1 = $price1+$value1;
			$value2 = $price2*$persen/100;
			$values2 = $price2+$value2;
			$value3 = $price3*$persen/100;
			$values3 = $price3+$value3;
			$value4 = $price4*$persen/100;
			$values4 = $price4+$value4;
			$value5 = $price5*$persen/100;
			$values5 = $price5+$value5;



			$row->item_id;
		$data2 = array(
			'item_id' 				=>  $this->input->post('item_id<?='.$row->item_id.'?>', TRUE),
			'item_price1_old' 				=>  $row->item_price1,
			'item_price1_new' 				=>  $values1,
			'item_price2_old' 				=>  $row->item_price2,
			'item_price2_new' 				=>  $values2,
			'item_price3_old' 				=>  $row->item_price3,
			'item_price3_new' 				=>  $values3,
			'item_price4_old' 				=>  $row->item_price4,
			'item_price4_new' 				=>  $values4,
			'item_price5_old' 				=>  $row->item_price5,
			'item_price5_new' 				=>  $values5,
			'user_id' 				=> $this->user_id,
			);

			
		$insert = $this->g_mod->insert_data_table('change_price_details', NULL, $data2);
		
		}
	}


		}
		if($insert->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}
		echo json_encode($response);
	}

	public function delete_data_detail(){
		$id = 0;
		//WHERE
		$where['data'][] = array(
			'column' => 'change_price_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('change_price_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}


	public function action_data_item($id3){
		$id2 = $this->input->post('i_brand');
		$type = $this->input->post('i_type');
		$persen = $this->input->post('i_persentase');
		$tbl = 'items';
		$select = '*';
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
		$where['data'][] = array(
			'column'	=>'brand_id',
			'param'	=>$id2
			);
		
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
			
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		foreach ($query->result() as $row){ 
			if ($id3==2) {
			$row->item_id;
		$where3['data'][]=array(
			'column'	=>'item_id',
			'param'		=>$row->item_id
			);
		$data3 = array(
			'item_id' 				=>  $this->input->post('item_id<?='.$row->item_id.'?>'),
			'item_price1' 				=> $this->input->post('item_price1<?='.$row->item_id.'?>'),
			'item_price2' 				=>  $this->input->post('item_price2<?='.$row->item_id.'?>'),
			'item_price3' 				=>  $this->input->post('item_price3<?='.$row->item_id.'?>'),
			'item_price4' 				=>  $this->input->post('item_price4<?='.$row->item_id.'?>'),
			'item_price5' 				=>  $this->input->post('item_price5<?='.$row->item_id.'?>'),
			);
		$update = $this->g_mod->update_data_table('items', $where3, $data3);
		
		
		}else{
			if ($this->input->post('item_id<?='.$row->item_id.'?>',TRUE)) {
			$price1 = $row->item_price1;
			$price2 = $row->item_price2;
			$price3 = $row->item_price3;
			$price4 = $row->item_price4;
			$price5 = $row->item_price5;

			$value1 = $price1*$persen/100;
			$values1 = $price1+$value1;
			$value2 = $price2*$persen/100;
			$values2 = $price2+$value2;
			$value3 = $price3*$persen/100;
			$values3 = $price3+$value3;
			$value4 = $price4*$persen/100;
			$values4 = $price4+$value4;
			$value5 = $price5*$persen/100;
			$values5 = $price5+$value5;



			$row->item_id;
		$where3['data'][]=array(
			'column'	=>'item_id',
			'param'		=>$row->item_id
			);
		$data3 = array(
			'item_id' 				=>  $this->input->post('item_id<?='.$row->item_id.'?>'),
			'item_price1' 				=>  $values1,
			'item_price2' 				=>  $values2,
			'item_price3' 				=>  $values3,
			'item_price4' 				=>  $values4,
			'item_price5' 				=>  $values5,
			);
		$update = $this->g_mod->update_data_table('items', $where3, $data3);
		}
	}


		}
	}
}