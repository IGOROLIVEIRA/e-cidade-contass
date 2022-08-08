<?
//MODULO: sicom
//CLASSE DA ENTIDADE conv102021
class cl_conv102021
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
  var $si92_sequencial = 0;
  var $si92_tiporegistro = 0;
  var $si92_codconvenio = 0;
  var $si92_codorgao = null;
  var $si92_nroconvenio = null;
  var $si92_dataassinatura_dia = null;
  var $si92_dataassinatura_mes = null;
  var $si92_dataassinatura_ano = null;
  var $si92_dataassinatura = null;
  var $si92_objetoconvenio = null;
  var $si92_datainiciovigencia_dia = null;
  var $si92_datainiciovigencia_mes = null;
  var $si92_datainiciovigencia_ano = null;
  var $si92_datainiciovigencia = null;
  var $si92_datafinalvigencia_dia = null;
  var $si92_datafinalvigencia_mes = null;
  var $si92_datafinalvigencia_ano = null;
  var $si92_datafinalvigencia = null;
  var $si92_vlconvenio = 0;
  var $si92_vlcontrapartida = 0;
  var $si92_codfontrecursos = 0;
  var $si92_mes = 0;
  var $si92_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si92_sequencial = int8 = sequencial
                 si92_tiporegistro = int8 = Tipo do  registro
                 si92_codconvenio = int8 = Código do  Convênio
                 si92_codorgao = varchar(2) = Código do órgão
                 si92_nroconvenio = varchar(30) = Número do  Convênio
                 si92_dataassinatura = date = Data da assinatura  do Convênio
                 si92_objetoconvenio = varchar(500) = Objeto do convênio
                 si92_datainiciovigencia = date = Data inicial da  vigência do  convênio
                 si92_datafinalvigencia = date = Data final da  vigência do  convênio
                 si92_vlconvenio = float8 = Valor do convênio
                 si92_vlcontrapartida = float8 = Valor da  contrapartida
                 si92_codfontrecursos = int8 = Tipo de Recurso
                 si92_mes = int8 = Mês
                 si92_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_conv102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("conv102021");
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
      $this->si92_sequencial = ($this->si92_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_sequencial"] : $this->si92_sequencial);
      $this->si92_tiporegistro = ($this->si92_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_tiporegistro"] : $this->si92_tiporegistro);
      $this->si92_codconvenio = ($this->si92_codconvenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_codconvenio"] : $this->si92_codconvenio);
      $this->si92_codorgao = ($this->si92_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_codorgao"] : $this->si92_codorgao);
      $this->si92_nroconvenio = ($this->si92_nroconvenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_nroconvenio"] : $this->si92_nroconvenio);
      if ($this->si92_dataassinatura == "") {
        $this->si92_dataassinatura_dia = ($this->si92_dataassinatura_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_dataassinatura_dia"] : $this->si92_dataassinatura_dia);
        $this->si92_dataassinatura_mes = ($this->si92_dataassinatura_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_dataassinatura_mes"] : $this->si92_dataassinatura_mes);
        $this->si92_dataassinatura_ano = ($this->si92_dataassinatura_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_dataassinatura_ano"] : $this->si92_dataassinatura_ano);
        if ($this->si92_dataassinatura_dia != "") {
          $this->si92_dataassinatura = $this->si92_dataassinatura_ano . "-" . $this->si92_dataassinatura_mes . "-" . $this->si92_dataassinatura_dia;
        }
      }
      $this->si92_objetoconvenio = ($this->si92_objetoconvenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_objetoconvenio"] : $this->si92_objetoconvenio);
      if ($this->si92_datainiciovigencia == "") {
        $this->si92_datainiciovigencia_dia = ($this->si92_datainiciovigencia_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_datainiciovigencia_dia"] : $this->si92_datainiciovigencia_dia);
        $this->si92_datainiciovigencia_mes = ($this->si92_datainiciovigencia_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_datainiciovigencia_mes"] : $this->si92_datainiciovigencia_mes);
        $this->si92_datainiciovigencia_ano = ($this->si92_datainiciovigencia_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_datainiciovigencia_ano"] : $this->si92_datainiciovigencia_ano);
        if ($this->si92_datainiciovigencia_dia != "") {
          $this->si92_datainiciovigencia = $this->si92_datainiciovigencia_ano . "-" . $this->si92_datainiciovigencia_mes . "-" . $this->si92_datainiciovigencia_dia;
        }
      }
      if ($this->si92_datafinalvigencia == "") {
        $this->si92_datafinalvigencia_dia = ($this->si92_datafinalvigencia_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_datafinalvigencia_dia"] : $this->si92_datafinalvigencia_dia);
        $this->si92_datafinalvigencia_mes = ($this->si92_datafinalvigencia_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_datafinalvigencia_mes"] : $this->si92_datafinalvigencia_mes);
        $this->si92_datafinalvigencia_ano = ($this->si92_datafinalvigencia_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_datafinalvigencia_ano"] : $this->si92_datafinalvigencia_ano);
        if ($this->si92_datafinalvigencia_dia != "") {
          $this->si92_datafinalvigencia = $this->si92_datafinalvigencia_ano . "-" . $this->si92_datafinalvigencia_mes . "-" . $this->si92_datafinalvigencia_dia;
        }
      }
      $this->si92_codfontrecursos = ($this->si92_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_codfontrecursos"] : $this->si92_codfontrecursos);
      $this->si92_vlconvenio = ($this->si92_vlconvenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_vlconvenio"] : $this->si92_vlconvenio);
      $this->si92_vlcontrapartida = ($this->si92_vlcontrapartida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_vlcontrapartida"] : $this->si92_vlcontrapartida);
      $this->si92_mes = ($this->si92_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_mes"] : $this->si92_mes);
      $this->si92_instit = ($this->si92_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_instit"] : $this->si92_instit);
    } else {
      $this->si92_sequencial = ($this->si92_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si92_sequencial"] : $this->si92_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si92_sequencial)
  {
    $this->atualizacampos();
    if ($this->si92_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si92_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si92_codconvenio == null) {
      $this->si92_codconvenio = "0";
    }
    if ($this->si92_dataassinatura == null) {
      $this->si92_dataassinatura = "null";
    }
    if ($this->si92_datainiciovigencia == null) {
      $this->si92_datainiciovigencia = "null";
    }
    if ($this->si92_datafinalvigencia == null) {
      $this->si92_datafinalvigencia = "null";
    }
    if ($this->si92_vlconvenio == null) {
      $this->si92_vlconvenio = "0";
    }
    if ($this->si92_vlcontrapartida == null) {
      $this->si92_vlcontrapartida = "0";
    }
    if ($this->si92_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si92_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si92_codfontrecursos == null) {
      $this->erro_sql = " Código da fonte de Recurso não informado.";
      $this->erro_campo = "si92_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si92_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si92_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si92_sequencial == "" || $si92_sequencial == null) {
      $result = db_query("select nextval('conv102021_si92_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: conv102021_si92_sequencial_seq do campo: si92_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si92_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from conv102021_si92_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si92_sequencial)) {
        $this->erro_sql = " Campo si92_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si92_sequencial = $si92_sequencial;
      }
    }
    if (($this->si92_sequencial == null) || ($this->si92_sequencial == "")) {
      $this->erro_sql = " Campo si92_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into conv102021(
                                       si92_sequencial
                                      ,si92_tiporegistro
                                      ,si92_codconvenio
                                      ,si92_codorgao
                                      ,si92_nroconvenio
                                      ,si92_dataassinatura
                                      ,si92_objetoconvenio
                                      ,si92_datainiciovigencia
                                      ,si92_datafinalvigencia
                                      ,si92_vlconvenio
                                      ,si92_vlcontrapartida
                                      ,si92_mes
                                      ,si92_instit
                                      ,si92_codfontrecursos
                       )
                values (
                                $this->si92_sequencial
                               ,$this->si92_tiporegistro
                               ,$this->si92_codconvenio
                               ,'$this->si92_codorgao'
                               ,'$this->si92_nroconvenio'
                               ," . ($this->si92_dataassinatura == "null" || $this->si92_dataassinatura == "" ? "null" : "'" . $this->si92_dataassinatura . "'") . "
                               ,'$this->si92_objetoconvenio'
                               ," . ($this->si92_datainiciovigencia == "null" || $this->si92_datainiciovigencia == "" ? "null" : "'" . $this->si92_datainiciovigencia . "'") . "
                               ," . ($this->si92_datafinalvigencia == "null" || $this->si92_datafinalvigencia == "" ? "null" : "'" . $this->si92_datafinalvigencia . "'") . "
                               ,$this->si92_vlconvenio
                               ,$this->si92_vlcontrapartida
                               ,$this->si92_mes
                               ,$this->si92_instit
                               ,$this->si92_codfontrecursos
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "conv102021 ($this->si92_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "conv102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "conv102021 ($this->si92_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si92_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si92_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010512,'$this->si92_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010320,2010512,'','" . AddSlashes(pg_result($resaco, 0, 'si92_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010513,'','" . AddSlashes(pg_result($resaco, 0, 'si92_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010514,'','" . AddSlashes(pg_result($resaco, 0, 'si92_codconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010515,'','" . AddSlashes(pg_result($resaco, 0, 'si92_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010516,'','" . AddSlashes(pg_result($resaco, 0, 'si92_nroconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010517,'','" . AddSlashes(pg_result($resaco, 0, 'si92_dataassinatura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010518,'','" . AddSlashes(pg_result($resaco, 0, 'si92_objetoconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010519,'','" . AddSlashes(pg_result($resaco, 0, 'si92_datainiciovigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010520,'','" . AddSlashes(pg_result($resaco, 0, 'si92_datafinalvigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010521,'','" . AddSlashes(pg_result($resaco, 0, 'si92_vlconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010522,'','" . AddSlashes(pg_result($resaco, 0, 'si92_vlcontrapartida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2010523,'','" . AddSlashes(pg_result($resaco, 0, 'si92_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010320,2011604,'','" . AddSlashes(pg_result($resaco, 0, 'si92_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si92_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update conv102021 set ";
    $virgula = "";
    if (trim($this->si92_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_sequencial"])) {
      if (trim($this->si92_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si92_sequencial"])) {
        $this->si92_sequencial = "0";
      }
      $sql .= $virgula . " si92_sequencial = $this->si92_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si92_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_tiporegistro"])) {
      $sql .= $virgula . " si92_tiporegistro = $this->si92_tiporegistro ";
      $virgula = ",";
      if (trim($this->si92_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si92_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si92_codconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_codconvenio"])) {
      if (trim($this->si92_codconvenio) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si92_codconvenio"])) {
        $this->si92_codconvenio = "0";
      }
      $sql .= $virgula . " si92_codconvenio = $this->si92_codconvenio ";
      $virgula = ",";
    }
    if (trim($this->si92_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_codfontrecursos"])) {
      if (trim($this->si92_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si92_codfontrecursos"])) {
        $this->si92_codfontrecursos = "0";
      }
      $sql .= $virgula . " si92_codfontrecursos = $this->si92_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si92_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_codorgao"])) {
      $sql .= $virgula . " si92_codorgao = '$this->si92_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si92_nroconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_nroconvenio"])) {
      $sql .= $virgula . " si92_nroconvenio = '$this->si92_nroconvenio' ";
      $virgula = ",";
    }
    if (trim($this->si92_dataassinatura) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_dataassinatura_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si92_dataassinatura_dia"] != "")) {
      $sql .= $virgula . " si92_dataassinatura = '$this->si92_dataassinatura' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si92_dataassinatura_dia"])) {
        $sql .= $virgula . " si92_dataassinatura = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si92_objetoconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_objetoconvenio"])) {
      $sql .= $virgula . " si92_objetoconvenio = '$this->si92_objetoconvenio' ";
      $virgula = ",";
    }
    if (trim($this->si92_datainiciovigencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_datainiciovigencia_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si92_datainiciovigencia_dia"] != "")) {
      $sql .= $virgula . " si92_datainiciovigencia = '$this->si92_datainiciovigencia' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si92_datainiciovigencia_dia"])) {
        $sql .= $virgula . " si92_datainiciovigencia = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si92_datafinalvigencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_datafinalvigencia_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si92_datafinalvigencia_dia"] != "")) {
      $sql .= $virgula . " si92_datafinalvigencia = '$this->si92_datafinalvigencia' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si92_datafinalvigencia_dia"])) {
        $sql .= $virgula . " si92_datafinalvigencia = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si92_vlconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_vlconvenio"])) {
      if (trim($this->si92_vlconvenio) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si92_vlconvenio"])) {
        $this->si92_vlconvenio = "0";
      }
      $sql .= $virgula . " si92_vlconvenio = $this->si92_vlconvenio ";
      $virgula = ",";
    }
    if (trim($this->si92_vlcontrapartida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_vlcontrapartida"])) {
      if (trim($this->si92_vlcontrapartida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si92_vlcontrapartida"])) {
        $this->si92_vlcontrapartida = "0";
      }
      $sql .= $virgula . " si92_vlcontrapartida = $this->si92_vlcontrapartida ";
      $virgula = ",";
    }
    if (trim($this->si92_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_mes"])) {
      $sql .= $virgula . " si92_mes = $this->si92_mes ";
      $virgula = ",";
      if (trim($this->si92_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si92_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si92_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si92_instit"])) {
      $sql .= $virgula . " si92_instit = $this->si92_instit ";
      $virgula = ",";
      if (trim($this->si92_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si92_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si92_sequencial != null) {
      $sql .= " si92_sequencial = $this->si92_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si92_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010512,'$this->si92_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_sequencial"]) || $this->si92_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010512,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_sequencial')) . "','$this->si92_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_tiporegistro"]) || $this->si92_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010513,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_tiporegistro')) . "','$this->si92_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_codconvenio"]) || $this->si92_codconvenio != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010514,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_codconvenio')) . "','$this->si92_codconvenio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_codorgao"]) || $this->si92_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010515,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_codorgao')) . "','$this->si92_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_nroconvenio"]) || $this->si92_nroconvenio != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010516,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_nroconvenio')) . "','$this->si92_nroconvenio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_dataassinatura"]) || $this->si92_dataassinatura != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010517,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_dataassinatura')) . "','$this->si92_dataassinatura'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_objetoconvenio"]) || $this->si92_objetoconvenio != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010518,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_objetoconvenio')) . "','$this->si92_objetoconvenio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_datainiciovigencia"]) || $this->si92_datainiciovigencia != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010519,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_datainiciovigencia')) . "','$this->si92_datainiciovigencia'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_datafinalvigencia"]) || $this->si92_datafinalvigencia != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010520,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_datafinalvigencia')) . "','$this->si92_datafinalvigencia'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_vlconvenio"]) || $this->si92_vlconvenio != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010521,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_vlconvenio')) . "','$this->si92_vlconvenio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_vlcontrapartida"]) || $this->si92_vlcontrapartida != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010522,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_vlcontrapartida')) . "','$this->si92_vlcontrapartida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_mes"]) || $this->si92_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2010523,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_mes')) . "','$this->si92_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si92_instit"]) || $this->si92_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010320,2011604,'" . AddSlashes(pg_result($resaco, $conresaco, 'si92_instit')) . "','$this->si92_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "conv102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si92_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "conv102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si92_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si92_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si92_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si92_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010512,'$si92_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010320,2010512,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010513,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010514,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_codconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010515,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010516,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_nroconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010517,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_dataassinatura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010518,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_objetoconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010519,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_datainiciovigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010520,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_datafinalvigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010521,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_vlconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010522,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_vlcontrapartida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2010523,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010320,2011604,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si92_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from conv102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si92_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si92_sequencial = $si92_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "conv102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si92_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "conv102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si92_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si92_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:conv102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si92_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from conv102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si92_sequencial != null) {
        $sql2 .= " where conv102021.si92_sequencial = $si92_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }

  // funcao do sql
  function sql_query_file($si92_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from conv102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si92_sequencial != null) {
        $sql2 .= " where conv102021.si92_sequencial = $si92_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
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
