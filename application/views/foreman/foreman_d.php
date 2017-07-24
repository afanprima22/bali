    <div class="col-md-12" style="padding-bottom: 10px;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <div class="col-md-4"><h2>No DO : <? if(isset($delivery_detail_code)) echo $delivery_detail_code?></h2> </div>
                              <div class="col-md-4"><h2>Gudang : <? if(isset($warehouse_name)) echo $warehouse_name?></h2> </div>
                              <div class="col-md-4"><h2>Type DO : <? if(isset($type)) echo $type?></h2> </div>
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
                                      <th>Qty Kirim</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?
                                    if (isset($query) && $query<>false) {
                                      $no = 1;
                                      foreach ($query->result() as $val) {
                                        if ($val->foreman_detail_qty) {
                                          $qty = $val->foreman_detail_qty;
                                        }else{
                                          $qty = '';
                                        }
                                        ?>
                                        <tr>
                                          <td><?=$no?></td>
                                          <td><?=$val->item_barcode?></td>
                                          <td><?=$val->item_name?></td>
                                          <td><?=$val->unit_name?></td>
                                          <td><?=$val->item_per_unit?></td>
                                          <td><?=$val->delivery_send_qty?></td>
                                          <td><input type="number" onchange="get_qty(this.value,<?=$val->delivery_send_qty?>,<?=$val->delivery_send_id?>)" class="form-control" name="i_qty<?=$val->delivery_send_id?>" id="i_qty<?=$val->delivery_send_id?>" value="<?=$qty?>" placeholder="Dikirim"></td>
                                        </tr>
                                      <? 
                                      $no++;
                                      }
                                    }
                                    ?>
                                  </tbody>
                                </table>                                
                              </div>
                            </div>
                          </div>
                        </div>
