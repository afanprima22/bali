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
                                <th>Kode Mutasi</th>
                                <th>Tanggal Mutasi</th>
                                <th>Asal Gudang</th>
                                <th>Gudang Tujuan</th>
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
                            <label>Tanggal Mutasi</label>
                              
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Mutasi" value="" required="required">
                            </div>
                          </div>
                        </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label>Gudang Asal</label>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" value="">
                            <select class="form-control select2" onchange="select_list_rack(this.value)"  name="i_warehouse" id="i_warehouse" style="width: 100%;" required="required" value=""></select>
                          </div>

                          <div class="form-group">
                            <label>Gudang Tujuan</label>
                            <select class="form-control select2" style="width: 100%;" class="form-control" name="i_warehouse2" id="i_warehouse2" value=""></select>
                          </div>
                        
                      </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>view Detail</h2>
<!--                               <div class="btn-group pull-right"><a href="#myModal" onclick="get_purchase_id()" class="btn-sm btn-success" data-toggle="modal" ><i class="glyphicon glyphicon-plus"> Detail</i></a></div>
 -->                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                        <td>
                                          <input type="hidden" class="form-control" name="i_detail" id="i_detail" value=""  >
                                          <input type="text" class="form-control" readonly="" placeholder="Barcode"  name="i_barcode" id="i_barcode" value="" readonly onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                        </td>
                                        <td>
                                          <select class="form-control select2" onchange="search_item(this.value)" class="form-control"  name="i_item" id="i_item"  style="width: 100%;" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                        </td>                                         
                                        <td><input type="text" readonly="" class="form-control" name="i_unit" id="i_unit" placeholder="satuan" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                        <td><input type="text" readonly="" class="form-control"  name="i_isi" id="i_isi" placeholder="isi per unit" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                        <td>
                                          <input type="number" class="form-control"  name="i_qty_mutasi" id="i_qty_mutasi" placeholder="Qty mutasi" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                        </td>
                                        <td>
                                          <select class="form-control select2" style="width: 100%;" class="form-control" name="i_rack" id="i_rack" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></select>
                                        </td>
                                        <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan detail</button></td>
                                        
                                    </tr>
                                    <tr>
                                      <th>Barcode</th>
                                      <th>Nama Barang</th>
                                      <th>Satuan</th>
                                      <th>Isi</th>
                                      <th>Qty Mutasi</th>
                                      <th>Rak Asal</th>
                                      <th>config</th>
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
                        <button type="button" onclick="reset3()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
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
        select_list_warehouse();
        select_list_warehouse2();
        select_list_rack();
        select_list_item();
        search_data_detail(0);
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>mutation/load_data/'
            },
            "columns": [
              {"name": "mutation_code"},
              {"name": "mutation_date"},
              {"name": "name1"},
              {"name": "name2"},
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
          url  : '<?php echo base_url();?>mutation/action_data/',
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
       $('input[name="i_date"]').val("");
      $("#i_warehouse option").remove();
      $("#i_warehouse2 option").remove();
    }
    function reset3(){
       $('input[name="i_id"]').val("");
       $('input[name="i_date"]').val("");
      $("#i_warehouse option").remove();
      $("#i_warehouse2 option").remove();
      search_data_detail(0);
      hapus();
    }


    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>mutation/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].mutation_id;
              document.getElementById("datepicker").value           = data.val[i].mutation_date;
              $("#i_warehouse").append('<option value="'+data.val[i].id1+'" selected>'+data.val[i].name1+'</option>');
              $("#i_warehouse2").append('<option value="'+data.val[i].id2+'" selected>'+data.val[i].name2+'</option>');
              
              search_data_detail(data.val[i].mutation_id);
              select_list_rack(data.val[i].id1)
            }
          }
        });

        $('[href="#form"]').tab('show');
    }
    
    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>mutation/delete_data',
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

      

    function save_detail(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>mutation/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset2();
              search_data_detail(id_new);
              
            } 
          }
        });
      }

      function reset2(){
         $('input[name="i_detail"]').val("");
         $('input[name="i_barcode"]').val("");
         $("#i_item option").remove();
         $('input[name="i_unit"]').val("");
         $('input[name="i_isi"]').val("");
         $('input[name="i_qty_mutasi"]').val("");
         $("#i_rack option").remove();
      }

      function search_data_detail(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Mutation/load_data_detail/'+id,
            },
            
          
            "columns": [
              {"name": "item_barcode"},
              {"name": "item_name"},
              {"name": "satuan"},
              {"name": "isi"},
              {"name": "muatation_detail_qty"},
              {"name": "rack_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
              
        });
        
    }

    function select_list_item(id) {
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

      function search_item(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Mutation/load_data_item/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_barcode").value             = data.val[i].item_barcode;
              document.getElementById("i_unit").value             = data.val[i].unit_name;
              document.getElementById("i_isi").value           = data.val[i].item_per_unit;
          }
        }
        });
  }

  function select_list_rack(id) {
        $('#i_rack').select2({
          placeholder: 'Pilih rack asal',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Mutation/load_data_select_rack/'+id,
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

      

      function select_list_warehouse2(id) {
        $('#i_warehouse2').select2({
          placeholder: 'Pilih tujuan gudang',
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

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Mutation/load_data_where_detail/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail"]').val(data.val[i].mutation_detail_id);
              $('input[name="i_barcode"]').val(data.val[i].item_barcode);
              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
              $('input[name="i_unit"]').val(data.val[i].unit_name);
              $('input[name="i_isi"]').val(data.val[i].item_per_unit);
              $('input[name="i_qty_mutasi"]').val(data.val[i].mutation_detail_qty);
              $("#i_rack").append('<option value="'+data.val[i].id1+'" selected>'+data.val[i].name1+'</option>');
            }
          }
        });
      }



      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Mutation/delete_data_detail',
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

    function hapus() {
            $.ajax({
                url: '<?php echo base_url();?>Mutation/hapus',
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                  }
                }
            });
    }
    function dlete() {
        var id = document.getElementById("i_id").value;
        var id2 = 0;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        
            $.ajax({
                url: '<?php echo base_url();?>Mutation/delete/'+id2,
                data: 'id='+id2,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_detail(id_new);
                  }
                }
            });
        
    }


</script>
</body>
</html>