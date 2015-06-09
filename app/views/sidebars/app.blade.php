@section('sidebarLeft')

 <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li>
                            <img src="{{ asset('img/icons/default.jpg') }}" style="width:50px" class="app-icon box" />
                            <h3 class="box-title-spinn text-blue center">
                                {{ $app->name }}
                                <ul class="app-description">
                                    <li>App in progress ...</li>
                                </ul>
                            </h3> 
                        </li>
                        <li>
                            <a href="{{ route('get.apps.dashboard', $app->id) }}">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('get.apps.edit', $app->_id) }}">
                                <i class="fa fa-edit"></i> <span>Edit App</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-cogs"></i> <span>Manage</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                @foreach($app->manageableModules() as $module)
                                <li><a href="{{ route('get.module.'. camel_case($module->name) .'.index', array($app->id)) }}"><i class="fa fa-angle-double-right"></i> {{ $module->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('get.apps.notifications', $app->_id) }}">
                                <i class="fa fa-bullhorn"></i> <span>Push Notifications</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

@stop