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
 *  junto com este programa; se não, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: contabilidade
//CLASSE DA ENTIDADE dipr
class cl_diprdeducoes
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
    var $c239_codhist = 0;
    var $c239_compl = 'f';
    var $c239_descr = null;
    var $c239_datarepasse = null;
    var $c239_datarepasse_dia = null;
    var $c239_datarepasse_mes = null;
    var $c239_datarepasse_ano = null; 
    var $nomeTabela = "diprdeducoes";
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        c239_sequencial int4 NOT NULL,
        c239_coddipr int8,
        c239_datasicom date,
        c239_tipoente int4,
   	    c239_mescompetencia int4,
        c239_exerciciocompetencia int4,
        c239_tipofundo int4,
        c239_tiporepasse int4,
        c239_tipocontribuicaopatronal int4,
        c239_tipocontribuicaosegurados int4,
        c239_tipodeducao int4,
        c239_tipocontribuicao int4,
        c239_descricao text,
        c239_valordeducao numeric,
        c239_datarepasse date ";

    //funcao construtor da classe
    function cl_diprdeducoes()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo($this->nomeTabela);
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
        $this->c239_sequencial = ($this->c239_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_sequencial"] : $this->c239_sequencial);
        if ($exclusao == false) {
            $this->c239_coddipr = ($this->c239_coddipr == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_coddipr"] : $this->c239_coddipr);
            $this->c239_tipoente = ($this->c239_tipoente == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_tipoente"] : $this->c239_tipoente);
            $this->atualizaCampoData("c239_datasicom");
            $this->c239_mescompetencia = ($this->c239_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_mescompetencia"] : $this->c239_mescompetencia);
            $this->c239_exerciciocompetencia = ($this->c239_exerciciocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_exerciciocompetencia"] : $this->c239_exerciciocompetencia);
            $this->c239_tipofundo = ($this->c239_tipofundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_tipofundo"] : $this->c239_tipofundo);
            $this->c239_tiporepasse = ($this->c239_tiporepasse == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_tiporepasse"] : $this->c239_tiporepasse);
            $this->c239_tipocontribuicaopatronal = ($this->c239_tipocontribuicaopatronal == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_tipocontribuicaopatronal"] : $this->c239_tipocontribuicaopatronal);
            $this->c239_tipocontribuicaosegurados = ($this->c239_tipocontribuicaosegurados == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_tipocontribuicaosegurados"] : $this->c239_tipocontribuicaosegurados);
            $this->c239_tipocontribuicao = ($this->c239_tipocontribuicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_tipocontribuicao"] : $this->c239_tipocontribuicao);
            $this->c239_tipodeducao = ($this->c239_tipodeducao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_tipodeducao"] : $this->c239_tipodeducao);
            $this->c239_descricao = ($this->c239_descricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_descricao"] : $this->c239_descricao);
            $this->c239_valordeducao = ($this->c239_valordeducao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_valordeducao"] : $this->c239_valordeducao);
            if ($this->c239_datarepasse == "") {
                $this->c239_datarepasse_dia = ($this->c239_datarepasse_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_datarepasse_dia"] : $this->c239_datarepasse_dia);
                $this->c239_datarepasse_mes = ($this->c239_datarepasse_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_datarepasse_mes"] : $this->c239_datarepasse_mes);
                $this->c239_datarepasse_ano = ($this->c239_datarepasse_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["c239_datarepasse_ano"] : $this->c239_datarepasse_ano);
                if ($this->c239_datarepasse_dia != "") {
                    $this->c239_datarepasse = $this->c239_datarepasse_ano . "-" . $this->c239_datarepasse_mes . "-" . $this->c239_datarepasse_dia;
                }
            }
        } 

    }

    function atualizaCampoData($nomeCampo)
    {
        $nomeCampoDia = "{$nomeCampo}_dia";
        $nomeCampoMes = "{$nomeCampo}_mes";
        $nomeCampoAno = "{$nomeCampo}_ano";
        if ($this->$nomeCampo == "") {
            $this->$nomeCampoDia = ($this->$nomeCampoDia == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampoDia] : $this->$nomeCampoDia);
            $this->$nomeCampoMes = ($this->$nomeCampoMes == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampoMes] : $this->$nomeCampoMes);
            $this->$nomeCampoAno = ($this->$nomeCampoAno == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampoAno] : $this->$nomeCampoAno);
            if ($this->$nomeCampoDia != "") {
                $this->$nomeCampo = $this->$nomeCampoAno . "-" . $this->$nomeCampoMes . "-" . $this->$nomeCampoDia;
            }
        }
    }

    // funcao para Inclusão
    function incluir()
    {
        $this->atualizacampos();
        if (!$this->verificaCodigoDIRP())
            return false;

        if (!$this->verificaTipoEnte())
            return false;

        if (!$this->verificaDataSICOM())
            return false;

        if (!$this->verificaMesCompetencia())
            return false;

        if (!$this->verificaExercicioCompetencia())
            return false;

        if (!$this->verificaTipoFundo())
            return false;

        if (!$this->verificaTipoRepasse())
            return false;

        if (!$this->verificaContribuicaoPatronal())
            return false;

        if (!$this->verificaContribuicaoSegurados())
            return false;

        if (!$this->verificaTipoContribuicao())
            return false;

        if (!$this->verificaTipoDeducao())
            return false;

        if (!$this->verificaDataRepasse())
            return false;           

        if (!$this->verificaDescricao())
            return false;

        if (!$this->verificaValorDeducao())
            return false;

        $sql  = " INSERT INTO {$this->nomeTabela} ( ";
        $sql .= " c239_coddipr, ";
        $sql .= " c239_tipoente, ";
        $sql .= " c239_datasicom, ";
        $sql .= " c239_mescompetencia, ";
        $sql .= " c239_exerciciocompetencia, ";
        $sql .= " c239_tipofundo, ";
        $sql .= " c239_tiporepasse, ";
        $sql .= " c239_tipocontribuicaopatronal, ";
        $sql .= " c239_tipocontribuicaosegurados, ";
        $sql .= " c239_tipodeducao, ";
        $sql .= " c239_tipocontribuicao, ";   
        $sql .= " c239_descricao, ";
        $sql .= " c239_valordeducao, ";
        $sql .= " c239_datarepasse ";
        $sql .= " ) VALUES ( ";
        $sql .= " {$this->c239_coddipr}, ";
        $sql .= " {$this->c239_tipoente}, ";
        $sql .= " '{$this->c239_datasicom}', ";
        $sql .= " {$this->c239_mescompetencia}, ";
        $sql .= " {$this->c239_exerciciocompetencia}, ";
        $sql .= " {$this->c239_tipofundo}, ";
        $sql .= " {$this->c239_tiporepasse}, ";
        $sql .= " {$this->c239_tipocontribuicaopatronal}, ";
        $sql .= " {$this->c239_tipocontribuicaosegurados}, ";
        $sql .= " {$this->c239_tipocontribuicao}, ";
        $sql .= " {$this->c239_tipodeducao}, ";
        $sql .= " '{$this->c239_descricao}', ";
        $sql .= " {$this->c239_valordeducao}, ";
        if (db_getsession("DB_anousu") > 2022)
            $sql .= " '{$this->c239_datarepasse}' ) ";
        else  
            $sql .= " null) ";  

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "DIRP não Incluída. Inclusão Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "DIRP já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "DIRP não Incluído. Inclusão Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->c239_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    function alterar($c239_sequencial = null)
    {
        $this->atualizacampos();

        if (!$this->verificaContribuicaoPatronal())
            return false;

        if (!$this->verificaContribuicaoSegurados())
            return false;

        if (!$this->verificaDescricao())
            return false;      

        $sql = " UPDATE {$this->nomeTabela} SET ";
        $virgula = "";

        if ($this->verificaSequencial()) {
            $sql .= $virgula . " c239_sequencial = {$this->c239_sequencial} ";
            $virgula = ",";            
        }

        if ($this->verificaCodigoDIRP()) {
            $sql .= $virgula . " c239_coddipr = {$this->c239_coddipr} ";
            $virgula = ",";            
        }

        if ($this->verificaTipoEnte()) {
            $sql .= $virgula . " c239_tipoente = {$this->c239_tipoente} ";
            $virgula = ",";            
        }

        if ($this->verificaDataSICOM()) {
            $sql .= $virgula . " c239_datasicom = '{$this->c239_datasicom}' ";
            $virgula = ",";            
        }

        if ($this->verificaMesCompetencia()) {
            $sql .= $virgula . " c239_mescompetencia = {$this->c239_mescompetencia} ";
            $virgula = ",";            
        }

        if ($this->verificaExercicioCompetencia()) {
            $sql .= $virgula . " c239_exerciciocompetencia = {$this->c239_exerciciocompetencia} ";
            $virgula = ",";            
        }

        if ($this->verificaTipoFundo()) {
            $sql .= $virgula . " c239_tipofundo = {$this->c239_tipofundo} ";
            $virgula = ",";            
        }

        if ($this->verificaTipoRepasse()) {
            $sql .= $virgula . " c239_tiporepasse = {$this->c239_tiporepasse} ";
            $virgula = ",";            
        }

        if ($this->verificaContribuicaoPatronal()) {
            $sql .= $virgula . " c239_tipocontribuicaopatronal = {$this->c239_tipocontribuicaopatronal} ";
            $virgula = ",";            
        }

        if ($this->verificaContribuicaoSegurados()) {
            $sql .= $virgula . " c239_tipocontribuicaosegurados = {$this->c239_tipocontribuicaosegurados} ";
            $virgula = ",";            
        }

        if ($this->verificaTipoContribuicao()) {
            $sql .= $virgula . " c239_tipocontribuicao = {$this->c239_tipocontribuicao} ";
            $virgula = ",";            
        }

        if ($this->verificaTipoDeducao()) {
            $sql .= $virgula . " c239_tipodeducao = {$this->c239_tipodeducao} ";
            $virgula = ",";            
        }

        if ($this->verificaDataRepasse()) {
            if(db_getsession("DB_anousu") < 2023){
                $sql .= $virgula . " c239_datarepasse = 'null'";
                $virgula = ","; 
            }else{
                $sql .= $virgula . " c239_datarepasse = '{$this->c239_datarepasse}' ";
                $virgula = ","; 
            }        
        }        

        if ($this->verificaDescricao()) {
            $sql .= $virgula . " c239_descricao = '{$this->c239_descricao}' ";
            $virgula = ",";            
        }

        if ($this->verificaValorDeducao()) {
            $sql .= $virgula . " c239_valordeducao = {$this->c239_valordeducao} ";
            $virgula = ",";            
        }

        $sql .= " WHERE ";

        if ($c239_sequencial != null) {
            $sql .= " c239_sequencial = $c239_sequencial ";
        }
        
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->c239_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg  .= $sql;
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->c239_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteracao efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->c239_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($c239_sequencial = null, $dbwhere = null)
    {
        $sql = " DELETE FROM {$this->nomeTabela} WHERE ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($c239_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c239_sequencial = $c239_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }

        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $c239_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $c239_sequencial;
                $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $c239_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

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
            $this->erro_sql   = "Record Vazio na Tabela:dipr";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    function sql_query($c239_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
    {
        $sql = "SELECT ";
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
        $sql .= " FROM {$this->nomeTabela} ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c239_sequencial != null) {
                $sql2 .= " WHERE c239_sequencial = $c239_sequencial ";
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

    function sql_query_file($c239_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from {$this->nomeTabela} ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c239_sequencial != null) {
                $sql2 .= " where c239_sequencial = $c239_sequencial ";
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

    public function verificaSequencial()
    {
        $nomeCampo = "c239_sequencial";
        $descricaoCampo = "Sequencial";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function verificaCodigoDIRP()
    {
        $nomeCampo = "c239_coddipr";
        $descricaoCampo = "Código DIRP";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaTipoEnte()
    {
        $nomeCampo = "c239_tipoente";
        $descricaoCampo = "Tipo Ente";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaDataSICOM()
    {
        $nomeCampo = "c239_datasicom";
        $descricaoCampo = "Data SICOM";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function verificaMesCompetencia()
    {
        $nomeCampo = "c239_mescompetencia";
        $descricaoCampo = "Mês Competencia";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaExercicioCompetencia()
    {
        $nomeCampo = "c239_exerciciocompetencia";
        $descricaoCampo = "Exercício Competencia";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    } 

    public function verificaTipoFundo()
    {
        $nomeCampo = "c239_tipofundo";
        $descricaoCampo = "Tipo Fundo";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaTipoRepasse()
    {
        $nomeCampo = "c239_tiporepasse";
        $descricaoCampo = "Tipo Repasse";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    } 

    public function verificaContribuicaoPatronal()
    {
        $nomeCampo = "c239_tipocontribuicaopatronal";
        $descricaoCampo = "Tipo Contribuição Patronal";
        if ($this->$nomeCampo == 0 AND $this->c239_tiporepasse == 1) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;   
    }

    public function verificaContribuicaoSegurados()
    {
        $nomeCampo = "c239_tipocontribuicaosegurados";
        $descricaoCampo = "Tipo Contribuição Segurados";
        if ($this->$nomeCampo == 0 AND $this->c239_tiporepasse == 2) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;   
    } 

    public function verificaTipoContribuicao()
    {
        $nomeCampo = "c239_tipocontribuicao";
        $descricaoCampo = "Tipo Contribuição";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);  
    }

    public function verificaTipoDeducao()
    {
        $nomeCampo = "c239_tipodeducao";
        $descricaoCampo = "Tipo Dedução";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaDataRepasse()
    {
        if(db_getsession("DB_anousu") > 2022){
            $nomeCampo = "c239_datarepasse";
            $descricaoCampo = "Data Repasse";
            return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
        }
        return true;    
    }

    public function verificaDescricao()
    {
        $nomeCampo = "c239_descricao";
        $descricaoCampo = "Descrição";
        if (trim($this->$nomeCampo) == "" AND trim($GLOBALS["HTTP_POST_VARS"][$nomeCampo]) == "" AND $this->c239_tipodeducao == 2) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;
    } 

    public function verificaValorDeducao()
    {
        $nomeCampo = "c239_valordeducao";
        $descricaoCampo = "Valor da Dedução";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function validacaoCampoTexto($nomeCampo, $descricaoCampo)
    {
        if (trim($this->$nomeCampo) == "" AND trim($GLOBALS["HTTP_POST_VARS"][$nomeCampo]) == "") {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;
    }

    public function validacaoCampoInteiro($nomeCampo, $descricaoCampo)
    {
        if ($this->$nomeCampo == 0) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;
    }

    function erroCampo($descricao, $campo)
    {
        $this->erro_sql = $descricao;
        $this->erro_campo = $campo;
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
    }
}