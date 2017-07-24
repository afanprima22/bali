<?
if ($query<>false) {
  foreach ($query->result() as $val) {

    if ($val->delivery_detail_type == 1) {
      $type = "Kirim";
    }else{
      $type = "Ambil";
    }

    ?>
    <div class="col-md-12" style="padding-bottom: 10px;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <div class="col-md-4"><h2>No DO : <?=$val->delivery_detail_code?></h2> </div>
                              <div class="col-md-4"><h2>Gudang : <?=$val->warehouse_name?></h2> </div>
                              <div class="col-md-4"><h2>Type DO : <?=$type?></h2> </div>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered responsive">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Barcode</th>
                                      <th>Nama Barang</th>
                                      <th>Satuan</th>
                                      <th>Isi</th>
                                      <th>Qty Order</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?
                                    $sql = "select a.*,c.item_barcode,c.item_name,item_per_unit,d.unit_name from delivery_sends a
                                            join nota_detail_orders b on b.nota_detail_order_id = a.nota_detail_order_id
                                            join items c on c.item_id = b.item_id
                                            join units d on d.unit_id = c.unit_id
                                            where a.delivery_detail_id = $val->delivery_detail_id";
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
                                      </tr>
                                    <? 
                                    $no++;
                                    }?>
                                  </tbody>
                                </table>                                
                              </div>
                            </div>
                          </div>
                        </div>
    
  <?}
}

?>                        
