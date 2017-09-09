<style type="text/css">
  .money{
    text-align: right;
  }
</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#list" data-toggle="tab">List Data</a></li>
        <li><a href="#form" data-toggle="tab">Form Data</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="list">
            <div class="box-inner">
                <div class="box-content">
                    <div id="create" class="alert alert-success" style="display: none;"><h4><i class="glyphicon glyphicon-check"></i> Sukses!</h4>Data telah Disimpan.</div>
                    <div id="update" class="alert alert-info" style="display: none;"><h4><i class="glyphicon glyphicon-info-sign"></i> Sukses!</h4>Data telah Direvisi.</div>
                    <div id="delete" class="alert alert-danger" style="display: none;"><h4><i class="glyphicon glyphicon-ban-circle"></i> Sukses!</h4>Data telah Dihapus.</div>
                    <table width="100%" id="table1" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                        <thead>
                            <tr>
                                <th>Kode Gudang</th>
                                <th>Nama Gudang</th>
                                <th>Telepon</th>
                                <th>No Fax</th>
                                <th>PIC</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                
            </div>

        </div>
        <div class="tab-pane" id="form">
            <div class="box-inner">

                <form id="formall" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
                    <div class="box-content">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Kode Gudang</label>
                            <input type="text" class="form-control" name="i_code" id="i_code" placeholder="Masukkan Kode Gudang" required="required" value="">
                            <input type="hidden" class="form-control" name="i_id" id="i_id" value="">
                          </div>
                          <div class="form-group">
                            <label>Nama Gudang</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Gudang" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Telepon</label>
                            <input type="number" class="form-control" name="i_telp" id="i_telp" placeholder="Masukkan Telepon" required="required" value="">
                          </div>
                          <div id="cek_stock" style="display: none;">
                            <a href="#stockModal" onclick="search_data_stock()" class="btn btn-info" data-toggle="modal"><i class="glyphicon glyphicon-search"></i> Cek Stock</a>
                          </div>
                          
                          <?
                          //echo fmod(10, 12);
                          ?>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>No Fax</label>
                            <input type="text" class="form-control" name="i_fax" id="i_fax" placeholder="Masukkan No Fax" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>PIC</label>
                            <input type="text" class="form-control" name="i_pic" id="i_pic" placeholder="Masukkan PIC" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Gudang" required="required" name="i_addres" id="i_addres"></textarea>
                          </div>
                          
                        </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Rak</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_rack_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <input type="text" class="form-control" name="i_rack_name" placeholder="Masukkan Nama Rak" onkeydown="if (event.keyCode == 13) { save_rack(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_rack()" class="btn btn-primary">Simpan Rak</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Nama Rak</th>
                                      <th >Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="form-group"></div>
                      <div class="box-footer text-right">
                        <!--<a href="#myModal" class="btn btn-info" data-toggle="modal">Click for dialog</a>-->
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>

                    </div>
                </form>

            </div>
        </div>

        <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Detail Rak</h4><input type="text" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                            
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_rack_detail_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;">
                                        </select>
                                      </td>
                                      <td><input type="text" class="form-control" name="i_stock_qty" placeholder="Masukkan Qty Stok"></td>
                                      <td width="10%"><button type="button" onclick="save_rack_detail()" class="btn btn-primary">Simpan Barang</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Barang</th>
                                      <th>Qty Stok</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                  </div>
                  <div class="modal-footer">
                      <a href="#" class="btn btn-warning" data-dismiss="modal">Selesai</a>
                      <!--<a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Save changes</a>-->
                  </div>
              </div>
          </form>
          </div>
      </div>

      <div style="padding-top: 50px;" class="modal fade" id="stockModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Stock Barang</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                            
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table4" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>gudang</th>
                                      <th>Rak</th>
                                      <th>Barang</th>
                                      <th>Qty</th>
                                      <th>Qty Konversi</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                  </div>
                  <div class="modal-footer">
                      <a href="#" class="btn btn-warning" data-dismiss="modal">Selesai</a>
                  </div>
              </div>
          </form>
          </div>
      </div>

    </div>
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        search_data_rack(0);
        select_list_item();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Warehouse/load_data/'
            },
            "columns": [
              {"name": "warehouse_code"},
              {"name": "warehouse_name"},
              {"name": "warehouse_telp"},
              {"name": "warehouse_fax"},
              {"name": "warehouse_pic"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_rack(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Warehouse/load_data_rack/'+id
            },
            "columns": [
              {"name": "rack_id"},
              {"name": "rack_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_rack_detail(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Warehouse/load_data_rack_detail/'+id
            },
            "columns": [
              {"name": "rack_detail_id"},
              {"name": "item_name"},
              {"name": "stock_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

        $('input[name="i_detail_id"]').val(id);
    }

    function search_data_stock() { 
      var id = document.getElementById("i_id").value;
        $('#table4').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Warehouse/load_data_stock/'+id
            },
            "columns": [
              {"name": "warehouse_name"},
              {"name": "rack_name"},
              {"name": "item_name"},
              {"name": "stock_qty_unit","orderable": false,"searchable": false},
              {"name": "stock_qty"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    $("#formall").submit(function(event){
        if ($("#formall").valid()==true) {
          action_data();
        }
        return false;
      });

    function action_data(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Warehouse/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2()
              search_data();
              $('[href="#list"]').tab('show');
              if (data.alert=='1') {
                document.getElementById('create').style.display = 'block';
                document.getElementById('update').style.display = 'none';
                document.getElementById('delete').style.display = 'none';
              }else if(data.alert=='2'){
                document.getElementById('create').style.display = 'none';
                document.getElementById('update').style.display = 'block';
                document.getElementById('delete').style.display = 'none';
              }
            } 
          }
        });
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Warehouse/delete_data',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset();
                    search_data();

                    document.getElementById('create').style.display = 'none';
                    document.getElementById('update').style.display = 'none';
                    document.getElementById('delete').style.display = 'block';
                  }
                }
            });
        }
        
    }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Warehouse/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].warehouse_id;
              document.getElementById("i_name").value           = data.val[i].warehouse_name;
              document.getElementById("i_code").value           = data.val[i].warehouse_code;
              document.getElementById("i_telp").value         = data.val[i].warehouse_telp;
              document.getElementById("i_addres").value      = data.val[i].warehouse_address;
              document.getElementById("i_fax").value         = data.val[i].warehouse_fax;
              document.getElementById("i_pic").value         = data.val[i].warehouse_pic;

              search_data_rack(data.val[i].warehouse_id);
              document.getElementById('cek_stock').style.display = 'block';
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function reset2(){
      document.getElementById('cek_stock').style.display = 'none';
      search_data_rack(0);
    }

      function select_list_item() {
        $('#i_item').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_item/',
            dataType: 'json',
            delay: 100,
            cache: true,
            data: function (params) {
              return {
                q: params.term, // search term
                page: params.page
              };
            },
            processResults: function (data, params) {
              params.page = params.page || 1;

              return {
                results: data.items,
                pagination: {
                  more: (params.page * 30) < data.total_count
                }
              };
            }
          },
          escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
          minimumInputLength: 1,
          templateResult: FormatResult,
          templateSelection: FormatSelection,
        });
      }

      function save_rack(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Warehouse/action_data_rack/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3();
              search_data_rack(id_new);
            } 
          }
        });
      }

      function reset3(){
        $('input[name="i_rack_id"]').val("");
        $('input[name="i_rack_name"]').val("");
      }

      function edit_data_rack(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Warehouse/load_data_where_rack/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_rack_id"]').val(data.val[i].rack_id);
              $('input[name="i_rack_name"]').val(data.val[i].rack_name);

            }
          }
        });
      }

      function delete_data_rack(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Warehouse/delete_data_rack',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_rack(id_new);
                  }
                }
            });
        }
        
    }

    function save_rack_detail(){
        var id = document.getElementById("i_detail_id").value;
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Warehouse/action_data_rack_detail/',
          data : $( "#form_modal" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset4();
              search_data_rack_detail(id);
            } 
          }
        });
      }

      function reset4(){
        $('#i_item option').remove();
        $('input[name="i_stock_qty"]').val("");
      }

      function edit_data_rack_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Warehouse/load_data_where_rack_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_rack_detail_id"]').val(data.val[i].rack_detail_id);
              $('input[name="i_stock_qty"]').val(data.val[i].stock_qty);
              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');

            }
          }
        });
      }

      function delete_data_rack_detail(id_formula) {
        var id = document.getElementById("i_detail_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Warehouse/delete_data_rack_detail',
                data: 'id='+id_formula,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_rack_detail(id_new);
                  }
                }
            });
        }
        
    }

    function print_pdf(id){
      window.open('<?php echo base_url();?>Warehouse/print_stock_pdf?id='+id);
    }

    
</script>
</body>
</html>