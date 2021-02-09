<?php
//MODULO: veiculos
//CLASSE DA ENTIDADE veiculostransferencia
class cl_veiculostransferencia {
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
    public $ve81_sequencial = 0;
    public $ve81_codigo = 0;
    public $ve81_codigoant = 0;
    public $ve81_codigonovo = 0;
    public $ve81_placa = null;
    public $ve81_codunidadesubatual = null;
    public $ve81_codunidadesubant = null;
    public $ve81_transferencia = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 ve81_sequencial = int4 = Seq. transf. veiculos
                 ve81_codigo = int4 = Codigo do Veiculo
                 ve81_codigoant = int4 = Codigo Anterior
                 ve81_placa = varchar(7) = Placa
                 ve81_codunidadesubatual = varchar(8) = Codigo unidade ant. atual
                 ve81_codunidadesubant = varchar(8) = Codigo Anterior
                 ve81_transferencia = int4 = CÃ³digo da transferencia
                 ve81_codigonovo    = int4 = novo codigo do veiculos
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("veiculostransferencia");
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
            $this->ve81_sequencial = ($this->ve81_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ve81_sequencial"]:$this->ve81_sequencial);
            $this->ve81_codigo = ($this->ve81_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["ve81_codigo"]:$this->ve81_codigo);
            $this->ve81_codigoant = ($this->ve81_codigoant == ""?@$GLOBALS["HTTP_POST_VARS"]["ve81_codigoant"]:$this->ve81_codigoant);
            $this->ve81_placa = ($this->ve81_placa == ""?@$GLOBALS["HTTP_POST_VARS"]["ve81_placa"]:$this->ve81_placa);
            $this->ve81_codunidadesubatual = ($this->ve81_codunidadesubatual == ""?@$GLOBALS["HTTP_POST_VARS"]["ve81_codunidadesubatual"]:$this->ve81_codunidadesubatual);
            $this->ve81_codunidadesubant = ($this->ve81_codunidadesubant == ""?@$GLOBALS["HTTP_POST_VARS"]["ve81_codunidadesubant"]:$this->ve81_codunidadesubant);
            $this->ve81_transferencia = ($this->ve81_transferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["ve81_transferencia"]:$this->ve81_transferencia);
            $this->ve81_codigonovo = ($this->ve81_codigonovo == ""?@$GLOBALS["HTTP_POST_VARS"]["ve81_codigonovo"]:$this->ve81_codigonovo);
        } else {
        }
    }

    // funcao para inclusao
    function incluir ($ve81_sequencial) {
        $this->atualizacampos();
        if ($this->ve81_codigo == null ) {
            $this->erro_sql = " Campo Codigo do Veiculo não informado.";
            $this->erro_campo = "ve81_codigo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ve81_codigoant == null ) {
            $this->ve81_codigoant = "0";
        }
        // if ($this->ve81_placa == null ) {
        //     $this->erro_sql = " Campo PlacaOS não informado.";
        //     $this->erro_campo = "ve81_placa";
        //     $this->erro_banco = "";
        //     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        //     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        //     $this->erro_status = "0";
        //     return false;
        // }
        if ($this->ve81_codunidadesubatual == null ) {
            $this->erro_sql = " Campo Codigo unidade ant. atual não informado.";
            $this->erro_campo = "ve81_codunidadesubatual";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ve81_codunidadesubant == null ) {
            $this->erro_sql = " Campo Codigo Anterior não informado.";
            $this->erro_campo = "ve81_codunidadesubant";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ve81_codigonovo == null ) {
            $this->erro_sql = " Campo Codigo Anterior não informado.";
            $this->erro_campo = "ve81_codigonovo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->ve81_transferencia == null ) {
            $this->erro_sql = " Campo CÃ³digo da transferencia não informado.";
            $this->erro_campo = "ve81_transferencia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($ve81_sequencial == "" || $ve81_sequencial == null ) {
            $result = db_query("select nextval('veiculostransferencia_ve81_sequencial_seq')");
            if ($result==false) {
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: veiculostransferencia_ve81_sequencial_seq do campo: ve81_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->ve81_sequencial = pg_result($result,0,0);
        } else {
            $result = db_query("select last_value from veiculostransferencia_ve81_sequencial_seq");
            if (($result != false) && (pg_result($result,0,0) < $ve81_sequencial)) {
                $this->erro_sql = " Campo ve81_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->ve81_sequencial = $ve81_sequencial;
            }
        }
        $sql = "insert into veiculostransferencia(
                                       ve81_sequencial
                                      ,ve81_codigo
                                      ,ve81_codigoant
                                      ,ve81_placa
                                      ,ve81_codunidadesubatual
                                      ,ve81_codunidadesubant
                                      ,ve81_transferencia
                                      ,ve81_codigonovo
                       )
                values (
                                $this->ve81_sequencial
                               ,$this->ve81_codigo
                               ,$this->ve81_codigoant
                               ,'$this->ve81_placa'
                               ,'$this->ve81_codunidadesubatual'
                               ,'$this->ve81_codunidadesubant'
                               ,$this->ve81_transferencia
                               ,$this->ve81_codigonovo
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "Veiculos Tranferencia () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Veiculos Tranferencia já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "Veiculos Tranferencia () nao Incluído. Inclusao Abortada.";
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
        $sql = " update veiculostransferencia set ";
        $virgula = "";
        if (trim($this->ve81_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve81_sequencial"])) {
            $sql  .= $virgula." ve81_sequencial = $this->ve81_sequencial ";
            $virgula = ",";
            if (trim($this->ve81_sequencial) == null ) {
                $this->erro_sql = " Campo Seq. transf. veiculos não informado.";
                $this->erro_campo = "ve81_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ve81_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve81_codigo"])) {
            $sql  .= $virgula." ve81_codigo = $this->ve81_codigo ";
            $virgula = ",";
            if (trim($this->ve81_codigo) == null ) {
                $this->erro_sql = " Campo Codigo do Veiculo não informado.";
                $this->erro_campo = "ve81_codigo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ve81_codigoant)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve81_codigoant"])) {
            if (trim($this->ve81_codigoant)=="" && isset($GLOBALS["HTTP_POST_VARS"]["ve81_codigoant"])) {
                $this->ve81_codigoant = "0" ;
            }
            $sql  .= $virgula." ve81_codigoant = $this->ve81_codigoant ";
            $virgula = ",";
        }

        if (trim($this->ve81_codigonovo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve81_codigonovo"])) {
            if (trim($this->ve81_codigonovo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["ve81_codigonovo"])) {
                $this->ve81_codigonovo = "0" ;
            }
            $sql  .= $virgula." ve81_codigonovo = $this->ve81_codigonovo ";
            $virgula = ",";
        }
        if (trim($this->ve81_placa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve81_placa"])) {
            $sql  .= $virgula." ve81_placa = '$this->ve81_placa' ";
            $virgula = ",";
            // if (trim($this->ve81_placa) == null ) {
            //     $this->erro_sql = " Campo Placa não informado.";
            //     $this->erro_campo = "ve81_placa";
            //     $this->erro_banco = "";
            //     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            //     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            //     $this->erro_status = "0";
            //     return false;
            // }
        }
        if (trim($this->ve81_codunidadesubatual)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve81_codunidadesubatual"])) {
            $sql  .= $virgula." ve81_codunidadesubatual = '$this->ve81_codunidadesubatual' ";
            $virgula = ",";
            if (trim($this->ve81_codunidadesubatual) == null ) {
                $this->erro_sql = " Campo Codigo unidade ant. atual não informado.";
                $this->erro_campo = "ve81_codunidadesubatual";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ve81_codunidadesubant)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve81_codunidadesubant"])) {
            $sql  .= $virgula." ve81_codunidadesubant = '$this->ve81_codunidadesubant' ";
            $virgula = ",";
            if (trim($this->ve81_codunidadesubant) == null ) {
                $this->erro_sql = " Campo Codigo Anterior não informado.";
                $this->erro_campo = "ve81_codunidadesubant";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->ve81_transferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve81_transferencia"])) {
            $sql  .= $virgula." ve81_transferencia = $this->ve81_transferencia ";
            $virgula = ",";
            if (trim($this->ve81_transferencia) == null ) {
                $this->erro_sql = " Campo CÓdigo da transferencia não informado.";
                $this->erro_campo = "ve81_transferencia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "oid = '$oid'";     $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Veiculos Tranferencia nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Veiculos Tranferencia nao foi Alterado. Alteracao Executada.\\n";
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

        $sql = " delete from veiculostransferencia
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
            $this->erro_sql   = "Veiculos Tranferencia nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "Veiculos Tranferencia nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:veiculostransferencia";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $oid = null,$campos="veiculostransferencia.oid,*",$ordem=null,$dbwhere="") {
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
        $sql .= " from veiculostransferencia ";
        $sql .= "      inner join veiculos  on  veiculos.ve01_codigo = veiculostransferencia.ve81_codunidadesubant";
        $sql .= "      inner join   on  . = veiculostransferencia.ve81_codunidadesubatual";
        $sql .= "      inner join ceplocalidades  on  ceplocalidades.cp05_codlocalidades = veiculos.ve01_ceplocalidades";
        $sql .= "      inner join veiccadtipo  on  veiccadtipo.ve20_codigo = veiculos.ve01_veiccadtipo";
        $sql .= "      inner join veiccadmarca  on  veiccadmarca.ve21_codigo = veiculos.ve01_veiccadmarca";
        $sql .= "      inner join veiccadmodelo  on  veiccadmodelo.ve22_codigo = veiculos.ve01_veiccadmodelo";
        $sql .= "      inner join veiccadcor  on  veiccadcor.ve23_codigo = veiculos.ve01_veiccadcor";
        $sql .= "      inner join veiccadtipocapacidade  on  veiccadtipocapacidade.ve24_codigo = veiculos.ve01_veiccadtipocapacidade";
        $sql .= "      inner join veiccadcategcnh  on  veiccadcategcnh.ve30_codigo = veiculos.ve01_veiccadcategcnh";
        $sql .= "      inner join veiccadproced  on  veiccadproced.ve25_codigo = veiculos.ve01_veiccadproced";
        $sql .= "      inner join veiccadpotencia  on  veiccadpotencia.ve31_codigo = veiculos.ve01_veiccadpotencia";
        $sql .= "      inner join veiccadcateg  as a on   a.ve32_codigo = veiculos.ve01_veiccadcateg";
        $sql .= "      inner join veictipoabast  on  veictipoabast.ve07_sequencial = veiculos.ve01_veictipoabast";
        $sql2 = "";
        if ($dbwhere=="") {
            if ( $oid != "" && $oid != null) {
                $sql2 = " where veiculostransferencia.oid = '$oid'";
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
        $sql .= " from veiculostransferencia ";
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

    function sql_buscar_transferencia ( $oid = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from veiculostransferencia ";
        $sql .= " inner join transferenciaveiculos on ve80_sequencial = ve81_transferencia  ";
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
