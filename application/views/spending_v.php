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
                                <th>ID</th>
                                <th>Tanggal operasional</th>
                                <th>Biaya</th>
                                <th>Code</th>
                                <th>Asal Kas</th>
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
                            <label>tanggal operasional</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="tanggal operasional" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Asal Kas</label>
                            <select class="form-control select2" name="i_cash" id="i_cash" style="width: 100%;" value="" placeholder="Keperluan" required></select>
                          </div>
                        </div>
                      <div class="col-md-6">

                          <div class="form-group">
                            <label>Total Biaya</label>
                             <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                            <input type="text" readonly class="form-control" style="{ border = transparent;}" name="i_cost" id="i_cost" value="" placeholder="Biaya" required>
                          </div>

                        
                      </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2><input type="hidden" class="form-control" name="i_spending" id="i_spending" placeholder="Auto" readonly="">
<!--                               <div class="btn-group pull-right"><a href="#myModal" onclick="get_purchase_id()" class="btn-sm btn-success" data-toggle="modal" ><i class="glyphicon glyphicon-plus"> Detail</i></a></div>
 -->                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <tr>                                        
                                        <td><select class="form-control select2" style="width: 100%;" name="i_oprational" id="i_oprational"  value="" ></select></td>
                                        <td><select class="form-control select2" style="width: 100%;" name="i_warehouse" id="i_warehouse"  value="" ></select></td>
                                        <td>
                                          <input type="hidden" class="form-control" readonly="" name="i_detail" id="i_detail"  value="" >
                                          <input type="number"  class="form-control" placeholder="Biaya"  name="i_price" id="i_price" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                        </td>
                                        <td><input type="text" class="form-control" name="i_needs" id="i_needs" value="" placeholder="Keperluan" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                        <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan detail</button></td>
                                        
                                    </tr>
                                    </tr>
                                    <tr>
                                      <th>Oprational</th>
                                      <th>Cabang</th>
                                      <th>Biaya</th>
                                      <th>Keperluan</th>
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
        search_data_detail(0);
         //get_SUM_detail(0);
        select_list_coa_cash();
        select_list_warehouse();
        select_list_operational();

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Spending/load_data/'
            },
            "columns": [
              {"name": "spending_id"},
              {"name": "spending_date"},
              {"name": "spending_cost"},
              {"name": "spending_code"},
              {"name": "coa_id"},
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
          url  : '<?php echo base_url();?>Spending/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
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
              $('input[name="i_detail"]').val("");
              $("#i_oprational option").remove("");
              $("#i_warehouse option").remove("");
              $('input[name="i_price"]').val("");
              $('input[name="i_needs"]').val("");
      }

      function reset2(){
              $('input[name="i_id"]').val("");
              $('input[name="i_date"]').val("");
              $('input[name="i_cost"]').val("");
              $("#i_cash option").remove();
      }
      function reset3(){
              $('input[name="i_id"]').val("");
              $('input[name="i_date"]').val("");
              $('input[name="i_cost"]').val("");
              $("#i_cash option").remove();
              search_data_detail(0);
              hapus();
      }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Spending/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].spending_id;
              document.getElementById("datepicker").value           = data.val[i].spending_date;
              document.getElementById("i_cost").value           = data.val[i].spending_cost;
              $("#i_cash").append('<option value="'+data.val[i].coa_id+'" selected>'+data.val[i].coa_name+'</option>');
              get_spending_id();
              search_data_detail(data.val[i].spending_id);
          }
        }
      });
        $('[href="#form"]').tab('show');
    }

    function select_list_coa_cash() {
        $('#i_cash').select2({
          placeholder: 'Pilih Asal Kas',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Spending/load_data_select_coa_cash/',
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
          placeholder: 'Pilih Nama Cabang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Spending/load_data_select_warehouse/',
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
                url: '<?php echo base_url();?>Spending/delete_data',
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
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        var id1 =document.getElementById("i_id").value;
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Spending/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset1();
              search_data_detail(id_new);
              $('input[name="i_cost"]').val(data.total);
              
            } 
            
          }
        });
        
      }

      
      

      

      function search_data_detail(id) { 
        

        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Spending/load_data_detail/'+id,
            },
            
              
            "columns": [
              {"name": "oprational_id"},
              {"name": "warehouse_id"},
              {"name": "spending_detail_cost"},
              {"name": "spending_detail_needs"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

        
    }

    function get_SUM_detail(id){
      var cost = 
      document.getElementById("i_cost").value = <?php 
                  $sql = "SELECT SUM(spending_detail_cost) as total FROM spendings_details";
                  $row = $this->g_mod->select_manual($sql);
                  $value = $row['total'];
                  if ($value==NULL) {
                    echo $value=0;
                  }
                  else{
                    echo $row['total'];
                  }
                 //echo $value;
                  
              ?>*1;

              document.getElementById("i_cost").value = cost;
    }

    function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Spending/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            reset1();
            
           var spending_id = $('input[name="i_id"]').val();
      //alert(purchase_id);
            $('input[name="i_spending"]').val(spending_id);
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail"]').val(data.val[i].spending_detail_id);
              $("#i_oprational").append('<option value="'+data.val[i].oprational_id+'" selected>'+data.val[i].oprational_name+'</option>');
              $("#i_warehouse").append('<option value="'+data.val[i].warehouse_id+'" selected>'+data.val[i].warehouse_name+'</option>');
              $('input[name="i_price"]').val(data.val[i].spending_detail_cost);
              $('input[name="i_needs"]').val(data.val[i].spending_detail_needs);
              $('input[name="i_cost"]').val(data.total);

            }
          }
        });
      }

      function select_list_operational() {
        $('#i_oprational').select2({
          placeholder: 'Pilih nama oprational',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>oprational/load_data_select_oprational/',
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



      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_spending").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        var id_spending = document.getElementById("i_id").value;

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Spending/delete_data_detail',
                data: {id_spending:id_spending,id:id_detail},
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_detail(id_new);
                    $('input[name="i_cost"]').val(data.total);
                  }
                }
            });
        }
        
    }

    function hapus() {
            $.ajax({
                url: '<?php echo base_url();?>Spending/hapus',
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                  }
                }
            });
        
    }

    function get_spending_id(){
      var spending_id = $('input[name="i_id"]').val();
      //alert(spending_id);
      $('input[name="i_spending"]').val(spending_id);
    }

    function spending_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Spending/load_data_spending_detail/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_COA"]').val(data.val[i].oprational_coa);

            }
          }
        });
      }

      function total(id){
        var biaya = document.getElementById("i_price").value;
        var tBiaya = document.getElementById("i_cost").value;
    document.getElementById('i_cost').value = (biaya*1)+(tBiaya*1);
    /*var biaya = $('input[name"i_price"]').val();

    var jumlah_harga = valgoritma + vjavascript + vphp;*/

    }
</script>
</body>
</html>