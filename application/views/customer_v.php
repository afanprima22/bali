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
                                <th>Nama</th>
                                <th>No Telepon</th>
                                <th>Nama Toko</th>
                                <th>Usaha</th>
                                <th>Wilayah</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                
            </div>

        </div>
        <div class="tab-pane" id="form">
            <div class="box-inner">

                <form id="formall" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="box-content">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Id Customer (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Nama Customer</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Customer" required="required" value="">
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
                          <div class="form-group">
                            <label>No HP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Handphone" name="i_hp" id="i_hp" value="">
                          </div>
                          <div class="form-group">
                            <label>Email</label>
                            <input type="mail" class="form-control" placeholder="Masukkan Mail" name="i_mail" id="i_mail" value="">
                          </div>
                          <div class="form-group">
                            <label>Limit Kredit</label>
                            <input type="number" class="form-control" placeholder="Masukkan Limit Kredit" required="required" name="i_kredit" id="i_kredit" value="">
                          </div>
                          <!--<div class="form-group">
                            <label>Limit Member Card</label>
                            <input type="number" class="form-control" placeholder="Masukkan Limit Member Card" required="required" name="i_card" id="i_card" value="">
                          </div>-->
                          <div class="form-group">
                            <label>Limit Jatuh Tempo</label>
                            <input type="number" class="form-control" placeholder="Masukkan Limit Jatuh Tempo"  name="i_tempo" id="i_tempo" value="">
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
                            <label>Group Customer</label>
                          </div>
                          <div class="form-group">
                            <select class="form-control select2" name="i_group" id="i_group" style="width: 80%;" >
                            </select>
                            <a href="#mygroup" class="btn btn-info btn-xs" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i><strong>Group</strong></a>
                          </div>
                          <div class="form-group">
                            <label>Badan Usaha</label>
                          </div>
                          <div class="form-group">
                            <select class="form-control select2" name="i_busines" id="i_busines" style="width: 80%;" required="required">
                            </select>
                            <a href="#mybadan" class="btn btn-info btn-xs" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i><strong>Badan Usaha</strong></a>
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
                          <div class="form-group">
                            <label for="exampleInputFile">Foto Toko</label>
                              <br />
                              <img id="img_customer" src="" style="width:100%;"/>
                              <br />
                            <input type="file" name="i_img" id="i_img" >
                            
                          </div>
                          
                        </div>
                        
                      </div>
                      
                      <div id="detail" style="display: none;">
                      <hr>
                      <div class="form-group">
                        <label>Nomor Member Card</label>
                        <input type="text" class="form-control" placeholder="Masukkan Nomor Member Card" name="i_member_card_no" id="i_member_card_no" value="">
                      </div>
                      <div class="box-inner">
                        <div class="box-header well" data-original-title="">
                          <h2>List Detail Member</h2>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                            <div class="box-inner">
                              <div class="box-content">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Nama Customer</th>
                                      <th>Bonus %</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <form id="formclass" role="form" action="" method="post" enctype="multipart/form-data">
                              <div class="box-content">
                                <div class="form-group">
                                  <label>Id Detail Member (Auto)</label>
                                  <input type="text" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" value="" readonly="">
                                </div>
                                <div class="form-group">
                                  <label>Nama Customer Member</label>
                                  <select class="form-control select2" name="i_customer" id="i_customer" style="width: 100%;">
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label>Bonus %</label>
                                  <input type="text" class="form-control" name="i_bonus" id="i_bonus" placeholder="Masukkan Bonus %" value="">
                                </div>
                                <div class="box-footer text-right">
                                  <button type="button" onclick="reset3()" class="btn btn-danger">Batal Detail</button>
                                  <button type="button" onclick="action_data_detail()" class="btn btn-info" <?php if(isset($c)) echo $c;?>>Simpan Detail</button>
                                </div>
                              </div>
                            </form>
                            
                          </div>
                        </div>
                      </div>
                      </div>

                      <div class="form-group">

                      </div>

                      <div class="box-footer text-right">
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    <div style="padding-top: 50px;" class="modal fade" id="mygroup" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="formgroup" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Data Group Customer</h4>
                  </div>
                  <div class="modal-body">
                      <!--<div class="box-inner">
                            
                            <div class="box-content">-->
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_group_id" id="i_group_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <input type="text" class="form-control" name="i_group_name" id="i_group_name" placeholder="Masukkan Nama Group" onkeydown="if (event.keyCode == 13) { save_group(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_group()" class="btn btn-primary">Simpan satuan</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Nama Group</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            <!--</div>
                          </div>-->
                  </div>
                  <div class="modal-footer">
                      <a href="#" class="btn btn-warning" data-dismiss="modal">Selesai</a>
                      <!--<a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Save changes</a>-->
                  </div>
              </div>
          </form>
          </div>
      </div>

      <div style="padding-top: 50px;" class="modal fade" id="mybadan" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="formbadan" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Data Badan Usaha</h4>
                  </div>
                  <div class="modal-body">
                      <!--<div class="box-inner">
                            
                            <div class="box-content">-->
                              <div class="form-group">
                                <table width="100%" id="table4" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_badan_id" id="i_badan_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <input type="text" class="form-control" name="i_badan_name" id="i_badan_name" placeholder="Masukkan Nama Badan Usaha" onkeydown="if (event.keyCode == 13) { save_badan(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_badan()" class="btn btn-primary">Simpan satuan</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Nama Badan Usaha</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            <!--</div>
                          </div>-->
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
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        search_data_group()
        search_data_badan()
        select_list_group();
        select_list_city();
        select_list_item_price();
        select_list_busines();
        select_list_customer();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Customer/load_data/'
            },
            "columns": [
              {"name": "customer_name"},
              {"name": "customer_telp"},
              {"name": "customer_store"},
              {"name": "customer_type_name"},
              {"name": "city_name"},
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
              url: '<?php echo base_url();?>Customer/load_data_detail/'+id
            },
            "columns": [
              {"name": "customer_name"},
              {"name": "customer_detail_bonus"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_group() { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Customer/load_data_group/'
            },
            "columns": [
              {"name": "customer_group_id"},
              {"name": "customer_group_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_badan() { 
        $('#table4').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Customer/load_data_badan/'
            },
            "columns": [
              {"name": "busines_id"},
              {"name": "busines_name"},
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
          url  : '<?php echo base_url();?>Customer/action_data/',
          data : new FormData($('#formall')[0]),//$( "#formall" ).serialize(),
          dataType : "json",
          contentType: false,       
          cache: false,             
          processData:false,
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

    function action_data_detail(){
      var new_id = document.getElementById("i_id").value;
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Customer/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3()
              search_data_detail(new_id);
            } 
          }
        });
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Customer/delete_data',
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

    function delete_data_detail(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Customer/delete_data_detail',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset3();
                    search_data_detail(new_id);
                  }
                }
            });
        }
        
    }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Customer/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].customer_id;
              document.getElementById("i_name").value = data.val[i].customer_name;
              document.getElementById("i_addres").value = data.val[i].customer_address;
              document.getElementById("i_store").value = data.val[i].customer_store;
              document.getElementById("i_telp").value = data.val[i].customer_telp;
              document.getElementById("i_hp").value = data.val[i].customer_hp;
              document.getElementById("i_mail").value = data.val[i].customer_mail;
              document.getElementById("i_no_npwp").value = data.val[i].customer_npwp;
              document.getElementById("i_name_npwp").value = data.val[i].customer_npwp_name;
              document.getElementById("i_kredit").value = data.val[i].customer_limit_kredit;
              //document.getElementById("i_card").value = data.val[i].customer_limit_card;
              document.getElementById("i_tempo").value = data.val[i].customer_limit_day;
              document.getElementById("i_member_card_no").value = data.val[i].customer_card_no;

              $("#i_category").append('<option value="'+data.val[i].category_price_id+'" selected>'+data.val[i].category_price_name+'</option>');
              $("#i_group").append('<option value="'+data.val[i].customer_group_id+'" selected>'+data.val[i].customer_group_name+'</option>');
              $("#i_city").append('<option value="'+data.val[i].city_id+'" selected>'+data.val[i].city_name+'</option>');
              $("#i_busines").append('<option value="'+data.val[i].busines_id+'" selected>'+data.val[i].busines_name+'</option>');
              $("#img_customer").attr("src", data.val[i].customer_img);

              search_data_detail(data.val[i].customer_id);
              document.getElementById('detail').style.display = 'block';

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function edit_data_detail(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Customer/load_data_detail_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_detail_id").value = data.val[i].customer_detail_id;
              document.getElementById("i_bonus").value = data.val[i].customer_detail_bonus;

              $("#i_customer").append('<option value="'+data.val[i].customer_member_id+'" selected>'+data.val[i].customer_name+'</option>');

            }
          }
        });

    }

    function select_list_group() {
        $('#i_group').select2({
          placeholder: 'Pilih Group',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Customer/load_data_select_group/',
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

      function reset2(){
        $('#i_category option').remove();
        $('#i_city option').remove();
        $('#i_busines option').remove();
        $('#i_group option').remove();
        $('#img_customer').attr('src', '');
        document.getElementById('detail').style.display = 'none';
      }

      function reset3(){
        $('#i_customer option').remove();
        document.getElementById("i_detail_id").value = '';
        document.getElementById("i_bonus").value = '';
        
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

      function select_list_busines() {
        $('#i_busines').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Customer/load_data_select_busines/',
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

      function save_group(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Customer/action_data_group/',
          data : $( "#formgroup" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset4();
              search_data_group();
            } 
          }
        });
      }

      function reset4(){
        document.getElementById("i_group_id").value = '';
        document.getElementById("i_group_name").value = '';
      }

      function edit_data_group(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Customer/load_data_where_group/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              reset4();
              document.getElementById("i_group_id").value               = data.val[i].customer_group_id;
              document.getElementById("i_group_name").value             = data.val[i].customer_group_name;

            }
          }
        });

    }

    function delete_data_group(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Customer/delete_data_group',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset4();
                    search_data_group();

                  }
                }
            });
        }
        
    }

    function save_badan(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Customer/action_data_badan/',
          data : $( "#formbadan" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset5();
              search_data_badan();
            } 
          }
        });
      }

      function reset5(){
        document.getElementById("i_badan_id").value = '';
        document.getElementById("i_badan_name").value = '';
      }

      function edit_data_badan(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Customer/load_data_where_badan/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              reset5();
              document.getElementById("i_badan_id").value               = data.val[i].busines_id;
              document.getElementById("i_badan_name").value             = data.val[i].busines_name;

            }
          }
        });

    }

    function delete_data_badan(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Customer/delete_data_badan',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset5();
                    search_data_badan();

                  }
                }
            });
        }
        
    }

</script>
</body>
</html>