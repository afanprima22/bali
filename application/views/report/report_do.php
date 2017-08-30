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
  <?php

    if ($delivery_detail_type == 1) {
      $type = "Kirim";
    }else{
      $type = "Ambil";
    }

    if ($delivery_detail_status == 0) {
      $status = "Pending";
    }elseif($delivery_detail_status == 1){
      $status = "Dikirim Full";
    }elseif($delivery_detail_status == 2){
      $status = "Dikirim Sebagian";
    }elseif($delivery_detail_status == 3){
      $status = "Dikirim Sebagian - New DO";
    }elseif($delivery_detail_status == 4){
      $status = "Dikirim Sebagian - Cancel";
    }

    ?>
    <!--<h4 align="center" style="font-size: 16px;"><b><?php echo $title; ?></b></h4>-->

    <table class="table table-striped" border="0" width="100%" cellspacing="0">
      <thead>
        <tr>
          <td>No DO</td>
          <td><?=$delivery_detail_code?></td>
          <td>Gudang</td>
          <td><?=$warehouse_name?></td>
        </tr>
        <tr>
          <td>Type DO</td>
          <td><?=$type?></td>
          <td>Status</td>
          <td><?=$status?></td>
        </tr>
      </thead>
    </table>

    <table class="table table-striped" border="1" width="100%" cellspacing="0" style="padding-top: 20px">
      <thead>
        <tr>
          <th>No</th>
            <th>Barcode</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Isi</th>
            <th>Qty Order</th>
            <th>Qty Dikirim</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "select a.*,c.item_barcode,c.item_name,item_per_unit,d.unit_name,e.foreman_detail_qty from delivery_sends a
                join nota_detail_orders b on b.nota_detail_order_id = a.nota_detail_order_id
                join items c on c.item_id = b.item_id
                join units d on d.unit_id = c.unit_id
                left join foreman_details e on e.delivery_send_id = a.delivery_send_id
                where a.delivery_detail_id = $delivery_detail_id";
        $detail = $this->g_mod->select_manual_for($sql);
        $no = 1;
        foreach ($detail->result() as $val2) {?>
          <tr>
            <td><?=$no?></td>
            <td><?=$val2->item_barcode?></td>
            <td><?=$val2->item_name?></td>
            <td><?=$val2->unit_name?></td>
            <td><?=$val2->item_per_unit?></td>
            <td><?=$val2->delivery_send_qty?></td>
            <td><?=$val2->foreman_detail_qty?></td>
          </tr>
        <? 
        $no++;
        }?>
      </tbody>
    </table>
  </div>
</body>
</html>