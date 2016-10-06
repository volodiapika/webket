<?php

namespace Models\Messages;

use \Core\Orm\Orm;

/**
* The messages
*/
class Messages extends Orm
{
	    
	public function title()
	{
		return nl2br($this->title);
	}
    
	public function message()
	{
	    return nl2br($this->message);
	}

	public function idto()
	{
	    return nl2br($this->idto);
	}

	public function idfrom()
	{
	    return nl2br($this->idfrom);
	}
}
