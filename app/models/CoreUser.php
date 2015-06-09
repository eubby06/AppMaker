<?php 

use Jenssegers\Mongodb\Model as Eloquent;

class CoreUser extends Eloquent {

    protected $collection = 'users';

    public $validator;

    public $activation_code;

    protected $fillable = array(
    	'_id', 
    	'first_name', 
    	'last_name', 
    	'company', 
    	'password', 
    	'type', 
    	'role_ids',
    	'mobile',
    	'email',
    	'gender',
    	'merchant_id',
    	'access_permissions',
        'manage_permissions',
        'persist_code',
        'activation_code',
        'reset_code',
        'status'
    	);

	public static $rules = array(
    	'first_name' 	 => 'required|max:60', 
    	'last_name' 	=> 'required|max:60', 
    	'company' 		=> 'required|max:60', 
    	'password' 		=> 'required|confirmed|min:8', 
    	'type' 			=> 'required', 
    	'role_ids' 		=> 'required',
    	'mobile' 		=> 'required|min:8|numeric',
    	'email' 		=> 'required|email|unique:users',
    	'gender' 		=> 'required',
        'status'        => 'required'
	);

    public function device()
    {
        return $this->hasOne('CoreDevice', 'user_id');
    }

    public function apps()
    {
        return $this->hasMany('CoreApp', 'merchant_id');
    }

    public function roles()
    {
        return CoreRole::whereIn('_id', $this->role_ids);
    }

    public function getRolesAttribute()
    {
       return $this->roles()->get();
    }

    public function merchant()
    {
        return $this->belongsTo('CoreUser', 'merchant_id');
    }

    public function merchants()
    {
        return $this->hasMany('CoreUser', 'channel_id');
    }

    public function users()
    {
        return $this->where('merchant_id', '=', $this->id);
    }

    public function getUsersAttribute()
    {
       return $this->users()->get();
    }

    public function getRoles()
    {
        return CoreRole::whereIn('_id', $this->role_ids)->get();
    }

    public function getRolesWithAccessType()
    {
        return CoreRole::whereIn('_id', $this->role_ids)->where('type','access')->get();
    }

    public function getRolesWithManageType()
    {
        return CoreRole::whereIn('_id', $this->role_ids)->where('type','manage')->get();
    }

    public function hasAccessAndManagePermission($moduleId)
    {
        if(!$this->hasAdminRights())
        {
            return $this->hasAccessPermission($moduleId);
        }
        else if($this->isManager())
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

	public function validate($input, $id = null)
	{

        //check if this is edit and new password is set
        if( isset($input['new_password']) )
        {
            self::$rules['password'] = '';
            self::$rules['new_password'] = 'confirmed';
        }

        //exclude email validation if update
        if(!is_null($id))
        {
            $user = $this->find($id);

            self::$rules['email'] = ($input['email'] == $user->email) ? '' : self::$rules['email'];
            
        }

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

    public function setPasswordAttribute($pass)
    {

        $this->attributes['password'] = Hash::make($pass);
    }

    public function activate($code)
    {
        if(!$this->isBanned() && !$this->isActivated() && $code == $this->activation_code)
        {
            $this->status = 'activated';
            $this->save();

            return true;
        }

        return false;
    }

    public function getResetCode()
    {
        $this->reset_code = $resetCode = $this->getRandomString();

        $this->save();

        return $resetCode;
    }

    public function getActivationCode()
    {
        $this->activation_code = $activationCode = $this->getRandomString();

        $this->save();

        return $activationCode;
    }

    public function getPersistCode()
    {
        $this->persist_code = $this->getRandomString();

        // Our code got hashed
        $persistCode = $this->persist_code;

        $this->save();

        return $persistCode;
    }

    public function checkPersistCode($persistCode)
    {
        if ( ! $persistCode)
        {
            return false;
        }

        return $persistCode == $this->persist_code;
    }

    public function getRandomString($length = 42)
    {
        // We'll check if the user has OpenSSL installed with PHP. If they do
        // we'll use a better method of getting a random string. Otherwise, we'll
        // fallback to a reasonably reliable method.
        if (function_exists('openssl_random_pseudo_bytes'))
        {
            // We generate twice as many bytes here because we want to ensure we have
            // enough after we base64 encode it to get the length we need because we
            // take out the "/", "+", and "=" characters.
            $bytes = openssl_random_pseudo_bytes($length * 2);

            // We want to stop execution if the key fails because, well, that is bad.
            if ($bytes === false)
            {
                throw new \RuntimeException('Unable to generate random string.');
            }

            return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
        }

        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function fullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isActivated()
    {
        return ($this->status == 'activated') ? true : false;
    }

    public function isBanned()
    {
        return ($this->status == 'banned') ? true : false;
    }

    public function getRole()
    {
        return is_null($this->role_ids) ? array() : $this->role_ids;
    }

    public function isUser()
    {
        return in_array('55012f16bffebc2b0e8b4567', $this->getRole()) ? true : false;
    }

    public function isManager()
    {
        return in_array('550143dbbffebc13128b4567', $this->getRole()) ? true : false;
    }

    public function isSuper()
    {
        return in_array('550143b8bffebc0b128b4567', $this->getRole()) ? true : false;
    }

    public function isAdmin()
    {
        return in_array('550143c9bffebc10128b4567', $this->getRole()) ? true : false;
    }

    public function hasAccessibleRights()
    {
        //get roles
        $accessRoles = $this->getRolesWithAccessType();

        return $accessRoles ? true : false;
    }

    public function hasManageableRights()
    {
        //get roles
        $manageRoles = $this->getRolesWithManageType();

        return ($manageRoles || $this->hasAdminRights()) ? true : false;
    }

    public function hasAdminRights()
    {
        if($this->isAdmin() || $this->isSuper() || $this->isManager())
        {
            return true;
        }

        return false;
    }

    //this refers to super admin, admin and manager
    public function hasAdminPermission($permission)
    {

        $permissions = $this->getAdminPermissions() ? $this->getAdminPermissions() : array();

        if(in_array($permission, $permissions))
        {
            return true;
        }

        return false;
    }

    public function getAdminPermissions()
    {

        foreach($this->role_ids as $role)
        {
            if(in_array($role, array('550143b8bffebc0b128b4567','550143c9bffebc10128b4567','550143dbbffebc13128b4567')))
            {
                $permissions = Config::get('user.permissions.' . $role . '.user_management');

                return $permissions;
            }
        }
    }

    public function hasPrivilege($app, $privilege)
    {
        $needle = array($app => $privilege);

        if(!isset($this->privileges[$app]))
        {
            return false;
        }

        if(in_array($needle, $this->privileges))
        {
            return true;
        }

        return false;
    }
}