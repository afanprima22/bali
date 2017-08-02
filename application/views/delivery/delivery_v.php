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
        <li class="active"><a href="#list" data-toggle="tab">List Nota</a></li>
        <li><a href="#form" data-toggle="tab">Form Data</a></li>
        <li><a href="#list_do" data-toggle="tab">List Nota DO</a></li>
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
                                <th>Tanggal Proses</th>
                                <th>Customer</th>
                                <th>Alamat Customer</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="list_do">
            <div class="box-inner">
                <div class="box-content">
                    <div id="create" class="alert alert-success" style="display: none;"><h4><i class="glyphicon glyphicon-check"></i> Sukses!</h4>Data telah Disimpan.</div>
                    <div id="update" class="alert alert-info" style="display: none;"><h4><i class="glyphicon glyphicon-info-sign"></i> Sukses!</h4>Data telah Direvisi.</div>
                    <div id="delete" class="alert alert-danger" style="display: none;"><h4><i class="glyphicon glyphicon-ban-circle"></i> Sukses!</h4>Data telah Dihapus.</div>
                    <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                        <thead>
                            <tr>
                                <th>Kode Nota</th>
                                <th>Tanggal DO</th>
                                <th>Sopir</th>
                                <th>Ongkos Kirim</th>
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
                            <label>Nama Sopir</label>
                            <select class="form-control select2" name="i_employee" id="i_employee" style="width: 100%;">
                            </select>
                            <input type="hidden" class="form-control" name="i_id" id="i_id">
                          </div>
                          <div class="form-group">
                            <label>Ongkos Kirim</label>
                            <input type="text" class="form-control money" placeholder="Masukkan Ongkos Kirim" required="required" name="i_cost" id="i_cost" value="">
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal DO</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal DO" value="" required="required">
                            </div>
                          </div>

                        </div>
                        
                        <div id="view_detail"></div>
                        <? //include('delivery_d.php'); ?>
                      </div>
                      <div class="form-group"></div>
                      <div class="box-footer text-right">
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
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
      var date = new Date();
        search_data();
        search_data_do();
        select_list_employee();
        //$.fn.modal.Constructor.prototype.enforceFocus = function() {};
        //document.getElementById("datepicker").value  = (date.getMonth()+ 1) + '/' + date.getDate() + '/' +  date.getFullYear();
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
              url: '<?php echo base_url();?>delivery/load_data/'
            },
            "columns": [
              {"name": "nota_code"},
              {"name": "nota_date"},
              {"name": "customer_name"},
              {"name": "customer_address"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'desc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_do() { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>delivery/load_data_do/'
            },
            "columns": [
              {"name": "nota_code"},
              {"name": "delivery_date"},
              {"name": "employee_name"},
              {"name": "delivery_cost"},
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
          url  : '<?php echo base_url();?>delivery/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2()
              search_data_do();
              $('[href="#list_do"]').tab('show');
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
      $('#i_employee option').remove();
      $("#view_detail").load("<?= site_url()?>delivery/load_view_detail/"+ 0+"/"+ 0);
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

    function edit_data(delivery_id,nota_id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>delivery/load_data_where/',
          data : {delivery_id:delivery_id,nota_id:nota_id},
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value           = data.val[i].delivery_id;
              document.getElementById("datepicker").value     = data.val[i].delivery_date;
              document.getElementById("i_cost").value         = data.val[i].delivery_cost;

              $("#i_employee").append('<option value="'+data.val[i].employee_id+'" selected>'+data.val[i].employee_name+'</option>');

              $("#view_detail").load("<?= site_url()?>delivery/load_view_detail/"+(delivery_id)+"/"+(nota_id));
              
            }
          }
        });

        $('[href="#form"]').tab('show');
    }


      function select_list_employee() {
        $('#i_employee').select2({
          placeholder: 'Pilih Sopir',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>employee/load_data_select_employee_divisi/'+ 3,
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


    function proses_data(id){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>delivery/proses_data/',
          data :{id:id},
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              //edit_data(data.delivery_id,data.nota_id);
              document.getElementById("i_id").value = data.delivery_id;
              $("#view_detail").load("<?= site_url()?>delivery/load_view_detail/"+(data.delivery_id)+"/"+(data.nota_id));
              $('[href="#form"]').tab('show');
            } 
          }
        });
    }

    function create_do(id){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>delivery/new_do_action/',
          data :{id:id},
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset2();
              $('[href="#list_do"]').tab('show');
            } 
          }
        });
    }
</script>
</body>
</html>