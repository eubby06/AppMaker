<!-- general form elements -->
<div id="js-pages-box" class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">My Pages</h3>
    </div><!-- /.box-header -->
   
    @if(!count($pages))
        <div class="box-body js-alert">
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>You have not added any page yet!</b> 
            </div>
        </div>
    @endif

    <div class="box-body">
        <div class="row modules js-app-pages-container">

            @foreach($pages as $page)
            <div class="col-md-2" id="js-page-block-{{ $page->pivot->id }}">
                <div class="small-box bg-teal">
                        <div class="inner text-center">
                            <i class="fa fa-bitbucket"></i>
                            <p class="js-page-name">{{ $page->pageName($page->pivot->id) }}</p>
                        </div>
                        <a data-page-name="{{ str_replace(" ", "_", $page->name) }}" data-page-id="{{ $page->pivot->id }}" class="small-box-footer js-edit-page-button {{ $page->pivot->id }}" href="#"><i class="fa fa-edit"></i></a>
                        <a data-page-name="{{ str_replace(" ", "_", $page->name) }}" data-page-id="{{ $page->pivot->id }}" class="small-box-footer small-box-footer-delete js-delete-page-button {{ $page->pivot->id }}" href="#"><i class="fa fa-times"></i></a>
                </div><!-- /.box -->
            </div><!-- /.col -->
            @endforeach
            
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<!-- page editing section -->
<script id="js-editing-container-template" type="text/x-handlebars-template"></script>
<div id="js-edit-box" class="js-editing-container"></div>

<!-- general form elements -->
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Available Pages</h3>
    </div><!-- /.box-header -->
   
    <div class="box-body">
        <div class="row modules">
            
            @foreach($modules as $module)

            <div class="col-md-2">
                <div class="small-box bg-maroon">
                        <div class="inner text-center">
                            <i class="fa fa-bitbucket"></i>
                            <p>{{ $module->name }}<p>
                        </div>
                       <a data-page="{{ $module->name }}" data-app="{{ $app->id }}" data-module="{{ $module->id }}" class="small-box-footer js-add-page-button" href="#"><i class="fa fa-plus-square-o"></i></a>
                </div><!-- /.box -->
            </div><!-- /.col -->

            @endforeach

        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->