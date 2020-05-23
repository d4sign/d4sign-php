<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Groups extends Service
{
	
	public function find($uuid_cofre)
    {
        $data = array();
        return $this->client->request("/groups/$uuid_cofre", "GET", $data, 200);
    }

}
