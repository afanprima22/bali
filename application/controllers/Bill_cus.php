<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_cus extends MY_Controller {
	private $any_error = array();
	public $tbl = 'bills';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();
        $this->load->library('PdfGenerator');

        $akses = $this->g_mod->get_user_acces($this->user_id,87);
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
			'title_page' 	=> 'Transaksi / Pembayaran - Customer',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('bill_cus_v', $data);
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
		$tbl  = 'bills a';
		$select = 'a.*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'bill_code,bill_date',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
				

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->bill_id>0) {

					$response['data'][] = array(
						$val->bill_code,
						$val->bill_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->bill_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->bill_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'bill_details a';
		$select = 'a.*,b.nota_code,b.nota_tempo,b.nota_netto,b.nota_dp';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_code,nota_tempo,nota_netto',
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
			'column' => 'bill_id',
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
			'table' => 'notas b',
			'join'	=> 'b.nota_id=a.nota_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->bill_detail_id>0) {

					$nominal = $val->nota_netto - $val->nota_dp;
					$response['data'][] = array(
						$val->nota_code,
						$val->nota_tempo,
						number_format($nominal),
						'<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->bill_detail_id.','.$val->nota_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_payment($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'bill_payments a';
		$select = 'a.*,b.entrusted_code,entrusted_date';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'bill_payment_nominal,bill_payment_date,entrusted_code,bill_payment_rek,bill_payment_bank',
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
			'column' => 'bill_id',
			'param'	 => $id
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'entrusteds b',
			'join'	=> 'b.entrusted_id=a.entrusted_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->bill_payment_id>0) {

					if ($val->bill_payment_type == 0) {
						$type = 'Cash';
						$desc = '';
					}elseif ($val->bill_payment_type == 1) {
						$type = 'Transfer';
						$desc = 'No Rek.'.$val->bill_payment_rek.' Bank.'.$val->bill_payment_bank;
					}else{
						$type = 'Giro';
						$desc = 'No Giro.'.$val->entrusted_code.' No Rek.'.$val->bill_payment_rek.' Bank.'.$val->bill_payment_bank.' Jatuh Tempo.'.$val->entrusted_date;
					}

					$nominal = $val->nota_netto - $val->nota_dp;
					$response['data'][] = array(
						$val->bill_payment_date,
						$type,
						number_format($val->bill_payment_nominal),
						$desc,
						'<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->bill_detail_id.','.$val->nota_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'bills a';
		$select = 'a.*';
		//WHERE
		$where['data'][] = array(
			'column' => 'a.bill_id',
			'param'	 => $this->input->get('id')
		);
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'bill_id'				=> $val->bill_id,
					'bill_date' 			=> $this->format_date_day_mid2($val->bill_date)
					
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
				'column' => 'nota_id',
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

			$data2['bill_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'bill_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('bill_details', $where2, $data2);
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
		

		$data['bill_id'] 			= $this->input->post('i_id');
		$data['nota_id'] 			= $this->input->post('i_nota');
		$data['user_id'] 			= $this->user_id;

		$data2['nota_bill'] 		= 1;

		$where['data'][] = array(
			'column' => 'nota_id',
			'param'	 => $data['nota_id']
		);
		$update = $this->g_mod->update_data_table('notas', $where, $data2);

		$insert = $this->g_mod->insert_data_table('bill_details', NULL, $data);
		if($insert->status) {
			$response['status'] = '200';
			$response['alert'] = '1';
		} else {
			$response['status'] = '204';
		}
		
		
		echo json_encode($response);
	}



	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'bill_id',
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
		$nota_id = $this->input->post('nota_id');
		//WHERE
		$where['data'][] = array(
			'column' => 'bill_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('bill_details', $where);

		$data2['nota_bill'] 		= 0;

		$where2['data'][] = array(
			'column' => 'nota_id',
			'param'	 => $nota_id
		);
		$update = $this->g_mod->update_data_table('notas', $where2, $data2);

		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_bill(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(bill_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(bill_code,1,8)',
			'param'	 => 'NT'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'bill_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);

		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('PY',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		if (!$id) {
			$data['bill_code'] 			= $this->get_code_bill();
		}

		$data['bill_date'] 				= $this->format_date_day_mid($this->input->post('i_date', TRUE));

		return $data;
	}

	function print_nota_pdf(){

		$id = $this->input->get('id');

		$sql = "SELECT a.*,b.customer_name,b.customer_telp,b.customer_address FROM notas a
				Join customers b on b.customer_id = a.customer_id
				where a.nota_id = $id";
		$result = $this->g_mod->select_manual($sql);

		$data = array(
			'nota_id' 				=> $result['nota_id'],
			'nota_code' 			=> $result['nota_code'],
			'nota_date' 			=> $result['nota_date'], 
			'nota_type' 			=> $result['nota_type'],
			'nota_dp' 				=> $result['nota_dp'],
			'customer_name' 		=> $result['customer_name'],
			'customer_telp' 		=> $result['customer_telp'],
			'customer_address' 		=> $result['customer_address']
			);

		$judul			= "Nota Penjualan";
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/report_nota', $data, true);//SEND DATA TO VIEW
	    $paper = 'A5';
    	$orientation = 'landscape';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	public function get_grand_total(){
		$select = 'a.*,b.nota_netto,b.nota_dp';
		$tbl = 'bill_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'bill_id',
			'param'	 => $this->input->get('id')
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'notas b',
			'join'	=> 'b.nota_id=a.nota_id',
			'type'	=> 'inner'
		);
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$grand_total = 0;
		if ($query<>false) {
			foreach ($query->result() as $val) {				

				$grand_total += $val->nota_netto - $val->nota_dp;
		
			}
		}

		$response['grand_total'] 		= number_format($grand_total);

		echo json_encode($response);
	}

	/* end Function */

	
}
