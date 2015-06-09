@section('content')
 <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{{ Lang::get('backendNotifications.section_title') }}</h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box" id="js-box-body">
                                <div class="box-header">
                                    <h3 class="box-title">{{ Lang::get('backendNotifications.table_title') }}</h3>
                                </div><!-- /.box-header -->

                                    @if(Session::has('message'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4>{{ Session::get('message') }}</h4>
                                        </div>
                                    @endif

                                    <div class="box-body">
   
                                        <div class="form-horizontal js-message-box">
                                            <div class="form-group">
                                                    <label class="col-sm-1 control-label">Message:</label>
                                                    <div class="col-sm-11">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control js-input-message" maxlength="140">
                                                            <span class="input-group-addon js-message-counter">0/140</span>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="box-body">

                                        <div class="js-target-box">
                                            <div class="form-horizontal">
                                                <section class="js-target js-target-users">
                                                    {{ Form::hidden('selected', 'device', array('class'=>'js-selected-target')) }}
                                                    {{ Form::hidden('app', $appId, array('class'=>'js-app-id')) }}
                                                    <h4 class="page-header">{{ Form::radio('byGroup','device',true,array('class'=>'js-input-target')) }} All Users</h4>
                                                </section>

                                                <section class="js-target js-target-groups">
                                                    <h4 class="page-header">{{ Form::radio('byGroup','group',false,array('class'=>'js-input-target')) }} by Groups</h4>
                                                    <div class="form-group">
                                                        <label class="col-sm-1 control-label">Groups:</label>
                                                        <div class="col-sm-10">
                                                        {{ Form::select('roles[]', $roles, null, array('class' => 'form-control js-select-roles', 'multiple')) }}
                                                        </div>
                                                    </div>
                                                </section>

                                                <section class="js-target js-target-countries">
                                                    <h4 class="page-header">{{ Form::radio('byGroup','country',false,array('class'=>'js-input-target')) }} by Countries</h4>
                                                    <div class="form-group">
                                                        <label class="col-sm-1 control-label">Countries:</label>
                                                        <div class="col-sm-10">
                                                        {{ Form::select('countries[]', $countries, null, array('class' => 'form-control js-select-countries', 'multiple')) }}
                                                        </div>
                                                    </div>
                                                </section>

                                                <section class="js-target js-target-location">
                                                    <h4 class="page-header">{{ Form::radio('byGroup','location',false,array('class'=>'js-input-target')) }} by Location</h4>
                                                    <div class="form-group">
                                                        <label class="col-sm-1 control-label">Location:</label>
                                                        <div class="col-sm-10"><input type="text" class="form-control" id="map-address"/></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-1 control-label">Map:</label>
                                                        <div class="col-sm-10"><div class="well" id="map" style="width: 760px; height: 300px;"></div></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-1 control-label">Radius:</label>
                                                        <div class="col-sm-2"><input type="text" name="radius" class="form-control js-map-radius" style="width: 80px" id="map-radius"/></div>
                                                        <label class="col-sm-1 control-label">Latitude:</label>
                                                        <div class="col-sm-3"><input type="text" name="latitude" class="form-control js-map-latitude" style="width: 150px" id="map-lat"/></div>
                                                        <label class="col-sm-1 control-label">Longitude:</label>
                                                        <div class="col-sm-3"><input type="text" name="longitude" class="form-control js-map-longitude" style="width: 150px" id="map-lon"/></div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-success btn-md js-submit-btn">Send Notification</button>
                                    </div>

                            </div><!-- /.box -->

                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
@stop