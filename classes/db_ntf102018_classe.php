<?
//MODULO: sicom
//CLASSE DA ENTIDADE ntf102018
class cl_ntf102018
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
  var $si143_sequencial = 0;
  var $si143_tiporegistro = 0;
  var $si143_codnotafiscal = 0;
  var $si143_codorgao = null;
  var $si143_nfnumero = null;
  var $si143_nfserie = null;
  var $si143_tipodocumento = 0;
  var $si143_nrodocumento = null;
  var $si143_nroinscestadual = null;
  var $si143_nroinscmunicipal = null;
  var $si143_nomemunicipio = null;
  var $si143_cepmunicipio = 0;
  var $si143_ufcredor = null;
  var $si143_notafiscaleletronica = 0;
  var $si143_chaveacesso = 0;
  var $si143_outraChaveAcesso = null;
  var $si143_nfaidf = null;
  var $si143_dtemissaonf_dia = null;
  var $si143_dtemissaonf_mes = null;
  var $si143_dtemissaonf_ano = null;
  var $si143_dtemissaonf = null;
  var $si143_dtvencimentonf_dia = null;
  var $si143_dtvencimentonf_mes = null;
  var $si143_dtvencimentonf_ano = null;
  var $si143_dtvencimentonf = null;
  var $si143_nfvalortotal = 0;
  var $si143_nfvalordesconto = 0;
  var $si143_nfvalorliquido = 0;
  var $si143_mes = 0;
  var $si143_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si143_sequencial = int8 = sequencial
                 si143_tiporegistro = int8 = Tipo do  registro
                 si143_codnotafiscal = int8 = Código  Identificador da Nota Fiscal
                 si143_codorgao = varchar(2) = Código do órgão
                 si143_nfnumero = varchar(20) = Número da nota  fiscal
                 si143_nfserie = varchar(8) = Número de série  da nota fiscal
                 si143_tipodocumento = int8 = Tipo de  Documento do  credor
                 si143_nrodocumento = varchar(14) = Número do documento do credor
                 si143_nroinscestadual = varchar(30) = Número da  inscrição estadual
                 si143_nroinscmunicipal = varchar(30) = Número da  Inscrição  Municipal
                 si143_nomemunicipio = varchar(120) = Nome do  Município
                 si143_cepmunicipio = int8 = CEP do Município
                 si143_ufcredor = varchar(2) = UF da Inscrição  do Credor
                 si143_notafiscaleletronica = int8 = Identifica se a  nota fiscal
                 si143_chaveacesso = int8 = Chave para  consulta
                 si143_outraChaveAcesso = varchar(60) = Chave Nota Fiscal  Eletrônica
                 si143_nfaidf = varchar(15) = Número da  Autorização
                 si143_dtemissaonf = date = Data de emissão  da nota fiscal
                 si143_dtvencimentonf = date = Data de  vencimento
                 si143_nfvalortotal = float8 = Valor bruto da  Nota fiscal
                 si143_nfvalordesconto = float8 = Valor do desconto  em Nota Fiscal
                 si143_nfvalorliquido = float8 = Valor liquido da  Nota Fiscal
                 si143_mes = int8 = Mês
                 si143_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_ntf102018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ntf102018");
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
      $this->si143_sequencial = ($this->si143_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_sequencial"] : $this->si143_sequencial);
      $this->si143_tiporegistro = ($this->si143_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_tiporegistro"] : $this->si143_tiporegistro);
      $this->si143_codnotafiscal = ($this->si143_codnotafiscal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_codnotafiscal"] : $this->si143_codnotafiscal);
      $this->si143_codorgao = ($this->si143_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_codorgao"] : $this->si143_codorgao);
      $this->si143_nfnumero = ($this->si143_nfnumero == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nfnumero"] : $this->si143_nfnumero);
      $this->si143_nfserie = ($this->si143_nfserie == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nfserie"] : $this->si143_nfserie);
      $this->si143_tipodocumento = ($this->si143_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_tipodocumento"] : $this->si143_tipodocumento);
      $this->si143_nrodocumento = ($this->si143_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nrodocumento"] : $this->si143_nrodocumento);
      $this->si143_nroinscestadual = ($this->si143_nroinscestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nroinscestadual"] : $this->si143_nroinscestadual);
      $this->si143_nroinscmunicipal = ($this->si143_nroinscmunicipal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nroinscmunicipal"] : $this->si143_nroinscmunicipal);
      $this->si143_nomemunicipio = ($this->si143_nomemunicipio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nomemunicipio"] : $this->si143_nomemunicipio);
      $this->si143_cepmunicipio = ($this->si143_cepmunicipio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_cepmunicipio"] : $this->si143_cepmunicipio);
      $this->si143_ufcredor = ($this->si143_ufcredor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_ufcredor"] : $this->si143_ufcredor);
      $this->si143_notafiscaleletronica = ($this->si143_notafiscaleletronica == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_notafiscaleletronica"] : $this->si143_notafiscaleletronica);
      $this->si143_chaveacesso = ($this->si143_chaveacesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_chaveacesso"] : $this->si143_chaveacesso);
      $this->si143_outraChaveAcesso = ($this->si143_outraChaveAcesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_outraChaveAcesso"] : $this->si143_outraChaveAcesso);
      $this->si143_nfaidf = ($this->si143_nfaidf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nfaidf"] : $this->si143_nfaidf);
      if ($this->si143_dtemissaonf == "") {
        $this->si143_dtemissaonf_dia = ($this->si143_dtemissaonf_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_dtemissaonf_dia"] : $this->si143_dtemissaonf_dia);
        $this->si143_dtemissaonf_mes = ($this->si143_dtemissaonf_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_dtemissaonf_mes"] : $this->si143_dtemissaonf_mes);
        $this->si143_dtemissaonf_ano = ($this->si143_dtemissaonf_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_dtemissaonf_ano"] : $this->si143_dtemissaonf_ano);
        if ($this->si143_dtemissaonf_dia != "") {
          $this->si143_dtemissaonf = $this->si143_dtemissaonf_ano . "-" . $this->si143_dtemissaonf_mes . "-" . $this->si143_dtemissaonf_dia;
        }
      }
      if ($this->si143_dtvencimentonf == "") {
        $this->si143_dtvencimentonf_dia = ($this->si143_dtvencimentonf_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_dtvencimentonf_dia"] : $this->si143_dtvencimentonf_dia);
        $this->si143_dtvencimentonf_mes = ($this->si143_dtvencimentonf_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_dtvencimentonf_mes"] : $this->si143_dtvencimentonf_mes);
        $this->si143_dtvencimentonf_ano = ($this->si143_dtvencimentonf_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_dtvencimentonf_ano"] : $this->si143_dtvencimentonf_ano);
        if ($this->si143_dtvencimentonf_dia != "") {
          $this->si143_dtvencimentonf = $this->si143_dtvencimentonf_ano . "-" . $this->si143_dtvencimentonf_mes . "-" . $this->si143_dtvencimentonf_dia;
        }
      }
      $this->si143_nfvalortotal = ($this->si143_nfvalortotal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nfvalortotal"] : $this->si143_nfvalortotal);
      $this->si143_nfvalordesconto = ($this->si143_nfvalordesconto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nfvalordesconto"] : $this->si143_nfvalordesconto);
      $this->si143_nfvalorliquido = ($this->si143_nfvalorliquido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_nfvalorliquido"] : $this->si143_nfvalorliquido);
      $this->si143_mes = ($this->si143_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_mes"] : $this->si143_mes);
      $this->si143_instit = ($this->si143_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_instit"] : $this->si143_instit);
    } else {
      $this->si143_sequencial = ($this->si143_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si143_sequencial"] : $this->si143_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si143_sequencial)
  {
    $this->atualizacampos();
    if ($this->si143_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si143_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si143_codnotafiscal == null) {
      $this->si143_codnotafiscal = "0";
    }
    if ($this->si143_nfnumero == null) {
      $this->si143_nfnumero = "'0'";
    }
    if ($this->si143_tipodocumento == null) {
      $this->si143_tipodocumento = "0";
    }
    if ($this->si143_cepmunicipio == null) {
      $this->si143_cepmunicipio = "0";
    }
    if ($this->si143_notafiscaleletronica == null) {
      $this->si143_notafiscaleletronica = "0";
    }
    if ($this->si143_chaveacesso == null) {
      $this->si143_chaveacesso = "0";
    }
    if ($this->si143_dtemissaonf == null) {
      $this->si143_dtemissaonf = "null";
    }
    if ($this->si143_dtvencimentonf == null) {
      $this->si143_dtvencimentonf = "null";
    }
    if ($this->si143_nfvalortotal == null) {
      $this->si143_nfvalortotal = "0";
    }
    if ($this->si143_nfvalordesconto == null) {
      $this->si143_nfvalordesconto = "0";
    }
    if ($this->si143_nfvalorliquido == null) {
      $this->si143_nfvalorliquido = "0";
    }
    if ($this->si143_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si143_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si143_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si143_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si143_sequencial == "" || $si143_sequencial == null) {
      $result = db_query("select nextval('ntf102018_si143_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ntf102018_si143_sequencial_seq do campo: si143_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si143_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ntf102018_si143_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si143_sequencial)) {
        $this->erro_sql = " Campo si143_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si143_sequencial = $si143_sequencial;
      }
    }
    if (($this->si143_sequencial == null) || ($this->si143_sequencial == "")) {
      $this->erro_sql = " Campo si143_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into ntf102018(
                                       si143_sequencial
                                      ,si143_tiporegistro
                                      ,si143_codnotafiscal
                                      ,si143_codorgao
                                      ,si143_nfnumero
                                      ,si143_nfserie
                                      ,si143_tipodocumento
                                      ,si143_nrodocumento
                                      ,si143_nroinscestadual
                                      ,si143_nroinscmunicipal
                                      ,si143_nomemunicipio
                                      ,si143_cepmunicipio
                                      ,si143_ufcredor
                                      ,si143_notafiscaleletronica
                                      ,si143_chaveacesso
                                      ,si143_outraChaveAcesso
                                      ,si143_nfaidf
                                      ,si143_dtemissaonf
                                      ,si143_dtvencimentonf
                                      ,si143_nfvalortotal
                                      ,si143_nfvalordesconto
                                      ,si143_nfvalorliquido
                                      ,si143_mes
                                      ,si143_instit
                       )
                values (
                                $this->si143_sequencial
                               ,$this->si143_tiporegistro
                               ,$this->si143_codnotafiscal
                               ,'$this->si143_codorgao'
                               ,'$this->si143_nfnumero'
                               ,'$this->si143_nfserie'
                               ,$this->si143_tipodocumento
                               ,'$this->si143_nrodocumento'
                               ,'$this->si143_nroinscestadual'
                               ,'$this->si143_nroinscmunicipal'
                               ,'$this->si143_nomemunicipio'
                               ,$this->si143_cepmunicipio
                               ,'$this->si143_ufcredor'
                               ,$this->si143_notafiscaleletronica
                               ,'$this->si143_chaveacesso'
                               ,'$this->si143_outraChaveAcesso'
                               ,'$this->si143_nfaidf'
                               ," . ($this->si143_dtemissaonf == "null" || $this->si143_dtemissaonf == "" ? "null" : "'" . $this->si143_dtemissaonf . "'") . "
                               ," . ($this->si143_dtvencimentonf == "null" || $this->si143_dtvencimentonf == "" ? "null" : "'" . $this->si143_dtvencimentonf . "'") . "
                               ,$this->si143_nfvalortotal
                               ,$this->si143_nfvalordesconto
                               ,$this->si143_nfvalorliquido
                               ,$this->si143_mes
                               ,$this->si143_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ntf102018 ($this->si143_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ntf102018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ntf102018 ($this->si143_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si143_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si143_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2011048,'$this->si143_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010372,2011048,'','" . AddSlashes(pg_result($resaco, 0, 'si143_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011049,'','" . AddSlashes(pg_result($resaco, 0, 'si143_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011050,'','" . AddSlashes(pg_result($resaco, 0, 'si143_codnotafiscal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011051,'','" . AddSlashes(pg_result($resaco, 0, 'si143_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011052,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nfnumero')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011053,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nfserie')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011054,'','" . AddSlashes(pg_result($resaco, 0, 'si143_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011055,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011056,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nroinscestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011057,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nroinscmunicipal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011058,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nomemunicipio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011059,'','" . AddSlashes(pg_result($resaco, 0, 'si143_cepmunicipio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011060,'','" . AddSlashes(pg_result($resaco, 0, 'si143_ufcredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011061,'','" . AddSlashes(pg_result($resaco, 0, 'si143_notafiscaleletronica')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011062,'','" . AddSlashes(pg_result($resaco, 0, 'si143_chaveacesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011063,'','" . AddSlashes(pg_result($resaco, 0, 'si143_outraChaveAcesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011064,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nfaidf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011065,'','" . AddSlashes(pg_result($resaco, 0, 'si143_dtemissaonf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011066,'','" . AddSlashes(pg_result($resaco, 0, 'si143_dtvencimentonf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011067,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nfvalortotal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011068,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nfvalordesconto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011069,'','" . AddSlashes(pg_result($resaco, 0, 'si143_nfvalorliquido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011070,'','" . AddSlashes(pg_result($resaco, 0, 'si143_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010372,2011656,'','" . AddSlashes(pg_result($resaco, 0, 'si143_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si143_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ntf102018 set ";
    $virgula = "";
    if (trim($this->si143_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_sequencial"])) {
      if (trim($this->si143_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_sequencial"])) {
        $this->si143_sequencial = "0";
      }
      $sql .= $virgula . " si143_sequencial = $this->si143_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si143_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_tiporegistro"])) {
      $sql .= $virgula . " si143_tiporegistro = $this->si143_tiporegistro ";
      $virgula = ",";
      if (trim($this->si143_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si143_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si143_codnotafiscal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_codnotafiscal"])) {
      if (trim($this->si143_codnotafiscal) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_codnotafiscal"])) {
        $this->si143_codnotafiscal = "0";
      }
      $sql .= $virgula . " si143_codnotafiscal = $this->si143_codnotafiscal ";
      $virgula = ",";
    }
    if (trim($this->si143_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_codorgao"])) {
      $sql .= $virgula . " si143_codorgao = '$this->si143_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si143_nfnumero) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nfnumero"])) {
      if (trim($this->si143_nfnumero) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_nfnumero"])) {
        $this->si143_nfnumero = "'0'";
      }
      $sql .= $virgula . " si143_nfnumero = '$this->si143_nfnumero' ";
      $virgula = ",";
    }
    if (trim($this->si143_nfserie) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nfserie"])) {
      $sql .= $virgula . " si143_nfserie = '$this->si143_nfserie' ";
      $virgula = ",";
    }
    if (trim($this->si143_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_tipodocumento"])) {
      if (trim($this->si143_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_tipodocumento"])) {
        $this->si143_tipodocumento = "0";
      }
      $sql .= $virgula . " si143_tipodocumento = $this->si143_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si143_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nrodocumento"])) {
      $sql .= $virgula . " si143_nrodocumento = '$this->si143_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si143_nroinscestadual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nroinscestadual"])) {
      $sql .= $virgula . " si143_nroinscestadual = '$this->si143_nroinscestadual' ";
      $virgula = ",";
    }
    if (trim($this->si143_nroinscmunicipal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nroinscmunicipal"])) {
      $sql .= $virgula . " si143_nroinscmunicipal = '$this->si143_nroinscmunicipal' ";
      $virgula = ",";
    }
    if (trim($this->si143_nomemunicipio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nomemunicipio"])) {
      $sql .= $virgula . " si143_nomemunicipio = '$this->si143_nomemunicipio' ";
      $virgula = ",";
    }
    if (trim($this->si143_cepmunicipio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_cepmunicipio"])) {
      if (trim($this->si143_cepmunicipio) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_cepmunicipio"])) {
        $this->si143_cepmunicipio = "0";
      }
      $sql .= $virgula . " si143_cepmunicipio = $this->si143_cepmunicipio ";
      $virgula = ",";
    }
    if (trim($this->si143_ufcredor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_ufcredor"])) {
      $sql .= $virgula . " si143_ufcredor = '$this->si143_ufcredor' ";
      $virgula = ",";
    }
    if (trim($this->si143_notafiscaleletronica) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_notafiscaleletronica"])) {
      if (trim($this->si143_notafiscaleletronica) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_notafiscaleletronica"])) {
        $this->si143_notafiscaleletronica = "0";
      }
      $sql .= $virgula . " si143_notafiscaleletronica = $this->si143_notafiscaleletronica ";
      $virgula = ",";
    }
    if (trim($this->si143_chaveacesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_chaveacesso"])) {
      if (trim($this->si143_chaveacesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_chaveacesso"])) {
        $this->si143_chaveacesso = "0";
      }
      $sql .= $virgula . " si143_chaveacesso = '$this->si143_chaveacesso' ";
      $virgula = ",";
    }
    if (trim($this->si143_outraChaveAcesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_outraChaveAcesso"])) {
      $sql .= $virgula . " si143_outraChaveAcesso = '$this->si143_outraChaveAcesso' ";
      $virgula = ",";
    }
    if (trim($this->si143_nfaidf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nfaidf"])) {
      $sql .= $virgula . " si143_nfaidf = '$this->si143_nfaidf' ";
      $virgula = ",";
    }
    if (trim($this->si143_dtemissaonf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_dtemissaonf_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si143_dtemissaonf_dia"] != "")) {
      $sql .= $virgula . " si143_dtemissaonf = '$this->si143_dtemissaonf' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si143_dtemissaonf_dia"])) {
        $sql .= $virgula . " si143_dtemissaonf = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si143_dtvencimentonf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_dtvencimentonf_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si143_dtvencimentonf_dia"] != "")) {
      $sql .= $virgula . " si143_dtvencimentonf = '$this->si143_dtvencimentonf' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si143_dtvencimentonf_dia"])) {
        $sql .= $virgula . " si143_dtvencimentonf = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si143_nfvalortotal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nfvalortotal"])) {
      if (trim($this->si143_nfvalortotal) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_nfvalortotal"])) {
        $this->si143_nfvalortotal = "0";
      }
      $sql .= $virgula . " si143_nfvalortotal = $this->si143_nfvalortotal ";
      $virgula = ",";
    }
    if (trim($this->si143_nfvalordesconto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nfvalordesconto"])) {
      if (trim($this->si143_nfvalordesconto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_nfvalordesconto"])) {
        $this->si143_nfvalordesconto = "0";
      }
      $sql .= $virgula . " si143_nfvalordesconto = $this->si143_nfvalordesconto ";
      $virgula = ",";
    }
    if (trim($this->si143_nfvalorliquido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_nfvalorliquido"])) {
      if (trim($this->si143_nfvalorliquido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si143_nfvalorliquido"])) {
        $this->si143_nfvalorliquido = "0";
      }
      $sql .= $virgula . " si143_nfvalorliquido = $this->si143_nfvalorliquido ";
      $virgula = ",";
    }
    if (trim($this->si143_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_mes"])) {
      $sql .= $virgula . " si143_mes = $this->si143_mes ";
      $virgula = ",";
      if (trim($this->si143_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si143_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si143_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si143_instit"])) {
      $sql .= $virgula . " si143_instit = $this->si143_instit ";
      $virgula = ",";
      if (trim($this->si143_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si143_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si143_sequencial != null) {
      $sql .= " si143_sequencial = $this->si143_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si143_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011048,'$this->si143_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_sequencial"]) || $this->si143_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011048,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_sequencial')) . "','$this->si143_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_tiporegistro"]) || $this->si143_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011049,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_tiporegistro')) . "','$this->si143_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_codnotafiscal"]) || $this->si143_codnotafiscal != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011050,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_codnotafiscal')) . "','$this->si143_codnotafiscal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_codorgao"]) || $this->si143_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011051,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_codorgao')) . "','$this->si143_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nfnumero"]) || $this->si143_nfnumero != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011052,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nfnumero')) . "','$this->si143_nfnumero'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nfserie"]) || $this->si143_nfserie != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011053,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nfserie')) . "','$this->si143_nfserie'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_tipodocumento"]) || $this->si143_tipodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011054,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_tipodocumento')) . "','$this->si143_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nrodocumento"]) || $this->si143_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011055,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nrodocumento')) . "','$this->si143_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nroinscestadual"]) || $this->si143_nroinscestadual != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011056,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nroinscestadual')) . "','$this->si143_nroinscestadual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nroinscmunicipal"]) || $this->si143_nroinscmunicipal != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011057,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nroinscmunicipal')) . "','$this->si143_nroinscmunicipal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nomemunicipio"]) || $this->si143_nomemunicipio != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011058,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nomemunicipio')) . "','$this->si143_nomemunicipio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_cepmunicipio"]) || $this->si143_cepmunicipio != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011059,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_cepmunicipio')) . "','$this->si143_cepmunicipio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_ufcredor"]) || $this->si143_ufcredor != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011060,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_ufcredor')) . "','$this->si143_ufcredor'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_notafiscaleletronica"]) || $this->si143_notafiscaleletronica != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011061,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_notafiscaleletronica')) . "','$this->si143_notafiscaleletronica'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_chaveacesso"]) || $this->si143_chaveacesso != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011062,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_chaveacesso')) . "','$this->si143_chaveacesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_outraChaveAcesso"]) || $this->si143_outraChaveAcesso != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011063,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_outraChaveAcesso')) . "','$this->si143_outraChaveAcesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nfaidf"]) || $this->si143_nfaidf != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011064,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nfaidf')) . "','$this->si143_nfaidf'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_dtemissaonf"]) || $this->si143_dtemissaonf != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011065,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_dtemissaonf')) . "','$this->si143_dtemissaonf'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_dtvencimentonf"]) || $this->si143_dtvencimentonf != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011066,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_dtvencimentonf')) . "','$this->si143_dtvencimentonf'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nfvalortotal"]) || $this->si143_nfvalortotal != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011067,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nfvalortotal')) . "','$this->si143_nfvalortotal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nfvalordesconto"]) || $this->si143_nfvalordesconto != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011068,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nfvalordesconto')) . "','$this->si143_nfvalordesconto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_nfvalorliquido"]) || $this->si143_nfvalorliquido != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011069,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_nfvalorliquido')) . "','$this->si143_nfvalorliquido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_mes"]) || $this->si143_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011070,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_mes')) . "','$this->si143_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si143_instit"]) || $this->si143_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010372,2011656,'" . AddSlashes(pg_result($resaco, $conresaco, 'si143_instit')) . "','$this->si143_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ntf102018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si143_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ntf102018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si143_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si143_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si143_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si143_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011048,'$si143_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010372,2011048,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011049,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011050,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_codnotafiscal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011051,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011052,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nfnumero')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011053,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nfserie')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011054,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011055,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011056,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nroinscestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011057,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nroinscmunicipal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011058,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nomemunicipio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011059,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_cepmunicipio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011060,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_ufcredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011061,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_notafiscaleletronica')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011062,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_chaveacesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011063,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_outraChaveAcesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011064,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nfaidf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011065,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_dtemissaonf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011066,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_dtvencimentonf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011067,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nfvalortotal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011068,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nfvalordesconto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011069,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_nfvalorliquido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011070,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010372,2011656,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si143_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from ntf102018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si143_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si143_sequencial = $si143_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ntf102018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si143_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ntf102018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si143_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si143_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ntf102018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si143_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ntf102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si143_sequencial != null) {
        $sql2 .= " where ntf102018.si143_sequencial = $si143_sequencial ";
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
  function sql_query_file($si143_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ntf102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si143_sequencial != null) {
        $sql2 .= " where ntf102018.si143_sequencial = $si143_sequencial ";
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
