@section('content')

 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
 
               <!-- Main content -->
                <section class="content">
               
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">{{ Lang::get('backendUsers.create_new_user_title') }}</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->

                                {{ Form::open( array('route' => 'post.users.create', 'role' => 'form') ) }}
                                    <div class="box-body" id="js-box-body">

                                        @if($errors->any())
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Oops! Please provide valid inputs.</strong>
                                                <ul>
                                                @foreach($errors->all() as $error)
                                                    <li>{{$error}}</li>
                                                @endforeach
                                                </ul>
                                        </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group {{ $errors->first('first_name') ? 'has-error' : '' }}">
                                                    <label>First Name</label>
                                                    <input type="text" name="first_name" class="form-control" value="{{ Input::old('first_name') }}" placeholder="Enter First Name">
                                                </div>
                                                <div class="form-group {{ $errors->first('last_name') ? 'has-error' : '' }}">
                                                    <label>Last Name</label>
                                                    <input type="text" name="last_name" class="form-control" value="{{ Input::old('last_name') }}" placeholder="Enter Last Name">
                                                </div>
                                                <div class="form-group {{ $errors->first('company') ? 'has-error' : '' }}">
                                                    <label>Company</label>
                                                    <input type="text" name="company" class="form-control" value="{{ Input::old('company') }}" placeholder="Enter Company">
                                                </div>
                                                <div class="form-group {{ $errors->first('email') ? 'has-error' : '' }}">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ Input::old('email') }}" placeholder="Enter Email">
                                                </div>
                                                <div class="form-group {{ $errors->first('password') ? 'has-error' : '' }}">
                                                    <label>Password</label>
                                                    <input type="password" name="password" value="{{ Input::old('password') }}" class="form-control" >
                                                </div>
                                                <div class="form-group {{ $errors->first('password_confirmation') ? 'has-error' : '' }}">
                                                    <label>Confirm Password</label>
                                                    <input type="password" name="password_confirmation" value="{{ Input::old('password') }}" class="form-control" >
                                                </div>
                                                <div class="form-group {{ $errors->first('mobile') ? 'has-error' : '' }}">
                                                    <label>Mobile No.</label>
                                                    <input type="text" name="mobile" class="form-control" value="{{ Input::old('mobile') }}" placeholder="Enter Mobile No">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {{ $errors->first('merchant_id') ? 'has-error' : '' }}">
                                                    <label>Merchant</label>
                                                    <?php $merchant = $currentUser ? $currentUser->id : Input::old('merchant_id'); ?>
                                                    {{ Form::select('merchant_id', $merchants, $merchant, array('class' => 'form-control js-select-merchant')
                                                    ) }}
                                                </div>
                                                <div class="form-group {{ $errors->first('gender') ? 'has-error' : '' }}">
                                                    <label>Gender</label>
                                                    {{ Form::select('gender', 
                                                        array(
                                                            ''          => 'Please select...',
                                                            'male'      => 'Male', 
                                                            'female'    => 'Female'
                                                        ), Input::old('gender'), array('class' => 'form-control')
                                                    ) }}
                                                </div>
                                                <div class="form-group {{ $errors->first('status') ? 'has-error' : '' }}">
                                                    <label>Status</label>
                                                    {{ Form::select('status', 
                                                        array(
                                                            'unactivated'       => 'Unactivated',
                                                            'activated'         => 'Activated', 
                                                            'banned'            => 'Banned'
                                                        ), Input::old('status'), array('class' => 'form-control')
                                                    ) }}
                                                </div>
         										<div class="form-group {{ $errors->first('type') ? 'has-error' : '' }}">
                                                    <label>User Type</label>
                                                    {{ Form::select('type', $types, Input::old('type'), array('class' => 'form-control js-select-type')
                                                    ) }}
                                                </div>
                                                <div class="form-group {{ $errors->first('role_ids') ? 'has-error' : '' }}">
                                                    <label>User Role</label>
                                                    {{ Form::select('role_ids[]', $roles, Input::old('role_ids'), array('class' => 'form-control js-select-role', 'multiple')
                                                    ) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                    
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                        <a href="{{ route('get.users.list') }}" class="btn btn-default btn-md">Cancel</a>
                                    </div>
                                {{ Form::close() }}
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

@stop