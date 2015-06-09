<?php namespace App\Modules\Form\Controllers;

use App\Modules\ModuleController,
	App\Modules\Form\Models\FormModel,
	Input,
	Redirect,
	Session,
	DB,
	Excel,
	Hash,
	View;

class FormController extends ModuleController {

	protected $layout = 'layouts.admin';
	protected $script = 'form::script';
	protected $resource = 'form';

	public function getIndex($appId)
	{
		$data = array();

		$app = $this->appRepo->findById($appId);

		if(Input::get('from') && Input::get('to'))
		{
			$from = Input::get('from');
			$to = Input::get('to');

			// retrieve data based on the date range
			$data = FormModel::where('app_id', $appId)
								->whereBetween('created_at', array($from, $to))->paginate(10);
		}
		else
		{
			// retrive all data
			$data = FormModel::where('app_id', $appId)->paginate(10);
		}

		$this->layout->content = View::make('form::index')->with('data', $data)->with('app', $app);
		$this->layout->sidebarLeft = View::make('sidebars.app')->with('app', $app);	

		return $this->layout;
	}

	// post action should all go through here
	public function postIndex($appId)
	{	
		// check if action is export, then call export funtion
		if(Input::get('export'))
		{
			return $this->_export($appId, Input::get('range'));
		}
		// check if action is filter, then call filter result funtion
		else if(Input::get('filter'))
		{
			return $this->_filter($appId, Input::get('range'));
		}
		// check if action is filter, then call filter result funtion
		else if(Input::get('delete'))
		{
			return $this->_delete($appId, Input::get('ids'));
		}
		// just redirect back if no action
		else
		{
			return Redirect::back();
		}
	}

	public function getDelete($appId, $itemId)
	{
		$item = FormModel::find($itemId);

		if($item)
		{
			$item->delete();
			Session::flash('message', 'Item has been deleted successfully!');
		}
		else
		{
			Session::flash('message', 'Could not process your request!');
		}

		return Redirect::back();
	}

	// delete items
	public function _delete($appId, $ids)
	{
		if(is_null($ids) && !is_array($ids))
		{
			Session::flash('message', 'You have not selected an item to delete!');
		}

		if(FormModel::whereIn('_id', $ids)->delete())
		{
			Session::flash('message', 'Items have been deleted successfully!');
		}
		else
		{
			Session::flash('message', 'Could not process your request!');
		}

		
		return Redirect::back();
	}

	// export model to csv file
	public function _export($appId, $range = null)
	{
		$data = array();

		if(!is_null($range) && !empty($range))
		{
			list($from, $to) = preg_split('/-/', Input::get('range'));

			$from = date( 'Y-m-d', strtotime($from));
			$to = date( 'Y-m-d', strtotime($to));

			// retrieve data based on the date range
			$data = FormModel::where('app_id', $appId)
								->whereBetween('created_at', array($from, $to))->paginate(10);
		}
		else
		{
			// retrive all data
			$data = FormModel::where('app_id', $appId)->get();
		}

		// define filename based on today's date
		$filename = 'Form-data-' . date('Y-m-d-H:i:s');

		// this class exports the models to a csv file
		Excel::create($filename, function($excel) use($data) {

		    $excel->sheet('Data', function($sheet) use($data) {
		        $sheet->fromModel($data);
		    });

		})->export('csv');

		// just redirect back
		Session::flash('message', 'CSV export successful!');
		return Redirect::back();
	}

	// this will filter the result by date range
	public function _filter($appId, $range = null)
	{
		if(!is_null($range) && !empty($range))
		{
			list($from, $to) = preg_split('/-/', Input::get('range'));

			$from = date( 'Y-m-d', strtotime($from));
			$to = date( 'Y-m-d', strtotime($to));

			// redirect to index method to display filtered results
			Session::flash('message', 'Showing data dated from ' . $from . ' to ' . $to);
			return Redirect::route('get.module.form.index', array($appId, 'from' => $from, 'to' => $to));
		}

		return Redirect::back();
	}
}