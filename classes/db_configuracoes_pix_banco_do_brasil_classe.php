<?php

use ECidadeLegacy\Classes\ClasseBase;

class cl_configuracoes_pix_banco_do_brasil extends ClasseBase
{
    public $rotulo = null;
    public $query_sql = null;
    public $numrows = 0;
    public $erro_status = null;
    public $erro_sql = null;
    public $erro_banco = null;
    public $erro_msg = null;
    public $erro_campo = null;
    public $pagina_retorno = null;
    public $k177_sequencial = 0;
    public $k177_instituicao_financeira = 0;
    public $k177_url_api = null;
    public $k177_url_oauth = null;
    public $k177_develop_application_key = null;
    public $k177_client_id = null;
    public $k177_client_secret = null;
    public $k177_ambiente = null;
    public $k177_numero_convenio = 0;
    public $k177_chave_pix = null;
    public $campos = "
                 k177_sequencial = int8 = Código Sequencial
                 k177_instituicao_financeira = int8 = Instituição Financeira
                 k177_url_api = text = End Point API URL
                 k177_url_oauth = text = End Point API OAuth2
                 k177_develop_application_key = text = Develop Application Key
                 k177_client_id = text = Client ID
                 k177_client_secret = text = Client Secret
                 k177_ambiente = varchar(1) = Ambiente
                 k177_numero_convenio = int8 = Convênio
                 k177_chave_pix = text = Chave PIX
                 ";
    private array $globals;

    public function __construct()
    {
        $this->rotulo = new rotulo("configuracoes_pix_banco_do_brasil");
        $this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
        $this->globals = $GLOBALS;
        $this->tableName = 'arrecadacao.configuracoes_pix_banco_do_brasil';
    }

    public function erro(bool $mostra, bool $retorna): void
    {
        if (($this->erro_status == "0") || ($mostra === true && $this->erro_status != null)) {
            echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
            if ($retorna === true) {
                echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
            }
        }
    }

    public function atualizacampos($exclusao = false): void
    {
        $this->k177_sequencial = $this->k177_sequencial == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_sequencial"]
            : $this->k177_sequencial;
        if ($exclusao) {
            return;
        }
        $this->k177_instituicao_financeira = $this->k177_instituicao_financeira == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_instituicao_financeira"]
            : $this->k177_instituicao_financeira;

        $this->k177_url_api = $this->k177_url_api == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_url_api"]
            : $this->k177_url_api;

        $this->k177_url_oauth = $this->k177_url_oauth == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_url_oauth"]
            : $this->k177_url_oauth;

        $this->k177_develop_application_key = $this->k177_develop_application_key == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_develop_application_key"]
            : $this->k177_develop_application_key;

        $this->k177_client_id = $this->k177_client_id == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_client_id"]
            : $this->k177_client_id;

        $this->k177_client_secret = $this->k177_client_secret == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_client_secret"]
            : $this->k177_client_secret;

        $this->k177_ambiente = $this->k177_ambiente == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_ambiente"]
            : $this->k177_ambiente;

        $this->k177_numero_convenio = $this->k177_numero_convenio == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_numero_convenio"]
            : $this->k177_numero_convenio;

        $this->k177_chave_pix = $this->k177_chave_pix == ""
            ? $this->globals["HTTP_POST_VARS"]["k177_chave_pix"]
            : $this->k177_chave_pix;
    }

    public function incluir(): bool
    {
        $this->atualizacampos();
        if (!$this->validate()) {
            return false;
        }
        $result = $this->insert(
            [
                'k177_instituicao_financeira' => $this->k177_instituicao_financeira,
                'k177_url_api' => "'$this->k177_url_api'",
                'k177_url_oauth' => "'$this->k177_url_oauth'",
                'k177_develop_application_key' => "'$this->k177_develop_application_key'",
                'k177_client_id' => "'$this->k177_client_id'",
                'k177_client_secret' => "'$this->k177_client_secret'",
                'k177_ambiente' => "'$this->k177_ambiente'",
                'k177_numero_convenio' => "'$this->k177_numero_convenio'",
                'k177_chave_pix' => "'$this->k177_chave_pix'"
            ]
        );

        if ($result === false) {
            $this->erro_sql = "Configuracoes para integragacao com a API PIX BB () não Incluído. Inclusao Abortada.";
            $this->erro_banco = str_replace("\n", "", pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_banco = "Configuracoes para integragacao com a API PIX BB j? Cadastrado";
            }
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
        $this->erro_status = "1";

        return true;
    }

    public function alterar(int $k177_sequencial): bool
    {
        $this->atualizacampos();
        if (!$this->validate()) {
            return false;
        }
        $result = $this->update(
            $k177_sequencial,
            [
                'k177_instituicao_financeira' => $this->k177_instituicao_financeira,
                'k177_url_api' => "'$this->k177_url_api'",
                'k177_url_oauth' => "'$this->k177_url_oauth'",
                'k177_develop_application_key' => "'$this->k177_develop_application_key'",
                'k177_client_id' => "'$this->k177_client_id'",
                'k177_client_secret' => "'$this->k177_client_secret'",
                'k177_ambiente' => "'$this->k177_ambiente'",
                'k177_numero_convenio' => "'$this->k177_numero_convenio'",
                'k177_chave_pix' => "'$this->k177_chave_pix'"
            ]
        );

        if ($result === false) {
            $this->erro_banco = str_replace("\n", "", pg_last_error());
            $this->erro_sql   = "Configuracoes para integragacao com a API PIX BB nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
        $this->erro_status = "1";
        return true;
    }

    public function excluir(int $k177_sequencial): bool
    {
        $result = $this->delete(
            ['k177_sequencial' => $k177_sequencial]
        );

        if ($result === false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Configuracoes para integragacao com a API PIX BB nao Exclu?do. Exclusão Abortada.\\n";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
        $this->erro_status = "1";
        return true;
    }

    private function validate(): bool
    {
        if ($this->k177_instituicao_financeira == null) {
            $this->erro_sql = " Campo Institui??o Financeira nao Informado.";
            $this->erro_campo = "k177_instituicao_financeira";
            $this->erro_banco = "";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        if ($this->k177_url_api == null) {
            $this->erro_sql = " Campo End Point API URL nao Informado.";
            $this->erro_campo = "k177_url_api";
            $this->erro_banco = "";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        if ($this->k177_url_oauth == null) {
            $this->erro_sql = " Campo End Point API OAuth2 nao Informado.";
            $this->erro_campo = "k177_url_oauth";
            $this->erro_banco = "";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        if ($this->k177_develop_application_key == null) {
            $this->erro_sql = " Campo Develop Application Key nao Informado.";
            $this->erro_campo = "k177_develop_application_key";
            $this->erro_banco = "";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        if ($this->k177_client_id == null) {
            $this->erro_sql = " Campo Client ID nao Informado.";
            $this->erro_campo = "k177_client_id";
            $this->erro_banco = "";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        if ($this->k177_client_secret == null) {
            $this->erro_sql = " Campo Client Secret nao Informado.";
            $this->erro_campo = "k177_client_secret";
            $this->erro_banco = "";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        if ($this->k177_ambiente == null) {
            $this->erro_sql = " Campo Ambiente nao Informado.";
            $this->erro_campo = "k177_ambiente";
            $this->erro_banco = "";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        if ($this->k177_numero_convenio == null) {
            $this->erro_sql = " Campo Conv?nio nao Informado.";
            $this->erro_campo = "k177_numero_convenio";
            $this->erro_banco = "";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        if ($this->k177_chave_pix == null) {
            $this->erro_sql = " Campo Chave PIX nao Informado.";
            $this->erro_campo = "k177_chave_pix";
            $this->erro_banco = "";
            $this->erro_msg = $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        return true;
    }

    private function parseErrorMsg(string $errorSql, string $errorBanco): string
    {
        $error = "Usuário: \\n\\n " . $errorSql . " \\n\\n";
        $error .= str_replace(
            '"',
            "",
            str_replace("'", "", "Administrador: \\n\\n " . $errorBanco . " \\n")
        );

        return $error;
    }

    public function sql_record($sql)
    {
        $result = pg_query($sql);
        if ($result === false) {
            $this->numrows = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Erro ao selecionar os registros.";
            $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql = "Dados do Grupo nao Encontrado";
            $this->parseErrorMsg($this->erro_sql, $this->erro_banco);
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    public function sql_query($k177_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
    {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from configuracoes_pix_banco_do_brasil ";
        $sql2 = "";
        if (empty($dbwhere) && !empty($k177_sequencial)) {
            $sql2 = " where configuracoes_pix_banco_do_brasil.k177_sequencial = $k177_sequencial";

        }

        if (!empty($dbwhere)) {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
}
