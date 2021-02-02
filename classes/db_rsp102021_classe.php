<?
//MODULO: sicom
//CLASSE DA ENTIDADE rsp102021
class cl_rsp102021
{
  // cria variaveis de erro
  var $rotulo = null;
  var $query_sql = null;
  var $numrows = 0;
  var $numrows_incluir = 0;
  var $numrows_alterar = 0;
  var $numrows_excluir = 0;
  var $erro_status = null;
  var $erro_sql = null;
  var $erro_banco = null;
  var $erro_msg = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo
  var $si112_sequencial = 0;
  var $si112_tiporegistro = 0;
  var $si112_codreduzidorsp = 0;
  var $si112_codorgao = null;
  var $si112_codunidadesub = null;
  var $si112_codunidadesuborig = null;
  var $si112_nroempenho = 0;
  var $si112_exercicioempenho = 0;
  var $si112_dtempenho_dia = null;
  var $si112_dtempenho_mes = null;
  var $si112_dtempenho_ano = null;
  var $si112_dtempenho = null;
  var $si112_dotorig = null;
  var $si112_vloriginal = 0;
  var $si112_vlsaldoantproce = 0;
  var $si112_vlsaldoantnaoproc = 0;
  var $si112_mes = 0;
  var $si112_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si112_sequencial = int8 = sequencial 
                 si112_tiporegistro = int8 = Tipo do  registro 
                 si112_codreduzidorsp = int8 = Código Identificador do resto a pagar 
                 si112_codorgao = varchar(2) = Código do órgão 
                 si112_codunidadesub = varchar(8) = Código da  unidade 
                 si112_codunidadesuborig = varchar(8) = Código da  unidade 
                 si112_nroempenho = int8 = Número do  empenho 
                 si112_exercicioempenho = int8 = Exercício do  empenho 
                 si112_dtempenho = date = Data do empenho 
                 si112_dotorig = varchar(21) = Classificação da  Despesa 
                 si112_vloriginal = float8 = Valor original do  empenho 
                 si112_vlsaldoantproce = float8 = Valor do Saldo do  empenho 
                 si112_vlsaldoantnaoproc = float8 = Valor do Saldo do  empenho 
                 si112_mes = int8 = Mês 
                 si112_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_rsp102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rsp102021");
    $this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }
  
  //funcao erro
  function erro($mostra, $retorna)
  {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
      echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
      if ($retorna == true) {
        echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
      }
    }
  }
  
  // funcao para atualizar campos
  function atualizacampos($exclusao = false)
  {
    if ($exclusao == false) {
      $this->si112_sequencial = ($this->si112_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_sequencial"] : $this->si112_sequencial);
      $this->si112_tiporegistro = ($this->si112_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_tiporegistro"] : $this->si112_tiporegistro);
      $this->si112_codreduzidorsp = ($this->si112_codreduzidorsp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_codreduzidorsp"] : $this->si112_codreduzidorsp);
      $this->si112_codorgao = ($this->si112_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_codorgao"] : $this->si112_codorgao);
      $this->si112_codunidadesub = ($this->si112_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_codunidadesub"] : $this->si112_codunidadesub);
      $this->si112_codunidadesuborig = ($this->si112_codunidadesuborig == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_codunidadesuborig"] : $this->si112_codunidadesuborig);
      $this->si112_nroempenho = ($this->si112_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_nroempenho"] : $this->si112_nroempenho);
      $this->si112_exercicioempenho = ($this->si112_exercicioempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_exercicioempenho"] : $this->si112_exercicioempenho);
      if ($this->si112_dtempenho == "") {
        $this->si112_dtempenho_dia = ($this->si112_dtempenho_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_dtempenho_dia"] : $this->si112_dtempenho_dia);
        $this->si112_dtempenho_mes = ($this->si112_dtempenho_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_dtempenho_mes"] : $this->si112_dtempenho_mes);
        $this->si112_dtempenho_ano = ($this->si112_dtempenho_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_dtempenho_ano"] : $this->si112_dtempenho_ano);
        if ($this->si112_dtempenho_dia != "") {
          $this->si112_dtempenho = $this->si112_dtempenho_ano . "-" . $this->si112_dtempenho_mes . "-" . $this->si112_dtempenho_dia;
        }
      }
      $this->si112_dotorig = ($this->si112_dotorig == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_dotorig"] : $this->si112_dotorig);
      $this->si112_vloriginal = ($this->si112_vloriginal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_vloriginal"] : $this->si112_vloriginal);
      $this->si112_vlsaldoantproce = ($this->si112_vlsaldoantproce == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_vlsaldoantproce"] : $this->si112_vlsaldoantproce);
      $this->si112_vlsaldoantnaoproc = ($this->si112_vlsaldoantnaoproc == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_vlsaldoantnaoproc"] : $this->si112_vlsaldoantnaoproc);
      $this->si112_mes = ($this->si112_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_mes"] : $this->si112_mes);
      $this->si112_instit = ($this->si112_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_instit"] : $this->si112_instit);
    } else {
      $this->si112_sequencial = ($this->si112_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si112_sequencial"] : $this->si112_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si112_sequencial)
  {
    $this->atualizacampos();
    if ($this->si112_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si112_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si112_codreduzidorsp == null) {
      $this->si112_codreduzidorsp = "0";
    }
    if ($this->si112_nroempenho == null) {
      $this->si112_nroempenho = "0";
    }
    if ($this->si112_exercicioempenho == null) {
      $this->si112_exercicioempenho = "0";
    }
    if ($this->si112_dtempenho == null) {
      $this->si112_dtempenho = "null";
    }
    if ($this->si112_vloriginal == null) {
      $this->si112_vloriginal = "0";
    }
    if ($this->si112_vlsaldoantproce == null) {
      $this->si112_vlsaldoantproce = "0";
    }
    if ($this->si112_vlsaldoantnaoproc == null) {
      $this->si112_vlsaldoantnaoproc = "0";
    }
    if ($this->si112_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si112_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si112_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si112_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si112_sequencial == "" || $si112_sequencial == null) {
      $result = db_query("select nextval('rsp102021_si112_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: rsp102021_si112_sequencial_seq do campo: si112_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si112_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from rsp102021_si112_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si112_sequencial)) {
        $this->erro_sql = " Campo si112_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si112_sequencial = $si112_sequencial;
      }
    }
    if (($this->si112_sequencial == null) || ($this->si112_sequencial == "")) {
      $this->erro_sql = " Campo si112_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into rsp102021(
                                       si112_sequencial 
                                      ,si112_tiporegistro 
                                      ,si112_codreduzidorsp 
                                      ,si112_codorgao 
                                      ,si112_codunidadesub 
                                      ,si112_nroempenho 
                                      ,si112_exercicioempenho 
                                      ,si112_dtempenho 
                                      ,si112_dotorig 
                                      ,si112_vloriginal 
                                      ,si112_vlsaldoantproce 
                                      ,si112_vlsaldoantnaoproc 
                                      ,si112_mes 
                                      ,si112_instit 
                                      ,si112_codunidadesuborig
                       )
                values (
                                $this->si112_sequencial 
                               ,$this->si112_tiporegistro 
                               ,$this->si112_codreduzidorsp 
                               ,'$this->si112_codorgao' 
                               ,'$this->si112_codunidadesub' 
                               ,$this->si112_nroempenho 
                               ,$this->si112_exercicioempenho 
                               ," . ($this->si112_dtempenho == "null" || $this->si112_dtempenho == "" ? "null" : "'" . $this->si112_dtempenho . "'") . " 
                               ,'$this->si112_dotorig' 
                               ,$this->si112_vloriginal 
                               ,$this->si112_vlsaldoantproce 
                               ,$this->si112_vlsaldoantnaoproc 
                               ,$this->si112_mes 
                               ,$this->si112_instit
                               ,'$this->si112_codunidadesuborig' 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "rsp102021 ($this->si112_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "rsp102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "rsp102021 ($this->si112_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si112_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si112_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010722,'$this->si112_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010341,2010722,'','" . AddSlashes(pg_result($resaco, 0, 'si112_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010723,'','" . AddSlashes(pg_result($resaco, 0, 'si112_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010724,'','" . AddSlashes(pg_result($resaco, 0, 'si112_codreduzidorsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010725,'','" . AddSlashes(pg_result($resaco, 0, 'si112_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010726,'','" . AddSlashes(pg_result($resaco, 0, 'si112_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010727,'','" . AddSlashes(pg_result($resaco, 0, 'si112_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2011330,'','" . AddSlashes(pg_result($resaco, 0, 'si112_exercicioempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010728,'','" . AddSlashes(pg_result($resaco, 0, 'si112_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010729,'','" . AddSlashes(pg_result($resaco, 0, 'si112_dotorig')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010730,'','" . AddSlashes(pg_result($resaco, 0, 'si112_vloriginal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010731,'','" . AddSlashes(pg_result($resaco, 0, 'si112_vlsaldoantproce')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010732,'','" . AddSlashes(pg_result($resaco, 0, 'si112_vlsaldoantnaoproc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2010733,'','" . AddSlashes(pg_result($resaco, 0, 'si112_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010341,2011625,'','" . AddSlashes(pg_result($resaco, 0, 'si112_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si112_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update rsp102021 set ";
    $virgula = "";
    if (trim($this->si112_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_sequencial"])) {
      if (trim($this->si112_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si112_sequencial"])) {
        $this->si112_sequencial = "0";
      }
      $sql .= $virgula . " si112_sequencial = $this->si112_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si112_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_tiporegistro"])) {
      $sql .= $virgula . " si112_tiporegistro = $this->si112_tiporegistro ";
      $virgula = ",";
      if (trim($this->si112_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si112_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si112_codreduzidorsp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_codreduzidorsp"])) {
      if (trim($this->si112_codreduzidorsp) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si112_codreduzidorsp"])) {
        $this->si112_codreduzidorsp = "0";
      }
      $sql .= $virgula . " si112_codreduzidorsp = $this->si112_codreduzidorsp ";
      $virgula = ",";
    }
    if (trim($this->si112_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_codorgao"])) {
      $sql .= $virgula . " si112_codorgao = '$this->si112_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si112_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_codunidadesub"])) {
      $sql .= $virgula . " si112_codunidadesub = '$this->si112_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si112_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_nroempenho"])) {
      if (trim($this->si112_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si112_nroempenho"])) {
        $this->si112_nroempenho = "0";
      }
      $sql .= $virgula . " si112_nroempenho = $this->si112_nroempenho ";
      $virgula = ",";
    }
    if (trim($this->si112_exercicioempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_exercicioempenho"])) {
      if (trim($this->si112_exercicioempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si112_exercicioempenho"])) {
        $this->si112_exercicioempenho = "0";
      }
      $sql .= $virgula . " si112_exercicioempenho = $this->si112_exercicioempenho ";
      $virgula = ",";
    }
    if (trim($this->si112_dtempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_dtempenho_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si112_dtempenho_dia"] != "")) {
      $sql .= $virgula . " si112_dtempenho = '$this->si112_dtempenho' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si112_dtempenho_dia"])) {
        $sql .= $virgula . " si112_dtempenho = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si112_dotorig) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_dotorig"])) {
      $sql .= $virgula . " si112_dotorig = '$this->si112_dotorig' ";
      $virgula = ",";
    }
    if (trim($this->si112_vloriginal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_vloriginal"])) {
      if (trim($this->si112_vloriginal) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si112_vloriginal"])) {
        $this->si112_vloriginal = "0";
      }
      $sql .= $virgula . " si112_vloriginal = $this->si112_vloriginal ";
      $virgula = ",";
    }
    if (trim($this->si112_vlsaldoantproce) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_vlsaldoantproce"])) {
      if (trim($this->si112_vlsaldoantproce) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si112_vlsaldoantproce"])) {
        $this->si112_vlsaldoantproce = "0";
      }
      $sql .= $virgula . " si112_vlsaldoantproce = $this->si112_vlsaldoantproce ";
      $virgula = ",";
    }
    if (trim($this->si112_vlsaldoantnaoproc) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_vlsaldoantnaoproc"])) {
      if (trim($this->si112_vlsaldoantnaoproc) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si112_vlsaldoantnaoproc"])) {
        $this->si112_vlsaldoantnaoproc = "0";
      }
      $sql .= $virgula . " si112_vlsaldoantnaoproc = $this->si112_vlsaldoantnaoproc ";
      $virgula = ",";
    }
    if (trim($this->si112_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_mes"])) {
      $sql .= $virgula . " si112_mes = $this->si112_mes ";
      $virgula = ",";
      if (trim($this->si112_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si112_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si112_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si112_instit"])) {
      $sql .= $virgula . " si112_instit = $this->si112_instit ";
      $virgula = ",";
      if (trim($this->si112_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si112_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si112_sequencial != null) {
      $sql .= " si112_sequencial = $this->si112_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si112_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010722,'$this->si112_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_sequencial"]) || $this->si112_sequencial != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010722,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_sequencial')) . "','$this->si112_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_tiporegistro"]) || $this->si112_tiporegistro != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010723,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_tiporegistro')) . "','$this->si112_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_codreduzidorsp"]) || $this->si112_codreduzidorsp != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010724,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_codreduzidorsp')) . "','$this->si112_codreduzidorsp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_codorgao"]) || $this->si112_codorgao != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010725,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_codorgao')) . "','$this->si112_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_codunidadesub"]) || $this->si112_codunidadesub != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010726,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_codunidadesub')) . "','$this->si112_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_nroempenho"]) || $this->si112_nroempenho != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010727,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_nroempenho')) . "','$this->si112_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_exercicioempenho"]) || $this->si112_exercicioempenho != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2011330,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_exercicioempenho')) . "','$this->si112_exercicioempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_dtempenho"]) || $this->si112_dtempenho != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010728,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_dtempenho')) . "','$this->si112_dtempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_dotorig"]) || $this->si112_dotorig != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010729,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_dotorig')) . "','$this->si112_dotorig'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_vloriginal"]) || $this->si112_vloriginal != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010730,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_vloriginal')) . "','$this->si112_vloriginal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_vlsaldoantproce"]) || $this->si112_vlsaldoantproce != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010731,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_vlsaldoantproce')) . "','$this->si112_vlsaldoantproce'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_vlsaldoantnaoproc"]) || $this->si112_vlsaldoantnaoproc != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010732,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_vlsaldoantnaoproc')) . "','$this->si112_vlsaldoantnaoproc'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_mes"]) || $this->si112_mes != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2010733,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_mes')) . "','$this->si112_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si112_instit"]) || $this->si112_instit != "") {
          $resac = db_query("insert into db_acount values($acount,2010341,2011625,'" . AddSlashes(pg_result($resaco, $conresaco, 'si112_instit')) . "','$this->si112_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "rsp102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si112_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "rsp102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si112_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si112_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si112_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si112_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010722,'$si112_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010341,2010722,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010723,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010724,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_codreduzidorsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010725,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010726,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010727,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2011330,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_exercicioempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010728,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010729,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_dotorig')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010730,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_vloriginal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010731,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_vlsaldoantproce')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010732,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_vlsaldoantnaoproc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2010733,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010341,2011625,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si112_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from rsp102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si112_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si112_sequencial = $si112_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "rsp102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si112_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "rsp102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si112_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si112_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao do recordset
  function sql_record($sql)
  {
    $result = db_query($sql);
    if ($result == false) {
      $this->numrows = 0;
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:rsp102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si112_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from rsp102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si112_sequencial != null) {
        $sql2 .= " where rsp102021.si112_sequencial = $si112_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }
    
    return $sql;
  }
  
  // funcao do sql
  function sql_query_file($si112_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from rsp102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si112_sequencial != null) {
        $sql2 .= " where rsp102021.si112_sequencial = $si112_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }
    
    return $sql;
  }
}

?>
