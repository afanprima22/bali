<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coa extends MY_Controller {
	private $any_error = array();
	public $tbl = 'coas';

	public function __construct() {
        parent::__construct();
        $this->load->library('PHPExcel');
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
			'title_page' 	=> 'Master-Data / Coa',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('Coa_v', $data);
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
			'column' => 'coa_name',
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
				if ($val->coa_id>0) {
					$jml = strlen($val->coa_nomor);

					$response['data'][] = array(
						$val->coa_nomor,
						'<p style="padding-left:'.$jml.'em;">'.$val->coa_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->coa_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->coa_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.coa_name as child_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'a.coa_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'coas b',
			'join'	=> 'b.coa_id=a.coa_parent',
			'type'	=> 'left'
		);
		$query = $this->g_mod->select($select,'coas a',NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'coa_id'			=> $val->coa_id,
					'coa_name' 		=> $val->coa_name,
					'coa_nomor' 		=> $val->coa_nomor,
					'coa_parent' 		=> $val->coa_parent,
					'child_name' 		=> $val->child_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		$id2 = $this->input->post('i_coa');
		if (!$id2) {
			$id2 = 0;
		}
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data($id2);
			//WHERE
			$where['data'][] = array(
				'column' => 'coa_id',
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
			$data = $this->general_post_data($id2);
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

	

	/* Saving $data as array to database */
	function general_post_data($id2){
		if (!$id2) {
			$id2 = 0;
		}
		$data = array(
			'coa_name' 		=> $this->input->post('i_name', TRUE),
			'coa_parent' 		=> $id2,
			'coa_nomor' 		=> $this->input->post('i_nomor',TRUE)
			);

		return $data;
	}

	public function load_data_select_coa(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'coa_name,coa_nomor',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'coa_nomor',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$jml = strlen($val->coa_nomor);
				$response['items'][] = array(
					'id'	=> $val->coa_id,
					'text'	=> '<p style="padding-left:'.$jml.'em;">'.$val->coa_nomor.'  '.$val->coa_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_nomor($id){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'coa_id',
			'param'	 => $id
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'coa_nomor' 		=> $val->coa_nomor,
				);
			}

			echo json_encode($response);
		}
	}
	public function load_data_cek($id){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'coa_nomor',
			'param'	 => $id
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'coa_nomor' 		=> $val->coa_nomor,
				);
			}

			echo json_encode($response);
		}
	}

	public function import_excel(){
		if($_FILES['file']['name']){

			$this->import('file');
		}

		//echo $status;

		$response['status']		= 200;
		echo json_encode($response);
	}

	public function import($file){
        $fileName = $_FILES[$file]['name'];
        $inputFileName    = $_FILES[$file]['tmp_name'];
         
        /*$config['upload_path'] = './images/import/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if(! $this->upload->do_upload($file) )
        $this->upload->display_errors();
             
        $media = $this->upload->data($file);
        $inputFileName = "images/import/".$media['file_name'];*/
         
        try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
             
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                //Sesuaikan sama nama kolom tabel di database                                
                 $data = array(
                    "coa_nomor"=> $rowData[0][0],
                    "coa_name"=> $rowData[0][1]
                );
                 
                //sesuaikan nama dengan nama tabel
                $this->g_mod->insert_data_table($this->tbl, NULL, $data);
                			
				/*if( file_exists( $inputFileName ) ){
	    			unlink( $inputFileName );
				}*/
                     
            }

            //return $inputFileName;
    }

}