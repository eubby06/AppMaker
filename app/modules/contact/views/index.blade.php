@section('module')

{{ Form::open(array('id' => 'contact-form')) }}
<div class="modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editing - Contact Us</h4>
      </div>
      <div class="modal-body">

        <!-- general form elements -->
        <div class="box box-primary">

                <div class="box-body">
                    <input type="hidden" id="page-id" value="{{$pageId}}"/>
                    @foreach($fields as $field)

                        @if($field['type'] == 'input')
                        <div class="form-group">
                            <label for="appName">{{ ($field['name'] == 'name' || $field['name'] == 'title') ? 'Page' : '' }} {{ ucwords($field['name']) }}</label>
                            <input type="text" name="{{$field['name']}}" class="form-control" id="{{$field['name']}}" placeholder="Enter {{ $field['name'] }}" value="{{ $field['value'] }}">
                        </div>

                        @elseif($field['type'] == 'textarea')
                        <!-- textarea -->
                        <div class="form-group">
                            <label>{{ ucwords($field['name']) }}</label>
                            <textarea class="form-control" name="{{$field['name']}}" id="{{$field['name']}}"rows="3" placeholder="Enter {{ $field['name'] }}">{{ $field['value'] }}</textarea>
                        </div>
                        @endif

                    @endforeach
                    
                </div><!-- /.box-body -->
            
        </div><!-- /.box -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="contact-submit">Save changes</button>
      </div>
    </div>
  </div>
</div>
{{ Form::close() }}

@stop