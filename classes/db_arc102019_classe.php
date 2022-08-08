<?
//MODULO: sicom
//CLASSE DA ENTIDADE arc102019
class cl_arc102019
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
  var $si28_sequencial = 0;
  var $si28_tiporegistro = 0;
  var $si28_codcorrecao = 0;
  var $si28_codorgao = null;
  var $si28_ededucaodereceita = 0;
  var $si28_identificadordeducaorecreduzida = 0;
  var $si28_naturezareceitareduzida = 0;
  var $si28_especificacaoreduzida = null;
  var $si28_identificadordeducaorecacrescida = 0;
  var $si28_naturezareceitaacrescida = 0;
  var $si28_especificacaoacrescida = null;
  var $si28_vlreduzidoacrescido = 0;
  var $si28_mes = 0;
  var $si28_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si28_sequencial = int8 = sequencial 
                 si28_tiporegistro = int8 = Tipo do  registro 
                 si28_codcorrecao = int8 = identifica a  operação 
                 si28_codorgao = varchar(2) = Código do órgão 
                 si28_ededucaodereceita = int8 = Identifica 
                 si28_identificadordeducaorecreduzida = int8 = Identificador da  dedução 
                 si28_naturezareceitareduzida = int8 = Natureza da receita  Reduzida 
                 si28_especificacaoreduzida = varchar(100) = Especificação 
                 si28_identificadordeducaorecacrescida = int8 = Identificador 
                 si28_naturezareceitaacrescida = int8 = Natureza da receita  acrescida 
                 si28_especificacaoacrescida = varchar(100) = Especificação da  receita acrescida 
                 si28_vlreduzidoacrescido = float8 = Valor reduzido 
                 si28_mes = int8 = Mês 
                 si28_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_arc102019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("arc102019");
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
      $this->si28_sequencial = ($this->si28_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_sequencial"] : $this->si28_sequencial);
      $this->si28_tiporegistro = ($this->si28_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_tiporegistro"] : $this->si28_tiporegistro);
      $this->si28_codcorrecao = ($this->si28_codcorrecao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_codcorrecao"] : $this->si28_codcorrecao);
      $this->si28_codorgao = ($this->si28_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_codorgao"] : $this->si28_codorgao);
      $this->si28_ededucaodereceita = ($this->si28_ededucaodereceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_ededucaodereceita"] : $this->si28_ededucaodereceita);
      $this->si28_identificadordeducaorecreduzida = ($this->si28_identificadordeducaorecreduzida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_identificadordeducaorecreduzida"] : $this->si28_identificadordeducaorecreduzida);
      $this->si28_naturezareceitareduzida = ($this->si28_naturezareceitareduzida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_naturezareceitareduzida"] : $this->si28_naturezareceitareduzida);
      $this->si28_especificacaoreduzida = ($this->si28_especificacaoreduzida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_especificacaoreduzida"] : $this->si28_especificacaoreduzida);
      $this->si28_identificadordeducaorecacrescida = ($this->si28_identificadordeducaorecacrescida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_identificadordeducaorecacrescida"] : $this->si28_identificadordeducaorecacrescida);
      $this->si28_naturezareceitaacrescida = ($this->si28_naturezareceitaacrescida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_naturezareceitaacrescida"] : $this->si28_naturezareceitaacrescida);
      $this->si28_especificacaoacrescida = ($this->si28_especificacaoacrescida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_especificacaoacrescida"] : $this->si28_especificacaoacrescida);
      $this->si28_vlreduzidoacrescido = ($this->si28_vlreduzidoacrescido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_vlreduzidoacrescido"] : $this->si28_vlreduzidoacrescido);
      $this->si28_mes = ($this->si28_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_mes"] : $this->si28_mes);
      $this->si28_instit = ($this->si28_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_instit"] : $this->si28_instit);
    } else {
      $this->si28_sequencial = ($this->si28_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si28_sequencial"] : $this->si28_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si28_sequencial)
  {
    $this->atualizacampos();
    if ($this->si28_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si28_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si28_codcorrecao == null) {
      $this->si28_codcorrecao = "0";
    }
    if ($this->si28_ededucaodereceita == null) {
      $this->si28_ededucaodereceita = "0";
    }
    if ($this->si28_identificadordeducaorecreduzida == null) {
      $this->si28_identificadordeducaorecreduzida = "0";
    }
    if ($this->si28_naturezareceitareduzida == null) {
      $this->si28_naturezareceitareduzida = "0";
    }
    if ($this->si28_identificadordeducaorecacrescida == null) {
      $this->si28_identificadordeducaorecacrescida = "0";
    }
    if ($this->si28_naturezareceitaacrescida == null) {
      $this->si28_naturezareceitaacrescida = "0";
    }
    if ($this->si28_vlreduzidoacrescido == null) {
      $this->si28_vlreduzidoacrescido = "0";
    }
    if ($this->si28_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si28_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si28_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si28_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si28_sequencial == "" || $si28_sequencial == null) {
      $result = db_query("select nextval('arc102019_si28_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: arc102019_si28_sequencial_seq do campo: si28_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si28_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from arc102019_si28_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si28_sequencial)) {
        $this->erro_sql = " Campo si28_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si28_sequencial = $si28_sequencial;
      }
    }
    if (($this->si28_sequencial == null) || ($this->si28_sequencial == "")) {
      $this->erro_sql = " Campo si28_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into arc102019(
                                       si28_sequencial 
                                      ,si28_tiporegistro 
                                      ,si28_codcorrecao 
                                      ,si28_codorgao 
                                      ,si28_ededucaodereceita 
                                      ,si28_identificadordeducaorecreduzida 
                                      ,si28_naturezareceitareduzida 
                                      ,si28_especificacaoreduzida 
                                      ,si28_identificadordeducaorecacrescida 
                                      ,si28_naturezareceitaacrescida 
                                      ,si28_especificacaoacrescida 
                                      ,si28_vlreduzidoacrescido 
                                      ,si28_mes 
                                      ,si28_instit 
                       )
                values (
                                $this->si28_sequencial 
                               ,$this->si28_tiporegistro 
                               ,$this->si28_codcorrecao 
                               ,'$this->si28_codorgao' 
                               ,$this->si28_ededucaodereceita 
                               ,$this->si28_identificadordeducaorecreduzida 
                               ,$this->si28_naturezareceitareduzida 
                               ,'$this->si28_especificacaoreduzida' 
                               ,$this->si28_identificadordeducaorecacrescida 
                               ,$this->si28_naturezareceitaacrescida 
                               ,'$this->si28_especificacaoacrescida' 
                               ,$this->si28_vlreduzidoacrescido 
                               ,$this->si28_mes 
                               ,$this->si28_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "arc102019 ($this->si28_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "arc102019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "arc102019 ($this->si28_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si28_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si28_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009690,'$this->si28_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010256,2009690,'','" . AddSlashes(pg_result($resaco, 0, 'si28_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009691,'','" . AddSlashes(pg_result($resaco, 0, 'si28_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009692,'','" . AddSlashes(pg_result($resaco, 0, 'si28_codcorrecao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009693,'','" . AddSlashes(pg_result($resaco, 0, 'si28_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009694,'','" . AddSlashes(pg_result($resaco, 0, 'si28_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009695,'','" . AddSlashes(pg_result($resaco, 0, 'si28_identificadordeducaorecreduzida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009696,'','" . AddSlashes(pg_result($resaco, 0, 'si28_naturezareceitareduzida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009697,'','" . AddSlashes(pg_result($resaco, 0, 'si28_especificacaoreduzida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009699,'','" . AddSlashes(pg_result($resaco, 0, 'si28_identificadordeducaorecacrescida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009700,'','" . AddSlashes(pg_result($resaco, 0, 'si28_naturezareceitaacrescida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009701,'','" . AddSlashes(pg_result($resaco, 0, 'si28_especificacaoacrescida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009702,'','" . AddSlashes(pg_result($resaco, 0, 'si28_vlreduzidoacrescido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2009745,'','" . AddSlashes(pg_result($resaco, 0, 'si28_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010256,2011543,'','" . AddSlashes(pg_result($resaco, 0, 'si28_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si28_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update arc102019 set ";
    $virgula = "";
    if (trim($this->si28_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_sequencial"])) {
      if (trim($this->si28_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si28_sequencial"])) {
        $this->si28_sequencial = "0";
      }
      $sql .= $virgula . " si28_sequencial = $this->si28_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si28_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_tiporegistro"])) {
      $sql .= $virgula . " si28_tiporegistro = $this->si28_tiporegistro ";
      $virgula = ",";
      if (trim($this->si28_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si28_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si28_codcorrecao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_codcorrecao"])) {
      if (trim($this->si28_codcorrecao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si28_codcorrecao"])) {
        $this->si28_codcorrecao = "0";
      }
      $sql .= $virgula . " si28_codcorrecao = $this->si28_codcorrecao ";
      $virgula = ",";
    }
    if (trim($this->si28_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_codorgao"])) {
      $sql .= $virgula . " si28_codorgao = '$this->si28_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si28_ededucaodereceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_ededucaodereceita"])) {
      if (trim($this->si28_ededucaodereceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si28_ededucaodereceita"])) {
        $this->si28_ededucaodereceita = "0";
      }
      $sql .= $virgula . " si28_ededucaodereceita = $this->si28_ededucaodereceita ";
      $virgula = ",";
    }
    if (trim($this->si28_identificadordeducaorecreduzida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_identificadordeducaorecreduzida"])) {
      if (trim($this->si28_identificadordeducaorecreduzida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si28_identificadordeducaorecreduzida"])) {
        $this->si28_identificadordeducaorecreduzida = "0";
      }
      $sql .= $virgula . " si28_identificadordeducaorecreduzida = $this->si28_identificadordeducaorecreduzida ";
      $virgula = ",";
    }
    if (trim($this->si28_naturezareceitareduzida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_naturezareceitareduzida"])) {
      if (trim($this->si28_naturezareceitareduzida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si28_naturezareceitareduzida"])) {
        $this->si28_naturezareceitareduzida = "0";
      }
      $sql .= $virgula . " si28_naturezareceitareduzida = $this->si28_naturezareceitareduzida ";
      $virgula = ",";
    }
    if (trim($this->si28_especificacaoreduzida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_especificacaoreduzida"])) {
      $sql .= $virgula . " si28_especificacaoreduzida = '$this->si28_especificacaoreduzida' ";
      $virgula = ",";
    }
    if (trim($this->si28_identificadordeducaorecacrescida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_identificadordeducaorecacrescida"])) {
      if (trim($this->si28_identificadordeducaorecacrescida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si28_identificadordeducaorecacrescida"])) {
        $this->si28_identificadordeducaorecacrescida = "0";
      }
      $sql .= $virgula . " si28_identificadordeducaorecacrescida = $this->si28_identificadordeducaorecacrescida ";
      $virgula = ",";
    }
    if (trim($this->si28_naturezareceitaacrescida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_naturezareceitaacrescida"])) {
      if (trim($this->si28_naturezareceitaacrescida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si28_naturezareceitaacrescida"])) {
        $this->si28_naturezareceitaacrescida = "0";
      }
      $sql .= $virgula . " si28_naturezareceitaacrescida = $this->si28_naturezareceitaacrescida ";
      $virgula = ",";
    }
    if (trim($this->si28_especificacaoacrescida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_especificacaoacrescida"])) {
      $sql .= $virgula . " si28_especificacaoacrescida = '$this->si28_especificacaoacrescida' ";
      $virgula = ",";
    }
    if (trim($this->si28_vlreduzidoacrescido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_vlreduzidoacrescido"])) {
      if (trim($this->si28_vlreduzidoacrescido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si28_vlreduzidoacrescido"])) {
        $this->si28_vlreduzidoacrescido = "0";
      }
      $sql .= $virgula . " si28_vlreduzidoacrescido = $this->si28_vlreduzidoacrescido ";
      $virgula = ",";
    }
    if (trim($this->si28_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_mes"])) {
      $sql .= $virgula . " si28_mes = $this->si28_mes ";
      $virgula = ",";
      if (trim($this->si28_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si28_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si28_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si28_instit"])) {
      $sql .= $virgula . " si28_instit = $this->si28_instit ";
      $virgula = ",";
      if (trim($this->si28_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si28_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si28_sequencial != null) {
      $sql .= " si28_sequencial = $this->si28_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si28_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009690,'$this->si28_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_sequencial"]) || $this->si28_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009690,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_sequencial')) . "','$this->si28_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_tiporegistro"]) || $this->si28_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009691,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_tiporegistro')) . "','$this->si28_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_codcorrecao"]) || $this->si28_codcorrecao != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009692,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_codcorrecao')) . "','$this->si28_codcorrecao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_codorgao"]) || $this->si28_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009693,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_codorgao')) . "','$this->si28_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_ededucaodereceita"]) || $this->si28_ededucaodereceita != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009694,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_ededucaodereceita')) . "','$this->si28_ededucaodereceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_identificadordeducaorecreduzida"]) || $this->si28_identificadordeducaorecreduzida != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009695,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_identificadordeducaorecreduzida')) . "','$this->si28_identificadordeducaorecreduzida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_naturezareceitareduzida"]) || $this->si28_naturezareceitareduzida != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009696,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_naturezareceitareduzida')) . "','$this->si28_naturezareceitareduzida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_especificacaoreduzida"]) || $this->si28_especificacaoreduzida != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009697,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_especificacaoreduzida')) . "','$this->si28_especificacaoreduzida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_identificadordeducaorecacrescida"]) || $this->si28_identificadordeducaorecacrescida != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009699,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_identificadordeducaorecacrescida')) . "','$this->si28_identificadordeducaorecacrescida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_naturezareceitaacrescida"]) || $this->si28_naturezareceitaacrescida != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009700,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_naturezareceitaacrescida')) . "','$this->si28_naturezareceitaacrescida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_especificacaoacrescida"]) || $this->si28_especificacaoacrescida != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009701,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_especificacaoacrescida')) . "','$this->si28_especificacaoacrescida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_vlreduzidoacrescido"]) || $this->si28_vlreduzidoacrescido != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009702,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_vlreduzidoacrescido')) . "','$this->si28_vlreduzidoacrescido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_mes"]) || $this->si28_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2009745,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_mes')) . "','$this->si28_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si28_instit"]) || $this->si28_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010256,2011543,'" . AddSlashes(pg_result($resaco, $conresaco, 'si28_instit')) . "','$this->si28_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "arc102019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si28_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "arc102019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si28_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si28_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si28_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si28_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009690,'$si28_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010256,2009690,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009691,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009692,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_codcorrecao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009693,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009694,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009695,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_identificadordeducaorecreduzida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009696,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_naturezareceitareduzida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009697,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_especificacaoreduzida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009699,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_identificadordeducaorecacrescida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009700,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_naturezareceitaacrescida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009701,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_especificacaoacrescida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009702,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_vlreduzidoacrescido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2009745,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010256,2011543,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si28_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from arc102019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si28_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si28_sequencial = $si28_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "arc102019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si28_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "arc102019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si28_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si28_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:arc102019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si28_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from arc102019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si28_sequencial != null) {
        $sql2 .= " where arc102019.si28_sequencial = $si28_sequencial ";
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
  function sql_query_file($si28_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from arc102019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si28_sequencial != null) {
        $sql2 .= " where arc102019.si28_sequencial = $si28_sequencial ";
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
