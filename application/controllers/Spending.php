<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spending extends MY_Controller {
	private $any_error = array();
	public $tbl = 'spendings';
	public $tbl2 = 'coas';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,80);
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
			'title_page' 	=> 'Transaksi / Pengeluaran - Operational',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('spending_v', $data);
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
		$tbl = 'spendings a';
		$select = 'a.*,b.coa_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'spending_id',
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

		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->spending_id>0) {
					$response['data'][] = array(
						$val->spending_id,
						$val->spending_date,
						$val->spending_cost,
						$val->spending_code,
						$val->coa_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->spending_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->spending_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
				'column' => 'spending_id',
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

			$data2['spending_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'spending_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('spendings_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function get_code_spending(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(spending_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(spending_code,1,8)',
            'param'     => 'SP'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'spending_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('SP',$query);
        return $new_code;
    }


	function general_post_data($id){

		if (!$id) {
			$data['spending_code'] = $this->get_code_spending();
		}

		$data['spending_date'] = $this->format_date_day_mid($this->input->post('i_date', TRUE));
		$data['spending_cost'] = $this->input->post('i_cost', TRUE);
		$data['coa_id'] = $this->input->post('i_cash', TRUE);
		/*$data = array(
			'purchase_date' 		=> $this->format_date_day_mid($this->input->post('i_date_purchase', TRUE)),
			'partner_id' 		=> $this->input->post('i_partner', TRUE),
			'purchase_tempo' 	=> $this->format_date_day_mid($this->input->post('i_date_tempo', TRUE)),
			'purchase_desc' 		=> $this->input->post('i_desc', TRUE)
			);*/
			

		return $data;
	}

	public function load_data_where(){
		$select = 'a.*,b.coa_name';
		$tbl= 'spendings a';
		//WHERE
		$where['data'][] = array(
			'column' => 'spending_id',
			'param'	 => $this->input->get('id')
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'coas b',
			'join'	=> 'b.coa_id=a.coa_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'spending_id'			=> $val->spending_id,
					'spending_date' 		=>$this->format_date_day_mid2($val->spending_date),
					'spending_cost'			=> $val->spending_cost,
					'coa_id'			=> $val->coa_id,
					'coa_name'			=> $val->coa_name,
				);
			}

			echo json_encode($response);
		}
	}

  	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'spending_id',
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

	public function load_data_detail($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'spendings_details a';
		$select = 'a.*,b.oprational_name,c.warehouse_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'spending_detail_id',
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
			'column' => 'spending_id',
			'param'	 => $id
		);

		if (!$id) {
			$where['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
		}
		

		//JOIN
		$join['data'][] = array(
			'table' => 'oprationals b',
			'join'	=> 'b.oprational_id=a.oprational_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'warehouses c',
			'join'	=> 'c.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);
		
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->spending_detail_id>0) {
					$response['data'][] = array(
						$val->oprational_name,
						$val->warehouse_name,
						$val->spending_detail_cost,
						$val->spending_detail_needs,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->spending_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->spending_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$id = $this->input->post('i_detail');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'spending_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('spendings_details', $where, $data);
			$spending_id = ($data['spending_id']) ? $data['spending_id'] : 0;
			$user_id = $data['user_id'];
			$sql = "SELECT SUM(spending_detail_cost) as total FROM spendings_details where spending_id = $spending_id and user_id = $user_id";
			$row = $this->g_mod->select_manual($sql);
			$response['total'] = $row['total'];
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
			$insert = $this->g_mod->insert_data_table('spendings_details', NULL, $data);
			$spending_id = ($data['spending_id']) ? $data['spending_id'] : 0;
			$user_id = $data['user_id'];
			$sql = "SELECT SUM(spending_detail_cost) as total FROM spendings_details where spending_id = $spending_id and user_id = $user_id";
			$row = $this->g_mod->select_manual($sql);
			$response['total'] = $row['total'];
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
			'spending_id' 			=> $this->input->post('i_id', TRUE),
			'oprational_id' 			=> $this->input->post('i_oprational', TRUE),
			'warehouse_id' 			=> $this->input->post('i_warehouse', TRUE),
			'user_id' 						=> $this->user_id,
			'spending_detail_cost' 				=> $this->input->post('i_price', TRUE),
			'spending_detail_needs' 				=> $this->input->post('i_needs', TRUE),
			);
			

		return $data;
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.oprational_name,c.warehouse_name';
		$tbl = 'spendings_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'spending_detail_id',
			'param'	 => $this->input->get('id')
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'oprationals b',
			'join'	=> 'b.oprational_id=a.oprational_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'warehouses c',
			'join'	=> 'c.warehouse_id=a.warehouse_id',
			'type'	=> 'inner'
		);

		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'spending_detail_id'	=> $val->spending_detail_id,
					'oprational_id'	=> $val->oprational_id,
					'oprational_name'	=> $val->oprational_name,
					'warehouse_id'	=> $val->warehouse_id,
					'warehouse_name'	=> $val->warehouse_name,
					'spending_detail_cost' 	=> $val->spending_detail_cost,
					'spending_detail_needs' 	=> $val->spending_detail_needs,
				);
			}

			echo json_encode($response);
		}
	}

	public function delete_data_detail(){
		$id = $this->input->post('id');
		$id2 = $this->input->post('id_spending');
		//WHERE
		$where['data'][] = array(
			'column' => 'spending_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('spendings_details', $where);
		$spending_id = ($id2) ? $id2 : 0;
		$user_id = $this->user_id;
			$sql = "SELECT SUM(spending_detail_cost) as total FROM spendings_details where spending_id =$spending_id and user_id = $user_id ";
			$row = $this->g_mod->select_manual($sql);
			$response['total'] = $row['total'];
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function hapus(){
		//WHERE
		$where['data'][] = array(
			'column' => 'spending_id',
			'param'	 => 0
		);
		$delete = $this->g_mod->delete_data_table('spendings_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function load_data_spending_detail($id){
		$select = '*';
		$tbl2 = 'oprationals a';
		//WHERE
		$where['data'][] = array(
			'column' => 'oprational_id',
			'param'	 => $id
		);

		


		$query = $this->g_mod->select($select,$tbl2,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'oprational_coa'	=> $val->oprational_coa,
					
				);
			}

			echo json_encode($response);
		}
	}

	public function get_SUM(){
     
                  $sql = "SELECT SUM(spending_detail_cost) as total FROM spendings_details";
                  $row = $this->g_mod->select_manual($sql);
                  $sum = $row['total'];
                if ($row<>false) {
                  foreach ($row as $val) {
				$response['val'][] = array(
					'total'	=> $sum,
					
				);
			}
              echo json_encode($response);
            }
    }


    public function load_data_select_coa(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'coa_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'coa_name',
			'type'	 => 'ASC'
		);

		
		$query = $this->g_mod->select('*',$this->tbl2,NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->coa_id,
					'text'	=>$val->coa_name.' '.$val->coa_nomor
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_coa_cash(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'coa_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'coa_name',
			'type'	 => 'ASC'
		);
		$where['data'][]=array(
			'column'	=>'coa_parent',
			'param'		=>3
			);
		$query = $this->g_mod->select('*',$this->tbl2,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->coa_id,
					'text'	=> $val->coa_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_warehouse(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'warehouse_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'warehouse_name',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*','warehouses',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->warehouse_id,
					'text'	=> $val->warehouse_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

}