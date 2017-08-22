<?php
namespace D4sign;

use D4sign\Services\Documents;
use D4sign\Services\Safes;
use D4sign\Services\Templates;
use D4sign\Services\Folders;

class Client extends ClientBase
{
    public $documents;
    
    public function __construct()
    {
        $this->documents 	= new Documents($this);
        $this->safes 		= new Safes($this);
        $this->templates 	= new Templates($this);
        $this->folders	 	= new Folders($this);
    }
    
}
