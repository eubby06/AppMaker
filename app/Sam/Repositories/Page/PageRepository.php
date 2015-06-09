<?php namespace Sam\Repositories\Page;

use Sam\Repositories\Page\PageRepositoryInterface,
	CorePage;

class PageRepository implements PageRepositoryInterface{

	private $pageModel;

	public function __construct(CorePage $pageModel)
	{
		$this->pageModel = $pageModel;
	}

	public function findAll()
	{
		return $this->pageModel->all();
	}

	public function findById($id)
	{
		return $this->pageModel->find($id);
	}

	public function create($input)
	{

		$page = $this->pageModel->where('module_id','=',$input['module_id'])
								->where('app_id','=',$input['app_id'])
								->where('name','=',$input['name'])
								->first();

		if(!$page)
		{
			$page = $this->pageModel->create($input);
		}

		return $page;
	}

	public function update($input, $id)
	{
		$page = $this->pageModel->find($id);
		$page->fill($input);
		$page->save();
	}

	public function validate( $input )
	{
		return $this->pageModel->validate( $input );
	}

	public function validatorInstance()
	{
		return $this->pageModel->validatorInstance();
	}
}