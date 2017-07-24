<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller {
	private $any_error = array();
	public $tbl = 'employees';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,65);
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
			'title_page' 	=> 'Master Data / Pegawai',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('employee/employee_v', $data);
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
		$tbl = 'employees a';
		$select = 'a.*,b.division_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'employee_name,employee_hp,division_name,employee_status,employee_address',
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
			'table' => 'divisions b',
			'join'	=> 'b.division_id=a.division_id',
			'type'	=> 'inner'
		);
		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->employee_id>0) {
					$response['data'][] = array(
						$val->employee_name,
						$val->employee_type,
						$val->employee_hp,
						$val->employee_address,
						$val->division_name,
						$val->employee_status,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->employee_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->employee_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'employee_cities a';
		$select = 'a.*,b.city_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'city_name,employee_city_presentase',
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
			'column' => 'employee_id',
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
			'table' => 'cities b',
			'join'	=> 'b.city_id=a.city_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->employee_city_id>0) {
					$response['data'][] = array(
						$val->employee_city_id,
						$val->city_name,
						$val->employee_city_presentase,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->employee_city_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->employee_city_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.division_name,c.warehouse_name';
		$tbl = 'employees a';
		//JOIN
		$join['data'][] = array(
			'table' => 'divisions b',
			'join'	=> 'b.division_id=a.division_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'warehouses c',
			'join'	=> 'c.warehouse_id=a.warehouse_id',
			'type'	=> 'left'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'employee_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'employee_id'			=> $val->employee_id,
					'employee_name' 		=> $val->employee_name,
					'employee_address'		=> $val->employee_address,
					'employee_birth_date' 	=> $this->format_date_day_mid2($val->employee_birth_date),
					'employee_hp' 			=> $val->employee_hp,
					'employee_rek' 			=> $val->employee_rek,
					'employee_bank' 		=> $val->employee_bank,
					'employee_npwp'			=> $val->employee_npwp,
					'employee_name_npwp' 	=> $val->employee_name_npwp,
					'employee_ktp' 			=> $val->employee_ktp,
					'division_id' 			=> $val->division_id,
					'division_name' 		=> $val->division_name,
					'warehouse_id' 			=> $val->warehouse_id,
					'warehouse_name' 		=> $val->warehouse_name,
					'employee_status'		=> $val->employee_status,
					'employee_begin' 		=> $this->format_date_day_mid2($val->employee_begin),
					'employee_first_salary' => $val->employee_first_salary,
					'employee_piece' 		=> $val->employee_piece,
					'employee_over' 		=> $val->employee_over,
					'employee_type' 		=> $val->employee_type,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.city_name';
		$tbl = 'employee_cities a';
		//WHERE
		$where['data'][] = array(
			'column' => 'employee_city_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'cities b',
			'join'	=> 'b.city_id=a.city_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'employee_city_id'			=> $val->employee_city_id,
					'city_id' 					=> $val->city_id,
					'city_name' 				=> $val->city_name,
					'employee_city_presentase' 	=> $val->employee_city_presentase,
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
				'column' => 'employee_id',
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
			//echo $data['employee_img'];
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
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'employee_city_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('employee_cities', $where, $data);
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
			$insert = $this->g_mod->insert_data_table('employee_cities', NULL, $data);
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
			'column' => 'employee_id',
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
			'column' => 'employee_city_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('employee_cities', $where);
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

		$data = array(
			'employee_name' 			=> $this->input->post('i_name', TRUE),
			'employee_birth_date' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			'employee_hp' 				=> $this->input->post('i_hp', TRUE),
			'employee_rek' 				=> $this->input->post('i_rek', TRUE),
			'employee_bank' 			=> $this->input->post('i_bank', TRUE),
			'employee_npwp' 			=> $this->input->post('i_no_npwp', TRUE),
			'employee_name_npwp' 		=> $this->input->post('i_name_npwp', TRUE),
			'employee_ktp' 				=> $this->input->post('i_ktp', TRUE),
			'division_id' 				=> $this->input->post('i_division', TRUE),
			'employee_status' 			=> $this->input->post('i_status', TRUE),
			'employee_begin' 			=> $this->format_date_day_mid($this->input->post('i_date_begin', TRUE)),
			'warehouse_id' 				=> $this->input->post('i_store', TRUE),
			'employee_first_salary' 	=> $this->input->post('i_salary', TRUE),
			'employee_piece' 			=> $this->input->post('i_piece', TRUE),
			'employee_over' 			=> $this->input->post('i_over', TRUE),
			'employee_address' 			=> $this->input->post('i_addres', TRUE),
			'employee_type' 			=> $this->input->post('i_type', TRUE)
			);
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'employee_id' 					=> $this->input->post('i_id', TRUE),
			'city_id' 						=> $this->input->post('i_city', TRUE),
			'employee_city_presentase' 		=> $this->input->post('i_detail_presentase', TRUE),
			'user_id' 						=> $this->user_id
			);
			

		return $data;
	}
	
	public function load_data_select_employee($id){
		//WHERE LIKE
		if ($id == 1) {
			$type = 'Karyawan';
		}else{
			$type = 'Sales';
		}
		
		$where_like['data'][] = array(
			'column' => 'employee_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'employee_name',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'employee_type',
			'param'	 => $type
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->employee_id,
					'text'	=> $val->employee_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_employee_divisi($id){
		//WHERE LIKE
		
		$where_like['data'][] = array(
			'column' => 'employee_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'employee_name',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'division_id',
			'param'	 => $id
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->employee_id,
					'text'	=> $val->employee_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function action_galery(){
		$new_name = time()."_".$_FILES['i_galery']['name'];
			
		$configUpload['upload_path']    = './images/employee/';                 #the folder placed in the root of project
		$configUpload['allowed_types']  = 'gif|jpg|png|bmp|jpeg';       #allowed types description
		$configUpload['max_size']	= 1024 * 8;
		$configUpload['encrypt_name']   = TRUE;   
		$configUpload['file_name'] 		= $new_name;                      	#encrypt name of the uploaded file

		$this->load->library('upload', $configUpload);                  #init the upload class
		$this->upload->initialize($configUpload);

		if(!$this->upload->do_upload('i_galery')){
			$uploadedDetails    = $this->upload->display_errors();
			$response['status'] = '204';
		}else{
			$uploadedDetails    = $this->upload->data(); 
			$response['status'] = '200';

			$data['employee_id'] = $this->input->post('i_id', TRUE);
			$data['employee_galery_file'] = $uploadedDetails['file_name'];

			$this->g_mod->insert_data_table('employee_galeries', NULL, $data);
				//$this->_createThumbnail($uploadedDetails['file_name']);
	 
				//$thumbnail_name = $uploadedDetails['raw_name']. '_thumb' .$uploadedDetails['file_ext'];   
		}
		
		echo json_encode($response);
	}

	public function delete_galery(){

		$galery_id = $this->input->post('id_galery', TRUE);

		$select = '*';
		$tbl = 'employee_galeries';
				
		//WHERE
		$where['data'][] = array(
			'column' => 'employee_galery_id',
			'param'	 => $galery_id
		);

		$query_galery = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query_galery<>false) {
			foreach ($query_galery->result() as $val) {

				$oldfile   = "images/employee/".$val->employee_galery_file;
				
				//DELETE IMAGE
				if( file_exists( $oldfile ) ){
		    		unlink( $oldfile );
				}

			}
		}

		//DELETE DATABASE
		//WHERE
		$where2['data'][] = array(
			'column' => 'employee_galery_id',
			'param'	 => $galery_id
		);
		$delete = $this->g_mod->delete_data_table($tbl, $where2);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function load_galery($id){
		
		$select2 = '*';
		$tbl2 = 'employee_galeries';
				
		//WHERE
		$where2['data'][] = array(
			'column' => 'employee_id',
			'param'	 => $id
		);

		$query_galery = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where2);
		
		$this->load->view('employee/employee_g', array('query_galery' => $query_galery));
		
	}

	/* end Function */

}
