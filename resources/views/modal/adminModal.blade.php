<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> Change Admin Password </h4>
      </div>
      <div class="modal-body">

<form class="form default-label" role="form" method="POST" action="{{ url('/newpassadmin') }}">
        {!! csrf_field() !!}
        <input type="hidden" class="form-control" id="id" name="id">
          <div class="form-group">
              <input type="text" class="form-control" id="username" name="username">
              <label for="username">NIP</label>
          @if ($errors->has('username'))
              <p class="help-blockleft">
                <strong>{{ $errors->first('username') }}</strong>
              </p>
          @endif
          </div>

          <div class="form-group">
              <input type="text" class="form-control" id="name" name="name">
              <label for="name">Name</label>
          @if ($errors->has('name'))
              <p class="help-blockleft">
                  <strong>{{ $errors->first('name') }}</strong>
              </p>
          @endif
          </div>

          <div class="form-group">
              <input type="email" class="form-control" id="email" name="email">
              <label for="email">Email</label>
          @if ($errors->has('email'))
              <p class="help-blockleft">
                <strong>{{ $errors->first('email') }}</strong>
              </p>
          @endif
          </div>

          <div class="form-group">
              <input type="text" class="form-control" id="password" name="password">
              <label for="password">Password</label>
              <p class="help-blockleft">
                <strong>Panjang Password minimal 6 karakter</strong>
              </p>
          </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
</form>
    </div>
  </div>
</div>