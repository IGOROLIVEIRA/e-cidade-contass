<?php
//MODULO: esocial
//CLASSE DA ENTIDADE eventos1070
class cl_eventos1070
{
    // cria variaveis de erro
    public $rotulo     = null;
    public $query_sql  = null;
    public $numrows    = 0;
    public $numrows_incluir = 0;
    public $numrows_alterar = 0;
    public $numrows_excluir = 0;
    public $erro_status = null;
    public $erro_sql   = null;
    public $erro_banco = null;
    public $erro_msg   = null;
    public $erro_campo = null;
    public $pagina_retorno = null;
    // cria variaveis do arquivo
    public $eso09_sequencial = 0;
    public $eso09_tipoprocesso = 'f';
    public $eso09_nroprocessoadm = 0;
    public $eso09_indautoria = 'f';
    public $eso09_indmateriaproc = 'f';
    public $eso09_obsproc = null;
    public $eso09_indundfederacao = 'f';
    public $eso09_codmuniibge = 0;
    public $eso09_idvara = 0;
    public $eso09_codsusp = 0;
    public $eso09_codsuspexigi = 'f';
    public $eso09_dtdecisao_dia = null;
    public $eso09_dtdecisao_mes = null;
    public $eso09_dtdecisao_ano = null;
    public $eso09_dtdecisao = null;
    public $eso09_inddeposito = 'f';
    public $eso09_instit = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 eso09_sequencial = int8 = eso09_sequencial
                 eso09_tipoprocesso = bool = eso09_tipoprocesso
                 eso09_nroprocessoadm = varchar(50) = eso09_nroprocessoadm
                 eso09_indautoria = bool = eso09_indautoria
                 eso09_indmateriaproc = bool = eso09_indmateriaproc
                 eso09_obsproc = varchar(255) = eso09_obsproc
                 eso09_indundfederacao = bool = eso09_indundfederacao
                 eso09_codmuniibge = varchar(50) = eso09_codmuniibge
                 eso09_idvara = varchar(50) = eso09_idvara
                 eso09_codsusp = int8 = eso09_codsusp
                 eso09_codsuspexigi = bool = eso09_codsuspexigi
                 eso09_dtdecisao = date = eso09_dtdecisao
                 eso09_inddeposito = bool = eso09_inddeposito
                 eso09_instit = int4 = eso09_instit
                 ";

    //funcao construtor da classe
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("eventos1070");
        $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
    }

    //funcao erro
    function erro($mostra, $retorna)
    {
        if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
            echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
            if ($retorna == true) {
                echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
            }
        }
    }

    // funcao para atualizar campos
    function atualizacampos($exclusao = false)
    {
        if ($exclusao == false) {
            $this->eso09_sequencial = ($this->eso09_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_sequencial"] : $this->eso09_sequencial);
            $this->eso09_tipoprocesso = ($this->eso09_tipoprocesso == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_tipoprocesso"] : $this->eso09_tipoprocesso);
            $this->eso09_nroprocessoadm = ($this->eso09_nroprocessoadm == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_nroprocessoadm"] : $this->eso09_nroprocessoadm);
            $this->eso09_indautoria = ($this->eso09_indautoria == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_indautoria"] : $this->eso09_indautoria);
            $this->eso09_indmateriaproc = ($this->eso09_indmateriaproc == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_indmateriaproc"] : $this->eso09_indmateriaproc);
            $this->eso09_obsproc = ($this->eso09_obsproc == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_obsproc"] : $this->eso09_obsproc);
            $this->eso09_indundfederacao = ($this->eso09_indundfederacao == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_indundfederacao"] : $this->eso09_indundfederacao);
            $this->eso09_codmuniibge = ($this->eso09_codmuniibge == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_codmuniibge"] : $this->eso09_codmuniibge);
            $this->eso09_idvara = ($this->eso09_idvara == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_idvara"] : $this->eso09_idvara);
            $this->eso09_codsusp = ($this->eso09_codsusp == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_codsusp"] : $this->eso09_codsusp);
            $this->eso09_codsuspexigi = ($this->eso09_codsuspexigi == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_codsuspexigi"] : $this->eso09_codsuspexigi);
            if ($this->eso09_dtdecisao == "") {
                $this->eso09_dtdecisao_dia = ($this->eso09_dtdecisao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_dtdecisao_dia"] : $this->eso09_dtdecisao_dia);
                $this->eso09_dtdecisao_mes = ($this->eso09_dtdecisao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_dtdecisao_mes"] : $this->eso09_dtdecisao_mes);
                $this->eso09_dtdecisao_ano = ($this->eso09_dtdecisao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_dtdecisao_ano"] : $this->eso09_dtdecisao_ano);
                if ($this->eso09_dtdecisao_dia != "") {
                    $this->eso09_dtdecisao = $this->eso09_dtdecisao_ano . "-" . $this->eso09_dtdecisao_mes . "-" . $this->eso09_dtdecisao_dia;
                }
            }
            $this->eso09_inddeposito = ($this->eso09_inddeposito == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_inddeposito"] : $this->eso09_inddeposito);
            $this->eso09_instit = ($this->eso09_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso09_instit"] : $this->eso09_instit);
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();
        if ($this->eso09_sequencial == null) {
            $result = db_query("select nextval('eventos1070_eso09_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: eventos1005_eso09_sequencial_seq do campo: eso09_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->eso09_sequencial = pg_result($result, 0, 0);
        }
        if ($this->eso09_tipoprocesso == null) {
            $this->erro_sql = " Campo eso09_tipoprocesso não informado.";
            $this->erro_campo = "eso09_tipoprocesso";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_nroprocessoadm == null) {
            $this->erro_sql = " Campo eso09_nroprocessoadm não informado.";
            $this->erro_campo = "eso09_nroprocessoadm";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_indautoria == null) {
            $this->erro_sql = " Campo eso09_indautoria não informado.";
            $this->erro_campo = "eso09_indautoria";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_indmateriaproc == null) {
            $this->erro_sql = " Campo eso09_indmateriaproc não informado.";
            $this->erro_campo = "eso09_indmateriaproc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_obsproc == null) {
            $this->erro_sql = " Campo eso09_obsproc não informado.";
            $this->erro_campo = "eso09_obsproc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_indundfederacao == null) {
            $this->erro_sql = " Campo eso09_indundfederacao não informado.";
            $this->erro_campo = "eso09_indundfederacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_codmuniibge == null) {
            $this->erro_sql = " Campo eso09_codmuniibge não informado.";
            $this->erro_campo = "eso09_codmuniibge";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_idvara == null) {
            $this->erro_sql = " Campo eso09_idvara não informado.";
            $this->erro_campo = "eso09_idvara";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_codsusp == null) {
            $this->erro_sql = " Campo eso09_codsusp não informado.";
            $this->erro_campo = "eso09_codsusp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_codsuspexigi == null) {
            $this->erro_sql = " Campo eso09_codsuspexigi não informado.";
            $this->erro_campo = "eso09_codsuspexigi";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_dtdecisao == null) {
            $this->erro_sql = " Campo eso09_dtdecisao não informado.";
            $this->erro_campo = "eso09_dtdecisao_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_inddeposito == null) {
            $this->erro_sql = " Campo eso09_inddeposito não informado.";
            $this->erro_campo = "eso09_inddeposito";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso09_instit == null) {
            $this->erro_sql = " Campo eso09_instit não informado.";
            $this->erro_campo = "eso09_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into eventos1070(
                                       eso09_sequencial
                                      ,eso09_tipoprocesso
                                      ,eso09_nroprocessoadm
                                      ,eso09_indautoria
                                      ,eso09_indmateriaproc
                                      ,eso09_obsproc
                                      ,eso09_indundfederacao
                                      ,eso09_codmuniibge
                                      ,eso09_idvara
                                      ,eso09_codsusp
                                      ,eso09_codsuspexigi
                                      ,eso09_dtdecisao
                                      ,eso09_inddeposito
                                      ,eso09_instit
                       )
                values (
                                $this->eso09_sequencial
                               ,'$this->eso09_tipoprocesso'
                               ,'$this->eso09_nroprocessoadm'
                               ,'$this->eso09_indautoria'
                               ,'$this->eso09_indmateriaproc'
                               ,'$this->eso09_obsproc'
                               ,'$this->eso09_indundfederacao'
                               ,'$this->eso09_codmuniibge'
                               ,'$this->eso09_idvara'
                               ,$this->eso09_codsusp
                               ,'$this->eso09_codsuspexigi'
                               ," . ($this->eso09_dtdecisao == "null" || $this->eso09_dtdecisao == "" ? "null" : "'" . $this->eso09_dtdecisao . "'") . "
                               ,'$this->eso09_inddeposito'
                               ,$this->eso09_instit
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "eventos1070 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "eventos1070 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "eventos1070 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {
        }
        return true;
    }

    // funcao para alteracao
    function alterar($eso09_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update eventos1070 set ";
        $virgula = "";
        if (trim($this->eso09_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_sequencial"])) {
            $sql  .= $virgula . " eso09_sequencial = $this->eso09_sequencial ";
            $virgula = ",";
            if (trim($this->eso09_sequencial) == null) {
                $this->erro_sql = " Campo eso09_sequencial não informado.";
                $this->erro_campo = "eso09_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_tipoprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_tipoprocesso"])) {
            $sql  .= $virgula . " eso09_tipoprocesso = '$this->eso09_tipoprocesso' ";
            $virgula = ",";
            if (trim($this->eso09_tipoprocesso) == null) {
                $this->erro_sql = " Campo eso09_tipoprocesso não informado.";
                $this->erro_campo = "eso09_tipoprocesso";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_nroprocessoadm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_nroprocessoadm"])) {
            $sql  .= $virgula . " eso09_nroprocessoadm = '$this->eso09_nroprocessoadm' ";
            $virgula = ",";
            if (trim($this->eso09_nroprocessoadm) == null) {
                $this->erro_sql = " Campo eso09_nroprocessoadm não informado.";
                $this->erro_campo = "eso09_nroprocessoadm";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_indautoria) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_indautoria"])) {
            $sql  .= $virgula . " eso09_indautoria = '$this->eso09_indautoria' ";
            $virgula = ",";
            if (trim($this->eso09_indautoria) == null) {
                $this->erro_sql = " Campo eso09_indautoria não informado.";
                $this->erro_campo = "eso09_indautoria";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_indmateriaproc) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_indmateriaproc"])) {
            $sql  .= $virgula . " eso09_indmateriaproc = '$this->eso09_indmateriaproc' ";
            $virgula = ",";
            if (trim($this->eso09_indmateriaproc) == null) {
                $this->erro_sql = " Campo eso09_indmateriaproc não informado.";
                $this->erro_campo = "eso09_indmateriaproc";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_obsproc) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_obsproc"])) {
            $sql  .= $virgula . " eso09_obsproc = '$this->eso09_obsproc' ";
            $virgula = ",";
            if (trim($this->eso09_obsproc) == null) {
                $this->erro_sql = " Campo eso09_obsproc não informado.";
                $this->erro_campo = "eso09_obsproc";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_indundfederacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_indundfederacao"])) {
            $sql  .= $virgula . " eso09_indundfederacao = '$this->eso09_indundfederacao' ";
            $virgula = ",";
            if (trim($this->eso09_indundfederacao) == null) {
                $this->erro_sql = " Campo eso09_indundfederacao não informado.";
                $this->erro_campo = "eso09_indundfederacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_codmuniibge) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_codmuniibge"])) {
            $sql  .= $virgula . " eso09_codmuniibge = '$this->eso09_codmuniibge' ";
            $virgula = ",";
            if (trim($this->eso09_codmuniibge) == null) {
                $this->erro_sql = " Campo eso09_codmuniibge não informado.";
                $this->erro_campo = "eso09_codmuniibge";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_idvara) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_idvara"])) {
            $sql  .= $virgula . " eso09_idvara = '$this->eso09_idvara' ";
            $virgula = ",";
            if (trim($this->eso09_idvara) == null) {
                $this->erro_sql = " Campo eso09_idvara não informado.";
                $this->erro_campo = "eso09_idvara";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_codsusp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_codsusp"])) {
            $sql  .= $virgula . " eso09_codsusp = $this->eso09_codsusp ";
            $virgula = ",";
            if (trim($this->eso09_codsusp) == null) {
                $this->erro_sql = " Campo eso09_codsusp não informado.";
                $this->erro_campo = "eso09_codsusp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_codsuspexigi) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_codsuspexigi"])) {
            $sql  .= $virgula . " eso09_codsuspexigi = '$this->eso09_codsuspexigi' ";
            $virgula = ",";
            if (trim($this->eso09_codsuspexigi) == null) {
                $this->erro_sql = " Campo eso09_codsuspexigi não informado.";
                $this->erro_campo = "eso09_codsuspexigi";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_dtdecisao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_dtdecisao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["eso09_dtdecisao_dia"] != "")) {
            $sql  .= $virgula . " eso09_dtdecisao = '$this->eso09_dtdecisao' ";
            $virgula = ",";
            if (trim($this->eso09_dtdecisao) == null) {
                $this->erro_sql = " Campo eso09_dtdecisao não informado.";
                $this->erro_campo = "eso09_dtdecisao_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["eso09_dtdecisao_dia"])) {
                $sql  .= $virgula . " eso09_dtdecisao = null ";
                $virgula = ",";
                if (trim($this->eso09_dtdecisao) == null) {
                    $this->erro_sql = " Campo eso09_dtdecisao não informado.";
                    $this->erro_campo = "eso09_dtdecisao_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->eso09_inddeposito) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_inddeposito"])) {
            $sql  .= $virgula . " eso09_inddeposito = '$this->eso09_inddeposito' ";
            $virgula = ",";
            if (trim($this->eso09_inddeposito) == null) {
                $this->erro_sql = " Campo eso09_inddeposito não informado.";
                $this->erro_campo = "eso09_inddeposito";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso09_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso09_instit"])) {
            $sql  .= $virgula . " eso09_instit = $this->eso09_instit ";
            $virgula = ",";
            if (trim($this->eso09_instit) == null) {
                $this->erro_sql = " Campo eso09_instit não informado.";
                $this->erro_campo = "eso09_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "eso09_sequencial = $this->eso09_sequencial";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "eventos1070 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "eventos1070 nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($eso09_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from eventos1070
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "eso09_sequencial = '$eso09_sequencial'";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "eventos1070 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "eventos1070 nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao do recordset
    function sql_record($sql)
    {
        $result = db_query($sql);
        if ($result == false) {
            $this->numrows    = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Erro ao selecionar os registros.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql   = "Record Vazio na Tabela:eventos1070";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query($eso09_sequencial = null, $campos = "eventos1070.eso09_sequencial,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from eventos1070 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($eso09_sequencial != "" && $eso09_sequencial != null) {
                $sql2 = " where eventos1070.eso09_sequencial = '$eso09_sequencial'";
            }
        } else if ($dbwhere != "") {
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

    // funcao do sql
    function sql_query_file($eso09_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from eventos1070 ";
        $sql2 = "";
        if ($dbwhere == "") {
        } else if ($dbwhere != "") {
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
