<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE entesconsorciados
class cl_entesconsorciados {
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
    public $c215_sequencial = 0;
    public $c215_cgm = 0;
    public $c215_percentualrateio = 0;
    public $c215_datainicioparticipacao_dia = null;
    public $c215_datainicioparticipacao_mes = null;
    public $c215_datainicioparticipacao_ano = null;
    public $c215_datainicioparticipacao = null;
    public $c215_datafimparticipacao_dia = null;
    public $c215_datafimparticipacao_mes = null;
    public $c215_datafimparticipacao_ano = null;
    public $c215_datafimparticipacao = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 c215_sequencial = int4 =
                 c215_cgm = int4 = CGM
                 c215_percentualrateio = float4 = Percentual  Rateio
                 c215_datainicioparticipacao = date = Data inicio participação
                 c215_datafimparticipacao = date = Data fim participação
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("entesconsorciados");
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
            $this->c215_sequencial = ($this->c215_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_sequencial"]:$this->c215_sequencial);
            $this->c215_cgm = ($this->c215_cgm == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_cgm"]:$this->c215_cgm);
            $this->c215_percentualrateio = ($this->c215_percentualrateio == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_percentualrateio"]:$this->c215_percentualrateio);
            if ($this->c215_datainicioparticipacao == "") {
                $this->c215_datainicioparticipacao_dia = ($this->c215_datainicioparticipacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_datainicioparticipacao_dia"]:$this->c215_datainicioparticipacao_dia);
                $this->c215_datainicioparticipacao_mes = ($this->c215_datainicioparticipacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_datainicioparticipacao_mes"]:$this->c215_datainicioparticipacao_mes);
                $this->c215_datainicioparticipacao_ano = ($this->c215_datainicioparticipacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_datainicioparticipacao_ano"]:$this->c215_datainicioparticipacao_ano);
                if ($this->c215_datainicioparticipacao_dia != "") {
                    $this->c215_datainicioparticipacao = $this->c215_datainicioparticipacao_ano."-".$this->c215_datainicioparticipacao_mes."-".$this->c215_datainicioparticipacao_dia;
                }
            }
            if ($this->c215_datafimparticipacao == "") {
                $this->c215_datafimparticipacao_dia = ($this->c215_datafimparticipacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_datafimparticipacao_dia"]:$this->c215_datafimparticipacao_dia);
                $this->c215_datafimparticipacao_mes = ($this->c215_datafimparticipacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_datafimparticipacao_mes"]:$this->c215_datafimparticipacao_mes);
                $this->c215_datafimparticipacao_ano = ($this->c215_datafimparticipacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_datafimparticipacao_ano"]:$this->c215_datafimparticipacao_ano);
                if ($this->c215_datafimparticipacao_dia != "") {
                    $this->c215_datafimparticipacao = $this->c215_datafimparticipacao_ano."-".$this->c215_datafimparticipacao_mes."-".$this->c215_datafimparticipacao_dia;
                }
            }
        } else {
            $this->c215_sequencial = ($this->c215_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c215_sequencial"]:$this->c215_sequencial);
        }
    }

    // funcao para inclusao
    function incluir ($c215_sequencial) {
        $this->atualizacampos();
        if ($this->c215_cgm == null ) {
            $this->erro_sql = " Campo CGM não informado.";
            $this->erro_campo = "c215_cgm";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c215_percentualrateio == null ) {
            $this->erro_sql = " Campo Percentual  Rateio não informado.";
            $this->erro_campo = "c215_percentualrateio";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c215_datainicioparticipacao == null ) {
            $this->erro_sql = " Campo Data inicio participação não informado.";
            $this->erro_campo = "c215_datainicioparticipacao_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c215_datafimparticipacao == null ) {
            $this->c215_datafimparticipacao = "null";
        }
        if ($c215_sequencial == "" || $c215_sequencial == null ) {
            $result = db_query("select nextval('entesconsorciados_c215_sequencial_seq')");
            if ($result==false) {
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: entesconsorciados_c215_sequencial_seq do campo: c215_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->c215_sequencial = pg_result($result,0,0);
        } else {
            $result = db_query("select last_value from entesconsorciados_c215_sequencial_seq");
            if (($result != false) && (pg_result($result,0,0) < $c215_sequencial)) {
                $this->erro_sql = " Campo c215_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->c215_sequencial = $c215_sequencial;
            }
        }
        if (($this->c215_sequencial == null) || ($this->c215_sequencial == "") ) {
            $this->erro_sql = " Campo c215_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into entesconsorciados(
                                       c215_sequencial
                                      ,c215_cgm
                                      ,c215_percentualrateio
                                      ,c215_datainicioparticipacao
                                      ,c215_datafimparticipacao
                       )
                values (
                                $this->c215_sequencial
                               ,$this->c215_cgm
                               ,$this->c215_percentualrateio
                               ,".($this->c215_datainicioparticipacao == "null" || $this->c215_datainicioparticipacao == ""?"null":"'".$this->c215_datainicioparticipacao."'")."
                               ,".($this->c215_datafimparticipacao == "null" || $this->c215_datafimparticipacao == ""?"null":"'".$this->c215_datafimparticipacao."'")."
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "entes consorciados ($this->c215_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "entes consorciados já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "entes consorciados ($this->c215_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->c215_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);

        return true;
    }

    // funcao para alteracao
    function alterar ($c215_sequencial=null) {
        $this->atualizacampos();
        $sql = " update entesconsorciados set ";
        $virgula = "";
        if (trim($this->c215_cgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c215_cgm"])) {
            $sql  .= $virgula." c215_cgm = $this->c215_cgm ";
            $virgula = ",";
            if (trim($this->c215_cgm) == null ) {
                $this->erro_sql = " Campo CGM não informado.";
                $this->erro_campo = "c215_cgm";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->c215_percentualrateio) != '') {
            $sql  .= $virgula." c215_percentualrateio = " . floatval($this->c215_percentualrateio) . " ";
            $virgula = ",";
        }
        if (trim($this->c215_datainicioparticipacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c215_datainicioparticipacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c215_datainicioparticipacao_dia"] !="") ) {
            $sql  .= $virgula." c215_datainicioparticipacao = '$this->c215_datainicioparticipacao' ";
            $virgula = ",";
            if (trim($this->c215_datainicioparticipacao) == null ) {
                $this->erro_sql = " Campo Data inicio participação não informado.";
                $this->erro_campo = "c215_datainicioparticipacao_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if (isset($GLOBALS["HTTP_POST_VARS"]["c215_datainicioparticipacao_dia"])) {
                $sql  .= $virgula." c215_datainicioparticipacao = null ";
                $virgula = ",";
                if (trim($this->c215_datainicioparticipacao) == null ) {
                    $this->erro_sql = " Campo Data inicio participação não informado.";
                    $this->erro_campo = "c215_datainicioparticipacao_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->c215_datafimparticipacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c215_datafimparticipacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c215_datafimparticipacao_dia"] !="") ) {
            $sql  .= $virgula." c215_datafimparticipacao = '$this->c215_datafimparticipacao' ";
            $virgula = ",";
        }     else{
            if (isset($GLOBALS["HTTP_POST_VARS"]["c215_datafimparticipacao_dia"])) {
                $sql  .= $virgula." c215_datafimparticipacao = null ";
                $virgula = ",";
            }
        }
        $sql .= " where ";
        if ($c215_sequencial!=null) {
            $sql .= " c215_sequencial = $this->c215_sequencial";
        }

        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "entes consorciados nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->c215_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "entes consorciados nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->c215_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->c215_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ($c215_sequencial=null,$dbwhere=null) {

        $sql = " delete from entesconsorciados
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            if ($c215_sequencial != "") {
                if ($sql2!="") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c215_sequencial = $c215_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "entes consorciados nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$c215_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "entes consorciados nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$c215_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$c215_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:entesconsorciados";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $c215_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from entesconsorciados ";
        $sql .= "      inner join cgm  on  cgm.z01_numcgm = entesconsorciados.c215_cgm";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c215_sequencial!=null ) {
                $sql2 .= " where entesconsorciados.c215_sequencial = $c215_sequencial ";
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

    // funcao do sql para pegar valor percentual da arrecadação de um ente sobre todos os outros.
    function sql_query_percentual ($dbwhere2="",$dbwhere3="") {
        $sql = "select coalesce(round((vlrarrecadeente/vlrarrecadetotal)*100,2),0) as percent from (
            select (select sum(case when c71_coddoc = 100 then c70_valor else c70_valor * -1 end)
              from entesconsorciadosreceitas 
            inner join orcreceita on c216_receita=o70_codfon and c216_anousu=o70_anousu
            inner join conlancamrec on c74_anousu=o70_anousu and c74_codrec=o70_codrec
            inner join conlancam on c74_codlan=c70_codlan
            inner join conlancamdoc on c71_codlan=c70_codlan
            inner join entesconsorciados on c216_enteconsorciado=c215_sequencial
            ".$dbwhere2.") as vlrarrecadetotal,
            (select sum(case when c71_coddoc = 100 then c70_valor else c70_valor * -1 end)
              from entesconsorciadosreceitas 
            inner join orcreceita on c216_receita=o70_codfon and c216_anousu=o70_anousu
            inner join conlancamrec on c74_anousu=o70_anousu and c74_codrec=o70_codrec
            inner join conlancam on c74_codlan=c70_codlan
            inner join conlancamdoc on c71_codlan=c70_codlan
            inner join entesconsorciados on c216_enteconsorciado=c215_sequencial
            ".$dbwhere3.") as vlrarrecadeente) as percent ";
        return $sql;
    }
    // funcao do sql
    function sql_query_file ( $c215_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from entesconsorciados ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ($c215_sequencial!=null ) {
                $sql2 .= " where entesconsorciados.c215_sequencial = $c215_sequencial ";
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
