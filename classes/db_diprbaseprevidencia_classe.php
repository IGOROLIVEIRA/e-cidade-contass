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
class cl_diprbaseprevidencia
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
    var $c238_codhist = 0;
    var $c238_compl = 'f';
    var $c238_descr = null;
    var $c238_valorjuros = 0;
    var $c238_valormulta = 0;
    var $c238_valoratualizacaomonetaria = 0;
    var $c238_valortotaldeducoes = 0;
    var $nomeTabela = "diprbaseprevidencia";
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        c238_sequencial int4 NOT NULL 
        c238_coddipr int8,
        c238_tipoente int4,
        c238_datasicom date,
   	    c238_mescompetencia int4,
        c238_exerciciocompetencia int4,
        c238_tipofundo int4,
        c238_tiporepasse int4,
        c238_tipocontribuicaopatronal int4,
        c238_tipocontribuicaosegurados int4,
        c238_tipocontribuicao int4,
        c238_datarepasse date,
        c238_datavencimentorepasse date,
        c238_valororiginal numeric,
        c238_valororiginalrepassado numeric,
        c238_valorjuros numeric,
        c238_valormulta numeric,
        c238_valoratualizacaomonetaria numeric,
        c238_valortotaldeducoes numeric";

    //funcao construtor da classe
    function cl_diprbaseprevidencia()
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
        $this->c238_sequencial = ($this->c238_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_sequencial"] : $this->c238_sequencial);
        if ($exclusao == false) {
            $this->c238_coddipr = ($this->c238_coddipr == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_coddipr"] : $this->c238_coddipr);
            $this->c238_tipoente = ($this->c238_tipoente == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_tipoente"] : $this->c238_tipoente);
            $this->atualizaCampoData("c238_datasicom");
            $this->c238_mescompetencia = ($this->c238_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_mescompetencia"] : $this->c238_mescompetencia);
            $this->c238_exerciciocompetencia = ($this->c238_exerciciocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_exerciciocompetencia"] : $this->c238_exerciciocompetencia);
            $this->c238_tipofundo = ($this->c238_tipofundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_tipofundo"] : $this->c238_tipofundo);
            $this->c238_tiporepasse = ($this->c238_tiporepasse == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_tiporepasse"] : $this->c238_tiporepasse);
            $this->c238_tipocontribuicaopatronal = ($this->c238_tipocontribuicaopatronal == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_tipocontribuicaopatronal"] : $this->c238_tipocontribuicaopatronal);
            $this->c238_tipocontribuicaosegurados = ($this->c238_tipocontribuicaosegurados == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_tipocontribuicaosegurados"] : $this->c238_tipocontribuicaosegurados);
            $this->c238_tipocontribuicao = ($this->c238_tipocontribuicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_tipocontribuicao"] : $this->c238_tipocontribuicao);
            $this->atualizaCampoData("c238_datarepasse");
            $this->atualizaCampoData("c238_datavencimentorepasse");
            $this->c238_valororiginal = ($this->c238_valororiginal == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_valororiginal"] : $this->c238_valororiginal);
            $this->c238_valororiginalrepassado = ($this->c238_valororiginalrepassado == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_valororiginalrepassado"] : $this->c238_valororiginalrepassado);
            $this->c238_valorjuros = ($this->c238_valorjuros == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_valorjuros"] : $this->c238_valorjuros);
            $this->c238_valormulta = ($this->c238_valormulta == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_valormulta"] : $this->c238_valormulta);
            $this->c238_valoratualizacaomonetaria = ($this->c238_valoratualizacaomonetaria == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_valoratualizacaomonetaria"] : $this->c238_valoratualizacaomonetaria);
            $this->c238_valortotaldeducoes = ($this->c238_valortotaldeducoes == "" ? @$GLOBALS["HTTP_POST_VARS"]["c238_valortotaldeducoes"] : $this->c238_valortotaldeducoes);
            
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

        if (!$this->verificaDataRepasse())
            return false;

        if (!$this->verificaDataVencimentoRepasse())
            return false;

        if (!$this->verificaValorOriginal())
            return false;

        if (!$this->verificaValorOriginalRepassado())
            return false;

        if (db_getsession("DB_anousu") > 2022){
            if (!$this->verificaValorJuros())
                return false;
           
            if (!$this->verificaValorMulta())
                return false;    

            if (!$this->verificaValorAtualizacaoMonetaria())
                return false;  
                
            if (!$this->verificaValorDeducoes())
                return false;
        }else{
            $this->c238_valorjuros = 'null';
            $this->c238_valormulta = 'null';
            $this->c238_valoratualizacaomonetaria = 'null';
            $this->c238_valortotaldeducoes = 'null' ;
        }     
                      
        $sql  = "INSERT INTO {$this->nomeTabela} ( ";
        $sql .= " c238_coddipr, ";
        $sql .= " c238_datasicom, ";
        $sql .= " c238_tipoente, ";
        $sql .= " c238_mescompetencia, ";
        $sql .= " c238_exerciciocompetencia, ";
        $sql .= " c238_tipofundo, ";
        $sql .= " c238_tiporepasse, ";
        $sql .= " c238_tipocontribuicaopatronal, ";
        $sql .= " c238_tipocontribuicaosegurados, ";
        $sql .= " c238_tipocontribuicao, ";
        $sql .= " c238_datarepasse, ";
        $sql .= " c238_datavencimentorepasse, ";
        $sql .= " c238_valororiginal, ";
        $sql .= " c238_valororiginalrepassado, ";
        $sql .= " c238_valorjuros, ";
        $sql .= " c238_valormulta, ";
        $sql .= " c238_valoratualizacaomonetaria, ";
        $sql .= " c238_valortotaldeducoes ";
        $sql .= ") VALUES ( ";
        $sql .= " {$this->c238_coddipr}, ";
        $sql .= " '{$this->c238_datasicom}', ";
        $sql .= " {$this->c238_tipoente}, ";
        $sql .= " {$this->c238_mescompetencia}, ";
        $sql .= " {$this->c238_exerciciocompetencia}, ";
        $sql .= " {$this->c238_tipofundo}, ";
        $sql .= " {$this->c238_tiporepasse}, ";
        $sql .= " {$this->c238_tipocontribuicaopatronal}, ";
        $sql .= " {$this->c238_tipocontribuicaosegurados}, ";
        $sql .= " {$this->c238_tipocontribuicao}, ";
        $sql .= " '{$this->c238_datarepasse}', ";
        $sql .= " '{$this->c238_datavencimentorepasse}', ";
        $sql .= " {$this->c238_valororiginal}, ";
        $sql .= " {$this->c238_valororiginalrepassado}, ";
        $sql .= " {$this->c238_valorjuros}, ";
        $sql .= " {$this->c238_valormulta}, ";
        $sql .= " {$this->c238_valoratualizacaomonetaria}, ";
        $sql .= " {$this->c238_valortotaldeducoes}) ";
     
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
        $this->erro_sql .= "Valores : " . $this->c238_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    function alterar($c238_sequencial = null)
    {
        $this->atualizacampos();
     
        if (!$this->verificaContribuicaoPatronal())
            return false;

        if (!$this->verificaContribuicaoSegurados())
            return false;

        $sql = " UPDATE {$this->nomeTabela} SET ";
        $virgula = "";

        if ($this->verificaSequencial()) {
            $sql .= $virgula . " c238_sequencial = {$this->c238_sequencial} ";
            $virgula = ",";            
        }
    
        if ($this->verificaCodigoDIRP()) {
            $sql .= $virgula . " c238_coddipr = {$this->c238_coddipr} ";
            $virgula = ",";   
        }

        if ($this->verificaTipoEnte()) {
            $sql .= $virgula . " c238_tipoente = {$this->c238_tipoente} ";
            $virgula = ",";            
        }

        if ($this->verificaDataSICOM()) {
            $sql .= $virgula . " c238_datasicom = '{$this->c238_datasicom}' ";
            $virgula = ",";   
        }

        if ($this->verificaMesCompetencia()) {
            $sql .= $virgula . " c238_mescompetencia = {$this->c238_mescompetencia} ";
            $virgula = ",";   
        }

        if ($this->verificaExercicioCompetencia()) {
            $sql .= $virgula . " c238_exerciciocompetencia = {$this->c238_exerciciocompetencia} ";
            $virgula = ",";   
        }

        if ($this->verificaTipoFundo()) {
            $sql .= $virgula . " c238_tipofundo = {$this->c238_tipofundo} ";
            $virgula = ",";   
        }

        if ($this->verificaTipoRepasse()) {
            $sql .= $virgula . " c238_tiporepasse = {$this->c238_tiporepasse} ";
            $virgula = ",";   
        }

        if ($this->verificaContribuicaoPatronal()) {
            $sql .= $virgula . " c238_tipocontribuicaopatronal = {$this->c238_tipocontribuicaopatronal} ";
            $virgula = ",";   
        }

        if ($this->verificaContribuicaoSegurados()) {
            $sql .= $virgula . " c238_tipocontribuicaosegurados = {$this->c238_tipocontribuicaosegurados} ";
            $virgula = ",";   
        }

        if ($this->verificaTipoContribuicao()) {
            $sql .= $virgula . " c238_tipocontribuicao = {$this->c238_tipocontribuicao} ";
            $virgula = ",";   
        }

        if ($this->verificaDataRepasse()) {
            $sql .= $virgula . " c238_datarepasse = '{$this->c238_datarepasse}' ";
            $virgula = ",";   
        }

        if ($this->verificaDataVencimentoRepasse()) {
            $sql .= $virgula . " c238_datavencimentorepasse = '{$this->c238_datavencimentorepasse}' ";
            $virgula = ",";   
        }

        if ($this->verificaValorOriginal()) {
            $sql .= $virgula . " c238_valororiginal = '{$this->c238_valororiginal}' ";
            $virgula = ",";   
        }

        if ($this->verificaValorOriginalRepassado()) {
            $sql .= $virgula . " c238_valororiginalrepassado = '{$this->c238_valororiginalrepassado}' ";
            $virgula = ",";   
        }

        if ($this->verificaValorJuros()) {
            if (db_getsession("DB_anousu") > 2022)
                $sql .= $virgula . " c238_valorjuros = '{$this->c238_valorjuros}' ";
            else 
                $sql .= $virgula . " c238_valorjuros = null ";
            $virgula = ",";   
        }

        if ($this->verificaValorMulta()) {
            if (db_getsession("DB_anousu") > 2022)
                $sql .= $virgula . " c238_valormulta = '{$this->c238_valormulta}' ";
            else 
                $sql .= $virgula . " c238_valormulta = null ";  
            $virgula = ",";   
        }

        if ($this->verificaValorAtualizacaoMonetaria()) {
            if (db_getsession("DB_anousu") > 2022)
                $sql .= $virgula . " c238_valoratualizacaomonetaria = '{$this->c238_valoratualizacaomonetaria}' ";
            else 
                $sql .= $virgula . " c238_valoratualizacaomonetaria = null ";    
            $virgula = ",";   
        }

        if ($this->verificaValorDeducoes()) {
            if (db_getsession("DB_anousu") > 2022)
                $sql .= $virgula . " c238_valortotaldeducoes = '{$this->c238_valortotaldeducoes}' ";
            else 
                $sql .= $virgula . " c238_valortotaldeducoes = null ";       
            $virgula = ",";   
        }

        $sql .= " WHERE ";

        if ($c238_sequencial != null) {
            $sql .= " c238_sequencial = $c238_sequencial ";
        }

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->c238_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->c238_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteracao efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->c238_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($c238_sequencial = null, $dbwhere = null)
    {
        $sql = " DELETE FROM {$this->nomeTabela} WHERE ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($c238_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c238_sequencial = $c238_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }

        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $c238_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $c238_sequencial;
                $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $c238_sequencial;
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

    function sql_query($c238_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
            if ($c238_sequencial != null) {
                $sql2 .= " WHERE c238_sequencial = $c238_sequencial ";
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

    function sql_query_file($c238_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
            if ($c238_sequencial != null) {
                $sql2 .= " where c238_sequencial = $c238_sequencial ";
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
        $nomeCampo = "c238_sequencial";
        $descricaoCampo = "Sequencial";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    } 

    public function verificaCodigoDIRP()
    {
        $nomeCampo = "c238_coddipr";
        $descricaoCampo = "Código DIRP";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaTipoEnte()
    {
        $nomeCampo = "c238_tipoente";
        $descricaoCampo = "Tipo Ente";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaDataSICOM()
    {
        $nomeCampo = "c238_datasicom";
        $descricaoCampo = "Data SICOM";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function verificaMesCompetencia()
    {
        $nomeCampo = "c238_mescompetencia";
        $descricaoCampo = "Mês Competencia";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    } 

    public function verificaExercicioCompetencia()
    {
        $nomeCampo = "c238_exerciciocompetencia";
        $descricaoCampo = "Exercício Competencia";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    } 

    public function verificaTipoFundo()
    {
        $nomeCampo = "c238_tipofundo";
        $descricaoCampo = "Tipo Fundo";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaTipoRepasse()
    {
        $nomeCampo = "c238_tiporepasse";
        $descricaoCampo = "Tipo Repasse";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    } 

    public function verificaContribuicaoPatronal()
    {
        $nomeCampo = "c238_tipocontribuicaopatronal";
        $descricaoCampo = "Tipo Contribuicao Patronal";
        if ($this->$nomeCampo == 0 AND $this->c238_tiporepasse == 1) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;   
    }

    public function verificaContribuicaoSegurados()
    {
        $nomeCampo = "c238_tipocontribuicaosegurados";
        $descricaoCampo = "Tipo Contribuicao Segurado";
        if ($this->$nomeCampo == 0 AND $this->c238_tiporepasse == 2) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;   
    }

    public function verificaTipoContribuicao()
    {
        $nomeCampo = "c238_tipocontribuicao";
        $descricaoCampo = "Tipo de Contribuicao";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaDataRepasse()
    {
        $nomeCampo = "c238_datarepasse";
        $descricaoCampo = "Data Repasse";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function verificaDataVencimentoRepasse()
    {
        $nomeCampo = "c238_datavencimentorepasse";
        $descricaoCampo = "Data Vencimento Repasse";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function verificaValorOriginal()
    {
        $nomeCampo = "c238_valororiginal";
        $descricaoCampo = "Valor Original";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    } 

    public function verificaValorOriginalRepassado()
    {
        $nomeCampo = "c238_valororiginalrepassado";
        $descricaoCampo = "Valor Original Repassado";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }
 
    public function verificaValorJuros()
    {
        $nomeCampo = "c238_valorjuros";
        $descricaoCampo = "Valor dos Juros";
        if (db_getsession("DB_anousu") > 2022)
            return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);  
    } 

    public function verificaValorMulta()
    {
        $nomeCampo = "c238_valormulta";
        $descricaoCampo = "Valor da Multa";
        if (db_getsession("DB_anousu") > 2022)
            return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
   } 

    public function verificaValorAtualizacaoMonetaria()
    {
        $nomeCampo = "c238_valoratualizacaomonetaria";
        $descricaoCampo = "Valor da atualização monetária";
        if (db_getsession("DB_anousu") > 2022)
            return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
} 

    public function verificaValorDeducoes()
    {
        $nomeCampo = "c238_valortotaldeducoes";
        $descricaoCampo = "Valor total das deduções";
        if (db_getsession("DB_anousu") > 2022)
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