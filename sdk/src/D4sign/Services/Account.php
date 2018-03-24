<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Account extends Service
{
	
	public function balance()
    {
        $data = array();
        return $this->client->request("/account/balance", "GET", $data, 200);
    }

}
