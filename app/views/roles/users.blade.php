@section('content')
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>

                        {{ Lang::get('backendRoles.section_title') }}
                        <small>add new user to this role <a class="js-create-app-button" href="#" data-toggle="modal" data-target="#add-user"><i class="fa fa-plus-square-o"></i> Add User</a></small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"><b>{{ $role->name }}</b> {{ Lang::get('backendRoles.table_user_title') }}</h3>
                                </div><!-- /.box-header -->

                                    @if(Session::has('message'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4>{{ Session::get('message') }}</h4>
                                        </div>
                                    @endif

                            {{ Form::open(array('route' => 'post.roles.remove.user')) }}
                                <div class="box-body table-responsive">
                                    <div class="form-group">
                                        <button type="submit" value="remove" class="btn btn-danger"><i class="fa fa-fw fa-times-circle-o"></i> Remove Selected</button>
                                    </div> 

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th><a href="{{ sortableUrl('users','first_name') }}">First Name</a><span class="caret caret-{{ showCaret('first_name') }}"></span></th>
                                                <th><a href="{{ sortableUrl('users','last_name') }}">Last Name</a><span class="caret caret-{{ showCaret('last_name') }}"></span></th>
                                                <th><a href="{{ sortableUrl('users','company') }}">Company</a><span class="caret caret-{{ showCaret('company') }}"></span></th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ Form::checkbox('users[]', $user->id) }}</td>
                                                {{ Form::hidden('role', $role->id) }}
                                                <td>{{ $user->first_name }}</td>
                                                <td>{{ $user->last_name }}</td>
                                                <td>{{ $user->company }}</td>
                                                <td>
                                                    <?php $enabled = ($role->type != 'admin') ?: 'disabled'; ?>
                                                    <a href="#" data-url="{{ route('get.roles.remove.user', array('role' => $role->id, 'user' => $user->_id)) }}" class="btn btn-danger btn-xs js-delete-user {{ $enabled }}" data-toggle="modal" data-target="#confirm-remove"><i class="fa fa-fw fa-times-circle-o"></i>{{ Lang::get('backendRoles.icon_remove') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ is_array($users) ? '' : $users->links() }}
                                </div><!-- /.box-body -->
                            {{ Form::close() }}

                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

            <!-- delete confirmation -->
            <div class="modal fade" id="confirm-remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Confirm Removal</h4>
                        </div>
                    
                        <div class="modal-body">
                            <p>You are about to remove this user from the group.</p>
                            <p>Do you want to proceed?</p>
                            <p class="debug-url"></p>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-danger btn-ok">Remove</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- delete confirmation -->
            <div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {{ Form::open( array('route' => 'post.roles.add.user') ) }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Add User To This Role</h4>
                        </div>
                    
                        <div class="modal-body">
                            
                            <div class="form-group">
                                <label>Select User</label>
                                {{ Form::select('user', $filteredUsers, null, array('class' => 'form-control js-select-merchant')
                                ) }}
                                {{ Form::hidden('role', $role->id) }}
                            </div>
                            
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Add Selected User</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
@stop