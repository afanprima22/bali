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
    <h4 align="center" style="font-size: 16px;"><b><?php echo $title; ?></b></h4>
    <?php
    $no = 1;
    ?>
    <table class="table table-striped" border="1" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>NO</th>
          <th>Kode Nota</th>
          <th>Tanggal Proses</th>
          <th>Customer</th>
          <th>Alamat Customer</th>
        </tr>
      </thead>
      <tbody>
      <?php    
      if ($query<>false) {
        $no = 1;
        foreach ($query->result() as $val) {
      ?>
        <tr>
          <td><?php echo $no;?></td>
          <td><?php echo $val->nota_code;?></td>
          <td><?php echo $val->nota_date;?></td>
          <td><?php echo $val->customer_name;?></td>
          <td><?php echo $val->customer_address;?></td>
        </tr>
      <?php
          $no++;
        }
      }
      ?>
      </tbody>
    </table>
  </div>
</body>
</html>