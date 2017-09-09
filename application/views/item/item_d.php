<div class="tab-pane active" id="list_data_item">
            <div class="box-inner">
                <div class="box-content">
                  <div class="btn-group pull-right"><button class="btn btn-warning btn-xl" type="button" onclick="print_pdf()" class="btn btn-primary">Print Pdf <i class="glyphicon glyphicon-print"></i></button></div>
                    <div id="create" class="alert alert-success" style="display: none;"><h4><i class="glyphicon glyphicon-check"></i> Sukses!</h4>Data telah Disimpan.</div>
                    <div id="update" class="alert alert-info" style="display: none;"><h4><i class="glyphicon glyphicon-info-sign"></i> Sukses!</h4>Data telah Direvisi.</div>
                    <div id="delete" class="alert alert-danger" style="display: none;"><h4><i class="glyphicon glyphicon-ban-circle"></i> Sukses!</h4>Data telah Dihapus.</div>
                    <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Class Item</th>
                                <th>Sub Class Item</th> 
                                <th>Merk</th>
                                <th>Satuan</th>
                                <th>Harga Terakhir</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                
            </div>

        </div>
        <div class="tab-pane" id="form_data_item">
            <div class="box-inner">

                <form id="formitem" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="box-content">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" name="i_name_item" id="i_name_item" placeholder="Masukkan Nama Barang" required="required" value="">
                            <input type="hidden" class="form-control" name="i_id_item" id="i_id_item" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Class Item</label>
                            <select class="form-control select2" name="i_class_item" id="i_class_item" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Sub Class Item</label>
                            <select class="form-control select2" name="i_sub_class_item" id="i_sub_class_item" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Merk</label>
                            <select class="form-control select2" name="i_brand" id="i_brand" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Barcode</label>
                            <input type="text" class="form-control" placeholder="Masukkan Barcode" required="required" name="i_barcode" id="i_barcode" value="">
                          </div>
                          <div class="form-group">
                            <label>Konversi</label>
                          </div>
                          <div class="form-group">
                          <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Qty Satuan" required="required" name="i_qty_unit" id="i_qty_unit" value="">
                            </div>
                            <div class="col-md-9">
                            <select class="form-control select2" name="i_unit" id="i_unit" style="width: 70%;" required="required">
                            </select>
                            <a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>Satuan</a>
                            </div>
                          </div>
                          <div class="form-group">&nbsp;</div>
                          <div class="form-group">
                            <label>Harga Beli Terakhir</label>
                            <input type="text" class="form-control money" placeholder="Masukkan Harga Beli Terakhir"  name="i_price_last" id="i_price_last" value="">
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Harga 1</label>
                            <input type="text" class="form-control money" placeholder="Masukkan Harga 1"  name="i_price1" id="i_price1" value="">
                          </div>
                          <div class="form-group">
                            <label>Harga 2</label>
                            <input type="text" class="form-control money" placeholder="Masukkan Harga 2"  name="i_price2" id="i_price2" value="">
                          </div>
                          <div class="form-group">
                            <label>Harga 3</label>
                            <input type="text" class="form-control money" placeholder="Masukkan Harga 3"  name="i_price3" id="i_price3" value="">
                          </div>
                          <div class="form-group">
                            <label>Harga 4</label>
                            <input type="text" class="form-control money" placeholder="Masukkan Harga 4"  name="i_price4" id="i_price4" value="">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Harga 5</label>
                            <input type="text" class="form-control money" placeholder="Masukkan Harga 5"  name="i_price5" id="i_price5" value="">
                          </div>
                          <div class="form-group">
                            <label>Stok Min</label>
                            <input type="number" class="form-control" placeholder="Masukkan Stok Min"  name="i_stok_min" id="i_stok_min" value="">
                          </div>
                          <div class="form-group">
                            <label>Stok Max</label>
                            <input type="number" class="form-control" placeholder="Masukkan Stok Max"  name="i_stok_max" id="i_stok_max" value="">
                          </div>
                          <div class="form-group">
                            <label>Biaya Angkut</label>
                            <input type="text" class="form-control money" placeholder="Masukkan Biaya Angkut"  name="i_cost" id="i_cost" value="">
                          </div>

                        </div>

                        <div class="col-md-12" id="detail_data" style="display: none;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2><i class="glyphicon glyphicon-picture"></i> Gallery</h2>
                              <div class="box-icon">
                              <div>
                                <span class="btn btn-success btn-xs fileinput-button"><i class="glyphicon glyphicon-plus"></i><span>Add files...</span><input type="file" onchange="get_save_galery(this.value)" name="i_galery" id="i_galery" title="fill slider img" /></span>
                                </div>
                              </div>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                
                                <div id="galeries"></div>

                              </div>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                      <div class="form-group"></div>
                      <div class="box-footer text-right">
                        <button type="button" onclick="reset(),reset4()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>

                    </div>
                </form>

            </div>
        </div>