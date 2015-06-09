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
                                    <h3 class="box-title">Register New Module</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                {{ Form::open(array('route' => 'get.modules.create','role' => 'form')) }}
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
                                            <label for="name">Module Name</label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Module Name">
                                        </div>
                                        <div class="form-group {{ $errors->first('protected') ? 'has-error' : '' }}">
                                            <label>Protected</label>
                                            {{ Form::select('protected', array('1'=>'Yes','0'=>'No'), Input::old('protected'), array('class' => 'form-control')
                                            ) }}
                                        </div>
                                        <div class="form-group {{ $errors->first('manageable') ? 'has-error' : '' }}">
                                            <label>Manageable</label>
                                            {{ Form::select('manageable', array('0'=>'No','1'=>'Yes'), Input::old('manageable'), array('class' => 'form-control')
                                            ) }}
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                {{ Form::close() }}
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

@stop