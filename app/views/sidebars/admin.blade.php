@section('sidebarLeft')

 <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- search form -->
                    <form action="{{ route('get.' . $resource . '.list') }}" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-group"></i>
                                <span>User Accounts</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                @foreach($types as $key => $value)
                                <li><a href="{{ route('get.users.list', array('type' => $key)) }}"><i class="fa fa-angle-double-right"></i> {{ $value }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('get.roles.list') }}">
                                <i class="fa fa-key"></i> <span>Roles & Permissions</span>
                            </a>
                        </li>
                        @if(App::make('AccessControl')->getUser()->isSuper())
                        <li>
                            <a href="{{ route('get.modules.list') }}">
                                <i class="fa fa-th"></i> <span>Modules</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('get.apps.list') }}">
                                <i class="fa fa-th-large"></i> <span>Applications</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

@stop