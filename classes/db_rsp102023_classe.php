<?
//MODULO: sicom
//CLASSE DA ENTIDADE rsp102023
class cl_rsp102023
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
  function cl_rsp102023()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rsp102023");
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
      $result = db_query("select nextval('rsp102023_si112_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: rsp102023_si112_sequencial_seq do campo: si112_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si112_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from rsp102023_si112_sequencial_seq");
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
    $sql = "insert into rsp102023(
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
        $this->erro_sql = "rsp102023 ($this->si112_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "rsp102023 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "rsp102023 ($this->si112_sequencial) nao Incluído. Inclusao Abortada.";
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
    $sql = " update rsp102023 set ";
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
      $this->erro_sql = "rsp102023 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si112_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "rsp102023 nao foi Alterado. Alteracao Executada.\n";
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
    $sql = " delete from rsp102023
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
      $this->erro_sql = "rsp102023 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si112_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "rsp102023 nao Encontrado. Exclusão não Efetuada.\n";
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
      $this->erro_sql = "Record Vazio na Tabela:rsp102023";
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
    $sql .= " from rsp102023 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si112_sequencial != null) {
        $sql2 .= " where rsp102023.si112_sequencial = $si112_sequencial ";
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
    $sql .= " from rsp102023 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si112_sequencial != null) {
        $sql2 .= " where rsp102023.si112_sequencial = $si112_sequencial ";
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

  public function sql_Reg10($ano, $instit)
  {
    $sql = "SELECT tiporegistro,
                  codreduzidorsp,
                  codorgao,
                  codunidadesub,
                  subunidade,
                  nroempenho,
                  exercicioempenho,
                  dtempenho,
                  dotorig,
                  vlremp AS vloriginal,
                  (vlremp - vlranu - vlrliq) AS vlsaldoantnaoproc,
                  (vlrliq - vlrpag) AS vlsaldoantproce,
                  codfontrecursos,
                  old_codfontrecursos,
                  new_codfontrecursos,
                  codco,
                  codidentificafr,
                  vlremp,
                  vlranu,
                  vlrliq,
                  vlrpag,
                  tipodoccredor,
                  documentocreddor,
                  e60_anousu,
                  pessoal,
                  dototigres
              FROM
              (SELECT '10' AS tiporegistro,
                      e60_numemp AS codreduzidorsp,
                      si09_codorgaotce AS codorgao,
                      lpad((CASE
                                WHEN o40_codtri = '0'
                                      OR NULL THEN o40_orgao::varchar
                                ELSE o40_codtri
                            END),2,0)||lpad((CASE
                                                  WHEN o41_codtri = '0'
                                                      OR NULL THEN o41_unidade::varchar
                                                  ELSE o41_codtri
                                              END),3,0) AS codunidadesub,
                      o41_subunidade AS subunidade,
                      e60_codemp AS nroempenho,
                      e60_anousu AS exercicioempenho,
                      e60_emiss AS dtempenho,
                      CASE
                          WHEN e60_anousu >= 2013 THEN ' '
                          ELSE lpad(o58_funcao,2,0)||lpad(o58_subfuncao,3,0)||lpad(o58_programa,4,0)||lpad(o58_projativ,4,0)|| substr(orcelemento.o56_elemento,2,6)||'00'
                      END AS dotorig,
                      sum(CASE
                              WHEN c71_coddoc IN
                                        (SELECT c53_coddoc
                                        FROM conhistdoc
                                        WHERE c53_tipo = 10) THEN round(c70_valor,2)
                              ELSE 0
                          END) AS vlremp,
                      sum(CASE
                              WHEN c71_coddoc IN
                                        (SELECT c53_coddoc
                                        FROM conhistdoc
                                        WHERE c53_tipo = 11) THEN round(c70_valor,2)
                              ELSE 0
                          END) AS vlranu,
                      sum(CASE
                              WHEN c71_coddoc IN
                                        (SELECT c53_coddoc
                                        FROM conhistdoc
                                        WHERE c53_tipo = 20) THEN round(c70_valor,2)
                              WHEN c71_coddoc IN
                                        (SELECT c53_coddoc
                                        FROM conhistdoc
                                        WHERE c53_tipo = 21) THEN round(c70_valor,2) *-1
                              WHEN c71_coddoc IN
                                        (SELECT c53_coddoc
                                        FROM conhistdoc
                                        WHERE c53_coddoc = 31) THEN round(c70_valor,2) *-1
                              ELSE 0
                          END) AS vlrliq,
                      sum(CASE
                              WHEN c71_coddoc IN
                                        (SELECT c53_coddoc
                                        FROM conhistdoc
                                        WHERE c53_tipo = 30) THEN round(c70_valor,2)
                              WHEN c71_coddoc IN
                                        (SELECT c53_coddoc
                                        FROM conhistdoc
                                        WHERE c53_tipo = 31) THEN round(c70_valor,2) *-1
                              ELSE 0
                          END) AS vlrpag,
                      CASE
                          WHEN o15_codtri::int4 IN (101, 201) THEN '1001'
                          WHEN o15_codtri::int4 IN (102, 202) THEN '1002'
                          WHEN o15_codtri::int4 IN (164, 264) THEN '3110'
                          WHEN o15_codtri::int4 IN (169, 269) THEN '3210'
                          WHEN o15_codtri::int4 IN (118, 166, 218, 266) THEN '1070'
                          ELSE '0000'
                      END AS codco,
                      o15_codtri::int4 AS codidentificafr,
                      o15_codtri AS codfontrecursos,
                      ano2022 AS old_codfontrecursos,
                      substr(ano2023, 1, 7) AS new_codfontrecursos,
                      CASE
                          WHEN length(z01_cgccpf) = 11 THEN 1
                          ELSE 2
                      END AS tipodoccredor,
                      z01_cgccpf AS documentocreddor,
                      e60_anousu,
                      substr(orcelemento.o56_elemento,2,6) AS pessoal,
                      lpad(o58_funcao,2,0)||lpad(o58_subfuncao,3,0)||lpad(o58_programa,4,0)||lpad(o58_projativ,4,0)||substr(orcelemento.o56_elemento,2,6)||substr(t1.o56_elemento, 8, 2) AS dototigres
                FROM empempenho
                INNER JOIN empresto ON e60_numemp = e91_numemp AND e91_anousu = {$ano}
                INNER JOIN conlancamemp ON e60_numemp = c75_numemp
                INNER JOIN empelemento ON e64_numemp = e60_numemp
                INNER JOIN cgm ON e60_numcgm = z01_numcgm
                INNER JOIN conlancamdoc ON c75_codlan = c71_codlan
                INNER JOIN conlancam ON c75_codlan = c70_codlan
                INNER JOIN orcdotacao ON (e60_coddot, e60_anousu) = (o58_coddot, o58_anousu)
                INNER JOIN orcelemento ON (o58_codele, o58_anousu) = (orcelemento.o56_codele, orcelemento.o56_anousu)
                INNER JOIN orcelemento t1 ON (t1.o56_anousu, t1.o56_codele) = (o58_anousu, e64_codele)
                JOIN orctiporec ON o58_codigo = o15_codigo
                JOIN db_config ON codigo = e60_instit
                LEFT JOIN infocomplementaresinstit ON codigo = si09_instit
                LEFT JOIN de_para_fontes ON o15_codtri::int4 = ano2022
                INNER JOIN orcunidade ON (o58_orgao, o58_unidade, o58_anousu) = (o41_orgao, o41_unidade, o41_anousu)
                JOIN orcorgao ON o40_orgao = o41_orgao AND o40_anousu = o41_anousu
                WHERE e60_anousu < {$ano}
                    AND e60_instit = {$instit}
                    AND c70_data <= '" . (db_getsession("DB_anousu") - 1) . "-12-31'
                GROUP BY e60_anousu, e60_codemp, e60_emiss, z01_numcgm, z01_cgccpf, z01_nome, e60_numemp, o58_codigo, o58_orgao, o58_unidade, o41_subunidade, o58_funcao, o58_subfuncao, o58_programa, o58_projativ,
                        orcelemento.o56_elemento, t1.o56_elemento, o15_codtri, si09_codorgaotce, o40_codtri, orcorgao.o40_orgao, orcunidade.o41_codtri, orcunidade.o41_unidade, de_para_fontes.ano2022, de_para_fontes.ano2023) AS restos
              WHERE (vlremp - vlranu - vlrliq) > 0
              OR (vlrliq - vlrpag) > 0";

    return $sql;
  }

  public function sql_DeParaFontes()
  {
    $sSql = "DROP TABLE IF EXISTS de_para_fontes;";
    
    $sSql .="CREATE TEMP TABLE de_para_fontes
             (
                 ano2022 int4,
                 ano2023 int4
             );
             
             INSERT INTO de_para_fontes VALUES
             (100, 15000000), (101, 15000001), (102, 15000002), (103, 18000000), (104, 18010000), (105, 18020000), (106, 15760010), (107, 15440000), (108, 17080000), (112, 16590020), (113, 15990030), (116, 17500000), (117, 17510000),
             (118, 15400007), (119, 15400000), (120, 15760000), (121, 16220000), (122, 15700000), (123, 16310000), (124, 17000000), (129, 16600000), (130, 18990040), (131, 17590050), (132, 16040000), (133, 17150000), (134, 17160000),
             (135, 17170000), (136, 17180000), (142, 16650000), (143, 15510000), (144, 15520000), (145, 15530000), (146, 15690000), (147, 15500000), (153, 16010000), (154, 16590000), (155, 16210000), (156, 16610000), (157, 17520000),
             (158, 18990060), (159, 16000000), (160, 17040000), (161, 17070000), (162, 17490120), (163, 17130070), (164, 17060000), (165, 17490000), (166, 15420007), (167, 15420000), (168, 17100100), (169, 17100000), (170, 15010000),
             (171, 15710000), (172, 15720000), (173, 15750000), (174, 15740000), (175, 15730000), (176, 16320000), (177, 16330000), (178, 16360000), (179, 16340000), (180, 16350000), (181, 17010000), (182, 17020000), (183, 17030000),
             (184, 17090000), (185, 17530000), (186, 17040000), (187, 17050000), (188, 15000000), (189, 15000000), (190, 17540000), (191, 17540000), (192, 17550000), (193, 18990000),
             (200, 25000000), (201, 25000001), (202, 25000002), (203, 28000000), (204, 28010000), (205, 28020000), (206, 25760010), (207, 25440000), (208, 27080000), (212, 26590020), (213, 25990030), (216, 27500000), (217, 27510000),
             (218, 25400007), (219, 25400000), (220, 25760000), (221, 26220000), (222, 25700000), (223, 26310000), (224, 27000000), (229, 26600000), (230, 28990040), (231, 27590050), (232, 26040000), (233, 27150000), (234, 27160000),
             (235, 27170000), (236, 27180000), (242, 26650000), (243, 25510000), (244, 25520000), (245, 25530000), (246, 25690000), (247, 25500000), (253, 26010000), (254, 26590000), (255, 26210000), (256, 26610000), (257, 27520000),
             (258, 28990060), (259, 26000000), (260, 27040000), (261, 27070000), (262, 27490120), (263, 27130070), (264, 27060000), (265, 27490000), (266, 25420007), (267, 25420000), (268, 27100100), (269, 27100000), (270, 25010000),
             (271, 25710000), (272, 25720000), (273, 25750000), (274, 25740000), (275, 25730000), (276, 26320000), (277, 26330000), (278, 26360000), (279, 26340000), (280, 26350000), (281, 27010000), (282, 27020000), (283, 27030000),
             (284, 27090000), (285, 27530000), (286, 27040000), (287, 27050000), (288, 25000000), (289, 25000000), (290, 27540000), (291, 27540000), (292, 27550000), (293, 28990000)";

    db_query($sSql);
  }
}

?>
