<div class="box-inner">
<div class="row">
	<div class="col-md-8">
		<div class="box-inner">
			<div class="box-content">
	            <table width="100%" id="table1" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
	                <thead>
	                    <tr>
	                        <th>Nama Class Item</th>
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
                        <label>Nama Class Item</label>
                        <input type="text" class="form-control" name="i_name_class" id="i_name_class" placeholder="Masukkan Nama Class Item" required="required" value="">
                        <input type="hidden" class="form-control" name="i_id_class" id="i_id_class" placeholder="Auto" value="" readonly="">
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