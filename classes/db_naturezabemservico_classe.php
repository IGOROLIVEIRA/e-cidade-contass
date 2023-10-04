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
//CLASSE DA ENTIDADE naturezabemservico
class cl_naturezabemservico
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
  var $e101_sequencial = 0;
  var $e101_descr = null;
  var $e101_resumo = null;
  var $e101_aliquota = 0;
  var $e101_codnaturezarendimento = null;
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 e101_sequencial = int4 = Sequencial 
                 e101_descr = text = Descrição
                 e101_resumo = varchar(120) = Resumo da descrição  
                 e101_aliquota = float8 = Alíquota
                 e101_codnaturezarendimento = int4 = Cod. Natureza do Rendimento
                 ";
  //funcao construtor da classe 
  function cl_naturezabemservico()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("naturezabemservico");
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
    if ($exclusao == false) {
      $this->e101_sequencial = ($this->e101_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["e101_sequencial"] : $this->e101_sequencial);
      $this->e101_descr = ($this->e101_descr == "" ? @$GLOBALS["HTTP_POST_VARS"]["e101_descr"] : $this->e101_descr);
      $this->e101_aliquota = ($this->e101_aliquota == "" ? @$GLOBALS["HTTP_POST_VARS"]["e101_aliquota"] : $this->e101_aliquota);
      $this->e101_codnaturezarendimento = ($this->e101_codnaturezarendimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["e101_codnaturezarendimento"] : $this->e101_codnaturezarendimento);
      if (strlen($this->e101_descr) > 120) {
        $this->e101_resumo = substr($this->e101_descr, 0, 117) . "...";
      } else {
        $this->e101_resumo = $this->e101_descr;
      }
    } else {
      $this->e101_sequencial = ($this->e101_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["e101_sequencial"] : $this->e101_sequencial);
      $this->e101_descr = ($this->e101_descr == "" ? @$GLOBALS["HTTP_POST_VARS"]["e101_descr"] : $this->e101_descr);
      $this->e101_aliquota = ($this->e101_aliquota == "" ? @$GLOBALS["HTTP_POST_VARS"]["e101_aliquota"] : $this->e101_aliquota);
      $this->e101_codnaturezarendimento = ($this->e101_codnaturezarendimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["e101_codnaturezarendimento"] : $this->e101_codnaturezarendimento);
      if (strlen($this->e101_descr) > 120) {
        $this->e101_resumo = substr($this->e101_descr, 0, 117) . "...";
      } else {
        $this->e101_resumo = $this->e101_descr;
      }
    }
  }
  // funcao para inclusao
  function incluir($e101_descr, $e101_aliquota, $e101_codnaturezarendimento)
  {
    $this->atualizacampos();
    if (($this->e101_descr == null) || ($this->e101_descr == "")) {
      $this->erro_sql = " Campo e101_descr nao declarado.";
      $this->erro_banco = "Descrição não informada";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->e101_aliquota == null) || ($this->e101_aliquota == "")) {
      $this->erro_sql = " Campo e101_aliquota nao declarado.";
      $this->erro_banco = "Alíquota não informada.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->e101_codnaturezarendimento == null) || ($this->e101_codnaturezarendimento == "")) {
      $this->erro_sql = " Campo e101_codnaturezarendimento nao declarado.";
      $this->erro_banco = "Alíquota não informada.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into naturezabemservico(
                                       e101_descr
                                      ,e101_resumo
                                      ,e101_aliquota
                                      ,e101_codnaturezarendimento 
                       )
                values (
                                      '$this->e101_descr'
                                      ,'$this->e101_resumo' 
                                      ,$this->e101_aliquota
                                      ,$e101_codnaturezarendimento 
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
    $this->erro_sql .= "Valores :\\nDescrição: " . $this->e101_descr . "\\nAliquota: " . $this->e101_aliquota;
    $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n" . $this->erro_sql . " \\n\\n";
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);

    $result = db_query("select currval('naturezabemservico_e101_sequencial_seq')");
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Verifique o cadastro da sequencia: naturezabemservico_e101_sequencial_seq do campo: e101_sequencial";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->e101_sequencial = pg_result($result, 0, 0);

    $resaco = $this->sql_record($this->sql_query_file($this->e101_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),'$this->e101_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_sequencial'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e101_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_descr'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e101_descr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_resumo'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e101_resumo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_aliquota'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e101_aliquota')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_codnaturezarendimento'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e101_codnaturezarendimento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }

    return true;
  }

  // funcao para alteracao
  function alterar($e101_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update naturezabemservico set ";
    $virgula = "";
    if (trim($this->e101_descr) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e101_descr"])) {
      $sql  .= $virgula . " e101_descr = '$this->e101_descr' ";
      $virgula = ",";
      $sql  .= $virgula . " e101_resumo = '$this->e101_descr' ";
      if (trim($this->e101_descr) == null) {
        $this->erro_sql = " Campo Descrição nao Informado.";
        $this->erro_campo = "e101_descr";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e101_aliquota) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e101_aliquota"])) {
      $sql  .= $virgula . " e101_aliquota = $this->e101_aliquota ";
      if (trim($this->e101_aliquota) == null) {
        $this->erro_sql = " Campo Alíquota nao Informado.";
        $this->erro_campo = "e101_aliquota";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e101_codnaturezarendimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e101_codnaturezarendimento"])) {
      $sql  .= $virgula . " e101_codnaturezarendimento = $this->e101_codnaturezarendimento ";
      if (trim($this->e101_codnaturezarendimento) == null) {
        $this->erro_sql = " Campo Cod. Natureza do Rendimento nao Informado.";
        $this->erro_campo = "e101_codnaturezarendimento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($e101_sequencial != null) {
      $sql .= " e101_sequencial = $e101_sequencial";
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Natureza de Bem ou Serviço nao alterada. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores :\\nDescrição: " . $this->e101_descr . "\\nAliquota: " . $this->e101_aliquota;
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Natureza de Bem ou Serviço nao alterada. Alteracao Abortada.\\n";
        $this->erro_sql .= "Valores :\\nDescrição: " . $this->e101_descr . "\\nAliquota: " . $this->e101_aliquota;
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return false;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores :\\nDescrição: " . $this->e101_descr . "\\nAliquota: " . $this->e101_aliquota;
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        //  $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Status: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        $resaco = $this->sql_record($this->sql_query_file($e101_sequencial));
        if ($this->numrows > 0) {
          for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac, 0, 0);
            $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
            $resac = db_query("insert into db_acountkey values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),'$e101_sequencial','A')");
            if (isset($GLOBALS["HTTP_POST_VARS"]["e101_descr"]) || $this->e101_descr != "")
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_aliquota'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e101_descr')) . "','$this->e101_descr'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_resumo'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e101_resumo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            if (isset($GLOBALS["HTTP_POST_VARS"]["e101_aliquota"]) || $this->e101_aliquota != null)
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_aliquota'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e101_aliquota')) . "','$this->e101_aliquota'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
              if (isset($GLOBALS["HTTP_POST_VARS"]["e101_codnaturezarendimento"]) || $this->e101_codnaturezarendimento != null)
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_codnaturezarendimento'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e101_codnaturezarendimento')) . "','$this->e101_codnaturezarendimento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }

        return true;
      }
    }
  }
  // funcao para exclusao 
  function excluir($e101_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($e101_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),'$e101_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e101_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from naturezabemservico
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($e101_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " e101_sequencial = $e101_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Natureza de Bem ou Serviço nao Excluída. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Natureza de Bem ou Serviço nao Excluída. Exclusão Abortada.\\n";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        //  $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Status: \\n\\n ".$this->erro_banco." \\n"));
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
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Record Vazio na Tabela:naturezabemservico";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  function sql_query($e101_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from naturezabemservico ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($e101_sequencial != null) {
        $sql2 .= " where e101_sequencial = $e101_sequencial ";
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
  function sql_query_file($e101_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from naturezabemservico ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($e101_sequencial != null) {
        $sql2 .= " where naturezabemservico.e101_sequencial = $e101_sequencial ";
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
