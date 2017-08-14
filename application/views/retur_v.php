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
                                <th>code Pembelian</th>
                                <th>tanggal return</th>
                                <th>Code return</th>
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
                            <label>Id Return (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>code Pembelian</label>
                            <select class="form-control select2" onchange="select_list_item(this.value)" name="i_code" id="i_code" style="width: 100%;" required="required" value=""></select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>tanggal Return</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal return" value="" required="required">
                            </div>
                          </div>
                        </div>
                        
                         <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2><input type="hidden" class="form-control" name="i_retur" id="i_retur" placeholder="Auto" readonly="">
<!--                               <div class="btn-group pull-right"><a href="#myModal" onclick="get_purchase_id()" class="btn-sm btn-success" data-toggle="modal" ><i class="glyphicon glyphicon-plus"> Detail</i></a></div>
 -->                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                        <td><input type="text" class="form-control" name="i_detail" id="i_detail" placeholder="Auto" value="" readonly=""></td>
                                        <td><select class="form-control select2" style="width: 100%;" onchange="retur_detail(this.value)" name="i_item" id="i_item" style="width: 85%;" onkeydown="if (event.keyCode == 13) { save_detail(); }"></select></td>
                                        <td><input type="text" class="form-control" name="i_qty" id="i_qty" placeholder="jumlah return" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                         <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan detail</button></td>
                                        
                                    </tr>
                                    <tr>
                                      <th>id</th>
                                      <th>Nama barang</th>
                                      <th>Qty</th>
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
                
                    </form>

            </div>
        </div>

        

    </div>
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        select_list_code();
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
              url: '<?php echo base_url();?>Retur/load_data/'
            },
            "columns": [
              {"name": "purchase_id"},
              {"name": "retur_supplier_date"},
              {"name": "retur_supplier_code"},
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

      function action_data(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Retur/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset1()
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
    
    

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Retur/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].retur_supplier_id;
              $("#i_code").append('<option value="'+data.val[i].purchase_id+'" selected>'+data.val[i].purchase_code+'</option>');
              document.getElementById("datepicker").value           = data.val[i].retur_supplier_date;

              search_data_detail(data.val[i].retur_supplier_id);
        get_retur_supplier_id();
              /* $("#i_item").append('<option value="'+data.val[i].item_clas_name+'" selected></option>');*/
            }
          }
        });
        $('[href="#form"]').tab('show');
    }
    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Retur/delete_data',
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
        var id = document.getElementById("i_retur").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Retur/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset2()
              search_data_detail(id_new);
            } 
          }
        });
      }

      function reset1(){
        $('input[name="i_id"]').val("");
        $("#i_code option").remove("");
        $('input[name="i_date"]').val("");
      }
      function reset2(){
        $('input[name="i_detail"]').val("");
        $("#i_item option").remove("");
        $('input[name="i_qty"]').val("");
      }

      function search_data_detail(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Retur/load_data_detail/'+id,
            },
            
              
            "columns": [
              {"name": "retur_supplier_detail_id"},
              {"name": "item_name"},
              {"name": "retur_supplier_detail_qty"},
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
          url  : '<?php echo base_url();?>Retur/load_data_where_detail/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            
           var retur_supplier_id = $('input[name="i_id"]').val();
      //alert(purchase_id);
            $('input[name="i_retur"]').val(retur_supplier_id);
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail"]').val(data.val[i].retur_supplier_detail_id);
              $("#i_item").append('<option value="'+data.val[i].purchase_detail_id+'" selected>'+data.val[i].item_name+'</option>');
              $('input[name="i_qty"]').val(data.val[i].retur_supplier_detail_qty);

            }
          }
        });
      }



      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_retur").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Retur/delete_data_detail',
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

    function get_retur_supplier_id(){
      var retur_supplier_id = $('input[name="i_id"]').val();
      //alert(retur_supplier_id);
      $('input[name="i_retur"]').val(retur_supplier_id);
    }

    function select_list_item() {
        $('#i_item').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Purchase/load_data_select_detail/',
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

      function retur_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Retur/load_data_retur_detail/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_qty"]').val(data.val[i].purchase_detail_qty);

            }
          }
        });
      }
</script>
</body>
</html>