<?php

namespace Controllers\MessagesController;

use \Core\View\View;
use \Request\MessagesRequest\MessagesRequest;
use \Request\MessagesViewRequest\MessagesViewRequest;
use \Models\Messages\Messages;
use \WebKet\Main\Main;
use \Request\UsersRequest\UsersRequest;
use \Models\Users\Users;

/**
* The messages contoller
*/
class MessagesController extends View
{
	
	public function __construct()
	{
		
	}
    
	public function messagesend(MessagesRequest $messagesRequest)
	{
        if (!(Main::auth() > 0))
            die (
                Main::jsonError('notauth', 'auth')
            );
        
        $messagesRequest->id = null;

        $messages = new Messages();
        $messages->save($messagesRequest);
        
        die (
            Main::jsonOk('accepted', 'update message')
        );
	}
    
    public function listmessages(UsersRequest $usersRequest)
    {
        if (!(Main::auth() > 0))
            die(Header('Location: /'));
        
        $users = new Users();
        $list = $users->all($usersRequest);
        
        $count = Main::getContent(
            $_SESSION['user']['id']
        );

        $posts = array(
            'title' => 'Web Ket | List messages',
            'auth' => Main::auth(),
            'page' => 'listmessages',
            'list' => $list,
            'idfrom' => $_SESSION['user']['id'],
            'count' => $count
        );
        $this->render(
            'listmessages',
            array('posts' => $posts),
            'layoutadmin'
        );
    }
    
    public function countmessages($id, MessagesViewRequest $messagesViewRequest)
    {
        $messagesViewRequest->id = $id;
        
        $messages = new Messages();
        $list = $messages->all($messagesViewRequest);
        
        $increment = 0;
        if (!empty($list))
            foreach ($list as $key => $value) {
                if (
                    $value->idto == $id ||
                    $value->idfrom == $id
                )
                    ++$increment;
            }
        else
            die("");
        
        die(" ({$increment})");
    }

    public function viewmessages($id, MessagesViewRequest $messagesViewRequest)
    {
        if (!(Main::auth() > 0))
            die(Header('Location: /'));

        if ($id != $_SESSION['user']['id'])
            die(Header('Location: /'));
        
        $messages = new Messages();
        $list = $messages->all($messagesViewRequest);
        
        $posts = array(
            'title' => 'Web Ket | View messages',
            'auth' => Main::auth(),
            'page' => 'listmessages',
            'list' => $list,
            'idfrom' => $_SESSION['user']['id'],
            'id' =>$id
        );
        $this->render(
            'viewmessages',
            array('posts' => $posts),
            'layoutadmin'
        );
    }
}
