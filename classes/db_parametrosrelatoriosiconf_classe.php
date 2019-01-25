<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE parametrosrelatoriosiconf
class cl_parametrosrelatoriosiconf {
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
    public $c222_sequencial = 0;
    public $c222_recimpostostranseduc = 0;
    public $c222_transfundeb60 = 0;
    public $c222_transfundeb40 = 0;
    public $c222_recdestinadoeduc = 0;
    public $c222_recimpostostranssaude = 0;
    public $c222_recdestinadosaude = 0;
    public $c222_recdestinadoassist = 0;
    public $c222_recdestinadorppspp = 0;
    public $c222_recdestinadorppspf = 0;
    public $c222_recopcreditoexsaudeeduc = 0;
    public $c222_recavaliacaodebens = 0;
    public $c222_outrasdestinacoes = 0;
    public $c222_recordinarios = 0;
    public $c222_outrosrecnaovinculados = 0;
    public $c222_anousu = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 c222_sequencial = int8 = Sequencial 
                 c222_recimpostostranseduc = float8 = Rec. Imp. e de Transf. de Imp. Educ 
                 c222_transfundeb60 = float8 = Transferências do FUNDEB 60% 
                 c222_transfundeb40 = float8 = Transferências do FUNDEB 40% 
                 c222_recdestinadoeduc = float8 = Outros Rec Destinados à Edu. 
                 c222_recimpostostranssaude = float8 = Rec. de Imp e Transf. de Imp. Saude 
                 c222_recdestinadosaude = int8 = Outros Recursos Destinados à Saúde 
                 c222_recdestinadoassist = float8 = Rec. Destinados à Assistência Social 
                 c222_recdestinadorppspp = float8 = Rec. Dest. ao RPPS-Plano Prev. 
                 c222_recdestinadorppspf = float8 = Rec. Dest. ao RPPS-Plano Fina. 
                 c222_recopcreditoexsaudeeduc = float8 = Rec. de Op. de Crédito Exeto edu. e Saude 
                 c222_recavaliacaodebens = float8 = Recursos de Alienação de Bens/Ativos 
                 c222_outrasdestinacoes = float8 = Outras Des Vinculadas de Rec 
                 c222_recordinarios = float8 = Recursos Ordinários 
                 c222_outrosrecnaovinculados = float8 = Outros Recursos não Vinculados 
                 c222_anousu = int4 = Ano Uso 
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("parametrosrelatoriosiconf");
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
            $this->c222_sequencial = ($this->c222_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_sequencial"]:$this->c222_sequencial);
            $this->c222_recimpostostranseduc = ($this->c222_recimpostostranseduc == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recimpostostranseduc"]:$this->c222_recimpostostranseduc);
            $this->c222_transfundeb60 = ($this->c222_transfundeb60 == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_transfundeb60"]:$this->c222_transfundeb60);
            $this->c222_transfundeb40 = ($this->c222_transfundeb40 == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_transfundeb40"]:$this->c222_transfundeb40);
            $this->c222_recdestinadoeduc = ($this->c222_recdestinadoeduc == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recdestinadoeduc"]:$this->c222_recdestinadoeduc);
            $this->c222_recimpostostranssaude = ($this->c222_recimpostostranssaude == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recimpostostranssaude"]:$this->c222_recimpostostranssaude);
            $this->c222_recdestinadosaude = ($this->c222_recdestinadosaude == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recdestinadosaude"]:$this->c222_recdestinadosaude);
            $this->c222_recdestinadoassist = ($this->c222_recdestinadoassist == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recdestinadoassist"]:$this->c222_recdestinadoassist);
            $this->c222_recdestinadorppspp = ($this->c222_recdestinadorppspp == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recdestinadorppspp"]:$this->c222_recdestinadorppspp);
            $this->c222_recdestinadorppspf = ($this->c222_recdestinadorppspf == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recdestinadorppspf"]:$this->c222_recdestinadorppspf);
            $this->c222_recopcreditoexsaudeeduc = ($this->c222_recopcreditoexsaudeeduc == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recopcreditoexsaudeeduc"]:$this->c222_recopcreditoexsaudeeduc);
            $this->c222_recavaliacaodebens = ($this->c222_recavaliacaodebens == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recavaliacaodebens"]:$this->c222_recavaliacaodebens);
            $this->c222_outrasdestinacoes = ($this->c222_outrasdestinacoes == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_outrasdestinacoes"]:$this->c222_outrasdestinacoes);
            $this->c222_recordinarios = ($this->c222_recordinarios == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_recordinarios"]:$this->c222_recordinarios);
            $this->c222_outrosrecnaovinculados = ($this->c222_outrosrecnaovinculados == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_outrosrecnaovinculados"]:$this->c222_outrosrecnaovinculados);
            $this->c222_anousu = ($this->c222_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c222_anousu"]:$this->c222_anousu);
        } else {
        }
    }

    // funcao para inclusao
    function incluir () {
        $this->atualizacampos();
//     if ($this->c222_sequencial == null ) {
//       $this->erro_sql = " Campo Sequencial não informado.";
//       $this->erro_campo = "c222_sequencial";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
        if ($this->c222_recimpostostranseduc == null ) {
            $this->erro_sql = " Campo Rec. Imp. e de Transf. de Imp. Educ não informado.";
            $this->erro_campo = "c222_recimpostostranseduc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_transfundeb60 == null ) {
            $this->erro_sql = " Campo Transferências do FUNDEB 60% não informado.";
            $this->erro_campo = "c222_transfundeb60";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_transfundeb40 == null ) {
            $this->erro_sql = " Campo Transferências do FUNDEB 40% não informado.";
            $this->erro_campo = "c222_transfundeb40";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_recdestinadoeduc == null ) {
            $this->erro_sql = " Campo Outros Rec Destinados à Edu. não informado.";
            $this->erro_campo = "c222_recdestinadoeduc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_recimpostostranssaude == null ) {
            $this->erro_sql = " Campo Rec. de Imp e Transf. de Imp. Saude não informado.";
            $this->erro_campo = "c222_recimpostostranssaude";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_recdestinadosaude == null ) {
            $this->erro_sql = " Campo Outros Recursos Destinados à Saúde não informado.";
            $this->erro_campo = "c222_recdestinadosaude";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_recdestinadoassist == null ) {
            $this->erro_sql = " Campo Rec. Destinados à Assistência Social não informado.";
            $this->erro_campo = "c222_recdestinadoassist";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_recdestinadorppspp == null ) {
            $this->erro_sql = " Campo Rec. Dest. ao RPPS-Plano Prev. não informado.";
            $this->erro_campo = "c222_recdestinadorppspp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_recdestinadorppspf == null ) {
            $this->erro_sql = " Campo Rec. Dest. ao RPPS-Plano Fina. não informado.";
            $this->erro_campo = "c222_recdestinadorppspf";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_recopcreditoexsaudeeduc == null ) {
            $this->erro_sql = " Campo Rec. de Op. de Crédito Exeto edu. e Saude não informado.";
            $this->erro_campo = "c222_recopcreditoexsaudeeduc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_recavaliacaodebens == null ) {
            $this->erro_sql = " Campo Recursos de Alienação de Bens/Ativos não informado.";
            $this->erro_campo = "c222_recavaliacaodebens";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_outrasdestinacoes == null ) {
            $this->erro_sql = " Campo Outras Des Vinculadas de Rec não informado.";
            $this->erro_campo = "c222_outrasdestinacoes";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_recordinarios == null ) {
            $this->erro_sql = " Campo Recursos Ordinários não informado.";
            $this->erro_campo = "c222_recordinarios";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_outrosrecnaovinculados == null ) {
            $this->erro_sql = " Campo Outros Recursos não Vinculados não informado.";
            $this->erro_campo = "c222_outrosrecnaovinculados";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c222_anousu == null ) {
            $this->erro_sql = " Campo Ano Uso não informado.";
            $this->erro_campo = "c222_anousu";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into parametrosrelatoriosiconf(
                                       c222_sequencial 
                                      ,c222_recimpostostranseduc 
                                      ,c222_transfundeb60 
                                      ,c222_transfundeb40 
                                      ,c222_recdestinadoeduc 
                                      ,c222_recimpostostranssaude 
                                      ,c222_recdestinadosaude 
                                      ,c222_recdestinadoassist 
                                      ,c222_recdestinadorppspp 
                                      ,c222_recdestinadorppspf 
                                      ,c222_recopcreditoexsaudeeduc 
                                      ,c222_recavaliacaodebens 
                                      ,c222_outrasdestinacoes 
                                      ,c222_recordinarios 
                                      ,c222_outrosrecnaovinculados 
                                      ,c222_anousu 
                       )
                values (
                                nextval('parametrosrelatoriosiconf_c222_sequencial_seq') 
                                ,".($this->c222_recimpostostranseduc == "null" || $this->c222_recimpostostranseduc == ""?0:"'".$this->c222_recimpostostranseduc."'")." 
                                ,".($this->c222_transfundeb60 == "null" || $this->c222_transfundeb60 == ""?0:"'".$this->c222_transfundeb60."'")." 
                                ,".($this->c222_transfundeb40 == "null" || $this->c222_transfundeb40 == ""?0:"'".$this->c222_transfundeb40."'")." 
                                ,".($this->c222_recdestinadoeduc == "null" || $this->c222_recdestinadoeduc == ""?0:"'".$this->c222_recdestinadoeduc."'")."
                                ,".($this->c222_recimpostostranssaude == "null" || $this->c222_recimpostostranssaude == ""?0:"'".$this->c222_recimpostostranssaude."'")."
                                ,".($this->c222_recdestinadosaude == "null" || $this->c222_recdestinadosaude == ""?0:"'".$this->c222_recdestinadosaude."'")."
                                ,".($this->c222_recdestinadoassist == "null" || $this->c222_recdestinadoassist == ""?0:"'".$this->c222_recdestinadoassist."'")."
                                ,".($this->c222_recdestinadorppspp == "null" || $this->c222_recdestinadorppspp == ""?0:"'".$this->c222_recdestinadorppspp."'")."
                                ,".($this->c222_recdestinadorppspf == "null" || $this->c222_recdestinadorppspf == ""?0:"'".$this->c222_recdestinadorppspf."'")."
                                ,".($this->c222_recopcreditoexsaudeeduc == "null" || $this->c222_recopcreditoexsaudeeduc == ""?0:"'".$this->c222_recopcreditoexsaudeeduc."'")."
                                ,".($this->c222_recavaliacaodebens == "null" || $this->c222_recavaliacaodebens == ""?0:"'".$this->c222_recavaliacaodebens."'")."
                                ,".($this->c222_outrasdestinacoes == "null" || $this->c222_outrasdestinacoes == ""?0:"'".$this->c222_outrasdestinacoes."'")."
                                ,".($this->c222_recordinarios == "null" || $this->c222_recordinarios == ""?0:"'".$this->c222_recordinarios."'")."
                                ,".($this->c222_outrosrecnaovinculados == "null" || $this->c222_outrosrecnaovinculados == ""?0:"'".$this->c222_outrosrecnaovinculados."'")."
                                ,".($this->c222_anousu == "null" || $this->c222_anousu == ""?0:"'".$this->c222_anousu."'")."
                      )";
        $result = db_query($sql);echo pg_last_error($result);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "parametrosrelatoriosiconf () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "parametrosrelatoriosiconf já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "parametrosrelatoriosiconf () nao Incluído. Inclusao Abortada.";
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
    function alterar () {
        $this->atualizacampos();
        $sql = " update parametrosrelatoriosiconf set ";
        $virgula = "";
        if (trim($this->c222_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_sequencial"])) {
            $sql  .= $virgula." c222_sequencial = $this->c222_sequencial ";
            $virgula = ",";
            if (trim($this->c222_sequencial) == null ) {
                $this->erro_sql = " Campo Sequencial não informado.";
                $this->erro_campo = "c222_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c222_recimpostostranseduc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recimpostostranseduc"])) {
            if (trim($this->c222_recimpostostranseduc) == null || trim($this->c222_recimpostostranseduc) == "" ) {
                $sql .= $virgula . " c222_recimpostostranseduc = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recimpostostranseduc = $this->c222_recimpostostranseduc ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_transfundeb60)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_transfundeb60"])) {
            if (trim($this->c222_transfundeb60) == null || trim($this->c222_transfundeb60) == "" ) {
                $sql .= $virgula . " c222_transfundeb60 = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_transfundeb60 = $this->c222_transfundeb60 ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_transfundeb40)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_transfundeb40"])) {
            if (trim($this->c222_transfundeb40) == null || trim($this->c222_transfundeb40) == "" ) {
                $sql .= $virgula . " c222_transfundeb40 = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_transfundeb40 = $this->c222_transfundeb40 ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_recdestinadoeduc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recdestinadoeduc"])) {
            if (trim($this->c222_recdestinadoeduc) == null || trim($this->c222_recdestinadoeduc) == "" ) {
                $sql .= $virgula . " c222_recdestinadoeduc = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recdestinadoeduc = $this->c222_recdestinadoeduc ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_recimpostostranssaude)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recimpostostranssaude"])) {
            if (trim($this->c222_recimpostostranssaude) == null || trim($this->c222_recimpostostranssaude) == "" ) {
                $sql .= $virgula . " c222_recimpostostranssaude = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recimpostostranssaude = $this->c222_recimpostostranssaude ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_recdestinadosaude)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recdestinadosaude"])) {
            if (trim($this->c222_recdestinadosaude) == null || trim($this->c222_recdestinadosaude) == "" ) {
                $sql .= $virgula . " c222_recdestinadosaude = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recdestinadosaude = $this->c222_recdestinadosaude ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_recdestinadoassist)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recdestinadoassist"])) {
            if (trim($this->c222_recdestinadoassist) == null || trim($this->c222_recdestinadoassist) == "" ) {
                $sql .= $virgula . " c222_recdestinadoassist = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recdestinadoassist = $this->c222_recdestinadoassist ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_recdestinadorppspp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recdestinadorppspp"])) {
            if (trim($this->c222_recdestinadorppspp) == null || trim($this->c222_recdestinadorppspp) == "" ) {
                $sql .= $virgula . " c222_recdestinadorppspp = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recdestinadorppspp = $this->c222_recdestinadorppspp ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_recdestinadorppspf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recdestinadorppspf"])) {
            if (trim($this->c222_recdestinadorppspf) == null || trim($this->c222_recdestinadorppspf) == "" ) {
                $sql .= $virgula . " c222_recdestinadorppspf = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recdestinadorppspf = $this->c222_recdestinadorppspf ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_recopcreditoexsaudeeduc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recopcreditoexsaudeeduc"])) {
            if (trim($this->c222_recopcreditoexsaudeeduc) == null || trim($this->c222_recopcreditoexsaudeeduc) == "" ) {
                $sql .= $virgula . " c222_recopcreditoexsaudeeduc = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recopcreditoexsaudeeduc = $this->c222_recopcreditoexsaudeeduc ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_recavaliacaodebens)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recavaliacaodebens"])) {
            if (trim($this->c222_recavaliacaodebens) == null || trim($this->c222_recavaliacaodebens) == "" ) {
                $sql .= $virgula . " c222_recavaliacaodebens = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recavaliacaodebens = $this->c222_recavaliacaodebens ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_outrasdestinacoes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_outrasdestinacoes"])) {
            if (trim($this->c222_outrasdestinacoes) == null || trim($this->c222_outrasdestinacoes) == "" ) {
                $sql .= $virgula . " c222_outrasdestinacoes = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_outrasdestinacoes = $this->c222_outrasdestinacoes ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_recordinarios)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_recordinarios"])) {
            if (trim($this->c222_recordinarios) == null || trim($this->c222_recordinarios) == "" ) {
                $sql .= $virgula . " c222_recordinarios = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_recordinarios = $this->c222_recordinarios ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_outrosrecnaovinculados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_outrosrecnaovinculados"])) {
            if (trim($this->c222_outrosrecnaovinculados) == null || trim($this->c222_outrosrecnaovinculados) == "" ) {
                $sql .= $virgula . " c222_outrosrecnaovinculados = 0 ";
                $virgula = ",";
            }else{
                $sql .= $virgula . " c222_outrosrecnaovinculados = $this->c222_outrosrecnaovinculados ";
                $virgula = ",";
            }
        }

        if (trim($this->c222_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c222_anousu"])) {
            $sql  .= $virgula." c222_anousu = $this->c222_anousu ";
            $virgula = ",";
            if (trim($this->c222_anousu) == null ) {
                $this->erro_sql = " Campo Ano Uso não informado.";
                $this->erro_campo = "c222_anousu";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "c222_sequencial = $this->c222_sequencial";
//     die($sql);
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "parametrosrelatoriosiconf nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "parametrosrelatoriosiconf nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso classe\\n";
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

        $sql = " delete from parametrosrelatoriosiconf
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
            $this->erro_sql   = "parametrosrelatoriosiconf nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "parametrosrelatoriosiconf nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:parametrosrelatoriosiconf";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $oid = null,$campos="parametrosrelatoriosiconf.oid,*",$ordem=null,$dbwhere="") {
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
        $sql .= " from parametrosrelatoriosiconf ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ( $oid != "" && $oid != null) {
                $sql2 = " where parametrosrelatoriosiconf.oid = '$oid'";
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
        $sql .= " from parametrosrelatoriosiconf ";
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
