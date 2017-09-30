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
                                <th>Code Mutasi</th>
                                <th>Tanggal Terima</th>
                                <th>Asal Gudang</th>
                                <th>Tujuan Gudang</th>
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
                            <label>Code Mutasi</label>
                            <select class="form-control select2"  onchange="save_detail(this.value),get_warehouse(this.value)" name="i_code" id="i_code" style="width: 100%;" required="required" value=""></select>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Terima</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal terima" value="" required="required">
                            </div>
                          </div>
                        </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label>Gudang Asal</label>
                            <input readonly="" type="text" class="form-control" name="i_warehouse" id="i_warehouse" placeholder="Gudang Asal" style="width: 100%;" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Gudang Tujuan</label>
                            <input readonly="" type="text" class="form-control" name="i_warehouse2" id="i_warehouse2" placeholder="Gudang Tujuan" style="width: 100%;" required="required" value="">
                          </div>
                        
                      </div>
                        
                    <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Barcode</th>
                                      <th>Nama Barang</th>
                                      <th>Qty Mutasi</th>
                                      <th>Pilih Rak</th>
                                      <th>Qty diterima</th>
                                      <th>Qty sisa</th>
                                      <th>Keterangan</th>
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
                        <button type="button" onclick="reset(),reset6()" class="btn btn-warning">Batal</button>
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
                      <h4>List Detail Penerimaan</h4>
                      <input type="hidden" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
                      <input type="hidden" class="form-control" name="mutation_detail_qty" id="mutation_detail_qty" placeholder="Auto" readonly="">
                      <input type="hidden" class="form-control" name="i_item_detail_id" id="i_item_detail_id" placeholder="Auto" readonly="">
                      <input type="text" class="form-control" name="mutation_receipt_qty" id="mutation_receipt_qty" placeholder="Auto" readonly="">
                  </div>
                      
                          <div class="box-inner">
                          <div class="row">
                          
                            <div class="col-md-12">
                              <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table4" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td width="40%">
                                        <select style="width: 100%" class="form-control select2" name="i_rack" id="i_rack"> </select>
                                        <input type="hidden" class="form-control" name="i_rack_id" id="i_rack_id" placeholder="Auto" readonly="">
                                      </td>
                                        <td><input type="number" onchange="cek_sisa(this.value)" class="form-control" name="i_qty_recept" id="i_qty_recept" placeholder="Jmlah Qty Yang Diterima"></td>

                                      <td  width="10%"><button type="button" <?php if(isset($c)) echo $c;?> onclick="save_rack()" class="btn btn-primary">Simpan Rak</button></td>
                                    </tr>
                                    <tr>
                                      <th>Tujuan Rak</th>
                                      <th>Qty Terima</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <a onclick="reload_detail()" href="#" class="btn btn-warning" data-dismiss="modal">Selesai</a>
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
        select_list_rack();

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Mutation_recept/load_data/'
            },
            "columns": [
              {"name": "mutation_id"},
              {"name": "mutation_recept_date"},
              {"name": "name1"},
              {"name": "name2"},
              {"name": "mutation_recept_code"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

    }

    function search_data_detail(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Mutation_recept/load_data_detail/'+id,
            },
            
          
            "columns": [
              {"name": "item_barcode"},
              {"name": "item_name"},
              {"name": "mutation_detail_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"},
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
              
        });
    }

    function get_mutation_detail(id,qty,item_id){
      $('input[name="i_detail_id"]').val(id);
      $('input[name="mutation_detail_qty"]').val(qty);
      $('input[name="i_item_detail_id"]').val(item_id);

      search_data_rack(id);
    }

    function search_data_rack(id){
      $('#table4').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Mutation_recept/load_data_rack/'+id,
            },
          
            "columns": [
              {"name": "rack_name"},
              {"name": "mutation_rack_recept_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
              ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
              
        });

      get_total(id);
    }

    $("#formall").submit(function(event){
        if ($("#formall").valid()==true) {
          action_data();
        }
        return false;
      });


    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Mutation_recept/delete_data',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset();
                    search_data();
                    search_data_detail(0);

                    document.getElementById('create').style.display = 'none';
                    document.getElementById('update').style.display = 'none';
                    document.getElementById('delete').style.display = 'block';
                  }
                }
            });
        }
        
    }

    function edit_data(id) {
      $("#detail").hide();
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Mutation_recept/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].mutation_recept_id;
              document.getElementById("datepicker").value           = data.val[i].mutation_recept_date;
              document.getElementById("i_warehouse").value           = data.val[i].name1;
              document.getElementById("i_warehouse2").value           = data.val[i].name2;

              $("#i_code").append('<option value="'+data.val[i].mutation_id+'" selected>'+data.val[i].mutation_code+'</option>');
              search_data_detail(data.val[i].mutation_recept_id);
              select_list_rack(data.val[i].warehouse_id2);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    
      function get_warehouse(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Mutation_recept/load_data_where_mutation/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_warehouse").value             = data.val[i].name1;
              document.getElementById("i_warehouse2").value             = data.val[i].name2;
              select_list_rack(data.val[i].warehouse_id2);
          }
        }
        });
  }

      function action_data(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Mutation_recept/action_data/',
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
      $('#input[name="i_warehouse2"]').val("");
      $('#input[name="i_warehouse"]').val("");
      $('input[name="i_date"]').val("");
      $('input[name="i_id"]').val("");
      
    }
    function reset6(){
      $('input[name="i_id"]').val("");
      $("#i_code option").remove();
      $('#input[name="i_warehouse2"]').val("");
      $('#input[name="i_warehouse"]').val("");
      $('input[name="i_date"]').val("");
      search_data_detail(0);
    }

    function select_list_rack(id) {
        $('#i_rack').select2({
          placeholder: 'Pilih rack Tujuan',
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

      function save_detail(mutasi_id){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
          alert("Kode mutasi tidak boleh di edit!");
        }else{
          var id_new = 0;

          $.ajax({
            type : "POST",
            url  : '<?php echo base_url();?>mutation_recept/action_data_detail/',
            data : {mutasi_id:mutasi_id,id:id},//$( "#formall" ).serialize(),
            dataType : "json",
            success:function(data){
              if(data.status=='200'){
                search_data_detail(id_new);
              } 
            }
          });
        }
        //alert(id);
        
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


    function save_rack(){

      detail_id = document.getElementById("i_detail_id").value;

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Mutation_recept/action_data_rack/',
          data : $( "#form_modal" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              search_data_rack(detail_id);
              reset2();
            } 
          }
        });
      }

      function edit_data_rack(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Mutation_recept/load_data_where_rack/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $("#i_rack").append('<option value="'+data.val[i].rack_id+'" selected>'+data.val[i].rack_name+'</option>');
              $('input[name="i_qty_recept"]').val(data.val[i].mutation_rack_recept_qty);

            }
          }
        });
      }

      function delete_data_rack(id_detail) {

        var id = document.getElementById("i_detail_id").value;

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Mutation_recept/delete_data_rack',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_rack(id);
                  }
                }
            });
        }
        
    }
    function reset2(){
      $('input[name="i_rack_id"]').val("");
      $('input[name="i_qty_recept"]').val("");
      $('#i_rack option').remove();
    }

    function reload_detail(){
      var id2 = document.getElementById("i_id").value;
        if (id2) {
          var id_new = id2;
        }else{
          var id_new = 0;
        }

        search_data_detail(id_new);
    }
    
    

    function select_list_code() {
        $('#i_code').select2({
          placeholder: 'Pilih Code Mutasi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Mutation_recept/load_data_select_code/',
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

      function get_total(id){
        $.ajax({
            type : "POST",
            url  : '<?php echo base_url();?>mutation_recept/get_total/',
            data : {id:id},//$( "#formall" ).serialize(),
            dataType : "json",
            success:function(data){
              $('input[name="mutation_receipt_qty"]').val(data.total);
            }
          });
      }

      function cek_sisa(value){
        var qty_mutasi = $('input[name="mutation_detail_qty"]').val();
        var qty_receipt = $('input[name="mutation_receipt_qty"]').val();

        var total_receipt = qty_receipt + value;

        if (total_receipt - qty_mutasi > 0) {
          alert("Tidak boleh melebihi batas mutasi!");
          $('input[name="i_qty_recept"]').val(0);
        }
      }

      function save_desc(value,id){
        $.ajax({
            type : "POST",
            url  : '<?php echo base_url();?>mutation_recept/save_desc/',
            data : {value:value,id:id},//$( "#formall" ).serialize(),
            dataType : "json",
            success:function(data){
              
            }
          });
      }

</script>
</body>
</html>
    