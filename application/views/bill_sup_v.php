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
                                <th>Kode Pembayaran</th>
                                <th>Tanggal</th>
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
                           <label>Tanggal Cetak</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Cetak" value="" required="required">
                            </div>
                            <input type="hidden" class="form-control i_id" name="i_id" id="i_id" value="" >
                          </div>

                        </div>
                        <div class="col-md-6">
                          
                          
                        </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Nota</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Kode Nota</th>
                                      <th>Tanggal Jatuh Tempo</th>
                                      <th>Nominal</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th colspan="2" style="text-align: right;">Total Tagihan</th>
                                      <th colspan="2"><input type="text" class="form-control" name="total_tagihan" readonly="" style="border: none;background: transparent;text-align: right;font-size: 18px;"></th>
                                    </tr>                                    
                                  </tfoot>
                                </table>                                
                              </div>
                              <div class="form-group">
                                <select class="form-control select2" name="i_nota" id="i_nota" style="width: 20%;" onchange="save_detail()">
                                </select>                              
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class="col-md-12" id="payment_data" style="padding-top: 10px; display: none;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Pembayaran</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th colspan="5">Jenis Pembayaran :
                                        <label>
                                            <input type="radio" onclick="type_payment(1)" name="i_type" id="inlineRadio1" value="0"> Cash
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>
                                            <input type="radio" onclick="type_payment(2)" name="i_type" id="inlineRadio2" value="1"> Transfer
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>
                                            <input type="radio" onclick="type_payment(3)" name="i_type" id="inlineRadio3" value="3"> Giro
                                        </label>
                                      </th>
                                    </tr>
                                    <tr>
                                      <th>
                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                          </div>
                                          <input type="text" class="form-control pull-right" id="datepicker2" name="i_detail_date" placeholder="Tanggal Bayar" value="">
                                        </div>
                                      </th>
                                      <th>
                                        <input type="text" class="form-control money" id="i_nominal" name="i_nominal" placeholder="Nominal" value="">
                                      </th>
                                      <th colspan="2">
                                        <div id="transfer" style="display: none;">
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="i_detail_bank" name="i_detail_bank" placeholder="Bank" value="">
                                          </div>
                                          <div class="col-md-4">
                                            <input type="text" class="form-control" id="i_detail_rek" name="i_detail_rek" placeholder="Rekening" value="">
                                          </div>
                                          
                                        </div>
                                        <div id="giro" style="display: none;">
                                          <div class="col-md-4">
                                            <div class="input-group date">
                                              <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                              </div>
                                              <input type="text" class="form-control pull-right" id="datepicker3" name="i_detail_tempo" placeholder="Tempo" value="">
                                            </div>
                                          </div>
                                          
                                        </div>
                                      </th>
                                      <th width="10%"><button type="button" onclick="save_detail_payment()" class="btn btn-primary">Simpan Detail</button></th>
                                    </tr>
                                    <tr>
                                      <th>Tanggal Pembayaran</th>
                                      <th>Nominal</th>
                                      <th>Jenis Pembayaran</th>                                      
                                      <th>Keterangan</th>
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
        search_data_detail(0);
        select_list_nota();
       // $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        document.getElementById("datepicker").value  = (date.getMonth()+ 1) + '/' + date.getDate() + '/' +  date.getFullYear();
    });

    function type_payment(id){

      if (id == 1) {
        document.getElementById('transfer').style.display = 'none';
        document.getElementById('giro').style.display     = 'none';
      }else if(id == 2){
        document.getElementById('transfer').style.display = 'block';
        document.getElementById('giro').style.display     = 'none';
      }else{
        document.getElementById('transfer').style.display = 'block';
        document.getElementById('giro').style.display     = 'block';
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
              url: '<?php echo base_url();?>bill_sup/load_data/'
            },
            "columns": [
              {"name": "bill_code"},
              {"name": "bill_date"},
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
              url: '<?php echo base_url();?>bill_sup/load_data_detail/'+id
            },
            "columns": [
              {"name": "nota_code"},
              {"name": "nota_tempo"},
              {"name": "nota_nominal","orderable": false,"searchable": false},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

        get_grand_total(id);
    }

    function search_data_payment(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>bill_sup/load_data_payment/'+id
            },
            "columns": [
              {"name": "bill_payment_date"},
              {"name": "bill_payment_type"},
              {"name": "bill_payment_nominal"},
              {"name": "bill_payment_nominal","orderable": false,"searchable": false},
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
          url  : '<?php echo base_url();?>bill_sup/action_data/',
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
                url: '<?php echo base_url();?>bill_sup/delete_data',
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
        document.getElementById('payment_data').style.display     = 'block';

        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>bill_sup/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].bill_id;
              document.getElementById("datepicker").value           = data.val[i].bill_date;

              search_data_detail(data.val[i].bill_id);
              search_data_payment(data.val[i].bill_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function reset2(){
      $('#i_nota option').remove();
      search_data_detail(0);
      search_data_payment(0);
      document.getElementById('payment_data').style.display     = 'none';
    }

      function select_list_nota() {
        $('#i_nota').select2({
          placeholder: 'Pilih Purchase',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Nota/load_data_select_nota/'+1,
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
          url  : '<?php echo base_url();?>bill_sup/action_data_detail/',
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
       $('#i_nota option').remove();
      }

      function delete_data_detail(id_detail,nota_id) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>bill_sup/delete_data_detail',
                data: {id:id_detail,nota_id:nota_id},
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

    function save_detail_payment(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>bill_sup/action_data_detail_payment/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset4();
              search_data_payment(id_new);
            } 
          }
        });
      }

    function reset4(){
       $('input[name="i_detail_rek"]').val("");
       $('input[name="i_type"]').val("");
       $('input[name="i_detail_bank"]').val("");
       $('input[name="i_nominal"]').val("");
       $('input[name="i_detail_date"]').val("");
       $('input[name="i_detail_tempo"]').val("");
    }

    function delete_data_payment(id_detail,entrusted) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>bill_sup/delete_data_payment',
                data: {id:id_detail,entrusted:entrusted},
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_payment(id_new);
                  }
                }
            });
        }
        
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

    function print_pdf(id){
      window.open('<?php echo base_url();?>Nota/print_nota_pdf?id='+id);
    }

    function get_grand_total(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>bill_sup/get_grand_total/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            $('input[name="total_tagihan"]').val(data.grand_total);
          }
        });
      }

    function type_dp(id){

      if (id == 1) {
        document.getElementById('nomor_card').style.display = 'none';
      }else{
        document.getElementById('nomor_card').style.display = 'block';
      }

    }
</script>
</body>
</html>