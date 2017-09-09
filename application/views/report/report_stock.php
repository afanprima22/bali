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
          <td width="10%">Lokasi</td>
          <td>: <?= $warehouse_name ?></td>
        </tr>
        <tr>
          <td width="50%">&nbsp;</td>
          <td width="10%"></td>
          <td>&nbsp;&nbsp;<?= $warehouse_address ?></td>
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
        
      </thead>
    </table>
    <table class="table table-striped" border="1" width="100%" cellspacing="0" style="padding-top: 10px">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Rak </th>
          <th>Nama Barang</th>
          <th>jumlah</th> 
          <th>Stock Qty</th> 
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT a.*,b.rack_detail_id,c.item_name,c.item_per_unit,d.stock_qty,e.warehouse_name,f.unit_name FROM racks a
        Join rack_details b on b.rack_id = a.rack_id 
        join items c on c.item_id=b.item_id
        join stocks d on d.item_id=b.item_id and d.rack_id=b.rack_id
        join warehouses e on e.warehouse_id = a.warehouse_id
        join units f on f.unit_id = c.unit_id 
        where a.warehouse_id = $warehouse_id";
        $row = $this->g_mod->select_manual_for($sql);
        $no = 1;
        foreach ($row->result() as $val2) {
        if ($val2->stock_qty == 0) {
            $stock = 0;
          }else{
            $mod = fmod($val2->stock_qty, $val2->item_per_unit);
            $stock = ($val2->stock_qty - $mod) / $val2->item_per_unit;

          }
          ?>
          <tr>
            <td><?=$no?></td>
            <td><?=$val2->rack_name?></td>
            <td><?=$val2->item_name?></td>
            <td><?=$stock.' '.$val2->unit_name?></td>
            <td><?=$val2->stock_qty?></td>
          </tr>
        <? 
        $no++;
        }?>
      </tbody>
    </table>
    
  </div>
</body>
</html>