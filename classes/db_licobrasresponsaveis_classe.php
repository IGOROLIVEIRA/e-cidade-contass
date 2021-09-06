<?php
//MODULO: Obras
//CLASSE DA ENTIDADE licobrasresponsaveis
class cl_licobrasresponsaveis {
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
    public $obr05_sequencial = 0;
    public $obr05_seqobra = 0;
    public $obr05_responsavel = 0;
    public $obr05_tiporesponsavel = 0;
    public $obr05_tiporegistro = 0;
    public $obr05_numregistro = null;
    public $obr05_numartourrt = 0;
    public $obr05_vinculoprofissional = 0;
    public $obr05_dtcadastrores = null;
    public $obr05_instit = 0;
    public $obr05_dscoutroconselho = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 obr05_sequencial = int8 = Cód. Sequencial
                 obr05_seqobra = int8 = Nº Obra
                 obr05_responsavel = int8 = Responsável
                 obr05_tiporesponsavel = int8 = Tipo Responsável
                 obr05_tiporegistro = int8 = Tipo Registro
                 obr05_numregistro = text = Numero Registro
                 obr05_numartourrt = int8 = Numero da ART ou RRT
                 obr05_vinculoprofissional = int8 = Vinculo do Prof. com a Adm. Pública
                 obr05_dtcadastrores = date = data de cadastro responsavel
                 obr05_instit = int8 = Instituição
                 obr05_dscoutroconselho = text = descricao outro conselho
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("licobrasresponsaveis");
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
            $this->obr05_sequencial = ($this->obr05_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_sequencial"]:$this->obr05_sequencial);
            $this->obr05_seqobra = ($this->obr05_seqobra == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_seqobra"]:$this->obr05_seqobra);
            $this->obr05_responsavel = ($this->obr05_responsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_responsavel"]:$this->obr05_responsavel);
            $this->obr05_tiporesponsavel = ($this->obr05_tiporesponsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_tiporesponsavel"]:$this->obr05_tiporesponsavel);
            $this->obr05_tiporegistro = ($this->obr05_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_tiporegistro"]:$this->obr05_tiporegistro);
            $this->obr05_numregistro = ($this->obr05_numregistro == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_numregistro"]:$this->obr05_numregistro);
            $this->obr05_numartourrt = ($this->obr05_numartourrt == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_numartourrt"]:$this->obr05_numartourrt);
            $this->obr05_vinculoprofissional = ($this->obr05_vinculoprofissional == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_vinculoprofissional"]:$this->obr05_vinculoprofissional);
            $this->obr05_dtcadastrores = ($this->obr05_dtcadastrores == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_dtcadastrores"]:$this->obr05_dtcadastrores);
            $this->obr05_instit = ($this->obr05_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_instit"]:$this->obr05_instit);
            $this->obr05_dscoutroconselho = ($this->obr05_dscoutroconselho == ""?@$GLOBALS["HTTP_POST_VARS"]["obr05_dscoutroconselho"]:$this->obr05_dscoutroconselho);
        } else {
        }
    }

    // funcao para inclusao
    function incluir () {

        $this->atualizacampos();
        if ($this->obr05_sequencial == null ) {
            $result = db_query("select nextval('licobrasresponsaveis_obr05_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: licobrasresponsaveis_obr05_sequencial_seq do campo: obr05_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->obr05_sequencial = pg_result($result,0,0);
        }
        if ($this->obr05_seqobra == null ) {
            $this->erro_sql = " Campo Nº Obra não informado.";
            $this->erro_campo = "obr05_seqobra";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->obr05_responsavel == null ) {
            $this->erro_sql = " Campo Responsável não informado.";
            $this->erro_campo = "obr05_responsavel";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->obr05_tiporesponsavel == null ) {
            $this->erro_sql = " Campo Tipo Responsável não informado.";
            $this->erro_campo = "obr05_tiporesponsavel";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->obr05_tiporegistro == null ) {
            $this->erro_sql = " Campo Tipo Registro não informado.";
            $this->erro_campo = "obr05_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->obr05_numregistro == null ) {
            $this->erro_sql = " Usuário: Campo Número Registro não informado!";
            $this->erro_campo = "obr05_numregistro";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: ".$this->erro_sql."";
            $this->erro_status = "0";
            return false;
        }
        if ($this->obr05_numartourrt == null ) {
            $this->obr05_numartourrt = 'NULL';
        }
        if ($this->obr05_vinculoprofissional == null ) {
            $this->erro_sql = " Campo Vinculo do Prof. com a Adm. Pública não informado.";
            $this->erro_campo = "obr05_vinculoprofissional";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->obr05_dtcadastrores == null ) {
            $this->erro_sql = " Campo data de cadastro não informado.";
            $this->erro_campo = "obr05_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->obr05_instit == null ) {
            $this->erro_sql = " Campo Instituição não informado.";
            $this->erro_campo = "obr05_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->obr05_tiporegistro == 3) {
            if ($this->obr05_dscoutroconselho == null) {
                $this->erro_sql = " Campo Descricão Outro Conselho não informado.";
                $this->erro_campo = "obr05_instit";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql = "insert into licobrasresponsaveis(
                                       obr05_sequencial
                                      ,obr05_seqobra
                                      ,obr05_responsavel
                                      ,obr05_tiporesponsavel
                                      ,obr05_tiporegistro
                                      ,obr05_numregistro
                                      ,obr05_numartourrt
                                      ,obr05_vinculoprofissional
                                      ,obr05_dtcadastrores
                                      ,obr05_instit
                                      ,obr05_dscoutroconselho
                       )
                values (
                                $this->obr05_sequencial
                               ,$this->obr05_seqobra
                               ,$this->obr05_responsavel
                               ,$this->obr05_tiporesponsavel
                               ,$this->obr05_tiporegistro
                               ,'$this->obr05_numregistro'
                               ,$this->obr05_numartourrt
                               ,$this->obr05_vinculoprofissional
                               ,'$this->obr05_dtcadastrores'
                               ,$this->obr05_instit
                               ,'$this->obr05_dscoutroconselho'
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "cadastro de responsaveis pela obras () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "cadastro de responsaveis pela obras já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "cadastro de responsaveis pela obras () nao Incluído. Inclusao Abortada.";
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
    function alterar ( $obr05_sequencial=null ) {
        $this->atualizacampos();
        $sql = " update licobrasresponsaveis set ";
        $virgula = "";
        if (trim($this->obr05_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_sequencial"])) {
            $sql  .= $virgula." obr05_sequencial = $this->obr05_sequencial ";
            $virgula = ",";
            if (trim($this->obr05_sequencial) == null ) {
                $this->erro_sql = " Campo Cód. Sequencial não informado.";
                $this->erro_campo = "obr05_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_seqobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_seqobra"])) {
            $sql  .= $virgula." obr05_seqobra = $this->obr05_seqobra ";
            $virgula = ",";
            if (trim($this->obr05_seqobra) == null ) {
                $this->erro_sql = " Campo Nº Obra não informado.";
                $this->erro_campo = "obr05_seqobra";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_responsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_responsavel"])) {
            $sql  .= $virgula." obr05_responsavel = $this->obr05_responsavel ";
            $virgula = ",";
            if (trim($this->obr05_responsavel) == null ) {
                $this->erro_sql = " Campo Responsável não informado.";
                $this->erro_campo = "obr05_responsavel";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_tiporesponsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_tiporesponsavel"])) {
            $sql  .= $virgula." obr05_tiporesponsavel = $this->obr05_tiporesponsavel ";
            $virgula = ",";
            if (trim($this->obr05_tiporesponsavel) == null ) {
                $this->erro_sql = " Campo Tipo Responsável não informado.";
                $this->erro_campo = "obr05_tiporesponsavel";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_tiporegistro"])) {
            $sql  .= $virgula." obr05_tiporegistro = $this->obr05_tiporegistro ";
            $virgula = ",";
            if (trim($this->obr05_tiporegistro) == null ) {
                $this->erro_sql = " Campo Tipo Registro não informado.";
                $this->erro_campo = "obr05_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_numregistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_numregistro"])) {
            $sql  .= $virgula." obr05_numregistro = '$this->obr05_numregistro' ";
            $virgula = ",";
            if (trim($this->obr05_numregistro) == null ) {
                $this->erro_sql = " Campo Numero Registro não informado.";
                $this->erro_campo = "obr05_numregistro";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_numartourrt)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_numartourrt"])) {
            $sql  .= $virgula." obr05_numartourrt = $this->obr05_numartourrt ";
            $virgula = ",";
            if (trim($this->obr05_numartourrt) == null ) {
                $this->erro_sql = " Campo Numero da ART ou RRT não informado.";
                $this->erro_campo = "obr05_numartourrt";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_vinculoprofissional)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_vinculoprofissional"])) {
            $sql  .= $virgula." obr05_vinculoprofissional = $this->obr05_vinculoprofissional ";
            $virgula = ",";
            if (trim($this->obr05_vinculoprofissional) == null ) {
                $this->erro_sql = " Campo Vinculo do Prof. com a Adm. Pública não informado.";
                $this->erro_campo = "obr05_vinculoprofissional";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_dtcadastrores)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_dtcadastrores"])) {
            $sql  .= $virgula." obr05_dtcadastrores = '$this->obr05_dtcadastrores' ";
            $virgula = ",";
            if (trim($this->obr05_dtcadastrores) == null ) {
                $this->erro_sql = " Campo data cadastro não informado.";
                $this->erro_campo = "obr05_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_instit"])) {
            $sql  .= $virgula." obr05_instit = $this->obr05_instit ";
            $virgula = ",";
            if (trim($this->obr05_instit) == null ) {
                $this->erro_sql = " Campo Instituição não informado.";
                $this->erro_campo = "obr05_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->obr05_dscoutroconselho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr05_dscoutroconselho"])) {
            $sql  .= $virgula." obr05_dscoutroconselho = '$this->obr05_dscoutroconselho' ";
            $virgula = ",";
            if($this->obr05_tiporegistro == 3){
                if (trim($this->obr05_dscoutroconselho) == null ) {
                    $this->erro_sql = " Campo Instituição não informado.";
                    $this->erro_campo = "obr05_instit";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        $sql .= " where ";
        $sql .= "obr05_sequencial = $obr05_sequencial";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "cadastro de responsaveis pela obras nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "cadastro de responsaveis pela obras nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir ( $obr05_sequencial=null ,$dbwhere=null) {

        $sql = " delete from licobrasresponsaveis
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            $sql2 = "obr05_sequencial = $obr05_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "cadastro de responsaveis pela obras nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "cadastro de responsaveis pela obras nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:licobrasresponsaveis";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $obr05_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from licobrasresponsaveis ";
        $sql .= " inner join cgm on z01_numcgm = obr05_responsavel ";
        $sql .= " inner join licobras on obr01_sequencial = obr05_seqobra ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ( $obr05_sequencial != "" && $obr05_sequencial != null) {
                $sql2 = " where licobrasresponsaveis.obr05_sequencial = $obr05_sequencial";
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
    function sql_query_file ( $obr05_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from licobrasresponsaveis ";
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
