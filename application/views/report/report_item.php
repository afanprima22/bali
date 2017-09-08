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
          <th>Nama Barang</th>
          <th>Class Item</th>
          <th>Sub Class Item</th> 
          <th>Merk</th>
          <th>Satuan</th>
          <th>item per unit</th>
          <th>Harga 1</th>
          <th>Harga 2</th>
          <th>Harga 3</th>
          <th>Harga 4</th>
          <th>Harga 5</th>
          <th>Harga Terakhir</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT a.*,b.item_clas_name,c.item_sub_clas_name,d.brand_name,e.unit_name FROM items a
        Join item_clases b on b.item_clas_id = a.item_clas_id join item_sub_clases c on c.item_sub_clas_id=a.item_sub_clas_id
        join brands d on d.brand_id = a.brand_id join units e on e.unit_id = a.unit_id
        ";
        $row = $this->g_mod->select_manual_for($sql);
        $no = 1;
        foreach ($row->result() as $val2) {
          ?>
          <tr>
            <td><?=$no?></td>
            <td><?=$val2->item_name?></td>
            <td><?=$val2->item_clas_name?></td>
            <td><?=$val2->item_sub_clas_name?></td>
            <td><?=$val2->brand_name?></td>
            <td><?=$val2->unit_name?></td>
            <td><?=$val2->item_per_unit?></td>
            <td align="right"><?= number_format($val2->item_price1)?></td>
            <td align="right"><?= number_format($val2->item_price2)?></td>
            <td align="right"><?= number_format($val2->item_price3)?></td>
            <td align="right"><?= number_format($val2->item_price4)?></td>
            <td align="right"><?= number_format($val2->item_price5)?></td>
            <td align="right"><?= number_format($val2->item_last_price)?></td>
          </tr>
        <? 
        $no++;
        }?>
      </tbody>
    </table>
    
  </div>
</body>
</html>