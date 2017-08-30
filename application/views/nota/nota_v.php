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
        <li><a href="#list_retail" data-toggle="tab">List Detail Retail</a></li>
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
                                <th>Kode Nota</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Sales</th>
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
                            <label>Nama Customer</label>
                            <select class="form-control select2" name="i_customer" id="i_customer" style="width: 50%;" onchange="get_customer(this.value)">
                            </select>
                            <a href="#customerModal" class="btn btn-info btn-xs" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>Customer</a>
                            <input type="hidden" class="form-control i_id" name="i_id" id="i_id" value="" >
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="i_addres" id="i_addres" placeholder="Auto"  value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" class="form-control" name="i_telp" id="i_telp" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Nama Sales</label>
                            <select class="form-control select2" name="i_sales" id="i_sales" style="width: 100%;">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Scan Member Card</label>
                            <input type="text" class="form-control" name="i_scan_card" id="i_scan_card" placeholder="Scan Member Card" value="" >
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Nota</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Nota" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Pilih Pembayaran :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(1)" name="i_type" id="inlineRadio1" value="1"> Cash
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(2)" name="i_type" id="inlineRadio2" value="2"> COD
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(3)" name="i_type" id="inlineRadio3" value="3"> Kredit/Hutang
                            </label>
                          </div>
                          <div class="form-group">
                            <label>Jenis Pembayaran</label>
                            <select class="form-control select2" name="i_coa" id="i_coa" style="width: 100%;" 
                            >
                            </select>
                          </div>

                          <div id="credit_card" style="display: none;">
                            <div class="form-group">
                              <label>Nomor Kartu</label>
                              <input type="text" class="form-control" name="i_card" id="i_card" placeholder="Masukkan Nomor Kartu"  value="">
                            </div>
                            <div class="form-group">
                              <label>Jatuh Tempo</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="glyphicon glyphicon-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker2" name="i_date_tempo" placeholder="Tanggal Nota" value="">
                              </div>
                            </div>

                          </div>
                          <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Keterangan" name="i_desc" id="i_desc"></textarea>
                          </div>
                          <div class="form-group">
                            <label>No REF Nota</label>
                            <select class="form-control select2" name="i_nota_id" id="i_nota_id" onchange="get_reference(this.value)" style="width: 100%;" 
                            >
                            </select>
                          </div>
                          
                        </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Penjualan</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Barcode</th>
                                      <th>Nama Barang</th>
                                      <th>Satuan</th>
                                      <th>Isi</th>
                                      <th>Harga</th>
                                      <th>Jumlah</th>
                                      <th>Retail</th>
                                      <th>D Promo</th>
                                      <th>Total Harga</th>
                                      <th>Ambil Sndri</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>                                
                              </div>
                              <div class="form-group">
                              
                                <input type="text" style="width: 20%;" class="form-control pull-right" name="i_barcode_scan" placeholder="Scan Barcode Retail" onkeypress="if (event.keyCode == 13) { save_item(2); }">
                              
                                <select class="form-control select2" name="i_item" id="i_item" style="width: 20%;" onchange="save_item(1)">
                                </select>
                              
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

        <div class="tab-pane" id="list_retail">
          <? include('nota_r.php');?>
        </div>

        <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Gudang</h4><input type="text" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                            
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Gudang</th>
                                      <th>Qty Stok</th>
                                      <th>OC</th>
                                      <th>Kirim</th>
                                      <th>Ambil Skrg</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                  </div>
                  <div class="modal-footer">
                      <a href="#" class="btn btn-warning" data-dismiss="modal" onclick="reset_detail()">Selesai</a>
                      <!--<a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Save changes</a>-->
                  </div>
              </div>
          </form>
          </div>
      </div>

      <div style="padding-top: 50px;" class="modal fade" id="customerModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="formcustomer" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>Form Input Customer</h4>
                  </div>
                  <div class="modal-body">
                          <div class="box-content">
                  <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nama Customer</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Customer" required="required" value="">
                            <input type="hidden" class="form-control" name="i_id" id="i_id1" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Alamat Customer</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat" required="required" name="i_addres" id="i_addres"></textarea>
                          </div>
                          <div class="form-group">
                            <label>Nama Toko</label>
                            <input type="text" class="form-control" name="i_store" id="i_store" placeholder="Masukkan Nama Toko" value="" required="required">
                          </div>
                          <div class="form-group">
                            <label>No Telepon</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Telepon" required="required" name="i_telp" id="i_telp" value="">
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>No NPWP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No NPWP" name="i_no_npwp" id="i_no_npwp" value="">
                          </div>
                          <div class="form-group">
                            <label>Nama NPWP</label>
                            <input type="text" class="form-control" placeholder="Masukkan Nama NPWP" name="i_name_npwp" id="i_name_npwp" value="">
                          </div>
                          
                          <div class="form-group">
                            <label>Kategori Harga</label>
                            <select class="form-control select2" name="i_category" id="i_category" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Wilayah</label>
                            <select class="form-control select2" name="i_city" id="i_city" style="width: 100%;" >
                            </select>
                          </div>
                          
                          
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <a href="#" class="btn btn-primary" data-dismiss="modal" onclick="save_customer()">Simpan</a>
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
        select_list_item();
        select_list_customer();
        select_list_sales();
        select_list_nota();
        select_list_item_price();
        select_list_city();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
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
        url: '<?=site_url('nota/read_coa')?>',
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
              url: '<?php echo base_url();?>nota/load_data/'
            },
            "columns": [
              {"name": "nota_code"},
              {"name": "nota_date"},
              {"name": "customer_name"},
              {"name": "sales_name"},
              {"name": "nota_status"},
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
              url: '<?php echo base_url();?>nota/load_data_detail/'+id
            },
            "columns": [
              {"name": "item_barcode"},
              {"name": "item_name"},
              {"name": "unit_name"},
              {"name": "nota_detail_qty"},
              {"name": "nota_detail_retail"},
              {"name": "nota_detail_price"},
              {"name": "jml","orderable": false,"searchable": false},
              {"name": "nota_detail_promo"},
              {"name": "harga","orderable": false,"searchable": false},
              {"name": "ambil","orderable": false,"searchable": false},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_stock(id,detail_id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>nota/load_data_stock/'+id+'/'+detail_id
            },
            "columns": [
              {"name": "warehouse_name"},
              {"name": "warehouse_name"},
              {"name": "warehouse_name"},
              {"name": "warehouse_name"},
              {"name": "warehouse_name"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

        $('input[name="i_detail_id"]').val(detail_id);
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
          url  : '<?php echo base_url();?>nota/action_data/',
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
                url: '<?php echo base_url();?>nota/delete_data',
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
          url  : '<?php echo base_url();?>nota/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].nota_id;
              document.getElementById("datepicker").value           = data.val[i].nota_date;
              document.getElementById("datepicker2").value         = data.val[i].nota_telp;
              document.getElementById("i_card").value      = data.val[i].nota_credit_card;
              document.getElementById("i_desc").value         = data.val[i].nota_desc;
              document.getElementById("i_addres").value      = data.val[i].customer_address;
              document.getElementById("i_telp").value         = data.val[i].customer_telp;
              document.getElementById("i_scan_card").value         = data.val[i].nota_member_card;

              $("#i_customer").append('<option value="'+data.val[i].customer_id+'" selected>'+data.val[i].customer_name+'</option>');
              $("#i_sales").append('<option value="'+data.val[i].employee_id+'" selected>'+data.val[i].employee_name+'</option>');
              $("#i_coa").append('<option value="'+data.val[i].coa_detail_id+'" selected>'+data.val[i].coa_name+'</option>');
              $("#i_nota_id").append('<option value="'+data.val[i].nota_reference+'" selected>'+data.val[i].code_referance+'</option>');

              if (data.val[i].nota_type == '1') {
                document.getElementById("inlineRadio1").checked = true;
              } else if (data.val[i].nota_type == '2') {
                document.getElementById("inlineRadio2").checked = true;
              }else if (data.val[i].nota_type == '3') {
                document.getElementById("inlineRadio3").checked = true;
                document.getElementById('credit_card').style.display = 'block';
              }

              search_data_detail(data.val[i].nota_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function reset2(){
      document.getElementById('credit_card').style.display = 'none';
      $('#i_customer option').remove();
      $('#i_sales option').remove();
      $('#i_coa option').remove();
      $('#i_nota_id option').remove();
      search_data_detail(0);
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

      function select_list_customer() {
        $('#i_customer').select2({
          placeholder: 'Pilih Customer',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Customer/load_data_select_customer/',
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

      function select_list_sales() {
        $('#i_sales').select2({
          placeholder: 'Pilih Sales',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Employee/load_data_select_employee/2',
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
        $('#i_nota_id').select2({
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

      function save_item(type){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>nota/action_data_detail/'+type,
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
       $('#i_item option').remove();
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
                url: '<?php echo base_url();?>nota/delete_data_detail',
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

    function get_customer(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>customer/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_addres").value         = data.val[i].customer_address;
              document.getElementById("i_telp").value           = data.val[i].customer_telp;             
            }
          }
        });
    }

    function get_qty_order(value,warehouse_id,item_id,type){
      //alert(warehouse_id);
      var detail_id = $('input[name="i_detail_id"]').val();
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>nota/action_data_order/',
          data : {value:value,warehouse_id:warehouse_id,item_id:item_id,detail_id:detail_id,type:type},
          dataType : "json",
          success:function(data){
            
          }
        });

    }

    function reset_detail(){
      var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        search_data_detail(id_new);
    }

    function get_detail_update(value,id,type){
      //alert(warehouse_id);
      var id_nota = document.getElementById("i_id").value;
        if (id_nota) {
          var id_new = id_nota;
        }else{
          var id_new = 0;
        }
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>nota/get_detail_update/',
          data : {value:value,id:id,type:type},
          dataType : "json",
          success:function(data){
            search_data_detail(id_new);
          }
        });

    }

    function get_reference(id){
      //alert(warehouse_id);
      var id_nota = document.getElementById("i_id").value;
        if (id_nota) {
          var id_new = id_nota;
        }else{
          var id_new = 0;
        }
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>nota/action_data_reference/',
          data : {id:id,id_new:id_new},
          dataType : "json",
          success:function(data){
            search_data_detail(id_new);
          }
        });

    }

    function get_data_retail(id){
        $("#list_retail").load("<?= site_url()?>nota/load_view_retail/"+id);
        $('[href="#list_retail"]').tab('show');
      }

    function save_retail(){
        //alert("test")
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>nota/action_data_retail/',
          data : $( "#formretail" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
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

    function select_list_item_price() {
        $('#i_category').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_item_price/',
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

      function select_list_city() {
        $('#i_city').select2({
          placeholder: 'Pilih Wilayah',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>City/load_data_select_city/',
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

      function save_customer(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Nota/action_data_customer/',
          data : $( "#formcustomer" ).serialize(),
          dataType : "json",
          success:function(data){
            
          }
        });
    }

    function print_pdf(id){
      window.open('<?php echo base_url();?>Nota/print_nota_pdf?id='+id);
    }
</script>
</body>
</html>