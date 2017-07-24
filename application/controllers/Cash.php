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
				if ($val->cash_id>0) {
					$response['data'][] = array(
						$val->warehouse_name,
						$val->cash_date,
						$val->cash_nominal,
						$val->cash_code,
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

	public function action_data(){
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

		if (!$id) {
			$data['cash_code'] = $this->get_code_cash();
		}

		$data['warehouse_id'] =$this->input->post('i_warehouse', TRUE);
		$data['cash_date'] = $this->format_date_day_mid($this->input->post('i_cash_date', TRUE));
		$data['cash_nominal'] =$this->input->post('i_nominal', TRUE);		/*$data = array(
			'purchase_date' 		=> $this->format_date_day_mid($this->input->post('i_date_purchase', TRUE)),
			'partner_id' 		=> $this->input->post('i_partner', TRUE),
			'purchase_tempo' 	=> $this->format_date_day_mid($this->input->post('i_date_tempo', TRUE)),
			'purchase_desc' 		=> $this->input->post('i_desc', TRUE)
			);*/
			

		return $data;
	}

	/*function general_post_data(){
		$data = array(
			'warehouse_id' 		=> $this->input->post('i_warehouse', TRUE),
			'cash_date' 		=>$this->format_date_day_mid($this->input->post('i_cash_date', TRUE)),
			'cash_nominal' 		=> $this->input->post('i_nominal', TRUE),
			);

		return $data;
	}*/

	public function load_data_where(){
    $select = 'a.*,b.warehouse_name';
    $tbl = 'cashs a';
    //WHERE
    $where['data'][] = array(
      'column' => 'cash_id',
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
          'cash_id'     => $val->cash_id,
          'warehouse_id'    => $val->warehouse_id,
          'warehouse_name'    => $val->warehouse_name,
          'cash_date'     =>$this->format_date_day_mid2($val->cash_date),
          'cash_nominal'    => $val->cash_nominal,
        );
      }

      echo json_encode($response);
    }
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

	public function load_data_select_cash(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'cash_id',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'cash_id',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','cashs',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->cash_id,
					'text'	=> $val->cash_id
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_detail($id){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'warehouse_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'cash_id',
			'type'	 => 'ASC'
		);

		$join['data'][] = array(
			'table' => 'warehouses b',
			'join'	=> 'b.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);

		/*$join['data'][] = array(
			'table' => 'units c',
			'join'	=> 'b.unit_id=c.unit_id',
			'type'	=> 'inner'
		);*/

//WHERE
		$where['data'][] = array(
			'column' => 'cash_id',
			'param'	 => $id
		);

		
		$query = $this->g_mod->select('*','cashs a',NULL,$where_like,$order,$join,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->cash_id,
					'text'	=> $val->warehouse_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
}