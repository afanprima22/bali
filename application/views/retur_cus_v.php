<style type="text/css">
  .money{
    text-align: right;
  }
  .i_id{
    width: 20%;
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
                                <th>Kode Retur</th>
                                <th>Nomor Nota</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
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
                            <label>Kode Nota</label>
                            <select class="form-control select2" name="i_nota" id="i_nota" style="width: 100%;" onchange="select_list_item(this.value),get_customer(this.value)">
                            </select>
                            <input type="hidden" class="form-control i_id" name="i_id" id="i_id" value="" >
                          </div>
                          <div class="form-group">
                            <label>Nama Customer</label>
                            <input type="text" class="form-control" name="i_customer" id="i_customer" placeholder="Auto" value="" readonly="">
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Retur</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Retur" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Keterangan" name="i_desc" id="i_desc"></textarea>
                          </div>
                          
                        </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td>
                                        <select class="form-control select2" name="i_nota_detail" id="i_nota_detail" style="width: 100%;" onchange="get_qty_order(this.value)"></select>
                                        <input type="hidden" class="form-control i_id" name="i_detail_id" id="i_detail_id" value="" >
                                      </td>
                                      <td><input type="text" class="form-control" name="i_order" id="i_order" placeholder="Auto" value="" readonly=""></td>
                                      <td><input type="text" class="form-control" name="i_qty_retur" id="i_qty_retur" placeholder="Jumlah Retur" value=""></td>
                                      <td><input type="text" class="form-control" name="i_detail_desc" id="i_detail_desc" placeholder="Keterangan" value=""></td>
                                      <td width="10%">
                                        <button id="simpan_detail" type="button" onclick="save_detail()" class="btn btn-primary">Simpan Detail</button>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th>Nama Barang</th>
                                      <th>Qty Order</th>
                                      <th>Qty Return</th>
                                      <th>Keterangan</th>
                                      <th>Status</th>
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
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button id="simpan" type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
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
      var date = new Date();
        search_data();
        search_data_detail(0);
        select_list_item(0);
        select_list_nota();
        /*$.fn.modal.Constructor.prototype.enforceFocus = function() {};*/
        document.getElementById("datepicker").value  = (date.getMonth()+ 1) + '/' + date.getDate() + '/' +  date.getFullYear();
    });

    function type_payment(id){

      if (id == 3) {
        document.getElementById('credit_card').style.display = 'block';
      }else{
        document.getElementById('credit_card').style.display = 'none';
      }

      $.ajax({
        type: 'POST',
        url: '<?=site_url('retur_cu/read_coa')?>',
        data: {id:id},
        dataType: 'json',
        success: function(data){
          $('#i_coa').html(data);
        } 
      });

      
    }

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>retur_cus/load_data/'
            },
            "columns": [
              {"name": "retur_cus_code"},
              {"name": "nota_code"},
              {"name": "retur_cus_date"},
              {"name": "customer_name"},
              {"name": "sales_name"},
              {"name": "retur_cus_status"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>retur_cus/load_data_detail/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "order","orderable": false},
              {"name": "retur_cus_detail_qty"},
              {"name": "retur_cus_detail_desc"},
              {"name": "retur_cus_detail_status"},
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
          //alert("test");
        }
        return false;
      });

    function action_data(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>retur_cus/action_data/',
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
                url: '<?php echo base_url();?>retur_cus/delete_data',
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
          url  : '<?php echo base_url();?>retur_cus/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].retur_cus_id;
              document.getElementById("datepicker").value           = data.val[i].retur_cus_date;
              document.getElementById("i_customer").value      = data.val[i].customer_name;
              document.getElementById("i_desc").value         = data.val[i].retur_cus_desc;
              $("#i_nota").append('<option value="'+data.val[i].nota_id+'" selected>'+data.val[i].nota_code+'</option>');

              search_data_detail(data.val[i].retur_cus_id);

              if (data.val[i].retur_cus_status == 1) {
                document.getElementById('simpan').style.display = 'none';
                document.getElementById('simpan_detail').style.display = 'none';
              }else{
                document.getElementById('simpan').style.display = 'block';
                document.getElementById('simpan_detail').style.display = 'block';
              }
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function reset2(){
      $('#i_nota option').remove();
      search_data_detail(0);
      document.getElementById('simpan').style.display = 'block';
      document.getElementById('simpan_detail').style.display = 'block';
    }

      function select_list_item(id) {
        $('#i_nota_detail').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Nota/load_data_select_nota_detail/'+id,
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

      function select_list_nota() {
        $('#i_nota').select2({
          placeholder: 'Pilih Nota',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Nota/load_data_select_nota/',
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
          url  : '<?php echo base_url();?>retur_cus/action_data_detail/',
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
       $('#i_nota_detail option').remove();
       document.getElementById("i_detail_id").value      = '';
       document.getElementById("i_qty_retur").value      = '';
       document.getElementById("i_order").value      = '';
       document.getElementById("i_detail_desc").value      = '';
      }

      function edit_data_detail(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>retur_cus/load_data_detail_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_detail_id").value        = data.val[i].retur_cus_detail_id;
              document.getElementById("i_qty_retur").value        = data.val[i].retur_cus_detail_qty;
              document.getElementById("i_order").value            = data.val[i].order;
              document.getElementById("i_detail_desc").value      = data.val[i].retur_cus_detail_desc;

              $("#i_nota_detail").append('<option value="'+data.val[i].nota_detail_id+'" selected>'+data.val[i].item_name+'</option>');
            }
          }
        });

        $('[href="#form"]').tab('show');
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
                url: '<?php echo base_url();?>retur_cus/delete_data_detail',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset3();
                    search_data_detail(id_new);
                  }
                }
            });
        }
        
    }

    function get_qty_order(id){
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>retur_cus/get_qty_order/',
          data : {id:id},
          dataType : "json",
          success:function(data){
            document.getElementById("i_order").value      = data;
          }
        });
    }

    function get_customer(id){
      //alert(id)
      $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>nota/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_customer").value      = data.val[i].customer_name;
            }
          }
        });
    }

    function receipt_data_detail(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        /*var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){*/
            $.ajax({
                url: '<?php echo base_url();?>retur_cus/update_data_detail_status',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset3();
                    search_data_detail(id_new);
                  }
                }
            });
        //}
        
    }

    function print_pdf(id){
      window.open('<?php echo base_url();?>Retur_cus/print_retur_cus_pdf?id='+id);
    }

</script>
</body>
</html>