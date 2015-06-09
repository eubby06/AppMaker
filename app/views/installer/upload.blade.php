<h1>Upload Module</h1>

{{ Form::open(array('url' => 'installer/frontend', 'files' => true)) }}
	
	{{ Form::file('package') }}
	{{ Form::submit('upload frontend') }}

{{ Form::close() }}

{{ Form::open(array('url' => 'installer/backend', 'files' => true)) }}
	
	{{ Form::file('package') }}
	{{ Form::submit('upload backend') }}

{{ Form::close() }}