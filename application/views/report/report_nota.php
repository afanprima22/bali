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

   
    if($nota_type == 1){
      $status = "CASH";
    }elseif($nota_type == 2){
      $status = "COD";
    }elseif($nota_type == 3){
      $status = "KREDIT/HUTANG";
    }

    ?>
    <h4 align="center" style="font-size: 16px;"><b><?php echo $title; ?></b></h4>

    <table class="table table-striped" border="0" width="100%" cellspacing="0">
      <thead>
        <tr>
          <td>&nbsp;</td>
          <td>No Nota</td>
          <td><?=$nota_code?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Tanggal</td>
          <td><?=$nota_date?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Customer</td>
          <td><?=$customer_name.' ('.$customer_telp.')'?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><?=$customer_address?></td>
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
                where a.delivery_detail_id = $nota_id";
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
    <p>&nbsp;</p>
    <table class="table table-striped" border="0" width="100%" cellspacing="0">
      <thead>
        <tr>
          <td>Terbilang</td>
          <td>Total</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Potongan</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Uang Muka</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Netto</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Status</td>
          <td>&nbsp;</td>
        </tr>
      </thead>
    </table>
    <table width="100%" border="0">
      <tr>
        <td align="center">Kasir</td>
        <td align="center">Singaraja, 06-Jul-2017 13:37</td>
      </tr>
      <tr>
        <td height="52">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center">Krisna Penarukan</td>
        <td align="center">(.....................................................)</td>
      </tr>
      <tr>
        <td><em>Catatan:</em></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td><em>*Harap memeriksa kelengkapan dan kondisi barang yang diterima</em></td>
        <td align="center">&nbsp;</td>
      </tr>
    </table>
  </div>
</body>
</html>