<?
//MODULO: sicom
//CLASSE DA ENTIDADE ddc302021
class cl_ddc302021
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
  var $si154_sequencial = 0;
  var $si154_tiporegistro = 0;
  var $si154_codorgao = null;
  var $si154_nrocontratodivida = null;
  var $si154_dtassinatura_dia = null;
  var $si154_dtassinatura_mes = null;
  var $si154_dtassinatura_ano = null;
  var $si154_dtassinatura = null;
  var $si154_tipolancamento = null;
  var $si154_subtipo = null;
  var $si154_tipodocumentocredor = 0;
  var $si154_nrodocumentocredor = null;
  var $si154_justificativacancelamento = null;
  var $si154_vlsaldoanterior = 0;
  var $si154_vlcontratacao = 0;
  var $si154_vlamortizacao = 0;
  var $si154_vlcancelamento = 0;
  var $si154_vlencampacao = 0;
  var $si154_vlatualizacao = 0;
  var $si154_vlsaldoatual = 0;
  var $si154_mes = 0;
  var $si154_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si154_sequencial = int8 = sequencial 
                 si154_tiporegistro = int8 = Tipo do registro 
                 si154_codorgao = varchar(2) = Código do órgão 
                 si154_nrocontratodivida = varchar(30) = Número do  Contrato 
                 si154_dtassinatura = date = Data da  assinatura do Contrato 
                 si154_tipolancamento = varchar(2) = Tipo de  Lançamento
                 si154_subtipo = varchar(1) = Subtipo
                 si154_tipodocumentocredor = int8 = Tipo de  Documento do credor 
                 si154_nrodocumentocredor = varchar(14) = Número do  documento do Credor 
                 si154_justificativacancelamento = varchar(500) = justificativa para o  Cancelamento 
                 si154_vlsaldoanterior = float8 = Valor do Saldo  Anterior 
                 si154_vlcontratacao = float8 = Valor de  Contratação 
                 si154_vlamortizacao = float8 = Valor de  Amortização 
                 si154_vlcancelamento = float8 = Valor de  Cancelamento 
                 si154_vlencampacao = float8 = Valor de  Encampação 
                 si154_vlatualizacao = float8 = Valor da  Atualização 
                 si154_vlsaldoatual = float8 = Valor do Saldo  Atual 
                 si154_mes = int8 = Mês 
                 si154_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_ddc302021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ddc302021");
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
      $this->si154_sequencial = ($this->si154_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_sequencial"] : $this->si154_sequencial);
      $this->si154_tiporegistro = ($this->si154_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_tiporegistro"] : $this->si154_tiporegistro);
      $this->si154_codorgao = ($this->si154_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_codorgao"] : $this->si154_codorgao);
      $this->si154_nrocontratodivida = ($this->si154_nrocontratodivida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_nrocontratodivida"] : $this->si154_nrocontratodivida);
      if ($this->si154_dtassinatura == "") {
        $this->si154_dtassinatura_dia = ($this->si154_dtassinatura_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_dtassinatura_dia"] : $this->si154_dtassinatura_dia);
        $this->si154_dtassinatura_mes = ($this->si154_dtassinatura_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_dtassinatura_mes"] : $this->si154_dtassinatura_mes);
        $this->si154_dtassinatura_ano = ($this->si154_dtassinatura_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_dtassinatura_ano"] : $this->si154_dtassinatura_ano);
        if ($this->si154_dtassinatura_dia != "") {
          $this->si154_dtassinatura = $this->si154_dtassinatura_ano . "-" . $this->si154_dtassinatura_mes . "-" . $this->si154_dtassinatura_dia;
        }
      }
      $this->si154_tipolancamento = ($this->si154_tipolancamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_tipolancamento"] : $this->si154_tipolancamento);
      $this->si154_subtipo = ($this->si154_subtipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_subtipo"] : $this->si154_subtipo);
      $this->si154_tipodocumentocredor = ($this->si154_tipodocumentocredor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_tipodocumentocredor"] : $this->si154_tipodocumentocredor);
      $this->si154_nrodocumentocredor = ($this->si154_nrodocumentocredor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_nrodocumentocredor"] : $this->si154_nrodocumentocredor);
      $this->si154_justificativacancelamento = ($this->si154_justificativacancelamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_justificativacancelamento"] : $this->si154_justificativacancelamento);
      $this->si154_vlsaldoanterior = ($this->si154_vlsaldoanterior == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_vlsaldoanterior"] : $this->si154_vlsaldoanterior);
      $this->si154_vlcontratacao = ($this->si154_vlcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_vlcontratacao"] : $this->si154_vlcontratacao);
      $this->si154_vlamortizacao = ($this->si154_vlamortizacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_vlamortizacao"] : $this->si154_vlamortizacao);
      $this->si154_vlcancelamento = ($this->si154_vlcancelamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_vlcancelamento"] : $this->si154_vlcancelamento);
      $this->si154_vlencampacao = ($this->si154_vlencampacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_vlencampacao"] : $this->si154_vlencampacao);
      $this->si154_vlatualizacao = ($this->si154_vlatualizacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_vlatualizacao"] : $this->si154_vlatualizacao);
      $this->si154_vlsaldoatual = ($this->si154_vlsaldoatual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_vlsaldoatual"] : $this->si154_vlsaldoatual);
      $this->si154_mes = ($this->si154_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_mes"] : $this->si154_mes);
      $this->si154_instit = ($this->si154_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_instit"] : $this->si154_instit);
    } else {
      $this->si154_sequencial = ($this->si154_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si154_sequencial"] : $this->si154_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si154_sequencial)
  {
    $this->atualizacampos();
    if ($this->si154_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si154_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si154_nrocontratodivida == null) {
      $this->si154_nrocontratodivida = "0";
    }
    if ($this->si154_dtassinatura == null) {
      $this->si154_dtassinatura = "null";
    }
    if ($this->si154_subtipo == null) {
      $this->si154_subtipo = "0";
    }
    if ($this->si154_tipodocumentocredor == null) {
      $this->si154_tipodocumentocredor = "0";
    }
    if ($this->si154_vlsaldoanterior == null) {
      $this->si154_vlsaldoanterior = "0";
    }
    if ($this->si154_vlcontratacao == null) {
      $this->si154_vlcontratacao = "0";
    }
    if ($this->si154_vlamortizacao == null) {
      $this->si154_vlamortizacao = "0";
    }
    if ($this->si154_vlcancelamento == null) {
      $this->si154_vlcancelamento = "0";
    }
    if ($this->si154_vlencampacao == null) {
      $this->si154_vlencampacao = "0";
    }
    if ($this->si154_vlatualizacao == null) {
      $this->si154_vlatualizacao = "0";
    }
    if ($this->si154_vlsaldoatual == null) {
      $this->si154_vlsaldoatual = "0";
    }
    if ($this->si154_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si154_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si154_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si154_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si154_sequencial == "" || $si154_sequencial == null) {
      $result = db_query("select nextval('ddc302021_si154_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ddc302021_si154_sequencial_seq do campo: si154_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si154_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ddc302021_si154_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si154_sequencial)) {
        $this->erro_sql = " Campo si154_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si154_sequencial = $si154_sequencial;
      }
    }
    if (($this->si154_sequencial == null) || ($this->si154_sequencial == "")) {
      $this->erro_sql = " Campo si154_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into ddc302021(
                                       si154_sequencial 
                                      ,si154_tiporegistro 
                                      ,si154_codorgao 
                                      ,si154_nrocontratodivida 
                                      ,si154_dtassinatura 
                                      ,si154_tipolancamento 
                                      ,si154_subtipo
                                      ,si154_tipodocumentocredor
                                      ,si154_nrodocumentocredor
                                      ,si154_justificativacancelamento 
                                      ,si154_vlsaldoanterior 
                                      ,si154_vlcontratacao 
                                      ,si154_vlamortizacao 
                                      ,si154_vlcancelamento 
                                      ,si154_vlencampacao 
                                      ,si154_vlatualizacao 
                                      ,si154_vlsaldoatual 
                                      ,si154_mes 
                                      ,si154_instit 
                       )
                values (
                                $this->si154_sequencial 
                               ,$this->si154_tiporegistro 
                               ,'$this->si154_codorgao' 
                               ,'$this->si154_nrocontratodivida' 
                               ," . ($this->si154_dtassinatura == "null" || $this->si154_dtassinatura == "" ? "null" : "'" . $this->si154_dtassinatura . "'") . "
                               ,'$this->si154_tipolancamento' 
                               ,'$this->si154_subtipo'
                               ,$this->si154_tipodocumentocredor
                               ,'$this->si154_nrodocumentocredor' 
                               ,'$this->si154_justificativacancelamento' 
                               ,$this->si154_vlsaldoanterior 
                               ,$this->si154_vlcontratacao 
                               ,$this->si154_vlamortizacao 
                               ,$this->si154_vlcancelamento 
                               ,$this->si154_vlencampacao 
                               ,$this->si154_vlatualizacao 
                               ,$this->si154_vlsaldoatual 
                               ,$this->si154_mes 
                               ,$this->si154_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ddc302021 ($this->si154_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ddc302021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ddc302021 ($this->si154_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si154_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si154_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2011175,'$this->si154_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010383,2011175,'','" . AddSlashes(pg_result($resaco, 0, 'si154_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011176,'','" . AddSlashes(pg_result($resaco, 0, 'si154_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011364,'','" . AddSlashes(pg_result($resaco, 0, 'si154_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011177,'','" . AddSlashes(pg_result($resaco, 0, 'si154_nrocontratodivida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011365,'','" . AddSlashes(pg_result($resaco, 0, 'si154_dtassinatura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011366,'','" . AddSlashes(pg_result($resaco, 0, 'si154_tipolancamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011367,'','" . AddSlashes(pg_result($resaco, 0, 'si154_tipodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011368,'','" . AddSlashes(pg_result($resaco, 0, 'si154_nrodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011178,'','" . AddSlashes(pg_result($resaco, 0, 'si154_justificativacancelamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011179,'','" . AddSlashes(pg_result($resaco, 0, 'si154_vlsaldoanterior')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011180,'','" . AddSlashes(pg_result($resaco, 0, 'si154_vlcontratacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011181,'','" . AddSlashes(pg_result($resaco, 0, 'si154_vlamortizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011182,'','" . AddSlashes(pg_result($resaco, 0, 'si154_vlcancelamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011183,'','" . AddSlashes(pg_result($resaco, 0, 'si154_vlencampacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011184,'','" . AddSlashes(pg_result($resaco, 0, 'si154_vlatualizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011185,'','" . AddSlashes(pg_result($resaco, 0, 'si154_vlsaldoatual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011186,'','" . AddSlashes(pg_result($resaco, 0, 'si154_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010383,2011667,'','" . AddSlashes(pg_result($resaco, 0, 'si154_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si154_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ddc302021 set ";
    $virgula = "";
    if (trim($this->si154_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_sequencial"])) {
      if (trim($this->si154_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si154_sequencial"])) {
        $this->si154_sequencial = "0";
      }
      $sql .= $virgula . " si154_sequencial = $this->si154_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si154_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_tiporegistro"])) {
      $sql .= $virgula . " si154_tiporegistro = $this->si154_tiporegistro ";
      $virgula = ",";
      if (trim($this->si154_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si154_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si154_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_codorgao"])) {
      $sql .= $virgula . " si154_codorgao = '$this->si154_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si154_nrocontratodivida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_nrocontratodivida"])) {
      $sql .= $virgula . " si154_nrocontratodivida = '$this->si154_nrocontratodivida' ";
      $virgula = ",";
    }
    if (trim($this->si154_dtassinatura) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_dtassinatura_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si154_dtassinatura_dia"] != "")) {
      $sql .= $virgula . " si154_dtassinatura = '$this->si154_dtassinatura' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si154_dtassinatura_dia"])) {
        $sql .= $virgula . " si154_dtassinatura = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si154_tipolancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_tipolancamento"])) {
      $sql .= $virgula . " si154_tipolancamento = '$this->si154_tipolancamento' ";
      $virgula = ",";
    }
    if (trim($this->si154_subtipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_subtipo"])) {
      $sql .= $virgula . " si154_subtipo = '$this->si154_subtipo' ";
      $virgula = ",";
    }
    if (trim($this->si154_tipodocumentocredor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_tipodocumentocredor"])) {
      if (trim($this->si154_tipodocumentocredor) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si154_tipodocumentocredor"])) {
        $this->si154_tipodocumentocredor = "0";
      }
      $sql .= $virgula . " si154_tipodocumentocredor = $this->si154_tipodocumentocredor ";
      $virgula = ",";
    }
    if (trim($this->si154_nrodocumentocredor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_nrodocumentocredor"])) {
      $sql .= $virgula . " si154_nrodocumentocredor = '$this->si154_nrodocumentocredor' ";
      $virgula = ",";
    }
    if (trim($this->si154_justificativacancelamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_justificativacancelamento"])) {
      $sql .= $virgula . " si154_justificativacancelamento = '$this->si154_justificativacancelamento' ";
      $virgula = ",";
    }
    if (trim($this->si154_vlsaldoanterior) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_vlsaldoanterior"])) {
      if (trim($this->si154_vlsaldoanterior) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si154_vlsaldoanterior"])) {
        $this->si154_vlsaldoanterior = "0";
      }
      $sql .= $virgula . " si154_vlsaldoanterior = $this->si154_vlsaldoanterior ";
      $virgula = ",";
    }
    if (trim($this->si154_vlcontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_vlcontratacao"])) {
      if (trim($this->si154_vlcontratacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si154_vlcontratacao"])) {
        $this->si154_vlcontratacao = "0";
      }
      $sql .= $virgula . " si154_vlcontratacao = $this->si154_vlcontratacao ";
      $virgula = ",";
    }
    if (trim($this->si154_vlamortizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_vlamortizacao"])) {
      if (trim($this->si154_vlamortizacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si154_vlamortizacao"])) {
        $this->si154_vlamortizacao = "0";
      }
      $sql .= $virgula . " si154_vlamortizacao = $this->si154_vlamortizacao ";
      $virgula = ",";
    }
    if (trim($this->si154_vlcancelamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_vlcancelamento"])) {
      if (trim($this->si154_vlcancelamento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si154_vlcancelamento"])) {
        $this->si154_vlcancelamento = "0";
      }
      $sql .= $virgula . " si154_vlcancelamento = $this->si154_vlcancelamento ";
      $virgula = ",";
    }
    if (trim($this->si154_vlencampacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_vlencampacao"])) {
      if (trim($this->si154_vlencampacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si154_vlencampacao"])) {
        $this->si154_vlencampacao = "0";
      }
      $sql .= $virgula . " si154_vlencampacao = $this->si154_vlencampacao ";
      $virgula = ",";
    }
    if (trim($this->si154_vlatualizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_vlatualizacao"])) {
      if (trim($this->si154_vlatualizacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si154_vlatualizacao"])) {
        $this->si154_vlatualizacao = "0";
      }
      $sql .= $virgula . " si154_vlatualizacao = $this->si154_vlatualizacao ";
      $virgula = ",";
    }
    if (trim($this->si154_vlsaldoatual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_vlsaldoatual"])) {
      if (trim($this->si154_vlsaldoatual) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si154_vlsaldoatual"])) {
        $this->si154_vlsaldoatual = "0";
      }
      $sql .= $virgula . " si154_vlsaldoatual = $this->si154_vlsaldoatual ";
      $virgula = ",";
    }
    if (trim($this->si154_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_mes"])) {
      $sql .= $virgula . " si154_mes = $this->si154_mes ";
      $virgula = ",";
      if (trim($this->si154_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si154_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si154_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si154_instit"])) {
      $sql .= $virgula . " si154_instit = $this->si154_instit ";
      $virgula = ",";
      if (trim($this->si154_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si154_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si154_sequencial != null) {
      $sql .= " si154_sequencial = $this->si154_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si154_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011175,'$this->si154_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_sequencial"]) || $this->si154_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011175,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_sequencial')) . "','$this->si154_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_tiporegistro"]) || $this->si154_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011176,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_tiporegistro')) . "','$this->si154_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_codorgao"]) || $this->si154_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011364,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_codorgao')) . "','$this->si154_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_nrocontratodivida"]) || $this->si154_nrocontratodivida != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011177,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_nrocontratodivida')) . "','$this->si154_nrocontratodivida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_dtassinatura"]) || $this->si154_dtassinatura != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011365,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_dtassinatura')) . "','$this->si154_dtassinatura'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_tipolancamento"]) || $this->si154_tipolancamento != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011366,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_tipolancamento')) . "','$this->si154_tipolancamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_tipodocumentocredor"]) || $this->si154_tipodocumentocredor != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011367,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_tipodocumentocredor')) . "','$this->si154_tipodocumentocredor'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_nrodocumentocredor"]) || $this->si154_nrodocumentocredor != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011368,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_nrodocumentocredor')) . "','$this->si154_nrodocumentocredor'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_justificativacancelamento"]) || $this->si154_justificativacancelamento != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011178,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_justificativacancelamento')) . "','$this->si154_justificativacancelamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_vlsaldoanterior"]) || $this->si154_vlsaldoanterior != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011179,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_vlsaldoanterior')) . "','$this->si154_vlsaldoanterior'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_vlcontratacao"]) || $this->si154_vlcontratacao != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011180,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_vlcontratacao')) . "','$this->si154_vlcontratacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_vlamortizacao"]) || $this->si154_vlamortizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011181,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_vlamortizacao')) . "','$this->si154_vlamortizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_vlcancelamento"]) || $this->si154_vlcancelamento != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011182,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_vlcancelamento')) . "','$this->si154_vlcancelamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_vlencampacao"]) || $this->si154_vlencampacao != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011183,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_vlencampacao')) . "','$this->si154_vlencampacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_vlatualizacao"]) || $this->si154_vlatualizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011184,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_vlatualizacao')) . "','$this->si154_vlatualizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_vlsaldoatual"]) || $this->si154_vlsaldoatual != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011185,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_vlsaldoatual')) . "','$this->si154_vlsaldoatual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_mes"]) || $this->si154_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011186,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_mes')) . "','$this->si154_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si154_instit"]) || $this->si154_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010383,2011667,'" . AddSlashes(pg_result($resaco, $conresaco, 'si154_instit')) . "','$this->si154_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ddc302021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si154_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ddc302021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si154_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si154_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si154_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si154_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011175,'$si154_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010383,2011175,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011176,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011364,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011177,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_nrocontratodivida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011365,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_dtassinatura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011366,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_tipolancamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011367,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_tipodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011368,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_nrodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011178,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_justificativacancelamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011179,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_vlsaldoanterior')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011180,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_vlcontratacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011181,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_vlamortizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011182,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_vlcancelamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011183,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_vlencampacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011184,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_vlatualizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011185,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_vlsaldoatual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011186,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010383,2011667,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si154_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from ddc302021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si154_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si154_sequencial = $si154_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ddc302021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si154_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ddc302021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si154_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si154_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ddc302021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si154_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ddc302021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si154_sequencial != null) {
        $sql2 .= " where ddc302021.si154_sequencial = $si154_sequencial ";
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
  function sql_query_file($si154_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ddc302021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si154_sequencial != null) {
        $sql2 .= " where ddc302021.si154_sequencial = $si154_sequencial ";
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
