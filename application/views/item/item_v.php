<style type="text/css">
  .money{
    text-align: right;
  }
  .fileinput-button input{position:absolute;top:0;right:0;margin:0;opacity:0;-ms-filter:'alpha(opacity=0)';font-size:15px;direction:ltr;cursor:pointer}
</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#list_item" data-toggle="tab">Data Barang</a></li>
        <li><a href="#list_class" data-toggle="tab">Data Class Item</a></li>
        <li><a href="#list_sub" data-toggle="tab">Data Sub Class Item</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="list_item">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#list_data_item" data-toggle="tab">List Data Barang</a></li>
          <li><a href="#form_data_item" data-toggle="tab">Form Data Barang</a></li>
        </ul>
        <div class="tab-content">
          <? include('item_d.php');?>
        </div>
      </div>
      <div class="tab-pane" id="list_class">
        <? include('item_class_d.php');?>
      </div>
      <div class="tab-pane" id="list_sub">
        <? include('item_sub_class_d.php');?>
      </div>
      
    </div>

    <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="formunit" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Data Satuan</h4>
                  </div>
                  <div class="modal-body">
                      <!--<div class="box-inner">
                            
                            <div class="box-content">-->
                              <div class="form-group">
                                <table width="100%" id="table4" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_unit_id" id="i_unit_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <input type="text" class="form-control" name="i_unit_name" id="i_unit_name" placeholder="Masukkan Nama Satuan" onkeydown="if (event.keyCode == 13) { save_unit(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_unit()" class="btn btn-primary">Simpan satuan</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Nama Satuan</th>
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
        search_data_class();
        search_data_sub();
        search_data_item();
        search_data_unit();
        select_list_class_sub();
        select_list_class_item();
        select_list_sub_class_item();
        select_list_brand();
        select_list_unit();
    });

    function search_data_class() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Item/load_data_class/'
            },
            "columns": [
              {"name": "item_clas_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    $("#formclass").submit(function(event){
        if ($("#formclass").valid()==true) {
          action_data_class();
        }
        return false;
      });

    function action_data_class(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Item/action_data_class/',
          data : $( "#formclass" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset2();
              search_data_class();
            } 
          }
        });
    }

    function delete_data_class(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Item/delete_data_class',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset2();
                    search_data_class();

                  }
                }
            });
        }
        
    }

    function edit_data_class(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item/load_data_where_class/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id_class").value               = data.val[i].item_clas_id;
              document.getElementById("i_name_class").value             = data.val[i].item_clas_name;

            }
          }
        });

    }

    function reset2(){
      document.getElementById("i_id_class").value = '';
      document.getElementById("i_name_class").value = '';
    }

    function search_data_sub() { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Item/load_data_sub/'
            },
            "columns": [
              {"name": "item_sub_clas_name"},
              {"name": "item_clas_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    $("#formsub").submit(function(event){
        if ($("#formsub").valid()==true) {
          action_data_sub();
        }
        return false;
      });

    function action_data_sub(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Item/action_data_sub/',
          data : $( "#formsub" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3();
              search_data_sub();
            } 
          }
        });
    }

    function delete_data_sub(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Item/delete_data_sub',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset3();
                    search_data_sub();

                  }
                }
            });
        }
        
    }

    function edit_data_sub(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item/load_data_where_sub/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id_sub").value               = data.val[i].item_sub_clas_id;
              document.getElementById("i_name_sub").value             = data.val[i].item_sub_clas_name;
              $("#i_class_sub").append('<option value="'+data.val[i].item_clas_id+'" selected>'+data.val[i].item_clas_name+'</option>');

            }
          }
        });

    }

    function select_list_class_sub() {
        $('#i_class_sub').select2({
          placeholder: 'Pilih Class Item',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_class/',
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

    function reset3(){
      document.getElementById("i_id_sub").value = '';
      document.getElementById("i_name_sub").value = '';
      $('#i_class_sub option').remove();
    }

    function search_data_item() { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Item/load_data_item/'
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_clas_name"},
              {"name": "item_sub_clas_name"},
              {"name": "brand_name"},
              {"name": "unit_name"},
              {"name": "item_last_price"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    $("#formitem").submit(function(event){
        if ($("#formitem").valid()==true) {
          action_data_item();
        }
        return false;
      });

    function action_data_item(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Item/action_data_item/',
          data : $( "#formitem" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset4();
              search_data_item();
              $('[href="#list_data_item"]').tab('show');
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

    function delete_data_item(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Item/delete_data_item',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset4();
                    search_data_item();

                    document.getElementById('create').style.display = 'none';
                    document.getElementById('update').style.display = 'none';
                    document.getElementById('delete').style.display = 'block';
                  }
                }
            });
        }
        
    }

    function edit_data_item(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item/load_data_where_item/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id_item").value            = data.val[i].item_id;
              document.getElementById("i_name_item").value          = data.val[i].item_name;
              document.getElementById("i_barcode").value            = data.val[i].item_barcode;
              document.getElementById("i_stok_min").value           = data.val[i].item_min;
              document.getElementById("i_stok_max").value           = data.val[i].item_max;
              document.getElementById("i_price_last").value         = data.val[i].item_last_price;
              document.getElementById("i_price1").value             = data.val[i].item_price1;
              document.getElementById("i_price2").value             = data.val[i].item_price2;
              document.getElementById("i_price3").value             = data.val[i].item_price3;
              document.getElementById("i_price4").value             = data.val[i].item_price4;
              document.getElementById("i_price5").value             = data.val[i].item_price5;
              document.getElementById("i_qty_unit").value             = data.val[i].item_per_unit;

              $("#i_class_item").append('<option value="'+data.val[i].item_clas_id+'" selected>'+data.val[i].item_clas_name+'</option>');
              $("#i_sub_class_item").append('<option value="'+data.val[i].item_sub_clas_id+'" selected>'+data.val[i].item_sub_clas_name+'</option>');
              $("#i_brand").append('<option value="'+data.val[i].brand_id+'" selected>'+data.val[i].brand_name+'</option>');
              $("#i_unit").append('<option value="'+data.val[i].unit_id+'" selected>'+data.val[i].unit_name+'</option>');

              document.getElementById('detail_data').style.display = 'block';

              $("#galeries").load("<?= base_url()?>Item/load_galery/"+id);

            }
          }
        });

        $('[href="#form_data_item"]').tab('show');

    }

    function select_list_class_item() {
        $('#i_class_item').select2({
          placeholder: 'Pilih Class Item',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_class/',
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

      function select_list_sub_class_item() {
        $('#i_sub_class_item').select2({
          placeholder: 'Pilih Sub Class Item',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_sub_class/',
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

      function select_list_brand() {
        $('#i_brand').select2({
          placeholder: 'Pilih Merk',
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

      function select_list_unit() {
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
      }

    function reset4(){
      document.getElementById("i_id_item").value = '';
      document.getElementById("i_price_last").value = '';
      document.getElementById("i_price1").value = '';
      document.getElementById("i_name_item").value = '';
      document.getElementById("i_barcode").value = '';
      document.getElementById("i_stok_min").value = '';
      document.getElementById("i_stok_max").value = '';
      document.getElementById("i_price2").value = '';
      document.getElementById("i_price3").value = '';
      document.getElementById("i_price4").value = '';
      document.getElementById("i_price5").value = '';
      $('#i_brand option').remove();
      $('#i_unit option').remove();
      $('#i_class_item option').remove();
      $('#i_sub_class_item option').remove();

      document.getElementById('detail_data').style.display = 'none';
    }

    function search_data_unit() { 
        $('#table4').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Item/load_data_unit/'
            },
            "columns": [
              {"name": "unit_id"},
              {"name": "unit_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function save_unit(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Item/action_data_unit/',
          data : $( "#formunit" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset5();
              search_data_unit();
            } 
          }
        });
    }

    function delete_data_unit(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Item/delete_data_unit',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset5();
                    search_data_unit();

                  }
                }
            });
        }
        
    }

    function edit_data_unit(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item/load_data_where_unit/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_unit_id").value               = data.val[i].unit_id;
              document.getElementById("i_unit_name").value             = data.val[i].unit_name;

            }
          }
        });

    }

    function reset5(){
      document.getElementById("i_unit_id").value = '';
      document.getElementById("i_unit_name").value = '';
    }

    function get_save_galery(value){
      //alert(id);
      var id =document.getElementById("i_id_item").value;

      $.ajax({
        type : "POST",
        url  : '<?php echo base_url();?>Item/action_galery/',
        data : new FormData($('#formitem')[0]),
        dataType : "json",
        contentType: false,       
        cache: false,             
        processData:false,
        success:function(data){
          if(data.status=='200'){
             $("#galeries").load("<?= base_url()?>Item/load_galery/"+id);
          }
        }
      });
    }

    function delete_galery(id_galery){
      //alert(id);
      var id =document.getElementById("i_id_item").value;
      
      $.ajax({
        type : "POST",
        url  : '<?php echo base_url();?>item/delete_galery/',
        data : {id_galery:id_galery},
        dataType : "json",
        success:function(data){
          if(data.status=='200'){
             $("#galeries").load("<?= base_url()?>item/load_galery/"+id);
          }
        }
      });
    }
</script>
</body>
</html>