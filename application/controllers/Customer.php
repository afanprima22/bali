<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {
	private $any_error = array();
	public $tbl = 'customers';
	public $tbl2 = 'customer_details';
	public $tbl3 = 'customer_groups';
	public $tbl4 = 'business';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,71);
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
			'title_page' 	=> 'Master Data / Customer',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('customer_v', $data);
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
		$tbl = 'customers a';
		$select = 'a.*,b.city_name,c.busines_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'customer_name,customer_telp,customer_store,busines_name,city_name',
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
			'table' => 'cities b',
			'join'	=> 'b.city_id=a.city_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'business c',
			'join'	=> 'c.busines_id=a.busines_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->customer_id>0) {
					$response['data'][] = array(
						$val->customer_name,
						$val->customer_telp,
						$val->customer_store,
						$val->busines_name,
						$val->city_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->customer_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->customer_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'customer_details a';
		$select = 'a.*,b.customer_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'customer_name,customer_detail_bonus',
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
			'join'	=> 'b.customer_id=a.customer_member_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.customer_id',
			'param'	 => $id
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->customer_detail_id>0) {
					$response['data'][] = array(
						$val->customer_name,
						$val->customer_detail_bonus,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->customer_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->customer_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_group(){
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
			'column' => 'customer_group_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$query_total = $this->g_mod->select($select,$this->tbl3,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$this->tbl3,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$this->tbl3,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->customer_group_id>0) {
					$response['data'][] = array(
						$val->customer_group_id,
						$val->customer_group_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_group('.$val->customer_group_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_group('.$val->customer_group_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_badan(){
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
			'column' => 'busines_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$query_total = $this->g_mod->select($select,$this->tbl4,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$this->tbl4,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$this->tbl4,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->busines_id>0) {
					$response['data'][] = array(
						$val->busines_id,
						$val->busines_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_badan('.$val->busines_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_badan('.$val->busines_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.city_name,c.busines_name,d.customer_group_name,e.category_price_name';
		$tbl = 'customers a';
		//JOIN
		$join['data'][] = array(
			'table' => 'cities b',
			'join'	=> 'b.city_id=a.city_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'business c',
			'join'	=> 'c.busines_id=a.busines_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'customer_groups d',
			'join'	=> 'd.customer_group_id=a.customer_group_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'category_prices e',
			'join'	=> 'e.category_price_id=a.category_price_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'customer_id'				=> $val->customer_id,
					'customer_name' 			=> $val->customer_name,
					'customer_address' 			=> $val->customer_address,
					'customer_store' 			=> $val->customer_store,
					'customer_telp' 			=> $val->customer_telp,
					'customer_hp'				=> $val->customer_hp,
					'customer_npwp' 			=> $val->customer_npwp,
					'customer_npwp_name' 		=> $val->customer_npwp_name,
					'customer_mail' 			=> $val->customer_mail,
					'customer_group_id' 		=> $val->customer_group_id,
					'customer_group_name' 		=> $val->customer_group_name,
					'city_id' 					=> $val->city_id,
					'city_name' 				=> $val->city_name,
					'busines_id' 				=> $val->busines_id,
					'busines_name' 				=> $val->busines_name,
					'category_price_id' 		=> $val->category_price_id,
					'category_price_name' 		=> $val->category_price_name,
					'customer_img' 				=> base_url().'images/customer/'.$val->customer_img,
					'customer_limit_kredit' 	=> $val->customer_limit_kredit,
					'customer_limit_card' 		=> $val->customer_limit_card,
					'customer_limit_day' 		=> $val->customer_limit_day,
					'customer_card_no' 			=> $val->customer_card_no,
					
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_detail_where(){
		$select = 'a.*,b.customer_name';
		$tbl = 'customer_details a';
		//JOIN
		$join['data'][] = array(
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_member_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_detail_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'customer_detail_id'			=> $val->customer_detail_id,
					'customer_member_id' 			=> $val->customer_member_id,
					'customer_name' 				=> $val->customer_name,
					'customer_detail_bonus' 		=> $val->customer_detail_bonus,
					
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_group(){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_group_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl3,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'customer_group_id'			=> $val->customer_group_id,
					'customer_group_name' 		=> $val->customer_group_name
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_badan(){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'busines_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl4,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'busines_id'			=> $val->busines_id,
					'busines_name' 			=> $val->busines_name
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
				'column' => 'customer_id',
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
			//echo $data['customer_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'customer_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl2, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail($id);
			//echo $data['customer_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl2, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_group(){
		$id = $this->input->post('i_group_id');
		if (strlen($id)>0) {
			//UPDATE
			$data['customer_group_name'] = $this->input->post('i_group_name', TRUE);
			//WHERE
			$where['data'][] = array(
				'column' => 'customer_group_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl3, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data['customer_group_name'] = $this->input->post('i_group_name', TRUE);
			//echo $data['item_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl3, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_badan(){
		$id = $this->input->post('i_badan_id');
		if (strlen($id)>0) {
			//UPDATE
			$data['busines_name'] = $this->input->post('i_badan_name', TRUE);
			//WHERE
			$where['data'][] = array(
				'column' => ' 	busines_id',
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
			$data['busines_name'] = $this->input->post('i_badan_name', TRUE);
			//echo $data['item_img'];
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
			'column' => 'customer_id',
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
		$id = $this->input->post('i_detail_id');
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl2, $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_group(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_group_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl3, $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_badan(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'busines_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl4, $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	/* Saving $data as array to database */
	function general_post_data($id){
		$this->load->library('upload');

		//$img = $this->input->post('i_img', TRUE);
		// upload gambar
		if($_FILES['i_img']['name']){

			if($id){
				$get_img = $this->g_mod->get_img("customers", "customer_img", "customer_id = '$id'");
			
				$oldfile   = "images/customer/".$get_img;
			
				if( file_exists( $oldfile ) ){
	    			unlink( $oldfile );
				}
			}

			$img_name = $this->upload_img('i_img');

			//$img 	= str_replace(" ", "_", $new_name);

			$data['customer_img']  = $img_name;

		}

		$data['customer_name'] 				= $this->input->post('i_name', TRUE);
		$data['customer_address'] 			= $this->input->post('i_addres', TRUE);
		$data['customer_store'] 			= $this->input->post('i_store', TRUE);
		$data['customer_telp'] 				= $this->input->post('i_telp', TRUE);
		$data['customer_hp'] 				= $this->input->post('i_hp', TRUE);
		$data['customer_npwp'] 				= $this->input->post('i_no_npwp', TRUE);
		$data['customer_npwp_name'] 		= $this->input->post('i_name_npwp', TRUE);
		$data['customer_mail'] 				= $this->input->post('i_mail', TRUE);
		$data['customer_group_id'] 			= $this->input->post('i_group', TRUE);
		$data['city_id'] 					= $this->input->post('i_city', TRUE);
		$data['busines_id'] 				= $this->input->post('i_busines', TRUE);
		$data['category_price_id'] 			= $this->input->post('i_category', TRUE);
		$data['customer_limit_kredit'] 		= $this->input->post('i_kredit', TRUE);
		//$data['customer_limit_card'] 		= $this->input->post('i_card', TRUE);
		$data['customer_limit_day'] 		= $this->input->post('i_tempo', TRUE);
		$data['customer_card_no'] 			= $this->input->post('i_member_card_no', TRUE);
			

		return $data;
	}

	function general_post_data_detail($id){
		$data = array(
			'customer_id' 				=> $this->input->post('i_id', TRUE),
			'customer_member_id' 		=> $this->input->post('i_customer', TRUE),
			'customer_detail_bonus' 	=> $this->input->post('i_bonus', TRUE)
			);

		return $data;
	}

	public function upload_img($img){
		$new_name = time()."_".$_FILES[$img]['name'];
			
			$configUpload['upload_path']    = './images/customer/';                 #the folder placed in the root of project
			$configUpload['allowed_types']  = 'gif|jpg|png|bmp|jpeg';       #allowed types description
			$configUpload['max_size']	= 1024 * 8;
			$configUpload['encrypt_name']   = TRUE;   
			$configUpload['file_name'] 		= $new_name;                      	#encrypt name of the uploaded file

			$this->load->library('upload', $configUpload);                  #init the upload class
			$this->upload->initialize($configUpload);

			if(!$this->upload->do_upload($img)){
				$uploadedDetails    = $this->upload->display_errors();
			}else{
				$uploadedDetails    = $this->upload->data(); 
				//$this->_createThumbnail($uploadedDetails['file_name']);
	 
				//$thumbnail_name = $uploadedDetails['raw_name']. '_thumb' .$uploadedDetails['file_ext'];   
			}
			
			return $uploadedDetails['file_name'];
	}

	public function load_data_select_customer(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'customer_name,customer_store',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'customer_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','customers',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->customer_id,
					'text'	=> $val->customer_name.'-'.$val->customer_store
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_group(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'customer_group_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'customer_group_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','customer_groups',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->customer_group_id,
					'text'	=> $val->customer_group_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_busines(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'busines_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'busines_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','business',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->busines_id,
					'text'	=> $val->busines_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
