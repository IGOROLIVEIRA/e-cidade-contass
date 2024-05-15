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
//CLASSE DA ENTIDADE pagordemreinf
class cl_pagordemreinf
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
  var $e102_codord = 0;
  var $e102_numcgm = 0;
  var $e102_vlrbruto = 0;
  var $e102_vlrbase = 0;
  var $e102_vlrir = 0;
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 e102_codord = int4 = Ordem de Pagamento 
                 e102_numcgm = int4 = Num. CGM
                 e102_vlrbruto = float8(120) = Valor Bruto 
                 e102_vlrbase = float8 = Valor Base
                 e102_vlrir = float8 = Valor IR
                 ";
  //funcao construtor da classe 
  function cl_pagordemreinf()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("pagordemreinf");
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
      $this->e102_codord = ($this->e102_codord == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_codord"] : $this->e102_codord);
      $this->e102_numcgm = ($this->e102_numcgm == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_numcgm"] : $this->e102_numcgm);
      $this->e102_vlrbase = ($this->e102_vlrbase == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_vlrbase"] : $this->e102_vlrbase);
      $this->e102_vlrir = ($this->e102_vlrir == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_vlrir"] : $this->e102_vlrir);
      $this->e102_vlrbruto = ($this->e102_vlrbruto == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_vlrbruto"] : $this->e102_vlrbruto);
    } else {
      $this->e102_codord = ($this->e102_codord == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_codord"] : $this->e102_codord);
      $this->e102_numcgm = ($this->e102_numcgm == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_numcgm"] : $this->e102_numcgm);
      $this->e102_vlrbase = ($this->e102_vlrbase == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_vlrbase"] : $this->e102_vlrbase);
      $this->e102_vlrir = ($this->e102_vlrir == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_vlrir"] : $this->e102_vlrir);
      $this->e102_vlrbruto = ($this->e102_vlrbruto == "" ? @$GLOBALS["HTTP_POST_VARS"]["e102_vlrbruto"] : $this->e102_vlrbruto);
    }
  }
  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    if (($this->e102_codord == null) || ($this->e102_codord == "")) {
      $this->erro_sql = " Campo e102_codord nao declarado.";
      $this->erro_banco = "Código de OP não informado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->e102_numcgm == null) || ($this->e102_numcgm == "")) {
      $this->erro_sql = " Campo e102_numcgm nao declarado.";
      $this->erro_banco = "Código CGM não informado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->e102_vlrbruto == null) || ($this->e102_vlrbruto == "")) {
      $this->erro_sql = " Campo e102_vlrbruto nao declarado.";
      $this->erro_banco = "Valor Bruto não informado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->e102_vlrbase == null) || ($this->e102_vlrbase == "")) {
      $this->erro_sql = " Campo e102_vlrbase nao declarado.";
      $this->erro_banco = "Valor Base não informado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if (($this->e102_vlrir == null) || ($this->e102_vlrir == "")) {
      $this->erro_sql = " Campo e102_vlrir nao declarado.";
      $this->erro_banco = "Valor IR não informado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into pagordemreinf(
                                       e102_codord
                                      ,e102_numcgm
                                      ,e102_vlrbruto
                                      ,e102_vlrbase
                                      ,e102_vlrir 
                       )
                values (
                                       $this->e102_codord
                                      ,$this->e102_numcgm
                                      ,$this->e102_vlrbruto
                                      ,$this->e102_vlrbase
                                      ,$this->e102_vlrir
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

    $resaco = $this->sql_record($this->sql_query_file($this->e102_codord));
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),'$this->e102_codord','I')");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_codord'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e102_codord')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_numcgm'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e102_numcgm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrbruto'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e102_vlrbruto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrbase'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e102_vlrbase')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrir'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e102_vlrir')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }

    return true;
  }

  // funcao para alteracao
  function alterar($e102_codord = null, $e102_numcgm = null)
  {
    $this->atualizacampos();
    $sql = " update pagordemreinf set ";
    $virgula = "";
    if (trim($this->e102_codord) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e102_codord"])) {
      $sql  .= $virgula . " e102_codord = $this->e102_codord ";
      $virgula = ",";
      if (trim($this->e102_codord) == null) {
        $this->erro_sql = " Campo OP nao Informado.";
        $this->erro_campo = "e102_codord";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e102_numcgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e102_numcgm"])) {
      $sql  .= $virgula . " e102_numcgm = '$this->e102_numcgm' ";
      if (trim($this->e102_numcgm) == null) {
        $this->erro_sql = " Campo Num. Cgm nao Informado.";
        $this->erro_campo = "e102_numcgm";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e102_vlrbruto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e102_vlrbruto"])) {
      $sql  .= $virgula . " e102_vlrbruto = $this->e102_vlrbruto ";
      if (trim($this->e102_vlrbruto) == null) {
        $this->erro_sql = " Campo Valor Bruto nao Informado.";
        $this->erro_campo = "e102_vlrbruto";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e102_vlrbase) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e102_vlrbase"])) {
      $sql  .= $virgula . " e102_vlrbase = $this->e102_vlrbase ";
      if (trim($this->e102_vlrbase) == null) {
        $this->erro_sql = " Campo Valor Base nao Informado.";
        $this->erro_campo = "e102_vlrbase";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e102_vlrir) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e102_vlrir"])) {
      $sql  .= $virgula . " e102_vlrir = $this->e102_vlrir ";
      if (trim($this->e102_vlrir) == null) {
        $this->erro_sql = " Campo Valor IR nao Informado.";
        $this->erro_campo = "e102_vlrir";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql2 = "";
      if ($e102_codord != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " e102_codord = $e102_codord ";
      }
      if ($e102_numcgm != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " e102_numcgm = $e102_numcgm ";
      }
      if ($sql2 == "") {
      $this->erro_sql = "Registro não encontrado";
      $this->erro_campo = "";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $result = db_query($sql.$sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Retenção de Ordem de Pagamento nao alterada. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Retenção de Ordem de Pagamento nao alterada. Alteracao Abortada.\\n";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        $this->numrows_alterar = 0;
        return false;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        $resaco = $this->sql_record($this->sql_query_file($e102_codord));
        if ($this->numrows > 0) {
          for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac, 0, 0);
            $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
            $resac = db_query("insert into db_acountkey values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),'$e102_codord','A')");
            if (isset($GLOBALS["HTTP_POST_VARS"]["e102_numcgm"]) || $this->e102_numcgm != "")
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrbase'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e102_numcgm')) . "','$this->e102_numcgm'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrbruto'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e102_vlrbruto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            if (isset($GLOBALS["HTTP_POST_VARS"]["e102_vlrbase"]) || $this->e102_vlrbase != null)
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrbase'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e102_vlrbase')) . "','$this->e102_vlrbase'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
              if (isset($GLOBALS["HTTP_POST_VARS"]["e102_vlrir"]) || $this->e102_vlrir != null)
              $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrir'),'" . AddSlashes(pg_result($resaco, $iresaco, 'e102_vlrir')) . "','$this->e102_vlrir'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }

        return true;
      }
    }
  }
  // funcao para exclusao 
  function excluir($e102_codord = null, $e102_numcgm = null, $dbwhere = null)
  {
    if (trim($e102_codord) == "" || $e102_codord == null) {
        $this->erro_sql = " Numero da OP nao Informado.";
        $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
    }

    if (trim($e102_numcgm) == "" || $e102_numcgm == null) {
      $this->erro_sql = " Numero do CGM nao Informado.";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
  }

    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($e102_codord));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),'$e102_codord','E')");
        $resac = db_query("insert into db_acount values($acount,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),'','" . AddSlashes(pg_result($resaco, $iresaco, 'e102_codord')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from pagordemreinf
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      $sql2 = "e102_codord = $e102_codord AND e102_numcgm = $e102_numcgm";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Retenção de Ordem de Pagamento nao Excluída. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Retenção de Ordem de Pagamento nao Excluída. Exclusão Abortada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:pagordemreinf";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  function verificaRetencao($e102_codord = null, $e102_numcgm = null)
  {
    $sql = "";
    $sql = "SELECT * FROM pagordemreinf WHERE e102_codord = $e102_codord AND e102_numcgm = $e102_numcgm";
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
      $this->erro_sql   = "Record Vazio na Tabela:pagordemreinf";
      $this->erro_msg   = "Usuário: " . db_getsession("DB_login") . "\\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Status: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  function sql_query($e102_codord = null, $e102_numcgm = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from pagordemreinf ";
    $sql2 = " where ";
    if ($dbwhere == null || $dbwhere == "") {
      if ($e102_codord != "" || $e102_codord != null) {
        if ($sql2 != " where ") {
          $sql2 .= " and ";
        }
        $sql2 .= " e102_codord = $e102_codord ";
      }
      if ($e102_numcgm != "" || $e102_numcgm != null) {
        if ($sql2 != " where ") {
          $sql2 .= " and ";
        }
        $sql2 .= " e102_numcgm = $e102_numcgm ";
      }
    } else {
      $sql2 .= $dbwhere;
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
  function sql_query_file($e102_codord = null,$e102_numcgm = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from pagordemreinf ";
    $sql2 = " where ";
    if ($dbwhere == null || $dbwhere == "") {
      if ($e102_codord != "") {
        if ($sql2 != " where ") {
          $sql2 .= " and ";
        }
        $sql2 .= " e102_codord = $e102_codord ";
      }
      if ($e102_numcgm != "") {
        if ($sql2 != " where ") {
          $sql2 .= " and ";
        }
        $sql2 .= " e102_numcgm = $e102_numcgm ";
      }
    } else {
      $sql2 .= $dbwhere;
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
  function sql_query_nome($e102_codord = null, $e102_numcgm = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from pagordemreinf join protocolo.cgm on e102_numcgm = z01_numcgm ";
    $sql2 = " where ";
    if ($dbwhere == null || $dbwhere == "") {
      if ($e102_codord != "") {
        if ($sql2 != " where ") {
          $sql2 .= " and ";
        }
        $sql2 .= " e102_codord = $e102_codord ";
      }
      if ($e102_numcgm != "") {
        if ($sql2 != " where ") {
          $sql2 .= " and ";
        }
        $sql2 .= " e102_numcgm = $e102_numcgm ";
      }
    } else {
      $sql2 .= $dbwhere;
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
