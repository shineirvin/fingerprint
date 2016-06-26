@extends('layouts.app1')

@section('content')

<div id="content">
	<section>
		<div class="section-header">
			<h2 class="text-primary">Pengaturan Batas Pertemuan</h2>
		</div>
		<div class="section-body">
			<div class="card">
				<div class="card-body">
				@if (count($errors) > 0)
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
					{!! Form::model($kelasmk, ['method' => 'PATCH', 'url' => 'registerbatashadir', 'class' => 'form-horizontal']) !!}
					<input type="hidden" name="_method" value="patch">
						<input type="hidden" value="{!! $kelasmk->id !!}" name="kelasmk_id">
						<div class="row">
							<div class="form-group">
								<label class="col-sm-2 control-label">Nama Dosen</label>
								<div class="col-sm-7">
									{!! Form::text('namadosen', $kelasmk->DosenName().' ('.$kelasmk->dosen_id.')', ['class' => 'form-control input-lg', 'readonly' => 'readonly']	) !!}
									<div class="form-control-line"></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label class="col-sm-2 control-label">Kode Matakuliah</label>
								<div class="col-sm-2">
									{!! Form::text('matakuliah_id', $kelasmk->matakuliah_id, ['class' => 'form-control input-lg', 'readonly' => 'readonly']) !!}
									<div class="form-control-line"></div>
								</div>

								<label class="col-sm-1 control-label">Semester</label>
								<div class="col-sm-2">
									{!! Form::text('semester', substr($kelasmk->semester, 0, 4). ' ' . (substr($kelasmk->semester, 4, 5) == '1' ? 'GANJIL' : 'GENAP'), ['class' => 'form-control input-lg', 'readonly' => 'readonly']) !!}
									<div class="form-control-line"></div>
								</div>

								<label class="col-sm-1 control-label">Kelas</label>
								<div class="col-sm-1">
									{!! Form::text('kelas', $kelasmk->kelas, ['class' => 'form-control input-lg', 'readonly' => 'readonly']	) !!}
									<div class="form-control-line"></div>
								</div>

							</div> 
						</div>

						<div class="row">
							<div class="form-group">
								<label class="col-sm-2 control-label">Ruang</label>
								<div class="col-sm-1">
									{!! Form::text('old_ruang_id', $kelasmk->NamaRuang(), ['class' => 'form-control input-lg', 'readonly' => 'readonly']) !!}
									<div class="form-control-line"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Hari</label>
								<div class="col-sm-1">
									{!! Form::text('old_hari_id', $kelasmk->NamaHari(), ['class' => 'form-control input-lg', 'readonly' => 'readonly']	) !!}
									<div class="form-control-line"></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label class="col-sm-2 control-label">Waktu</label>
								<div class="col-sm-2">
									{!! Form::text('old_waktu', substr($kelasmk->waktu, 0, 5), ['class' => 'form-control input-lg', 'readonly' => 'readonly']) !!}
									<div class="form-control-line"></div>
								</div>
							</div>
						</div>

<hr class="ruler-xxl"/>

						<div class="row">
							<div class="form-group">
								<label class="col-sm-2 control-label">Batas Pertemuan</label>
								<div class="col-sm-1">
									{!! Form::text('batashadir', $kelasmk->batashadir, ['class' => 'form-control input-lg', 'readonly' => 'readonly']) !!}
									<div class="form-control-line"></div>
								</div>
								<label class="col-sm-2 control-label"><i class="fa fa-arrow-right"></i> Batas Pertemuan</label>
								<div class="col-sm-1">
										{!! Form::text('batashadir', $kelasmk->batashadir, ['class' => 'form-control input-lg']) !!}
									<div class="form-control-line"></div>
								</div>
							</div>	
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-9">
								<label class="radio-inline radio-styled radio-success">
									{!! Form::radio('recstatus', '1', ($kelasmk->recstatus == "1" ? true : false)) !!}<span>Active</span>
								</label>
								<label class="radio-inline radio-styled radio-danger">
									{!! Form::radio('recstatus', '0', ($kelasmk->recstatus == "0" ? true : false)) !!}<span>Non Active</span>
								</label>
							</div>
						</div>



						<br><br>
						<div class="card-actionbar">
							<div class="card-actionbar-row">
								<button type="submit" class="btn btn-flat btn-primary ink-reaction">Register</button>
							</div>
						</div>

					{!! Form::close() !!}
				</div>
			</div>
		</div><!--end .section-body -->
	</section>
</div><!--end #content-->
<!-- END CONTENT -->
@endsection