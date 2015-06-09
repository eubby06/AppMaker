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
                                    <h3 class="box-title">Edit Role</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                {{ Form::open(array('route' => array('post.roles.edit', $role->_id),'role' => 'form')) }}
                                    <div class="box-body">

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

                                        <div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">
                                            <label for="name">Role Name</label>
                                            <input type="text" name="name" class="form-control" id="name" value="{{ $role->name }}" placeholder="Enter Module Name">
                                        </div>
                                        <div class="form-group {{ $errors->first('type') ? 'has-error' : '' }}">
                                            <label>Type</label>
                                            {{ Form::select('type', array('access'=>'Access','manage'=>'Manage'), $role->type, array('class' => 'form-control')
                                            ) }}
                                        </div>
                                        <div class="form-group {{ $errors->first('merchant_id') ? 'has-error' : '' }}">
                                            <label>Merchant</label>
                                            {{ Form::select('merchant_id', $merchants, $role->merchant_id, array('class' => 'form-control')
                                            ) }}
                                        </div>
                                        <div class="form-group {{ $errors->first('app_id') ? 'has-error' : '' }}">
                                            <label>Application</label>
                                            {{ Form::select('app_id', $apps, $role->app_id, array('class' => 'form-control')
                                            ) }}
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                        <a href="{{ route('get.roles.list') }}" class="btn btn-default btn-md">Cancel</a>
                                    </div>
                                {{ Form::close() }}
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

@stop