@section('content')
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Modules
                        <small>register a new module <a href="{{ route('get.modules.create') }}"><i class="fa fa-plus-square-o"></i> New Module</a></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Blank page</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4>{{ Session::get('message') }}</h4>
                        </div>
                    @endif
                	@foreach($modules as $module)
                        <div class="col-md-4">
                            <div class="box box-solid">
                                <div class="box-header">
                                	<img src="{{ asset('img/icons/default.jpg') }}" class="app-icon box" />
                            	    <h3 class="box-title-spinn text-blue center">
                            			{{ $module->name }}
                            		</h3>  	
                                </div><!-- /.box-header -->
                                <div class="box-body text-center">
                                    <div class="sparkline" data-type="line" data-spot-Radius="3" data-highlight-Spot-Color="#f39c12" data-highlight-Line-Color="#222" data-min-Spot-Color="#f56954" data-max-Spot-Color="#00a65a" data-spot-Color="#39CCCC" data-offset="90" data-width="100%" data-height="100px" data-line-Width='2' data-line-Color='#39CCCC' data-fill-Color='rgba(57, 204, 204, 0.08)'>
                                        <a href="{{ route('get.modules.edit', $module->_id) }}"><i class="fa fa-edit"></i> Edit</button></a> &nbsp;|&nbsp;
                                        <i class="fa fa-bar-chart-o"></i> Analytics</button> &nbsp;|&nbsp;
                                        <i class="fa fa-times"></i> Delete</button> 
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    @endforeach

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
@stop