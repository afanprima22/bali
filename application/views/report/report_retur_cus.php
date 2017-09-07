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
        
      </thead>
    </table>
    <table class="table table-striped" border="1" width="100%" cellspacing="0" style="padding-top: 10px">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal Return</th>
          <th>Kode Nota</th>
          <th>Kode Return</th>
          <th>Qty Return</th> 
          <th>status</th> 
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT a.*,b.retur_cus_id,b.retur_cus_date,b.retur_cus_code,c.nota_code,d.nota_detail_id FROM retur_cus_details a
        Join retur_cus b on b.retur_cus_id = a.retur_cus_id join notas c on c.nota_id=b.nota_id
        join nota_details d on d.nota_detail_id = a.nota_detail_id
        where b.retur_cus_id = $retur_cus_id";
        $row = $this->g_mod->select_manual_for($sql);
        $no = 1;
        foreach ($row->result() as $val2) {
        if ($val2->retur_cus_detail_status == 0) {
            $status = 'Belum Diterima';
          }elseif ($val2->retur_cus_detail_status == 1) {
            $status = 'Sudah Diterima';
          }
          ?>
          <tr>
            <td><?=$no?></td>
            <td><?=$val2->retur_cus_date?></td>
            <td><?=$val2->nota_code?></td>
            <td><?=$val2->retur_cus_code?></td>
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