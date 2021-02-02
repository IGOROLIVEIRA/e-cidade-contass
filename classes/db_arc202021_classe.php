<?
//MODULO: sicom
//CLASSE DA ENTIDADE arc202021
class cl_arc202021
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
  var $si31_sequencial = 0;
  var $si31_tiporegistro = 0;
  var $si31_codorgao = null;
  var $si31_codestorno = 0;
  var $si31_ededucaodereceita = 0;
  var $si31_identificadordeducao = 0;
  var $si31_naturezareceitaestornada = 0;
  var $si31_regularizacaorepasseestornada = 0;
  var $si31_exercicioestornada = null;
  var $si31_emendaparlamentarestornada = 0;
  var $si31_vlestornado = 0;
  var $si31_mes = 0;
  var $si31_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si31_sequencial = int8 = sequencial
                 si31_tiporegistro = int8 = Tipo do  registro
                 si31_codorgao = varchar(2) = Código do órgão
                 si31_codestorno = int8 = Código estorno
                 si31_ededucaodereceita = int8 = Identifica
                 si31_identificadordeducao = int8 = Identificador
                 si31_naturezareceitaestornada = int8 = Natureza da receita
                 si31_regularizacaorepasseestornada = int8 = Regularização de Repasse
                 si31_exercicioestornada = varchar(4) = Exercício
                 si31_emendaparlamentarestornada = int8 = Emenda Parlamentar
                 si31_vlestornado = float8 = Valor estornado
                 si31_mes = int8 = Mês
                 si31_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_arc202021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("arc202021");
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
      $this->si31_sequencial = ($this->si31_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_sequencial"] : $this->si31_sequencial);
      $this->si31_tiporegistro = ($this->si31_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_tiporegistro"] : $this->si31_tiporegistro);
      $this->si31_codorgao = ($this->si31_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_codorgao"] : $this->si31_codorgao);
      $this->si31_codestorno = ($this->si31_codestorno == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_codestorno"] : $this->si31_codestorno);
      $this->si31_ededucaodereceita = ($this->si31_ededucaodereceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_ededucaodereceita"] : $this->si31_ededucaodereceita);
      $this->si31_identificadordeducao = ($this->si31_identificadordeducao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_identificadordeducao"] : $this->si31_identificadordeducao);
      $this->si31_naturezareceitaestornada = ($this->si31_naturezareceitaestornada == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_naturezareceitaestornada"] : $this->si31_naturezareceitaestornada);
      $this->si31_regularizacaorepasseestornada = ($this->si31_regularizacaorepasseestornada == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_regularizacaorepasseestornada"] : $this->si31_regularizacaorepasseestornada);
      $this->si31_exercicioestornada = ($this->si31_exercicioestornada == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_exercicioestornada"] : $this->si31_exercicioestornada);
      $this->si31_emendaparlamentarestornada = ($this->si31_emendaparlamentarestornada == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_emendaparlamentarestornada"] : $this->si31_emendaparlamentarestornada);
      $this->si31_vlestornado = ($this->si31_vlestornado == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_vlestornado"] : $this->si31_vlestornado);
      $this->si31_mes = ($this->si31_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_mes"] : $this->si31_mes);
      $this->si31_instit = ($this->si31_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_instit"] : $this->si31_instit);
    } else {
      $this->si31_sequencial = ($this->si31_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si31_sequencial"] : $this->si31_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si31_sequencial)
  {
    $this->atualizacampos();

    if ($this->si31_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si31_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si31_codorgao == null) {
      $this->erro_sql = " Campo Código do Órgão não Informado.";
      $this->erro_campo = "si31_codorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si31_codestorno == null) {
      $this->erro_sql = " Campo Código do Estorno não Informado.";
      $this->erro_campo = "si31_codestorno";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si31_ededucaodereceita == null) {
      $this->erro_sql = " Campo Dedução de Receita não Informado.";
      $this->erro_campo = "si31_ededucaodereceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
    }
    // if ($this->si31_identificadordeducao == null) {
    //   $this->si31_identificadordeducao = "0";
    // }
    // if ($this->si31_naturezareceitaestornada == null) {
    //   $this->erro_sql = " Campo Natureza da Receita Estornada não Informado.";
    //   $this->erro_campo = "si31_naturezareceitaestornada";
    //   $this->erro_banco = "";
    //   $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    //   $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    //   $this->erro_status = "0";

    // }
    if ($this->si31_regularizacaorepasseestornada == null) {
        $this->si31_regularizacaorepasseestornada = "0";
      }
      if ($this->si31_exercicioestornada == null) {
        $this->si31_exercicioestornada = "0";
      }
      if ($this->si31_emendaparlamentarestornada == null) {
        $this->si31_emendaparlamentarestornada = "0";
      }
    if ($this->si31_vlestornado == null) {
      $this->erro_sql = " Campo Valor Estornado na Natureza de Receita não Informado.";
      $this->erro_campo = "si31_vlestornado";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si31_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si31_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si31_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si31_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($si31_sequencial == "" || $si31_sequencial == null) {

      $result = db_query("select nextval('arc202021_si31_sequencial_seq')");


      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: arc202021_si31_sequencial_seq do campo: si31_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si31_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from arc202021_si31_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si31_sequencial)) {
        $this->erro_sql = " Campo si31_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si31_sequencial = $si31_sequencial;
      }
    }
    if (($this->si31_sequencial == null) || ($this->si31_sequencial == "")) {
      $this->erro_sql = " Campo si31_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into arc202021(
                                       si31_sequencial
                                      ,si31_tiporegistro
                                      ,si31_codorgao
                                      ,si31_codestorno
                                      ,si31_ededucaodereceita
                                      ,si31_identificadordeducao
                                      ,si31_naturezareceitaestornada
                                      ,si31_regularizacaorepasseestornada
                                      ,si31_exercicioestornada
                                      ,si31_emendaparlamentarestornada
                                      ,si31_vlestornado
                                      ,si31_mes
                                      ,si31_instit
                       )
                values (
                                $this->si31_sequencial
                               ,$this->si31_tiporegistro
                               ,'$this->si31_codorgao'
                               ,$this->si31_codestorno
                               ,$this->si31_ededucaodereceita
                               ,$this->si31_identificadordeducao
                               ,$this->si31_naturezareceitaestornada
                               ,$this->si31_regularizacaorepasseestornada
                               ,$this->si31_exercicioestornada
                               ,$this->si31_emendaparlamentarestornada
                               ,$this->si31_vlestornado
                               ,$this->si31_mes
                               ,$this->si31_instit
                      )";


    $result = db_query($sql);

    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "arc202021 ($this->si31_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "arc202021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "arc202021 ($this->si31_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si31_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
//    $resaco = $this->sql_record($this->sql_query_file($this->si31_sequencial));
//    if (($resaco != false) || ($this->numrows != 0)) {
//      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//      $acount = pg_result($resac, 0, 0);
//      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//      $resac = db_query("insert into db_acountkey values($acount,2009715,'$this->si31_sequencial','I')");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009715,'','" . AddSlashes(pg_result($resaco, 0, 'si31_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009716,'','" . AddSlashes(pg_result($resaco, 0, 'si31_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009717,'','" . AddSlashes(pg_result($resaco, 0, 'si31_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009718,'','" . AddSlashes(pg_result($resaco, 0, 'si31_codestorno')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009719,'','" . AddSlashes(pg_result($resaco, 0, 'si31_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009720,'','" . AddSlashes(pg_result($resaco, 0, 'si31_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009721,'','" . AddSlashes(pg_result($resaco, 0, 'si31_naturezareceitaestornada')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009722,'','" . AddSlashes(pg_result($resaco, 0, 'si31_especificacaoestornada')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009723,'','" . AddSlashes(pg_result($resaco, 0, 'si31_vlestornado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2009748,'','" . AddSlashes(pg_result($resaco, 0, 'si31_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010259,2011546,'','" . AddSlashes(pg_result($resaco, 0, 'si31_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//    }

    return true;
  }

  // funcao para alteracao
  function alterar($si31_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update arc202021 set ";
    $virgula = "";
    if (trim($this->si31_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_sequencial"])) {
      if (trim($this->si31_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si31_sequencial"])) {
        $this->si31_sequencial = "0";
      }
      $sql .= $virgula . " si31_sequencial = $this->si31_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si31_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_tiporegistro"])) {
      $sql .= $virgula . " si31_tiporegistro = $this->si31_tiporegistro ";
      $virgula = ",";
      if (trim($this->si31_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si31_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si31_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_codorgao"])) {
      $sql .= $virgula . " si31_codorgao = '$this->si31_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si31_codestorno) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_codestorno"])) {
      if (trim($this->si31_codestorno) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si31_codestorno"])) {
        $this->si31_codestorno = "0";
      }
      $sql .= $virgula . " si31_codestorno = $this->si31_codestorno ";
      $virgula = ",";
    }
    if (trim($this->si31_ededucaodereceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_ededucaodereceita"])) {
      if (trim($this->si31_ededucaodereceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si31_ededucaodereceita"])) {
        $this->si31_ededucaodereceita = "0";
      }
      $sql .= $virgula . " si31_ededucaodereceita = $this->si31_ededucaodereceita ";
      $virgula = ",";
    }
    if (trim($this->si31_identificadordeducao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_identificadordeducao"])) {
      if (trim($this->si31_identificadordeducao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si31_identificadordeducao"])) {
        $this->si31_identificadordeducao = "0";
      }
      $sql .= $virgula . " si31_identificadordeducao = $this->si31_identificadordeducao ";
      $virgula = ",";
    }
    if (trim($this->si31_naturezareceitaestornada) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_naturezareceitaestornada"])) {
      if (trim($this->si31_naturezareceitaestornada) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si31_naturezareceitaestornada"])) {
        $this->si31_naturezareceitaestornada = "0";
      }
      $sql .= $virgula . " si31_naturezareceitaestornada = $this->si31_naturezareceitaestornada ";
      $virgula = ",";
    }
    if (trim($this->si31_regularizacaorepasseestornada) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_regularizacaorepasseestornada"])) {
        if (trim($this->si31_regularizacaorepasseestornada) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si31_regularizacaorepasseestornada"])) {
            $this->si31_regularizacaorepasseestornada = "0";
        }
        $sql .= $virgula . " si31_regularizacaorepasseestornada = $this->si31_regularizacaorepasseestornada ";
        $virgula = ",";
        }
    if (trim($this->si31_exercicioestornada) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_exercicioestornada"])) {
        if (trim($this->si31_exercicioestornada) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si31_exercicioestornada"])) {
            $this->si31_exercicioestornada = "0";
        }
        $sql .= $virgula . " si31_exercicioestornada = $this->si31_exercicioestornada ";
        $virgula = ",";
        }
    if (trim($this->si31_emendaparlamentarestornada) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_emendaparlamentarestornada"])) {
        if (trim($this->si31_emendaparlamentarestornada) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si31_emendaparlamentarestornada"])) {
            $this->si31_emendaparlamentarestornada = "0";
        }
        $sql .= $virgula . " si31_emendaparlamentarestornada = $this->si31_emendaparlamentarestornada ";
        $virgula = ",";
    }
    if (trim($this->si31_vlestornado) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_vlestornado"])) {
      if (trim($this->si31_vlestornado) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si31_vlestornado"])) {
        $this->si31_vlestornado = "0";
      }
      $sql .= $virgula . " si31_vlestornado = $this->si31_vlestornado ";
      $virgula = ",";
    }
    if (trim($this->si31_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_mes"])) {
      $sql .= $virgula . " si31_mes = $this->si31_mes ";
      $virgula = ",";
      if (trim($this->si31_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si31_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si31_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si31_instit"])) {
      $sql .= $virgula . " si31_instit = $this->si31_instit ";
      $virgula = ",";
      if (trim($this->si31_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si31_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si31_sequencial != null) {
      $sql .= " si31_sequencial = $this->si31_sequencial";
    }
//    $resaco = $this->sql_record($this->sql_query_file($this->si31_sequencial));
//    if ($this->numrows > 0) {
//      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2009715,'$this->si31_sequencial','A')");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_sequencial"]) || $this->si31_sequencial != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009715,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_sequencial')) . "','$this->si31_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_tiporegistro"]) || $this->si31_tiporegistro != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009716,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_tiporegistro')) . "','$this->si31_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_codorgao"]) || $this->si31_codorgao != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009717,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_codorgao')) . "','$this->si31_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_codestorno"]) || $this->si31_codestorno != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009718,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_codestorno')) . "','$this->si31_codestorno'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_ededucaodereceita"]) || $this->si31_ededucaodereceita != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009719,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_ededucaodereceita')) . "','$this->si31_ededucaodereceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_identificadordeducao"]) || $this->si31_identificadordeducao != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009720,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_identificadordeducao')) . "','$this->si31_identificadordeducao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_naturezareceitaestornada"]) || $this->si31_naturezareceitaestornada != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009721,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_naturezareceitaestornada')) . "','$this->si31_naturezareceitaestornada'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_especificacaoestornada"]) || $this->si31_especificacaoestornada != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009722,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_especificacaoestornada')) . "','$this->si31_especificacaoestornada'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_vlestornado"]) || $this->si31_vlestornado != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009723,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_vlestornado')) . "','$this->si31_vlestornado'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_mes"]) || $this->si31_mes != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2009748,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_mes')) . "','$this->si31_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si31_instit"]) || $this->si31_instit != "")
//          $resac = db_query("insert into db_acount values($acount,2010259,2011546,'" . AddSlashes(pg_result($resaco, $conresaco, 'si31_instit')) . "','$this->si31_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
//    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "arc202021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si31_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "arc202021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si31_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si31_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si31_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si31_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
//    if (($resaco != false) || ($this->numrows != 0)) {
//      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2009715,'$si31_sequencial','E')");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009715,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009716,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009717,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009718,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_codestorno')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009719,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009720,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009721,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_naturezareceitaestornada')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009722,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_especificacaoestornada')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009723,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_vlestornado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2009748,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010259,2011546,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si31_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
//    }
    $sql = " delete from arc202021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si31_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si31_sequencial = $si31_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "arc202021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si31_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "arc202021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si31_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si31_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:arc202021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si31_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from arc202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si31_sequencial != null) {
        $sql2 .= " where arc202021.si31_sequencial = $si31_sequencial ";
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
  function sql_query_file($si31_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from arc202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si31_sequencial != null) {
        $sql2 .= " where arc202021.si31_sequencial = $si31_sequencial ";
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
