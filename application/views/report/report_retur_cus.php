<!DOCTYPE html>
<html>
<head>
  <title>Bali | <?php echo $title; ?></title>
  <!-- Bootstrap CSS-->
  <style type="text/css">
    body {
      font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
      font-weight: 400;
      font-size:12px;
    }
    p {
      font-size:16px;
    }
    table.hdr-table td { padding:12px; }
  </style>
</head>
<body>
  <div class="container">
  
    <!--<h4 align="center" style="font-size: 16px;"><b><?php echo $title; ?></b></h4>-->
    <table class="table table-striped" border="0" width="100%" cellspacing="0">
      <thead>
        <tr>
          <td colspan="3" style="font-size: 20px;text-align: center;"><b><?php echo $title; ?></b></td>
        </tr>
        <tr>
          <td width="0%">&nbsp;</td>
          <td width="10%"></td>
          <td></td>
        </tr>
        <tr>
          <td>Nomor Nota</td>
          <td width="60%">: <?=$nota_code ?></td>
          <td>Tanggal</td>
          <td>: <?=$date= date("d-M-Y")?></td>
        </tr>
        <tr>
          <td>Code Return</td>
          <td width="60%">: <?=$retur_cus_code ?></td>
        </tr>
        <tr>
          <td>Nama Customer</td>
          <td>: <?=$customer_name?></td>
          <td>Tanggal Return</td>
          <td>: <?=$retur_cus_date?></td>
        </tr>
        
      </thead>
    </table>
    <table class="table table-striped" border="1" width="100%" cellspacing="0" style="padding-top: 10px">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Qty Order</th>
          <th>Qty Return</th>
          <th>status</th> 
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT a.*,b.retur_cus_id,b.retur_cus_date,b.retur_cus_code,c.item_name,d.nota_detail_id,d.nota_detail_retail FROM retur_cus_details a
        Join retur_cus b on b.retur_cus_id = a.retur_cus_id 
        join nota_details d on d.nota_detail_id = a.nota_detail_id
        join items c on c.item_id= d.item_id
        where b.retur_cus_id = $retur_cus_id";
        $row = $this->g_mod->select_manual_for($sql);
        $no = 1;
        
        foreach ($row->result() as $val2) {
        if ($val2->retur_cus_detail_status == 0) {
            $status = 'Belum Diterima';
          }elseif ($val2->retur_cus_detail_status == 1) {
            $status = 'Sudah Diterima';
          }
          $sql = "SELECT SUM(nota_detail_order_qty + nota_detail_order_now) as qty_order
              FROM nota_detail_orders a
              join nota_details d on d.nota_detail_id = a.nota_detail_id
              join retur_cus_details b on b.nota_detail_id = d.nota_detail_id
              where b.retur_cus_id = $retur_cus_id";

          $row2 = $this->g_mod->select_manual($sql);

          $order = $row2['qty_order'] + $val2->nota_detail_retail;
          ?>
          <tr>
            <td><?=$no?></td>
            <td><?=$val2->item_name?></td>
            <td><?= $order ?></td>
            <td><?=$val2->retur_cus_detail_qty?></td>
            <td><?=$status?></td>
            <td><?=$val2->retur_cus_detail_desc?></td>
          </tr>
        <? 
        $no++;
        }?>
      </tbody>
    </table>
    
  </div>
</body>
</html>