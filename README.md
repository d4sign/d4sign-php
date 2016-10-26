# D4Sign PHP Client - SDK

Documentação [D4Sign REST API](http://docapi.d4sign.com.br/).

## Configuração mínima

PHP 5 >= 5.5.0

## Passo a Passo

### 1º - Realizar o upload do documento
### 2º - Cadastrar o webhook(POSTBack)
### 3º - Cadastrar os signatários
### 4º - Enviar o documento para assinatura
### 5º - Utilizar o EMBED D4Sign para exibir o documento em seu website


## Documentos

### Listar TODOS os documentos

Este objeto retornará TODOS os documentos da sua conta.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$docs = $client->documents->find();

//print_r($docs);
```

### Listar um documento específico

Esse objeto retornará apenas o documento solicitado.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$docs = $client->documents->find("{UUID-DOCUMENT}");

//print_r($docs);
```

### Listar TODOS os documentos de um cofre

Esse objeto retornará todos os documentos que estiverem associados ao cofre informado.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$docs = $client->documents->safe("{UUID-SAFE}");

//print_r($docs);
```

### Listar TODOS os documentos de uma fase

Esse objeto retornará todos os documentos que estiverem na fase informada.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$docs = $client->documents->status("{ID-FASE}");

//print_r($docs);
```

ID 1 - Processando
ID 2 - Aguardando Signatários
ID 3 - Aguardando Assinaturas
ID 4 - Finalizado
ID 5 - Arquivado
ID 6 - Cancelado


### Realizar o UPLOAD de um documento

Esse objeto realizará o UPLOAD do seu documento para os servidores da D4Sign.

Após o UPLOAD, o documento será criptografado em nossos cofres e carimbado com um número de série.

Após o processamento um preview será gerado. O processamento será realizado em background, ou seja, a requisição não ficará bloqueada.

Todos os documentos ficam armazenados em COFRES criptografados, ou seja, o parâmetro UUID-SAFE é obrigatório e determina em qual cofre o documento ficará armazenado.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$path_file = '/pasta/arquivo.pdf';
$id_doc = $client->documents->upload('{UUID-SAFE}', $path_file);

//print_r($id_doc);
```

### Cadastrar signatários

Esse objeto realizará o cadastro dos signatários do documento, ou seja, quais pessoas precisam assinar esse documento.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$signers = array(
	array("email" => "email1@dominio.com", "act" => '1', "foreign" => '0'),
	array("email" => "email2@dominio.com", "act" => '1', "foreign" => '0')
);

$return = $client->documents->createList("{UUID-DOCUMENT}", $signers);

//print_r($return);
```

### Listar signatários de um documento

Esse objeto retornará todos os signatários de um documento.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$docs = $client->documents->listsignatures("{UUID-DOCUMENT}");

//print_r($docs);
```

### Enviar um documento para assinatura

Esse objeto enviará o documento para assinatura, ou seja, o documento entrará na fase 'Aguardando assinaturas', onde, a partir dessa fase, os signatários poderão assinar os documentos.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$message = 'Prezados, segue o contrato eletrônico para assinatura.';
$workflow = 0 //Todos podem assinar ao mesmo tempo;
$skip_email = 1 //Não disparar email com link de assinatura (usando EMBED);

$doc = $client->documents->sendToSigner("{UUID-DOCUMENT}",$message, $skip_email, $workflow);

//print_r($doc);
```

### Cancelar um documento

Esse objeto irá cancelar o documento.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$docs = $client->documents->cancel("{UUID-DOCUMENT}");

//print_r($docs);
```

### Reenviar link de assinatura

Esse objeto irá reenviar o link de assinatura para o signatário.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$email = 'email@dominio.com';
$return = $client->documents->resend('{UUID-DOCUMENT}', $email);

//print_r($return);
```

### Realizar o DOWNLOAD de um documento

Esse objeto irá disponibilizar um link para download do documento.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

//Você poderá fazer download do ZIP ou apenas do PDF setando o último parametro.
$url_final = $client->documents->getfileurl('{UUID-DOCUMENT}','zip');
//print_r($url_final);

$arquivo = file_get_contents($url_final->url);

//CASO VOCÊ ESTEJA FAZENDO O DOWNLOAD APENAS DO PDF, NÃO ESQUEÇA DE ALTERAR O CONTENT-TYPE PARA application/pdf E O NOME DO ARQUIVO PARA .PDF
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$url_final->name.".zip"."\"");
echo $arquivo;
```

## WebHooks Services (POSTBack)

### Listar Webhook de um documento

Esse objeto irá retornar o webhook cadastrado no documento.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$webhook = $client->documents->webhooklist("{UUID-DOCUMENT}");

//print_r($webhook);
```

### Cadastrar Webhook em um documento

Esse objeto irá cadastrar o webhook no documento.

```php
require_once(__DIR__ . '/sdk/vendor/autoload.php');

use D4sign\Client;
$client = new Client();
$client->setAccessToken("{TOKEN-USER}");

$url = 'http://seudominio.com.br/post.php';
$webhook = $client->documents->webhookadd("{UUID-DOCUMENT}",$url);
	
//print_r($webhook);
```

## Documentação completa da API

http://docapi.d4sign.com.br/

## Dúvidas?

Entre em contato com nossos desenvolvedores pelo e-mail suporte@d4sign.com.br
