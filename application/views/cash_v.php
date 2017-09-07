<style type="text/css">
  .money{
    text-align: right;
  }
</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#list" data-toggle="tab">List Data</a></li>
        <li><a href="#form" data-toggle="tab">Form Data</a></li>
        <li><a href="#Review" data-toggle="tab">Review Kas Harian</a></li>
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
                                <th>Tanggal</th>
                                <th>Nominal Kas</th>
                                <th>Kode Akun</th>
                                <th>Asal Akun</th>
                                <th>Tujuan   Akun</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                
            </div>

        </div>
        <div class="tab-pane" id="Review">
          <div class="box-inner">
            <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              
                 <div class="box-content">
                      <div class="row">
                        <div class="row">
                          <div class="col-md-12">
                            
                              <form id="formclass" role="form" action="" method="post" enctype="multipart/form-data">
                                <div class="box-content">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Tanggal Kas</label>
                                    <div class="input-group date">
                                      <div class="input-group-addon">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control pull-right" onchange="review(this.value)" id="datepicker2" name="i_cash_date2" placeholder="Masukkan Tanggal Kas" value="" required="required">
                                    </div>
                                  </div>
                                  
                                </div>
                                </div>
                              </form>
                          </div>
                          </div>
                          </div>
                          <div class="box-inner">
                              <div class="box-content" width="100%">
                                      <table width="160%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                          <thead>
                                              <tr>
                                                  <th>Tanggal</th>
                                                  <th>Cabang</th>
                                                  <th>Nominal Kas</th>
                                                  <th>Kode Akun</th>
                                                  <th>Asal Akun</th>
                                                  <th>Tujuan   Akun</th>
                                              </tr>
                                          </thead>
                                      </table>
                                </div>
                          </div>
              </div>
          </form>
          </div>
        </div>
        <div class="tab-pane" id="form">
            <div class="box-inner">

                <form id="formall" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
                    <div class="box-content">
                      <div class="row">
                        <div class="col-md-6">
                          <div hidden class="form-group">
                            <label>Alokasi Kas :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" name="i_type" id="inlineRadio1" value="0"> Debit
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" name="i_type" id="inlineRadio2" value="1"> Kredit
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" name="i_type" id="inlineRadio3" value="2"> Hutang
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" name="i_type" id="inlineRadio4" value="3"> Piutang
                            </label>
                          </div>
                          <div class="form-group">
                            <label>Gudang</label>
                            <select class="form-control select2" name="i_warehouse" id="i_warehouse" style="width: 100%;" required="required" value=""></select>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" value="" >
                          </div>
                          <div class="form-group">
                            <label>Kode Akun</label>
                            <select class="form-control select2" name="i_coa" id="i_coa" style="width: 100%;" required="required" value=""></select>
                          </div>
                          <div class="form-group">
                            <label>Asal Akun</label>
                            <select class="form-control select2" name="i_coa2" id="i_coa2" style="width: 100%;" required="required" value=""></select>
                          </div>
                          <div class="form-group">
                            <label>Tujuan Akun</label>
                            <select class="form-control select2" name="i_coa3" id="i_coa3" style="width: 100%;" required="required" value=""></select>
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Kas</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_cash_date" placeholder="Masukkan Tanggal Kas" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Nominal</label>
                            <input type="text" class="form-control money" name="i_nominal" id="i_nominal" placeholder="Masukkan Nominal" value="" required="required">
                          </div>
                          <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Keterangan" name="i_desc" id="i_desc"></textarea>
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

        

    </div>
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        select_list_warehouse();
        select_list_coa();
        select_list_coa2();
        select_list_coa3();

       // $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Cash/load_data/'
            },
            "columns": [
              {"name": "cash_date"},
              {"name": "cash_nominal"},
              {"name": "coa_name.' '.coa_nomor"},
              {"name": "name1.' '.nomor1"},
              {"name": "name2.' '.nomor2"},
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
          url  : '<?php echo base_url();?>Cash/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset1();
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

    function reset1(){
      $("#i_coa option").remove("");
      $("#i_warehouse option").remove("");
    }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Cash/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].cash_id;
              document.getElementById("datepicker").value           = data.val[i].cash_date;
              document.getElementById("i_nominal").value           = data.val[i].cash_nominal;
              document.getElementById("i_desc").value           = data.val[i].cash_desc;

              $("#i_coa").append('<option value="'+data.val[i].coa_id+'" selected>'+data.val[i].coa_nomor+' '+data.val[i].coa_name+'</option>');
              $("#i_coa2").append('<option value="'+data.val[i].coa_id2+'" selected>'+data.val[i].nomor1+' '+data.val[i].name1+'</option>');
              $("#i_coa3").append('<option value="'+data.val[i].coa_id3+'" selected>'+data.val[i].nomor2+' '+data.val[i].name2+'</option>');
              $("#i_warehouse").append('<option value="'+data.val[i].warehouse_id+'" selected>'+data.val[i].warehouse_name+'</option>');

              if (data.val[i].cash_type == '0') {
                document.getElementById("inlineRadio1").checked = true;
              }else if (data.val[i].cash_type == '1') {
                document.getElementById("inlineRadio2").checked = true;
              }else if (data.val[i].cash_type == '2') {
                document.getElementById("inlineRadio3").checked = true;
              }else if (data.val[i].cash_type == '3') {
                document.getElementById("inlineRadio4").checked = true;
              }
          }
        }
      });
        $('[href="#form"]').tab('show');
    }

    function select_list_warehouse() {
        $('#i_warehouse').select2({
          placeholder: 'Pilih Gudang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Warehouse/load_data_select_warehouse/',
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

      function select_list_coa() {
        $('#i_coa').select2({
          placeholder: 'Pilih Kode Akun',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Coa/load_data_select_coa/',
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

      function select_list_coa2() {
        $('#i_coa2').select2({
          placeholder: 'Pilih Asal Akun',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Coa/load_data_select_coa/',
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

      function select_list_coa3() {
        $('#i_coa3').select2({
          placeholder: 'Pilih Tuhuan Akun',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Coa/load_data_select_coa/',
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
                url: '<?php echo base_url();?>Cash/delete_data',
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

    function review(id){
      $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Cash/load_data_review?id='+id,
              data : "id="+id,
            },
            "columns": [
              {"name": "cash_date"},
              {"name": "warehouse_name"},
              {"name": "cash_nominal"},
              {"name": "coa_name.' '.coa_nomor"},
              {"name": "name1.' '.nomor1"},
              {"name": "name2.' '.nomor2"},
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

</script>
</body>
</html>