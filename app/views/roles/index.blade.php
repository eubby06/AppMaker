@section('content')
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>

                        {{ Lang::get('backendRoles.section_title') }}
                        <small>create a new role <a class="js-create-app-button" href="{{ route('get.roles.create') }}"><i class="fa fa-plus-square-o"></i> New Role</a></small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{{ Lang::get('backendRoles.table_title') }}</h3>
                                </div><!-- /.box-header -->

                                    @if(Session::has('message'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4>{{ Session::get('message') }}</h4>
                                        </div>
                                    @endif

                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><a href="{{ sortableUrl('roles','name') }}">Role Name</a><span class="caret caret-{{ showCaret('first_name') }}"></span></th>
                                                <th>Merchant</th>
                                                <th>Application</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($roles) > 0)
                                            @foreach ($roles as $role)
                                                <tr>
                                                    <td>{{ $role->name }}</td>
                                                    <td>{{ $role->merchant_id ? $role->merchant->fullname() : '-' }}</td>
                                                    <td>{{ $role->app_id ? $role->app->name : '-' }}</td>
                                                    <td>{{ $role->type }}</td>
                                                    <td>
                                                        <!-- default and admin roles are not meant to be changed -->
                                                        <?php $enabled = ($role->type != 'default' AND $role->type != 'admin') ? true : false; ?>
                                                        <a href="{{ route('get.roles.edit', $role->_id) }}" class="btn btn-primary btn-xs {{ $enabled ?: 'disabled' }}"><i class="fa fa-fw fa-edit"></i>{{ Lang::get('backendRoles.icon_edit') }}</a>
                                                        <a href="#" data-url="{{ !$enabled ?: route('get.roles.delete', $role->_id) }}" class="btn btn-danger btn-xs {{ $enabled ?: 'disabled' }}" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-fw fa-times-circle-o"></i>{{ Lang::get('backendRoles.icon_delete') }}</a>
                                                        <a href="{{ route('get.permissions.list', array('role' => $role->_id)) }}" class="btn btn-info btn-xs {{ $enabled ?: 'disabled' }}"><i class="fa fa-fw fa-key"></i>{{ Lang::get('backendUsers.icon_permission') }}</a>
                                                        <a href="{{ route('get.roles.users', $role->_id) }}" class="btn btn-success btn-xs"><i class="fa fa-fw fa-user"></i>{{ Lang::get('backendRoles.icon_add_user') }}</a>
                                                        
                                                        
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    {{ $roles->links() }}
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

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

@stop