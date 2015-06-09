@section('content')
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {{ Lang::get('form::backend.section_title') }}
                      </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{{ Lang::get('form::backend.table_title') }}</h3>
                                </div><!-- /.box-header -->

                                    @if(Session::has('message'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4>{{ Session::get('message') }}</h4>
                                        </div>
                                    @endif

                                <div class="box-body table-responsive">
                                    {{ Form::open(array('route' => array('post.module.form.index', $app->id), 'method' => 'post', 'role' => 'form')) }}
                                	<div class="row">
	                                	<div class="col-md-7">
											<div class="form-group">
		                                        <div class="input-group input-group-sm">
		                                            <div class="input-group-addon">
		                                            	<i class="fa fa-calendar"></i> &nbsp; Date Range
		                                            </div>
		                                            <input type="text" name="range" class="form-control pull-right" id="js-form-range"/>
		                                        </div><!-- /.input group -->
		                                    </div><!-- /.form group -->
	                                	</div>
	                                	<div class="col-md-5">
		                                    <button class="btn btn-primary btn-sm" name="filter" value="1" /><i class="fa fa-list-ol"></i> Filter Results
                                            <button class="btn btn-success btn-sm" name="export" value="1" /><i class="fa fa-file-text"></i> Export CSV
                                            <button class="btn btn-danger btn-sm" name="delete" value="1" /><i class="fa fa-times-circle-o"></i> Delete Selected
                                        </div>
	                                	
	                                </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Date Sent</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $item)
                                                <tr>
                                                    <td>{{ Form::checkbox('ids[]', $item->id) }}</td>
                                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ str_limit($item->message, $limit = 100, $end = '...') }}</td>
                                                    <td>  
                                                        <a href="#" class="btn btn-primary btn-xs js-item-view">
                                                            <i class="fa fa-fw fa-search"></i>{{ Lang::get('form::backend.icon_view') }}
                                                        </a>
                                                        <a href="#" data-url="{{ route('get.module.form.delete', array($item->app_id,$item->id)) }}" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#confirm-delete">
                                                            <i class="fa fa-fw fa-times-circle-o"></i>{{ Lang::get('form::backend.icon_delete') }}
                                                        </a>
                                                        
                                                    </td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ Form::close() }}
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                    <!-- delete confirmation -->
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Confirm Removal</h4>
                                </div>
                            
                                <div class="modal-body">
                                    <p>You are about to delete this role, this procedure is irreversible.</p>
                                    <p>Do you want to proceed?</p>
                                    <p class="debug-url"></p>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <a class="btn btn-danger btn-ok">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- view modal -->
                    <div class="modal fade" id="js-view-item-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Form Data</h4>
                                </div>
                            
                                <div class="modal-body">
                                    <div class="input-group">
                                        <span class="input-group-addon">key</span>
                                        <input class="form-control" value="value" disabled type="text">
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <a class="btn btn-danger btn-ok">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

@stop