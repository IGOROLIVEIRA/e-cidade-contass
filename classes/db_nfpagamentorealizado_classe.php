<?php
//MODULO: protocolo
//CLASSE DA ENTIDADE nfpagamentorealizado
class cl_nfpagamentorealizado {
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
    public $p113_sequencial = 0;
    public $p113_codproc = 0;
    public $p113_nfe = 0;
    public $p113_numpagamento = 0;
    public $p113_nfgeral = 'f';
    public $p113_nfaberturaprocesso = 0;
    public $p113_nfprevisaopagamento = 0;
    public $p113_dataenvio_dia = null;
    public $p113_dataenvio_mes = null;
    public $p113_dataenvio_ano = null;
    public $p113_dataenvio = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 p113_sequencial = int4 = Codigo Sequencial 
                 p113_codproc = int4 = Numero do código do Processo 
                 p113_nfe = int8 = Nota Fiscal 
                 p113_numpagamento = int8 = Numero de Pagamento 
                 p113_nfgeral = bool = p113_nfgeral 
                 p113_nfaberturaprocesso = int4 = Código de Abertura de Processo 
                 p113_nfprevisaopagamento = int4 = Código Previsão de Pagamento 
                 p113_dataenvio = date = Data de Envio 
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("nfpagamentorealizado");
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
            $this->p113_sequencial = ($this->p113_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_sequencial"]:$this->p113_sequencial);
            $this->p113_codproc = ($this->p113_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_codproc"]:$this->p113_codproc);
            $this->p113_nfe = ($this->p113_nfe == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_nfe"]:$this->p113_nfe);
            $this->p113_numpagamento = ($this->p113_numpagamento == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_numpagamento"]:$this->p113_numpagamento);
            $this->p113_nfgeral = ($this->p113_nfgeral == "f"?@$GLOBALS["HTTP_POST_VARS"]["p113_nfgeral"]:$this->p113_nfgeral);
            $this->p113_nfaberturaprocesso = ($this->p113_nfaberturaprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_nfaberturaprocesso"]:$this->p113_nfaberturaprocesso);
            $this->p113_nfprevisaopagamento = ($this->p113_nfprevisaopagamento == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_nfprevisaopagamento"]:$this->p113_nfprevisaopagamento);
            if ($this->p113_dataenvio == "") {
                $this->p113_dataenvio_dia = ($this->p113_dataenvio_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_dataenvio_dia"]:$this->p113_dataenvio_dia);
                $this->p113_dataenvio_mes = ($this->p113_dataenvio_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_dataenvio_mes"]:$this->p113_dataenvio_mes);
                $this->p113_dataenvio_ano = ($this->p113_dataenvio_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_dataenvio_ano"]:$this->p113_dataenvio_ano);
                if ($this->p113_dataenvio_dia != "") {
                    $this->p113_dataenvio = $this->p113_dataenvio_ano."-".$this->p113_dataenvio_mes."-".$this->p113_dataenvio_dia;
                }
            }
        } else {
            $this->p113_sequencial = ($this->p113_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p113_sequencial"]:$this->p113_sequencial);
        }
    }

    // funcao para inclusao
    function incluir ($p113_sequencial) {
        $this->atualizacampos();
        if ($this->p113_codproc == null ) {
            $this->erro_sql = " Campo Numero do código do Processo não informado.";
            $this->erro_campo = "p113_codproc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->p113_nfe == null ) {
            $this->erro_sql = " Campo Nota Fiscal não informado.";
            $this->erro_campo = "p113_nfe";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->p113_numpagamento == null ) {
            $this->erro_sql = " Campo Numero de Pagamento não informado.";
            $this->erro_campo = "p113_numpagamento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->p113_nfgeral == null ) {
            $this->p113_nfgeral = "f";
        }
        if ($this->p113_nfaberturaprocesso == null ) {
            $this->p113_nfaberturaprocesso = "null";
        }
        if ($this->p113_nfprevisaopagamento == null ) {
            $this->p113_nfprevisaopagamento = "null";
        }
        if ($this->p113_dataenvio == null ) {
            $this->erro_sql = " Campo Data de Envio não informado.";
            $this->erro_campo = "p113_dataenvio_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if (($this->p113_sequencial == null) || ($this->p113_sequencial == "") ) {
            $result = db_query("select nextval('nfpagamentorealizado_p113_sequencial_seq')");
            if ($result==false) {
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: nfpagamentorealizado_p113_sequencial_seq do campo: p113_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->p113_sequencial = pg_result($result,0,0);
        } else {
            $result = db_query("select last_value from nfpagamentorealizado_p113_sequencial_seq");
            if (($result != false) && (pg_result($result,0,0) < $p113_sequencial)) {
                $this->erro_sql = " Campo p113_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->p113_sequencial = $p113_sequencial;
            }
        }

        if (($this->p113_sequencial == null) || ($this->p113_sequencial == "") ) {
            $this->erro_sql = " Campo p113_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into nfpagamentorealizado(
                                       p113_sequencial 
                                      ,p113_codproc 
                                      ,p113_nfe 
                                      ,p113_numpagamento 
                                      ,p113_nfgeral 
                                      ,p113_nfaberturaprocesso 
                                      ,p113_nfprevisaopagamento 
                                      ,p113_dataenvio 
                       )
                values (
                                $this->p113_sequencial 
                               ,$this->p113_codproc 
                               ,$this->p113_nfe 
                               ,$this->p113_numpagamento 
                               ,'$this->p113_nfgeral' 
                               ,$this->p113_nfaberturaprocesso 
                               ,$this->p113_nfprevisaopagamento 
                               ,".($this->p113_dataenvio == "null" || $this->p113_dataenvio == ""?"null":"'".$this->p113_dataenvio."'")." 
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "nfpagamentorealizado ($this->p113_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "nfpagamentorealizado já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "nfpagamentorealizado ($this->p113_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->p113_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            $resaco = $this->sql_record($this->sql_query_file($this->p113_sequencial  ));
            if (($resaco!=false)||($this->numrows!=0)) {

                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,1009260,'$this->p113_sequencial','I')");
                $resac = db_query("insert into db_acount values($acount,1010196,1009260,'','".AddSlashes(pg_result($resaco,0,'p113_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010196,1009261,'','".AddSlashes(pg_result($resaco,0,'p113_codproc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010196,1009263,'','".AddSlashes(pg_result($resaco,0,'p113_nfe'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010196,1009264,'','".AddSlashes(pg_result($resaco,0,'p113_numpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010196,1009268,'','".AddSlashes(pg_result($resaco,0,'p113_nfgeral'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010196,1009269,'','".AddSlashes(pg_result($resaco,0,'p113_nfaberturaprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010196,1009270,'','".AddSlashes(pg_result($resaco,0,'p113_nfprevisaopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010196,1009265,'','".AddSlashes(pg_result($resaco,0,'p113_dataenvio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        return true;
    }

    // funcao para alteracao
    function alterar ($p113_sequencial=null) {
        $this->atualizacampos();
        $sql = " update nfpagamentorealizado set ";
        $virgula = "";
        if (trim($this->p113_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p113_sequencial"])) {
            $sql  .= $virgula." p113_sequencial = $this->p113_sequencial ";
            $virgula = ",";
            if (trim($this->p113_sequencial) == null ) {
                $this->erro_sql = " Campo Codigo Sequencial não informado.";
                $this->erro_campo = "p113_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p113_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p113_codproc"])) {
            $sql  .= $virgula." p113_codproc = $this->p113_codproc ";
            $virgula = ",";
            if (trim($this->p113_codproc) == null ) {
                $this->erro_sql = " Campo Numero do código do Processo não informado.";
                $this->erro_campo = "p113_codproc";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p113_nfe)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p113_nfe"])) {
            $sql  .= $virgula." p113_nfe = $this->p113_nfe ";
            $virgula = ",";
            if (trim($this->p113_nfe) == null ) {
                $this->erro_sql = " Campo Nota Fiscal não informado.";
                $this->erro_campo = "p113_nfe";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p113_numpagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p113_numpagamento"])) {
            $sql  .= $virgula." p113_numpagamento = $this->p113_numpagamento ";
            $virgula = ",";
            if (trim($this->p113_numpagamento) == null ) {
                $this->erro_sql = " Campo Numero de Pagamento não informado.";
                $this->erro_campo = "p113_numpagamento";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p113_nfgeral)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p113_nfgeral"])) {
            $sql  .= $virgula." p113_nfgeral = '$this->p113_nfgeral' ";
            $virgula = ",";
            if (trim($this->p113_nfgeral) == null ) {
                $this->erro_sql = " Campo p113_nfgeral não informado.";
                $this->erro_campo = "p113_nfgeral";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->p113_nfaberturaprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p113_nfaberturaprocesso"])) {
            if (trim($this->p113_nfaberturaprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["p113_nfaberturaprocesso"])) {
                $this->p113_nfaberturaprocesso = "0" ;
            }
            $sql  .= $virgula." p113_nfaberturaprocesso = $this->p113_nfaberturaprocesso ";
            $virgula = ",";
        }
        if (trim($this->p113_nfprevisaopagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p113_nfprevisaopagamento"])) {
            if (trim($this->p113_nfprevisaopagamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["p113_nfprevisaopagamento"])) {
                $this->p113_nfprevisaopagamento = "0" ;
            }
            $sql  .= $virgula." p113_nfprevisaopagamento = $this->p113_nfprevisaopagamento ";
            $virgula = ",";
        }
        if (trim($this->p113_dataenvio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p113_dataenvio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["p113_dataenvio_dia"] !="") ) {
            $sql  .= $virgula." p113_dataenvio = '$this->p113_dataenvio' ";
            $virgula = ",";
            if (trim($this->p113_dataenvio) == null ) {
                $this->erro_sql = " Campo Data de Envio não informado.";
                $this->erro_campo = "p113_dataenvio_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if (isset($GLOBALS["HTTP_POST_VARS"]["p113_dataenvio_dia"])) {
                $sql  .= $virgula." p113_dataenvio = null ";
                $virgula = ",";
                if (trim($this->p113_dataenvio) == null ) {
                    $this->erro_sql = " Campo Data de Envio não informado.";
                    $this->erro_campo = "p113_dataenvio_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        $sql .= " where ";
        if ($p113_sequencial!=null) {
            $sql .= " p113_sequencial = $this->p113_sequencial";
        }
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            $resaco = $this->sql_record($this->sql_query_file($this->p113_sequencial));
            if ($this->numrows>0) {

                for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac,0,0);
                    $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                    $resac = db_query("insert into db_acountkey values($acount,1009260,'$this->p113_sequencial','A')");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p113_sequencial"]) || $this->p113_sequencial != "")
                        $resac = db_query("insert into db_acount values($acount,1010196,1009260,'".AddSlashes(pg_result($resaco,$conresaco,'p113_sequencial'))."','$this->p113_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p113_codproc"]) || $this->p113_codproc != "")
                        $resac = db_query("insert into db_acount values($acount,1010196,1009261,'".AddSlashes(pg_result($resaco,$conresaco,'p113_codproc'))."','$this->p113_codproc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p113_nfe"]) || $this->p113_nfe != "")
                        $resac = db_query("insert into db_acount values($acount,1010196,1009263,'".AddSlashes(pg_result($resaco,$conresaco,'p113_nfe'))."','$this->p113_nfe',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p113_numpagamento"]) || $this->p113_numpagamento != "")
                        $resac = db_query("insert into db_acount values($acount,1010196,1009264,'".AddSlashes(pg_result($resaco,$conresaco,'p113_numpagamento'))."','$this->p113_numpagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p113_nfgeral"]) || $this->p113_nfgeral != "")
                        $resac = db_query("insert into db_acount values($acount,1010196,1009268,'".AddSlashes(pg_result($resaco,$conresaco,'p113_nfgeral'))."','$this->p113_nfgeral',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p113_nfaberturaprocesso"]) || $this->p113_nfaberturaprocesso != "")
                        $resac = db_query("insert into db_acount values($acount,1010196,1009269,'".AddSlashes(pg_result($resaco,$conresaco,'p113_nfaberturaprocesso'))."','$this->p113_nfaberturaprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p113_nfprevisaopagamento"]) || $this->p113_nfprevisaopagamento != "")
                        $resac = db_query("insert into db_acount values($acount,1010196,1009270,'".AddSlashes(pg_result($resaco,$conresaco,'p113_nfprevisaopagamento'))."','$this->p113_nfprevisaopagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["p113_dataenvio"]) || $this->p113_dataenvio != "")
                        $resac = db_query("insert into db_acount values($acount,1010196,1009265,'".AddSlashes(pg_result($resaco,$conresaco,'p113_dataenvio'))."','$this->p113_dataenvio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                }
            }
        }
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "nfpagamentorealizado nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->p113_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "nfpagamentorealizado nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->p113_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->p113_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ($p113_sequencial=null,$dbwhere=null) {

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            if ($dbwhere==null || $dbwhere=="") {

                $resaco = $this->sql_record($this->sql_query_file($p113_sequencial));
            } else {
                $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
            }
            if (($resaco != false) || ($this->numrows!=0)) {

                for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

                    $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac,0,0);
                    $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                    $resac  = db_query("insert into db_acountkey values($acount,1009260,'$p113_sequencial','E')");
                    $resac  = db_query("insert into db_acount values($acount,1010196,1009260,'','".AddSlashes(pg_result($resaco,$iresaco,'p113_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010196,1009261,'','".AddSlashes(pg_result($resaco,$iresaco,'p113_codproc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010196,1009263,'','".AddSlashes(pg_result($resaco,$iresaco,'p113_nfe'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010196,1009264,'','".AddSlashes(pg_result($resaco,$iresaco,'p113_numpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010196,1009268,'','".AddSlashes(pg_result($resaco,$iresaco,'p113_nfgeral'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010196,1009269,'','".AddSlashes(pg_result($resaco,$iresaco,'p113_nfaberturaprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010196,1009270,'','".AddSlashes(pg_result($resaco,$iresaco,'p113_nfprevisaopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010196,1009265,'','".AddSlashes(pg_result($resaco,$iresaco,'p113_dataenvio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                }
            }
        }
        $sql = " delete from nfpagamentorealizado
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            if ($p113_sequencial != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " p113_sequencial = $p113_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "nfpagamentorealizado nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$p113_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "nfpagamentorealizado nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$p113_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$p113_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:nfpagamentorealizado";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $p113_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from nfpagamentorealizado ";
        $sql .= "      inner join protprocesso  on  protprocesso.p58_codproc = nfpagamentorealizado.p113_codproc";
        $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
        $sql .= "      inner join db_config  on  db_config.codigo = protprocesso.p58_instit";
        $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
        $sql .= "      inner join db_depart  on  db_depart.coddepto = protprocesso.p58_coddepto";
        $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($p113_sequencial!=null ) {
                $sql2 .= " where nfpagamentorealizado.p113_sequencial = $p113_sequencial ";
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
    function sql_query_file ( $p113_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from nfpagamentorealizado ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($p113_sequencial!=null ) {
                $sql2 .= " where nfpagamentorealizado.p113_sequencial = $p113_sequencial ";
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