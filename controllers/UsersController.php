<?php

namespace Controllers\UsersController;

use \Core\View\View;
use \Request\UsersRequest\UsersRequest;
use \Request\UsersUpdateRequest\UsersUpdateRequest;
use \Models\Users\Users;
use \Request\UsersLoginRequest\UsersLoginRequest;
use \Models\UsersLogin\UsersLogin;
use \WebKet\Main\Main;

/**
* The users contoller
*/
class UsersController extends View
{
	
	public function __construct()
	{
		
	}
    
	public function registration(UsersRequest $usersRequest)
	{
        if (Main::auth() > 0)
            die (
                Main::jsonError('auth', 'auth')
            );
        $usersRequest->password = md5($usersRequest->password);
        $usersRequest->role = 1;
        $users = new Users();
        $users->save($usersRequest);
        die (
	    	Main::jsonOk('accepted', 'login')
	    );
	}
    
	public function login(UsersLoginRequest $usersLoginRequest)
	{
        if (Main::auth() > 0)
            die (
                Main::jsonError('auth', 'auth')
            );
        $usersLoginRequest->password = md5(
            $usersLoginRequest->password
        );
        $usersLogin = new UsersLogin();
        foreach (
        	$usersLogin->all(
        		$usersLoginRequest,
        		'users'
        	) as $key => $value
        ) {
        	if (
        		$value->login == $usersLoginRequest->login
        		&&
        		$value->password == $usersLoginRequest->password
        	) {
                $_SESSION['user']['id'] = $value->id;
                $_SESSION['user']['role'] = $value->role;
        		die (
			    	Main::jsonOk('accepted', 'login or password')
			    );
            }
        }
        die (
	    	Main::jsonError('exists', 'login or password')
	    );
	}
    
    public function authlogin()
    {
        if (Main::auth() > 0)
            die(Header('Location: /'));
        $posts = array(
            'title' => 'Web Ket | Login',
            'auth' => Main::auth(),
            'page' => 'authlogin'
        );
        $this->render(
            'login',
            array('posts' => $posts),
            'layoutadmin'
        );
    }

    public function authlogout()
    {
        if (!(Main::auth() > 0))
            die(Header('Location: /'));
        unset($_SESSION['user']);
        die (Header('Location: /'));
    }
    
    public function authregister()
    {
        if (Main::auth() > 0)
            die(Header('Location: /'));
        $posts = array(
            'title' => 'Web Ket | Registration',
            'page' => 'authregister',
            'auth' => Main::auth()
        );
        $this->render(
            'register',
            array('posts' => $posts),
            'layoutadmin'
        );
    }
    
    public function listusers(UsersRequest $usersRequest)
    {
        if (!(Main::auth() > 1))
            die(Header('Location: /'));
        
        $users = new Users();
        $list = $users->all($usersRequest);
        
        $posts = array(
            'title' => 'Web Ket | List users',
            'auth' => Main::auth(),
            'page' => 'listusers',
            'list' => $list
        );
        $this->render(
            'listusers',
            array('posts' => $posts),
            'layoutadmin'
        );
    }
    
    public function deleteusers($id, UsersRequest $usersRequest)
    {
        if (!(Main::auth() > 1))
            die (
                Main::jsonError('notauth', 'auth')
            );
        
        $usersRequest->id = $id;
        $users = new Users();
        $list = $users->remove($usersRequest);
        
        die (
            Main::jsonOk('accepted', 'delete users')
        );
    }
    
    public function update(UsersUpdateRequest $usersUpdateRequest)
    {
        if (!(Main::auth() > 1))
            die (
                Main::jsonError('notauth', 'auth')
            );
        $usersUpdateRequest->password = md5($usersUpdateRequest->password);
        $users = new Users();
        $users->update($usersUpdateRequest);
        die (
            Main::jsonOk('accepted', 'login')
        );
    }
}
