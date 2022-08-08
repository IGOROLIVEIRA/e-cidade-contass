<?
//MODULO: sicom
//CLASSE DA ENTIDADE dividaconsolidada
class cl_dividaconsolidada
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
  var $si167_sequencial = 0;
  var $si167_nroleiautorizacao = null;
  var $si167_dtleiautorizacao_dia = null;
  var $si167_dtleiautorizacao_mes = null;
  var $si167_dtleiautorizacao_ano = null;
  var $si167_dtleiautorizacao = null;
  var $si167_dtpublicacaoleiautorizacao_dia = null;
  var $si167_dtpublicacaoleiautorizacao_mes = null;
  var $si167_dtpublicacaoleiautorizacao_ano = null;
  var $si167_dtpublicacaoleiautorizacao = null;
  var $si167_nrocontratodivida = null;
  var $si167_dtassinatura_dia = null;
  var $si167_dtassinatura_mes = null;
  var $si167_dtassinatura_ano = null;
  var $si167_dtassinatura = null;
  var $si167_tipodocumentocredor = 0;
  var $si167_nrodocumentocredor = null;
  var $si167_vlsaldoanterior = 0;
  var $si167_vlcontratacao = 0;
  var $si167_vlamortizacao = 0;
  var $si167_vlcancelamento = 0;
  var $si167_vlencampacao = 0;
  var $si167_vlatualizacao = 0;
  var $si167_vlsaldoatual = 0;
  var $si167_contratodeclei = 0;
  var $si167_objetocontratodivida = null;
  var $si167_especificacaocontratodivida = null;
  var $si167_tipolancamento = null;
  var $si167_subtipo = null;
  var $si167_mesreferencia = 0;
  var $si167_anoreferencia = 0;
  var $si167_instit = 0;
  var $si167_numcgm = 0;
  var $si167_justificativacancelamento = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si167_sequencial = int8 = sequencial
                 si167_nroleiautorizacao = text = Número da Lei de Autorização
                 si167_dtleiautorizacao = date = Data da Lei de Autorização
                 si167_dtpublicacaoleiautorizacao = date = Data de  Publicação da Lei
                 si167_nrocontratodivida = varchar(30) = Número do Contrato de Dívida
                 si167_dtassinatura = date = Data da assinatura do Contrato
                 si167_tipodocumentocredor = int8 = Tipo de  Documento
                 si167_nrodocumentocredor = varchar(14) = Número do  documento
                 si167_vlsaldoanterior = float8 = Valor do Saldo Anterior
                 si167_vlcontratacao = float8 = Valor de  Contratação
                 si167_vlamortizacao = float8 = Valor de  Amortização
                 si167_vlcancelamento = float8 = Valor de  Cancelamento
                 si167_vlencampacao = float8 = Valor de  Encampação
                 si167_vlatualizacao = float8 = Valor da Atualização
                 si167_vlsaldoatual = float8 = Valor do Saldo Atual
                 si167_contratodeclei = int8 = Contrato decorrente de Lei de Autorização
                 si167_objetocontratodivida = varchar(1000) = Objeto do  contrato
                 si167_especificacaocontratodivida = varchar(500) = Descrição da dívida consolidada
                 si167_tipolancamento = varchar(2) = Tipo de Lançamento
                 si167_subtipo = varchar(1) = Subtipo de Lançamento
                 si167_mesreferencia = int8 = Mês de referência
                 si167_anoreferencia = int8 = Ano de referência
                 si167_instit = int8 = Instituição
                 si167_numcgm = int8 = Número do cgm
                 si167_justificativacancelamento = varchar(500) = Justificativa de cancelamento
                 ";

  //funcao construtor da classe
  function cl_dividaconsolidada()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("dividaconsolidada");
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
      $this->si167_sequencial = ($this->si167_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_sequencial"] : $this->si167_sequencial);
      $this->si167_nroleiautorizacao = ($this->si167_nroleiautorizacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_nroleiautorizacao"] : $this->si167_nroleiautorizacao);
      if ($this->si167_dtleiautorizacao == "") {
        $this->si167_dtleiautorizacao_dia = ($this->si167_dtleiautorizacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_dtleiautorizacao_dia"] : $this->si167_dtleiautorizacao_dia);
        $this->si167_dtleiautorizacao_mes = ($this->si167_dtleiautorizacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_dtleiautorizacao_mes"] : $this->si167_dtleiautorizacao_mes);
        $this->si167_dtleiautorizacao_ano = ($this->si167_dtleiautorizacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_dtleiautorizacao_ano"] : $this->si167_dtleiautorizacao_ano);
        if ($this->si167_dtleiautorizacao_dia != "") {
          $this->si167_dtleiautorizacao = $this->si167_dtleiautorizacao_ano . "-" . $this->si167_dtleiautorizacao_mes . "-" . $this->si167_dtleiautorizacao_dia;
        }
      }
      if ($this->si167_dtpublicacaoleiautorizacao == "") {
        $this->si167_dtpublicacaoleiautorizacao_dia = ($this->si167_dtpublicacaoleiautorizacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_dtpublicacaoleiautorizacao_dia"] : $this->si167_dtpublicacaoleiautorizacao_dia);
        $this->si167_dtpublicacaoleiautorizacao_mes = ($this->si167_dtpublicacaoleiautorizacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_dtpublicacaoleiautorizacao_mes"] : $this->si167_dtpublicacaoleiautorizacao_mes);
        $this->si167_dtpublicacaoleiautorizacao_ano = ($this->si167_dtpublicacaoleiautorizacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_dtpublicacaoleiautorizacao_ano"] : $this->si167_dtpublicacaoleiautorizacao_ano);
        if ($this->si167_dtpublicacaoleiautorizacao_dia != "") {
          $this->si167_dtpublicacaoleiautorizacao = $this->si167_dtpublicacaoleiautorizacao_ano . "-" . $this->si167_dtpublicacaoleiautorizacao_mes . "-" . $this->si167_dtpublicacaoleiautorizacao_dia;
        }
      }
      $this->si167_nrocontratodivida = ($this->si167_nrocontratodivida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_nrocontratodivida"] : $this->si167_nrocontratodivida);
      if ($this->si167_dtassinatura == "") {
        $this->si167_dtassinatura_dia = ($this->si167_dtassinatura_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_dtassinatura_dia"] : $this->si167_dtassinatura_dia);
        $this->si167_dtassinatura_mes = ($this->si167_dtassinatura_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_dtassinatura_mes"] : $this->si167_dtassinatura_mes);
        $this->si167_dtassinatura_ano = ($this->si167_dtassinatura_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_dtassinatura_ano"] : $this->si167_dtassinatura_ano);
        if ($this->si167_dtassinatura_dia != "") {
          $this->si167_dtassinatura = $this->si167_dtassinatura_ano . "-" . $this->si167_dtassinatura_mes . "-" . $this->si167_dtassinatura_dia;
        }
      }
      $this->si167_tipodocumentocredor = ($this->si167_tipodocumentocredor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_tipodocumentocredor"] : $this->si167_tipodocumentocredor);
      $this->si167_nrodocumentocredor = ($this->si167_nrodocumentocredor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_nrodocumentocredor"] : $this->si167_nrodocumentocredor);
      $this->si167_vlsaldoanterior = ($this->si167_vlsaldoanterior == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_vlsaldoanterior"] : $this->si167_vlsaldoanterior);
      $this->si167_vlcontratacao = ($this->si167_vlcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_vlcontratacao"] : $this->si167_vlcontratacao);
      $this->si167_vlamortizacao = ($this->si167_vlamortizacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_vlamortizacao"] : $this->si167_vlamortizacao);
      $this->si167_vlcancelamento = ($this->si167_vlcancelamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_vlcancelamento"] : $this->si167_vlcancelamento);
      $this->si167_vlencampacao = ($this->si167_vlencampacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_vlencampacao"] : $this->si167_vlencampacao);
      $this->si167_vlatualizacao = ($this->si167_vlatualizacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_vlatualizacao"] : $this->si167_vlatualizacao);
      $this->si167_vlsaldoatual = ($this->si167_vlsaldoatual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_vlsaldoatual"] : $this->si167_vlsaldoatual);
      $this->si167_contratodeclei = ($this->si167_contratodeclei == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_contratodeclei"] : $this->si167_contratodeclei);
      $this->si167_objetocontratodivida = ($this->si167_objetocontratodivida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_objetocontratodivida"] : $this->si167_objetocontratodivida);
      $this->si167_especificacaocontratodivida = ($this->si167_especificacaocontratodivida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_especificacaocontratodivida"] : $this->si167_especificacaocontratodivida);
      $this->si167_tipolancamento = ($this->si167_tipolancamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_tipolancamento"] : $this->si167_tipolancamento);
      $this->si167_subtipo = ($this->si167_subtipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_subtipo"] : $this->si167_subtipo);
      $this->si167_mesreferencia = ($this->si167_mesreferencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_mesreferencia"] : $this->si167_mesreferencia);
    } else {
      $this->si167_sequencial = ($this->si167_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si167_sequencial"] : $this->si167_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si167_sequencial)
  {
    $this->atualizacampos();
    if ($this->si167_nroleiautorizacao == null) {
      $this->erro_sql = " Campo Número da Lei de Autorização nao Informado.";
      $this->erro_campo = "si167_nroleiautorizacao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_dtleiautorizacao == null) {
      $this->erro_sql = " Campo Data da Lei de Autorização nao Informado.";
      $this->erro_campo = "si167_dtleiautorizacao_dia";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_dtpublicacaoleiautorizacao == null) {
      $this->erro_sql = " Campo Data de  Publicação da Lei nao Informado.";
      $this->erro_campo = "si167_dtpublicacaoleiautorizacao_dia";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_nrocontratodivida == null) {
      $this->erro_sql = " Campo Número do Contrato de Dívida nao Informado.";
      $this->erro_campo = "si167_nrocontratodivida";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_dtassinatura == null) {
      $this->erro_sql = " Campo Data da assinatura do Contrato nao Informado.";
      $this->erro_campo = "si167_dtassinatura_dia";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    /*if($this->si167_tipodocumentocredor == null ){
       $this->erro_sql = " Campo Tipo de  Documento nao Informado.";
       $this->erro_campo = "si167_tipodocumentocredor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si167_nrodocumentocredor == null ){
       $this->erro_sql = " Campo Número do  documento nao Informado.";
       $this->erro_campo = "si167_nrodocumentocredor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
    if ($this->si167_vlsaldoanterior == null) {
      $this->erro_sql = " Campo Valor do Saldo Anterior nao Informado.";
      $this->erro_campo = "si167_vlsaldoanterior";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_vlcontratacao == null) {
      $this->erro_sql = " Campo Valor de  Contratação nao Informado.";
      $this->erro_campo = "si167_vlcontratacao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_vlamortizacao == null) {
      $this->erro_sql = " Campo Valor de  Amortização nao Informado.";
      $this->erro_campo = "si167_vlamortizacao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_vlcancelamento == null) {
      $this->erro_sql = " Campo Valor de  Cancelamento nao Informado.";
      $this->erro_campo = "si167_vlcancelamento";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_vlencampacao == null) {
      $this->erro_sql = " Campo Valor de  Encampação nao Informado.";
      $this->erro_campo = "si167_vlencampacao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_vlatualizacao == null) {
      $this->erro_sql = " Campo Valor da Atualização nao Informado.";
      $this->erro_campo = "si167_vlatualizacao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_vlsaldoatual == null) {
      $this->erro_sql = " Campo Valor do Saldo Atual nao Informado.";
      $this->erro_campo = "si167_vlsaldoatual";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_contratodeclei == null) {
      $this->erro_sql = " Campo Contrato decorrente de Lei de Autorização nao Informado.";
      $this->erro_campo = "si167_contratodeclei";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_objetocontratodivida == null) {
      $this->erro_sql = " Campo Objeto do  contrato nao Informado.";
      $this->erro_campo = "si167_objetocontratodivida";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_especificacaocontratodivida == null) {
      $this->erro_sql = " Campo Descrição da dívida consolidada nao Informado.";
      $this->erro_campo = "si167_especificacaocontratodivida";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_tipolancamento == null) {
      $this->erro_sql = " Campo Tipo de Lançamento nao Informado.";
      $this->erro_campo = "si167_tipolancamento";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_numcgm == null) {
      $this->erro_sql = " Campo Número do cgm nao Informado.";
      $this->erro_campo = "si167_numcgm";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si167_mesreferencia == null || $this->si167_mesreferencia == 0) {
      $this->erro_sql = " Campo Mês de referência nao Informado.";
      $this->erro_campo = "si167_mesreferencia";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si167_vlcancelamento > 0) {
      if ($this->si167_justificativacancelamento == null) {
        $this->erro_sql = " Campo Justificativa de cancelamento nao Informado.";
        $this->erro_campo = "si167_justificativacancelamento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }

    if ($si167_sequencial == "" || $si167_sequencial == null) {
      $result = db_query("select nextval('dividaconsolidada_si167_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: dividaconsolidada_si167_sequencial_seq do campo: si167_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si167_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from dividaconsolidada_si167_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si167_sequencial)) {
        $this->erro_sql = " Campo si167_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si167_sequencial = $si167_sequencial;
      }
    }
    if (($this->si167_sequencial == null) || ($this->si167_sequencial == "")) {
      $this->erro_sql = " Campo si167_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into dividaconsolidada(
                                       si167_sequencial
                                      ,si167_nroleiautorizacao
                                      ,si167_dtleiautorizacao
                                      ,si167_dtpublicacaoleiautorizacao
                                      ,si167_nrocontratodivida
                                      ,si167_dtassinatura
                                      ,si167_tipodocumentocredor
                                      ,si167_nrodocumentocredor
                                      ,si167_vlsaldoanterior
                                      ,si167_vlcontratacao
                                      ,si167_vlamortizacao
                                      ,si167_vlcancelamento
                                      ,si167_vlencampacao
                                      ,si167_vlatualizacao
                                      ,si167_vlsaldoatual
                                      ,si167_contratodeclei
                                      ,si167_objetocontratodivida
                                      ,si167_especificacaocontratodivida
                                      ,si167_tipolancamento
                                      ,si167_subtipo
                                      ,si167_mesreferencia
                                      ,si167_anoreferencia
                                      ,si167_instit
                                      ,si167_numcgm
                                      ,si167_justificativacancelamento
                       )
                values (
                                $this->si167_sequencial
                               ,'$this->si167_nroleiautorizacao'
                               ," . ($this->si167_dtleiautorizacao == "null" || $this->si167_dtleiautorizacao == "" ? "null" : "'" . $this->si167_dtleiautorizacao . "'") . "
                               ," . ($this->si167_dtpublicacaoleiautorizacao == "null" || $this->si167_dtpublicacaoleiautorizacao == "" ? "null" : "'" . $this->si167_dtpublicacaoleiautorizacao . "'") . "
                               ,'$this->si167_nrocontratodivida'
                               ," . ($this->si167_dtassinatura == "null" || $this->si167_dtassinatura == "" ? "null" : "'" . $this->si167_dtassinatura . "'") . "
                               ," . ($this->si167_tipodocumentocredor == "null" || $this->si167_tipodocumentocredor == "" ? "null" : "'" . $this->si167_tipodocumentocredor . "'") . "
                               ," . ($this->si167_nrodocumentocredor == "null" || $this->si167_nrodocumentocredor == "" ? "null" : "'" . $this->si167_nrodocumentocredor . "'") . "
                               ,$this->si167_vlsaldoanterior
                               ,$this->si167_vlcontratacao
                               ,$this->si167_vlamortizacao
                               ,$this->si167_vlcancelamento
                               ,$this->si167_vlencampacao
                               ,$this->si167_vlatualizacao
                               ,$this->si167_vlsaldoatual
                               ,$this->si167_contratodeclei
                               ,'$this->si167_objetocontratodivida'
                               ,'$this->si167_especificacaocontratodivida'
                               ,'$this->si167_tipolancamento'
                               ,'$this->si167_subtipo'
                               ,$this->si167_mesreferencia
                               ," . db_getsession("DB_anousu") . "
                               ," . db_getsession("DB_instit") . "
                               ,$this->si167_numcgm
                               ," . ($this->si167_justificativacancelamento == "null" || $this->si167_justificativacancelamento == "" ? "null" : "'" . $this->si167_justificativacancelamento . "'") . "
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "dividaconsolidada ($this->si167_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "dividaconsolidada já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "dividaconsolidada ($this->si167_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si167_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si167_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2011415,'$this->si167_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010401,2011415,'','" . AddSlashes(pg_result($resaco, 0, 'si167_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011416,'','" . AddSlashes(pg_result($resaco, 0, 'si167_nroleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011417,'','" . AddSlashes(pg_result($resaco, 0, 'si167_dtleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011434,'','" . AddSlashes(pg_result($resaco, 0, 'si167_dtpublicacaoleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011418,'','" . AddSlashes(pg_result($resaco, 0, 'si167_nrocontratodivida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011419,'','" . AddSlashes(pg_result($resaco, 0, 'si167_dtassinatura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011420,'','" . AddSlashes(pg_result($resaco, 0, 'si167_tipodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011421,'','" . AddSlashes(pg_result($resaco, 0, 'si167_nrodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011422,'','" . AddSlashes(pg_result($resaco, 0, 'si167_vlsaldoanterior')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011423,'','" . AddSlashes(pg_result($resaco, 0, 'si167_vlcontratacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011424,'','" . AddSlashes(pg_result($resaco, 0, 'si167_vlamortizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011425,'','" . AddSlashes(pg_result($resaco, 0, 'si167_vlcancelamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011426,'','" . AddSlashes(pg_result($resaco, 0, 'si167_vlencampacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011427,'','" . AddSlashes(pg_result($resaco, 0, 'si167_vlatualizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011428,'','" . AddSlashes(pg_result($resaco, 0, 'si167_vlsaldoatual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011430,'','" . AddSlashes(pg_result($resaco, 0, 'si167_contratodeclei')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011431,'','" . AddSlashes(pg_result($resaco, 0, 'si167_objetocontratodivida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011432,'','" . AddSlashes(pg_result($resaco, 0, 'si167_especificacaocontratodivida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011433,'','" . AddSlashes(pg_result($resaco, 0, 'si167_tipolancamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010401,2011429,'','" . AddSlashes(pg_result($resaco, 0, 'si167_mesreferencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si167_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update dividaconsolidada set ";
    $virgula = "";
    if (trim($this->si167_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_sequencial"])) {
      $sql .= $virgula . " si167_sequencial = $this->si167_sequencial ";
      $virgula = ",";
      if (trim($this->si167_sequencial) == null) {
        $this->erro_sql = " Campo sequencial nao Informado.";
        $this->erro_campo = "si167_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_nroleiautorizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_nroleiautorizacao"])) {
      $sql .= $virgula . " si167_nroleiautorizacao = '$this->si167_nroleiautorizacao' ";
      $virgula = ",";
      if (trim($this->si167_nroleiautorizacao) == null) {
        $this->erro_sql = " Campo Número da Lei de Autorização nao Informado.";
        $this->erro_campo = "si167_nroleiautorizacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_dtleiautorizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_dtleiautorizacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si167_dtleiautorizacao_dia"] != "")) {
      $sql .= $virgula . " si167_dtleiautorizacao = '$this->si167_dtleiautorizacao' ";
      $virgula = ",";
      if (trim($this->si167_dtleiautorizacao) == null) {
        $this->erro_sql = " Campo Data da Lei de Autorização nao Informado.";
        $this->erro_campo = "si167_dtleiautorizacao_dia";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si167_dtleiautorizacao_dia"])) {
        $sql .= $virgula . " si167_dtleiautorizacao = null ";
        $virgula = ",";
        if (trim($this->si167_dtleiautorizacao) == null) {
          $this->erro_sql = " Campo Data da Lei de Autorização nao Informado.";
          $this->erro_campo = "si167_dtleiautorizacao_dia";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";

          return false;
        }
      }
    }
    if (trim($this->si167_dtpublicacaoleiautorizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_dtpublicacaoleiautorizacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si167_dtpublicacaoleiautorizacao_dia"] != "")) {
      $sql .= $virgula . " si167_dtpublicacaoleiautorizacao = '$this->si167_dtpublicacaoleiautorizacao' ";
      $virgula = ",";
      if (trim($this->si167_dtpublicacaoleiautorizacao) == null) {
        $this->erro_sql = " Campo Data de  Publicação da Lei nao Informado.";
        $this->erro_campo = "si167_dtpublicacaoleiautorizacao_dia";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si167_dtpublicacaoleiautorizacao_dia"])) {
        $sql .= $virgula . " si167_dtpublicacaoleiautorizacao = null ";
        $virgula = ",";
        if (trim($this->si167_dtpublicacaoleiautorizacao) == null) {
          $this->erro_sql = " Campo Data de  Publicação da Lei nao Informado.";
          $this->erro_campo = "si167_dtpublicacaoleiautorizacao_dia";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";

          return false;
        }
      }
    }
    if (trim($this->si167_nrocontratodivida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_nrocontratodivida"])) {
      $sql .= $virgula . " si167_nrocontratodivida = '$this->si167_nrocontratodivida' ";
      $virgula = ",";
      if (trim($this->si167_nrocontratodivida) == null) {
        $this->erro_sql = " Campo Número do Contrato de Dívida nao Informado.";
        $this->erro_campo = "si167_nrocontratodivida";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_dtassinatura) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_dtassinatura_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si167_dtassinatura_dia"] != "")) {
      $sql .= $virgula . " si167_dtassinatura = '$this->si167_dtassinatura' ";
      $virgula = ",";
      if (trim($this->si167_dtassinatura) == null) {
        $this->erro_sql = " Campo Data da assinatura do Contrato nao Informado.";
        $this->erro_campo = "si167_dtassinatura_dia";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si167_dtassinatura_dia"])) {
        $sql .= $virgula . " si167_dtassinatura = null ";
        $virgula = ",";
        if (trim($this->si167_dtassinatura) == null) {
          $this->erro_sql = " Campo Data da assinatura do Contrato nao Informado.";
          $this->erro_campo = "si167_dtassinatura_dia";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";

          return false;
        }
      }
    }
    /*if(trim($this->si167_tipodocumentocredor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si167_tipodocumentocredor"])){
       $sql  .= $virgula." si167_tipodocumentocredor = $this->si167_tipodocumentocredor ";
       $virgula = ",";
       if(trim($this->si167_tipodocumentocredor) == null ){
         $this->erro_sql = " Campo Tipo de  Documento nao Informado.";
         $this->erro_campo = "si167_tipodocumentocredor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si167_nrodocumentocredor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si167_nrodocumentocredor"])){
       $sql  .= $virgula." si167_nrodocumentocredor = '$this->si167_nrodocumentocredor' ";
       $virgula = ",";
       if(trim($this->si167_nrodocumentocredor) == null ){
         $this->erro_sql = " Campo Número do  documento nao Informado.";
         $this->erro_campo = "si167_nrodocumentocredor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }*/
    if (trim($this->si167_vlsaldoanterior) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_vlsaldoanterior"])) {
      $sql .= $virgula . " si167_vlsaldoanterior = $this->si167_vlsaldoanterior ";
      $virgula = ",";
      if (trim($this->si167_vlsaldoanterior) == null) {
        $this->erro_sql = " Campo Valor do Saldo Anterior nao Informado.";
        $this->erro_campo = "si167_vlsaldoanterior";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_vlcontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_vlcontratacao"])) {
      $sql .= $virgula . " si167_vlcontratacao = $this->si167_vlcontratacao ";
      $virgula = ",";
      if (trim($this->si167_vlcontratacao) == null) {
        $this->erro_sql = " Campo Valor de  Contratação nao Informado.";
        $this->erro_campo = "si167_vlcontratacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_vlamortizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_vlamortizacao"])) {
      $sql .= $virgula . " si167_vlamortizacao = $this->si167_vlamortizacao ";
      $virgula = ",";
      if (trim($this->si167_vlamortizacao) == null) {
        $this->erro_sql = " Campo Valor de  Amortização nao Informado.";
        $this->erro_campo = "si167_vlamortizacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_vlcancelamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_vlcancelamento"])) {
      $sql .= $virgula . " si167_vlcancelamento = $this->si167_vlcancelamento ";
      $virgula = ",";
      if (trim($this->si167_vlcancelamento) == null) {
        $this->erro_sql = " Campo Valor de  Cancelamento nao Informado.";
        $this->erro_campo = "si167_vlcancelamento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_vlencampacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_vlencampacao"])) {
      $sql .= $virgula . " si167_vlencampacao = $this->si167_vlencampacao ";
      $virgula = ",";
      if (trim($this->si167_vlencampacao) == null) {
        $this->erro_sql = " Campo Valor de  Encampação nao Informado.";
        $this->erro_campo = "si167_vlencampacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_vlatualizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_vlatualizacao"])) {
      $sql .= $virgula . " si167_vlatualizacao = $this->si167_vlatualizacao ";
      $virgula = ",";
      if (trim($this->si167_vlatualizacao) == null) {
        $this->erro_sql = " Campo Valor da Atualização nao Informado.";
        $this->erro_campo = "si167_vlatualizacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_vlsaldoatual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_vlsaldoatual"])) {
      $sql .= $virgula . " si167_vlsaldoatual = $this->si167_vlsaldoatual ";
      $virgula = ",";
      if (trim($this->si167_vlsaldoatual) == null) {
        $this->erro_sql = " Campo Valor do Saldo Atual nao Informado.";
        $this->erro_campo = "si167_vlsaldoatual";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_contratodeclei) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_contratodeclei"])) {
      $sql .= $virgula . " si167_contratodeclei = $this->si167_contratodeclei ";
      $virgula = ",";
      if (trim($this->si167_contratodeclei) == null) {
        $this->erro_sql = " Campo Contrato decorrente de Lei de Autorização nao Informado.";
        $this->erro_campo = "si167_contratodeclei";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_objetocontratodivida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_objetocontratodivida"])) {
      $sql .= $virgula . " si167_objetocontratodivida = '$this->si167_objetocontratodivida' ";
      $virgula = ",";
      if (trim($this->si167_objetocontratodivida) == null) {
        $this->erro_sql = " Campo Objeto do  contrato nao Informado.";
        $this->erro_campo = "si167_objetocontratodivida";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_especificacaocontratodivida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_especificacaocontratodivida"])) {
      $sql .= $virgula . " si167_especificacaocontratodivida = '$this->si167_especificacaocontratodivida' ";
      $virgula = ",";
      if (trim($this->si167_especificacaocontratodivida) == null) {
        $this->erro_sql = " Campo Descrição da dívida consolidada nao Informado.";
        $this->erro_campo = "si167_especificacaocontratodivida";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_tipolancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_tipolancamento"])) {
      $sql .= $virgula . " si167_tipolancamento = '$this->si167_tipolancamento' ";
      $virgula = ",";
      if (trim($this->si167_tipolancamento) == null) {
        $this->erro_sql = " Campo Tipo de Lançamento nao Informado.";
        $this->erro_campo = "si167_tipolancamento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si167_subtipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_subtipo"])) {
      $sql .= $virgula . " si167_subtipo = '$this->si167_subtipo' ";
      $virgula = ",";
    }

    if (trim($this->si167_numcgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_numcgm"])) {
      $sql .= $virgula . " si167_numcgm = '$this->si167_numcgm' ";
      $virgula = ",";
      if (trim($this->si167_numcgm) == null) {
        $this->erro_sql = " Campo Número do cgm nao Informado.";
        $this->erro_campo = "si167_numcgm";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }

    if (trim($this->si167_mesreferencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si167_mesreferencia"])) {
      $sql .= $virgula . " si167_mesreferencia = $this->si167_mesreferencia ";
      $virgula = ",";
      if (trim($this->si167_mesreferencia) == null) {
        $this->erro_sql = " Campo Mês de referência nao Informado.";
        $this->erro_campo = "si167_mesreferencia";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if ($this->si167_justificativacancelamento != null || isset($GLOBALS["HTTP_POST_VARS"]["si167_justificativacancelamento"])) {
      $sql .= $virgula . " si167_justificativacancelamento = '$this->si167_justificativacancelamento' ";
      $virgula = ",";
    } elseif ($this->si167_vlcancelamento > 0) {
      if (trim($this->si167_justificativacancelamento) == null) {
        $this->erro_sql = " Campo Justificativa de cancelamento nao Informado.";
        $this->erro_campo = "si167_justificativacancelamento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si167_sequencial != null) {
      $sql .= " si167_sequencial = $this->si167_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si167_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011415,'$this->si167_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_sequencial"]) || $this->si167_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011415,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_sequencial')) . "','$this->si167_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_nroleiautorizacao"]) || $this->si167_nroleiautorizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011416,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_nroleiautorizacao')) . "','$this->si167_nroleiautorizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_dtleiautorizacao"]) || $this->si167_dtleiautorizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011417,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_dtleiautorizacao')) . "','$this->si167_dtleiautorizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_dtpublicacaoleiautorizacao"]) || $this->si167_dtpublicacaoleiautorizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011434,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_dtpublicacaoleiautorizacao')) . "','$this->si167_dtpublicacaoleiautorizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_nrocontratodivida"]) || $this->si167_nrocontratodivida != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011418,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_nrocontratodivida')) . "','$this->si167_nrocontratodivida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_dtassinatura"]) || $this->si167_dtassinatura != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011419,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_dtassinatura')) . "','$this->si167_dtassinatura'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_tipodocumentocredor"]) || $this->si167_tipodocumentocredor != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011420,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_tipodocumentocredor')) . "','$this->si167_tipodocumentocredor'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_nrodocumentocredor"]) || $this->si167_nrodocumentocredor != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011421,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_nrodocumentocredor')) . "','$this->si167_nrodocumentocredor'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_vlsaldoanterior"]) || $this->si167_vlsaldoanterior != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011422,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_vlsaldoanterior')) . "','$this->si167_vlsaldoanterior'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_vlcontratacao"]) || $this->si167_vlcontratacao != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011423,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_vlcontratacao')) . "','$this->si167_vlcontratacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_vlamortizacao"]) || $this->si167_vlamortizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011424,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_vlamortizacao')) . "','$this->si167_vlamortizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_vlcancelamento"]) || $this->si167_vlcancelamento != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011425,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_vlcancelamento')) . "','$this->si167_vlcancelamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_vlencampacao"]) || $this->si167_vlencampacao != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011426,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_vlencampacao')) . "','$this->si167_vlencampacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_vlatualizacao"]) || $this->si167_vlatualizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011427,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_vlatualizacao')) . "','$this->si167_vlatualizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_vlsaldoatual"]) || $this->si167_vlsaldoatual != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011428,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_vlsaldoatual')) . "','$this->si167_vlsaldoatual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_contratodeclei"]) || $this->si167_contratodeclei != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011430,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_contratodeclei')) . "','$this->si167_contratodeclei'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_objetocontratodivida"]) || $this->si167_objetocontratodivida != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011431,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_objetocontratodivida')) . "','$this->si167_objetocontratodivida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_especificacaocontratodivida"]) || $this->si167_especificacaocontratodivida != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011432,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_especificacaocontratodivida')) . "','$this->si167_especificacaocontratodivida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_tipolancamento"]) || $this->si167_tipolancamento != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011433,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_tipolancamento')) . "','$this->si167_tipolancamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si167_mesreferencia"]) || $this->si167_mesreferencia != "")
          $resac = db_query("insert into db_acount values($acount,2010401,2011429,'" . AddSlashes(pg_result($resaco, $conresaco, 'si167_mesreferencia')) . "','$this->si167_mesreferencia'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "dividaconsolidada nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si167_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dividaconsolidada nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si167_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si167_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si167_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si167_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011415,'$si167_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010401,2011415,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011416,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_nroleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011417,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_dtleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011434,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_dtpublicacaoleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011418,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_nrocontratodivida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011419,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_dtassinatura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011420,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_tipodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011421,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_nrodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011422,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_vlsaldoanterior')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011423,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_vlcontratacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011424,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_vlamortizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011425,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_vlcancelamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011426,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_vlencampacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011427,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_vlatualizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011428,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_vlsaldoatual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011430,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_contratodeclei')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011431,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_objetocontratodivida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011432,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_especificacaocontratodivida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011433,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_tipolancamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010401,2011429,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si167_mesreferencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from dividaconsolidada
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si167_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si167_sequencial = $si167_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "dividaconsolidada nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si167_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dividaconsolidada nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si167_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si167_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:dividaconsolidada";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si167_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dividaconsolidada ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si167_sequencial != null) {
        $sql2 .= " where dividaconsolidada.si167_sequencial = $si167_sequencial ";
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
  function sql_query_file($si167_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dividaconsolidada ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si167_sequencial != null) {
        $sql2 .= " where dividaconsolidada.si167_sequencial = $si167_sequencial ";
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
