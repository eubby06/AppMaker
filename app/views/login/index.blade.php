@section('content')

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            {{ Form::open(array('route' => 'post.login.index')) }}
                <div class="body bg-gray">

                    @if(Session::has('message'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4>{{ Session::get('message') }}</h4>
                        </div>
                    @endif

                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4>{{ Session::get('success') }}</h4>
                        </div>
                    @endif

                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="E-mail"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" value="1" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-blue btn-block">Sign me in</button>  
                    
                    <p><a href="{{ route('get.users.request', 'password') }}">I forgot my password</a></p>

                </div>
            {{ Form::close() }}

        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>

@stop