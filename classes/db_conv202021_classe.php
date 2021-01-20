<?
//MODULO: sicom
//CLASSE DA ENTIDADE conv202021
class cl_conv202021
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
  var $si94_sequencial = 0;
  var $si94_tiporegistro = 0;
  var $si94_codorgao = null;
  var $si94_nroconvenio = null;
  var $si94_dtassinaturaconvoriginal_dia = null;
  var $si94_dtassinaturaconvoriginal_mes = null;
  var $si94_dtassinaturaconvoriginal_ano = null;
  var $si94_dtassinaturaconvoriginal = null;
  var $si94_nroseqtermoaditivo = null;
  var $si94_codconvaditivo = null;
  var $si94_dscalteracao = null;
  var $si94_dtassinaturatermoaditivo_dia = null;
  var $si94_dtassinaturatermoaditivo_mes = null;
  var $si94_dtassinaturatermoaditivo_ano = null;
  var $si94_dtassinaturatermoaditivo = null;
  var $si94_datafinalvigencia_dia = null;
  var $si94_datafinalvigencia_mes = null;
  var $si94_datafinalvigencia_ano = null;
  var $si94_datafinalvigencia = null;
  var $si94_valoratualizadoconvenio = 0;
  var $si94_valoratualizadocontrapartida = 0;
  var $si94_mes = 0;
  var $si94_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si94_sequencial = int8 = sequencial
                 si94_tiporegistro = int8 = Tipo do  registro
                 si94_codorgao = varchar(2) = Código do órgão
                 si94_nroconvenio = varchar(30) = Número do  Convênio Original
                 si94_dtassinaturaconvoriginal = date = Data da assinatura  do Convênio
                 si94_nroseqtermoaditivo = varchar(2) = Número sequencial do Termo Aditivo
                 si94_codconvaditivo = varchar(20) = Código Convênio Aditivo
                 si94_dscalteracao = varchar(500) = Descrição da  alteração
                 si94_dtassinaturatermoaditivo = date = Data da assinatura  do Termo Aditivo
                 si94_datafinalvigencia = date = Data final da  vigência do  convênio
                 si94_valoratualizadoconvenio = float8 = Valor atualizado do  Convênio
                 si94_valoratualizadocontrapartida = float8 = Valor atualizado da  Contrapartida
                 si94_mes = int8 = Mês
                 si94_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_conv202021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("conv202021");
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
      $this->si94_sequencial = ($this->si94_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_sequencial"] : $this->si94_sequencial);
      $this->si94_tiporegistro = ($this->si94_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_tiporegistro"] : $this->si94_tiporegistro);
      $this->si94_codorgao = ($this->si94_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_codorgao"] : $this->si94_codorgao);
      $this->si94_nroconvenio = ($this->si94_nroconvenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_nroconvenio"] : $this->si94_nroconvenio);
      if ($this->si94_dtassinaturaconvoriginal == "") {
        $this->si94_dtassinaturaconvoriginal_dia = ($this->si94_dtassinaturaconvoriginal_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturaconvoriginal_dia"] : $this->si94_dtassinaturaconvoriginal_dia);
        $this->si94_dtassinaturaconvoriginal_mes = ($this->si94_dtassinaturaconvoriginal_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturaconvoriginal_mes"] : $this->si94_dtassinaturaconvoriginal_mes);
        $this->si94_dtassinaturaconvoriginal_ano = ($this->si94_dtassinaturaconvoriginal_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturaconvoriginal_ano"] : $this->si94_dtassinaturaconvoriginal_ano);
        if ($this->si94_dtassinaturaconvoriginal_dia != "") {
          $this->si94_dtassinaturaconvoriginal = $this->si94_dtassinaturaconvoriginal_ano . "-" . $this->si94_dtassinaturaconvoriginal_mes . "-" . $this->si94_dtassinaturaconvoriginal_dia;
        }
      }
      $this->si94_nroseqtermoaditivo = ($this->si94_nroseqtermoaditivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_nroseqtermoaditivo"] : $this->si94_nroseqtermoaditivo);
      $this->si94_codconvaditivo = ($this->si94_codconvaditivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_codconvaditivo"] : $this->si94_codconvaditivo);
      $this->si94_dscalteracao = ($this->si94_dscalteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_dscalteracao"] : $this->si94_dscalteracao);
      if ($this->si94_dtassinaturatermoaditivo == "") {
        $this->si94_dtassinaturatermoaditivo_dia = ($this->si94_dtassinaturatermoaditivo_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturatermoaditivo_dia"] : $this->si94_dtassinaturatermoaditivo_dia);
        $this->si94_dtassinaturatermoaditivo_mes = ($this->si94_dtassinaturatermoaditivo_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturatermoaditivo_mes"] : $this->si94_dtassinaturatermoaditivo_mes);
        $this->si94_dtassinaturatermoaditivo_ano = ($this->si94_dtassinaturatermoaditivo_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturatermoaditivo_ano"] : $this->si94_dtassinaturatermoaditivo_ano);
        if ($this->si94_dtassinaturatermoaditivo_dia != "") {
          $this->si94_dtassinaturatermoaditivo = $this->si94_dtassinaturatermoaditivo_ano . "-" . $this->si94_dtassinaturatermoaditivo_mes . "-" . $this->si94_dtassinaturatermoaditivo_dia;
        }
      }
      if ($this->si94_datafinalvigencia == "") {
        $this->si94_datafinalvigencia_dia = ($this->si94_datafinalvigencia_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_datafinalvigencia_dia"] : $this->si94_datafinalvigencia_dia);
        $this->si94_datafinalvigencia_mes = ($this->si94_datafinalvigencia_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_datafinalvigencia_mes"] : $this->si94_datafinalvigencia_mes);
        $this->si94_datafinalvigencia_ano = ($this->si94_datafinalvigencia_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_datafinalvigencia_ano"] : $this->si94_datafinalvigencia_ano);
        if ($this->si94_datafinalvigencia_dia != "") {
          $this->si94_datafinalvigencia = $this->si94_datafinalvigencia_ano . "-" . $this->si94_datafinalvigencia_mes . "-" . $this->si94_datafinalvigencia_dia;
        }
      }
      $this->si94_valoratualizadoconvenio = ($this->si94_valoratualizadoconvenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_valoratualizadoconvenio"] : $this->si94_valoratualizadoconvenio);
      $this->si94_valoratualizadocontrapartida = ($this->si94_valoratualizadocontrapartida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_valoratualizadocontrapartida"] : $this->si94_valoratualizadocontrapartida);
      $this->si94_mes = ($this->si94_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_mes"] : $this->si94_mes);
      $this->si94_instit = ($this->si94_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_instit"] : $this->si94_instit);
    } else {
      $this->si94_sequencial = ($this->si94_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si94_sequencial"] : $this->si94_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si94_sequencial)
  {
    $this->atualizacampos();
    if ($this->si94_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si94_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si94_dtassinaturaconvoriginal == null) {
      $this->si94_dtassinaturaconvoriginal = "null";
    }
    if ($this->si94_dtassinaturatermoaditivo == null) {
      $this->si94_dtassinaturatermoaditivo = "null";
    }
    if ($this->si94_datafinalvigencia == null) {
      $this->si94_datafinalvigencia = "null";
    }
    if ($this->si94_valoratualizadoconvenio == null) {
      $this->si94_valoratualizadoconvenio = "0";
    }
    if ($this->si94_valoratualizadocontrapartida == null) {
      $this->si94_valoratualizadocontrapartida = "0";
    }
    if ($this->si94_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si94_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si94_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si94_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si94_sequencial == "" || $si94_sequencial == null) {
      $result = db_query("select nextval('conv202021_si94_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: conv202021_si94_sequencial_seq do campo: si94_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si94_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from conv202021_si94_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si94_sequencial)) {
        $this->erro_sql = " Campo si94_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si94_sequencial = $si94_sequencial;
      }
    }
    if (($this->si94_sequencial == null) || ($this->si94_sequencial == "")) {
      $this->erro_sql = " Campo si94_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into conv202021(
                                       si94_sequencial
                                      ,si94_tiporegistro
                                      ,si94_codorgao
                                      ,si94_nroconvenio
                                      ,si94_dtassinaturaconvoriginal
                                      ,si94_nroseqtermoaditivo
                                      ,si94_codconvaditivo
                                      ,si94_dscalteracao
                                      ,si94_dtassinaturatermoaditivo
                                      ,si94_datafinalvigencia
                                      ,si94_valoratualizadoconvenio
                                      ,si94_valoratualizadocontrapartida
                                      ,si94_mes
                                      ,si94_instit
                       )
                values (
                                $this->si94_sequencial
                               ,$this->si94_tiporegistro
                               ,'$this->si94_codorgao'
                               ,'$this->si94_nroconvenio'
                               ," . ($this->si94_dtassinaturaconvoriginal == "null" || $this->si94_dtassinaturaconvoriginal == "" ? "null" : "'" . $this->si94_dtassinaturaconvoriginal . "'") . "
                               ,'$this->si94_nroseqtermoaditivo'
                               ,'$this->si94_codconvaditivo'
                               ,'$this->si94_dscalteracao'
                               ," . ($this->si94_dtassinaturatermoaditivo == "null" || $this->si94_dtassinaturatermoaditivo == "" ? "null" : "'" . $this->si94_dtassinaturatermoaditivo . "'") . "
                               ," . ($this->si94_datafinalvigencia == "null" || $this->si94_datafinalvigencia == "" ? "null" : "'" . $this->si94_datafinalvigencia . "'") . "
                               ,$this->si94_valoratualizadoconvenio
                               ,$this->si94_valoratualizadocontrapartida
                               ,$this->si94_mes
                               ,$this->si94_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "conv202021 ($this->si94_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "conv202021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "conv202021 ($this->si94_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si94_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
//    $resaco = $this->sql_record($this->sql_query_file($this->si94_sequencial));
//    if (($resaco != false) || ($this->numrows != 0)) {
//      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//      $acount = pg_result($resac, 0, 0);
//      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//      $resac = db_query("insert into db_acountkey values($acount,2010533,'$this->si94_sequencial','I')");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010533,'','" . AddSlashes(pg_result($resaco, 0, 'si94_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010534,'','" . AddSlashes(pg_result($resaco, 0, 'si94_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010535,'','" . AddSlashes(pg_result($resaco, 0, 'si94_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010536,'','" . AddSlashes(pg_result($resaco, 0, 'si94_nroconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010537,'','" . AddSlashes(pg_result($resaco, 0, 'si94_dtassinaturaconvoriginal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010538,'','" . AddSlashes(pg_result($resaco, 0, 'si94_nroseqtermoaditivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010539,'','" . AddSlashes(pg_result($resaco, 0, 'si94_dscalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010540,'','" . AddSlashes(pg_result($resaco, 0, 'si94_dtassinaturatermoaditivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010541,'','" . AddSlashes(pg_result($resaco, 0, 'si94_datafinalvigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010542,'','" . AddSlashes(pg_result($resaco, 0, 'si94_valoratualizadoconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010543,'','" . AddSlashes(pg_result($resaco, 0, 'si94_valoratualizadocontrapartida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010544,'','" . AddSlashes(pg_result($resaco, 0, 'si94_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2011606,'','" . AddSlashes(pg_result($resaco, 0, 'si94_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//    }

    return true;
  }

  // funcao para alteracao
  function alterar($si94_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update conv202021 set ";
    $virgula = "";
    if (trim($this->si94_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_sequencial"])) {
      if (trim($this->si94_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si94_sequencial"])) {
        $this->si94_sequencial = "0";
      }
      $sql .= $virgula . " si94_sequencial = $this->si94_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si94_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_tiporegistro"])) {
      $sql .= $virgula . " si94_tiporegistro = $this->si94_tiporegistro ";
      $virgula = ",";
      if (trim($this->si94_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si94_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si94_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_codorgao"])) {
      $sql .= $virgula . " si94_codorgao = '$this->si94_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si94_nroconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_nroconvenio"])) {
      $sql .= $virgula . " si94_nroconvenio = '$this->si94_nroconvenio' ";
      $virgula = ",";
    }
    if (trim($this->si94_dtassinaturaconvoriginal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturaconvoriginal_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturaconvoriginal_dia"] != "")) {
      $sql .= $virgula . " si94_dtassinaturaconvoriginal = '$this->si94_dtassinaturaconvoriginal' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturaconvoriginal_dia"])) {
        $sql .= $virgula . " si94_dtassinaturaconvoriginal = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si94_nroseqtermoaditivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_nroseqtermoaditivo"])) {
      $sql .= $virgula . " si94_nroseqtermoaditivo = '$this->si94_nroseqtermoaditivo' ";
      $virgula = ",";
    }
    if (trim($this->si94_dscalteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_dscalteracao"])) {
      $sql .= $virgula . " si94_dscalteracao = '$this->si94_dscalteracao' ";
      $virgula = ",";
    }
    if (trim($this->si94_dtassinaturatermoaditivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturatermoaditivo_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturatermoaditivo_dia"] != "")) {
      $sql .= $virgula . " si94_dtassinaturatermoaditivo = '$this->si94_dtassinaturatermoaditivo' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturatermoaditivo_dia"])) {
        $sql .= $virgula . " si94_dtassinaturatermoaditivo = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si94_datafinalvigencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_datafinalvigencia_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si94_datafinalvigencia_dia"] != "")) {
      $sql .= $virgula . " si94_datafinalvigencia = '$this->si94_datafinalvigencia' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si94_datafinalvigencia_dia"])) {
        $sql .= $virgula . " si94_datafinalvigencia = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si94_valoratualizadoconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_valoratualizadoconvenio"])) {
      if (trim($this->si94_valoratualizadoconvenio) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si94_valoratualizadoconvenio"])) {
        $this->si94_valoratualizadoconvenio = "0";
      }
      $sql .= $virgula . " si94_valoratualizadoconvenio = $this->si94_valoratualizadoconvenio ";
      $virgula = ",";
    }
    if (trim($this->si94_valoratualizadocontrapartida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_valoratualizadocontrapartida"])) {
      if (trim($this->si94_valoratualizadocontrapartida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si94_valoratualizadocontrapartida"])) {
        $this->si94_valoratualizadocontrapartida = "0";
      }
      $sql .= $virgula . " si94_valoratualizadocontrapartida = $this->si94_valoratualizadocontrapartida ";
      $virgula = ",";
    }
    if (trim($this->si94_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_mes"])) {
      $sql .= $virgula . " si94_mes = $this->si94_mes ";
      $virgula = ",";
      if (trim($this->si94_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si94_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si94_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si94_instit"])) {
      $sql .= $virgula . " si94_instit = $this->si94_instit ";
      $virgula = ",";
      if (trim($this->si94_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si94_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si94_sequencial != null) {
      $sql .= " si94_sequencial = $this->si94_sequencial";
    }
//    $resaco = $this->sql_record($this->sql_query_file($this->si94_sequencial));
//    if ($this->numrows > 0) {
//      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2010533,'$this->si94_sequencial','A')");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_sequencial"]) || $this->si94_sequencial != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010533,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_sequencial')) . "','$this->si94_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_tiporegistro"]) || $this->si94_tiporegistro != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010534,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_tiporegistro')) . "','$this->si94_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_codorgao"]) || $this->si94_codorgao != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010535,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_codorgao')) . "','$this->si94_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_nroconvenio"]) || $this->si94_nroconvenio != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010536,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_nroconvenio')) . "','$this->si94_nroconvenio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturaconvoriginal"]) || $this->si94_dtassinaturaconvoriginal != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010537,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_dtassinaturaconvoriginal')) . "','$this->si94_dtassinaturaconvoriginal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_nroseqtermoaditivo"]) || $this->si94_nroseqtermoaditivo != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010538,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_nroseqtermoaditivo')) . "','$this->si94_nroseqtermoaditivo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_dscalteracao"]) || $this->si94_dscalteracao != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010539,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_dscalteracao')) . "','$this->si94_dscalteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_dtassinaturatermoaditivo"]) || $this->si94_dtassinaturatermoaditivo != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010540,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_dtassinaturatermoaditivo')) . "','$this->si94_dtassinaturatermoaditivo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_datafinalvigencia"]) || $this->si94_datafinalvigencia != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010541,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_datafinalvigencia')) . "','$this->si94_datafinalvigencia'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_valoratualizadoconvenio"]) || $this->si94_valoratualizadoconvenio != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010542,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_valoratualizadoconvenio')) . "','$this->si94_valoratualizadoconvenio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_valoratualizadocontrapartida"]) || $this->si94_valoratualizadocontrapartida != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010543,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_valoratualizadocontrapartida')) . "','$this->si94_valoratualizadocontrapartida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_mes"]) || $this->si94_mes != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010544,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_mes')) . "','$this->si94_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si94_instit"]) || $this->si94_instit != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2011606,'" . AddSlashes(pg_result($resaco, $conresaco, 'si94_instit')) . "','$this->si94_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
//    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "conv202021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si94_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "conv202021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si94_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si94_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si94_sequencial = null, $dbwhere = null)
  {
//    if ($dbwhere == null || $dbwhere == "") {
//      $resaco = $this->sql_record($this->sql_query_file($si94_sequencial));
//    } else {
//      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
//    }
//    if (($resaco != false) || ($this->numrows != 0)) {
//      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2010533,'$si94_sequencial','E')");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010533,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010534,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010535,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010536,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_nroconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010537,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_dtassinaturaconvoriginal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010538,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_nroseqtermoaditivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010539,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_dscalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010540,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_dtassinaturatermoaditivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010541,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_datafinalvigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010542,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_valoratualizadoconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010543,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_valoratualizadocontrapartida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010544,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2011606,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si94_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
//    }
    $sql = " delete from conv202021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si94_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si94_sequencial = $si94_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "conv202021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si94_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "conv202021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si94_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si94_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:conv202021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si94_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from conv202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si94_sequencial != null) {
        $sql2 .= " where conv202021.si94_sequencial = $si94_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
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
  function sql_query_file($si94_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from conv202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si94_sequencial != null) {
        $sql2 .= " where conv202021.si94_sequencial = $si94_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
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
