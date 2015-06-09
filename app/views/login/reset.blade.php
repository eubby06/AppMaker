@section('content')

        <div class="form-box" id="login-box">
            <div class="header">Reset Password</div>

            {{ Form::open(array('route' => array('post.users.reset')) )}}
                <div class="body bg-gray">

                    @if(Session::has('message'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4>{{ Session::get('message') }}</h4>
                        </div>
                    @endif

                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="New Password"/>
                        <input type="hidden" name="user" value="{{ $user->id }}"/>
                        <input type="hidden" name="code" value="{{ $code }}"/>
                    </div>    
                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password"/>
                    </div>      
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-blue btn-block">Submit</button>
                </div>
            {{ Form::close() }}

        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>

@stop