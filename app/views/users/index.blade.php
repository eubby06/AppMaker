@section('content')
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>

                        {{ Lang::get('backendUsers.section_title') }}
                        <small>create a new user <a class="js-create-app-button" href="{{ route('get.users.create') }}"><i class="fa fa-plus-square-o"></i> New User</a></small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{{ Lang::get('backendUsers.table_title') }}</h3>
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
                                                <th><a href="{{ sortableUrl('users','created_at') }}">Joined</a><span class="caret caret-{{ showCaret('created_at') }}"></span></th>
                                                <th><a href="{{ sortableUrl('users','first_name') }}">First Name</a><span class="caret caret-{{ showCaret('first_name') }}"></span></th>
                                                <th><a href="{{ sortableUrl('users','last_name') }}">Last Name</a><span class="caret caret-{{ showCaret('last_name') }}"></span></th>
                                                <th><a href="{{ sortableUrl('users','company') }}">Company</a><span class="caret caret-{{ showCaret('company') }}"></span></th>
                                                <th>Type</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $user->first_name }}</td>
                                                <td>{{ $user->last_name }}</td>
                                                <td>{{ $user->company }}</td>
                                                <td>{{ $user->type }}</td>
                                                <td>{{ buttonizeRoles($user->getRoles()) }}</td>
                                                <td>
                                                    <a href="{{ route('get.users.edit', $user->_id) }}" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-edit"></i>{{ Lang::get('backendUsers.icon_edit') }}</a>
                                                    <a href="#" data-url="{{ route('get.users.delete', $user->_id) }}" class="btn btn-danger btn-xs js-delete-user" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-fw fa-times-circle-o"></i>{{ Lang::get('backendUsers.icon_delete') }}</a>
                                          
                                                <?php $enabled = (!$user->isSuper() AND !$user->isAdmin()) ?: 'disabled'; ?>
                                                    <a href="{{ route('get.permissions.list', array('user' => $user->_id)) }}" class="btn btn-info btn-xs {{ $enabled }}"><i class="fa fa-fw fa-key"></i>{{ Lang::get('backendUsers.icon_permission') }}</a>
                                               
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ $users->links() }}
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

            <!-- delete confirmation -->
            <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                        </div>
                    
                        <div class="modal-body">
                            <p>You are about to delete this user, this procedure is irreversible.</p>
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
@stop