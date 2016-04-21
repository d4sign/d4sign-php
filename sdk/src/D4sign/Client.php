<?php
namespace D4sign;

use D4sign\Services\Documents;

class Client extends ClientBase
{
    public $documents;
    
    public function __construct()
    {
        $this->documents = new Documents($this);
    }
    
}
