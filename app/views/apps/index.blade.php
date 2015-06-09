@section('content')
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Applications
                        <small>create a new application <a class="js-create-app-button" href="{{ route('get.apps.create') }}"><i class="fa fa-plus-square-o"></i> New App</a></small>
                    </h1>

                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="js-modal-container"></div>
                    
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4>{{ Session::get('message') }}</h4>
                        </div>
                    @endif

                	@foreach($apps as $app)
                  
                        <div class="col-md-6">
                            <div class="box box-solid">
                                <div class="box-header">
                                	<img src="{{ asset('img/icons/default.jpg') }}" class="app-icon box" />
                            	    <h3 class="box-title-spinn text-blue center">
                            			{{ $app->name }}
                        				<ul class="app-description">
                            				<li>{{ $app->merchant->first_name }} {{ $app->merchant->last_name }} - {{ $app->merchant->company }}</li>
                            				<li>{} installs </li>
                            				<li>created at {}</li>
                        				</ul>
                            		</h3>  	
                                </div><!-- /.box-header -->
                                <div class="box-body text-center">
                                    <div class="sparkline" data-type="line" data-spot-Radius="3" data-highlight-Spot-Color="#f39c12" data-highlight-Line-Color="#222" data-min-Spot-Color="#f56954" data-max-Spot-Color="#00a65a" data-spot-Color="#39CCCC" data-offset="90" data-width="100%" data-height="100px" data-line-Width='2' data-line-Color='#39CCCC' data-fill-Color='rgba(57, 204, 204, 0.08)'>
                                        <i class="fa fa-dashboard"></i> <a href="{{ route('get.apps.dashboard', $app->_id) }}">Dashboard</a> &nbsp;|&nbsp;
                                        <i class="fa fa-edit"></i> <a href="{{ route('get.apps.edit', $app->_id) }}">Edit</a> &nbsp;|&nbsp;
                                        <i class="fa fa-bar-chart-o"></i> <a href="#">Analytics</a> &nbsp;|&nbsp;
                                        <i class="fa fa-bullhorn"></i> <a href="{{ route('get.apps.notifications', $app->_id) }}">Notifications</a> &nbsp;|&nbsp;
                                        <i class="fa fa-times"></i> <a href="#">Delete</a> 
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    @endforeach

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

            

            <script id="js-create-app-template" type="text/x-handlebars-template">
            <div class="modal fade js-create-app-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create New App</h4>
                      </div>
                      <div class="modal-body">

                        <!-- general form elements -->
                        <div class="box box-primary">
                            <!-- form start -->
                            {{ Form::open(array('route' => 'get.apps.create','role' => 'form')) }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="appName">App Name</label>
                                        <input type="text" name="appName" class="form-control js-input-app-name" placeholder="Enter App Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Select Type</label>
                                        <select name="appType" class="form-control js-input-app-type" >
                                            <option value="business">Business</option>
                                            <option value="blog">Blog</option>
                                            <option value="restaurant">Restaurant</option>
                                            <option value="events">Events</option>
                                            <option value="photography">Photography</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="appFacebook">Grab Facebook Content</label>
                                        <input type="text" name="appFacebook" class="form-control js-input-app-facebook" placeholder="Enter Facebook Account">
                                    </div>
                                </div><!-- /.box-body -->
                            {{ Form::close() }}
                        </div><!-- /.box -->

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary js-create-app-submit">Save changes</button>
                      </div>
                    </div>
                  </div>
            </div>
            </script>

@stop