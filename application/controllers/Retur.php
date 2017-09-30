<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur extends MY_Controller {
	private $any_error = array();
	public $tbl = 'returs_suppliers';
	public $tbl1 = 'purchases_details';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();
        $this->load->library('PdfGenerator');

        $akses = $this->g_mod->get_user_acces($this->user_id,77);
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
			'title_page' 	=> 'Transaksi / Return Supplier',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('retur_v', $data);
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
		
		$select = 'a.*,b.purchase_code';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'purchase_code',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'purchases b',
			'join'	=> 'b.purchase_id=a.purchase_id',
			'type'	=> 'inner'
		);
		$query_total = $this->g_mod->select($select,'returs_suppliers a',NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,'returs_suppliers a',NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,'returs_suppliers a',$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->retur_supplier_id>0) {
					$response['data'][] = array(
						$val->purchase_code,
						$val->retur_supplier_date,
						$val->retur_supplier_code,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->retur_supplier_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->retur_supplier_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;<button class="btn btn-warning btn-xs" type="button" onclick="print_pdf('.$val->retur_supplier_id.')" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i></button>'
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
				'column' => 'retur_supplier_id',
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

			$data2['retur_supplier_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'retur_supplier_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('returs_suppliers_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	function get_code_retur_supplier(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(retur_supplier_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(retur_supplier_code,1,8)',
            'param'     => 'RS'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'retur_supplier_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('RS',$query);
        return $new_code;
    }


	function general_post_data($id){

		if (!$id) {
			$data['retur_supplier_code'] = $this->get_code_retur_supplier();
		}

		$data['purchase_id'] = $this->input->post('i_code', TRUE);
		$data['retur_supplier_date'] = $this->format_date_day_mid($this->input->post('i_date', TRUE));
		/*$data = array(
			'purchase_date' 		=> $this->format_date_day_mid($this->input->post('i_date_purchase', TRUE)),
			'partner_id' 		=> $this->input->post('i_partner', TRUE),
			'purchase_tempo' 	=> $this->format_date_day_mid($this->input->post('i_date_tempo', TRUE)),
			'purchase_desc' 		=> $this->input->post('i_desc', TRUE)
			);*/
			

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
		$tbl = 'returs_suppliers_details a';
		$select = 'a.*,b.purchase_detail_qty_akumulation,b.purchase_detail_qty,c.item_name,d.reception_detail_qty';
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
		
		//JOIN
		$join['data'][] = array(
			'table' => 'purchases_details b',
			'join'	=> 'b.purchase_detail_id=a.purchase_detail_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'receptions_details d',
			'join'	=> 'd.purchase_detail_id=b.purchase_detail_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=b.item_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'retur_supplier_id',
			'param'	 => $id
		);
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->retur_supplier_detail_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->purchase_detail_qty,
						$val->reception_detail_qty,
						$val->purchase_detail_qty-$val->purchase_detail_qty_akumulation,
						$val->retur_supplier_detail_qty,
						$val->retur_supplier_detail_desc,
						
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="edit_data_detail('.$val->retur_supplier_detail_id.')"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->retur_supplier_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
			'column' => 'retur_supplier_id',
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
		$select = 'a.*,b.purchase_code,c.partner_name';
		$tbl = 'returs_suppliers a';
		//WHERE
		$where['data'][] = array(
			'column' => 'retur_supplier_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'purchases b',
			'join'	=> 'b.purchase_id=a.purchase_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'partners c',
			'join'	=> 'c.partner_id=b.partner_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'retur_supplier_id'			=> $val->retur_supplier_id,
					'purchase_id'			=>$val->purchase_id,
					'purchase_code' 		=> $val->purchase_code,
					'partner_name' 		=> $val->partner_name,
					'retur_supplier_date' 		=>$this->format_date_day_mid2($val->retur_supplier_date),
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail');
		if (strlen($id)>0) {
		$sql ="SELECT * FROM returs_suppliers_details where retur_supplier_detail_id = $id";
			$row = $this->g_mod->select_manual($sql);
			$qty = $row['retur_supplier_detail_qty'];
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'retur_supplier_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('returs_suppliers_details', $where, $data);
			
			
			$data2 = $data['retur_supplier_detail_qty'];
			$qty2 = $data2 - $qty;
			$update1 = $this->g_mod->update_data_Qty('purchases_details', 'purchase_detail_qty_akumulation','purchase_detail_id',$qty2,$this->input->post('i_item',TRUE)	);
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
			$insert = $this->g_mod->insert_data_table('returs_suppliers_details', NULL, $data);
			$update1 = $this->g_mod->update_data_Qty('purchases_details', 'purchase_detail_qty_akumulation','purchase_detail_id',$this->input->post('i_qty_return',TRUE),$this->input->post('i_item',TRUE)	);
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
			'retur_supplier_id' 			=> $this->input->post('i_id', TRUE),
			'user_id' 						=> $this->user_id,
			'purchase_detail_id' 						=> $this->input->post('i_item',TRUE),
			'retur_supplier_detail_qty' 				=> $this->input->post('i_qty_return', TRUE),
			'retur_supplier_detail_desc' 				=> $this->input->post('i_desc', TRUE),
			);
			

		return $data;
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.purchase_detail_qty_akumulation,b.purchase_detail_qty,c.item_name,d.reception_detail_qty';
		$tbl = 'returs_suppliers_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'retur_supplier_detail_id',
			'param'	 => $this->input->get('id')
		);

		

		//JOIN
		$join['data'][] = array(
			'table' => 'purchases_details b',
			'join'	=> 'b.purchase_detail_id=a.purchase_detail_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'receptions_details d',
			'join'	=> 'd.purchase_detail_id=b.purchase_detail_id',
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
					'retur_supplier_detail_id'	=> $val->retur_supplier_detail_id,
					'purchase_detail_id' 	=> $val->purchase_detail_id,
					'item_name' 	=> $val->item_name,
					'purchase_detail_qty' 	=> $val->purchase_detail_qty,
					'reception_detail_qty' 	=> $val->reception_detail_qty,
					'purchase_detail_qty_akumulation' 	=> $val->purchase_detail_qty-$val->purchase_detail_qty_akumulation,
					'retur_supplier_detail_qty' 	=> $val->retur_supplier_detail_qty,
					'retur_supplier_detail_desc' 	=> $val->retur_supplier_detail_desc,
				);
			}

			echo json_encode($response);
		}
	}

	public function delete_data_detail(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'retur_supplier_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('returs_suppliers_details', $where);
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
			'column' => 'retur_supplier_id',
			'param'	 => 0
		);
		$delete = $this->g_mod->delete_data_table('returs_suppliers_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function load_data_retur_detail($id){
		$select = '*';
		$tbl2 = 'purchases_details';
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_detail_id',
			'param'	 => $id
		);
		$query = $this->g_mod->select($select,$tbl2,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'purchase_detail_qty'	=> $val->purchase_detail_qty,
					'qty_akumulation'	=> $val->purchase_detail_qty_akumulation,
					'purchase_detail_qty_akumulation'	=>$val->purchase_detail_qty-$val->purchase_detail_qty_akumulation,
					
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_reception_detail($id){
		$select = '*';
		$tbl2 = 'receptions_details';
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_detail_id',
			'param'	 => $id
		);
		$query = $this->g_mod->select($select,$tbl2,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'reception_detail_qty'	=> $val->reception_detail_qty,					
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_supplier($id){
		$select = 'a.*,b.partner_name';
		$tbl2 = 'purchases';
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_id',
			'param'	 => $id
		);

		$join['data'][] = array(
			'table' => 'partners b',
			'join'	=> 'b.partner_id=a.partner_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select($select,'purchases a',NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'partner_name'	=> $val->partner_name,
					
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_select_detail($id){
		$where_like['data'][] = array(
			'column' => 'item_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_id',
			'type'	 => 'ASC'
		);

		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);

		$where['data'][]=array(
			'column'	=>'purchase_id',
			'param'		=>$id
		);

		$query = $this->g_mod->select('a.*,b.item_name','purchases_details a',NULL,$where_like,$order,$join,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->purchase_detail_id,
					'text'	=> $val->item_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	function print_retur_sup_pdf(){

		$id = $this->input->get('id');
		$select = ' a.*,e.partner_name,b.retur_supplier_id,b.retur_supplier_date,b.retur_supplier_code,b.purchase_id,c.purchase_code,d.purchase_detail_id';
		$tbl = 'returs_suppliers_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'a.retur_supplier_id',
			'param'	 => $id
		);

		

		//JOIN
		$join['data'][] = array(
			'table' => 'returs_suppliers b',
			'join'	=> 'b.retur_supplier_id=a.retur_supplier_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'purchases_details d',
			'join'	=> 'd.purchase_detail_id=a.purchase_detail_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'purchases c',
			'join'	=> 'c.purchase_id=b.purchase_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'partners e',
			'join'	=> 'e.partner_id=c.partner_id',
			'type'	=> 'inner'
		);

		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		foreach ($query->result() as $row){ 

			$data = array(
				'retur_supplier_report_date' 		=> date("Y/m/d"),
				/*'retur_supplier_id' 				=> $row->retur_supplier_id,*/
				'retur_supplier_date' 			=> $row->retur_supplier_date, 
				'retur_supplier_code' 		=> $row->retur_supplier_code,
				'partner_name' 				=> $row->partner_name,
				/*'purchase_id' 				=> $row->purchase_id,*/
				'purchase_code' 				=> $row->purchase_code,
				/*'retur_supplier_detail_id' 				=> $row->retur_supplier_detail_id,*/
				'retur_supplier_detail_qty' 		=> $row->retur_supplier_detail_qty,
				'retur_supplier_detail_desc'		=> $row->retur_supplier_detail_desc,
				/*'purchase_detail_id'				=> $row->purchase_detail_id,*/

				);
			$insert = $this->g_mod->insert_data_table('returs_supplier_reports', NULL, $data);
		}
		$judul			= "Return Supplier";
		$data['title'] 	= $judul;
		$data['retur_supplier_id'] 	= $row->retur_supplier_id;
		$data['retur_supplier_code'] 	= $row->retur_supplier_code;
		$data['purchase_code'] 	= $row->purchase_code;
		$data['partner_name'] 	= $row->partner_name;
		$data['retur_supplier_date'] 	=  $row->retur_supplier_date;

	    $html = $this->load->view('report/report_retur_sup', $data, true);//SEND DATA TO VIEW
	    $paper = 'A4';
    	$orientation = 'portraitid';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

}