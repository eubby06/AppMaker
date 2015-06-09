<?php

function sortableUrl($resource, $field)
{
	$url = '';

	if(Input::get('sort') == 'asc')
	{
		$url = route('get.'.$resource.'.list', array_merge(Input::all(), array('orderby' => $field, 'sort' => 'desc')));
	}
	else
	{
		$url = route('get.'.$resource.'.list', array_merge(Input::all(), array('orderby' => $field, 'sort' => 'asc')));
	}

	return $url;
}

function showCaret($field)
{
	if(Input::get('orderby') == $field)
	{
		return 'asc';
	}

	return 'desc';
}

function switchLanguageUrl($lang)
{
	$segments = explode('/', Request::path());
	
	if($segments[0] == 'en' || $segments[0] == 'zh')
	{
		$segments[0] = $lang;

		$newPath = implode('/', $segments);
	}

	$url = 'http://' . Request::getHttpHost() . "/" . $newPath . "?" . http_build_query(Input::all());

	return $url;
}

function buttonizeRoles($objects)
{
	$buttons = '';

	foreach($objects as $obj)
	{
		$route = route('get.permissions.list', array('role' => $obj->id));
		$buttons .= '<a href="' . $route . '" class="btn btn-default btn-xs">' . $obj->name . '</a> ';
	}

	return $buttons;
}

function listNamesOfObjects($objects)
{
	$string = '';

	foreach($objects as $obj)
	{
		$string .= '{' . $obj->name . '}';
	}

	return $string;
}

function dropdownFormat($objects)
{
	$data = array();

	foreach($objects as $obj)
	{
		$data[$obj->id] = $obj->name;
	}

	return $data;
}

function getModulePrivileges($name, $type = null)
{
	$name = !empty($name) ? camel_case(strtolower($name)) : null;

	if(is_null($name))
	{
		return;
	}

	$privileges = Config::get($name.'::privileges');

	if(!is_null($type))
	{
		$privileges = $privileges[$type];
	}

	return $privileges;
}