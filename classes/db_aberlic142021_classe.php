<?
//MODULO: sicom
//CLASSE DA ENTIDADE aberlic142021
class cl_aberlic142021
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
  var $si50_sequencial = 0;
  var $si50_tiporegistro = 0;
  var $si50_codorgaoresp = null;
  var $si50_codunidadesubresp = null;
  var $si50_exerciciolicitacao = 0;
  var $si50_nroprocessolicitatorio = null;
  var $si50_nrolote = 0;
  var $si50_coditem = 0;
  var $si50_dtcotacao_dia = null;
  var $si50_dtcotacao_mes = null;
  var $si50_dtcotacao_ano = null;
  var $si50_dtcotacao = null;
  var $si50_vlrefpercentual = 0;
  var $si50_vlcotprecosunitario = 0;
  var $si50_quantidade = 0;
  var $si50_vlminalienbens = 0;
  var $si50_mes = 0;
  var $si50_reg10 = 0;
  var $si50_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si50_sequencial = int8 = sequencial
                 si50_tiporegistro = int8 = Tipo do  registro
                 si50_codorgaoresp = varchar(2) = Código do órgão responsável
                 si50_codunidadesubresp = varchar(8) = Código da unidade
                 si50_exerciciolicitacao = int8 = Exercício em que   foi instaurado
                 si50_nroprocessolicitatorio = varchar(12) = Número sequencial   do processo
                 si50_nrolote = int8 = Número do Lote
                 si50_coditem = int8 = Código do Item
                 si50_dtcotacao = date = Data da cotação
                 si50_vlrefpercentual = float4 = Valor de referência, em percentual, para a licitação
                 si50_vlcotprecosunitario = float8 = Valor de referência para a licitação
                 si50_quantidade = float8 = Quantidade do item
                 si50_vlminalienbens = float8 = Valor mínimo global
                 si50_mes = int8 = Mês
                 si50_reg10 = int8 = reg10
                 si50_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_aberlic142021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aberlic142021");
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
      $this->si50_sequencial = ($this->si50_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_sequencial"] : $this->si50_sequencial);
      $this->si50_tiporegistro = ($this->si50_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_tiporegistro"] : $this->si50_tiporegistro);
      $this->si50_codorgaoresp = ($this->si50_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_codorgaoresp"] : $this->si50_codorgaoresp);
      $this->si50_codunidadesubresp = ($this->si50_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_codunidadesubresp"] : $this->si50_codunidadesubresp);
      $this->si50_exerciciolicitacao = ($this->si50_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_exerciciolicitacao"] : $this->si50_exerciciolicitacao);
      $this->si50_nroprocessolicitatorio = ($this->si50_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_nroprocessolicitatorio"] : $this->si50_nroprocessolicitatorio);
      $this->si50_nrolote = ($this->si50_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_nrolote"] : $this->si50_nrolote);
      $this->si50_coditem = ($this->si50_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_coditem"] : $this->si50_coditem);
      if ($this->si50_dtcotacao == "") {
        $this->si50_dtcotacao_dia = ($this->si50_dtcotacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_dtcotacao_dia"] : $this->si50_dtcotacao_dia);
        $this->si50_dtcotacao_mes = ($this->si50_dtcotacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_dtcotacao_mes"] : $this->si50_dtcotacao_mes);
        $this->si50_dtcotacao_ano = ($this->si50_dtcotacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_dtcotacao_ano"] : $this->si50_dtcotacao_ano);
        if ($this->si50_dtcotacao_dia != "") {
          $this->si50_dtcotacao = $this->si50_dtcotacao_ano . "-" . $this->si50_dtcotacao_mes . "-" . $this->si50_dtcotacao_dia;
        }
      }
      $this->si50_vlrefpercentual = ($this->si50_vlrefpercentual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_vlrefpercentual"] : $this->si50_vlrefpercentual);
      $this->si50_vlcotprecosunitario = ($this->si50_vlcotprecosunitario == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_vlcotprecosunitario"] : $this->si50_vlcotprecosunitario);
      $this->si50_quantidade = ($this->si50_quantidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_quantidade"] : $this->si50_quantidade);
      $this->si50_vlminalienbens = ($this->si50_vlminalienbens == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_vlminalienbens"] : $this->si50_vlminalienbens);
      $this->si50_mes = ($this->si50_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_mes"] : $this->si50_mes);
      $this->si50_reg10 = ($this->si50_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_reg10"] : $this->si50_reg10);
      $this->si50_instit = ($this->si50_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_instit"] : $this->si50_instit);
    } else {
      $this->si50_sequencial = ($this->si50_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si50_sequencial"] : $this->si50_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si50_sequencial)
  {
    $this->atualizacampos();
    if ($this->si50_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si50_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si50_exerciciolicitacao == null) {
      $this->si50_exerciciolicitacao = "0";
    }
    if ($this->si50_nrolote == null) {
      $this->si50_nrolote = "0";
    }
    if ($this->si50_coditem == null) {
      $this->si50_coditem = "0";
    }
    if ($this->si50_dtcotacao == null) {
      $this->si50_dtcotacao = "null";
    }
    if ($this->si50_vlrefpercentual == null) {
      $this->si50_vlrefpercentual = "0";
    }
    if ($this->si50_vlcotprecosunitario == null) {
      $this->si50_vlcotprecosunitario = "0";
    }
    if ($this->si50_quantidade == null) {
      $this->si50_quantidade = "0";
    }
    if ($this->si50_vlminalienbens == null) {
      $this->si50_vlminalienbens = "0";
    }
    if ($this->si50_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si50_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si50_reg10 == null) {
      $this->si50_reg10 = "0";
    }
    if ($this->si50_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si50_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si50_sequencial == "" || $si50_sequencial == null) {
      $result = db_query("select nextval('aberlic142021_si50_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aberlic142021_si50_sequencial_seq do campo: si50_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si50_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aberlic142021_si50_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si50_sequencial)) {
        $this->erro_sql = " Campo si50_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si50_sequencial = $si50_sequencial;
      }
    }
    if (($this->si50_sequencial == null) || ($this->si50_sequencial == "")) {
      $this->erro_sql = " Campo si50_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aberlic142021(
                                       si50_sequencial
                                      ,si50_tiporegistro
                                      ,si50_codorgaoresp
                                      ,si50_codunidadesubresp
                                      ,si50_exerciciolicitacao
                                      ,si50_nroprocessolicitatorio
                                      ,si50_nrolote
                                      ,si50_coditem
                                      ,si50_dtcotacao
                                      ,si50_vlrefpercentual
                                      ,si50_vlcotprecosunitario
                                      ,si50_quantidade
                                      ,si50_vlminalienbens
                                      ,si50_mes
                                      ,si50_reg10
                                      ,si50_instit
                       )
                values (
                                $this->si50_sequencial
                               ,$this->si50_tiporegistro
                               ,'$this->si50_codorgaoresp'
                               ,'$this->si50_codunidadesubresp'
                               ,$this->si50_exerciciolicitacao
                               ,'$this->si50_nroprocessolicitatorio'
                               ,$this->si50_nrolote
                               ,$this->si50_coditem
                               ," . ($this->si50_dtcotacao == "null" || $this->si50_dtcotacao == "" ? "null" : "'" . $this->si50_dtcotacao . "'") . "
                               ,$this->si50_vlrefpercentual
                               ,$this->si50_vlcotprecosunitario
                               ,$this->si50_quantidade
                               ,$this->si50_vlminalienbens
                               ,$this->si50_mes
                               ,$this->si50_reg10
                               ,$this->si50_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aberlic142021 ($this->si50_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aberlic142021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aberlic142021 ($this->si50_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si50_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si50_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009929,'$this->si50_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010279,2009929,'','" . AddSlashes(pg_result($resaco, 0, 'si50_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009930,'','" . AddSlashes(pg_result($resaco, 0, 'si50_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009931,'','" . AddSlashes(pg_result($resaco, 0, 'si50_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009932,'','" . AddSlashes(pg_result($resaco, 0, 'si50_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009933,'','" . AddSlashes(pg_result($resaco, 0, 'si50_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009934,'','" . AddSlashes(pg_result($resaco, 0, 'si50_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009935,'','" . AddSlashes(pg_result($resaco, 0, 'si50_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009936,'','" . AddSlashes(pg_result($resaco, 0, 'si50_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009937,'','" . AddSlashes(pg_result($resaco, 0, 'si50_dtcotacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009938,'','" . AddSlashes(pg_result($resaco, 0, 'si50_vlcotprecosunitario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009939,'','" . AddSlashes(pg_result($resaco, 0, 'si50_quantidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009941,'','" . AddSlashes(pg_result($resaco, 0, 'si50_vlminalienbens')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009942,'','" . AddSlashes(pg_result($resaco, 0, 'si50_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2009943,'','" . AddSlashes(pg_result($resaco, 0, 'si50_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010279,2011564,'','" . AddSlashes(pg_result($resaco, 0, 'si50_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si50_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aberlic142021 set ";
    $virgula = "";
    if (trim($this->si50_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_sequencial"])) {
      if (trim($this->si50_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si50_sequencial"])) {
        $this->si50_sequencial = "0";
      }
      $sql .= $virgula . " si50_sequencial = $this->si50_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si50_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_tiporegistro"])) {
      $sql .= $virgula . " si50_tiporegistro = $this->si50_tiporegistro ";
      $virgula = ",";
      if (trim($this->si50_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si50_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si50_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_codorgaoresp"])) {
      $sql .= $virgula . " si50_codorgaoresp = '$this->si50_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si50_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_codunidadesubresp"])) {
      $sql .= $virgula . " si50_codunidadesubresp = '$this->si50_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si50_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_exerciciolicitacao"])) {
      if (trim($this->si50_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si50_exerciciolicitacao"])) {
        $this->si50_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si50_exerciciolicitacao = $this->si50_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si50_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si50_nroprocessolicitatorio = '$this->si50_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si50_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_nrolote"])) {
      if (trim($this->si50_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si50_nrolote"])) {
        $this->si50_nrolote = "0";
      }
      $sql .= $virgula . " si50_nrolote = $this->si50_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si50_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_coditem"])) {
      if (trim($this->si50_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si50_coditem"])) {
        $this->si50_coditem = "0";
      }
      $sql .= $virgula . " si50_coditem = $this->si50_coditem ";
      $virgula = ",";
    }
    if (trim($this->si50_dtcotacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_dtcotacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si50_dtcotacao_dia"] != "")) {
      $sql .= $virgula . " si50_dtcotacao = '$this->si50_dtcotacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si50_dtcotacao_dia"])) {
        $sql .= $virgula . " si50_dtcotacao = null ";
        $virgula = ",";
      }
    }

    if (trim($this->si50_vlrefpercentual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_vlrefpercentual"])) {
      if (trim($this->si50_vlrefpercentual) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si50_vlrefpercentual"])) {
        $this->si50_vlrefpercentual = "0";
      }
      $sql .= $virgula . " si50_vlrefpercentual = $this->si50_vlrefpercentual ";
      $virgula = ",";
    }

    if (trim($this->si50_vlcotprecosunitario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_vlcotprecosunitario"])) {
      if (trim($this->si50_vlcotprecosunitario) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si50_vlcotprecosunitario"])) {
        $this->si50_vlcotprecosunitario = "0";
      }
      $sql .= $virgula . " si50_vlcotprecosunitario = $this->si50_vlcotprecosunitario ";
      $virgula = ",";
    }
    if (trim($this->si50_quantidade) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_quantidade"])) {
      if (trim($this->si50_quantidade) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si50_quantidade"])) {
        $this->si50_quantidade = "0";
      }
      $sql .= $virgula . " si50_quantidade = $this->si50_quantidade ";
      $virgula = ",";
    }
    if (trim($this->si50_vlminalienbens) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_vlminalienbens"])) {
      if (trim($this->si50_vlminalienbens) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si50_vlminalienbens"])) {
        $this->si50_vlminalienbens = "0";
      }
      $sql .= $virgula . " si50_vlminalienbens = $this->si50_vlminalienbens ";
      $virgula = ",";
    }
    if (trim($this->si50_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_mes"])) {
      $sql .= $virgula . " si50_mes = $this->si50_mes ";
      $virgula = ",";
      if (trim($this->si50_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si50_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si50_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_reg10"])) {
      if (trim($this->si50_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si50_reg10"])) {
        $this->si50_reg10 = "0";
      }
      $sql .= $virgula . " si50_reg10 = $this->si50_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si50_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si50_instit"])) {
      $sql .= $virgula . " si50_instit = $this->si50_instit ";
      $virgula = ",";
      if (trim($this->si50_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si50_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si50_sequencial != null) {
      $sql .= " si50_sequencial = $this->si50_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si50_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009929,'$this->si50_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_sequencial"]) || $this->si50_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009929,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_sequencial')) . "','$this->si50_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_tiporegistro"]) || $this->si50_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009930,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_tiporegistro')) . "','$this->si50_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_codorgaoresp"]) || $this->si50_codorgaoresp != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009931,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_codorgaoresp')) . "','$this->si50_codorgaoresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_codunidadesubresp"]) || $this->si50_codunidadesubresp != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009932,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_codunidadesubresp')) . "','$this->si50_codunidadesubresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_exerciciolicitacao"]) || $this->si50_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009933,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_exerciciolicitacao')) . "','$this->si50_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_nroprocessolicitatorio"]) || $this->si50_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009934,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_nroprocessolicitatorio')) . "','$this->si50_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_nrolote"]) || $this->si50_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009935,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_nrolote')) . "','$this->si50_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_coditem"]) || $this->si50_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009936,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_coditem')) . "','$this->si50_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_dtcotacao"]) || $this->si50_dtcotacao != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009937,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_dtcotacao')) . "','$this->si50_dtcotacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_vlcotprecosunitario"]) || $this->si50_vlcotprecosunitario != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009938,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_vlcotprecosunitario')) . "','$this->si50_vlcotprecosunitario'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_quantidade"]) || $this->si50_quantidade != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009939,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_quantidade')) . "','$this->si50_quantidade'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_vlminalienbens"]) || $this->si50_vlminalienbens != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009941,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_vlminalienbens')) . "','$this->si50_vlminalienbens'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_mes"]) || $this->si50_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009942,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_mes')) . "','$this->si50_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_reg10"]) || $this->si50_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2009943,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_reg10')) . "','$this->si50_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si50_instit"]) || $this->si50_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010279,2011564,'" . AddSlashes(pg_result($resaco, $conresaco, 'si50_instit')) . "','$this->si50_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aberlic142021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si50_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aberlic142021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si50_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si50_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si50_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si50_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009929,'$si50_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010279,2009929,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009930,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009931,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009932,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009933,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009934,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009935,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009936,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009937,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_dtcotacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009938,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_vlcotprecosunitario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009939,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_quantidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009941,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_vlminalienbens')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009942,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2009943,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010279,2011564,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si50_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aberlic142021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si50_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si50_sequencial = $si50_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aberlic142021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si50_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aberlic142021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si50_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si50_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aberlic142021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si50_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aberlic142021 ";
    $sql .= "      left  join aberlic102020  on  aberlic102020.si46_sequencial = aberlic142021.si50_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si50_sequencial != null) {
        $sql2 .= " where aberlic142021.si50_sequencial = $si50_sequencial ";
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
  function sql_query_file($si50_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aberlic142021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si50_sequencial != null) {
        $sql2 .= " where aberlic142021.si50_sequencial = $si50_sequencial ";
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
