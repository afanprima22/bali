<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends MY_Controller {
	private $any_error = array();
	public $tbl = 'deliveries';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();
        $this->load->library('PdfGenerator');

        $akses = $this->g_mod->get_user_acces($this->user_id,73);
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
			'title_page' 	=> 'Transaksi / Delivery - Order',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('delivery/delivery_v', $data);
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
		$tbl  = 'notas a';
		$select = 'a.*,d.customer_name,d.customer_address';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_code,nota_date,customer_name,customer_address',
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
			'table' => 'nota_details b',
			'join'	=> 'b.nota_id=a.nota_id',
			'type'	=> 'inner'
		);	
		//JOIN
		$join['data'][] = array(
			'table' => 'nota_detail_orders c',
			'join'	=> 'c.nota_detail_id=b.nota_detail_id',
			'type'	=> 'inner'
		);	

		//JOIN
		$join['data'][] = array(
			'table' => 'customers d',
			'join'	=> 'd.customer_id=a.customer_id',
			'type'	=> 'inner'
		);	

		//WHERE
		$where['data'][] = array(
			'column' => 'a.nota_status',
			'param'	 => 0
		);	

		$group_by = "a.nota_id";

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where,NULL,$group_by);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where,NULL,$group_by);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where,NULL,$group_by);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->nota_id>0) {

					$response['data'][] = array(
						$val->nota_code,
						$val->nota_date,
						$val->customer_name,
						$val->customer_address,
						'<button class="btn btn-primary btn-xs" type="button" onclick="proses_data('.$val->nota_id.')" '.$u.'>Proses <i class="glyphicon glyphicon-forward"></i></button>'
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

	public function load_data_do(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'deliveries a';
		$select = 'a.*,b.nota_code,c.employee_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'delivery_date,nota_code,employee_name',
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
			'table' => 'notas b',
			'join'	=> 'b.nota_id=a.nota_id',
			'type'	=> 'left'
		);
		$join['data'][] = array(
			'table' => 'employees c',
			'join'	=> 'c.employee_id=a.employee_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->delivery_id>0) {

					$response['data'][] = array(
						$val->nota_code,
						$val->delivery_date,
						$val->employee_name,
						number_format($val->delifery_freight_cost),
						'<button class="btn btn-info btn-xs" type="button" onclick="edit_data('.$val->delivery_id.','.$val->nota_id.')" '.$d.'><i class="glyphicon glyphicon-pencil"></i></button>'
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
		$tbl = 'deliveries a';
		$select = 'a.*,b.employee_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'a.delivery_id',
			'param'	 => $this->input->get('delivery_id')
		);

		$where['data'][] = array(
			'column' => 'a.nota_id',
			'param'	 => $this->input->get('nota_id')
		);
		
		$join['data'][] = array(
			'table' => 'employees b',
			'join'	=> 'b.employee_id=a.employee_id',
			'type'	=> 'left'
		);
		

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'delivery_id'				=> $val->delivery_id,
					'delivery_date' 			=> $this->format_date_day_mid2($val->delivery_date),
					'employee_id' 			=> $val->employee_id,
					'employee_name' 		=> $val->employee_name,
					'delivery_cost' 		=> $val->delivery_cost,
					'delifery_freight_cost' => $val->delifery_freight_cost
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
			//UPDATE
			$data = $this->general_post_data($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'delivery_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		
		
		echo json_encode($response);
	}

	public function proses_data(){
		$nota_id = $this->input->post('id');

		$tbl  = 'notas a';
		$select = 'a.*,c.warehouse_id,c.nota_detail_order_id,(nota_detail_order_qty - accumulation_qty) as qty_kirim,(nota_detail_order_now - accumulation_now) as qty_ambil,d.item_cost';
		//ORDER
		$order['data'][] = array(
			'column' => 'c.warehouse_id',
			'type'	 => 'ASC'
		);
		
		//JOIN
		$join['data'][] = array(
			'table' => 'nota_details b',
			'join'	=> 'b.nota_id=a.nota_id',
			'type'	=> 'inner'
		);	
		//JOIN
		$join['data'][] = array(
			'table' => 'nota_detail_orders c',
			'join'	=> 'c.nota_detail_id=b.nota_detail_id',
			'type'	=> 'inner'
		);	

		//JOIN
		$join['data'][] = array(
			'table' => 'items d',
			'join'	=> 'd.item_id=c.item_id',
			'type'	=> 'inner'
		);	

		//WHERE
		$where['data'][] = array(
			'column' => 'a.nota_id',
			'param'	 => $nota_id
		);	

		$data4['nota_status'] = 1;
		$update = $this->g_mod->update_data_table($tbl, $where, $data4);

		$data['nota_id'] = $nota_id;
		$data['delivery_date'] = date('Y-m-d');
		$insert = $this->g_mod->insert_data_table('deliveries', NULL, $data);

		$delivery_id = $insert->output;

		$warehouse_id = '';
		$detail_type1_id = '';
		$detail_type2_id = '';
		
		$total_cost = 0;
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,$order,$join,$where,NULL);
		foreach ($query->result() as $val) {
			$warehouse_new_id = $val->warehouse_id;

			if ($warehouse_id != $warehouse_new_id && $val->qty_kirim != 0) {
				$data2['delivery_id'] = $delivery_id;
				$data2['delivery_detail_code'] = $this->get_code_delivery();
				$data2['warehouse_id'] = $warehouse_new_id;
				$data2['delivery_detail_type'] = 1;
				$insert_detail = $this->g_mod->insert_data_table('delivery_details', NULL, $data2);
				$detail_type1_id = $insert_detail->output;

				$data3['delivery_detail_id'] = $detail_type1_id;
				$data3['nota_detail_order_id'] = $val->nota_detail_order_id;
				$data3['delivery_send_qty'] = $val->qty_kirim;
				$insert_send = $this->g_mod->insert_data_table('delivery_sends', NULL, $data3);
			}else{
				$data3['delivery_detail_id'] = $detail_type1_id;
				$data3['nota_detail_order_id'] = $val->nota_detail_order_id;
				$data3['delivery_send_qty'] = $val->qty_kirim;
				$insert_send = $this->g_mod->insert_data_table('delivery_sends', NULL, $data3);
			}

			if ($warehouse_id != $warehouse_new_id && $val->qty_ambil != 0) {
				$data2['delivery_id'] = $delivery_id;
				$data2['delivery_detail_code'] = $this->get_code_delivery();
				$data2['warehouse_id'] = $warehouse_new_id;
				$data2['delivery_detail_type'] = 2;
				$insert_detail = $this->g_mod->insert_data_table('delivery_details', NULL, $data2);
				$detail_type2_id = $insert_detail->output;

				$data3['delivery_detail_id'] = $detail_type2_id;
				$data3['nota_detail_order_id'] = $val->nota_detail_order_id;
				$data3['delivery_send_qty'] = $val->qty_ambil;
				$insert_send = $this->g_mod->insert_data_table('delivery_sends', NULL, $data3);
			}else{
				$data3['delivery_detail_id'] = $detail_type2_id;
				$data3['nota_detail_order_id'] = $val->nota_detail_order_id;
				$data3['delivery_send_qty'] = $val->qty_ambil;
				$insert_send = $this->g_mod->insert_data_table('delivery_sends', NULL, $data3);
			}

			$warehouse_id = $warehouse_new_id;

			$cost = ($val->qty_kirim + $val->qty_ambil) * $val->item_cost;

			$total_cost += $cost;


		}
		

		if($insert->status) {
			$response['status'] 		= '200';
			$response['alert'] 			= '1';
			$response['delivery_id'] 	= $delivery_id;
			$response['nota_id'] 		= $nota_id;
			$response['total_cost'] 	= $total_cost;
		} else {
			$response['status'] = '204';
		}
		
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'delivery_id',
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


	function get_code_delivery(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(delivery_detail_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(delivery_detail_code,1,8)',
			'param'	 => 'DO'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'delivery_detail_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,'delivery_details',$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('DO',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		$data = array(
			'employee_id' 		=> $this->input->post('i_employee', TRUE),
			'delivery_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			//'delivery_cost' 	=> $this->input->post('i_cost', TRUE),
			'delifery_freight_cost' 	=> $this->input->post('i_freight', TRUE)
			);
			

		return $data;
	}

	public function load_data_select_do(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'delivery_detail_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'delivery_detail_code',
			'type'	 => 'ASC'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'delivery_detail_status',
			'param'	 => 0
		);

		$query = $this->g_mod->select('*','delivery_details',NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->delivery_detail_id,
					'text'	=> $val->delivery_detail_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_view_detail($delivery_id,$nota_id) {
		
		//echo $id;
		$tbl  = 'deliveries a';
		$select = 'a.*,b.delivery_detail_id,b.delivery_detail_code,b.delivery_detail_type,c.warehouse_name,b.delivery_detail_status';
		//ORDER
		$order['data'][] = array(
			'column' => 'b.delivery_detail_type',
			'type'	 => 'ASC'
		);
		
		//JOIN
		$join['data'][] = array(
			'table' => 'delivery_details b',
			'join'	=> 'b.delivery_id=a.delivery_id',
			'type'	=> 'inner'
		);	

		//JOIN
		$join['data'][] = array(
			'table' => 'warehouses c',
			'join'	=> 'c.warehouse_id=b.warehouse_id',
			'type'	=> 'inner'
		);	
		
		//WHERE
		$where['data'][] = array(
			'column' => 'a.nota_id',
			'param'	 => $nota_id
		);	
		//WHERE
		$where['data'][] = array(
			'column' => 'a.delivery_id',
			'param'	 => $delivery_id
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,$order,$join,$where);
			
		$this->load->view('delivery/delivery_d',array('query' => $query));
			
 	}

 	public function new_do_action(){

 		$id = $this->input->post('id');
		
		//WHERE
		$where['data'][] = array(
			'column' => 'delivery_detail_id',
			'param'	 => $id
		);
		$data3['delivery_detail_status'] = 3;
		$update = $this->g_mod->update_data_table('delivery_details', $where, $data3);

		$query = $this->g_mod->select('*','delivery_details',NULL,NULL,NULL,NULL,$where);
		foreach ($query->result() as $val) {
			$data = array(
				'delivery_id' => $val->delivery_id, 
				'delivery_detail_code' => $this->get_code_delivery(), 
				'warehouse_id' => $val->warehouse_id, 
				'delivery_detail_type' =>  $val->delivery_detail_type
				);
			$insert = $this->g_mod->insert_data_table('delivery_details', NULL, $data);
			$delivery_detail_id = $insert->output;

			$sql = "select a.*,b.foreman_detail_qty from delivery_sends a
					join foreman_details b on b.delivery_send_id = a.delivery_send_id
					where a.delivery_detail_id = $val->delivery_detail_id";
			$query2 = $this->g_mod->select_manual_for($sql);
			foreach ($query2->result() as $val2) {
				$qty_sisa = $val2->delivery_send_qty - $val2->foreman_detail_qty;
				if ($qty_sisa > 0) {
					$data2 = array(
						'delivery_detail_id' => $delivery_detail_id,
						'nota_detail_order_id' => $val2->nota_detail_order_id,
						'delivery_send_qty' => $qty_sisa
						);
					$this->g_mod->insert_data_table('delivery_sends', NULL, $data2);
				}
			}
		}

		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}
		
		
		echo json_encode($response);
	}

	public function cetak_list_pdf(){
		
		$tbl  = 'notas a';
		$select = 'a.*,d.customer_name,d.customer_address';
				//JOIN
		$join['data'][] = array(
			'table' => 'customers d',
			'join'	=> 'd.customer_id=a.customer_id',
			'type'	=> 'inner'
		);	

		//WHERE
		$where['data'][] = array(
			'column' => 'a.nota_status',
			'param'	 => 0
		);	

		$data['query']	= $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$judul			= "Laporan Delivery Order Pending";
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/report_list_do', $data, true);//SEND DATA TO VIEW
	    $paper = 'A4';
    	$orientation = 'potrait';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	public function cetak_do_pdf(){
		
		$id = $this->input->get('id');

		$sql = "select a.*,b.warehouse_name from delivery_details a 
				join warehouses b on b.warehouse_id = a.warehouse_id
				where a.delivery_detail_id = $id";

		$result	= $this->g_mod->select_manual($sql);

		$data = array(
			'delivery_detail_status' 	=> $result['delivery_detail_status'],
			'delivery_detail_code' 		=> $result['delivery_detail_code'], 
			'delivery_detail_id' 		=> $result['delivery_detail_id'],
			'warehouse_name' 			=> $result['warehouse_name'],
			'delivery_detail_type' 		=> $result['delivery_detail_type']
			);

		$judul			= "Laporan Delivery Order";
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/report_do', $data, true);//SEND DATA TO VIEW
	    $paper = 'A5';
    	$orientation = 'landscape';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	/* end Function */

}
