<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

//MODULO: pessoal
//CLASSE DA ENTIDADE rhpesrescisao
class cl_rhpesrescisao
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
    var $rh05_seqpes = 0;
    var $rh05_recis_dia = null;
    var $rh05_recis_mes = null;
    var $rh05_recis_ano = null;
    var $rh05_recis = null;
    var $rh05_causa = 0;
    var $rh05_caub = null;
    var $rh05_aviso_dia = null;
    var $rh05_aviso_mes = null;
    var $rh05_aviso_ano = null;
    var $rh05_aviso = null;
    var $rh05_taviso = 0;
    var $rh05_mremun = 0;
    var $rh05_empenhado = 'f';
    var $rh05_trct = null;
    var $rh05_codigoseguranca = null;
    var $rh05_feriasavos = 0;
    var $rh05_feriasvencidas = 0;
    var $rh05_13salarioavos = 0;
    var $rh05_saldofgts = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 rh05_seqpes = int4 = Sequência
                 rh05_recis = date = Data da Rescisão
                 rh05_causa = int4 = Causa da Rescisão
                 rh05_caub = varchar(2) = Sub causa de rescisão
                 rh05_aviso = date = Data de Aviso Prévio
                 rh05_taviso = int4 = Tipo de Aviso
                 rh05_mremun = float8 = Maior Remuneração
                 rh05_empenhado = bool = Rescisão Empenhada
                 rh05_trct = varchar(200) = TRCT
                 rh05_codigoseguranca = varchar(200) = Código de segurança
                 rh05_feriasavos = int4 = Avos de férias
                 rh05_feriasvencidas = int4 = Férias vencidas
                 rh05_13salarioavos = int4 = Avos de 13º salário
                 rh05_saldofgts = float8 = Saldo FGTS
                 ";
    //funcao construtor da classe
    function cl_rhpesrescisao()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("rhpesrescisao");
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
            $this->rh05_seqpes = ($this->rh05_seqpes == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_seqpes"] : $this->rh05_seqpes);
            if ($this->rh05_recis == "") {
                $this->rh05_recis_dia = ($this->rh05_recis_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_recis_dia"] : $this->rh05_recis_dia);
                $this->rh05_recis_mes = ($this->rh05_recis_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_recis_mes"] : $this->rh05_recis_mes);
                $this->rh05_recis_ano = ($this->rh05_recis_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_recis_ano"] : $this->rh05_recis_ano);
                if ($this->rh05_recis_dia != "") {
                    $this->rh05_recis = $this->rh05_recis_ano . "-" . $this->rh05_recis_mes . "-" . $this->rh05_recis_dia;
                }
            }
            $this->rh05_causa = ($this->rh05_causa == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_causa"] : $this->rh05_causa);
            $this->rh05_caub = ($this->rh05_caub == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_caub"] : $this->rh05_caub);
            if ($this->rh05_aviso == "") {
                $this->rh05_aviso_dia = ($this->rh05_aviso_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_aviso_dia"] : $this->rh05_aviso_dia);
                $this->rh05_aviso_mes = ($this->rh05_aviso_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_aviso_mes"] : $this->rh05_aviso_mes);
                $this->rh05_aviso_ano = ($this->rh05_aviso_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_aviso_ano"] : $this->rh05_aviso_ano);
                if ($this->rh05_aviso_dia != "") {
                    $this->rh05_aviso = $this->rh05_aviso_ano . "-" . $this->rh05_aviso_mes . "-" . $this->rh05_aviso_dia;
                }
            }
            $this->rh05_taviso = ($this->rh05_taviso == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_taviso"] : $this->rh05_taviso);
            $this->rh05_mremun = ($this->rh05_mremun == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_mremun"] : $this->rh05_mremun);
            $this->rh05_empenhado = ($this->rh05_empenhado == "f" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_empenhado"] : $this->rh05_empenhado);
            $this->rh05_trct = ($this->rh05_trct == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_trct"] : $this->rh05_trct);
            $this->rh05_codigoseguranca = ($this->rh05_codigoseguranca == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_codigoseguranca"] : $this->rh05_codigoseguranca);
            $this->rh05_feriasavos = ($this->rh05_feriasavos == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_feriasavos"] : $this->rh05_feriasavos);
            $this->rh05_feriasvencidas = ($this->rh05_feriasvencidas == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_feriasvencidas"] : $this->rh05_feriasvencidas);
            $this->rh05_13salarioavos = ($this->rh05_13salarioavos == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_13salarioavos"] : $this->rh05_13salarioavos);
            $this->rh05_saldofgts = ($this->rh05_saldofgts == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_saldofgts"] : $this->rh05_saldofgts);
        } else {
            $this->rh05_seqpes = ($this->rh05_seqpes == "" ? @$GLOBALS["HTTP_POST_VARS"]["rh05_seqpes"] : $this->rh05_seqpes);
        }
    }
    // funcao para inclusao
    function incluir($rh05_seqpes)
    {
        $this->atualizacampos();
        if ($this->rh05_recis == null) {
            $this->erro_sql = " Campo Data da Rescisão nao Informado.";
            $this->erro_campo = "rh05_recis_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->rh05_causa == null) {
            $this->erro_sql = " Campo Causa da Rescisão nao Informado.";
            $this->erro_campo = "rh05_causa";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->rh05_aviso == null) {
            $this->rh05_aviso = "null";
        }
        if ($this->rh05_taviso == null) {
            $this->erro_sql = " Campo Tipo de Aviso nao Informado.";
            $this->erro_campo = "rh05_taviso";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->rh05_mremun == null) {
            $this->erro_sql = " Campo Maior Remuneração nao Informado.";
            $this->erro_campo = "rh05_mremun";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->rh05_empenhado == null) {
            $this->rh05_empenhado = "false";
        }
        if ($this->rh05_feriasavos == null) {
            $this->rh05_feriasavos = "0";
        }
        if ($this->rh05_feriasvencidas == null) {
            $this->rh05_feriasvencidas = "0";
        }
        if ($this->rh05_13salarioavos == null) {
            $this->rh05_13salarioavos = "0";
        }
        if (empty($this->rh05_saldofgts)) {
            $this->rh05_saldofgts = 0;
        }

        $this->rh05_seqpes = $rh05_seqpes;
        if (($this->rh05_seqpes == null) || ($this->rh05_seqpes == "")) {
            $this->erro_sql = " Campo rh05_seqpes nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into rhpesrescisao(
                                       rh05_seqpes
                                      ,rh05_recis
                                      ,rh05_causa
                                      ,rh05_caub
                                      ,rh05_aviso
                                      ,rh05_taviso
                                      ,rh05_mremun
                                      ,rh05_empenhado
                                      ,rh05_trct
                                      ,rh05_codigoseguranca
                                      ,rh05_feriasavos
                                      ,rh05_feriasvencidas
                                      ,rh05_13salarioavos
                                      ,rh05_saldofgts
                       )
                values (
                                $this->rh05_seqpes
                               ," . ($this->rh05_recis == "null" || $this->rh05_recis == "" ? "null" : "'" . $this->rh05_recis . "'") . "
                               ,$this->rh05_causa
                               ,'$this->rh05_caub'
                               ," . ($this->rh05_aviso == "null" || $this->rh05_aviso == "" ? "null" : "'" . $this->rh05_aviso . "'") . "
                               ,$this->rh05_taviso
                               ,$this->rh05_mremun
                               ,'$this->rh05_empenhado'
                               ,'$this->rh05_trct'
                               ,'$this->rh05_codigoseguranca'
                               ,$this->rh05_feriasavos
                               ,$this->rh05_feriasvencidas
                               ,$this->rh05_13salarioavos
                               ,$this->rh05_saldofgts
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "Funcionários em rescisão ($this->rh05_seqpes) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "Funcionários em rescisão já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "Funcionários em rescisão ($this->rh05_seqpes) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->rh05_seqpes;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $resaco = $this->sql_record($this->sql_query_file($this->rh05_seqpes));
        if (($resaco != false) || ($this->numrows != 0)) {
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac, 0, 0);
            $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
            $resac = db_query("insert into db_acountkey values($acount,7043,'$this->rh05_seqpes','I')");
            $resac = db_query("insert into db_acount values($acount,1161,7043,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_seqpes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,7044,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_recis')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,7045,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_causa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,7046,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_caub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,7047,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_aviso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,7048,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_taviso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,7049,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_mremun')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,17509,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_empenhado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,19589,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_trct')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,19590,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_codigoseguranca')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,19633,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_feriasavos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,19635,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_feriasvencidas')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,1161,19634,'','" . AddSlashes(pg_result($resaco, 0, 'rh05_13salarioavos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        return true;
    }
    // funcao para alteracao
    function alterar($rh05_seqpes = null)
    {
        $this->atualizacampos();
        $sql = " update rhpesrescisao set ";
        $virgula = "";
        if (trim($this->rh05_seqpes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_seqpes"])) {
            $sql  .= $virgula . " rh05_seqpes = $this->rh05_seqpes ";
            $virgula = ",";
            if (trim($this->rh05_seqpes) == null) {
                $this->erro_sql = " Campo Sequência nao Informado.";
                $this->erro_campo = "rh05_seqpes";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->rh05_recis) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_recis_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["rh05_recis_dia"] != "")) {
            $sql  .= $virgula . " rh05_recis = '$this->rh05_recis' ";
            $virgula = ",";
            if (trim($this->rh05_recis) == null) {
                $this->erro_sql = " Campo Data da Rescisão nao Informado.";
                $this->erro_campo = "rh05_recis_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_recis_dia"])) {
                $sql  .= $virgula . " rh05_recis = null ";
                $virgula = ",";
                if (trim($this->rh05_recis) == null) {
                    $this->erro_sql = " Campo Data da Rescisão nao Informado.";
                    $this->erro_campo = "rh05_recis_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->rh05_causa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_causa"])) {
            $sql  .= $virgula . " rh05_causa = $this->rh05_causa ";
            $virgula = ",";
            if (trim($this->rh05_causa) == null) {
                $this->erro_sql = " Campo Causa da Rescisão nao Informado.";
                $this->erro_campo = "rh05_causa";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->rh05_caub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_caub"])) {
            $sql  .= $virgula . " rh05_caub = '$this->rh05_caub' ";
            $virgula = ",";
        }
        if (trim($this->rh05_aviso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_aviso_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["rh05_aviso_dia"] != "")) {
            $sql  .= $virgula . " rh05_aviso = '$this->rh05_aviso' ";
            $virgula = ",";
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_aviso_dia"])) {
                $sql  .= $virgula . " rh05_aviso = null ";
                $virgula = ",";
            }
        }
        if (trim($this->rh05_taviso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_taviso"])) {
            $sql  .= $virgula . " rh05_taviso = $this->rh05_taviso ";
            $virgula = ",";
            if (trim($this->rh05_taviso) == null) {
                $this->erro_sql = " Campo Tipo de Aviso nao Informado.";
                $this->erro_campo = "rh05_taviso";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->rh05_mremun) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_mremun"])) {
            $sql  .= $virgula . " rh05_mremun = $this->rh05_mremun ";
            $virgula = ",";
            if (trim($this->rh05_mremun) == null) {
                $this->erro_sql = " Campo Maior Remuneração nao Informado.";
                $this->erro_campo = "rh05_mremun";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->rh05_empenhado) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_empenhado"])) {
            $sql  .= $virgula . " rh05_empenhado = '$this->rh05_empenhado' ";
            $virgula = ",";
        }
        if (trim($this->rh05_trct) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_trct"])) {
            $sql  .= $virgula . " rh05_trct = '$this->rh05_trct' ";
            $virgula = ",";
        }
        if (trim($this->rh05_codigoseguranca) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_codigoseguranca"])) {
            $sql  .= $virgula . " rh05_codigoseguranca = '$this->rh05_codigoseguranca' ";
            $virgula = ",";
        }
        if (trim($this->rh05_feriasavos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_feriasavos"])) {
            if (trim($this->rh05_feriasavos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["rh05_feriasavos"])) {
                $this->rh05_feriasavos = "0";
            }
            $sql  .= $virgula . " rh05_feriasavos = $this->rh05_feriasavos ";
            $virgula = ",";
        }
        if (trim($this->rh05_feriasvencidas) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_feriasvencidas"])) {
            if (trim($this->rh05_feriasvencidas) == "" && isset($GLOBALS["HTTP_POST_VARS"]["rh05_feriasvencidas"])) {
                $this->rh05_feriasvencidas = "0";
            }
            $sql  .= $virgula . " rh05_feriasvencidas = $this->rh05_feriasvencidas ";
            $virgula = ",";
        }
        if (trim($this->rh05_13salarioavos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_13salarioavos"])) {
            if (trim($this->rh05_13salarioavos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["rh05_13salarioavos"])) {
                $this->rh05_13salarioavos = "0";
            }
            $sql  .= $virgula . " rh05_13salarioavos = $this->rh05_13salarioavos ";
            $virgula = ",";
        }
        if (trim($this->rh05_saldofgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["rh05_saldofgts"])) {
            if (trim($this->rh05_saldofgts) == "" && isset($GLOBALS["HTTP_POST_VARS"]["rh05_saldofgts"])) {
                $this->rh05_saldofgts = "0";
            }
            $sql  .= $virgula . " rh05_saldofgts = $this->rh05_saldofgts ";
            $virgula = ",";
        }
        $sql .= " where ";
        if ($rh05_seqpes != null) {
            $sql .= " rh05_seqpes = $this->rh05_seqpes";
        }
        $resaco = $this->sql_record($this->sql_query_file($this->rh05_seqpes));
        if ($this->numrows > 0) {
            for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac, 0, 0);
                $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
                $resac = db_query("insert into db_acountkey values($acount,7043,'$this->rh05_seqpes','A')");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_seqpes"]) || $this->rh05_seqpes != "")
                    $resac = db_query("insert into db_acount values($acount,1161,7043,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_seqpes')) . "','$this->rh05_seqpes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_recis"]) || $this->rh05_recis != "")
                    $resac = db_query("insert into db_acount values($acount,1161,7044,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_recis')) . "','$this->rh05_recis'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_causa"]) || $this->rh05_causa != "")
                    $resac = db_query("insert into db_acount values($acount,1161,7045,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_causa')) . "','$this->rh05_causa'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_caub"]) || $this->rh05_caub != "")
                    $resac = db_query("insert into db_acount values($acount,1161,7046,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_caub')) . "','$this->rh05_caub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_aviso"]) || $this->rh05_aviso != "")
                    $resac = db_query("insert into db_acount values($acount,1161,7047,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_aviso')) . "','$this->rh05_aviso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_taviso"]) || $this->rh05_taviso != "")
                    $resac = db_query("insert into db_acount values($acount,1161,7048,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_taviso')) . "','$this->rh05_taviso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_mremun"]) || $this->rh05_mremun != "")
                    $resac = db_query("insert into db_acount values($acount,1161,7049,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_mremun')) . "','$this->rh05_mremun'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_empenhado"]) || $this->rh05_empenhado != "")
                    $resac = db_query("insert into db_acount values($acount,1161,17509,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_empenhado')) . "','$this->rh05_empenhado'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_trct"]) || $this->rh05_trct != "")
                    $resac = db_query("insert into db_acount values($acount,1161,19589,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_trct')) . "','$this->rh05_trct'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_codigoseguranca"]) || $this->rh05_codigoseguranca != "")
                    $resac = db_query("insert into db_acount values($acount,1161,19590,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_codigoseguranca')) . "','$this->rh05_codigoseguranca'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_feriasavos"]) || $this->rh05_feriasavos != "")
                    $resac = db_query("insert into db_acount values($acount,1161,19633,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_feriasavos')) . "','$this->rh05_feriasavos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_feriasvencidas"]) || $this->rh05_feriasvencidas != "")
                    $resac = db_query("insert into db_acount values($acount,1161,19635,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_feriasvencidas')) . "','$this->rh05_feriasvencidas'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["rh05_13salarioavos"]) || $this->rh05_13salarioavos != "")
                    $resac = db_query("insert into db_acount values($acount,1161,19634,'" . AddSlashes(pg_result($resaco, $conresaco, 'rh05_13salarioavos')) . "','$this->rh05_13salarioavos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Funcionários em rescisão nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->rh05_seqpes;
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Funcionários em rescisão nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->rh05_seqpes;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->rh05_seqpes;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir($rh05_seqpes = null, $dbwhere = null)
    {
        if ($dbwhere == null || $dbwhere == "") {
            $resaco = $this->sql_record($this->sql_query_file($rh05_seqpes));
        } else {
            $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
        }
        if (($resaco != false) || ($this->numrows != 0)) {
            for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac, 0, 0);
                $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
                $resac = db_query("insert into db_acountkey values($acount,7043,'$rh05_seqpes','E')");
                $resac = db_query("insert into db_acount values($acount,1161,7043,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_seqpes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,7044,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_recis')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,7045,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_causa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,7046,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_caub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,7047,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_aviso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,7048,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_taviso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,7049,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_mremun')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,17509,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_empenhado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,19589,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_trct')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,19590,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_codigoseguranca')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,19633,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_feriasavos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,19635,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_feriasvencidas')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,1161,19634,'','" . AddSlashes(pg_result($resaco, $iresaco, 'rh05_13salarioavos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }
        $sql = " delete from rhpesrescisao
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($rh05_seqpes != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " rh05_seqpes = $rh05_seqpes ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Funcionários em rescisão nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $rh05_seqpes;
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Funcionários em rescisão nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $rh05_seqpes;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $rh05_seqpes;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql   = "Record Vazio na Tabela:rhpesrescisao";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql
    function sql_query($rh05_seqpes = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from rhpesrescisao ";
        $sql .= "      inner join rhpessoalmov  on  rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes";
        $sql .= "      inner join tpcontra  on  tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont";
        $sql .= "      inner join rhregime  on  rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
		                                    and  rhregime.rh30_instit = rhpessoalmov.rh02_instit ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($rh05_seqpes != null) {
                $sql2 .= " where rhpesrescisao.rh05_seqpes = $rh05_seqpes ";
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
    function sql_query_file($rh05_seqpes = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from rhpesrescisao ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($rh05_seqpes != null) {
                $sql2 .= " where rhpesrescisao.rh05_seqpes = $rh05_seqpes ";
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
    function atualiza_incluir()
    {
        $this->incluir($this->rh05_seqpes);
    }
    function sql_query_retorno($rh05_seqpes = null, $campos = "*", $ordem = null, $dbwhere = "", $anonovo, $mesnovo)
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
        $sql .= " from rhpesrescisao ";
        $sql .= "      inner join rhpessoalmov on rh05_seqpes=rh02_seqpes ";
        $sql .= "      left  join rhpessoal on rh01_regist=rh02_regist ";
        $sql .= "      left  join rhpessoalmov a on a.rh02_regist=rh01_regist
		                                         and a.rh02_anousu=" . $anonovo . "
                                             and a.rh02_mesusu=" . $mesnovo . "
																						 and a.rh02_instit=" . db_getsession("DB_instit") . " ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($rh05_seqpes != null) {
                $sql2 .= " where rhpesrescisao.rh05_seqpes = $rh05_seqpes ";
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
    function sql_query_rescisao($rh05_seqpes = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from rhpesrescisao ";
        $sql .= "      inner join rhpessoalmov  on  rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes";
        $sql .= "      inner join tpcontra  on  tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont";
        $sql .= "      inner join rhregime  on  rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
		                                    and  rhregime.rh30_instit = rhpessoalmov.rh02_instit ";
        $sql .= "      inner join rescisao  on  rescisao.r59_anousu  = rhpessoalmov.rh02_anousu
                                        and  rescisao.r59_mesusu  = rhpessoalmov.rh02_mesusu
                              					and  rescisao.r59_regime  = rhregime.rh30_regime
                              					and  rescisao.r59_causa   = rhpesrescisao.rh05_causa
                              					and  rescisao.r59_caub    = rhpesrescisao.rh05_caub::char(2)
																				and  rescisao.r59_instit  = rhpessoalmov.rh02_instit ";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($rh05_seqpes != null) {
                $sql2 .= " where rhpesrescisao.rh05_seqpes = $rh05_seqpes ";
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
    function sql_query_ngeraferias($rh05_seqpes = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from rhpesrescisao ";
        $sql .= "      inner join rhpessoalmov  on  rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($rh05_seqpes != null) {
                $sql2 .= " where rhpesrescisao.rh05_seqpes = $rh05_seqpes ";
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

    function sql_relatorios_termo_rescisao($rh05_seqpes = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " FROM rhpessoal ";
        $sql .= " JOIN rhpessoalmov ON rhpessoal.rh01_regist = rhpessoalmov.rh02_regist ";
        $sql .= " JOIN cgm ON rhpessoal.rh01_numcgm = cgm.z01_numcgm ";
        $sql .= " LEFT JOIN rhpesdoc ON rhpessoal.rh01_regist = rhpesdoc.rh16_regist ";
        $sql .= " LEFT JOIN tpcontra ON rhpessoalmov.rh02_tpcont = tpcontra.h13_codigo ";
        $sql .= " LEFT JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg ";
        $sql .= " LEFT JOIN rhfuncao ON (rhpessoal.rh01_funcao, rhpessoal.rh01_instit) = (rhfuncao.rh37_funcao, rhfuncao.rh37_instit) ";
        $sql .= " LEFT JOIN rhpesfgts ON rhpessoal.rh01_regist = rhpesfgts.rh15_regist ";
        $sql .= " LEFT JOIN rhpesrescisao ON rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes ";
        $sql .= " LEFT JOIN rescisao ON rescisao.r59_anousu  = rhpessoalmov.rh02_anousu  ";
        $sql .= "          AND rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu  ";
        $sql .= "          AND rescisao.r59_regime = rhregime.rh30_regime  ";
        $sql .= "          AND rescisao.r59_causa  = rhpesrescisao.rh05_causa ";
        $sql .= "          AND rescisao.r59_caub   = rhpesrescisao.rh05_caub::char(2) ";
        $sql .= "          AND rescisao.r59_instit = rhpessoalmov.rh02_instit ";
        $sql .= " LEFT JOIN causaafastamento ON causaafastamento.rh115_sequencial = rescisao.r59_causaafastamento ";
        $sql .= " LEFT JOIN rhlota ON rhpessoalmov.rh02_lota = rhlota.r70_codigo ";
        $sql .= "          AND rhlota.r70_instit = rhpessoalmov.rh02_instit ";
        $sql .= " LEFT JOIN rhpeslocaltrab ON rhpessoalmov.rh02_seqpes = rhpeslocaltrab.rh56_seqpes ";
        $sql .= " LEFT JOIN rhlocaltrab ON rhlocaltrab.rh55_codigo  = rhpeslocaltrab.rh56_localtrab ";
        $sql .= " LEFT JOIN rhlotaexe ON rhlotaexe.rh26_codigo = rhlota.r70_codigo ";
        $sql .= "          AND rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu ";
        $sql .= " LEFT JOIN orcorgao ON orcorgao.o40_orgao = rhlotaexe.rh26_orgao ";
        $sql .= "          AND orcorgao.o40_anousu = rhpessoalmov.rh02_anousu ";
        $sql .= "          AND orcorgao.o40_instit = rhpessoalmov.rh02_instit ";
        $sql .= " LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo ";
        $sql .= "          AND rhlotavinc.rh25_anousu  = rhpessoalmov.rh02_anousu ";
        $sql .= "          AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo ";
        $sql .= " LEFT JOIN orctiporec ON orctiporec.o15_codigo = rhlotavinc.rh25_recurso ";
        $sql .= " LEFT JOIN rhsindicato ON rhpessoal.rh01_rhsindicato = rhsindicato.rh116_sequencial ";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($rh05_seqpes != null) {
                $sql2 .= " where rhpesrescisao.rh05_seqpes = $rh05_seqpes ";
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

    function sql_relatorios_termo_rescisao_pontorescisao($iAno, $iMes, $campos = "*", $dbwhere = "")
    {
        $iInstit = db_getsession("DB_instit");

        $sSql = "select ";
        if ($campos != "*") {
            $campos_sql = split("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sSql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sSql .= $campos;
        }


        $sSql .= " from rhpessoalmov                                                                                                                                  \n";
        $sSql .= "       inner join rhpessoal     on rhpessoal.rh01_regist     = rhpessoalmov.rh02_regist                                                             \n";
        $sSql .= "       inner join tpcontra      on tpcontra.h13_codigo       = rhpessoalmov.rh02_tpcont                                                             \n";
        $sSql .= "       inner join cgm           on cgm.z01_numcgm            = rhpessoal.rh01_numcgm                                                                \n";
        $sSql .= "       inner join rhlota        on rhlota.r70_codigo         = rhpessoalmov.rh02_lota                                                               \n";
        $sSql .= "                               and rhlota.r70_instit         = rhpessoalmov.rh02_instit                                                             \n";
        $sSql .= "       left  join rhpesdoc      on rhpesdoc.rh16_regist      = rhpessoal.rh01_regist                                                                \n";
        $sSql .= "       left  join rhregime      on rhregime.rh30_codreg      = rhpessoalmov.rh02_codreg                                                             \n";
        $sSql .= "                               and rhregime.rh30_instit      = rhpessoalmov.rh02_instit                                                             \n";
        $sSql .= "       left  join rhcadregime   on rhregime.rh30_regime      = rhcadregime.rh52_regime                                                              \n";
        $sSql .= "       left  join rhlotaexe     on rhlotaexe.rh26_anousu     = rhpessoalmov.rh02_anousu                                                             \n";
        $sSql .= "                               and rhlotaexe.rh26_codigo     = rhlota.r70_codigo                                                                    \n";
        $sSql .= "       left  join orcunidade    on orcunidade.o41_anousu     = rhlotaexe.rh26_anousu                                                                \n";
        $sSql .= "                               and orcunidade.o41_orgao      = rhlotaexe.rh26_orgao                                                                 \n";
        $sSql .= "                               and orcunidade.o41_unidade    = rhlotaexe.rh26_unidade                                                               \n";
        $sSql .= "       left  join orcorgao      on orcorgao.o40_anousu       = orcunidade.o41_anousu                                                                \n";
        $sSql .= "                               and orcorgao.o40_orgao        = orcunidade.o41_orgao                                                                 \n";
        $sSql .= "       left  join rhlotavinc    on rhlotavinc.rh25_codigo    = rhlotaexe.rh26_codigo                                                                \n";
        $sSql .= "                               and rhlotavinc.rh25_anousu    = rhpessoalmov.rh02_anousu                                                             \n";
        $sSql .= "                               and rhlotavinc.rh25_vinculo   = rhregime.rh30_vinculo                                                                \n";
        $sSql .= "       left  join orcprojativ   on orcprojativ.o55_anousu    = rhpessoalmov.rh02_anousu                                                             \n";
        $sSql .= "                               and orcprojativ.o55_projativ  = rhlotavinc.rh25_projativ                                                             \n";
        $sSql .= "       left  join orctiporec    on orctiporec.o15_codigo     = rhlotavinc.rh25_recurso                                                              \n";
        $sSql .= "       left  join rhpesrescisao on rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes                                                             \n";
        $sSql .= "       left  join rescisao      on rescisao.r59_anousu       = rhpessoalmov.rh02_anousu                                                             \n";
        $sSql .= "                               and rescisao.r59_mesusu       = rhpessoalmov.rh02_mesusu                                                             \n";
        $sSql .= "                               and rescisao.r59_regime       = rhregime.rh30_regime                                                                 \n";
        $sSql .= "                               and rescisao.r59_causa        = rhpesrescisao.rh05_causa                                                             \n";
        $sSql .= "                               and rescisao.r59_caub         = rhpesrescisao.rh05_caub::char(2)                                                     \n";
        $sSql .= "                               and case when (rhpesrescisao.rh05_recis - rhpessoal.rh01_admiss) >= 365 then 'N' else 'S' end = rescisao.r59_menos1  \n";
        $sSql .= "                               and rescisao.r59_instit       = rhpessoalmov.rh02_instit                                                             \n";
        $sSql .= "       left  join gerfres       on gerfres.r20_anousu        = rhpessoalmov.rh02_anousu                                                             \n";
        $sSql .= "                               and gerfres.r20_mesusu        = rhpessoalmov.rh02_mesusu                                                             \n";
        $sSql .= "                               and gerfres.r20_regist        = rhpessoalmov.rh02_regist                                                             \n";
        $sSql .= "                               and gerfres.r20_instit        = $iInstit                                                                             \n";
        $sSql .= "       left  join afasta        on rhpessoal.rh01_regist     = afasta.r45_regist                                                                    \n";
        $sSql .= "                               and rhpessoalmov.rh02_anousu  = afasta.r45_anousu                                                                    \n";
        $sSql .= "                               and rhpessoalmov.rh02_mesusu  = afasta.r45_mesusu                                                                    \n";
        $sSql .= "                               and afasta.r45_situac         = 2                                                                                    \n";
        $sSql .= "       left join rhfuncao ON (rhpessoal.rh01_funcao, rhpessoal.rh01_instit) = (rhfuncao.rh37_funcao, rhfuncao.rh37_instit)                          \n";
        $sSql .= "       left join rhsindicato ON rhpessoal.rh01_rhsindicato = rhsindicato.rh116_sequencial                                                           \n";
        $sSql .= "       left join rhpesfgts ON rhpessoal.rh01_regist = rhpesfgts.rh15_regist                                                                         \n";
        $sSql .= "       left join causaafastamento ON causaafastamento.rh115_sequencial = rescisao.r59_causaafastamento                                              \n";

        $sSql .= "where ";
        $sSql .= " case";
        $sSql .= "     when gerfres.r20_regist IS NOT NULL and r20_anousu = $iAno";/* Caso tenha cálculo */
        $sSql .= "       then (rhpessoalmov.rh02_anousu = $iAno)";
        $sSql .= "     else (extract(year from rhpesrescisao.rh05_recis) = $iAno)"; /* Caso não tenha calculo*/
        $sSql .= " end";

        $sSql .= "    and rhpessoalmov.rh02_instit                     = $iInstit                                                                                     \n";
        $sSql .= "    and rhpesrescisao.rh05_seqpes is not null                                                                                                       \n";
        $sSql .= "    and case                                                                                                                                        \n";
        $sSql .= "          when gerfres.r20_regist is null                                       /* Caso não tenha cálculo                              */           \n";
        $sSql .= "          then (afasta.r45_regist is not null and rhcadregime.rh52_regime <> 2) /* Valida se tem afastamento e se o servidor não é CLT */           \n";
        $sSql .= "          else true                                                             /* no caso de haver cálculo retorna semrpre            */           \n";
        $sSql .= "        end                                                                                                                                         \n";
        $sSql .= "                                  $dbwhere                                                                                                           \n";
        $sSql .= "  order by rh01_regist                                                                                                                              \n";
        return $sSql;
    }

    function sql_servidor_rescisao($rh05_seqpes = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from rhpesrescisao ";
        $sql .= "      inner join rhpessoalmov  on  rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes";
        $sql .= "      inner join rhpessoal on  rhpessoalmov.rh02_regist = rhpessoal.rh01_regist";
        $sql .= "      inner join cgm  on  rhpessoal.rh01_numcgm = cgm.z01_numcgm ";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($rh05_seqpes != null) {
                $sql2 .= " where rhpesrescisao.rh05_seqpes = $rh05_seqpes ";
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

    function sql_dados_rescisao($rh05_seqpes = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " FROM rhpessoal ";
        $sql .= " JOIN rhpessoalmov ON rhpessoal.rh01_regist = rhpessoalmov.rh02_regist ";
        $sql .= " JOIN cgm ON rhpessoal.rh01_numcgm = cgm.z01_numcgm ";
        $sql .= " LEFT JOIN rhpesdoc ON rhpessoal.rh01_regist = rhpesdoc.rh16_regist ";
        $sql .= " LEFT JOIN tpcontra ON rhpessoalmov.rh02_tpcont = tpcontra.h13_codigo ";
        $sql .= " LEFT JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg ";
        $sql .= " LEFT JOIN rhfuncao ON (rhpessoal.rh01_funcao, rhpessoal.rh01_instit) = (rhfuncao.rh37_funcao, rhfuncao.rh37_instit) ";
        $sql .= " LEFT JOIN rhpesfgts ON rhpessoal.rh01_regist = rhpesfgts.rh15_regist ";
        $sql .= " LEFT JOIN rhpesrescisao ON rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes ";
        $sql .= " LEFT JOIN rescisao ON rescisao.r59_anousu  = rhpessoalmov.rh02_anousu  ";
        $sql .= "          AND rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu  ";
        $sql .= "          AND rescisao.r59_regime = rhregime.rh30_regime  ";
        $sql .= "          AND rescisao.r59_causa  = rhpesrescisao.rh05_causa ";
        $sql .= "          AND rescisao.r59_caub   = rhpesrescisao.rh05_caub::char(2) ";
        $sql .= "          AND rescisao.r59_instit = rhpessoalmov.rh02_instit ";

        $sql2 = "";
        if ($dbwhere == "") {
            if ($rh05_seqpes != null) {
                $sql2 .= " where rhpesrescisao.rh05_seqpes = $rh05_seqpes ";
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
