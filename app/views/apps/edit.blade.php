@section('content')

 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Editing {{ $app->name }} App
                        <small>save your changes <a class="js-save-app-styles" href="{{ route('get.apps.list') }}"><i class="fa fa-plus-square-o"></i> Save Changes</a></small>
                    </h1>
                </section>

               <!-- Main content -->
                <section id="main-content" class="content">

                    <!-- row column -->
                    <div class="row">
                        {{ Form::open(array('route' => array('post.apps.edit', $app->_id),'role' => 'form')) }}
                        <!-- left column -->
                        <div class="col-md-4">
                            
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
                                            <label for="name">App Name</label>
                                            <input type="text" name="name" class="form-control" id="name" value="{{ $app->name }}" placeholder="Enter App Name">
                                        </div>
                                        <div class="form-group {{ $errors->first('merchant_id') ? 'has-error' : '' }}">
                                            <label>Merchant</label>
                                            {{ Form::select('merchant_id', $merchants, $app->merchant_id, array('class' => 'form-control')
                                            ) }}
                                        </div>
                                        <div class="form-group {{ $errors->first('protected') ? 'has-error' : '' }}">
                                            <label>Protected</label>
                                            {{ Form::select('protected', array('1'=>'Yes','0'=>'No'), $app->protected, array('class' => 'form-control')
                                            ) }}
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                        <a href="{{ route('get.apps.list') }}" class="btn btn-default btn-md">Cancel</a>
                                    </div>
                               
                        </div><!--/.col (right) -->

                        <div class="col-md-4">
                                <div class="box-body">
                                    <div class="form-group {{ $errors->first('module_ids') ? 'has-error' : '' }}">
                                        <label style="display:block">Select Modules</label>
                                        {{ Form::select('modules', $modules, null, array('class' => 'form-control js-select-modules')
                                        ) }}
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Page Name</label>
                                        <input type="text" name="pageName" class="form-control js-page-name" placeholder="Enter Page Name">
                                    </div>
                                    <a href="#" class="btn js-btn-add btn-warning btn-xs" data-toggle="modal" data-target="#rename-page">Add <i class="fa fa-fw fa-arrow-circle-o-right"></i></a>
                                </div><!-- /.box-body -->
                        </div>

                        <div class="col-md-4">
                            <div class="box-body">
                                    <div class="form-group {{ $errors->first('page_ids') ? 'has-error' : '' }}">
                                        <label style="display:block">My Pages</label>
                                        <select name="page_ids[]" class="form-control js-select-pages" multiple>
                                            @foreach($pages as $page)
                                            <option value="{{ $page->id }}-{{ $page->name }}" selected>{{ $page->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div><!-- /.box-body -->
                            <a href="JavaScript:void(0);" class="btn btn-warning btn-xs js-btn-remove"><i class="fa fa-fw fa-arrow-circle-o-left"></i> Remove</a>
                        </div>

                        
                        {{ Form::close() }}
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

@stop