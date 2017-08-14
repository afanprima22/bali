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
                                <th>id Coa</th>
                                <th>Nama Coa</th>
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
                      <label>
                            <input type="radio" onclick="type_payment(1)" name="i_type" id="inlineRadio1" value="1"> Parent
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(2)" name="i_type" id="inlineRadio2" value="2"> Child
                            </label>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Id COA (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                                               
                        </div>
                        <div class="col-md-6">
                        <div id="credit_card" style="display: none;">
                          <div class="form-group">
                            <label>Nama parent</label>
                            <select class="form-control select2" onchange="nomor(this.value)" name="i_coa" id="i_coa" style="width: 100%;"  value=""></select>
                          </div>
                        </div>
                          <div class="form-group">
                            <label>Nama Coa</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" required="required" placeholder="Masukkan Nama Coa"  value="" >
                          </div>
                          <div class="form-group">
                            <label>Coa nomor</label>
                            <input type="text" class="form-control" onchange="cek(this.value)" name="i_nomor" id="i_nomor" required="required" placeholder="Masukkan Nomor Coa"  value="" >
                          </div>    
                      </div></div>
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
        search_data();
        //search_data_akun(0);
        select_list_coa();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Coa/load_data/'
            },
            "columns": [
              {"name": "coa_id"},
              {"name": "coa_name"},
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
          url  : '<?php echo base_url();?>Coa/action_data/',
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
        $('#i_coa option').remove();
        $('input[name="i_akun_name"]').val("");
      }

    
    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Coa/load_data_where/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
             document.getElementById("i_id").value             = data.val[i].coa_id;
              document.getElementById("i_name").value           = data.val[i].coa_name;
              document.getElementById("i_parent").value           = data.val[i].coa_parent;
              //search_data_akun(data.val[i].coa_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }
    function select_list_coa() {
        $('#i_coa').select2({
          placeholder: 'Pilih Coa',
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

      function type_payment(id){

      if (id == 2) {
        document.getElementById('credit_card').style.display = 'block';
      }else{
        document.getElementById('credit_card').style.display = 'none';
      }
    }
    function nomor(id){
      $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Coa/load_data_nomor/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_nomor").value           = data.val[i].coa_nomor;
            }
          }
        });
    }

    function cek(id) { 
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Coa/load_data_cek/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              var nomor = document.getElementById("i_nomor").value;
              if (nomor==data.val[i].coa_nomor) {
                alert("akun sudah ada");
              };
            }
          }
        });
    }
</script>
</body>
</html>