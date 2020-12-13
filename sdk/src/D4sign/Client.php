<?php
namespace D4sign;

use D4sign\Services\Documents;
use D4sign\Services\Safes;
use D4sign\Services\Templates;
use D4sign\Services\Folders;
use D4sign\Services\Account;
use D4sign\Services\Users;
use D4sign\Services\Groups;
use D4sign\Services\Tags;
use D4sign\Services\Certificate;
use D4sign\Services\Watcher;

class Client extends ClientBase
{
    public $documents;
    
    public function __construct()
    {
        $this->documents 	= new Documents($this);
        $this->safes 		= new Safes($this);
        $this->templates 	= new Templates($this);
        $this->folders	 	= new Folders($this);
        $this->account	 	= new Account($this);
        $this->users	 	= new Users($this);
        $this->groups	 	= new Groups($this);
        $this->tags	 	    = new Tags($this);
        $this->certificate	= new Certificate($this);
        $this->watcher	    = new Watcher($this);
    }
    
}
