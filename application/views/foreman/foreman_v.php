<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#form" data-toggle="tab">Form Data</a></li>
      <li><a href="#list" data-toggle="tab">List Data</a></li>
      <li><a href="#list_specifik" data-toggle="tab">List Rak Keluar</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="list">
            <div class="box-inner">
                <div class="box-content">
                    <div id="create" class="alert alert-success" style="display: none;"><h4><i class="glyphicon glyphicon-check"></i> Sukses!</h4>Data telah Disimpan.</div>
                    <div id="update" class="alert alert-info" style="display: none;"><h4><i class="glyphicon glyphicon-info-sign"></i> Sukses!</h4>Data telah Direvisi.</div>
                    <div id="delete" class="alert alert-danger" style="display: none;"><h4><i class="glyphicon glyphicon-ban-circle"></i> Sukses!</h4>Data telah Dihapus.</div>
                    <table width="100%" id="table1" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                        <thead>
                            <tr>
                                <th>Tanggal Proses</th>
                                <th>Nama Mandor</th>
                                <th>Gudang</th>
                                <th>Nomor DO</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                
            </div>

        </div>

        <div class="tab-pane" id="list_specifik">
            <? include('foreman_s.php'); ?>
        </div>

        <div class="tab-pane active" id="form">
            <div class="box-inner">

                <form id="formall" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="box-content">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Kode DO</label>
                            <select class="form-control select2" name="i_code_do" id="i_code_do" style="width: 100%;" onchange="get_detail(this.value)">
                            </select>
                          </div>                         
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nama Mandor : <?=$mandor?></label>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" value="">
                            <input type="hidden" class="form-control" name="i_employee" value="<?=$employee_id?>">
                          </div>
                      </div>
                      <div id="view_detail">
                        <? include('foreman_d.php'); ?>
                      </div>
                        
                    </div>
                      <div class="box-footer text-right">
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
        select_list_do();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Foreman/load_data/'
            },
            "columns": [
              {"name": "foreman_date"},
              {"name": "employee_name"},
              {"name": "warehouse_name"},
              {"name": "delivery_detail_code"},
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
      var mandor = $('input[name="i_employee"]').val();
        if ($("#formall").valid()==true) {
          if (mandor) {
            action_data();
          }else{
            alert("Maaf halaman untuk mandor!");
          }
          
        }
        return false;
      });

    function action_data(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>foreman/action_data/',
          data : $( "#formall" ).serialize(),
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

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>foreman/delete_data',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset2();
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
          url  : '<?php echo base_url();?>foreman/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].foreman_id;

              $("#i_code_do").append('<option value="'+data.val[i].delivery_detail_id+'" selected>'+data.val[i].delivery_detail_code+'</option>');

              $("#view_detail").load("<?= site_url()?>foreman/load_view_detail/"+data.val[i].delivery_detail_id+"/"+ 1);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_do() {
        $('#i_code_do').select2({
          placeholder: 'Pilih Kode DO',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Delivery/load_data_select_do/',
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

      function get_detail(id){
        $("#view_detail").load("<?= site_url()?>foreman/load_view_detail/"+id+"/"+ 1);
      }

      function reset2(){
        $('#i_code_do option').remove();
        $("#view_detail").load("<?= site_url()?>foreman/load_view_detail/"+ 0+"/"+ 1);
      }

      function get_qty(value,qty,id){
        //alert("test");
        if (parseFloat(value) > parseFloat(qty)) {
          alert("Tidak boleh melebihi order!");
          document.getElementById("i_qty"+id).value = qty;
        }
      }

      function specifik_data(id){
        $("#list_specifik").load("<?= site_url()?>foreman/load_view_detail/"+id+"/"+ 2);
        $('[href="#list_specifik"]').tab('show');
      }

      function save_spesifik(){
        //alert("test")
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>foreman/action_data_spesifik/',
          data : $( "#formspesific" ).serialize(),
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
</script>
</body>
</html>