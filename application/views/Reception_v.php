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
                                <th>Code Pembelian</th>
                                <th>tanggal terima</th>
                                <th>nama gudang</th>
                                <th>Kode Terima</th>
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
                            <label>Id Reception (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Code Pembelian</label>
                            <select class="form-control select2"  onchange="get_reference(this.value)" name="i_code" id="i_code" style="width: 100%;" required="required" value=""></select>
                          </div>
                          <div class="form-group">
                            <label>tanggal terima</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date_reception" placeholder="Tanggal Lahir" value="" required="required">
                            </div>
                          </div>
                        </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label>Gudang</label>
                            <select class="form-control select2" name="i_warehouse" id="i_warehouse" style="width: 100%;" required="required" value=""></select>
                          </div>
                        
                      </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2><input type="hidden" class="form-control" name="i_reception" id="i_reception" placeholder="Auto" readonly="">
                              <input type="hidden" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
<!--                               <div class="btn-group pull-right"><a href="#myModal" onclick="get_purchase_id()" class="btn-sm btn-success" data-toggle="modal" ><i class="glyphicon glyphicon-plus"> Detail</i></a></div>
 -->                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                        <td><input type="text" class="form-control" name="i_detail_reception" id="i_detail_reception" placeholder="Auto" value="" readonly=""></td>
                                      <!-- <tr>
                                        <td><input type="text" class="form-control" placeholder="Barcode"  name="i_barcode" id="i_barcode" value="" readonly onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                        <td><input type="text" class="form-control"  name="i_item" id="i_item" readonly style="width: 85%;" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>                                         <td><input type="text" class="form-control" name="i_unit" id="i_unit" required="required" readonly onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                         <td><input type="text" readonly="" class="form-control" name="i_order" id="i_order" placeholder="jumlah order" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                        <td><input type="number" class="form-control" onchange="Qty(this.value)" name="i_Qty" id="i_Qty" placeholder="Qty deterima" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                        <td><input type="hidden" class="form-control" name="i_sisa" id="i_sisa" required="required" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                        <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Barang</button></td>
                                        
                                    </tr> -->
                                    <tr>
                                      <th>Id</th>
                                      <th>barcode</th>
                                      <th>nama barang</th>
                                      <th>jumlah order</th>
                                      <th>Qty diterima</th>
                                      <th>id</th>
                                      <th>Qty sisa</th>
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
                        <button type="button" onclick="reset()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>

                    </div>
                
                    </form>
            </div>
        </div>

        <div style="padding-top: 50px;" width="120%" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content" width="100%">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Detail Penerimaan</h4><input type="text" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                        <div class="row">
                          <div class="col-md-12">
                            
                              <form id="formclass" role="form" action="" method="post" enctype="multipart/form-data">
                                <div class="box-content">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>qty pembatalan</label>
                                      <input type="number" class="form-control" onchange="batal(this.value)" name="i_batal" id="i_batal" placeholder="masukkan qty dibatalkan" value="" >
                                  </div>
                                  <div class="form-group">
                                    <label>keterangan</label>
                                      <input type="text" class="form-control" name="i_desc_batal" id="i_desc_batal" placeholder="Alasan"  value="">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>qty kembali</label>
                                      <input type="number" class="form-control" onchange="kembali(this.value)" name="i_kembali" id="i_kembali" placeholder="Masukkan qty dikembalikan"  value="">
                                  </div>
                                  <div class="form-group">
                                    <label>keterangan</label>
                                      <input type="text" class="form-control" name="i_desc_kembali" id="i_desc_kembali" placeholder="alasan"  value="">
                                  </div>
                                </div>
                                </div>
                                  <div class="box-footer text-right">
                                    <button type="button" onclick="reset2()" class="btn btn-warning">Batal</button>
                                    <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                                  </div>
                              </form>
                          </div>
                          </div>
                          </div>
                          <div class="box-inner">
                          <div class="row">
                          
                            <div class="col-md-12">
                            <div class="box-inner">
                              <div class="box-content" width="100%">
                                      <table width="160%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                          <thead>
                                              <tr>
                                                  <th>Qty pembatalan</th>
                                                  <th>keterangan pembatalan</th>
                                                  <th>Qty kembali</th>
                                                  <th>keterangan kembali</th>
                                                  <th>Config</th>
                                              </tr>
                                          </thead>
                                      </table>
                                  </div>
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

    </div>
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        search_data_detail(0);
        select_list_code();
        select_list_warehouse();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Reception/load_data/'
            },
            "columns": [
              {"name": "purchase_id"},
              {"name": "reception_date"},
              {"name": "warehouse_id"},
              {"name": "reception_code"},
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

    function search_data_detail(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Reception/load_data_detail/'+id,
            },
            
          
            "columns": [
              {"name": "reception_detail_id"},
              {"name": "item_barcode"},
              {"name": "item_name"},
              {"name": "reception_detail_order"},
              {"name": "reception_detail_qty"},
              {"name": "purchase_detail_id"},
              {"name": "reception_detail_order-purchase_detail_qty_akumulation"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
              
        });
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Reception/delete_data',
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
          url  : '<?php echo base_url();?>Reception/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].reception_id;
              $("#i_code").append('<option value="'+data.val[i].purchase_id+'" selected>'+data.val[i].purchase_code+'</option>');
              document.getElementById("datepicker").value           = data.val[i].reception_date;
              $("#i_warehouse").append('<option value="'+data.val[i].warehouse_id+'" selected>'+data.val[i].warehouse_name+'</option>');
              get_reception_id();
              search_data_detail(data.val[i].reception_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_code() {
        $('#i_code').select2({
          placeholder: 'Pilih code pembelian',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Purchase/load_data_select_code/',
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

      function action_data(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Reception/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset1();
              search_data();
              search_data_detail(0);
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
      $("#i_code option").remove();
      $("#i_warehouse option").remove();
    }

    /*function select_list_unit() {
        $('#i_unit').select2({
          placeholder: 'Pilih Satuan',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_unit/',
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
      }*/

      function save_detail(){
        var id = document.getElementById("i_reception").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        var id1 =document.getElementById("i_id").value;
        var id2 =document.getElementById("i_sisa").value;
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Reception/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3();
              search_data_detail(id_new);
            } 
          }
        });
      }

      function reset3(){
        $('input[name="i_barcode"]').val("");
        $('input[name="i_item"]').val("");
        $('input[name="i_order"]').val("");
        $('input[name="i_Qty"]').val("");
      }

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Reception/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
           var reception_id = $('input[name="i_id"]').val();
      //alert(purchase_id);
              $('input[name="i_reception"]').val(reception_id);
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id"]').val(data.val[i].purchase_detail_id);
              $('input[name="i_detail_reception"]').val(data.val[i].reception_detail_id);
              $('input[name="i_barcode"]').val(data.val[i].item_barcode);
              $('input[name="i_item"]').val(data.val[i].item_id).val(data.val[i].item_name);
              $('input[name="i_order"]').val(data.val[i].reception_detail_order);
              $('input[name="i_Qty"]').val(data.val[i].reception_detail_qty);

            }
          }
        });
      }

      /*function select_list_item(id) {
        $('#i_item').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Purchase/load_data_select_detail/'+id,
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
      }*/

      

      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_detail_reception").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Reception/delete_data_detail',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_detail(id_new);
                  }
                }
            });
        }
        
    }

    function reception_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Reception/load_data_reception_detail/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id"]').val(data.val[i].purchase_detail_id);
              $('input[name="i_barcode"]').val(data.val[i].item_barcode);
              $('input[name="i_item"]').val(data.val[i].item_id).val(data.val[i].item_name);
              $('input[name="i_unit"]').val(data.val[i].unit_id);
              $('input[name="i_order"]').val(data.val[i].purchase_detail_qty);
              $('input[name="i_sisa"]').val(data.val[i].purchase_detail_qty_akumulation);

            }
          }
        });
      }

      function Qty(id){
        var order = document.getElementById("i_order").value;
        var sisa = document.getElementById("i_sisa").value;
        if (parseFloat(id)>parseFloat(sisa)) {
          reset7()
          alert("qty tidak boleh lebih dari order")
        };
      }

      function reset7(){
        $('input[name="i_Qty"]').val("");
      }

      function batal(id){
        var order = document.getElementById("i_order").value;
        var qty = document.getElementById("i_Qty").value;
        var kembali = document.getElementById("i_kembali").value;
        var total = (parseFloat(order)-parseFloat(qty));
          if (parseFloat(id)>parseFloat(total)) {
          reset6()

          alert("qty tidak boleh lebih dari order")
          };
      }

      function reset6(){
        $('input[name="i_batal"]').val("");
      }

      function kembali(id){
        var order = document.getElementById("i_order").value;
        var qty = document.getElementById("i_Qty").value;
        var batal = document.getElementById("i_batal").value;
        var total = (parseFloat(order)-parseFloat(qty));
          if (parseFloat(id)>parseFloat(total)) {
          reset5()

          alert("qty tidak boleh lebih dari order")
          };
      }

      function reset5(){
        $('input[name="i_kembali"]').val("");
      }


      function search_data_reception_detail(id) { 
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
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

        $('input[name="i_detail_id"]').val(id);
    }


    $("#form_modal").submit(function(event){
        if ($("#form_modal").valid()==true) {
          action_detail();
        }
        return false;
      });
      

      function action_detail(){
        var id = document.getElementById("i_detail_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Reception/action_reception_detail/',
          data : $( "#form_modal" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              search_reception_detail(id_new);
            } 
          }
        });
      }

      function search_reception_detail(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Reception/load_reception_detail/'+id,
            },
            
          
            "columns": [
              {"name": "reception_detail_qty_batal"},
              {"name": "reception_detail_desc_batal"},
              {"name": "reception_detail_qty_kembali"},
              {"name": "reception_detail_desc_kembali"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
              
        });
        $('input[name="i_detail_id"]').val(id);
    }

    function get_reception_id(){
      var reception_id = $('input[name="i_id"]').val();
      //alert(purchase_id);
      $('input[name="i_reception"]').val(reception_id);
    }

    function get_reference(id){
      //alert(warehouse_id);
    var id_reception = document.getElementById("i_id").value;
        if (id_reception) {
          var id_new = id_reception;
        }else{
          var id_new = 0;
        }
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Reception/action_data_reference/'+id,
          data : {id:id,id_new:id_new},
          dataType : "json",
          success:function(data){
            search_data_detail(id_new);
          }
        });

    }

    function get_detail_reception(value,id){
      //alert(warehouse_id);
      
       var id_reception = document.getElementById("i_detail_reception").value;
        if (id_reception) {
          var id_new = id_reception;
        }else{
          var id_new = 0;
        }
        var id_purchase = document.getElementById("i_detail_id").value;
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Reception/action_data_reception/'+id,
          data : {value:value,id:id},
          dataType : "json",
          success:function(data){
            search_data_detail(id_new);
          }
        });

    }

</script>
</body>
</html>
    