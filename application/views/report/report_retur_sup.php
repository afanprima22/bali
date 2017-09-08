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
          <td>Code Pembelian</td>
          <td width="60%">: <?=$purchase_code ?></td>
          <td>Tanggal</td>
          <td>: <?=$date= date("d-M-Y")?></td>
        </tr>
        <tr>
          <td>Code Return</td>
          <td width="60%">: <?=$retur_supplier_code ?></td>
          <td>Nama Supplier</td>
          <td>: <?=$partner_name?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>Tanggal Return</td>
          <td>: <?=$retur_supplier_date?></td>
        </tr>
        
      </thead>
    </table>
    <table class="table table-striped" border="1" width="100%" cellspacing="0" style="padding-top: 10px">
      <thead>
        <tr>
          <th>No</th>
          <th>Qty Pembelian</th>
          <th>Qty Diterima</th>
          <th>Qty Return</th> 
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT a.*,b.reception_detail_qty,d.purchase_detail_qty FROM returs_suppliers_details a
        join purchases_details d on d.purchase_detail_id = a.purchase_detail_id
        Join receptions_details b on b.purchase_detail_id = d.purchase_detail_id 
        where a.retur_supplier_id = $retur_supplier_id";
        $row = $this->g_mod->select_manual_for($sql);
        $no = 1;
        foreach ($row->result() as $val2) {
          ?>
          <tr>
            <td><?=$no?></td>
            <td><?=$val2->purchase_detail_qty?></td>
            <td><?=$val2->reception_detail_qty?></td>
            <td><?=$val2->retur_supplier_detail_qty?></td>
            <td><?=$val2->retur_supplier_detail_desc?></td>
          </tr>
        <? 
        $no++;
        }?>
      </tbody>
    </table>
    
  </div>
</body>
</html>