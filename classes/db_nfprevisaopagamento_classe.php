<?php
//MODULO: protocolo
//CLASSE DA ENTIDADE nfprevisaopagamento
class cl_nfprevisaopagamento {
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
    public $p112_sequencial = 0;
    public $p112_codproc = 0;
    public $p112_nfe = 0;
    public $p112_dataliquidacao_dia = null;
    public $p112_dataliquidacao_mes = null;
    public $p112_dataliquidacao_ano = null;
    public $p112_dataliquidacao = null;
    public $p112_dataprevisao_dia = null;
    public $p112_dataprevisao_mes = null;
    public $p112_dataprevisao_ano = null;
    public $p112_dataprevisao = null;
    public $p112_nfgeral = 'f';
    public $p112_nfaberturaprocesso = 0;
    public $p112_dataenvio_dia = null;
    public $p112_dataenvio_mes = null;
    public $p112_dataenvio_ano = null;
    public $p112_dataenvio = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 p112_sequencial = int4 = Codigo Sequencial 
                 p112_codproc = int4 = Número de Controle 
                 p112_nfe = int8 = Nota Fiscal 
                 p112_dataliquidacao = date = Liquidacao 
                 p112_dataprevisao = date = Previsao 
                 p112_nfgeral = bool = p112_nfgeral 
                 p112_nfaberturaprocesso = int4 = Código Abertura de Processo 
                 p112_dataenvio = date = Data de Envio 
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("nfprevisaopagamento");
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
            $this->p112_sequencial = ($this->p112_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_sequencial"]:$this->p112_sequencial);
            $this->p112_codproc = ($this->p112_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_codproc"]:$this->p112_codproc);
            $this->p112_nfe = ($this->p112_nfe == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_nfe"]:$this->p112_nfe);
            if ($this->p112_dataliquidacao == "") {
                $this->p112_dataliquidacao_dia = ($this->p112_dataliquidacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_dataliquidacao_dia"]:$this->p112_dataliquidacao_dia);
                $this->p112_dataliquidacao_mes = ($this->p112_dataliquidacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_dataliquidacao_mes"]:$this->p112_dataliquidacao_mes);
                $this->p112_dataliquidacao_ano = ($this->p112_dataliquidacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_dataliquidacao_ano"]:$this->p112_dataliquidacao_ano);
                if ($this->p112_dataliquidacao_dia != "") {
                    $this->p112_dataliquidacao = $this->p112_dataliquidacao_ano."-".$this->p112_dataliquidacao_mes."-".$this->p112_dataliquidacao_dia;
                }
            }
            if ($this->p112_dataprevisao == "") {
                $this->p112_dataprevisao_dia = ($this->p112_dataprevisao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_dataprevisao_dia"]:$this->p112_dataprevisao_dia);
                $this->p112_dataprevisao_mes = ($this->p112_dataprevisao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_dataprevisao_mes"]:$this->p112_dataprevisao_mes);
                $this->p112_dataprevisao_ano = ($this->p112_dataprevisao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_dataprevisao_ano"]:$this->p112_dataprevisao_ano);
                if ($this->p112_dataprevisao_dia != "") {
                    $this->p112_dataprevisao = $this->p112_dataprevisao_ano."-".$this->p112_dataprevisao_mes."-".$this->p112_dataprevisao_dia;
                }
            }
            $this->p112_nfgeral = ($this->p112_nfgeral == "f"?@$GLOBALS["HTTP_POST_VARS"]["p112_nfgeral"]:$this->p112_nfgeral);
            $this->p112_nfaberturaprocesso = ($this->p112_nfaberturaprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_nfaberturaprocesso"]:$this->p112_nfaberturaprocesso);
            if ($this->p112_dataenvio == "") {
                $this->p112_dataenvio_dia = ($this->p112_dataenvio_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_dataenvio_dia"]:$this->p112_dataenvio_dia);
                $this->p112_dataenvio_mes = ($this->p112_dataenvio_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_dataenvio_mes"]:$this->p112_dataenvio_mes);
                $this->p112_dataenvio_ano = ($this->p112_dataenvio_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_dataenvio_ano"]:$this->p112_dataenvio_ano);
                if ($this->p112_dataenvio_dia != "") {
                    $this->p112_dataenvio = $this->p112_dataenvio_ano."-".$this->p112_dataenvio_mes."-".$this->p112_dataenvio_dia;
                }
            }
        } else {
            $this->p112_sequencial = ($this->p112_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p112_sequencial"]:$this->p112_sequencial);
        }
    }

    // funcao para inclusao
    function incluir ($p112_sequencial) {
        $this->atualizacampos();
        if ($this->p112_codproc == null ) {
            $this->erro_sql = " Campo Número de Controle não informado.";
            $this->erro_campo = "p112_codproc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->p112_nfe == null ) {
            $this->erro_sql = " Campo Nota Fiscal não informado.";
            $this->erro_campo = "p112_nfe";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->p112_dataliquidacao == null ) {
            $this->erro_sql = " Campo Liquidacao não informado.";
            $this->erro_campo = "p112_dataliquidacao_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->p112_dataprevisao == null ) {
            $this->erro_sql = " Campo Previsao não informado.";
            $this->erro_campo = "p112_dataprevisao_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->p112_nfgeral == null ) {
            $this->p112_nfgeral = "f";
        }
        if ($this->p112_nfaberturaprocesso == null ) {
            $this->p112_nfaberturaprocesso = "null";
        }

        if ($this->p112_dataenvio == null ) {
            $this->erro_sql = " Campo Data de Envio não informado.";
            $this->erro_campo = "p112_dataenvio_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        if (($this->p112_sequencial == null) || ($this->p112_sequencial == "") ) {
            $result = db_query("select nextval('nfprevisaopagamento_p112_sequencial_seq')");
            if ($result==false) {
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: nfprevisaopagamento_p112_sequencial_seq do campo: p112_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->p112_sequencial = pg_result($result,0,0);
        } else {
            $result = db_query("select last_value from nfprevisaopagamento_p112_sequencial_seq");
            if (($result != false) && (pg_result($result,0,0) < $p112_sequencial)) {
                $this->erro_sql = " Campo p112_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->p112_sequencial = $p112_sequencial;
            }
        }
        if (($this->p112_sequencial == null) || ($this->p112_sequencial == "") ) {
            $this->erro_sql = " Campo p112_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into nfprevisaopagamento(
                                       p112_sequencial 
                                      ,p112_codproc 
                                      ,p112_nfe 
                                      ,p112_dataliquidacao 
                                      ,p112_dataprevisao 
                                      ,p112_nfgeral 
                                      ,p112_nfaberturaprocesso 
                                      ,p112_dataenvio 
                       )
                values (
                                $this->p112_sequencial 
                               ,$this->p112_codproc 
                               ,$this->p112_nfe 
                               ,".($this->p112_dataliquidacao == "null" || $this->p112_dataliquidacao == ""?"null":"'".$this->p112_dataliquidacao."'")." 
                               ,".($this->p112_dataprevisao == "null" || $this->p112_dataprevisao == ""?"null":"'".$this->p112_dataprevisao."'")." 
                               ,'$this->p112_nfgeral' 
                               ,$this->p112_nfaberturaprocesso 
                               ,".($this->p112_dataenvio == "null" || $this->p112_dataenvio == ""?"null":"'".$this->p112_dataenvio."'")." 
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "nfprevisaopagamento ($this->p112_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "nfprevisaopagamento já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "nfprevisaopagamento ($this->p112_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->p112_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            $resaco = $this->sql_record($this->sql_query_file($this->p112_sequencial  ));
            if (($resaco!=false)||($this->numrows!=0)) {

                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,1009254,'$this->p112_sequencial','I')");
                $resac = db_query("insert into db_acount values($acount,1010195,1009254,'','".AddSlashes(pg_result($resaco,0,'p112_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009255,'','".AddSlashes(pg_result($resaco,0,'p112_codproc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009256,'','".AddSlashes(pg_result($resaco,0,'p112_nfe'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009257,'','".AddSlashes(pg_result($resaco,0,'p112_dataliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009258,'','".AddSlashes(pg_result($resaco,0,'p112_dataprevisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009267,'','".AddSlashes(pg_result($resaco,0,'p112_nfgeral'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009266,'','".AddSlashes(pg_result($resaco,0,'p112_nfaberturaprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009259,'','".AddSlashes(pg_result($resaco,0,'p112_dataenvio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        return true;
    }

    // funcao para alteracao
    function alterar ($p112_sequencial=null) {
        $this->atualizacampos();
        $sql = " update nfprevisaopagamento set ";
        $virgula = "";
        if (trim($this->p112_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p112_sequencial"])) {
            $sql  .= $virgula." p112_sequencial = $this->p112_sequencial ";
            $virgula = ",";
            if (trim($this->p112_sequencial) == null ) {
                $this->erro_sql = " Campo Codigo Sequencial não informado.";
                $this->erro_campo = "p112_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p112_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p112_codproc"])) {
            $sql  .= $virgula." p112_codproc = $this->p112_codproc ";
            $virgula = ",";
            if (trim($this->p112_codproc) == null ) {
                $this->erro_sql = " Campo Número de Controle não informado.";
                $this->erro_campo = "p112_codproc";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p112_nfe)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p112_nfe"])) {
            $sql  .= $virgula." p112_nfe = $this->p112_nfe ";
            $virgula = ",";
            if (trim($this->p112_nfe) == null ) {
                $this->erro_sql = " Campo Nota Fiscal não informado.";
                $this->erro_campo = "p112_nfe";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p112_dataliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p112_dataliquidacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["p112_dataliquidacao_dia"] !="") ) {
            $sql  .= $virgula." p112_dataliquidacao = '$this->p112_dataliquidacao' ";
            $virgula = ",";
            if (trim($this->p112_dataliquidacao) == null ) {
                $this->erro_sql = " Campo Liquidacao não informado.";
                $this->erro_campo = "p112_dataliquidacao_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if (isset($GLOBALS["HTTP_POST_VARS"]["p112_dataliquidacao_dia"])) {
                $sql  .= $virgula." p112_dataliquidacao = null ";
                $virgula = ",";
                if (trim($this->p112_dataliquidacao) == null ) {
                    $this->erro_sql = " Campo Liquidacao não informado.";
                    $this->erro_campo = "p112_dataliquidacao_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->p112_dataprevisao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p112_dataprevisao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["p112_dataprevisao_dia"] !="") ) {
            $sql  .= $virgula." p112_dataprevisao = '$this->p112_dataprevisao' ";
            $virgula = ",";
            if (trim($this->p112_dataprevisao) == null ) {
                $this->erro_sql = " Campo Previsao não informado.";
                $this->erro_campo = "p112_dataprevisao_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if (isset($GLOBALS["HTTP_POST_VARS"]["p112_dataprevisao_dia"])) {
                $sql  .= $virgula." p112_dataprevisao = null ";
                $virgula = ",";
                if (trim($this->p112_dataprevisao) == null ) {
                    $this->erro_sql = " Campo Previsao não informado.";
                    $this->erro_campo = "p112_dataprevisao_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->p112_nfgeral)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p112_nfgeral"])) {
            $sql  .= $virgula." p112_nfgeral = '$this->p112_nfgeral' ";
            $virgula = ",";
            if (trim($this->p112_nfgeral) == null ) {
                $this->erro_sql = " Campo p112_nfgeral não informado.";
                $this->erro_campo = "p112_nfgeral";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p112_nfaberturaprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p112_nfaberturaprocesso"])) {
            if (trim($this->p112_nfaberturaprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["p112_nfaberturaprocesso"])) {
                $this->p112_nfaberturaprocesso = "0" ;
            }
            $sql  .= $virgula." p112_nfaberturaprocesso = $this->p112_nfaberturaprocesso ";
            $virgula = ",";
        }
        if (trim($this->p112_dataenvio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p112_dataenvio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["p112_dataenvio_dia"] !="") ) {
            $sql  .= $virgula." p112_dataenvio = '$this->p112_dataenvio' ";
            $virgula = ",";
            if (trim($this->p112_dataenvio) == null ) {
                $this->erro_sql = " Campo Data de Envio não informado.";
                $this->erro_campo = "p112_dataenvio_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if (isset($GLOBALS["HTTP_POST_VARS"]["p112_dataenvio_dia"])) {
                $sql  .= $virgula." p112_dataenvio = null ";
                $virgula = ",";
                if (trim($this->p112_dataenvio) == null ) {
                    $this->erro_sql = " Campo Data de Envio não informado.";
                    $this->erro_campo = "p112_dataenvio_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        $sql .= " where ";
        if ($p112_sequencial!=null) {
            $sql .= " p112_sequencial = $this->p112_sequencial";
        }
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            $resaco = $this->sql_record($this->sql_query_file($this->p112_sequencial));
            if ($this->numrows>0) {

                for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac,0,0);
                    $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                    $resac = db_query("insert into db_acountkey values($acount,1009254,'$this->p112_sequencial','A')");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p112_sequencial"]) || $this->p112_sequencial != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'p112_sequencial'))."','$this->p112_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p112_codproc"]) || $this->p112_codproc != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'p112_codproc'))."','$this->p112_codproc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p112_nfe"]) || $this->p112_nfe != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'p112_nfe'))."','$this->p112_nfe',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p112_dataliquidacao"]) || $this->p112_dataliquidacao != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'p112_dataliquidacao'))."','$this->p112_dataliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p112_dataprevisao"]) || $this->p112_dataprevisao != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'p112_dataprevisao'))."','$this->p112_dataprevisao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p112_nfgeral"]) || $this->p112_nfgeral != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009267,'".AddSlashes(pg_result($resaco,$conresaco,'p112_nfgeral'))."','$this->p112_nfgeral',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p112_nfaberturaprocesso"]) || $this->p112_nfaberturaprocesso != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009266,'".AddSlashes(pg_result($resaco,$conresaco,'p112_nfaberturaprocesso'))."','$this->p112_nfaberturaprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p112_dataenvio"]) || $this->p112_dataenvio != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009259,'".AddSlashes(pg_result($resaco,$conresaco,'p112_dataenvio'))."','$this->p112_dataenvio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                }
            }
        }
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "nfprevisaopagamento nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->p112_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "nfprevisaopagamento nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->p112_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->p112_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ($p112_sequencial=null,$dbwhere=null) {

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            if ($dbwhere==null || $dbwhere=="") {

                $resaco = $this->sql_record($this->sql_query_file($p112_sequencial));
            } else {
                $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
            }
            if (($resaco != false) || ($this->numrows!=0)) {

                for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

                    $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac,0,0);
                    $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                    $resac  = db_query("insert into db_acountkey values($acount,1009254,'$p112_sequencial','E')");
                    $resac  = db_query("insert into db_acount values($acount,1010195,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'p112_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'p112_codproc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'p112_nfe'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'p112_dataliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'p112_dataprevisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,1009267,'','".AddSlashes(pg_result($resaco,$iresaco,'p112_nfgeral'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,1009266,'','".AddSlashes(pg_result($resaco,$iresaco,'p112_nfaberturaprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,1009259,'','".AddSlashes(pg_result($resaco,$iresaco,'p112_dataenvio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                }
            }
        }
        $sql = " delete from nfprevisaopagamento
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            if ($p112_sequencial != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " p112_sequencial = $p112_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "nfprevisaopagamento nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$p112_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "nfprevisaopagamento nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$p112_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$p112_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:nfprevisaopagamento";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $p112_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from nfprevisaopagamento ";
        $sql .= "      inner join protprocesso  on  protprocesso.p58_codproc = nfprevisaopagamento.p112_codproc";
        $sql .= "      left  join nfaberturaprocesso  on  nfaberturaprocesso.p111_sequencial = nfprevisaopagamento.p112_nfaberturaprocesso";
        $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
        $sql .= "      inner join db_config  on  db_config.codigo = protprocesso.p58_instit";
        $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
        $sql .= "      inner join db_depart  on  db_depart.coddepto = protprocesso.p58_coddepto";
        $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
        $sql .= "      inner join protprocesso  on  protprocesso.p58_codproc = nfaberturaprocesso.p111_codproc";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($p112_sequencial!=null ) {
                $sql2 .= " where nfprevisaopagamento.p112_sequencial = $p112_sequencial ";
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
    function sql_query_file ( $p112_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from nfprevisaopagamento ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($p112_sequencial!=null ) {
                $sql2 .= " where nfprevisaopagamento.p112_sequencial = $p112_sequencial ";
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
