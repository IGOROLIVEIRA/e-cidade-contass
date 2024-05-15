<?php
//MODULO: protocolo
//CLASSE DA ENTIDADE nfaberturaprocesso
class cl_nfaberturaprocesso {
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
    public $p111_sequencial = 0;
    public $p111_codproc = 0;
    public $p111_dataenvio_dia = null;
    public $p111_dataenvio_mes = null;
    public $p111_dataenvio_ano = null;
    public $p111_dataenvio = null;
    public $p111_nfe = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 p111_sequencial = int4 = Codigo Sequencial 
                 p111_codproc = int4 = Número de Controle 
                 p111_dataenvio = date = Data de Envio 
                 p111_nfe = int8 = Nota Fiscal 
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("nfaberturaprocesso");
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
            $this->p111_sequencial = ($this->p111_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p111_sequencial"]:$this->p111_sequencial);
            $this->p111_codproc = ($this->p111_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["p111_codproc"]:$this->p111_codproc);
            if ($this->p111_dataenvio == "") {
                $this->p111_dataenvio_dia = ($this->p111_dataenvio_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["p111_dataenvio_dia"]:$this->p111_dataenvio_dia);
                $this->p111_dataenvio_mes = ($this->p111_dataenvio_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["p111_dataenvio_mes"]:$this->p111_dataenvio_mes);
                $this->p111_dataenvio_ano = ($this->p111_dataenvio_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["p111_dataenvio_ano"]:$this->p111_dataenvio_ano);
                if ($this->p111_dataenvio_dia != "") {
                    $this->p111_dataenvio = $this->p111_dataenvio_ano."-".$this->p111_dataenvio_mes."-".$this->p111_dataenvio_dia;
                }
            }
            $this->p111_nfe = ($this->p111_nfe == ""?@$GLOBALS["HTTP_POST_VARS"]["p111_nfe"]:$this->p111_nfe);
        } else {
            $this->p111_sequencial = ($this->p111_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p111_sequencial"]:$this->p111_sequencial);
        }
    }

    // funcao para inclusao
    function incluir ($p111_sequencial) {
        $this->atualizacampos();
        if ($this->p111_codproc == null ) {
            $this->erro_sql = " Campo Número de Controle não informado.";
            $this->erro_campo = "p111_codproc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->p111_dataenvio == null ) {
            $this->erro_sql = " Campo Data de Envio não informado.";
            $this->erro_campo = "p111_dataenvio_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->p111_nfe == null ) {
            $this->erro_sql = " Campo Nota Fiscal não informado.";
            $this->erro_campo = "p111_nfe";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if (($this->p111_sequencial == null) || ($this->p111_sequencial == "") ) {
            $result = db_query("select nextval('nfaberturaprocesso_p111_sequencial_seq')");
            if ($result==false) {
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: nfaberturaprocesso_p111_sequencial_seq do campo: p111_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->p111_sequencial = pg_result($result,0,0);
        } else {
            $result = db_query("select last_value from nfaberturaprocesso_p111_sequencial_seq");
            if (($result != false) && (pg_result($result,0,0) < $p111_sequencial)) {
                $this->erro_sql = " Campo p111_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->p111_sequencial = $p111_sequencial;
            }
        }
        if (($this->p111_sequencial == null) || ($this->p111_sequencial == "") ) {
            $this->erro_sql = " Campo p111_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into nfaberturaprocesso(
                                       p111_sequencial 
                                      ,p111_codproc 
                                      ,p111_dataenvio 
                                      ,p111_nfe 
                       )
                values (
                                $this->p111_sequencial 
                               ,$this->p111_codproc 
                               ,".($this->p111_dataenvio == "null" || $this->p111_dataenvio == ""?"null":"'".$this->p111_dataenvio."'")." 
                               ,$this->p111_nfe 
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "nfaberturaprocesso ($this->p111_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "nfaberturaprocesso já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "nfaberturaprocesso ($this->p111_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->p111_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            $resaco = $this->sql_record($this->sql_query_file($this->p111_sequencial  ));
            if (($resaco!=false)||($this->numrows!=0)) {

                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,1009247,'$this->p111_sequencial','I')");
                $resac = db_query("insert into db_acount values($acount,1010194,1009247,'','".AddSlashes(pg_result($resaco,0,'p111_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010194,1009248,'','".AddSlashes(pg_result($resaco,0,'p111_codproc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010194,1009252,'','".AddSlashes(pg_result($resaco,0,'p111_dataenvio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010194,1009253,'','".AddSlashes(pg_result($resaco,0,'p111_nfe'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        return true;
    }

    // funcao para alteracao
    function alterar ($p111_sequencial=null) {
        $this->atualizacampos();
        $sql = " update nfaberturaprocesso set ";
        $virgula = "";
        if (trim($this->p111_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p111_sequencial"])) {
            $sql  .= $virgula." p111_sequencial = $this->p111_sequencial ";
            $virgula = ",";
            if (trim($this->p111_sequencial) == null ) {
                $this->erro_sql = " Campo Codigo Sequencial não informado.";
                $this->erro_campo = "p111_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p111_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p111_codproc"])) {
            $sql  .= $virgula." p111_codproc = $this->p111_codproc ";
            $virgula = ",";
            if (trim($this->p111_codproc) == null ) {
                $this->erro_sql = " Campo Número de Controle não informado.";
                $this->erro_campo = "p111_codproc";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p111_dataenvio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p111_dataenvio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["p111_dataenvio_dia"] !="") ) {
            $sql  .= $virgula." p111_dataenvio = '$this->p111_dataenvio' ";
            $virgula = ",";
            if (trim($this->p111_dataenvio) == null ) {
                $this->erro_sql = " Campo Data de Envio não informado.";
                $this->erro_campo = "p111_dataenvio_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if (isset($GLOBALS["HTTP_POST_VARS"]["p111_dataenvio_dia"])) {
                $sql  .= $virgula." p111_dataenvio = null ";
                $virgula = ",";
                if (trim($this->p111_dataenvio) == null ) {
                    $this->erro_sql = " Campo Data de Envio não informado.";
                    $this->erro_campo = "p111_dataenvio_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->p111_nfe)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p111_nfe"])) {
            $sql  .= $virgula." p111_nfe = $this->p111_nfe ";
            $virgula = ",";
            if (trim($this->p111_nfe) == null ) {
                $this->erro_sql = " Campo Nota Fiscal não informado.";
                $this->erro_campo = "p111_nfe";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        if ($p111_sequencial!=null) {
            $sql .= " p111_sequencial = $this->p111_sequencial";
        }
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            $resaco = $this->sql_record($this->sql_query_file($this->p111_sequencial));
            if ($this->numrows>0) {

                for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac,0,0);
                    $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                    $resac = db_query("insert into db_acountkey values($acount,1009247,'$this->p111_sequencial','A')");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p111_sequencial"]) || $this->p111_sequencial != "")
                        $resac = db_query("insert into db_acount values($acount,1010194,1009247,'".AddSlashes(pg_result($resaco,$conresaco,'p111_sequencial'))."','$this->p111_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p111_codproc"]) || $this->p111_codproc != "")
                        $resac = db_query("insert into db_acount values($acount,1010194,1009248,'".AddSlashes(pg_result($resaco,$conresaco,'p111_codproc'))."','$this->p111_codproc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p111_dataenvio"]) || $this->p111_dataenvio != "")
                        $resac = db_query("insert into db_acount values($acount,1010194,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'p111_dataenvio'))."','$this->p111_dataenvio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p111_nfe"]) || $this->p111_nfe != "")
                        $resac = db_query("insert into db_acount values($acount,1010194,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'p111_nfe'))."','$this->p111_nfe',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                }
            }
        }
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "nfaberturaprocesso nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->p111_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "nfaberturaprocesso nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->p111_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->p111_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ($p111_sequencial=null,$dbwhere=null) {

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            if ($dbwhere==null || $dbwhere=="") {

                $resaco = $this->sql_record($this->sql_query_file($p111_sequencial));
            } else {
                $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
            }
            if (($resaco != false) || ($this->numrows!=0)) {

                for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

                    $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac,0,0);
                    $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                    $resac  = db_query("insert into db_acountkey values($acount,1009247,'$p111_sequencial','E')");
                    $resac  = db_query("insert into db_acount values($acount,1010194,1009247,'','".AddSlashes(pg_result($resaco,$iresaco,'p111_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010194,1009248,'','".AddSlashes(pg_result($resaco,$iresaco,'p111_codproc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010194,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'p111_dataenvio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010194,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'p111_nfe'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                }
            }
        }
        $sql = " delete from nfaberturaprocesso
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            if ($p111_sequencial != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " p111_sequencial = $p111_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "nfaberturaprocesso nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$p111_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "nfaberturaprocesso nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$p111_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$p111_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:nfaberturaprocesso";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $p111_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from nfaberturaprocesso ";
        $sql .= "      inner join protprocesso  on  protprocesso.p58_codproc = nfaberturaprocesso.p111_codproc";
        $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
        $sql .= "      inner join db_config  on  db_config.codigo = protprocesso.p58_instit";
        $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
        $sql .= "      inner join db_depart  on  db_depart.coddepto = protprocesso.p58_coddepto";
        $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($p111_sequencial!=null ) {
                $sql2 .= " where nfaberturaprocesso.p111_sequencial = $p111_sequencial ";
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
    function sql_query_file ( $p111_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from nfaberturaprocesso ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($p111_sequencial!=null ) {
                $sql2 .= " where nfaberturaprocesso.p111_sequencial = $p111_sequencial ";
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
}
?>