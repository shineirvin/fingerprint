<script src="{!! url('assets/js/vue.min.js')!!}"></script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> Change Mahasiswa Password </h4>
      </div>
      <div class="modal-body">

        <form class="form default-label" role="form" method="POST" action="{{ url('/newpassmahasiswa') }}" id="vue">
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

            <div class="form-group @{{ message.length < 6 ? ' has-error' : '' }}" id="vue" >
                <input type="text" class="form-control" id="password" v-model="message" name="password">
                <label for="password">Password</label>
                <p class="help-blockleft">
                  <strong v-if="message.length < 6" style="color:red"> Panjang Password minimal 6 karakter </strong>
                  <strong v-else>Berhasil</strong>
                </p>
            </div>



        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" :disabled="message.length < 6">Save changes</button>
        </div>
        </form>
    </div>
  </div>
</div>
</div>

<script>
  new Vue({
          el: '#vue',

          data: {
            message: ''
          }
        });
</script>