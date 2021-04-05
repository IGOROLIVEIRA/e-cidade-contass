<?php
//MODULO: sicom
//CLASSE DA ENTIDADE exeobras202021
class cl_exeobras202021 {
    // cria variaveis de erro
    public $rotulo     = null;
    public $query_sql  = null;
    public $numrows    = 0;
    public $numrows_incluir = 0;
    public $numrows_alterar = 0;
    public $numrows_excluir = 0;
    public $erro_status= null;
    public $erro_sql   = null;
    public $erro_banco = null;
    public $erro_msg   = null;
    public $erro_campo = null;
    public $pagina_retorno = null;
    // cria variaveis do arquivo
    public $si204_sequencial = 0;
    public $si204_tiporegistro = 0;
    public $si204_codorgao = null;
    public $si204_codunidadesub = null;
    public $si204_nrocontrato = 0;
    public $si204_exerciciocontrato = 0;
    public $si204_nroprocesso  = null;
    public $si204_tipoprocesso  = null;
    public $si204_codobra = 0;
    public $si204_objeto = null;
    public $si204_linkobra = null;
    public $si204_mes = 0;
    public $si204_instit = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 si204_sequencial = int8 = Sequencial
                 si204_tiporegistro = int8 = Tiporegistro
                 si204_codorgao = text = codorgaoresp
                 si204_codunidadesub = text = codUnidadeSubRespEstadual
                 si204_nrocontrato = int8 = nroContrato
                 si204_exerciciocontrato = int4 = exercicioLicitacao
                 si204_nroprocesso = int4 = numero do processo
                 si204_tipoprocesso = int4 = tipo processo
                 si204_codobra = int8 = codigoobra
                 si204_objeto = text = objeto
                 si204_linkobra = text = linkobra
                 si204_mes = int4 = Mes
                 si204_instit = int4 = Instituição
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("exeobras202021");
        $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
    }

    //funcao erro
    function erro($mostra,$retorna) {
        if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )) {
            echo "<script>alert(\"".$this->erro_msg."\");</script>";
            if ($retorna==true) {
                echo "<script>location.href='".$this->pagina_retorno."'</script>";
            }
        }
    }

    // funcao para atualizar campos
    function atualizacampos($exclusao=false) {
        if ($exclusao==false) {
            $this->si204_sequencial = ($this->si204_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_sequencial"]:$this->si204_sequencial);
            $this->si204_tiporegistro = ($this->si204_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_tiporegistro"]:$this->si204_tiporegistro);
            $this->si204_codorgao = ($this->si204_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_codorgao"]:$this->si204_codorgao);
            $this->si204_codunidadesub = ($this->si204_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_codunidadesub"]:$this->si204_codunidadesub);
            $this->si204_nrocontrato = ($this->si204_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_nrocontrato"]:$this->si204_nrocontrato);
            $this->si204_exerciciocontrato = ($this->si204_exerciciocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_exerciciocontrato"]:$this->si204_exerciciocontrato);
            $this->si204_nroprocesso = ($this->si204_nroprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_nroprocesso"]:$this->si204_nroprocesso);
            $this->si204_tipoprocesso = ($this->si204_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_tipoprocesso"]:$this->si204_tipoprocesso);
            $this->si204_objeto = ($this->si204_objeto == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_objeto"]:$this->si204_objeto);
            $this->si204_linkobra = ($this->si204_linkobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_linkobra"]:$this->si204_linkobra);
            $this->si204_mes = ($this->si204_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_mes"]:$this->si204_mes);
            $this->si204_instit = ($this->si204_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_instit"]:$this->si204_instit);
        } else {
        }
    }

    // funcao para inclusao
    function incluir () {
        $this->atualizacampos();
        if ($this->si204_sequencial == null ) {
            $result = db_query("select nextval('exeobras202021_si204_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: exeobras202021_si204_sequencial_seq do campo: si204_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->si204_sequencial = pg_result($result,0,0);
        }
        if ($this->si204_tiporegistro == null ) {
            $this->erro_sql = " Campo Tiporegistro não informado.";
            $this->erro_campo = "si204_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si204_codorgao == null ) {
            $this->erro_sql = " Campo codorgaoresp não informado.";
            $this->erro_campo = "si204_codorgao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si204_codunidadesub == null ) {
            $this->erro_sql = " Campo codUnidadeSubRespEstadual não informado.";
            $this->erro_campo = "si204_codunidadesub";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si204_nrocontrato == null ) {
            $this->erro_sql = " Campo nroContrato não informado.";
            $this->erro_campo = "si204_nrocontrato";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si204_exerciciocontrato == null ) {
            $this->erro_sql = " Campo exercicioLicitacao não informado.";
            $this->erro_campo = "si204_exerciciocontrato";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si204_codobra == null ) {
            $this->erro_sql = " Campo codigoobra não informado.";
            $this->erro_campo = "si204_codobra";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si204_objeto == null ) {
            $this->erro_sql = " Campo objeto não informado.";
            $this->erro_campo = "si204_objeto";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si204_linkobra == null ) {
            $this->erro_sql = " Campo linkobra não informado.";
            $this->erro_campo = "si204_linkobra";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si204_mes == null ) {
            $this->erro_sql = " Campo Mes não informado.";
            $this->erro_campo = "si204_mes";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si204_instit == null ) {
            $this->erro_sql = " Campo Instituição não informado.";
            $this->erro_campo = "si204_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into exeobras202021(
                                       si204_sequencial
                                      ,si204_tiporegistro
                                      ,si204_codorgao
                                      ,si204_codunidadesub
                                      ,si204_nrocontrato
                                      ,si204_exerciciocontrato
                                      ,si204_nroprocesso
                                      ,si204_tipoprocesso
                                      ,si204_codobra
                                      ,si204_objeto
                                      ,si204_linkobra
                                      ,si204_mes
                                      ,si204_instit
                       )
                values (
                                $this->si204_sequencial
                               ,$this->si204_tiporegistro
                               ,'$this->si204_codorgao'
                               ,'$this->si204_codunidadesub'
                               ,$this->si204_nrocontrato
                               ,$this->si204_exerciciocontrato
                               ,$this->si204_nroprocesso
                               ,$this->si204_tipoprocesso
                               ,$this->si204_codobra
                               ,'$this->si204_objeto'
                               ,'$this->si204_linkobra'
                               ,$this->si204_mes
                               ,$this->si204_instit
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "execucao de obras () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "execucao de obras já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "execucao de obras () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

        }
        return true;
    }

    // funcao para alteracao
    function alterar ( $si204_sequencial=null ) {
        $this->atualizacampos();
        $sql = " update exeobras202021 set ";
        $virgula = "";
        if (trim($this->si204_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_sequencial"])) {
            $sql  .= $virgula." si204_sequencial = $this->si204_sequencial ";
            $virgula = ",";
            if (trim($this->si204_sequencial) == null ) {
                $this->erro_sql = " Campo Sequencial não informado.";
                $this->erro_campo = "si204_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_tiporegistro"])) {
            $sql  .= $virgula." si204_tiporegistro = $this->si204_tiporegistro ";
            $virgula = ",";
            if (trim($this->si204_tiporegistro) == null ) {
                $this->erro_sql = " Campo Tiporegistro não informado.";
                $this->erro_campo = "si204_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_codorgao"])) {
            $sql  .= $virgula." si204_codorgao = '$this->si204_codorgao' ";
            $virgula = ",";
            if (trim($this->si204_codorgao) == null ) {
                $this->erro_sql = " Campo codorgaoresp não informado.";
                $this->erro_campo = "si204_codorgao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_codunidadesub"])) {
            $sql  .= $virgula." si204_codunidadesub = '$this->si204_codunidadesub' ";
            $virgula = ",";
            if (trim($this->si204_codunidadesub) == null ) {
                $this->erro_sql = " Campo codUnidadeSubRespEstadual não informado.";
                $this->erro_campo = "si204_codunidadesub";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_nrocontrato"])) {
            $sql  .= $virgula." si204_nrocontrato = $this->si204_nrocontrato ";
            $virgula = ",";
            if (trim($this->si204_nrocontrato) == null ) {
                $this->erro_sql = " Campo nroContrato não informado.";
                $this->erro_campo = "si204_nrocontrato";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_exerciciocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_exerciciocontrato"])) {
            $sql  .= $virgula." si204_exerciciocontrato = $this->si204_exerciciocontrato ";
            $virgula = ",";
            if (trim($this->si204_exerciciocontrato) == null ) {
                $this->erro_sql = " Campo exercicioLicitacao não informado.";
                $this->erro_campo = "si204_exerciciocontrato";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_codobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_codobra"])) {
            $sql  .= $virgula." si204_codobra = $this->si204_codobra ";
            $virgula = ",";
            if (trim($this->si204_codobra) == null ) {
                $this->erro_sql = " Campo codigoobra não informado.";
                $this->erro_campo = "si204_codobra";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_objeto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_objeto"])) {
            $sql  .= $virgula." si204_objeto = '$this->si204_objeto' ";
            $virgula = ",";
            if (trim($this->si204_objeto) == null ) {
                $this->erro_sql = " Campo objeto não informado.";
                $this->erro_campo = "si204_objeto";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_linkobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_linkobra"])) {
            $sql  .= $virgula." si204_linkobra = '$this->si204_linkobra' ";
            $virgula = ",";
            if (trim($this->si204_linkobra) == null ) {
                $this->erro_sql = " Campo linkobra não informado.";
                $this->erro_campo = "si204_linkobra";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_mes"])) {
            $sql  .= $virgula." si204_mes = $this->si204_mes ";
            $virgula = ",";
            if (trim($this->si204_mes) == null ) {
                $this->erro_sql = " Campo Mes não informado.";
                $this->erro_campo = "si204_mes";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si204_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si204_instit"])) {
            $sql  .= $virgula." si204_instit = $this->si204_instit ";
            $virgula = ",";
            if (trim($this->si204_instit) == null ) {
                $this->erro_sql = " Campo Instituição não informado.";
                $this->erro_campo = "si204_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "si204_sequencial = '$si204_sequencial'";     $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "execucao de obras nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "execucao de obras nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ( $si204_sequencial=null ,$dbwhere=null) {

        $sql = " delete from exeobras202021
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            $sql2 = "si204_sequencial = '$si204_sequencial'";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "execucao de obras nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "execucao de obras nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao do recordset
    function sql_record($sql) {
        $result = db_query($sql);
        if ($result==false) {
            $this->numrows    = 0;
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Erro ao selecionar os registros.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows==0) {
            $this->erro_banco = "";
            $this->erro_sql   = "Record Vazio na Tabela:exeobras202021";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $si204_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
        $sql = "select ";
        if ($campos != "*" ) {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from exeobras202021 ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ( $si204_sequencial != "" && $si204_sequencial != null) {
                $sql2 = " where exeobras202021.si204_sequencial = '$si204_sequencial'";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null ) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    // funcao do sql
    function sql_query_file ( $si204_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
        $sql = "select ";
        if ($campos != "*" ) {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from exeobras202021 ";
        $sql2 = "";
        if ($dbwhere=="") {
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null ) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
}
?>
