<?php namespace Sam\Services\Builder;

use SSH;
use File;
use Sam\Services\Builder\AndroidBuilder;

class BuilderQueue
{
	public function fire($job, $data)
    {
    	//File::append(app_path().'/queue.txt', $data['message'].PHP_EOL);
    	SSH::run(array(
			'cd ~/myapp',
			'meteor build ~/output/'.$data['output'].' --server=spinnappmaker.meteor.com',
			'cd ~/output/'.$data['output'].'/android',
			'jarsigner -digestalg SHA1 unaligned.apk sam -storepass spinnlabs',
		    '~/.meteor/android_bundle/android-sdk/build-tools/20.0.0/zipalign 4 unaligned.apk sam.apk'
		));

        $job->delete();
    }
}