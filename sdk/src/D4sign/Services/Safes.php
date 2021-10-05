<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Safes extends Service
{
	
	public function find($safeKey = '')
    {
        $data = array();
        return $this->client->request("/safes/$safeKey", "GET", $data, 200);
    }

}
