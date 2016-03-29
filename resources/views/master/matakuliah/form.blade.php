<div class="form-group">
	<label class="col-sm-2 control-label">Kode Matakuliah</label>
	<div class="col-sm-10">
		{!! Form::text('kode_matakuliah', null, ['class' => 'form-control input-lg']) !!}
		<div class="form-control-line"></div>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">Nama Matakuliah</label>
	<div class="col-sm-10">
		{!! Form::text('nama_matakuliah', null, ['class' => 'form-control input-lg']) !!}
		<div class="form-control-line"></div>
	</div>
</div> 

<div class="form-group">
	<label class="col-sm-2 control-label">SKS</label>
	<div class="col-sm-10">
		{!! Form::text('sks', null, ['class' => 'form-control input-lg']) !!}
		<div class="form-control-line"></div>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">Status</label>
	<div class="col-sm-9">
		<label class="radio-inline radio-styled radio-success">
			{!! Form::radio('recstatus', '1', ($matakuliah->recstatus == "1" ? true : false)) !!}<span>Active</span>
		</label>
		<label class="radio-inline radio-styled radio-danger">
			{!! Form::radio('recstatus', '0', ($matakuliah->recstatus == "0" ? true : false)) !!}<span>Non Active</span>
		</label>
	</div>
</div>

<br><br>
<div class="form-group" align="center">
	{!! Form::submit($SubmitButtonText, ['class' => 'btn btn-primary']) !!}
</div>