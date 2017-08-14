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
                                <th>Periode Awal</th>
                                <th>Periode Akhir</th>
                                <th>Code</th>
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
                            <label>Id (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>

                          <div class="form-group">
                            <label>Gudang</label>
                            <select class="form-control select2"   name="i_warehouse1" id="i_warehouse1" style="width: 100%;" required="required" value=""></select>
                          </div>
                          
                        </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label>Periode Awal</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date_awal" placeholder="Periode Awal" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Periode Akhir</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker2" name="i_date_akhir" placeholder="Periode Akhir" value="" required="required">
                            </div>
                          </div>
                          
                        
                      </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2><input type="hidden" class="form-control" name="i_transales" id="i_transales" placeholder="Auto" readonly="">
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <tr>
                                        <td><input type="text" class="form-control" name="i_detail" id="i_detail" placeholder="Auto" value="" readonly=""></td>
                                        <td><select class="form-control select2"  name="i_sales" id="i_sales" style="width: 100%;" onkeydown="if (event.keyCode == 13) { save_detail(); }"></select></td>
                                        <td style="width:17%;"><input type="number" class="form-control" placeholder="biaya keliling"  name="i_arround" id="i_arround" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                        <td style="width:17%;"><input type="number" class="form-control" name="i_additional" id="i_additional" placeholder="biaya tambahan" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                        <td><select class="form-control select2" style="width: 100%;"  name="i_origin" id="i_origin" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></select></td>
                                        <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan detail</button></td>
                                        
                                    </tr>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>nama sales</th>
                                      <th>biaya keliling</th>
                                      <th>biaya tambahan</th>
                                      <th>Asal kas</th>
                                      <th>Config</th>
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
                      <h4>List Detail</h4><input type="text" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
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
        select_list_sales();/*
        select_list_kas();*/
        select_list_warehouse();
        select_list_warehouse1();
        search_data_detail(0);

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Transales/load_data/'
            },
            "columns": [
              {"name": "transales_early_periode"},
              {"name": "transales_periode_end"},
              {"name": "transales_code"},
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
          url  : '<?php echo base_url();?>Transales/action_data/',
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
      $('#i_warehouse1 option').remove();
    }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Transales/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].transales_id;
              $("#i_warehouse1").append('<option value="'+data.val[i].cash_id+'" selected>'+data.val[i].warehouse_name+'</option>');
              document.getElementById("datepicker").value           = data.val[i].transales_early_periode;
              document.getElementById("datepicker2").value           = data.val[i].transales_periode_end;
              get_transales_id();
              search_data_detail(data.val[i].transales_id);
          }
        }
      });
        $('[href="#form"]').tab('show');
    }

    function select_list_sales() {
        $('#i_sales').select2({
          placeholder: 'Pilih sales',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Sales/load_data_select_sales/',
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
        $('#i_origin').select2({
          placeholder: 'Pilih gudang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Cash/load_data_select_warehouse/',
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

      function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Transales/delete_data',
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

    function save_detail(){
        var id = document.getElementById("i_transales").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Transales/action_data_detail/',
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
         $("#i_sales option").remove("");
        $('input[name="i_arround"]').val("");
        $('input[name="i_additional"]').val("");
        $("#i_origin option").remove("");
      }

      function search_data_detail(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Transales/load_data_detail/'+id,
            },
            
              
            "columns": [
              {"name": "transales_detail_id"},
              {"name": "sales_name"},
              {"name": "transales_detail_cost_arround"},
              {"name": "transales_detail_cost_additional"},
              {"name": "warehouse_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
              
        });
    }

    function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Transales/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            
           var transales_id = $('input[name="i_id"]').val();
      //alert(purchase_id);
            $('input[name="i_transales"]').val(transales_id);
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail"]').val(data.val[i].transales_detail_id);
              $("#i_sales").append('<option value="'+data.val[i].sales_id+'" selected>'+data.val[i].sales_name+'</option>');
              $('input[name="i_arround"]').val(data.val[i].transales_detail_cost_arround);
              $('input[name="i_additional"]').val(data.val[i].transales_detail_cost_additional);
              $("#i_origin").append('<option value="'+data.val[i].cash_id+'" selected>'+data.val[i].warehouse_name+'</option>');

            }
          }
        });
      }



      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_transales").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Transales/delete_data_detail',
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

    function get_transales_id(){
      var transales_id = $('input[name="i_id"]').val();
      //alert(transales_id);
      $('input[name="i_transales"]').val(transales_id);
    }

    function select_list_warehouse1() {
        $('#i_warehouse1').select2({
          placeholder: 'Pilih Gudang',
          multiple: false,
          allowClear: true,
          ajax: {
           url: '<?php echo base_url();?>Cash/load_data_select_warehouse/',
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


</script>
</body>
</html>