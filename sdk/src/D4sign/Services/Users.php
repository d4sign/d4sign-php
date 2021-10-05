<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Users extends Service
{
	
    public function listall()
    {
        $data = array();
        return $this->client->request("/users/list", "GET", $data, 200);
    }
    public function check($email)
    {
        $data = array("email_user" => json_encode($email));
        return $this->client->request("/users/check", "POST", $data, 200);
    }
    public function block($email)
    {
        $data = array("email_user" => json_encode($email));
        return $this->client->request("/users/block", "POST", $data, 200);
    }
    public function unblock($email)
    {
        $data = array("email_user" => json_encode($email));
        return $this->client->request("/users/unblock", "POST", $data, 200);
    }
}
