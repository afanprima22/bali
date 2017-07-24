<div class="box-inner">
<div class="row">
	<div class="col-md-8">
		<div class="box-inner">
			<div class="box-content">
	            <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
	                <thead>
	                    <tr>
	                        <th>Nama Sub Class Item</th>
	                        <th>Nama Class Item</th>
	                        <th>Config</th>
	                    </tr>
	                </thead>
	            </table>
	        </div>
        </div>
	</div>
	<div class="col-md-4">
		
			<form id="formsub" role="form" action="" method="post" enctype="multipart/form-data">
				<div class="box-content">
					<div class="form-group">
                        <label>Id Sub Class Item (Auto)</label>
                        <input type="text" class="form-control" name="i_id_sub" id="i_id_sub" placeholder="Auto" value="" readonly="">
                    </div>
                    <div class="form-group">
                        <label>Nama Sub Class Item</label>
                        <input type="text" class="form-control" name="i_name_sub" id="i_name_sub" placeholder="Masukkan Nama Class Item" required="required" value="">
                    </div>
                    <div class="form-group">
                        <label>Nama Sub Class Item</label>
                        <select class="form-control select2" name="i_class_sub" id="i_class_sub" style="width: 100%;" required="required">
                        </select>
                    </div>
                    <div class="box-footer text-right">
                        <button type="button" onclick="reset3()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                    </div>
				</div>
			</form>
		
	</div>
</div>
</div>