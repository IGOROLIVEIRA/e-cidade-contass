<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE despesasinscritasRP
class cl_despesasinscritasRP {
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
    public $c223_sequencial = 0;
    public $c223_codemp = 0;
    public $c223_credor = 0;
    public $c223_fonte = 0;
    public $c223_vlrnaoliquidado = 0;
    public $c223_vlrliquidado = 0;
    public $c223_vlrdisRPNP = 0;
    public $c223_vlrdisRPP = 0;
    public $c223_vlrsemdisRPNP = 0;
    public $c223_vlrsemdisRPP = 0;
    public $c223_vlrdisptotal = 0;
    public $c223_vlrutilizado = 0;
    public $c223_vlrdisponivel = 0;
    public $c223_anousu = 0;
    public $c223_instit = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 c223_sequencial = int8 = Sequencial
                 c223_codemp = int8 = Codigo Empenho
                 c223_credor = int8 = Credor
                 c223_fonte = int8 = Fonte de recurso
                 c223_vlrnaoliquidado = float8 = Valor Não Liquidado
                 c223_vlrliquidado = float8 = Valor Liquidado
                 c223_vlrdisRPNP = float8 = Valor Disponivel RPNP
                 c223_vlrdisRPP = float8 = Valor Disponivel RPP
                 c223_vlrsemdisRPNP = float8 = Valor Sem Disponibilidade RPNP
                 c223_vlrsemdisRPP = float8 = Valor Sem Disponiblidade RPP
                 c223_vlrdisptotal = float8 = Valor Disponivel Total
                 c223_vlrutilizado = float8 = Valor Utilizado
                 c223_vlrdisponivel = float8 = Valor Disponivel
                 c223_anousu = float8 = Ano Uso
                 c223_instit = int8 = codigo da instituição
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("despesasinscritasRP");
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
            $this->c223_sequencial = ($this->c223_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_sequencial"]:$this->c223_sequencial);
            $this->c223_codemp = ($this->c223_codemp == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_codemp"]:$this->c223_codemp);
            $this->c223_credor = ($this->c223_credor == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_credor"]:$this->c223_credor);
            $this->c223_fonte = ($this->c223_fonte == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_fonte"]:$this->c223_fonte);
            $this->c223_vlrnaoliquidado = ($this->c223_vlrnaoliquidado == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_vlrnaoliquidado"]:$this->c223_vlrnaoliquidado);
            $this->c223_vlrliquidado = ($this->c223_vlrliquidado == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_vlrliquidado"]:$this->c223_vlrliquidado);
            $this->c223_vlrdisRPNP = ($this->c223_vlrdisRPNP == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_vlrdisRPNP"]:$this->c223_vlrdisRPNP);
            $this->c223_vlrdisRPP = ($this->c223_vlrdisRPP == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_vlrdisRPP"]:$this->c223_vlrdisRPP);
            $this->c223_vlrsemdisRPNP = ($this->c223_vlrsemdisRPNP == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_vlrsemdisRPNP"]:$this->c223_vlrsemdisRPNP);
            $this->c223_vlrsemdisRPP = ($this->c223_vlrsemdisRPP == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_vlrsemdisRPP"]:$this->c223_vlrsemdisRPP);
            $this->c223_vlrdisptotal = ($this->c223_vlrdisptotal == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_vlrdisptotal"]:$this->c223_vlrdisptotal);
            $this->c223_vlrutilizado = ($this->c223_vlrutilizado == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_vlrutilizado"]:$this->c223_vlrutilizado);
            $this->c223_vlrdisponivel = ($this->c223_vlrdisponivel == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_vlrdisponivel"]:$this->c223_vlrdisponivel);
            $this->c223_anousu = ($this->c223_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_anousu"]:$this->c223_anousu);
            $this->c223_instit = ($this->c223_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["c223_instit"]:$this->c223_instit);
        } else {
        }
    }

    // funcao para inclusao
    function incluir () {
        $this->atualizacampos();
//        if ($this->c223_sequencial == null ) {
//            $this->erro_sql = " Campo Sequencial não informado.";
//            $this->erro_campo = "c223_sequencial";
//            $this->erro_banco = "";
//            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//            $this->erro_status = "0";
//            return false;
//        }
        if ($this->c223_codemp == null ) {
            $this->erro_sql = " Campo Codigo Empenho não informado.";
            $this->erro_campo = "c223_codemp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c223_credor == null ) {
            $this->erro_sql = " Campo Credor não informado.";
            $this->erro_campo = "c223_credor";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }else{
            $this->c223_credor = str_replace("'","",$this->c223_credor);
        }
        if ($this->c223_fonte == null ) {
            $this->erro_sql = " Campo Fonte não informado.";
            $this->erro_campo = "c223_fonte";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c223_vlrnaoliquidado == null ) {
            $this->erro_sql = " Campo Valor Não Liquidado não informado.";
            $this->erro_campo = "c223_vlrnaoliquidado";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c223_vlrliquidado == null ) {
            $this->erro_sql = " Campo Valor Liquidado não informado.";
            $this->erro_campo = "c223_vlrliquidado";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c223_vlrdisRPNP == null ) {
            $this->erro_sql = " Campo Valor Disponivel RPNP não informado.";
            $this->erro_campo = "c223_vlrdisRPNP";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
//        if ($this->c223_vlrdisRPP == null ) {
//            $this->erro_sql = " Campo Valor Disponivel RPP não informado.";
//            $this->erro_campo = "c223_vlrdisRPP";
//            $this->erro_banco = "";
//            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//            $this->erro_status = "0";
//            return false;
//        }
//        if ($this->c223_vlrsemdisRPNP == null ) {
//            $this->erro_sql = " Campo Valor Sem Disponibilidade RPNP não informado.";
//            $this->erro_campo = "c223_vlrsemdisRPNP";
//            $this->erro_banco = "";
//            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//            $this->erro_status = "0";
//            return false;
//        }
//        if ($this->c223_vlrsemdisRPP == null ) {
//            $this->erro_sql = " Campo Valor Sem Disponiblidade RPP não informado.";
//            $this->erro_campo = "c223_vlrsemdisRPP";
//            $this->erro_banco = "";
//            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//            $this->erro_status = "0";
//            return false;
//        }
//        if ($this->c223_vlrdisptotal == null ) {
//            $this->erro_sql = " Campo Valor Disponivel Total não informado.";
//            $this->erro_campo = "c223_vlrdisptotal";
//            $this->erro_banco = "";
//            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//            $this->erro_status = "0";
//            return false;
//        }
//        if ($this->c223_vlrutilizado == null ) {
//            $this->erro_sql = " Campo Valor Utilizado não informado.";
//            $this->erro_campo = "c223_vlrutilizado";
//            $this->erro_banco = "";
//            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//            $this->erro_status = "0";
//            return false;
//        }
//        if ($this->c223_vlrdisponivel == null ) {
//            $this->erro_sql = " Campo Valor Disponivel não informado.";
//            $this->erro_campo = "c223_vlrdisponivel";
//            $this->erro_banco = "";
//            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//            $this->erro_status = "0";
//            return false;
//        }
        if ($this->c223_anousu == null ) {
            $this->erro_sql = " Campo Ano Uso não informado.";
            $this->erro_campo = "c223_anousu";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into despesasinscritasRP(
                                       c223_sequencial
                                      ,c223_codemp
                                      ,c223_credor
                                      ,c223_fonte
                                      ,c223_vlrnaoliquidado
                                      ,c223_vlrliquidado
                                      ,c223_vlrdisRPNP
                                      ,c223_vlrdisRPP
                                      ,c223_vlrsemdisRPNP
                                      ,c223_vlrsemdisRPP
                                      ,c223_vlrdisptotal
                                      ,c223_vlrutilizado
                                      ,c223_vlrdisponivel
                                      ,c223_anousu
                                      ,c223_instit
                       )
                values (
                                 nextval('despesasinscritasRP_c223_sequencial_seq')
                               ,$this->c223_codemp
                               ,'$this->c223_credor'
                               ,$this->c223_fonte
                               ,".($this->c223_vlrnaoliquidado== "null" || $this->c223_vlrnaoliquidado == ""? 0 : "'".$this->c223_vlrnaoliquidado."'")."
                               ,".($this->c223_vlrliquidado   == "null" || $this->c223_vlrliquidado    == ""? 0 : "'".$this->c223_vlrliquidado."'")."
                               ,".($this->c223_vlrdisRPNP     == "null" || $this->c223_vlrdisRPNP      == ""? 0 : "'".$this->c223_vlrdisRPNP."'")."
                               ,".($this->c223_vlrdisRPP      == "null" || $this->c223_vlrdisRPP       == ""? 0 : "'".$this->c223_vlrdisRPP."'")."
                               ,".($this->c223_vlrdisRPNP  == 0 || $this->c223_vlrdisRPNP   == ""? $this->c223_vlrnaoliquidado : "'".$this->c223_vlrsemdisRPNP."'")."
                               ,".($this->c223_vlrdisRPP   == 0 || $this->c223_vlrdisRPP    == ""? $this->c223_vlrliquidado : "'".$this->c223_vlrsemdisRPP."'")."
                               ,".($this->c223_vlrdisptotal   == "null" || $this->c223_vlrdisptotal    == ""? 0 : "'".$this->c223_vlrdisptotal."'")."
                               ,".($this->c223_vlrutilizado   == "null" || $this->c223_vlrutilizado    == ""? 0 : "'".$this->c223_vlrutilizado."'")."
                               ,".($this->c223_vlrdisponivel  == "null" || $this->c223_vlrdisponivel   == ""? 0 : "'".$this->c223_vlrdisponivel."'")."
                               ,$this->c223_anousu
                               ,$this->c223_instit
                      )";
//        die($sql);
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "despesasinscritasRP () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "despesasinscritasRP já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "despesasinscritasRP () nao Incluído. Inclusao Abortada.";
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
    function alterar ( $oid=null ) {
        $this->atualizacampos();
        $sql = " update despesasinscritasRP set ";
        $virgula = "";
        if (trim($this->c223_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_sequencial"])) {
            $sql  .= $virgula." c223_sequencial = $this->c223_sequencial ";
            $virgula = ",";
            if (trim($this->c223_sequencial) == null ) {
                $this->erro_sql = " Campo Sequencial não informado.";
                $this->erro_campo = "c223_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_codemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_codemp"])) {
            $sql  .= $virgula." c223_codemp = $this->c223_codemp ";
            $virgula = ",";
            if (trim($this->c223_codemp) == null ) {
                $this->erro_sql = " Campo Codigo Empenho não informado.";
                $this->erro_campo = "c223_codemp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_credor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_credor"])) {
            $sql  .= $virgula." c223_credor = '$this->c223_credor' ";
            $virgula = ",";
            if (trim($this->c223_credor) == null ) {
                $this->erro_sql = " Campo Credor não informado.";
                $this->erro_campo = "c223_credor";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_vlrnaoliquidado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_vlrnaoliquidado"])) {
            $sql  .= $virgula." c223_vlrnaoliquidado = $this->c223_vlrnaoliquidado ";
            $virgula = ",";
            if (trim($this->c223_vlrnaoliquidado) == null ) {
                $this->erro_sql = " Campo Valor Não Liquidado não informado.";
                $this->erro_campo = "c223_vlrnaoliquidado";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_vlrliquidado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_vlrliquidado"])) {
            $sql  .= $virgula." c223_vlrliquidado = $this->c223_vlrliquidado ";
            $virgula = ",";
            if (trim($this->c223_vlrliquidado) == null ) {
                $this->erro_sql = " Campo Valor Liquidado não informado.";
                $this->erro_campo = "c223_vlrliquidado";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_vlrdisRPNP)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_vlrdisRPNP"])) {
            $sql  .= $virgula." c223_vlrdisRPNP = $this->c223_vlrdisRPNP ";
            $virgula = ",";
            if (trim($this->c223_vlrdisRPNP) == null ) {
                $this->erro_sql = " Campo Valor Disponivel RPNP não informado.";
                $this->erro_campo = "c223_vlrdisRPNP";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_vlrdisRPP)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_vlrdisRPP"])) {
            $sql  .= $virgula." c223_vlrdisRPP = $this->c223_vlrdisRPP ";
            $virgula = ",";
            if (trim($this->c223_vlrdisRPP) == null ) {
                $this->erro_sql = " Campo Valor Disponivel RPP não informado.";
                $this->erro_campo = "c223_vlrdisRPP";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_vlrsemdisRPNP)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_vlrsemdisRPNP"])) {
            if($this->c223_vlrdisRPNP == 0 || $this->c223_vlrdisRPNP == ""){
                $sql  .= $virgula." c223_vlrsemdisRPNP = $this->c223_vlrnaoliquidado ";
            }else{
                $sql  .= $virgula." c223_vlrsemdisRPNP = $this->c223_vlrsemdisRPNP ";
            }
            $virgula = ",";
            if (trim($this->c223_vlrsemdisRPNP) == null ) {
                $this->erro_sql = " Campo Valor Sem Disponibilidade RPNP não informado.";
                $this->erro_campo = "c223_vlrsemdisRPNP";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_vlrsemdisRPP)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_vlrsemdisRPP"])) {
            if($this->c223_vlrdisRPP == 0 || $this->c223_vlrdisRPP == ""){
                $sql  .= $virgula." c223_vlrsemdisRPP = $this->c223_vlrliquidado ";
            }else{
                $sql  .= $virgula." c223_vlrsemdisRPP = $this->c223_vlrsemdisRPP ";
            }
            $virgula = ",";
            if (trim($this->c223_vlrsemdisRPP) == null ) {
                $this->erro_sql = " Campo Valor Sem Disponiblidade RPP não informado.";
                $this->erro_campo = "c223_vlrsemdisRPP";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_vlrdisptotal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_vlrdisptotal"])) {
            $sql  .= $virgula." c223_vlrdisptotal = $this->c223_vlrdisptotal ";
            $virgula = ",";
            if (trim($this->c223_vlrdisptotal) == null ) {
                $this->erro_sql = " Campo Valor Disponivel Total não informado.";
                $this->erro_campo = "c223_vlrdisptotal";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_vlrutilizado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_vlrutilizado"])) {
            $sql  .= $virgula." c223_vlrutilizado = $this->c223_vlrutilizado ";
            $virgula = ",";
            if (trim($this->c223_vlrutilizado) == null ) {
                $this->erro_sql = " Campo Valor Utilizado não informado.";
                $this->erro_campo = "c223_vlrutilizado";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_vlrdisponivel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_vlrdisponivel"])) {
            $sql  .= $virgula." c223_vlrdisponivel = $this->c223_vlrdisponivel ";
            $virgula = ",";
            if (trim($this->c223_vlrdisponivel) == null ) {
                $this->erro_sql = " Campo Valor Disponivel não informado.";
                $this->erro_campo = "c223_vlrdisponivel";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_anousu"])) {
            $sql  .= $virgula." c223_anousu = $this->c223_anousu ";
            $virgula = ",";
            if (trim($this->c223_anousu) == null ) {
                $this->erro_sql = " Campo Ano Uso não informado.";
                $this->erro_campo = "c223_anousu";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c223_fonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c223_fonte"])) {
            $sql  .= $virgula." c223_fonte = $this->c223_fonte ";
            $virgula = ",";
            if (trim($this->c223_fonte) == null ) {
                $this->erro_sql = " Campo Fonte não informado.";
                $this->erro_campo = "c223_fonte";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= " c223_sequencial = $this->c223_sequencial";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "despesasinscritasRP nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "despesasinscritasRP nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir ( $oid=null ,$dbwhere=null) {

        $sql = " delete from despesasinscritasRP
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            $sql2 = "oid = '$oid'";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "despesasinscritasRP nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "despesasinscritasRP nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:despesasinscritasRP";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $oid = null,$campos="despesasinscritasRP.oid,*",$ordem=null,$dbwhere="") {
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
        $sql .= " from despesasinscritasRP ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ( $oid != "" && $oid != null) {
                $sql2 = " where despesasinscritasRP.oid = '$oid'";
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
    function sql_query_file ( $oid = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from despesasinscritasRP ";
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
