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
                                <th>ID Stok</th>
                                <th>tanggal Stok opname</th>
                                <th>nama gudang</th>
                                <th>Kode Stok</th>
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
                            <label>Id Stok opname (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Gudang</label>
                            <select class="form-control select2" onchange="search_data_stok(this.value), select_list_rack(this.value)" name="i_warehouse" id="i_warehouse" style="width: 100%;" required="required" value=""></select>
                          </div>
                        </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Rak</label>
                            <select class="form-control select2" onchange="search_data_stok_rack(this.value)"  name="i_rack" id="i_rack" style="width: 100%;" required="required" ></select>
                          </div>
                      </div>
          <!--VIEW GUDANG-->
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List View</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>barcode</th>
                                      <th>nama barang</th>
                                      <th>satuan</th>
                                      <th>isi</th>
                                      <th>jumlah</th>
                                      <th>Rak</th>
                                      <th style="width:50%">Qty Real</th>
                                      <th style="width:50%">Keterangan</th>
                                      <th>Qty Rusak</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              <div class="box-footer text-right">
                                <button type="button" onclick="reset()" class="btn btn-warning">Batal</button>
                                <button type="button" onclick="save_stok()" class="btn btn-primary">Simpan stok</button>
                              </div>
                            </div>
                          </div>
                        </div>
          <!-- LIST DETAIL -->
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2><input type="hidden" class="form-control" name="i_stok" id="i_stok" placeholder="Auto" readonly="">
                              
<!--                               <div class="btn-group pull-right"><a href="#myModal" onclick="get_purchase_id()" class="btn-sm btn-success" data-toggle="modal" ><i class="glyphicon glyphicon-plus"> Detail</i></a></div>
 -->                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>barcode</th>
                                      <th>nama barang</th>
                                      <th>Stock Lama</th>
                                      <th>Rak</th>
                                      <th>Qty Real</th>
                                      <th>Keterangan</th>
                                      <th>Qty Rusak</th>
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
                       <button type="button" onclick="reset()" class="btn btn-warning">Batal</button>
                       <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                    </div>
                    </div>
                  </form>

    </div>
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        search_data_detail(0);
        search_data_stok(0);
        select_list_warehouse();
        select_list_rack();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Stokopname/load_data/'
            },
            "columns": [
              {"name": "stok_opname_id"},
              {"name": "stok_opname_date"},
              {"name": "warehouse_id"},
              {"name": "stok_opname_code"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
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
          url  : '<?php echo base_url();?>Stokopname/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset1();
              search_data();
              search_data_detail(0);
              search_data_stok(0);
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

    function reset1(){
      $("#i_warehouse option").remove();
      $("#i_rack option").remove();
    }


    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Stokopname/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].stok_opname_id;
              $("#i_warehouse").append('<option value="'+data.val[i].warehouse_id+'" selected>'+data.val[i].warehouse_name+'</option>');
              get_stok_opname_id();
              search_data_detail(data.val[i].stok_opname_id);
              search_data_detail(data.val[i].warehouse_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function get_stok_opname_id(){
      var get_stok_opname_id = $('input[name="i_id"]').val();
      //alert(purchase_id);
      $('input[name="i_stok"]').val(get_stok_opname_id);
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Stokopname/delete_data',
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

      function select_list_warehouse() {
        $('#i_warehouse').select2({
          placeholder: 'Pilih gudang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Warehouse/load_data_select_warehouse/',
            dataType: 'json',
            delay: 100,
            cache: true,
            data: function (params) {
              reset1();
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
      function reset1(){
        $('#i_rack option').remove();
      }

      function select_list_rack(id) {
        $('#i_rack').select2({
          placeholder: 'Pilih Rak',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Stokopname/load_data_select_rack/'+id,
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


    function search_data_detail(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Stokopname/load_data_detail/'+id,
            },
            
          
            "columns": [
              
              {"name": "item_barcode"},
              {"name": "item_name"},
              {"name": "stok_opname_detail_qty_old"},
              {"name": "rack_name"},
              {"name": "stok_opname_detail_real"},
              {"name": "stok_opname_detail_desc"},
              {"name": "stok_opname_detail_qty_rusak"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
              
        });
        select_list_rack(id);
    }

    function search_data_stok(id) { 
      if (!id) {
        var id=0;
      };
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Stokopname/load_data_stok/'+id,
            },
            
          
            "columns": [
              {"name": "item_barcode"},
              {"name": "item_name"},
              {"name": "unit_name"},
              {"name": "item_per_unit"},
              {"name": "stock_qty"},
              {"name": "rack_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10

              
        });
    }

    function search_data_stok_rack(id) { 
      var warehouse_id = document.getElementById('i_warehouse').value;
      if (!id) {
        var id=0;
        search_data_stok(warehouse_id);
      }
      else{
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Stokopname/load_data_stok_rack/'+id,
            },
            
          
            "columns": [
              {"name": "item_barcode"},
              {"name": "item_name"},
              {"name": "unit_name"},
              {"name": "item_per_unit"},
              {"name": "stock_qty"},
              {"name": "rack_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
              
        });
      }
    }

    /*function stok_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Stokopname/load_data_stok_detail/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_rack"]').val(data.val[i].rack_detail_id);
              $('input[name="i_barcode"]').val(data.val[i].item_barcode);
              $('input[name="i_item"]').val(data.val[i].item_name);
              $('input[name="i_isi"]').val(data.val[i].item_per_unit);
              $('input[name="i_unit"]').val(data.val[i].unit_name);
              $('input[name="i_rack"]').val(data.val[i].rack_name);

            }
          }
        });
      }*/

      function get_stok_opname(id){
    var id_stok = document.getElementById("i_id").value;
        if (id_stok) {
          var id_new = id_stok;
        }else{
          var id_new = 0;
        }
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Stokopname/action_data_stok/'+id,
          data :  $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            search_data_detail(id_new);
          }
        });

    }

    function save_stok(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Stokopname/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              search_data_detail(id_new);
              
            } 
          }
        });
      }

</script>
</body>
</html>