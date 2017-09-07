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
                                <th>Nama Merek</th>
                                <th>Type</th>
                                <th>Persentase</th>
                                <th>tanggal</th>
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
                      <label>Type : </label>
                            <label>
                            <input type="radio" onclick="type_payment(1)" required name="i_type" id="inlineRadio1" value="1"> Presentase
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(2)" required name="i_type" id="inlineRadio2" value="2"> manual
                            </label>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Id Harga (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Merk</label>
                            <select class="form-control select2" onchange="search_data_view(this.value)" name="i_brand" id="i_brand" required style="width: 100%;"  value=""></select>
                          </div>   
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                          <label>Tanggal Ubah</label>
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="glyphicon glyphicon-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker" name="i_date_price" placeholder="Masukkan Tanggal" value="" required="required">
                          </div>
                        </div> 
                        <div id="credit_card" style="display: none;">
                          <div class="form-group">
                            <label>Presentase</label>
                            <input type="text" class="form-control" name="i_persentase" id="i_persentase" placeholder="masukan dalam bentuk %" value="">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>View Detail</h2>
<!--                               <div class="btn-group pull-right"><a href="#myModal" onclick="get_purchase_id()" class="btn-sm btn-success" data-toggle="modal" ><i class="glyphicon glyphicon-plus"> Detail</i></a></div>
 -->                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>no</th>
                                      <th>barcode</th>
                                      <th>nama barang</th>
                                      <th>harga 1</th>
                                      <th>harga 2</th>
                                      <th>harga 3</th>
                                      <th>harga 4</th>
                                      <th>harga 5</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              <div class="form-group"></div>
                                <div class="box-footer text-right">
                                   <button type="button" onclick="reset()" class="btn btn-warning">Batal</button>
                                   <button type="button"  onclick="save_detail()" class="btn btn-primary">Simpan Detail</button>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12" id="detail_data_item">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2>
<!--                               <div class="btn-group pull-right"><a href="#myModal" onclick="get_purchase_id()" class="btn-sm btn-success" data-toggle="modal" ><i class="glyphicon glyphicon-plus"> Detail</i></a></div>
 -->                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>nama barang</th>
                                      <th>harga 1 Lama</th>
                                      <th>harga 1 baru</th>
                                      <th>harga 2 Lama</th>
                                      <th>harga 2 baru</th>
                                      <th>harga 3 Lama</th>
                                      <th>harga 3 baru</th>
                                      <th>harga 4 Lama</th>
                                      <th>harga 4 baru</th>
                                      <th>harga 5 Lama</th>
                                      <th>harga 5 baru</th>
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
                        <button type="button" onclick="reset2()" class="btn btn-warning">Batal</button>
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
        search_data_view(0);
        search_data_detail(0);
        select_list_brand();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Price/load_data/'
            },
            "columns": [
              {"name": "brand_id"},
              {"name": "change_price_type"},
              {"name": "change_price_persentase"},
              {"name": "change_price_date"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function active_tab(id){
        if (id == 1) {
          $('[href="#tabs-2"]').tab('show');
        }else{
          $('[href="#tabs-1"]').tab('show');
        }
        
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
          url  : '<?php echo base_url();?>Price/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset1();
              search_data();
              search_data_view(0);
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
        $('#i_brand option').remove();
        $('input[name="i_persentase"]').val("");
      }
    function reset2(){
            $('#i_brand option').remove();
            $('input[name="i_persentase"]').val("");
            search_data_view(0);
            delete_data_detail();
            search_data_detail(0);
          }

    
    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Price/load_data_where/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
             document.getElementById("i_id").value             = data.val[i].change_price_id;
             document.getElementById("datepicker").value             = data.val[i].change_price_date;
              $("#i_brand").append('<option value="'+data.val[i].brand_id+'" selected>'+data.val[i].brand_name+'</option>');
              document.getElementById("i_persentase").value           = data.val[i].change_price_persentase;
              if (data.val[i].change_price_type == '1') {
                document.getElementById("inlineRadio1").checked = true;
                document.getElementById('credit_card').style.display = 'block';
              } else if (data.val[i].change_price_type == '2') {
                document.getElementById("inlineRadio2").checked = true;
              }
              search_data_view(data.val[i].brand_id);
              search_data_detail(data.val[i].change_price_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }
    function select_list_brand() {
        $('#i_brand').select2({
          placeholder: 'Pilih Merek',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Brand/load_data_select_brand/',
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

      function type_payment(id){

      if (id == 1) {
        document.getElementById('credit_card').style.display = 'block';
      }else{
        document.getElementById('credit_card').style.display = 'none';
      }
    }
    function search_data_view(id){
      if (!id) {
        var id = 0;
      };
      var type = document.getElementsByName('i_type') ;
      var type2;
      for(var i = 0; i < type.length; i++){
          if(type[i].checked){
              type2 = type[i].value;
          }
      }
      $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Price/load_data_item/'+id+'/'+type2,
            },
            "columns": [
              {"name": "item_id"},
              {"name": "item_barcode"},
              {"name": "item_name"},
              {"name": "item_price1"},
              {"name": "item_price2"},
              {"name": "item_price3"},
              {"name": "item_price4"},
              {"name": "item_price5"},
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail(id){
      $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Price/load_data_detail/'+id,
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_price1_old"},
              {"name": "item_price1_new"},
              {"name": "item_price2_old"},
              {"name": "item_price2_new"},
              {"name": "item_price3_old"},
              {"name": "item_price3_new"},
              {"name": "item_price4_old"},
              {"name": "item_price4_new"},
              {"name": "item_price5_old"},
              {"name": "item_price5_new"},
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
                url: '<?php echo base_url();?>Price/delete_data',
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
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Price/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              search_data_detail(id_new);
            } 
          }
        });
      }

      function delete_data_detail() {
            $.ajax({
                url: '<?php echo base_url();?>Price/delete_data_detail',
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_detail();

                  }
                }
            });
        
    }
</script>
</body>
</html>