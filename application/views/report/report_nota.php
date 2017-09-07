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
    <!--<h4 align="center" style="font-size: 16px;"><b><?php echo $title; ?></b></h4>-->
    <table class="table table-striped" border="0" width="100%" cellspacing="0">
      <thead>
        <tr>
          <td colspan="3" style="font-size: 20px;text-align: center;"><b><?php echo $title; ?></b></td>
        </tr>
        <tr>
          <td width="50%">&nbsp;</td>
          <td width="10%">No Nota</td>
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
    <table class="table table-striped" border="1" width="100%" cellspacing="0" style="padding-top: 10px">
      <thead>
        <tr>
          <th>No</th>
          <th>Qty</th>
          <th>Ambil</th>
          <th>Nama Barang</th>
          <th>Satuan (Rp)</th>
          <th>Potongan (Rp)</th>
          <th>Jumlah (Rp)</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT a.*,b.item_name,c.unit_name,d.qty_order,d.qty_ambil from nota_details a
                join items b on b.item_id = a.item_id
                join units c on c.unit_id = b.unit_id
                join (SELECT z.nota_detail_id,(SUM(z.nota_detail_order_qty + z.nota_detail_order_now)) as qty_order,(SUM(z.nota_detail_order_now)) as qty_ambil from nota_detail_orders z group by z.nota_detail_id) d on d.nota_detail_id = a.nota_detail_id
                where a.nota_id = $nota_id";
        $detail = $this->g_mod->select_manual_for($sql);
        $no = 1;
        $grand_total = 0;
        $potongan = 0;
        foreach ($detail->result() as $val2) {
          $qty_order = $val2->qty_order + $val2->nota_detail_retail;
          $total = $qty_order * $val2->nota_detail_price;
          ?>
          <tr>
            <td><?=$no?></td>
            <td><?= number_format($qty_order).'('.$val2->unit_name.')'?></td>
            <td><?=$val2->qty_ambil?></td>
            <td><?=$val2->item_name?></td>
            <td align="right"><?= number_format($val2->nota_detail_price)?></td>
            <td align="right"><?= number_format($val2->nota_detail_promo)?></td>
            <td align="right"><?= number_format($total)?></td>
          </tr>
        <? 
        $no++;
        $grand_total += $total;
        $potongan += $val2->nota_detail_promo;
        }?>
      </tbody>
    </table>
    <table class="table table-striped" border="0" width="100%" cellspacing="0" style="padding-top: 10px">
      <thead>
        <tr>
          <td width="70%">Terbilang:</td>
          <td width="10%">Total</td>
          <td align="right"><?= number_format($grand_total)?></td>
        </tr>
        <tr>
          <td><?= ucwords(Terbilang($grand_total - $potongan))?></td>
          <td>Potongan</td>
          <td align="right"><?= number_format($potongan)?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Uang Muka</td>
          <td align="right"><?= number_format($nota_dp)?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Netto</td>
          <td align="right" ><p style="text-decoration: underline overline line-through;"><u><?= number_format($grand_total - $potongan)?></u></p></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Status</td>
          <td align="right"><?=$status?></td>
        </tr>
      </thead>
    </table>
    <table width="100%" border="0">
      <tr>
        <td align="center">Kasir</td>
        <td align="center">Singaraja, <?= date('d-M-Y H:i')?></td>
      </tr>
      <tr>
        <td height="30">&nbsp;</td>
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

<?php
function Terbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}

?>