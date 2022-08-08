<?
//MODULO: sicom
//CLASSE DA ENTIDADE regadesao102018
class cl_regadesao102018
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
  var $si67_sequencial = 0;
  var $si67_tiporegistro = 0;
  var $si67_codorgao = null;
  var $si67_codunidadesub = null;
  var $si67_nroprocadesao = null;
  var $si63_exercicioadesao = 0;
  var $si67_dtabertura_dia = null;
  var $si67_dtabertura_mes = null;
  var $si67_dtabertura_ano = null;
  var $si67_dtabertura = null;
  var $si67_nomeorgaogerenciador = null;
  var $si67_exerciciolicitacao = 0;
  var $si67_nroprocessolicitatorio = null;
  var $si67_codmodalidadelicitacao = 0;
  var $si67_nromodalidade = 0;
  var $si67_dtataregpreco_dia = null;
  var $si67_dtataregpreco_mes = null;
  var $si67_dtataregpreco_ano = null;
  var $si67_dtataregpreco = null;
  var $si67_dtvalidade_dia = null;
  var $si67_dtvalidade_mes = null;
  var $si67_dtvalidade_ano = null;
  var $si67_dtvalidade = null;
  var $si67_naturezaprocedimento = 0;
  var $si67_dtpublicacaoavisointencao_dia = null;
  var $si67_dtpublicacaoavisointencao_mes = null;
  var $si67_dtpublicacaoavisointencao_ano = null;
  var $si67_dtpublicacaoavisointencao = null;
  var $si67_objetoadesao = null;
  var $si67_cpfresponsavel = null;
  var $si67_descontotabela = 0;
  var $si67_processoporlote = 0;
  var $si67_mes = 0;
  var $si67_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si67_sequencial = int8 = sequencial 
                 si67_tiporegistro = int8 = Tipo do  registro 
                 si67_codorgao = varchar(2) = Código do órgão 
                 si67_codunidadesub = varchar(8) = Código da unidade 
                 si67_nroprocadesao = varchar(12) = Número do  processo de  adesão 
                 si63_exercicioadesao = int8 = Exercício do processo de adesão 
                 si67_dtabertura = date = Data de abertura  do processo 
                 si67_nomeorgaogerenciador = varchar(100) = Nome do órgão 
                 si67_exerciciolicitacao = int8 = Exercício em que   foi instaurado 
                 si67_nroprocessolicitatorio = varchar(20) = Número sequencial  do processo 
                 si67_codmodalidadelicitacao = int8 = Modalidade da Licitação 
                 si67_nromodalidade = int8 = Número sequencial da Modalidade 
                 si67_dtataregpreco = date = Data da Ata do  Registro de Preços 
                 si67_dtvalidade = date = Data de validade 
                 si67_naturezaprocedimento = int8 = Natureza do Procedimento 
                 si67_dtpublicacaoavisointencao = date = Data de publicação  do aviso 
                 si67_objetoadesao = varchar(500) = Objeto da Adesão 
                 si67_cpfresponsavel = varchar(11) = CPF do  responsável 
                 si67_descontotabela = int8 = Desconto Tabela 
                 si67_processoporlote = int8 = Processo por Lote 
                 si67_mes = int8 = Mês 
                 si67_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_regadesao102018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("regadesao102018");
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
      $this->si67_sequencial = ($this->si67_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_sequencial"] : $this->si67_sequencial);
      $this->si67_tiporegistro = ($this->si67_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_tiporegistro"] : $this->si67_tiporegistro);
      $this->si67_codorgao = ($this->si67_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_codorgao"] : $this->si67_codorgao);
      $this->si67_codunidadesub = ($this->si67_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_codunidadesub"] : $this->si67_codunidadesub);
      $this->si67_nroprocadesao = ($this->si67_nroprocadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_nroprocadesao"] : $this->si67_nroprocadesao);
      $this->si63_exercicioadesao = ($this->si63_exercicioadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si63_exercicioadesao"] : $this->si63_exercicioadesao);
      if ($this->si67_dtabertura == "") {
        $this->si67_dtabertura_dia = ($this->si67_dtabertura_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtabertura_dia"] : $this->si67_dtabertura_dia);
        $this->si67_dtabertura_mes = ($this->si67_dtabertura_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtabertura_mes"] : $this->si67_dtabertura_mes);
        $this->si67_dtabertura_ano = ($this->si67_dtabertura_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtabertura_ano"] : $this->si67_dtabertura_ano);
        if ($this->si67_dtabertura_dia != "") {
          $this->si67_dtabertura = $this->si67_dtabertura_ano . "-" . $this->si67_dtabertura_mes . "-" . $this->si67_dtabertura_dia;
        }
      }
      $this->si67_nomeorgaogerenciador = ($this->si67_nomeorgaogerenciador == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_nomeorgaogerenciador"] : $this->si67_nomeorgaogerenciador);
      $this->si67_exerciciolicitacao = ($this->si67_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_exerciciolicitacao"] : $this->si67_exerciciolicitacao);
      $this->si67_nroprocessolicitatorio = ($this->si67_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_nroprocessolicitatorio"] : $this->si67_nroprocessolicitatorio);
      $this->si67_codmodalidadelicitacao = ($this->si67_codmodalidadelicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_codmodalidadelicitacao"] : $this->si67_codmodalidadelicitacao);
      $this->si67_nromodalidade = ($this->si67_nromodalidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_nromodalidade"] : $this->si67_nromodalidade);
      if ($this->si67_dtataregpreco == "") {
        $this->si67_dtataregpreco_dia = ($this->si67_dtataregpreco_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtataregpreco_dia"] : $this->si67_dtataregpreco_dia);
        $this->si67_dtataregpreco_mes = ($this->si67_dtataregpreco_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtataregpreco_mes"] : $this->si67_dtataregpreco_mes);
        $this->si67_dtataregpreco_ano = ($this->si67_dtataregpreco_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtataregpreco_ano"] : $this->si67_dtataregpreco_ano);
        if ($this->si67_dtataregpreco_dia != "") {
          $this->si67_dtataregpreco = $this->si67_dtataregpreco_ano . "-" . $this->si67_dtataregpreco_mes . "-" . $this->si67_dtataregpreco_dia;
        }
      }
      if ($this->si67_dtvalidade == "") {
        $this->si67_dtvalidade_dia = ($this->si67_dtvalidade_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtvalidade_dia"] : $this->si67_dtvalidade_dia);
        $this->si67_dtvalidade_mes = ($this->si67_dtvalidade_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtvalidade_mes"] : $this->si67_dtvalidade_mes);
        $this->si67_dtvalidade_ano = ($this->si67_dtvalidade_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtvalidade_ano"] : $this->si67_dtvalidade_ano);
        if ($this->si67_dtvalidade_dia != "") {
          $this->si67_dtvalidade = $this->si67_dtvalidade_ano . "-" . $this->si67_dtvalidade_mes . "-" . $this->si67_dtvalidade_dia;
        }
      }
      $this->si67_naturezaprocedimento = ($this->si67_naturezaprocedimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_naturezaprocedimento"] : $this->si67_naturezaprocedimento);
      if ($this->si67_dtpublicacaoavisointencao == "") {
        $this->si67_dtpublicacaoavisointencao_dia = ($this->si67_dtpublicacaoavisointencao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtpublicacaoavisointencao_dia"] : $this->si67_dtpublicacaoavisointencao_dia);
        $this->si67_dtpublicacaoavisointencao_mes = ($this->si67_dtpublicacaoavisointencao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtpublicacaoavisointencao_mes"] : $this->si67_dtpublicacaoavisointencao_mes);
        $this->si67_dtpublicacaoavisointencao_ano = ($this->si67_dtpublicacaoavisointencao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_dtpublicacaoavisointencao_ano"] : $this->si67_dtpublicacaoavisointencao_ano);
        if ($this->si67_dtpublicacaoavisointencao_dia != "") {
          $this->si67_dtpublicacaoavisointencao = $this->si67_dtpublicacaoavisointencao_ano . "-" . $this->si67_dtpublicacaoavisointencao_mes . "-" . $this->si67_dtpublicacaoavisointencao_dia;
        }
      }
      $this->si67_objetoadesao = ($this->si67_objetoadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_objetoadesao"] : $this->si67_objetoadesao);
      $this->si67_cpfresponsavel = ($this->si67_cpfresponsavel == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_cpfresponsavel"] : $this->si67_cpfresponsavel);
      $this->si67_descontotabela = ($this->si67_descontotabela == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_descontotabela"] : $this->si67_descontotabela);
      $this->si67_processoporlote = ($this->si67_processoporlote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_processoporlote"] : $this->si67_processoporlote);
      $this->si67_mes = ($this->si67_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_mes"] : $this->si67_mes);
      $this->si67_instit = ($this->si67_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_instit"] : $this->si67_instit);
    } else {
      $this->si67_sequencial = ($this->si67_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si67_sequencial"] : $this->si67_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si67_sequencial)
  {
    $this->atualizacampos();
    if ($this->si67_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si67_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si63_exercicioadesao == null) {
      $this->si63_exercicioadesao = "0";
    }
    if ($this->si67_dtabertura == null) {
      $this->si67_dtabertura = "null";
    }
    if ($this->si67_exerciciolicitacao == null) {
      $this->si67_exerciciolicitacao = "0";
    }
    if ($this->si67_codmodalidadelicitacao == null) {
      $this->si67_codmodalidadelicitacao = "0";
    }
    if ($this->si67_nromodalidade == null) {
      $this->si67_nromodalidade = "0";
    }
    if ($this->si67_dtataregpreco == null) {
      $this->si67_dtataregpreco = "null";
    }
    if ($this->si67_dtvalidade == null) {
      $this->si67_dtvalidade = "null";
    }
    if ($this->si67_naturezaprocedimento == null) {
      $this->si67_naturezaprocedimento = "0";
    }
    if ($this->si67_dtpublicacaoavisointencao == null) {
      $this->si67_dtpublicacaoavisointencao = "null";
    }
    if ($this->si67_descontotabela == null) {
      $this->si67_descontotabela = "0";
    }
    if ($this->si67_processoporlote == null) {
      $this->si67_processoporlote = "0";
    }
    if ($this->si67_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si67_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si67_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si67_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si67_sequencial == "" || $si67_sequencial == null) {
      $result = db_query("select nextval('regadesao102018_si67_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: regadesao102018_si67_sequencial_seq do campo: si67_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si67_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from regadesao102018_si67_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si67_sequencial)) {
        $this->erro_sql = " Campo si67_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si67_sequencial = $si67_sequencial;
      }
    }
    if (($this->si67_sequencial == null) || ($this->si67_sequencial == "")) {
      $this->erro_sql = " Campo si67_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into regadesao102018(
                                       si67_sequencial 
                                      ,si67_tiporegistro 
                                      ,si67_codorgao 
                                      ,si67_codunidadesub 
                                      ,si67_nroprocadesao 
                                      ,si63_exercicioadesao 
                                      ,si67_dtabertura 
                                      ,si67_nomeorgaogerenciador 
                                      ,si67_exerciciolicitacao 
                                      ,si67_nroprocessolicitatorio 
                                      ,si67_codmodalidadelicitacao 
                                      ,si67_nromodalidade 
                                      ,si67_dtataregpreco 
                                      ,si67_dtvalidade 
                                      ,si67_naturezaprocedimento 
                                      ,si67_dtpublicacaoavisointencao 
                                      ,si67_objetoadesao 
                                      ,si67_cpfresponsavel 
                                      ,si67_descontotabela 
                                      ,si67_processoporlote 
                                      ,si67_mes 
                                      ,si67_instit 
                       )
                values (
                                $this->si67_sequencial 
                               ,$this->si67_tiporegistro 
                               ,'$this->si67_codorgao' 
                               ,'$this->si67_codunidadesub' 
                               ,'$this->si67_nroprocadesao' 
                               ,$this->si63_exercicioadesao 
                               ," . ($this->si67_dtabertura == "null" || $this->si67_dtabertura == "" ? "null" : "'" . $this->si67_dtabertura . "'") . " 
                               ,'$this->si67_nomeorgaogerenciador' 
                               ,$this->si67_exerciciolicitacao 
                               ,'$this->si67_nroprocessolicitatorio' 
                               ,$this->si67_codmodalidadelicitacao 
                               ,$this->si67_nromodalidade 
                               ," . ($this->si67_dtataregpreco == "null" || $this->si67_dtataregpreco == "" ? "null" : "'" . $this->si67_dtataregpreco . "'") . " 
                               ," . ($this->si67_dtvalidade == "null" || $this->si67_dtvalidade == "" ? "null" : "'" . $this->si67_dtvalidade . "'") . " 
                               ,$this->si67_naturezaprocedimento 
                               ," . ($this->si67_dtpublicacaoavisointencao == "null" || $this->si67_dtpublicacaoavisointencao == "" ? "null" : "'" . $this->si67_dtpublicacaoavisointencao . "'") . " 
                               ,'$this->si67_objetoadesao' 
                               ,'$this->si67_cpfresponsavel' 
                               ,$this->si67_descontotabela 
                               ,$this->si67_processoporlote 
                               ,$this->si67_mes 
                               ,$this->si67_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "regadesao102018 ($this->si67_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "regadesao102018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "regadesao102018 ($this->si67_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si67_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si67_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010164,'$this->si67_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010296,2010164,'','" . AddSlashes(pg_result($resaco, 0, 'si67_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010165,'','" . AddSlashes(pg_result($resaco, 0, 'si67_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010166,'','" . AddSlashes(pg_result($resaco, 0, 'si67_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010167,'','" . AddSlashes(pg_result($resaco, 0, 'si67_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010168,'','" . AddSlashes(pg_result($resaco, 0, 'si67_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2011310,'','" . AddSlashes(pg_result($resaco, 0, 'si63_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010169,'','" . AddSlashes(pg_result($resaco, 0, 'si67_dtabertura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010170,'','" . AddSlashes(pg_result($resaco, 0, 'si67_nomeorgaogerenciador')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010171,'','" . AddSlashes(pg_result($resaco, 0, 'si67_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010172,'','" . AddSlashes(pg_result($resaco, 0, 'si67_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010173,'','" . AddSlashes(pg_result($resaco, 0, 'si67_codmodalidadelicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010174,'','" . AddSlashes(pg_result($resaco, 0, 'si67_nromodalidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010175,'','" . AddSlashes(pg_result($resaco, 0, 'si67_dtataregpreco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010176,'','" . AddSlashes(pg_result($resaco, 0, 'si67_dtvalidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010177,'','" . AddSlashes(pg_result($resaco, 0, 'si67_naturezaprocedimento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010178,'','" . AddSlashes(pg_result($resaco, 0, 'si67_dtpublicacaoavisointencao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010179,'','" . AddSlashes(pg_result($resaco, 0, 'si67_objetoadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010180,'','" . AddSlashes(pg_result($resaco, 0, 'si67_cpfresponsavel')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010181,'','" . AddSlashes(pg_result($resaco, 0, 'si67_descontotabela')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010182,'','" . AddSlashes(pg_result($resaco, 0, 'si67_processoporlote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2010183,'','" . AddSlashes(pg_result($resaco, 0, 'si67_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010296,2011579,'','" . AddSlashes(pg_result($resaco, 0, 'si67_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si67_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update regadesao102018 set ";
    $virgula = "";
    if (trim($this->si67_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_sequencial"])) {
      if (trim($this->si67_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si67_sequencial"])) {
        $this->si67_sequencial = "0";
      }
      $sql .= $virgula . " si67_sequencial = $this->si67_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si67_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_tiporegistro"])) {
      $sql .= $virgula . " si67_tiporegistro = $this->si67_tiporegistro ";
      $virgula = ",";
      if (trim($this->si67_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si67_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si67_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_codorgao"])) {
      $sql .= $virgula . " si67_codorgao = '$this->si67_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si67_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_codunidadesub"])) {
      $sql .= $virgula . " si67_codunidadesub = '$this->si67_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si67_nroprocadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_nroprocadesao"])) {
      $sql .= $virgula . " si67_nroprocadesao = '$this->si67_nroprocadesao' ";
      $virgula = ",";
    }
    if (trim($this->si63_exercicioadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si63_exercicioadesao"])) {
      if (trim($this->si63_exercicioadesao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si63_exercicioadesao"])) {
        $this->si63_exercicioadesao = "0";
      }
      $sql .= $virgula . " si63_exercicioadesao = $this->si63_exercicioadesao ";
      $virgula = ",";
    }
    if (trim($this->si67_dtabertura) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_dtabertura_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si67_dtabertura_dia"] != "")) {
      $sql .= $virgula . " si67_dtabertura = '$this->si67_dtabertura' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si67_dtabertura_dia"])) {
        $sql .= $virgula . " si67_dtabertura = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si67_nomeorgaogerenciador) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_nomeorgaogerenciador"])) {
      $sql .= $virgula . " si67_nomeorgaogerenciador = '$this->si67_nomeorgaogerenciador' ";
      $virgula = ",";
    }
    if (trim($this->si67_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_exerciciolicitacao"])) {
      if (trim($this->si67_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si67_exerciciolicitacao"])) {
        $this->si67_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si67_exerciciolicitacao = $this->si67_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si67_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si67_nroprocessolicitatorio = '$this->si67_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si67_codmodalidadelicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_codmodalidadelicitacao"])) {
      if (trim($this->si67_codmodalidadelicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si67_codmodalidadelicitacao"])) {
        $this->si67_codmodalidadelicitacao = "0";
      }
      $sql .= $virgula . " si67_codmodalidadelicitacao = $this->si67_codmodalidadelicitacao ";
      $virgula = ",";
    }
    if (trim($this->si67_nromodalidade) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_nromodalidade"])) {
      if (trim($this->si67_nromodalidade) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si67_nromodalidade"])) {
        $this->si67_nromodalidade = "0";
      }
      $sql .= $virgula . " si67_nromodalidade = $this->si67_nromodalidade ";
      $virgula = ",";
    }
    if (trim($this->si67_dtataregpreco) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_dtataregpreco_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si67_dtataregpreco_dia"] != "")) {
      $sql .= $virgula . " si67_dtataregpreco = '$this->si67_dtataregpreco' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si67_dtataregpreco_dia"])) {
        $sql .= $virgula . " si67_dtataregpreco = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si67_dtvalidade) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_dtvalidade_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si67_dtvalidade_dia"] != "")) {
      $sql .= $virgula . " si67_dtvalidade = '$this->si67_dtvalidade' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si67_dtvalidade_dia"])) {
        $sql .= $virgula . " si67_dtvalidade = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si67_naturezaprocedimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_naturezaprocedimento"])) {
      if (trim($this->si67_naturezaprocedimento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si67_naturezaprocedimento"])) {
        $this->si67_naturezaprocedimento = "0";
      }
      $sql .= $virgula . " si67_naturezaprocedimento = $this->si67_naturezaprocedimento ";
      $virgula = ",";
    }
    if (trim($this->si67_dtpublicacaoavisointencao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_dtpublicacaoavisointencao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si67_dtpublicacaoavisointencao_dia"] != "")) {
      $sql .= $virgula . " si67_dtpublicacaoavisointencao = '$this->si67_dtpublicacaoavisointencao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si67_dtpublicacaoavisointencao_dia"])) {
        $sql .= $virgula . " si67_dtpublicacaoavisointencao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si67_objetoadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_objetoadesao"])) {
      $sql .= $virgula . " si67_objetoadesao = '$this->si67_objetoadesao' ";
      $virgula = ",";
    }
    if (trim($this->si67_cpfresponsavel) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_cpfresponsavel"])) {
      $sql .= $virgula . " si67_cpfresponsavel = '$this->si67_cpfresponsavel' ";
      $virgula = ",";
    }
    if (trim($this->si67_descontotabela) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_descontotabela"])) {
      if (trim($this->si67_descontotabela) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si67_descontotabela"])) {
        $this->si67_descontotabela = "0";
      }
      $sql .= $virgula . " si67_descontotabela = $this->si67_descontotabela ";
      $virgula = ",";
    }
    if (trim($this->si67_processoporlote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_processoporlote"])) {
      if (trim($this->si67_processoporlote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si67_processoporlote"])) {
        $this->si67_processoporlote = "0";
      }
      $sql .= $virgula . " si67_processoporlote = $this->si67_processoporlote ";
      $virgula = ",";
    }
    if (trim($this->si67_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_mes"])) {
      $sql .= $virgula . " si67_mes = $this->si67_mes ";
      $virgula = ",";
      if (trim($this->si67_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si67_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si67_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si67_instit"])) {
      $sql .= $virgula . " si67_instit = $this->si67_instit ";
      $virgula = ",";
      if (trim($this->si67_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si67_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si67_sequencial != null) {
      $sql .= " si67_sequencial = $this->si67_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si67_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010164,'$this->si67_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_sequencial"]) || $this->si67_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010164,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_sequencial')) . "','$this->si67_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_tiporegistro"]) || $this->si67_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010165,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_tiporegistro')) . "','$this->si67_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_codorgao"]) || $this->si67_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010166,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_codorgao')) . "','$this->si67_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_codunidadesub"]) || $this->si67_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010167,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_codunidadesub')) . "','$this->si67_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_nroprocadesao"]) || $this->si67_nroprocadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010168,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_nroprocadesao')) . "','$this->si67_nroprocadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si63_exercicioadesao"]) || $this->si63_exercicioadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2011310,'" . AddSlashes(pg_result($resaco, $conresaco, 'si63_exercicioadesao')) . "','$this->si63_exercicioadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_dtabertura"]) || $this->si67_dtabertura != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010169,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_dtabertura')) . "','$this->si67_dtabertura'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_nomeorgaogerenciador"]) || $this->si67_nomeorgaogerenciador != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010170,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_nomeorgaogerenciador')) . "','$this->si67_nomeorgaogerenciador'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_exerciciolicitacao"]) || $this->si67_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010171,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_exerciciolicitacao')) . "','$this->si67_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_nroprocessolicitatorio"]) || $this->si67_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010172,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_nroprocessolicitatorio')) . "','$this->si67_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_codmodalidadelicitacao"]) || $this->si67_codmodalidadelicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010173,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_codmodalidadelicitacao')) . "','$this->si67_codmodalidadelicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_nromodalidade"]) || $this->si67_nromodalidade != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010174,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_nromodalidade')) . "','$this->si67_nromodalidade'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_dtataregpreco"]) || $this->si67_dtataregpreco != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010175,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_dtataregpreco')) . "','$this->si67_dtataregpreco'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_dtvalidade"]) || $this->si67_dtvalidade != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010176,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_dtvalidade')) . "','$this->si67_dtvalidade'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_naturezaprocedimento"]) || $this->si67_naturezaprocedimento != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010177,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_naturezaprocedimento')) . "','$this->si67_naturezaprocedimento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_dtpublicacaoavisointencao"]) || $this->si67_dtpublicacaoavisointencao != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010178,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_dtpublicacaoavisointencao')) . "','$this->si67_dtpublicacaoavisointencao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_objetoadesao"]) || $this->si67_objetoadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010179,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_objetoadesao')) . "','$this->si67_objetoadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_cpfresponsavel"]) || $this->si67_cpfresponsavel != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010180,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_cpfresponsavel')) . "','$this->si67_cpfresponsavel'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_descontotabela"]) || $this->si67_descontotabela != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010181,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_descontotabela')) . "','$this->si67_descontotabela'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_processoporlote"]) || $this->si67_processoporlote != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010182,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_processoporlote')) . "','$this->si67_processoporlote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_mes"]) || $this->si67_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2010183,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_mes')) . "','$this->si67_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si67_instit"]) || $this->si67_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010296,2011579,'" . AddSlashes(pg_result($resaco, $conresaco, 'si67_instit')) . "','$this->si67_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao102018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si67_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao102018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si67_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si67_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si67_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si67_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010164,'$si67_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010296,2010164,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010165,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010166,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010167,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010168,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2011310,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si63_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010169,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_dtabertura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010170,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_nomeorgaogerenciador')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010171,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010172,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010173,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_codmodalidadelicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010174,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_nromodalidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010175,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_dtataregpreco')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010176,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_dtvalidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010177,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_naturezaprocedimento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010178,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_dtpublicacaoavisointencao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010179,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_objetoadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010180,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_cpfresponsavel')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010181,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_descontotabela')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010182,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_processoporlote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2010183,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010296,2011579,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si67_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from regadesao102018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si67_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si67_sequencial = $si67_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao102018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si67_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao102018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si67_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si67_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:regadesao102018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si67_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si67_sequencial != null) {
        $sql2 .= " where regadesao102018.si67_sequencial = $si67_sequencial ";
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
  function sql_query_file($si67_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si67_sequencial != null) {
        $sql2 .= " where regadesao102018.si67_sequencial = $si67_sequencial ";
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
