<?
//MODULO: sicom
//CLASSE DA ENTIDADE hablic202018
class cl_hablic202018
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
  var $si59_sequencial = 0;
  var $si59_tiporegistro = 0;
  var $si59_codorgao = null;
  var $si59_codunidadesub = null;
  var $si59_exerciciolicitacao = 0;
  var $si59_nroprocessolicitatorio = null;
  var $si59_tipodocumento = 0;
  var $si59_nrodocumento = null;
  var $si59_datacredenciamento_dia = null;
  var $si59_datacredenciamento_mes = null;
  var $si59_datacredenciamento_ano = null;
  var $si59_datacredenciamento = null;
  var $si59_nrolote = 0;
  var $si59_coditem = 0;
  var $si59_nroinscricaoestadual = null;
  var $si59_ufinscricaoestadual = null;
  var $si59_nrocertidaoregularidadeinss = null;
  var $si59_dataemissaocertidaoregularidadeinss_dia = null;
  var $si59_dataemissaocertidaoregularidadeinss_mes = null;
  var $si59_dataemissaocertidaoregularidadeinss_ano = null;
  var $si59_dataemissaocertidaoregularidadeinss = null;
  var $si59_dtvalidadecertidaoregularidadeinss_dia = null;
  var $si59_dtvalidadecertidaoregularidadeinss_mes = null;
  var $si59_dtvalidadecertidaoregularidadeinss_ano = null;
  var $si59_dtvalidadecertidaoregularidadeinss = null;
  var $si59_nrocertidaoregularidadefgts = null;
  var $si59_dtemissaocertidaoregularidadefgts_dia = null;
  var $si59_dtemissaocertidaoregularidadefgts_mes = null;
  var $si59_dtemissaocertidaoregularidadefgts_ano = null;
  var $si59_dtemissaocertidaoregularidadefgts = null;
  var $si59_dtvalidadecertidaoregularidadefgts_dia = null;
  var $si59_dtvalidadecertidaoregularidadefgts_mes = null;
  var $si59_dtvalidadecertidaoregularidadefgts_ano = null;
  var $si59_dtvalidadecertidaoregularidadefgts = null;
  var $si59_nrocndt = null;
  var $si59_dtemissaocndt_dia = null;
  var $si59_dtemissaocndt_mes = null;
  var $si59_dtemissaocndt_ano = null;
  var $si59_dtemissaocndt = null;
  var $si59_dtvalidadecndt_dia = null;
  var $si59_dtvalidadecndt_mes = null;
  var $si59_dtvalidadecndt_ano = null;
  var $si59_dtvalidadecndt = null;
  var $si59_mes = 0;
  var $si59_instit = 0;
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 si59_sequencial = int8 = sequencial 
                 si59_tiporegistro = int8 = Tipo do  registro 
                 si59_codorgao = varchar(2) = Código do órgão 
                 si59_codunidadesub = varchar(8) = Código da unidade 
                 si59_exerciciolicitacao = int8 = Exercício em que   foi instaurado 
                 si59_nroprocessolicitatorio = varchar(12) = Número sequencial 
                 si59_tipodocumento = int8 = Tipo do  documento 
                 si59_nrodocumento = varchar(14) = Número do  documento 
                 si59_datacredenciamento = date = Data do  credenciamento 
                 si59_nrolote = int8 = Número do Lote 
                 si59_coditem = int8 = Código do Item 
                 si59_nroinscricaoestadual = varchar(30) = Número da  Inscrição estadual 
                 si59_ufinscricaoestadual = varchar(2) = UF da inscrição  estadual 
                 si59_nrocertidaoregularidadeinss = varchar(30) = Número da certidão de regularidade FGTS 
                 si59_dataemissaocertidaoregularidadeinss = date = Data de emissão  da certidão 
                 si59_dtvalidadecertidaoregularidadeinss = date = Data de validade  da certidão 
                 si59_nrocertidaoregularidadefgts = varchar(30) = Número da certidão  de regularidade FGTS 
                 si59_dtemissaocertidaoregularidadefgts = date = Data de emissão da certidão de regularidade 
                 si59_dtvalidadecertidaoregularidadefgts = date = Data de validade  da certidão FGTS 
                 si59_nrocndt = varchar(30) = Número da  Certidão Negativa  de Débitos 
                 si59_dtemissaocndt = date = Data de emissão  da certidão  Negativa 
                 si59_dtvalidadecndt = date = Data de validade  da certidão  Negativa 
                 si59_mes = int8 = Mês 
                 si59_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe 
  function cl_hablic202018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("hablic202018");
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
      $this->si59_sequencial = ($this->si59_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_sequencial"] : $this->si59_sequencial);
      $this->si59_tiporegistro = ($this->si59_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_tiporegistro"] : $this->si59_tiporegistro);
      $this->si59_codorgao = ($this->si59_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_codorgao"] : $this->si59_codorgao);
      $this->si59_codunidadesub = ($this->si59_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_codunidadesub"] : $this->si59_codunidadesub);
      $this->si59_exerciciolicitacao = ($this->si59_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_exerciciolicitacao"] : $this->si59_exerciciolicitacao);
      $this->si59_nroprocessolicitatorio = ($this->si59_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_nroprocessolicitatorio"] : $this->si59_nroprocessolicitatorio);
      $this->si59_tipodocumento = ($this->si59_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_tipodocumento"] : $this->si59_tipodocumento);
      $this->si59_nrodocumento = ($this->si59_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_nrodocumento"] : $this->si59_nrodocumento);
      if ($this->si59_datacredenciamento == "") {
        $this->si59_datacredenciamento_dia = ($this->si59_datacredenciamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_datacredenciamento_dia"] : $this->si59_datacredenciamento_dia);
        $this->si59_datacredenciamento_mes = ($this->si59_datacredenciamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_datacredenciamento_mes"] : $this->si59_datacredenciamento_mes);
        $this->si59_datacredenciamento_ano = ($this->si59_datacredenciamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_datacredenciamento_ano"] : $this->si59_datacredenciamento_ano);
        if ($this->si59_datacredenciamento_dia != "") {
          $this->si59_datacredenciamento = $this->si59_datacredenciamento_ano . "-" . $this->si59_datacredenciamento_mes . "-" . $this->si59_datacredenciamento_dia;
        }
      }
      $this->si59_nrolote = ($this->si59_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_nrolote"] : $this->si59_nrolote);
      $this->si59_coditem = ($this->si59_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_coditem"] : $this->si59_coditem);
      $this->si59_nroinscricaoestadual = ($this->si59_nroinscricaoestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_nroinscricaoestadual"] : $this->si59_nroinscricaoestadual);
      $this->si59_ufinscricaoestadual = ($this->si59_ufinscricaoestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_ufinscricaoestadual"] : $this->si59_ufinscricaoestadual);
      $this->si59_nrocertidaoregularidadeinss = ($this->si59_nrocertidaoregularidadeinss == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_nrocertidaoregularidadeinss"] : $this->si59_nrocertidaoregularidadeinss);
      if ($this->si59_dataemissaocertidaoregularidadeinss == "") {
        $this->si59_dataemissaocertidaoregularidadeinss_dia = ($this->si59_dataemissaocertidaoregularidadeinss_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dataemissaocertidaoregularidadeinss_dia"] : $this->si59_dataemissaocertidaoregularidadeinss_dia);
        $this->si59_dataemissaocertidaoregularidadeinss_mes = ($this->si59_dataemissaocertidaoregularidadeinss_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dataemissaocertidaoregularidadeinss_mes"] : $this->si59_dataemissaocertidaoregularidadeinss_mes);
        $this->si59_dataemissaocertidaoregularidadeinss_ano = ($this->si59_dataemissaocertidaoregularidadeinss_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dataemissaocertidaoregularidadeinss_ano"] : $this->si59_dataemissaocertidaoregularidadeinss_ano);
        if ($this->si59_dataemissaocertidaoregularidadeinss_dia != "") {
          $this->si59_dataemissaocertidaoregularidadeinss = $this->si59_dataemissaocertidaoregularidadeinss_ano . "-" . $this->si59_dataemissaocertidaoregularidadeinss_mes . "-" . $this->si59_dataemissaocertidaoregularidadeinss_dia;
        }
      }
      if ($this->si59_dtvalidadecertidaoregularidadeinss == "") {
        $this->si59_dtvalidadecertidaoregularidadeinss_dia = ($this->si59_dtvalidadecertidaoregularidadeinss_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadeinss_dia"] : $this->si59_dtvalidadecertidaoregularidadeinss_dia);
        $this->si59_dtvalidadecertidaoregularidadeinss_mes = ($this->si59_dtvalidadecertidaoregularidadeinss_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadeinss_mes"] : $this->si59_dtvalidadecertidaoregularidadeinss_mes);
        $this->si59_dtvalidadecertidaoregularidadeinss_ano = ($this->si59_dtvalidadecertidaoregularidadeinss_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadeinss_ano"] : $this->si59_dtvalidadecertidaoregularidadeinss_ano);
        if ($this->si59_dtvalidadecertidaoregularidadeinss_dia != "") {
          $this->si59_dtvalidadecertidaoregularidadeinss = $this->si59_dtvalidadecertidaoregularidadeinss_ano . "-" . $this->si59_dtvalidadecertidaoregularidadeinss_mes . "-" . $this->si59_dtvalidadecertidaoregularidadeinss_dia;
        }
      }
      $this->si59_nrocertidaoregularidadefgts = ($this->si59_nrocertidaoregularidadefgts == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_nrocertidaoregularidadefgts"] : $this->si59_nrocertidaoregularidadefgts);
      if ($this->si59_dtemissaocertidaoregularidadefgts == "") {
        $this->si59_dtemissaocertidaoregularidadefgts_dia = ($this->si59_dtemissaocertidaoregularidadefgts_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocertidaoregularidadefgts_dia"] : $this->si59_dtemissaocertidaoregularidadefgts_dia);
        $this->si59_dtemissaocertidaoregularidadefgts_mes = ($this->si59_dtemissaocertidaoregularidadefgts_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocertidaoregularidadefgts_mes"] : $this->si59_dtemissaocertidaoregularidadefgts_mes);
        $this->si59_dtemissaocertidaoregularidadefgts_ano = ($this->si59_dtemissaocertidaoregularidadefgts_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocertidaoregularidadefgts_ano"] : $this->si59_dtemissaocertidaoregularidadefgts_ano);
        if ($this->si59_dtemissaocertidaoregularidadefgts_dia != "") {
          $this->si59_dtemissaocertidaoregularidadefgts = $this->si59_dtemissaocertidaoregularidadefgts_ano . "-" . $this->si59_dtemissaocertidaoregularidadefgts_mes . "-" . $this->si59_dtemissaocertidaoregularidadefgts_dia;
        }
      }
      if ($this->si59_dtvalidadecertidaoregularidadefgts == "") {
        $this->si59_dtvalidadecertidaoregularidadefgts_dia = ($this->si59_dtvalidadecertidaoregularidadefgts_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadefgts_dia"] : $this->si59_dtvalidadecertidaoregularidadefgts_dia);
        $this->si59_dtvalidadecertidaoregularidadefgts_mes = ($this->si59_dtvalidadecertidaoregularidadefgts_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadefgts_mes"] : $this->si59_dtvalidadecertidaoregularidadefgts_mes);
        $this->si59_dtvalidadecertidaoregularidadefgts_ano = ($this->si59_dtvalidadecertidaoregularidadefgts_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadefgts_ano"] : $this->si59_dtvalidadecertidaoregularidadefgts_ano);
        if ($this->si59_dtvalidadecertidaoregularidadefgts_dia != "") {
          $this->si59_dtvalidadecertidaoregularidadefgts = $this->si59_dtvalidadecertidaoregularidadefgts_ano . "-" . $this->si59_dtvalidadecertidaoregularidadefgts_mes . "-" . $this->si59_dtvalidadecertidaoregularidadefgts_dia;
        }
      }
      $this->si59_nrocndt = ($this->si59_nrocndt == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_nrocndt"] : $this->si59_nrocndt);
      if ($this->si59_dtemissaocndt == "") {
        $this->si59_dtemissaocndt_dia = ($this->si59_dtemissaocndt_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocndt_dia"] : $this->si59_dtemissaocndt_dia);
        $this->si59_dtemissaocndt_mes = ($this->si59_dtemissaocndt_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocndt_mes"] : $this->si59_dtemissaocndt_mes);
        $this->si59_dtemissaocndt_ano = ($this->si59_dtemissaocndt_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocndt_ano"] : $this->si59_dtemissaocndt_ano);
        if ($this->si59_dtemissaocndt_dia != "") {
          $this->si59_dtemissaocndt = $this->si59_dtemissaocndt_ano . "-" . $this->si59_dtemissaocndt_mes . "-" . $this->si59_dtemissaocndt_dia;
        }
      }
      if ($this->si59_dtvalidadecndt == "") {
        $this->si59_dtvalidadecndt_dia = ($this->si59_dtvalidadecndt_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecndt_dia"] : $this->si59_dtvalidadecndt_dia);
        $this->si59_dtvalidadecndt_mes = ($this->si59_dtvalidadecndt_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecndt_mes"] : $this->si59_dtvalidadecndt_mes);
        $this->si59_dtvalidadecndt_ano = ($this->si59_dtvalidadecndt_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecndt_ano"] : $this->si59_dtvalidadecndt_ano);
        if ($this->si59_dtvalidadecndt_dia != "") {
          $this->si59_dtvalidadecndt = $this->si59_dtvalidadecndt_ano . "-" . $this->si59_dtvalidadecndt_mes . "-" . $this->si59_dtvalidadecndt_dia;
        }
      }
      $this->si59_mes = ($this->si59_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_mes"] : $this->si59_mes);
      $this->si59_instit = ($this->si59_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_instit"] : $this->si59_instit);
    } else {
      $this->si59_sequencial = ($this->si59_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si59_sequencial"] : $this->si59_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si59_sequencial)
  {
    $this->atualizacampos();
    if ($this->si59_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si59_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si59_exerciciolicitacao == null) {
      $this->si59_exerciciolicitacao = "0";
    }
    if ($this->si59_tipodocumento == null) {
      $this->si59_tipodocumento = "0";
    }
    if ($this->si59_datacredenciamento == null) {
      $this->si59_datacredenciamento = "null";
    }
    if ($this->si59_nrolote == null) {
      $this->si59_nrolote = "0";
    }
    if ($this->si59_coditem == null) {
      $this->si59_coditem = "0";
    }
    if ($this->si59_dataemissaocertidaoregularidadeinss == null) {
      $this->si59_dataemissaocertidaoregularidadeinss = "null";
    }
    if ($this->si59_dtvalidadecertidaoregularidadeinss == null) {
      $this->si59_dtvalidadecertidaoregularidadeinss = "null";
    }
    if ($this->si59_dtemissaocertidaoregularidadefgts == null) {
      $this->si59_dtemissaocertidaoregularidadefgts = "null";
    }
    if ($this->si59_dtvalidadecertidaoregularidadefgts == null) {
      $this->si59_dtvalidadecertidaoregularidadefgts = "null";
    }
    if ($this->si59_dtemissaocndt == null) {
      $this->si59_dtemissaocndt = "null";
    }
    if ($this->si59_dtvalidadecndt == null) {
      $this->si59_dtvalidadecndt = "null";
    }
    if ($this->si59_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si59_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si59_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si59_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si59_sequencial == "" || $si59_sequencial == null) {
      $result = db_query("select nextval('hablic202018_si59_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: hablic202018_si59_sequencial_seq do campo: si59_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si59_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from hablic202018_si59_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si59_sequencial)) {
        $this->erro_sql = " Campo si59_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si59_sequencial = $si59_sequencial;
      }
    }
    if (($this->si59_sequencial == null) || ($this->si59_sequencial == "")) {
      $this->erro_sql = " Campo si59_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into hablic202018(
                                       si59_sequencial 
                                      ,si59_tiporegistro 
                                      ,si59_codorgao 
                                      ,si59_codunidadesub 
                                      ,si59_exerciciolicitacao 
                                      ,si59_nroprocessolicitatorio 
                                      ,si59_tipodocumento 
                                      ,si59_nrodocumento 
                                      ,si59_datacredenciamento 
                                      ,si59_nrolote 
                                      ,si59_coditem 
                                      ,si59_nroinscricaoestadual 
                                      ,si59_ufinscricaoestadual 
                                      ,si59_nrocertidaoregularidadeinss 
                                      ,si59_dataemissaocertidaoregularidadeinss 
                                      ,si59_dtvalidadecertidaoregularidadeinss 
                                      ,si59_nrocertidaoregularidadefgts 
                                      ,si59_dtemissaocertidaoregularidadefgts 
                                      ,si59_dtvalidadecertidaoregularidadefgts 
                                      ,si59_nrocndt 
                                      ,si59_dtemissaocndt 
                                      ,si59_dtvalidadecndt 
                                      ,si59_mes 
                                      ,si59_instit 
                       )
                values (
                                $this->si59_sequencial 
                               ,$this->si59_tiporegistro 
                               ,'$this->si59_codorgao' 
                               ,'$this->si59_codunidadesub' 
                               ,$this->si59_exerciciolicitacao 
                               ,'$this->si59_nroprocessolicitatorio' 
                               ,$this->si59_tipodocumento 
                               ,'$this->si59_nrodocumento' 
                               ," . ($this->si59_datacredenciamento == "null" || $this->si59_datacredenciamento == "" ? "null" : "'" . $this->si59_datacredenciamento . "'") . " 
                               ,$this->si59_nrolote 
                               ,$this->si59_coditem 
                               ,'$this->si59_nroinscricaoestadual' 
                               ,'$this->si59_ufinscricaoestadual' 
                               ,'$this->si59_nrocertidaoregularidadeinss' 
                               ," . ($this->si59_dataemissaocertidaoregularidadeinss == "null" || $this->si59_dataemissaocertidaoregularidadeinss == "" ? "null" : "'" . $this->si59_dataemissaocertidaoregularidadeinss . "'") . " 
                               ," . ($this->si59_dtvalidadecertidaoregularidadeinss == "null" || $this->si59_dtvalidadecertidaoregularidadeinss == "" ? "null" : "'" . $this->si59_dtvalidadecertidaoregularidadeinss . "'") . " 
                               ,'$this->si59_nrocertidaoregularidadefgts' 
                               ," . ($this->si59_dtemissaocertidaoregularidadefgts == "null" || $this->si59_dtemissaocertidaoregularidadefgts == "" ? "null" : "'" . $this->si59_dtemissaocertidaoregularidadefgts . "'") . " 
                               ," . ($this->si59_dtvalidadecertidaoregularidadefgts == "null" || $this->si59_dtvalidadecertidaoregularidadefgts == "" ? "null" : "'" . $this->si59_dtvalidadecertidaoregularidadefgts . "'") . " 
                               ,'$this->si59_nrocndt' 
                               ," . ($this->si59_dtemissaocndt == "null" || $this->si59_dtemissaocndt == "" ? "null" : "'" . $this->si59_dtemissaocndt . "'") . " 
                               ," . ($this->si59_dtvalidadecndt == "null" || $this->si59_dtvalidadecndt == "" ? "null" : "'" . $this->si59_dtvalidadecndt . "'") . " 
                               ,$this->si59_mes 
                               ,$this->si59_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "hablic202018 ($this->si59_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "hablic202018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "hablic202018 ($this->si59_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si59_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si59_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010056,'$this->si59_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010288,2010056,'','" . AddSlashes(pg_result($resaco, 0, 'si59_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010059,'','" . AddSlashes(pg_result($resaco, 0, 'si59_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010060,'','" . AddSlashes(pg_result($resaco, 0, 'si59_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010061,'','" . AddSlashes(pg_result($resaco, 0, 'si59_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010062,'','" . AddSlashes(pg_result($resaco, 0, 'si59_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010063,'','" . AddSlashes(pg_result($resaco, 0, 'si59_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010064,'','" . AddSlashes(pg_result($resaco, 0, 'si59_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010065,'','" . AddSlashes(pg_result($resaco, 0, 'si59_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010066,'','" . AddSlashes(pg_result($resaco, 0, 'si59_datacredenciamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010067,'','" . AddSlashes(pg_result($resaco, 0, 'si59_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010068,'','" . AddSlashes(pg_result($resaco, 0, 'si59_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010069,'','" . AddSlashes(pg_result($resaco, 0, 'si59_nroinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010070,'','" . AddSlashes(pg_result($resaco, 0, 'si59_ufinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010071,'','" . AddSlashes(pg_result($resaco, 0, 'si59_nrocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010072,'','" . AddSlashes(pg_result($resaco, 0, 'si59_dataemissaocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010076,'','" . AddSlashes(pg_result($resaco, 0, 'si59_dtvalidadecertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010077,'','" . AddSlashes(pg_result($resaco, 0, 'si59_nrocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010078,'','" . AddSlashes(pg_result($resaco, 0, 'si59_dtemissaocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010079,'','" . AddSlashes(pg_result($resaco, 0, 'si59_dtvalidadecertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010080,'','" . AddSlashes(pg_result($resaco, 0, 'si59_nrocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010081,'','" . AddSlashes(pg_result($resaco, 0, 'si59_dtemissaocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010082,'','" . AddSlashes(pg_result($resaco, 0, 'si59_dtvalidadecndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2010083,'','" . AddSlashes(pg_result($resaco, 0, 'si59_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010288,2011571,'','" . AddSlashes(pg_result($resaco, 0, 'si59_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si59_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update hablic202018 set ";
    $virgula = "";
    if (trim($this->si59_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_sequencial"])) {
      if (trim($this->si59_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si59_sequencial"])) {
        $this->si59_sequencial = "0";
      }
      $sql .= $virgula . " si59_sequencial = $this->si59_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si59_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_tiporegistro"])) {
      $sql .= $virgula . " si59_tiporegistro = $this->si59_tiporegistro ";
      $virgula = ",";
      if (trim($this->si59_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si59_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si59_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_codorgao"])) {
      $sql .= $virgula . " si59_codorgao = '$this->si59_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si59_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_codunidadesub"])) {
      $sql .= $virgula . " si59_codunidadesub = '$this->si59_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si59_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_exerciciolicitacao"])) {
      if (trim($this->si59_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si59_exerciciolicitacao"])) {
        $this->si59_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si59_exerciciolicitacao = $this->si59_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si59_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si59_nroprocessolicitatorio = '$this->si59_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si59_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_tipodocumento"])) {
      if (trim($this->si59_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si59_tipodocumento"])) {
        $this->si59_tipodocumento = "0";
      }
      $sql .= $virgula . " si59_tipodocumento = $this->si59_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si59_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_nrodocumento"])) {
      $sql .= $virgula . " si59_nrodocumento = '$this->si59_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si59_datacredenciamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_datacredenciamento_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si59_datacredenciamento_dia"] != "")) {
      $sql .= $virgula . " si59_datacredenciamento = '$this->si59_datacredenciamento' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si59_datacredenciamento_dia"])) {
        $sql .= $virgula . " si59_datacredenciamento = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si59_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_nrolote"])) {
      if (trim($this->si59_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si59_nrolote"])) {
        $this->si59_nrolote = "0";
      }
      $sql .= $virgula . " si59_nrolote = $this->si59_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si59_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_coditem"])) {
      if (trim($this->si59_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si59_coditem"])) {
        $this->si59_coditem = "0";
      }
      $sql .= $virgula . " si59_coditem = $this->si59_coditem ";
      $virgula = ",";
    }
    if (trim($this->si59_nroinscricaoestadual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_nroinscricaoestadual"])) {
      $sql .= $virgula . " si59_nroinscricaoestadual = '$this->si59_nroinscricaoestadual' ";
      $virgula = ",";
    }
    if (trim($this->si59_ufinscricaoestadual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_ufinscricaoestadual"])) {
      $sql .= $virgula . " si59_ufinscricaoestadual = '$this->si59_ufinscricaoestadual' ";
      $virgula = ",";
    }
    if (trim($this->si59_nrocertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_nrocertidaoregularidadeinss"])) {
      $sql .= $virgula . " si59_nrocertidaoregularidadeinss = '$this->si59_nrocertidaoregularidadeinss' ";
      $virgula = ",";
    }
    if (trim($this->si59_dataemissaocertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_dataemissaocertidaoregularidadeinss_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si59_dataemissaocertidaoregularidadeinss_dia"] != "")) {
      $sql .= $virgula . " si59_dataemissaocertidaoregularidadeinss = '$this->si59_dataemissaocertidaoregularidadeinss' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dataemissaocertidaoregularidadeinss_dia"])) {
        $sql .= $virgula . " si59_dataemissaocertidaoregularidadeinss = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si59_dtvalidadecertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadeinss_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadeinss_dia"] != "")) {
      $sql .= $virgula . " si59_dtvalidadecertidaoregularidadeinss = '$this->si59_dtvalidadecertidaoregularidadeinss' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadeinss_dia"])) {
        $sql .= $virgula . " si59_dtvalidadecertidaoregularidadeinss = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si59_nrocertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_nrocertidaoregularidadefgts"])) {
      $sql .= $virgula . " si59_nrocertidaoregularidadefgts = '$this->si59_nrocertidaoregularidadefgts' ";
      $virgula = ",";
    }
    if (trim($this->si59_dtemissaocertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocertidaoregularidadefgts_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocertidaoregularidadefgts_dia"] != "")) {
      $sql .= $virgula . " si59_dtemissaocertidaoregularidadefgts = '$this->si59_dtemissaocertidaoregularidadefgts' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocertidaoregularidadefgts_dia"])) {
        $sql .= $virgula . " si59_dtemissaocertidaoregularidadefgts = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si59_dtvalidadecertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadefgts_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadefgts_dia"] != "")) {
      $sql .= $virgula . " si59_dtvalidadecertidaoregularidadefgts = '$this->si59_dtvalidadecertidaoregularidadefgts' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadefgts_dia"])) {
        $sql .= $virgula . " si59_dtvalidadecertidaoregularidadefgts = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si59_nrocndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_nrocndt"])) {
      $sql .= $virgula . " si59_nrocndt = '$this->si59_nrocndt' ";
      $virgula = ",";
    }
    if (trim($this->si59_dtemissaocndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocndt_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocndt_dia"] != "")) {
      $sql .= $virgula . " si59_dtemissaocndt = '$this->si59_dtemissaocndt' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocndt_dia"])) {
        $sql .= $virgula . " si59_dtemissaocndt = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si59_dtvalidadecndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecndt_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecndt_dia"] != "")) {
      $sql .= $virgula . " si59_dtvalidadecndt = '$this->si59_dtvalidadecndt' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecndt_dia"])) {
        $sql .= $virgula . " si59_dtvalidadecndt = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si59_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_mes"])) {
      $sql .= $virgula . " si59_mes = $this->si59_mes ";
      $virgula = ",";
      if (trim($this->si59_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si59_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si59_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si59_instit"])) {
      $sql .= $virgula . " si59_instit = $this->si59_instit ";
      $virgula = ",";
      if (trim($this->si59_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si59_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si59_sequencial != null) {
      $sql .= " si59_sequencial = $this->si59_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si59_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010056,'$this->si59_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_sequencial"]) || $this->si59_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010056,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_sequencial')) . "','$this->si59_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_tiporegistro"]) || $this->si59_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010059,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_tiporegistro')) . "','$this->si59_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_codorgao"]) || $this->si59_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010060,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_codorgao')) . "','$this->si59_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_codunidadesub"]) || $this->si59_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010061,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_codunidadesub')) . "','$this->si59_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_exerciciolicitacao"]) || $this->si59_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010062,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_exerciciolicitacao')) . "','$this->si59_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_nroprocessolicitatorio"]) || $this->si59_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010063,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_nroprocessolicitatorio')) . "','$this->si59_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_tipodocumento"]) || $this->si59_tipodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010064,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_tipodocumento')) . "','$this->si59_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_nrodocumento"]) || $this->si59_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010065,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_nrodocumento')) . "','$this->si59_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_datacredenciamento"]) || $this->si59_datacredenciamento != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010066,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_datacredenciamento')) . "','$this->si59_datacredenciamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_nrolote"]) || $this->si59_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010067,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_nrolote')) . "','$this->si59_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_coditem"]) || $this->si59_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010068,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_coditem')) . "','$this->si59_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_nroinscricaoestadual"]) || $this->si59_nroinscricaoestadual != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010069,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_nroinscricaoestadual')) . "','$this->si59_nroinscricaoestadual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_ufinscricaoestadual"]) || $this->si59_ufinscricaoestadual != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010070,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_ufinscricaoestadual')) . "','$this->si59_ufinscricaoestadual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_nrocertidaoregularidadeinss"]) || $this->si59_nrocertidaoregularidadeinss != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010071,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_nrocertidaoregularidadeinss')) . "','$this->si59_nrocertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dataemissaocertidaoregularidadeinss"]) || $this->si59_dataemissaocertidaoregularidadeinss != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010072,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_dataemissaocertidaoregularidadeinss')) . "','$this->si59_dataemissaocertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadeinss"]) || $this->si59_dtvalidadecertidaoregularidadeinss != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010076,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_dtvalidadecertidaoregularidadeinss')) . "','$this->si59_dtvalidadecertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_nrocertidaoregularidadefgts"]) || $this->si59_nrocertidaoregularidadefgts != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010077,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_nrocertidaoregularidadefgts')) . "','$this->si59_nrocertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocertidaoregularidadefgts"]) || $this->si59_dtemissaocertidaoregularidadefgts != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010078,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_dtemissaocertidaoregularidadefgts')) . "','$this->si59_dtemissaocertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecertidaoregularidadefgts"]) || $this->si59_dtvalidadecertidaoregularidadefgts != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010079,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_dtvalidadecertidaoregularidadefgts')) . "','$this->si59_dtvalidadecertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_nrocndt"]) || $this->si59_nrocndt != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010080,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_nrocndt')) . "','$this->si59_nrocndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtemissaocndt"]) || $this->si59_dtemissaocndt != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010081,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_dtemissaocndt')) . "','$this->si59_dtemissaocndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_dtvalidadecndt"]) || $this->si59_dtvalidadecndt != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010082,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_dtvalidadecndt')) . "','$this->si59_dtvalidadecndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_mes"]) || $this->si59_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2010083,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_mes')) . "','$this->si59_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si59_instit"]) || $this->si59_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010288,2011571,'" . AddSlashes(pg_result($resaco, $conresaco, 'si59_instit')) . "','$this->si59_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "hablic202018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si59_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "hablic202018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si59_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si59_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao 
  function excluir($si59_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si59_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010056,'$si59_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010288,2010056,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010059,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010060,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010061,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010062,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010063,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010064,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010065,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010066,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_datacredenciamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010067,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010068,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010069,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_nroinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010070,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_ufinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010071,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_nrocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010072,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_dataemissaocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010076,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_dtvalidadecertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010077,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_nrocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010078,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_dtemissaocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010079,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_dtvalidadecertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010080,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_nrocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010081,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_dtemissaocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010082,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_dtvalidadecndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2010083,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010288,2011571,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si59_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from hablic202018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si59_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si59_sequencial = $si59_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "hablic202018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si59_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "hablic202018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si59_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si59_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:hablic202018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql 
  function sql_query($si59_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from hablic202018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si59_sequencial != null) {
        $sql2 .= " where hablic202018.si59_sequencial = $si59_sequencial ";
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
  function sql_query_file($si59_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from hablic202018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si59_sequencial != null) {
        $sql2 .= " where hablic202018.si59_sequencial = $si59_sequencial ";
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
