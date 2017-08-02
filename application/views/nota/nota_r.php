                          <div class="box-inner">
                          <form id="formretail" role="form" action="" method="post" enctype="multipart/form-data">
                            <div class="box-header well" data-original-title="">
                              <div class="col-md-4"><h2>No Nota : <? if(isset($nota_code)) echo $nota_code?></h2> </div>
                              <div class="col-md-4"><h2>Gudang : <? if(isset($warehouse_name)) echo $warehouse_name?></h2> </div>
                              <div class="col-md-4"><h2>Customer : <? if(isset($customer_name)) echo $customer_name?></h2> </div>
                            </div>
                            <div class="box-content">
                              <input type="hidden" class="form-control" name="i_nota_id" value="<? if(isset($nota_id)) echo $nota_id?>">
                                <?
                                if (isset($query) && $query<>false) {
                                  $no = 1;
                                  foreach ($query->result() as $val) {
                                    if ($val->nota_detail_retail) {
                                      $qty = $val->nota_detail_retail;
                                    }else{
                                      $qty = 0;
                                    }
                                  ?>
                                  <table width="100%" id="table3" class="table table-striped table-bordered responsive">
                                    <thead>
                                      <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Qty Retail</th>
                                        <?
                                        $sql = "select a.*,b.rack_name,c.item_per_unit,(a.stock_qty / c.item_per_unit) as stok,d.nota_detail_retail_qty from stocks a
                                                JOIN racks b on b.rack_id = a.rack_id
                                                JOIN items c on c.item_id = a.item_id
                                                left JOIN nota_detail_retails d on d.nota_detail_id = $val->nota_detail_id and d.rack_id = b.rack_id and d.item_id = c.item_id
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
                                            <td><input type="number" class="form-control" name="i_qty_retail<?=$val->nota_detail_id.$val2->rack_id.$val2->item_id?>" value="<?=$val2->nota_detail_retail_qty?>" placeholder="Diambil"></td>
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
                                <!--<button type="button" onclick="reset3()" class="btn btn-warning">Batal</button>-->
                                <button type="button" class="btn btn-primary" onclick="save_retail()" <?php if(isset($c)) echo $c;?>>Simpan</button>
                              </div>
                              <? }?>
                            </div>

                          </form>
                          </div>