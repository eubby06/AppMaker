@section('content')
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>

                        {{ Lang::get('backendPermissions.section_title') }}
                        <small>create a new role <a class="js-create-app-button" href="{{ route('get.roles.create') }}"><i class="fa fa-plus-square-o"></i> New User</a></small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{{ Lang::get('backendPermissions.table_role_title') }}
                                        - <b>{{ $role->name }}</b></h3>
                                </div><!-- /.box-header -->
                                {{ Form::open( array('route' => 'post.permissions.assign') )}}
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Applications</th>
                                                <th>{{ $role->type == 'manage' ? 'Backend Modules' : 'Frontend Modules'}}</th>
                                                <th>{{ $role->type == 'manage' ? 'Manage Permission' : 'Access Permission'}}</th>
                                                <th>Privileges</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @foreach($data as $item)
                            
                                                    @foreach($item['modules'] as $module)
                                                    <tr>
                                                        <td>{{ $item['app']->name }}</td>
                                                        <td>{{ $module->name }}</td>
                                                        {{ Form::hidden('role', $role->id) }}
                                                        <td>
                                                            {{ Form::checkbox('modules[]', $module->_id, $role->hasAccessAndManagePermission($module->_id), array('class' => 'js-permission-allow')) }}<i>&nbsp;&nbsp;Allow</i>
                                                        </td>
                                                        <td>
                                                            @if($privileges = getModulePrivileges($module->name, $role->type))

                                                                <ul class="form-group js-privileges-container" style="display:{{ !$role->hasAccessAndManagePermission($module->_id) ? 'none' : 'block' }}">
                                                                {{ Form::select('privileges[]', $privileges, $role->privileges, array('class' => 'form-control js-select-privileges', 'multiple')) }}
                                                                </ul>

                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                            @endforeach   

                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                                        <a href="{{ route('get.roles.list') }}" class="btn btn-default btn-md">Cancel</a>
                                </div>
                                {{ Form::close() }}   
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

@stop