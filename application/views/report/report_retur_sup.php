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
          <td width="50%">&nbsp;</td>
          <td width="10%"></td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Tanggal</td>
          <td>: <?=$date= date("d-M-Y")?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td></td>
        </tr>
        
      </thead>
    </table>
    <table class="table table-striped" border="1" width="100%" cellspacing="0" style="padding-top: 10px">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal Return</th>
          <th>Kode Pembelian</th>
          <th>Kode Return</th>
          <th>Qty Return</th> 
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT a.*,b.retur_supplier_id,b.retur_supplier_date,b.retur_supplier_code,c.purchase_code,d.purchase_detail_id FROM returs_suppliers_details a
        Join returs_suppliers b on b.retur_supplier_id = a.retur_supplier_id join purchases c on c.purchase_id=b.purchase_id
        join purchases_details d on d.purchase_detail_id = a.purchase_detail_id
        where b.retur_supplier_id = $retur_supplier_id";
        $row = $this->g_mod->select_manual_for($sql);
        $no = 1;
        foreach ($row->result() as $val2) {
          ?>
          <tr>
            <td><?=$no?></td>
            <td><?=$val2->retur_supplier_date?></td>
            <td><?=$val2->purchase_code?></td>
            <td><?=$val2->retur_supplier_code?></td>
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