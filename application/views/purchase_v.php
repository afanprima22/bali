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
                                <th>Code Pembelian</th>
                                <th>tanggal pembelian</th>
                                <th>nama partner</th>
                                <th>jatuh tempo</th>
                                <th>keterangan</th>
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
                            <label>Id purchase (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>tanggal pembelian</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date_purchase" placeholder="Tanggal pembelian" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Partner</label>
                            <select class="form-control select2" name="i_partner" id="i_partner" style="width: 100%;" required="required" value=""></select>
                          </div>
                        </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>jatuh tempo</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker2" name="i_date_tempo" placeholder="Jatuh Tempo" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>keterangan</label>
                            <input type="text" class="form-control" name="i_desc" id="i_desc" placeholder="Keterangan" required="required" value="">
                          </div>
                      </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2><input type="hidden" class="form-control" name="i_purchase_id" id="i_purchase_id" placeholder="Auto" readonly="">
                              <div class="btn-group pull-right"><a href="#myModal" onclick="reset3()" class="btn-sm btn-success" data-toggle="modal" ><i class="glyphicon glyphicon-plus"> Detail</i></a></div>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Id</th>
                                      <th>Nama barang</th>
                                      <th>Qty</th>
                                      <th>Harga</th>
                                      <th>Diskon</th>
                                      <th>Total</th>
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

                    </div>
                
                    </form>
            </div>
        </div>

        <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 70%;">
          <form id="formalls" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Detail</h4><input type="hidden" class="form-control" name="i_purchase_id" id="i_purchase_id" placeholder="Auto" readonly="">
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                            
                            <div class="box-content">
                              <div class="row">
                      <div class="col-md-4">
                          <input type="hidden" class="form-control" name="i_purchase_detail_id" id="i_purchase_detail_id" placeholder="Auto" value="" readonly="">
                          
                          <div class="form-group">
                            <label>Nama barang</label>
                            <select class="form-control select2" onchange="item_detail(this.value)" name="i_item" id="i_item" style="width: 100%;" onkeydown="if (event.keyCode == 13) { save_detail(); }"></select>
                          </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" class="form-control" onchange="total(this.value)" name="i_qty" placeholder="Masukkan Quantity" required="required" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" class="form-control" onchange="total2(this.value)" name="i_price" id="i_price" placeholder="Masukkan Harga" required="required" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                          </div>
                        <div class="form-group">
                            <label>Diskon</label>
                            <input type="number" class="form-control" onchange="diskon(this.value)" name="i_diskon" placeholder="Masukkan Diskon" required="required" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                            <label>Total</label>
                            <input type="text" class="form-control" readonly="" name="i_total" placeholder="Total" required="required" value="" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                          </div>

                        </div>
                      </div>
                            </div>
                          </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="save_detail(1)" class="btn btn-warning">Tambah</button>
                    <button type="button"  onclick="save_detail(2)" class="btn btn-primary">Simpan</button>
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
        select_list_item();
        select_list_partner();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Purchase/load_data/'
            },
            "columns": [
              {"name": "purchase_code"},
              {"name": "purchase_date"},
              {"name": "supplier_id"},
              {"name": "purchase_tempo"},
              {"name": "purchase_desc"},
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
    
    

    function search_data_detail(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Purchase/load_data_detail/'+id
            },
            "columns": [
              {"name": "purchase_detail_id"},
              {"name": "item_id"},
              {"name": "purchase_detail_qty"},
              {"name": "purchase_detail_price"},
              {"name": "purchase_detail_discount"},
              {"name": "purchase_detail_total"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

    }
    


    function action_data(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Purchase/action_data/',
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

    function reset2(){
      $("#i_partner option").remove();
    }

           
    

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Purchase/delete_data',
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
          url  : '<?php echo base_url();?>Purchase/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].purchase_id;
              document.getElementById("datepicker").value           = data.val[i].purchase_date;
              $("#i_partner").append('<option value="'+data.val[i].partner_id+'" selected>'+data.val[i].partner_name+'</option>');
              document.getElementById("datepicker2").value      = data.val[i].purchase_tempo;
              document.getElementById("i_desc").value         = data.val[i].purchase_desc;
              get_purchase_id();
              search_data_detail(data.val[i].purchase_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function get_purchase_id(){
      var purchase_id = $('input[name="i_id"]').val();
      //alert(transales_id);
      $('input[name="i_purchase_id"]').val(purchase_id);
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

      function select_list_partner() {
        $('#i_partner').select2({
          placeholder: 'Pilih partner',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Partner/load_data_select_partner/',
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

      
      function save_detail(type){
        var id = document.getElementById("i_purchase_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        var id1 =document.getElementById("i_id").value;
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Purchase/action_data_detail/',
          data : $( "#formalls" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              search_data_detail(id_new);
              reset3();
              if (type==2) {
              $('#myModal').modal('hide');
              };
            } 
          }
        });
      }

      function reset3(){
        $('input[name="i_purchase_detail_id"]').val("");
              $("#i_item option").remove();
              $('input[name="i_qty"]').val("");
              $('input[name="i_price"]').val("");
              $('input[name="i_diskon"]').val("");
              $('input[name="i_total"]').val("");
      }

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Purchase/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
              var purchase_id = $('input[name="i_id"]').val();
      //alert(purchase_id);
      $('input[name="i_purchase_id"]').val(purchase_id);
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_purchase_detail_id"]').val(data.val[i].purchase_detail_id);
              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
              $('input[name="i_qty"]').val(data.val[i].purchase_detail_qty);
              $('input[name="i_price"]').val(data.val[i].purchase_detail_price);
              $('input[name="i_diskon"]').val(data.val[i].purchase_detail_discount);
              $('input[name="i_total"]').val(data.val[i].purchase_detail_total);

            }

          }
        });
      }

      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_purchase_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Purchase/delete_data_detail',
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

    function get_purchase_id(){
      var purchase_id = $('input[name="i_id"]').val();
      //alert(purchase_id);
      $('input[name="i_purchase_id"]').val(purchase_id);
    }

    function item_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item/load_data_item_detail/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            reset5();
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_price"]').val(data.val[i].item_price1);
              $('input[name="i_total"]').val(data.val[i].item_price1);
            }
          }
        });
      }
      function reset5(){
              $('input[name="i_qty"]').val("");
              $('input[name="i_diskon"]').val("");
      }
//TOTAL
      function total(id){
        var price = $('input[name="i_price"]').val();
        var diskon = $('input[name="i_diskon"]').val();
       if (!price) {
          var price =0;
          
        };if (!diskon) {
          var diskon =0;
          
        };
        if (!id) {
          var id =0;
          
        };
        var total1 = (parseFloat(id)*parseFloat(price));
        var total2 = (parseFloat(diskon)*parseFloat(total1));
        var total = (parseFloat(total2)/100)
        var total4 = (parseFloat(total1)-parseFloat(total));

        var subtotal = parseFloat(total4);
      $('input[name="i_total"]').val(parseFloat(subtotal));
      }


      function total2(id){
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Purchase/action_data_item/',
          data :  $( "#formalls" ).serialize(),
          dataType : "json",
          success:function(data){
            price();
          }
        });

    }
      function price(){
        var price = $('input[name="i_price"]').val();
        var Qty = $('input[name="i_qty"]').val();
        var diskon = $('input[name="i_diskon"]').val();
        if (!diskon) {
          var diskon =0;
          
        };if (!Qty) {
          var Qty =0;
          
        };
        if (!id) {
          var id =0;
          
        };
        
        var total1 = (parseFloat(price)*parseFloat(Qty));
        var total2 = (parseFloat(diskon)*parseFloat(total1));
        var total = (parseFloat(total2)/100)
        var total4 = (parseFloat(total1)-parseFloat(total));

        var subtotal = parseFloat(total4);
      $('input[name="i_total"]').val(parseFloat(subtotal));
      }
      function reset4(){
         $('input[name="i_diskon"]').val("");
      }

      function diskon(id){
        var price = $('input[name="i_price"]').val();
        var Qty = $('input[name="i_qty"]').val();
        if (!Qty) {
          var Qty =0;
          
        };
        if (!id) {
          var id =0;
          
        };if (!price) {
          var price =0;
          
        };
        if (id>100) {
          reset4();
          alert("diskon tidak boleh lebih dari 100%")
        };
        if (id<0) {
          reset4();
          alert("diskon tidak boleh kurang dari 0%")
        };
        var total1 = (parseFloat(Qty)*parseFloat(price));
        var total2 = (parseFloat(id)*parseFloat(total1));
        var total = (parseFloat(total2)/100)
        var total4 = (parseFloat(total1)-parseFloat(total));
        var subtotal = parseFloat(total4);
       
      $('input[name="i_total"]').val(subtotal);
      }
    
    
</script>
</body>
</html>