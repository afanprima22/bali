                          <div class="box-inner">
                          <form id="formspesific" role="form" action="" method="post" enctype="multipart/form-data">
                            <div class="box-header well" data-original-title="">
                              <div class="col-md-3"><h2>Kode Nota : <? if(isset($nota_code)) echo $nota_code?></h2> </div>
                              <div class="col-md-4"><h2>No DO : <? if(isset($delivery_detail_code)) echo $delivery_detail_code?></h2> </div>
                              <div class="col-md-4"><h2>Gudang : <? if(isset($warehouse_name)) echo $warehouse_name?></h2> </div>
                              <div class="col-md-4"><h2>Type DO : <? if(isset($type)) echo $type?></h2> </div>
                            </div>
                            <div class="box-content">
                              <input type="hidden" class="form-control" name="i_foreman_id" value="<? if(isset($foreman_id)) echo $foreman_id?>">
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
                                  <table width="100%" id="table3" class="table table-striped table-bordered responsive">
                                    <thead>
                                      <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Qty Kirim</th>
                                        <?
                                        $sql = "select a.*,b.rack_name,c.item_per_unit,(a.stock_qty / c.item_per_unit) as stok,d.foreman_rack_qty from stocks a
                                                JOIN racks b on b.rack_id = a.rack_id
                                                JOIN items c on c.item_id = a.item_id
                                                left JOIN foreman_racks d on d.foreman_detail_id = $val->foreman_detail_id and d.rack_id = b.rack_id and d.item_id = c.item_id
                                                WHERE b.warehouse_id = $val->warehouse_id AND a.item_id = $val->item_id
                                                HAVING stok >=1";
                                        $query2 = $this->g_mod->select_manual_for($sql);
                                        if ($query2) {
                                          foreach ($query2->result() as $val2) {
                                            $mod = fmod($val2->stock_qty, $val2->item_per_unit);
                                            $stock = ($val2->stock_qty - $mod) / $val2->item_per_unit;
                                            ?>
                                            <th><?=$val2->rack_name?>  (<?=$stock?>)</th>
                                          <? }
                                        }
                                        ?>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td><?=$no?></td>
                                        <td><?=$val->item_name?></td>
                                        <td><?=$qty?></td>
                                        <?
                                        $query2 = $this->g_mod->select_manual_for($sql);
                                        if ($query2) {
                                          foreach ($query2->result() as $val2) {?>
                                            <td><input type="number" class="form-control" name="i_qty_spesifik<?=$val->foreman_detail_id.$val2->rack_id.$val2->item_id?>" value="<?=$val2->foreman_rack_qty?>" placeholder="Diambil"></td>
                                          <? }
                                        }
                                        ?>
                                      </tr>
                                    </tbody>
                                  </table> 
                                <? 
                                  $no++;
                                  }
                                
                                ?>                               
                              <div class="box-footer text-right">
                                <button type="button" onclick="reset3()" class="btn btn-warning">Batal</button>
                                <button type="button" class="btn btn-primary" onclick="save_spesifik()" <?php if(isset($c)) echo $c;?>>Simpan</button>
                              </div>
                              <? }?>
                            </div>

                          </form>
                          </div>