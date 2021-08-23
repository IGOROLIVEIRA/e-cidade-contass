<?php
//MODULO: sicom
//CLASSE DA ENTIDADE licobras302021
class cl_licobras302021 {
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
    public $si203_sequencial                = 0;
    public $si203_tiporegistro              = 0;
    public $si203_codorgaoresp              = null;
    public $si203_codobra                   = null;
    public $si203_codunidadesubrespestadual = null;
    public $si203_nroseqtermoaditivo        = null;
    public $si203_dataassinaturatermoaditivo= null;
    public $si203_tipoalteracaovalor        = null;
    public $si203_tipotermoaditivo          = null;
    public $si203_dscalteracao              = null;
    public $si203_novadatatermino           = null;
    public $si203_tipodetalhamento          = null;
    public $si203_valoraditivo              = null;
    public $si203_mes                       = 0;
    public $si203_instit                    = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                    si203_sequencial                
                    si203_tiporegistro              
                    si203_codorgaoresp              
                    si203_codobra                   
                    si203_codunidadesubrespestadual 
                    si203_nroseqtermoaditivo        
                    si203_dataassinaturatermoaditivo
                    si203_tipoalteracaovalor        
                    si203_tipotermoaditivo          
                    si203_dscalteracao              
                    si203_novadatatermino           
                    si203_tipodetalhamento          
                    si203_valoraditivo              
                    si203_mes                       
                    si203_instit                    
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("licobras302021");
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
            $this->si203_sequencial = ($this->si203_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_sequencial"]:$this->si203_sequencial);
            $this->si203_tiporegistro = ($this->si203_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"]:$this->si203_tiporegistro);
            $this->si203_codorgaoresp = ($this->si203_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_codorgaoresp"]:$this->si203_codorgaoresp);
            $this->si203_codobra = ($this->si203_codobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_codobra"]:$this->si203_codobra);
            $this->si203_codunidadesubrespestadual = ($this->si203_codunidadesubrespestadual == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_codunidadesubrespestadual"]:$this->si203_codunidadesubrespestadual);
            $this->si203_nroseqtermoaditivo = ($this->si203_nroseqtermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_nroseqtermoaditivo"]:$this->si203_nroseqtermoaditivo);
            $this->si203_dataassinaturatermoaditivo = ($this->si203_dataassinaturatermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_dataassinaturatermoaditivo"]:$this->si203_dataassinaturatermoaditivo);
            $this->si203_tipoalteracaovalor = ($this->si203_tipoalteracaovalor == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_tipoalteracaovalor"]:$this->si203_tipoalteracaovalor);
            $this->si203_tipotermoaditivo = ($this->si203_tipotermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_tipotermoaditivo"]:$this->si203_tipotermoaditivo);
            $this->si203_dscalteracao = ($this->si203_dscalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_dscalteracao"]:$this->si203_dscalteracao);
            $this->si203_novadatatermino = ($this->si203_novadatatermino == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_novadatatermino"]:$this->si203_novadatatermino);
            $this->si203_tipodetalhamento = ($this->si203_tipodetalhamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_tipodetalhamento"]:$this->si203_tipodetalhamento);
            $this->si203_valoraditivo = ($this->si203_valoraditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_valoraditivo"]:$this->si203_valoraditivo);
            $this->si203_mes = ($this->si203_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_mes"]:$this->si203_mes);
            $this->si203_instit = ($this->si203_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si203_instit"]:$this->si203_instit);
        }
    }

    // funcao para inclusao
    function incluir () {
        $this->atualizacampos();
        if ($this->si203_sequencial == null ) {
            $result = db_query("select nextval('licobras302021_si203_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: licobras302021_si203_sequencial_seq do campo: si203_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->si203_sequencial = pg_result($result,0,0);
        }
        if ($this->si203_tiporegistro == null ) {
            $this->erro_sql = " Campo Tiporegistro não informado.";
            $this->erro_campo = "si203_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si203_codorgaoresp == null ) {
            $this->erro_sql = " Campo codorgaoresp não informado.";
            $this->erro_campo = "si203_codorgaoresp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si203_codobra == null ) {
            $this->erro_sql = " Campo codigo da obra não informado.";
            $this->erro_campo = "si203_codobra";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si203_codunidadesubrespestadual == null ) {
            $this->erro_sql = " Campo cod unidade sub resp estadual não informado.";
            $this->erro_campo = "si203_codunidadesubrespestadual";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si203_nroseqtermoaditivo == null ) {
            $this->erro_sql = " Campo numero sequencial termo aditivo não informado.";
            $this->erro_campo = "si203_nroseqtermoaditivo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si203_dataassinaturatermoaditivo == null ) {
            $this->erro_sql = " Campo data assinatura do termo aditivo não informado.";
            $this->erro_campo = "si203_dataassinaturatermoaditivo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si203_tipoalteracaovalor == null ) {
            $this->erro_sql = " Campo Tipo alteracao valor não informado.";
            $this->erro_campo = "si203_tipoalteracaovalor";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si203_tipotermoaditivo == null ) {
            $this->erro_sql = " Campo tipo termo aditivo não informado.";
            $this->erro_campo = "si203_tipotermoaditivo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

//        if ($this->si203_dscalteracao == null ) {
//            $this->erro_sql = " Campo descricao alteracao não informado.";
//            $this->erro_campo = "si203_dscalteracao";
//            $this->erro_banco = "";
//            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//            $this->erro_status = "0";
//            return false;
//        }

        if ($this->si203_novadatatermino == null ) {
            $this->erro_sql = " Campo nova data de termino não informado.";
            $this->erro_campo = "si203_novadatatermino";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->si203_tipodetalhamento == null ) {
            $this->erro_sql = " Campo tipo detalhamento nao informado não informado.";
            $this->erro_campo = "si203_tipodetalhamento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->si203_valoraditivo == null ) {
            $this->si203_valoraditivo = 0;
        }

        if ($this->si203_mes == null ) {
            $this->erro_sql = " Campo mes não informado.";
            $this->erro_campo = "si203_mes";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->si203_instit == null ) {
            $this->erro_sql = " Campo instituicao não informado.";
            $this->erro_campo = "si203_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }


        $sql = "insert into licobras302021(
                                       si203_sequencial
                                      ,si203_tiporegistro
                                      ,si203_codorgaoresp
                                      ,si203_codobra
                                      ,si203_codunidadesubrespestadual
                                      ,si203_nroseqtermoaditivo
                                      ,si203_dataassinaturatermoaditivo
                                      ,si203_tipoalteracaovalor
                                      ,si203_tipotermoaditivo
                                      ,si203_dscalteracao           
                                      ,si203_novadatatermino     
                                      ,si203_tipodetalhamento        
                                      ,si203_valoraditivo            
                                      ,si203_mes
                                      ,si203_instit
                       )
                values (
                                $this->si203_sequencial
                               ,$this->si203_tiporegistro
                               ,'$this->si203_codorgaoresp'
                               ,$this->si203_codobra
                               ,'$this->si203_codunidadesubrespestadual'
                               ,$this->si203_nroseqtermoaditivo
                               ,'$this->si203_dataassinaturatermoaditivo'
                               ,$this->si203_tipoalteracaovalor
                               ,'$this->si203_tipotermoaditivo'
                               ,'$this->si203_dscalteracao'           
                               ,'$this->si203_novadatatermino'     
                               ,$this->si203_tipodetalhamento        
                               ,$this->si203_valoraditivo            
                               ,$this->si203_mes
                               ,$this->si203_instit
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "cadastro de obras () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "cadastro de obras já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "cadastro de obras () nao Incluído. Inclusao Abortada.";
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
    function alterar ( $si203_sequencial=null ) {
        $this->atualizacampos();
        $sql = " update licobras302021 set ";
        $virgula = "";
        if (trim($this->si203_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_sequencial"])) {
            $sql  .= $virgula." si203_sequencial = $this->si203_sequencial ";
            $virgula = ",";
            if (trim($this->si203_sequencial) == null ) {
                $this->erro_sql = " Campo Sequencial não informado.";
                $this->erro_campo = "si203_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si203_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"])) {
            $sql  .= $virgula." si203_tiporegistro = $this->si203_tiporegistro ";
            $virgula = ",";
            if (trim($this->si203_tiporegistro) == null ) {
                $this->erro_sql = " Campo Tiporegistro não informado.";
                $this->erro_campo = "si203_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si203_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_codorgaoresp"])) {
            $sql  .= $virgula." si203_codorgaoresp = '$this->si203_codorgaoresp' ";
            $virgula = ",";
            if (trim($this->si203_codorgaoresp) == null ) {
                $this->erro_sql = " Campo codorgaoresp não informado.";
                $this->erro_campo = "si203_codorgaoresp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si203_codobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_codobra"])) {
            $sql  .= $virgula." si203_codobra = '$this->si203_codobra' ";
            $virgula = ",";
            if (trim($this->si203_codobra) == null ) {
                $this->erro_sql = " Campo codUnidadeSubRespEstadual não informado.";
                $this->erro_campo = "si203_codobra";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si203_codunidadesubrespestadual)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_codunidadesubrespestadual"])) {
            $sql  .= $virgula." si203_codunidadesubrespestadual = $this->si203_codunidadesubrespestadual ";
            $virgula = ",";
            if (trim($this->si203_codunidadesubrespestadual) == null ) {
                $this->erro_sql = " Campo exercicioLicitacao não informado.";
                $this->erro_campo = "si203_codunidadesubrespestadual";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si203_nroseqtermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_nroseqtermoaditivo"])) {
            $sql  .= $virgula." si203_nroseqtermoaditivo = '$this->si203_nroseqtermoaditivo' ";
            $virgula = ",";
            if (trim($this->si203_nroseqtermoaditivo) == null ) {
                $this->erro_sql = " Campo nroProcessoLicitatorio não informado.";
                $this->erro_campo = "si203_nroseqtermoaditivo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si203_dataassinaturatermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_dataassinaturatermoaditivo"])) {
            $sql  .= $virgula." si203_dataassinaturatermoaditivo = $this->si203_dataassinaturatermoaditivo ";
            $virgula = ",";
            if (trim($this->si203_dataassinaturatermoaditivo) == null ) {
                $this->erro_sql = " Campo codigoobra não informado.";
                $this->erro_campo = "si203_dataassinaturatermoaditivo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si203_tipoalteracaovalor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_tipoalteracaovalor"])) {
            $sql  .= $virgula." si203_tipoalteracaovalor = '$this->si203_tipoalteracaovalor' ";
            $virgula = ",";
            if (trim($this->si203_tipoalteracaovalor) == null ) {
                $this->erro_sql = " Campo objeto não informado.";
                $this->erro_campo = "si203_tipoalteracaovalor";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si203_tipotermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si203_tipotermoaditivo"])) {
            $sql  .= $virgula." si203_tipotermoaditivo = '$this->si203_tipotermoaditivo' ";
            $virgula = ",";
            if (trim($this->si203_tipotermoaditivo) == null ) {
                $this->erro_sql = " Campo linkobra não informado.";
                $this->erro_campo = "si203_tipotermoaditivo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "si203_sequencial = '$si203_sequencial'";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "cadastro de obras nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "cadastro de obras nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir ( $si203_sequencial=null ,$dbwhere=null) {

        $sql = " delete from licobras302021
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            $sql2 = "si203_sequencial = '$si203_sequencial'";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "cadastro de obras nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "cadastro de obras nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:licobras302021";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $si203_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from licobras302021 ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ( $si203_sequencial != "" && $si203_sequencial != null) {
                $sql2 = " where licobras302021.si203_sequencial = '$si203_sequencial'";
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
    function sql_query_file ( $si203_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from licobras302021 ";
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
