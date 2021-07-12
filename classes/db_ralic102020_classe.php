<?
//MODULO: sicom
//CLASSE DA ENTIDADE ralic102020
class cl_ralic102020
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
  var $si180_sequencial = 0;
  var $si180_tiporegistro = 0;
  var $si180_codorgaoresp = null;
  var $si180_codunidadesubresp = null;
  var $si180_codunidadesubrespestadual = null;
  var $si180_exerciciolicitacao = 0;
  var $si180_nroprocessolicitatorio = null;
  var $si180_tipocadastradolicitacao = null;
  var $si180_dsccadastrolicitatorio = '';
  var $si180_codmodalidadelicitacao = 0;
  var $si180_naturezaprocedimento = 0;
  var $si180_nroedital = 0;
  var $si180_exercicioedital = 0;
  var $si180_dtpublicacaoeditaldo_dia = null;
  var $si180_dtpublicacaoeditaldo_mes = null;
  var $si180_dtpublicacaoeditaldo_ano = null;
  var $si180_dtpublicacaoeditaldo = null;
  var $si180_link = '';
  var $si180_tipolicitacao = 0;
  var $si180_naturezaobjeto = 0;
  var $si180_objeto = null;
  var $si180_regimeexecucaoobras = 0;
  var $si180_vlcontratacao = 0;
  var $si180_bdi = 0;
  var $si180_mesexercicioreforc = 0;
  var $si180_origemrecurso = 0;
  var $si180_dscorigemrecurso = '';
  var $si180_mes = 0;
  var $si180_instit = 0;
  var $campos = "
                 si180_sequencial = int8 = sequencial
                 si180_tiporegistro = int8 = Tipo do registro
                 si180_codorgaoresp = varchar(2) = Código do órgão
                 si180_codunidadesubresp = varchar(8) = Código da unidade
                 si180_codunidadesubrespestadual = varchar(4) = Código da unidade responsável
                 si180_exerciciolicitacao = int8 = Exercício da licitação
                 si180_nroprocessolicitatorio = varchar(12) = Número sequencial do processo
                 si180_tipocadastradolicitacao = int(8) = Tipo de cadastro da licitação
                 si180_dsccadastrolicitatorio = varchar(150) = Motivo da anulação ou revogação
                 si180_codmodalidadelicitacao = int8 = Modalidade da Licitação
                 si180_naturezaprocedimento = int8 = Natureza do Procedimento
                 si180_nroedital = int8 = Número do edital
                 si180_exercicioedital = int8 = Exercício do edital
                 si180_dtpublicacaoeditaldo = date = Data de publicação do edital
                 si180_link = varchar(200) = Link da publicação de documentos
                 si180_tipolicitacao = int8 = Tipo de licitação
                 si180_naturezaobjeto = int8 = Natureza do objeto
                 si180_objeto = varchar(500) = Objeto da licitação
                 si180_regimeexecucaoobras = int8 = Regime de execução para obras
                 si180_vlcontratacao = real = Valor Estimado da contratação
                 si180_bdi = real = Percentual da Bonificação e Despesas
                 si180_mesexercicioreforc = int(4) = Percentual da Bonificação e Despesas
                 si180_origemrecurso = int(4) = Origem do recurso
                 si180_dscorigemrecurso = varchar(150) = Descrição da origem do recurso
                 si180_mes = int8 = Mês
                 si180_instit = int8 = Instituição
                 ";
  // cria propriedade com as variaveis do arquivo

  //funcao construtor da classe
  function cl_ralic102020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ralic102020");
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
      $this->si180_sequencial = ($this->si180_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_sequencial"] : $this->si180_sequencial);
      $this->si180_tiporegistro = ($this->si180_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_tiporegistro"] : $this->si180_tiporegistro);
      $this->si180_codorgaoresp = ($this->si180_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_codorgaoresp"] : $this->si180_codorgaoresp);
      $this->si180_codunidadesubresp = ($this->si180_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_codunidadesubresp"] : $this->si180_codunidadesubresp);
      $this->si180_exerciciolicitacao = ($this->si180_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_exerciciolicitacao"] : $this->si180_exerciciolicitacao);
      $this->si180_nroprocessolicitatorio = ($this->si180_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_nroprocessolicitatorio"] : $this->si180_nroprocessolicitatorio);
      $this->si180_tipocadastradolicitacao = ($this->si180_tipocadastradolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_tipocadastradolicitacao"] : $this->si180_tipocadastradolicitacao);
      $this->si180_dsccadastrolicitatorio = ($this->si180_dsccadastrolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_dsccadastrolicitatorio"] : $this->si180_dsccadastrolicitatorio);
      $this->si180_codmodalidadelicitacao = ($this->si180_codmodalidadelicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_codmodalidadelicitacao"] : $this->si180_codmodalidadelicitacao);
      $this->si180_naturezaprocedimento = ($this->si180_naturezaprocedimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_naturezaprocedimento"] : $this->si180_naturezaprocedimento);
      $this->si180_nroedital = ($this->si180_nroedital == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_nroedital"] : $this->si180_nroedital);
      $this->si180_exercicioedital = ($this->si180_exercicioedital == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_exercicioedital"] : $this->si180_exercicioedital);

      if ($this->si180_dtpublicacaoeditaldo == "") {
        $this->si180_dtpublicacaoeditaldo_dia = ($this->si180_dtpublicacaoeditaldo_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_dtpublicacaoeditaldo_dia"] : $this->si180_dtpublicacaoeditaldo_dia);
        $this->si180_dtpublicacaoeditaldo_mes = ($this->si180_dtpublicacaoeditaldo_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_dtpublicacaoeditaldo_mes"] : $this->si180_dtpublicacaoeditaldo_mes);
        $this->si180_dtpublicacaoeditaldo_ano = ($this->si180_dtpublicacaoeditaldo_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_dtpublicacaoeditaldo_ano"] : $this->si180_dtpublicacaoeditaldo_ano);
        if ($this->si180_dtpublicacaoeditaldo_dia != "") {
          $this->si180_dtpublicacaoeditaldo = $this->si180_dtpublicacaoeditaldo_ano . "-" . $this->si180_dtpublicacaoeditaldo_mes . "-" . $this->si180_dtpublicacaoeditaldo_dia;
        }
      }

      $this->si180_link = ($this->si180_link == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_link"] : $this->si180_link);
      $this->si180_tipolicitacao = ($this->si180_tipolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_tipolicitacao"] : $this->si180_tipolicitacao);
      $this->si180_naturezaobjeto = ($this->si180_naturezaobjeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_naturezaobjeto"] : $this->si180_naturezaobjeto);
      $this->si180_objeto = ($this->si180_objeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_objeto"] : $this->si180_objeto);
      $this->si180_regimeexecucaoobras = ($this->si180_regimeexecucaoobras == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_regimeexecucaoobras"] : $this->si180_regimeexecucaoobras);
      $this->si180_vlcontratacao = ($this->si180_vlcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_vlcontratacao"] : $this->si180_vlcontratacao);
      $this->si180_bdi = ($this->si180_bdi == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_bdi"] : $this->si180_bdi);
      $this->si180_mesexercicioreforc = ($this->si180_mesexercicioreforc == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_mesexercicioreforc"] : $this->si180_mesexercicioreforc);
      $this->si180_origemrecurso = ($this->si180_origemrecurso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_origemrecurso"] : $this->si180_origemrecurso);
      $this->si180_dscorigemrecurso = ($this->si180_dscorigemrecurso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_dscorigemrecurso"] : $this->si180_dscorigemrecurso);
      $this->si180_mes = ($this->si180_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_mes"] : $this->si180_mes);
      $this->si180_instit = ($this->si180_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_instit"] : $this->si180_instit);
    } else {
      $this->si180_sequencial = ($this->si180_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_sequencial"] : $this->si180_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si180_sequencial)
  {
    $this->atualizacampos();
    if ($this->si180_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si180_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si180_exerciciolicitacao == null) {
      $this->erro_sql = " Campo Exercício da Licitação não Informado.";
      $this->erro_campo = "si180_exerciciolicitacao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si180_nroprocessolicitatorio == null) {
      $this->erro_sql = " Campo Número do Processo Licitatório não Informado.";
      $this->erro_campo = "si180_nroprocessolicitatorio";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si180_codmodalidadelicitacao == null) {
      $this->si180_codmodalidadelicitacao = "0";
    }
    if ($this->si180_naturezaprocedimento == null) {
      $this->si180_naturezaprocedimento = "0";
    }
    if ($this->si180_dtpublicacaoeditaldo == null) {
      $this->si180_dtpublicacaoeditaldo = "null";
    }
    if ($this->si180_tipolicitacao == null) {
      $this->si180_tipolicitacao = "0";
    }
    if ($this->si180_naturezaobjeto == null) {
      $this->si180_naturezaobjeto = "0";
    }
    if ($this->si180_regimeexecucaoobras == null) {
      $this->si180_regimeexecucaoobras = "0";
    }
    if ($this->si180_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si180_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si180_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si180_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si180_sequencial == "" || $si180_sequencial == null) {
      $result = db_query("select nextval('ralic102020_si180_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ralic102020_si180_sequencial_seq do campo: si180_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si180_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ralic102020_si180_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si180_sequencial)) {
        $this->erro_sql = " Campo si180_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si180_sequencial = $si180_sequencial;
      }
    }
    if (($this->si180_sequencial == null) || ($this->si180_sequencial == "")) {
      $this->erro_sql = " Campo si180_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if($this->si180_exercicioedital == null){
      $this->erro_sql = " Campo si180_exercicioedital nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if($this->si180_bdi == null){
      $this->si180_bdi = 0;
    }

    if($this->si180_vlcontratacao == null){
      $this->si180_vlcontratacao = 0;
    }

    $sql = "insert into ralic102020(
                                       si180_sequencial
                                      ,si180_tiporegistro
                                      ,si180_codorgaoresp
                                      ,si180_codunidadesubresp
                                      ,si180_codunidadesubrespestadual
                                      ,si180_exerciciolicitacao
                                      ,si180_nroprocessolicitatorio
                                      ,si180_tipocadastradolicitacao
                                      ,si180_dsccadastrolicitatorio
                                      ,si180_codmodalidadelicitacao
                                      ,si180_naturezaprocedimento
                                      ,si180_nroedital
                                      ,si180_exercicioedital
                                      ,si180_dtpublicacaoeditaldo
                                      ,si180_link
                                      ,si180_tipolicitacao
                                      ,si180_naturezaobjeto
                                      ,si180_objeto
                                      ,si180_regimeexecucaoobras
                                      ,si180_vlcontratacao
                                      ,si180_bdi
                                      ,si180_mesexercicioreforc
                                      ,si180_origemrecurso
                                      ,si180_dscorigemrecurso
                                      ,si180_mes
                                      ,si180_instit
                       )
                values (
                                $this->si180_sequencial
                               ,$this->si180_tiporegistro
                               ,'$this->si180_codorgaoresp'
                               ,'$this->si180_codunidadesubresp'
                               ,'$this->si180_codunidadesubrespestadual'
                               ,$this->si180_exerciciolicitacao
                               ,'$this->si180_nroprocessolicitatorio'
                               ,$this->si180_tipocadastradolicitacao
                               ,'$this->si180_dsccadastrolicitatorio'
                               ,$this->si180_codmodalidadelicitacao
                               ,$this->si180_naturezaprocedimento
                               ,$this->si180_nroedital
                               ,$this->si180_exercicioedital
                               ," . ($this->si180_dtpublicacaoeditaldo == "null" || $this->si180_dtpublicacaoeditaldo == "" ? "null" : "'" . $this->si180_dtpublicacaoeditaldo . "'") . "
                               ,'$this->si180_link'
                               ,$this->si180_tipolicitacao
                               ,$this->si180_naturezaobjeto
                               ,'$this->si180_objeto'
                               ,$this->si180_regimeexecucaoobras
                               ,$this->si180_vlcontratacao
                               ,$this->si180_bdi
                               ,$this->si180_mesexercicioreforc
                               ,$this->si180_origemrecurso
                               ,'$this->si180_dscorigemrecurso'
                               ,$this->si180_mes
                               ,$this->si180_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ralic102020 ($this->si180_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ralic102020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ralic102020 ($this->si180_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si180_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si180_sequencial));

    return true;
  }

  // funcao para alteracao
  function alterar($si180_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ralic102020 set ";
    $virgula = "";
    if (trim($this->si180_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_sequencial"])) {
      if (trim($this->si180_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si180_sequencial"])) {
        $this->si180_sequencial = "0";
      }
      $sql .= $virgula . " si180_sequencial = $this->si180_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si180_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_tiporegistro"])) {
      $sql .= $virgula . " si180_tiporegistro = $this->si180_tiporegistro ";
      $virgula = ",";
      if (trim($this->si180_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si180_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si180_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_codorgaoresp"])) {
      $sql .= $virgula . " si180_codorgaoresp = '$this->si180_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si180_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_codunidadesubresp"])) {
      $sql .= $virgula . " si180_codunidadesubresp = '$this->si180_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si180_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_exerciciolicitacao"])) {
      if (trim($this->si180_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si180_exerciciolicitacao"])) {
        $this->si180_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si180_exerciciolicitacao = $this->si180_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si180_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si180_nroprocessolicitatorio = '$this->si180_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si180_codmodalidadelicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_codmodalidadelicitacao"])) {
      if (trim($this->si180_codmodalidadelicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si180_codmodalidadelicitacao"])) {
        $this->si180_codmodalidadelicitacao = "0";
      }
      $sql .= $virgula . " si180_codmodalidadelicitacao = $this->si180_codmodalidadelicitacao ";
      $virgula = ",";
    }

    if (trim($this->si180_naturezaprocedimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_naturezaprocedimento"])) {
      if (trim($this->si180_naturezaprocedimento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si180_naturezaprocedimento"])) {
        $this->si180_naturezaprocedimento = "0";
      }
      $sql .= $virgula . " si180_naturezaprocedimento = $this->si180_naturezaprocedimento ";
      $virgula = ",";
    }

    if (trim($this->si180_dtpublicacaoeditaldo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_dtpublicacaoeditaldo_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si180_dtpublicacaoeditaldo_dia"] != "")) {
      $sql .= $virgula . " si180_dtpublicacaoeditaldo = '$this->si180_dtpublicacaoeditaldo' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si180_dtpublicacaoeditaldo_dia"])) {
        $sql .= $virgula . " si180_dtpublicacaoeditaldo = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si180_tipolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_tipolicitacao"])) {
      if (trim($this->si180_tipolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si180_tipolicitacao"])) {
        $this->si180_tipolicitacao = "0";
      }
      $sql .= $virgula . " si180_tipolicitacao = $this->si180_tipolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si180_naturezaobjeto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_naturezaobjeto"])) {
      if (trim($this->si180_naturezaobjeto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si180_naturezaobjeto"])) {
        $this->si180_naturezaobjeto = "0";
      }
      $sql .= $virgula . " si180_naturezaobjeto = $this->si180_naturezaobjeto ";
      $virgula = ",";
    }
    echo 'Valor da contratacao: '.$this->si180_objeto;
    if (trim($this->si180_objeto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_objeto"])) {
      $sql .= $virgula . " si180_objeto = '$this->si180_objeto' ";
      $virgula = ",";
    }
    if (trim($this->si180_regimeexecucaoobras) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_regimeexecucaoobras"])) {
      if (trim($this->si180_regimeexecucaoobras) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si180_regimeexecucaoobras"])) {
        $this->si180_regimeexecucaoobras = "0";
      }
      $sql .= $virgula . " si180_regimeexecucaoobras = $this->si180_regimeexecucaoobras ";
      $virgula = ",";
    }

    if (trim($this->si180_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_mes"])) {
      $sql .= $virgula . " si180_mes = $this->si180_mes ";
      $virgula = ",";
      if (trim($this->si180_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si180_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si180_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_instit"])) {
      $sql .= $virgula . " si180_instit = $this->si180_instit ";
      $virgula = ",";
      if (trim($this->si180_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si180_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si180_sequencial != null) {
      $sql .= " si180_sequencial = $this->si180_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ralic102020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si180_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ralic102020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si180_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si180_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si180_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si180_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    $sql = " delete from ralic102020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si180_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si180_sequencial = $si180_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ralic102020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si180_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ralic102020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si180_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si180_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ralic102020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si180_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ralic102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si180_sequencial != null) {
        $sql2 .= " where ralic102020.si180_sequencial = $si180_sequencial ";
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
  function sql_query_file($si180_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ralic102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si180_sequencial != null) {
        $sql2 .= " where ralic102020.si180_sequencial = $si180_sequencial ";
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
