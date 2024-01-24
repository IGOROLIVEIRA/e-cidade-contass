## e-Cidade v3
## Eloquent
O Eloquent é um ORM utilizado nativamente pelo Laravel. Aqui no e-cidade usamos com o mesmo propósito, ou seja, de ser uma camada de acesso ao banco de dados.
### Como usar?

Para utilizar, basta criar uma classe em `app/Models` que `extends` de `LegacyModel` e pronto. De resto, basta seguir as convenções do ORM que são descritas na [doc do Eloquent](https://laravel.com/docs/5.8/eloquent):

```php
<?php

namespace App\Models;

class Flight extends LegacyModel
{
    //
}

```

### Account de Dados do E-cidade
Mas e como fica os logs do e-cidade? Para solucionar essa dor, foi criada uma `Trait` chamada `LegacyAccount`. Fazendo o uso dessa `trait` o model irá realizar os logs de accout legacy do e-cidade de forma automática para os eventos de `save`, `update` e `delete`:

```php

<?php

namespace App\Models;

class Flight extends LegacyModel
{
    use LegacyAccount;
}
```

### Legacy Labels
Para tornar o eloquent compatível com a geracao de HTML nativa do e-cidade, utilize a trait `LegacyLabel`.

1. Incula a trait `LegacyLabel` no model:

```php
<?php
class ConfiguracaoPixBancoDoBrasil extends LegacyModel
{
    use LegacyLabel;
}
```
2. Dessa forma voce será capaz de utilizar o método `label()` normalmente:

```php
<?php
// Forma legada
$clissbase->rotulo->label();
db_input('q02_inscr',4,$Iq02_inscr,true,'text',$db_opcao,"")

// Com eloquent
use App\Models\ConfiguracaoPixBancoDoBrasil;

$configuracaoPixBb = new ConfiguracaoPixBancoDoBrasil();
$configuracaoPixBb->legacyLabel->label();

db_input(
    'k177_url_api',
    '',
    $Ik177_url_api,
    true,
    'text',
    $db_opcao,
    " style='width: 100%'",
    '',
    '',
    '',
    ''
);
```

### Observacoes
- O Eloquent nao coloca em desuso as classes DAO (classes/db_tabela_classe.php) nativas do e-cidade, apenas dá uma possibilidade a mais para o desenvolvedor de utilizar os Models do Eloquent no lugar das classes DAO legadas.
- A versão atual do Eloquent é 9, no entanto estamos usando a 5.8 devido a outras dependências atuais do e-cidade.


## Usando docker na v3
Para configurar o docker primeiro edit o env com a porta para
o apache
```bash
    $cp .env-exemplo .env
```

### Depois execute o comando para subir o docker do apache
```bash
    docker-compose up -d --build
    docker exec -it <NOME-ou-ID-CONTAINER> /bin/bash
    chmod -R 775 /var/www/html/*
    chmod -R 777 /var/www/html/tmp/
    cd /var/www/html/
    composer install
    cd /var/www/html/config/
    cp preferencias.json.dist preferencias.json
    cd ..
    cd /var/www/html/extension/data/extension/
    cp Desktop.data.dist Desktop.data  
    cd /var/www/html/extension/modification/data/modification/
    cp dbportal-v3-desktop.data.dist dbportal-v3-desktop.data
    bin/v3/extension/install Desktop <NOME-DO-SEU-USUARIO>
```

### Configuração do banco de dados local

Alterar o arquivo db_conn.php que esta na pasta libs. Caso não exista copio db_conn.php.dist 
```
    cd libs
    cp db_conn.php.dist db_conn.php
```
Alterar as seguintes variáveis deixando igual ao exemplo.

    $DB_USUARIO   = "ecidade"; // Usuário do PostgreSQL 
    $DB_SENHA     = "ecidade"; // Senha do usuário do PostgreSQL 
    $DB_SERVIDOR = "bd"; // 
    $DB_PORTA = "5432"; //
    $DB_PORTA_ALT = "5432"; //
    $DB_BASE      = "ecidade"; // Nome da base de dados

## Todos comandos php devem ser executando dentro do conteiner web
```
    docker exec -it <NOMEDOCONTAINER> /bin/bash
```
### Depois execute o comando para parar o docker do apache
```bash
    $docker-compose down
```

### Recuperando backup 

    psql -U ecidade ecidade -h localhost -f NOMEDOARQUIVO.SQL

### Para Acessar
Acesse no navegador com o portal informada no .env: http://localhost:8888

Para acessar o banco de dados no navegador http://localhost:8484

### Para debugar no PHPSTORM

...

### Para Debugar no VSCode

...

