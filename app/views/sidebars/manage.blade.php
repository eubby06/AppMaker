@section('sidebarLeft')

 <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @foreach($menu as $item)
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-th-large"></i>
                                <span>{{ $item['app']->name }}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                @foreach($item['modules'] as $module)
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> {{ $module->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

@stop