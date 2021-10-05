<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Watcher extends Service
{
	public function find($uuid_arquivo)
    {
        $data = array();
        return $this->client->request("/watcher/$uuid_arquivo", "GET", $data, 200);
    }
    public function add($uuid_arquivo, $email, $perfil = 0)
    {
        $data = array("email" => json_encode($email), "permission" => json_encode($perfil));
    	return $this->client->request("/watcher/$uuid_arquivo/add", "POST", $data, 200);
    }
    public function remove($uuid_arquivo, $email)
    {
        $data = array("email" => json_encode($email));
        return $this->client->request("/watcher/$uuid_arquivo/remove", "POST", $data, 200);
    }
    public function erase($uuid_arquivo)
    {
        $data = array();
        return $this->client->request("/watcher/$uuid_arquivo/erase", "POST", $data, 200);
    }

}
