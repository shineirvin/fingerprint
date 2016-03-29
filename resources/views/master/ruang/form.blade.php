<div class="form-group">
	<label class="col-sm-2 control-label">Nama Ruang</label>
	<div class="col-sm-10">
		{!! Form::text('nama_ruang', null, ['class' => 'form-control input-lg']) !!}
		<div class="form-control-line"></div>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">Kapasitas</label>
	<div class="col-sm-10">
		{!! Form::text('kapasitas', null, ['class' => 'form-control input-lg']) !!}
		<div class="form-control-line"></div>
	</div>
</div> 

<div class="form-group">
	<label class="col-sm-2 control-label">Jenis Ruang</label>
	<div class="col-sm-10">
		{!! Form::select('jenisruang_id', $jenisruang, $ruang->jenisruang_id,  array('class'=>'form-control input-lg')) !!}
		<div class="form-control-line"></div>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">Status</label>
	<div class="col-sm-9">
		<label class="radio-inline radio-styled radio-success">
			{!! Form::radio('recstatus', '1', ($ruang->recstatus == "1" ? true : false)) !!}<span>Active</span>
		</label>
		<label class="radio-inline radio-styled radio-danger">
			{!! Form::radio('recstatus', '0', ($ruang->recstatus == "0" ? true : false)) !!}<span>Non Active</span>
		</label>
	</div>
</div>

<br><br>
<div class="form-group" align="center">
	{!! Form::submit($SubmitButtonText, ['class' => 'btn btn-primary']) !!}
</div>