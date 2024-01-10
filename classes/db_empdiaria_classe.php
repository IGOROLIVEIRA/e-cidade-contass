<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

//MODULO: empenho
//CLASSE DA ENTIDADE empdiaria
class cl_empdiaria
{
  // cria variaveis de erro 
  var $rotulo     = null;
  var $query_sql  = null;
  var $numrows    = 0;
  var $numrows_incluir = 0;
  var $numrows_alterar = 0;
  var $numrows_excluir = 0;
  var $erro_status = null;
  var $erro_sql   = null;
  var $erro_banco = null;
  var $erro_msg   = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo 
  var $e140_sequencial = 0;
  var $e140_codord = 0;
  var $e140_dtautorizacao = null;
  var $e140_matricula = 0;
  var $e140_cargo = '';
  var $e140_dtinicial = null;
  var $e140_dtfinal = null;
  var $e140_origem = '';
  var $e140_destino = '';
  var $e140_qtddiarias = 0;
  var $e140_vrldiariauni = 0;
  var $e140_transporte = '';
  var $e140_vlrtransport = 0;
  var $e140_objetivo = '';
  var $e140_horainicial = '';
  var $e140_horafinal = '';
  var $e140_qtdhospedagens = 0;
  var $e140_vrlhospedagemuni = 0;
  var $e140_qtddiariaspernoite = 0;
  var $e140_vrldiariaspernoiteuni = 0;
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                e140_sequencial = int8 = Sequencial,
                e140_codord = int8 = Codigo de Ordem de Pagamento,
                e140_dtautorizacao = DATE = Data de Autorização,
                e140_matricula = int8 = Matricula,
                e140_cargo = varchar(60) = Cargo,
                e140_dtinicial = DATE = Data Inicial da Viagem,
                e140_dtfinal = DATE = Data Final da Viagem,
                e140_origem = varchar(60) = Origem,
                e140_destino = varchar(60) = Destino,
                e140_qtddiarias = float4 = Quantidade de Diárias,
                e140_vrldiariauni = float8 = Valor Unitario da Diária,
                e140_transporte = varchar(60) = Transporte,
                e140_vlrtransport = float8 = Valor do Transporte,
                e140_objetivo = varchar(500) = Objetivo da Viagem,
                e140_horainicial = varchar(5) = Hora Inicial,
                e140_horafinal = varchar(5) = Hora Final,
                e140_qtdhospedagens = float4 = Quantidade de Hospedagens,
                e140_vrlhospedagemuni = float8 = Valor Unitario da Hospedagem,
                e140_qtddiariaspernoite = float4 = Quantidade de Diárias Pernoite,
                e140_vrldiariaspernoiteuni = float8 = Valor Unitario da Diária Pernoite,
                 ";
  //funcao construtor da classe 
  function cl_empdiaria()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("empdiaria");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
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
    $this->e140_dtautorizacao = ($this->e140_dtautorizacao === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_dtautorizacao"] : $this->e140_dtautorizacao);
    $this->e140_matricula = ($this->e140_matricula === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_matricula"] : $this->e140_matricula);
    $this->e140_cargo = ($this->e140_cargo === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_cargo"] : $this->e140_cargo);
    $this->e140_dtinicial = ($this->e140_dtinicial === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_dtinicial"] : $this->e140_dtinicial);
    $this->e140_dtfinal = ($this->e140_dtfinal === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_dtfinal"] : $this->e140_dtfinal);
    $this->e140_origem = ($this->e140_origem === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_origem"] : $this->e140_origem);
    $this->e140_destino = ($this->e140_destino === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_destino"] : $this->e140_destino);
    $this->e140_qtddiarias = ($this->e140_qtddiarias === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_qtddiarias"] : $this->e140_qtddiarias);
    $this->e140_vrldiariauni = ($this->e140_vrldiariauni === '' ? @$GLOBALS["HTTP_POST_VARS"]["e140_vrldiariauni"] : $this->e140_vrldiariauni);
    $this->e140_transporte = ($this->e140_transporte === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_transporte"] : $this->e140_transporte);
    $this->e140_vlrtransport = ($this->e140_vlrtransport === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_vlrtransport"] : $this->e140_vlrtransport);
    $this->e140_objetivo = ($this->e140_objetivo === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_objetivo"] : $this->e140_objetivo);
    $this->e140_horainicial = ($this->e140_horainicial === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_horainicial"] : $this->e140_horainicial);
    $this->e140_horafinal = ($this->e140_horafinal === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_horafinal"] : $this->e140_horafinal);
    $this->e140_qtdhospedagens = ($this->e140_qtdhospedagens === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_qtdhospedagens"] : $this->e140_qtdhospedagens);
    $this->e140_vrlhospedagemuni = ($this->e140_vrlhospedagemuni === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_vrlhospedagemuni"] : $this->e140_vrlhospedagemuni);
    $this->e140_qtddiariaspernoite = ($this->e140_qtddiariaspernoite === "" ? @$GLOBALS["HTTP_POST_VARS"]["e140_qtddiariaspernoite"] : $this->e140_qtddiariaspernoite);
    $this->e140_vrldiariaspernoiteuni = ($this->e140_vrldiariaspernoiteuni === '' ? @$GLOBALS["HTTP_POST_VARS"]["e140_vrldiariaspernoiteuni"] : $this->e140_vrldiariaspernoiteuni);

  }
  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    if (($this->e140_codord == null) || ($this->e140_codord == "")) {
      $this->erro_sql = " Campo e140_codord nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    if (($this->e140_dtautorizacao == null) || ($this->e140_dtautorizacao == "")) {
      $this->erro_sql = " Campo e140_dtautorizacao nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    if (($this->e140_matricula == null) || ($this->e140_matricula == "")) {
      $this->erro_sql = " Campo e140_matricula nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    if (($this->e140_dtinicial == null) || ($this->e140_dtinicial == "")) {
      $this->erro_sql = " Campo e140_dtinicial nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    if (($this->e140_dtfinal == null) || ($this->e140_dtfinal == "")) {
      $this->erro_sql = " Campo e140_dtfinal nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    if (($this->e140_origem == null) || ($this->e140_origem == "")) {
      $this->erro_sql = " Campo e140_origem nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    if (($this->e140_destino == null) || ($this->e140_destino == "")) {
      $this->erro_sql = " Campo e140_destino nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    if (($this->e140_objetivo == null) || ($this->e140_objetivo == "")) {
      $this->erro_sql = " Campo e140_objetivo nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    if (($this->e140_horainicial == null) || ($this->e140_horainicial == "")) {
      $this->erro_sql = " Campo e140_horainicial nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    if (($this->e140_horafinal == null) || ($this->e140_horafinal == "")) {
      $this->erro_sql = " Campo e140_horafinal nao declarado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into empdiaria(
                                   e140_codord
                                  ,e140_dtautorizacao
                                  ,e140_matricula
                                  ,e140_cargo
                                  ,e140_dtinicial
                                  ,e140_dtfinal
                                  ,e140_origem
                                  ,e140_destino
                                  ,e140_qtddiarias
                                  ,e140_vrldiariauni
                                  ,e140_transporte
                                  ,e140_vlrtransport
                                  ,e140_objetivo
                                  ,e140_horainicial        
                                  ,e140_horafinal        
                                  ,e140_qtdhospedagens        
                                  ,e140_vrlhospedagemuni 
                                  ,e140_qtddiariaspernoite
                                  ,e140_vrldiariaspernoiteuni      
                       )
                values (
                                  $this->e140_codord
                                  ,'$this->e140_dtautorizacao'
                                  ,$this->e140_matricula
                                  ,'$this->e140_cargo'
                                  ,'$this->e140_dtinicial'
                                  ,'$this->e140_dtfinal'
                                  ,'$this->e140_origem'
                                  ,'$this->e140_destino'
                                  ,$this->e140_qtddiarias
                                  ,$this->e140_vrldiariauni
                                  ,'$this->e140_transporte'
                                  ,$this->e140_vlrtransport
                                  ,'$this->e140_objetivo'
                                  ,'$this->e140_horainicial'        
                                  ,'$this->e140_horafinal'        
                                  ,$this->e140_qtdhospedagens        
                                  ,$this->e140_vrlhospedagemuni
                                  ,$this->e140_qtddiariaspernoite
                                  ,$this->e140_vrldiariaspernoiteuni  
                      )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Houve um erro durante o cadastro.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n\\n";
    $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n" . $this->erro_sql . " \\n\\n";
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);

    $result = db_query("select currval('empdiaria_e140_sequencial_seq')");
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Verifique o cadastro da sequencia: empdiaria_e140_sequencial_seq do campo: e140_sequencial";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->e140_sequencial = pg_result($result, 0, 0);

    $resaco = $this->sql_record($this->sql_query_file($this->e140_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),'$this->e140_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_sequencial'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_codord'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_codord')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_dtautorizacao'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_dtautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_matricula'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_matricula')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_cargo'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_cargo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_dtinicial'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_dtinicial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_dtfinal'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_dtfinal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_origem'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_origem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_destino'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_destino')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_qtddiarias'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_qtddiarias')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vrldiariauni'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_vrldiariauni')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_transporte'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_transporte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vlrtransport'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_vlrtransport')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_objetivo'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_objetivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_horainicial'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_horainicial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_horafinal'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_horafinal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_qtdhospedagens'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_qtdhospedagens')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vrlhospedagemuni'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_vrlhospedagemuni')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_qtddiariaspernoite'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_qtddiariaspernoite')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vrldiariaspernoiteuni'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_vrldiariaspernoiteuni')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }

    return true;
  }

  // funcao para alteracao
  function alterar($e140_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update empdiaria set ";
    $virgula = "";
    if (trim($this->e140_matricula) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_matricula"])) {
      $sql  .= $virgula . " e140_matricula = '$this->e140_matricula' ";
      $virgula = ",";
      if (trim($this->e140_matricula) == null) {
        $this->erro_sql = " Campo e140_matricula nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e140_cargo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_cargo"])) {
      $sql  .= $virgula . " e140_cargo = '$this->e140_cargo' ";
      $virgula = ",";
      if (trim($this->e140_cargo) == null) {
        $this->erro_sql = " Campo e140_cargo nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e140_dtautorizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_dtautorizacao"])) {
      $sql  .= $virgula . " e140_dtautorizacao = '$this->e140_dtautorizacao' ";
      $virgula = ",";
      if (trim($this->e140_dtautorizacao) == null) {
        $this->erro_sql = " Campo e140_dtautorizacao nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e140_dtinicial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_dtinicial"])) {
      $sql  .= $virgula . " e140_dtinicial = '$this->e140_dtinicial' ";
      $virgula = ",";
      if (trim($this->e140_dtinicial) == null) {
        $this->erro_sql = " Campo e140_dtinicial nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e140_dtfinal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_dtfinal"])) {
      $sql  .= $virgula . " e140_dtfinal = '$this->e140_dtfinal' ";
      $virgula = ",";
      if (trim($this->e140_dtfinal) == null) {
        $this->erro_sql = " Campo e140_dtfinal nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e140_horainicial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_horainicial"])) {
      $sql  .= $virgula . " e140_horainicial = '$this->e140_horainicial' ";
      $virgula = ",";
      if (trim($this->e140_horainicial) == null) {
        $this->erro_sql = " Campo e140_horainicial nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e140_horafinal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_horafinal"])) {
      $sql  .= $virgula . " e140_horafinal = '$this->e140_horafinal' ";
      $virgula = ",";
      if (trim($this->e140_horafinal) == null) {
        $this->erro_sql = " Campo e140_horafinal nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e140_origem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_origem"])) {
      $sql  .= $virgula . " e140_origem = '$this->e140_origem' ";
      $virgula = ",";
      if (trim($this->e140_origem) == null) {
        $this->erro_sql = " Campo e140_origem nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e140_destino) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_destino"])) {
      $sql  .= $virgula . " e140_destino = '$this->e140_destino' ";
      $virgula = ",";
      if (trim($this->e140_destino) == null) {
        $this->erro_sql = " Campo e140_destino nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e140_qtddiarias) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_qtddiarias"])) {
      $sql  .= $virgula . " e140_qtddiarias = $this->e140_qtddiarias ";
      $virgula = ",";
    }
    if (trim($this->e140_vrldiariauni) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_vrldiariauni"])) {
      $sql  .= $virgula . " e140_vrldiariauni = $this->e140_vrldiariauni ";
      $virgula = ",";
    }
    if (trim($this->e140_qtddiariaspernoite) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_qtddiariaspernoite"])) {
      $sql  .= $virgula . " e140_qtddiariaspernoite = $this->e140_qtddiariaspernoite ";
      $virgula = ",";
    }
    if (trim($this->e140_vrldiariaspernoiteuni) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_vrldiariaspernoiteuni"])) {
      $sql  .= $virgula . " e140_vrldiariaspernoiteuni = $this->e140_vrldiariaspernoiteuni ";
      $virgula = ",";
    }
    if (trim($this->e140_qtdhospedagens) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_qtdhospedagens"])) {
      $sql  .= $virgula . " e140_qtdhospedagens = $this->e140_qtdhospedagens ";
      $virgula = ",";
    }
    if (trim($this->e140_vrlhospedagemuni) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_vrlhospedagemuni"])) {
      $sql  .= $virgula . " e140_vrlhospedagemuni = $this->e140_vrlhospedagemuni ";
      $virgula = ",";
    }
    if (trim($this->e140_transporte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_transporte"])) {
      $sql  .= $virgula . " e140_transporte = '$this->e140_transporte' ";
      $virgula = ",";
    }
    if (trim($this->e140_vlrtransport) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_vlrtransport"])) {
      $sql  .= $virgula . " e140_vlrtransport = $this->e140_vlrtransport ";
      $virgula = ",";
    }
    if (trim($this->e140_objetivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e140_objetivo"])) {
      $sql  .= $virgula . " e140_objetivo = '$this->e140_objetivo' ";
      $virgula = ",";
      if (trim($this->e140_objetivo) == null) {
        $this->erro_sql = " Campo e140_objetivo nao declarado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($e140_sequencial != null) {
      $sql .= " e140_sequencial = $e140_sequencial";
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Diária nao alterada. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Diária nao alterada. Alteracao Abortada.\\n";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return false;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        $resaco = $this->sql_record($this->sql_query_file($e140_sequencial));
        if ($this->numrows > 0) {
          for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac, 0, 0);
            $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
            $resac = db_query("insert into db_acountkey values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),'$e140_sequencial','A')");
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_codord"]) || $this->e140_codord != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_codord'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_codord')) . "','$this->e140_codord'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_dtautorizacao"]) || $this->e140_dtautorizacao != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_dtautorizacao'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_dtautorizacao')) . "','$this->e140_dtautorizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_matricula"]) || $this->e140_matricula != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_matricula'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_matricula')) . "','$this->e140_matricula'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_cargo"]) || $this->e140_cargo != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_cargo'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_cargo')) . "','$this->e140_cargo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_dtinicial"]) || $this->e140_dtinicial != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_dtinicial'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_dtinicial')) . "','$this->e140_dtinicial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_dtfinal"]) || $this->e140_dtfinal != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_dtfinal'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_dtfinal')) . "','$this->e140_dtfinal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_origem"]) || $this->e140_origem != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_origem'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_origem')) . "','$this->e140_origem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_destino"]) || $this->e140_destino != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_destino'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_destino')) . "','$this->e140_destino'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_qtddiarias"]) || $this->e140_qtddiarias != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_qtddiarias'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_qtddiarias')) . "','$this->e140_qtddiarias'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_vrldiariauni"]) || $this->e140_vrldiariauni != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vrldiariauni'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_vrldiariauni')) . "','$this->e140_vrldiariauni'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_transporte"]) || $this->e140_transporte != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_transporte'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_transporte')) . "','$this->e140_transporte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_vlrtransport"]) || $this->e140_vlrtransport != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vlrtransport'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_vlrtransport')) . "','$this->e140_vlrtransport'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_objetivo"]) || $this->e140_objetivo != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_objetivo'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_objetivo')) . "','$this->e140_objetivo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_horainicial"]) || $this->e140_horainicial != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_horainicial'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_horainicial')) . "','$this->e140_horainicial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_horafinal"]) || $this->e140_horafinal != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_horafinal'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_horafinal')) . "','$this->e140_horafinal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_qtdhospedagens"]) || $this->e140_qtdhospedagens != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_qtdhospedagens'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_qtdhospedagens')) . "','$this->e140_qtdhospedagens'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_vrlhospedagemuni"]) || $this->e140_vrlhospedagemuni != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vrlhospedagemuni'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_vrlhospedagemuni')) . "','$this->e140_vrlhospedagemuni'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_qtddiariaspernoite"]) || $this->e140_qtddiariaspernoite != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_qtddiariaspernoite'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_qtddiariaspernoite')) . "','$this->e140_qtddiariaspernoite'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
            if (isset($GLOBALS["HTTP_POST_VARS"]["e140_vrldiariaspernoiteuni"]) || $this->e140_vrldiariaspernoiteuni != null) {
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e140_vrldiariaspernoiteuni'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e140_vrldiariaspernoiteuni')) . "','$this->e140_vrldiariaspernoiteuni'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
          }
        }

        return true;
      }
    }
  }
  // funcao para exclusao 
  function excluir($e140_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($e140_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),'$e140_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empdiaria'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e140_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from empdiaria
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($e140_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " e140_sequencial = $e140_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Diária nao Excluída. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Diária nao Excluída. Exclusão Abortada.\\n";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
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
      $this->numrows    = 0;
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Erro ao selecionar os registros.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->numrows = pg_num_rows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Record Vazio na Tabela:empdiaria";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  function sql_query($e140_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from empdiaria ";
    $sql .= " inner join pagordem on e140_codord = e50_codord ";
    $sql .= " inner join empempenho on e50_numemp = e60_numemp ";
    $sql .= " inner join cgm on e60_numcgm = z01_numcgm ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($e140_sequencial != null) {
        $sql2 .= " where e140_sequencial = $e140_sequencial ";
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
  function sql_query_file($e140_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from empdiaria ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($e140_sequencial != null) {
        $sql2 .= " where empdiaria.e140_sequencial = $e140_sequencial ";
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
