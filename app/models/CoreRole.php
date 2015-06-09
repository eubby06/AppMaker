<?php 

use Jenssegers\Mongodb\Model as Eloquent;

class CoreRole extends Eloquent {

	protected $collection = 'roles';

	public $validator;

    protected $fillable = array(
    	'_id', 
    	'name', 
    	'merchant_id',
    	'app_id',
    	'type',
        'access_permissions',
        'manage_permissions',
        'privileges',
        'user_ids'
    	);

	public static $rules = array(
    	'name' 	 	=> 'required|max:60',
    	'merchant_id' => 'required',
    	'app_id' => 'required',
    	'type' => 'required'
	);

    public function users()
    {
        return CoreUser::whereIn('_id', $this->user_ids);
    }

    public function getUsersAttribute()
    {
       return $this->users()->get();
    }

	public function app()
	{
		return $this->belongsTo('CoreApp','app_id');
	}

	public function merchant()
	{
		return $this->belongsTo('CoreUser','merchant_id');
	}

    public function hasAccessAndManagePermission($moduleId)
    {
        if($this->type == 'access')
        {
            return $this->hasAccessPermission($moduleId);
        }
        else if($this->type == 'manage')
        {
            return $this->hasManagePermission($moduleId);
        }
        else
        {
            return false;
        }
    }

    public function hasAccessPermission($moduleId)
    {
        $permissions = is_null($this->access_permissions) ? array() : $this->access_permissions;

        if(in_array($moduleId, $permissions ))
        {
            return true;
        }

        return false;
    }

    public function hasManagePermission($moduleId)
    {
        $permissions = is_null($this->manage_permissions) ? array() : $this->manage_permissions;

        if(in_array($moduleId, $permissions ))
        {
            return true;
        }

        return false;
    }
    
	public function validate( $input )
	{

		$validator = Validator::make( $input, self::$rules );

		if( $validator->fails() )
		{
			$this->validator = $validator;

			return false;
		}

		return true;
	}

	public function validatorInstance()
	{
		return $this->validator;
	}

    public function removeUsers($ids)
    {
        $users = $this->user_ids;

        if(is_array($users))
        {
            $users = array_map(function($user) use($ids)
                {
                    if(in_array($user, $ids))
                    {
                        return $user;
                    }
                }, $users);

            $this->user_ids = $users;
            $this->save();
            
            return true;
        }

        return false;
    }

    public function removeUser($id)
    {
        $users = $this->user_ids;

        if(is_array($users))
        {
            $users = array_map(function($user) use($id)
                {
                    if($id != $user)
                    {
                        return $user;
                    }
                }, $users);

            $this->user_ids = $users;
            $this->save();
            return true;
        }

        return false;
    }

    public function addUser($id)
    {
        //user to be added to a role
        $user = CoreUser::find($id);
        $roles = $user->role_ids;
        $thisRoleId = array($this->id);

        $newRoleIds = $thisRoleId;

        //check if this role already exist in user's roles
        if(is_array($roles))
        {
            $newRoleIds = array_merge($roles, $thisRoleId);
        }

        $user->role_ids = $newRoleIds;
        $user->save(); 
        
        $users = $this->user_ids;
        $userId = array($id);

        $newUserIds = $userId;

        //check if this user already exist in role's users
        if(is_array($users))
        {
            $newUserIds = array_merge($users, $userId);
        }
            
        $this->user_ids = $newUserIds;
        $this->save();

        return true;
    }
}