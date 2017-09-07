<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash extends MY_Controller {
	private $any_error = array();
	public $tbl = 'cashs';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,78);
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
			'title_page' 	=> 'Transaksi / Kas',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('cash_v', $data);
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
		$tbl = 'cashs a';
		$select = 'a.*,b.coa_nomor,b.coa_name,c.coa_nomor as nomor1,c.coa_name as name1,d.coa_nomor as  nomor2,d.coa_name as name2';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'b.coa_name',
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
			'table' => 'coas b',
			'join'	=> 'b.coa_id=a.coa_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'coas c',
			'join'	=> 'c.coa_id=a.coa_id2',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'coas d',
			'join'	=> 'd.coa_id=a.coa_id3',
			'type'	=> 'inner'
		);


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->cash_id>0) {
					$response['data'][] = array(
						$val->cash_date,
						$val->cash_nominal,
						$val->coa_name.'  '.$val->coa_nomor,
						$val->name1.'  '.$val->nomor1,
						$val->name2.'  '.$val->nomor2,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->cash_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->cash_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
	    $select = 'a.*,b.coa_name,b.coa_nomor,c.coa_nomor as nomor1,c.coa_name as name1,d.coa_nomor as  nomor2,d.coa_name as name2,e.warehouse_name';
	    $tbl = 'cashs a';
	    //WHERE
	    $where['data'][] = array(
	      'column' => 'cash_id',
	      'param'  => $this->input->get('id')
	    );
	    //JOIN
	    $join['data'][] = array(
	      'table' => 'coas b',
	      'join'  => 'b.coa_id=a.coa_id',
	      'type'  => 'inner'
	    );
	    $join['data'][] = array(
			'table' => 'coas c',
			'join'	=> 'c.coa_id=a.coa_id2',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'coas d',
			'join'	=> 'd.coa_id=a.coa_id3',
			'type'	=> 'inner'
		);
	    //JOIN
		$join['data'][] = array(
			'table' => 'warehouses e',
			'join'	=> 'e.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);
	    
	    $query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
	    if ($query<>false) {

	      foreach ($query->result() as $val) {
	        $response['val'][] = array(
	          'cash_id'     		=> $val->cash_id,
	          'coa_id'    			=> $val->coa_id,
	          'coa_name'    		=> $val->coa_name,
	          'coa_nomor'			=> $val->coa_nomor,
	          'name1'    		=> $val->name1,
	          'nomor1'			=> $val->nomor1,
	          'name2'    		=> $val->name2,
	          'nomor2'			=> $val->nomor2,
	          'cash_date'     		=>$this->format_date_day_mid2($val->cash_date),
	          'cash_nominal'    	=> $val->cash_nominal,
	          'cash_type'    		=> $val->cash_type,
	          'warehouse_id'   		=> $val->warehouse_id,
	          'warehouse_name'    	=> $val->warehouse_name,
	          'cash_desc'    	=> $val->cash_desc,
	        );
	      }

	      echo json_encode($response);
	    }
	}

	public function action_data(){
		$debit 		= 0;
		$kredit 	= 0;
		$hutang 	= 0;
		$piutang 	= 0;

		$id = $this->input->post('i_id');
		if (strlen($id)>0) {	
			//UPDATE
			$data = $this->general_post_data($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'cash_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);

			switch ($data['cash_type']) {
				case '0':
					$debit = $data['cash_nominal'];
					break;
				case '1':
					$kredit = $data['cash_nominal'];
					break;
				case '2':
					$hutang = $data['cash_nominal'];
					break;
				case '3':
					$piutang = $data['cash_nominal'];
					break;
				
				default:
					$debit = $data['cash_nominal'];
					break;
			}

			//WHERE
			$where2['data'][] = array(
				'column' => 'journal_type_id',
				'param'	 => 1
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'journal_data_id',
				'param'	 => $id
			);

			$data_journal = array(
				'journal_date' => $data['cash_date'],
				'journal_debit' => $debit,
				'journal_kredit' => $kredit,
				'journal_hutang' => $hutang,
				'journal_piutang' => $piutang,
				'journal_desc' => $data['cash_desc']
			);

			$this->g_mod->update_data_table('journals', $where2, $data_journal);

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

			switch ($data['cash_type']) {
				case '0':
					$debit = $data['cash_nominal'];
					break;
				case '1':
					$kredit = $data['cash_nominal'];
					break;
				case '2':
					$hutang = $data['cash_nominal'];
					break;
				case '3':
					$piutang = $data['cash_nominal'];
					break;
				
				default:
					$debit = $data['cash_nominal'];
					break;
			}


			$data_journal = array(
				'journal_date' => $data['cash_date'],
				'journal_type_id' => 1,
				'journal_data_id' => $insert->output,
				'journal_debit' => $debit,
				'journal_kredit' => $kredit,
				'journal_hutang' => $hutang,
				'journal_piutang' => $piutang,
				'journal_desc' => $data['cash_desc']
			);

			$this->g_mod->insert_data_table('journals', NULL, $data_journal);

			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function get_code_cash(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(cash_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(cash_code,1,8)',
            'param'     => 'CA'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'cash_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('CA',$query);
        return $new_code;
    }


	function general_post_data($id){
		$type =$this->input->post('i_type', TRUE);
		if (!$id) {
			$data['cash_code'] = $this->get_code_cash();
		}
		if (!$type) {
			$type = 0;
		}

		$data['coa_id'] = $this->input->post('i_coa', TRUE);
		$data['coa_id2'] = $this->input->post('i_coa2', TRUE);
		$data['coa_id3'] = $this->input->post('i_coa3', TRUE);
		$data['cash_type'] = $type;
		$data['cash_date'] = $this->format_date_day_mid($this->input->post('i_cash_date', TRUE));
		$data['cash_nominal'] =$this->input->post('i_nominal', TRUE);
		$data['warehouse_id'] =$this->input->post('i_warehouse', TRUE);
		$data['cash_desc'] =$this->input->post('i_desc', TRUE);
			
		return $data;
	}

  	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'cash_id',
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

	public function load_data_review(){

		$id =$this->input->get('id');
		$id2 = $this->format_date_day_mid($id);
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'cashs a';
		$select = 'a.*,e.warehouse_name,b.coa_nomor,b.coa_name,c.coa_nomor as nomor1,c.coa_name as name1,d.coa_nomor as  nomor2,d.coa_name as name2';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'b.coa_name',
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
			'table' => 'coas b',
			'join'	=> 'b.coa_id=a.coa_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'coas c',
			'join'	=> 'c.coa_id=a.coa_id2',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'coas d',
			'join'	=> 'd.coa_id=a.coa_id3',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'warehouses e',
			'join'	=> 'e.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);

		$where['data'][]=array(
			'column'	=>'cash_date',
			'param'		=>$id2
		);


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->cash_id>0) {
					$response['data'][] = array(
						$val->cash_date,
						$val->warehouse_name,
						$val->cash_nominal,
						$val->coa_name.'  '.$val->coa_nomor,
						$val->name1.'  '.$val->nomor1,
						$val->name2.'  '.$val->nomor2,
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