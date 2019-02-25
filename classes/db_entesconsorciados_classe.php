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
                 c215_datainicioparticipacao = date = Data inicio participa��o
                 c215_datafimparticipacao = date = Data fim participa��o
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
       $this->erro_sql = " Campo CGM n�o informado.";
       $this->erro_campo = "c215_cgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c215_percentualrateio == null ) {
       $this->erro_sql = " Campo Percentual  Rateio n�o informado.";
       $this->erro_campo = "c215_percentualrateio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c215_datainicioparticipacao == null ) {
       $this->erro_sql = " Campo Data inicio participa��o n�o informado.";
       $this->erro_campo = "c215_datainicioparticipacao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->c215_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from entesconsorciados_c215_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $c215_sequencial)) {
         $this->erro_sql = " Campo c215_sequencial maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
         $this->erro_sql   = "entes consorciados ($this->c215_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "entes consorciados j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "entes consorciados ($this->c215_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c215_sequencial;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
         $this->erro_sql = " Campo CGM n�o informado.";
         $this->erro_campo = "c215_cgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
         $this->erro_sql = " Campo Data inicio participa��o n�o informado.";
         $this->erro_campo = "c215_datainicioparticipacao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["c215_datainicioparticipacao_dia"])) {
         $sql  .= $virgula." c215_datainicioparticipacao = null ";
         $virgula = ",";
         if (trim($this->c215_datainicioparticipacao) == null ) {
           $this->erro_sql = " Campo Data inicio participa��o n�o informado.";
           $this->erro_campo = "c215_datainicioparticipacao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "entes consorciados nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c215_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c215_sequencial;
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
       $this->erro_sql   = "entes consorciados nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c215_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "entes consorciados nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c215_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c215_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if ($this->numrows==0) {
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:entesconsorciados";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
       $sql2 = " where  $dbwhere";
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
  function gerarSQLDespesas($sMes, $sEnte) {
    $nEnte  = intval($sEnte);
    $nMes   = intval($sMes);
    $nAno   = intval(db_getsession('DB_anousu'));

    $sql = "SELECT sum(c217_valorpago) despesasatemes
        FROM despesarateioconsorcio";
    if($nMes == 1){
        $sql = "SELECT sum(c217_valorpago) despesasatemes
          FROM despesarateioconsorcio limit 0"; 
    }else{ 
      if($sEnte == null){ 
        $sql .= " WHERE c217_mes<={$nMes}
              AND c217_anousu={$nAno}";
      }else{
         $sql = " WHERE c217_enteconsorciado={$nEnte}
              AND c217_mes<={$nMes}
              AND c217_anousu={$nAno}";
      }
    }
    return $sql;
  }

  function sql_rec_saldo_inicial($sEnte){
    $nEnte  = intval($sEnte);
    $nAno   = intval(db_getsession('DB_anousu'));
    $sql = "select sum(c216_saldo3112) as c216_saldo3112 from entesconsorciadosreceitas ";
    if($nEnte == null){
        $sql .= " where c216_anousu=".$nAno;
    }else
        $sql .= " where c216_enteconsorciado=".$nEnte." and c216_anousu=".$nAno;
    return $sql;
  }
  function gerarSQLReceitas($sMes, $sEnte) {

    $nEnte  = intval($sEnte);
    $nMes   = intval($sMes);
    $nAno   = intval(db_getsession('DB_anousu'));
    
    $sql = "SELECT (sum(CASE
                          WHEN c71_coddoc = 100 THEN (c70_valor*(c216_percentual/100))
                          ELSE (c70_valor*(c216_percentual/100)) * -1
                      END)) AS receitasatemes
          FROM entesconsorciadosreceitas
          INNER JOIN orcreceita ON c216_receita=o70_codfon
          AND c216_anousu=o70_anousu
          INNER JOIN conlancamrec ON c74_anousu=o70_anousu
          AND c74_codrec=o70_codrec
          INNER JOIN conlancam ON c74_codlan=c70_codlan
          INNER JOIN conlancamdoc ON c71_codlan=c70_codlan
          INNER JOIN entesconsorciados ON c216_enteconsorciado=c215_sequencial
          INNER JOIN tipodereceitarateio ON c216_tiporeceita=c218_codigo ";

    if($sEnte == null){
       $sql .=" WHERE date_part('MONTH',c70_data) <={$nMes}
              AND date_part('YEAR',c70_data)={$nAno}
              AND c215_datainicioparticipacao <= '{$nAno}-{$nMes}-01'
          ORDER BY c216_tiporeceita ";
    }else{ 
      $sql .=" WHERE date_part('MONTH',c70_data) <={$nMes}
                AND date_part('YEAR',c70_data)={$nAno}
                AND c216_enteconsorciado={$nEnte}
                AND c215_datainicioparticipacao <= '{$nAno}-{$nMes}-01'
            ORDER BY c216_tiporeceita ";
      }
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
