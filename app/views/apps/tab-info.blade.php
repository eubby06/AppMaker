{{ Form::open(array('route' => 'get.apps.create','role' => 'form')) }}

<div class="box box-primary app-info">
    <div class="box-header">
        <h3 class="box-title">App Info</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    
        <div class="box-body">

            <div class="row">
                <h4>Navigation Header Bar</h4>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Header Type</label>
                        <select name="appType" class="form-control" >
                            <option value="image">Image</option>
                            <option value="text">Text</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="appName">Text</label>
                        <input type="text" name="appName" class="form-control" id="appName" placeholder="Enter App Name" value="{{ $app->name }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Colors</label>
                    <div class="row">
                        <div class="col-md-6 color"><button class="btn bg-maroon btn-flat"></button> Bckgrnd</div>
                        <div class="col-md-6 color"><button class="btn bg-maroon btn-flat"></button> Text</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <h4>Brand Identity</h4>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>App Icon</label>
                        <input type="file" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Launch Image</label>
                        <input type="file" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="appName">App Name</label>
                        <input type="text" name="appName" class="form-control" id="appName" placeholder="Enter App Name" value="{{ $app->name }}">
                    </div>
                     <div class="form-group">
                        <label for="appName">App Language</label>
                        <select name="appType" class="form-control" >
                            <option value="en">English</option>
                            <option value="ch">Chinese</option>
                        </select>
                    </div>
                </div>
            </div>

        </div><!-- /.box-body -->
</div><!-- /.App Styles Tab -->

{{ Form::close() }}