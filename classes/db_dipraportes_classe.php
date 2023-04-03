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
class cl_dipraportes
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
    var $c240_codhist = 0;
    var $c240_compl = 'f';
    var $c240_descr = null;
    var $nomeTabela = "dipraportes";
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        c240_sequencial int4 NOT NULL
        c240_coddipr int8,
        c240_tipoente int4,
        c240_datasicom date,
   	    c240_mescompetencia int4,
        c240_exerciciocompetencia int4,
        c240_tipofundo int4,
        c240_tipoaporte int4,
        c240_descricao text,
        c240_atonormativo int4,
        c240_exercicioatonormativo int4,
        c240_valoraporte numeric,
        c240_datarepasse ";

    //funcao construtor da classe
    function cl_dipraportes()
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
        $this->c240_sequencial = ($this->c240_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_sequencial"] : $this->c240_sequencial);
        if ($exclusao == false) {
            $this->c240_coddipr = ($this->c240_coddipr == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_coddipr"] : $this->c240_coddipr);
            $this->c240_tipoente = ($this->c240_tipoente == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_tipoente"] : $this->c240_tipoente);
            $this->atualizaCampoData("c240_datasicom");
            $this->c240_mescompetencia = ($this->c240_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_mescompetencia"] : $this->c240_mescompetencia);
            $this->c240_exerciciocompetencia = ($this->c240_exerciciocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_exerciciocompetencia"] : $this->c240_exerciciocompetencia);
            $this->c240_tipofundo = ($this->c240_tipofundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_tipofundo"] : $this->c240_tipofundo);
            $this->c240_tipoaporte = ($this->c240_tipoaporte == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_tipoaporte"] : $this->c240_tipoaporte);
            $this->verificarCondicaoDescricao("c240_descricao");
            $this->c240_atonormativo = ($this->c240_atonormativo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_atonormativo"] : $this->c240_atonormativo);
            $this->c240_exercicioatonormativo = ($this->c240_exercicioatonormativo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_exercicioatonormativo"] : $this->c240_exercicioatonormativo);
            $this->c240_valoraporte = ($this->c240_valoraporte == "" ? @$GLOBALS["HTTP_POST_VARS"]["c240_valoraporte"] : $this->c240_valoraporte);
            $this->atualizaCampoData("c240_datarepasse");
        }
    }

    function verificarCondicaoDescricao($nomeCampo)
    {
        if ($this->c240_tipoaporte != "5") {
            $this->$nomeCampo = "";
            return;
        }
        $this->$nomeCampo = ($this->nomeCampo == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampo] : $this->$nomeCampo);
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

    function verificacoes()
    {
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

        if (!$this->verificaAporte())
            return false;

        if (!$this->verificaDescricao())
            return false;

        if (!$this->verificaAtoNormativo())
            return false;

        if (!$this->verificaExercicioNormativo())
            return false;

        if (!$this->verificaValorAporte())
            return false;
        if (db_getsession("DB_anousu") > 2022){
            if (!$this->verificaDataRepasse())
                return false;
        }    
        return true;
    }

    // funcao para Inclusão
    function incluir()
    {
        $this->atualizacampos();

        if (!$this->verificacoes())
            return false;
          
        if (db_getsession("DB_anousu") > 2022)
            $this->c240_atonormativo = 'null'; 
            
        if (db_getsession("DB_anousu") > 2022)
            $this->c240_exercicioatonormativo = 'null' ;
          
        $sql  = " INSERT INTO {$this->nomeTabela} ( ";
        $sql .= " c240_coddipr, ";
        $sql .= " c240_datasicom, ";
        $sql .= " c240_tipoente, ";
        $sql .= " c240_mescompetencia, ";
        $sql .= " c240_exerciciocompetencia, ";
        $sql .= " c240_tipofundo, ";
        $sql .= " c240_tipoaporte, ";
        $sql .= " c240_descricao, ";
        $sql .= " c240_atonormativo, ";
        $sql .= " c240_exercicioatonormativo, ";
        $sql .= " c240_valoraporte, ";
        $sql .= " c240_datarepasse ";
        $sql .= " ) VALUES ( ";
        $sql .= " {$this->c240_coddipr}, ";
        $sql .= " '{$this->c240_datasicom}', ";
        $sql .= " {$this->c240_tipoente}, "; 
        $sql .= " {$this->c240_mescompetencia}, ";
        $sql .= " {$this->c240_exerciciocompetencia}, ";
        $sql .= " {$this->c240_tipofundo}, ";
        $sql .= " {$this->c240_tipoaporte}, ";
        $sql .= " '{$this->c240_descricao}', ";
        $sql .= " {$this->c240_atonormativo}, ";
        $sql .= " {$this->c240_exercicioatonormativo}, ";
        $sql .= " {$this->c240_valoraporte},";
        if (db_getsession("DB_anousu") > 2022)
            $sql .= " '{$this->c240_datarepasse}' ) ";
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
        $this->erro_sql .= "Valores : " . $this->c240_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    function alterar($c240_sequencial = null)
    {
        $this->atualizacampos();

        if (!$this->verificacoes())
            return false;

        $sql = " UPDATE {$this->nomeTabela} SET ";
        $virgula = "";

        if ($this->verificaSequencial()) {
            $sql .= $virgula . " c240_sequencial = {$this->c240_sequencial} ";
            $virgula = ",";
        }

        if ($this->verificaCodigoDIRP()) {
            $sql .= $virgula . " c240_coddipr = {$this->c240_coddipr} ";
            $virgula = ",";
        }

        if ($this->verificaTipoEnte()) {
            $sql .= $virgula . " c240_tipoente = {$this->c240_tipoente} ";
            $virgula = ",";
        }

        if ($this->verificaDataSICOM()) {
            $sql .= $virgula . " c240_datasicom = '{$this->c240_datasicom}' ";
            $virgula = ",";
        }

        if ($this->verificaMesCompetencia()) {
            $sql .= $virgula . " c240_mescompetencia = {$this->c240_mescompetencia} ";
            $virgula = ",";
        }

        if ($this->verificaExercicioCompetencia()) {
            $sql .= $virgula . " c240_exerciciocompetencia = {$this->c240_exerciciocompetencia} ";
            $virgula = ",";
        }

        if ($this->verificaTipoFundo()) {
            $sql .= $virgula . " c240_tipofundo = {$this->c240_tipofundo} ";
            $virgula = ",";
        }

        if ($this->verificaAporte()) {
            $sql .= $virgula . " c240_tipoaporte = {$this->c240_tipoaporte} ";
            $virgula = ",";
        }

        if ($this->verificaDescricao()) {
            $sql .= $virgula . " c240_descricao = '{$this->c240_descricao}' ";
            $virgula = ",";
        }

        if ($this->verificaAtoNormativo()) {
            if (db_getsession("DB_anousu") > 2022)
                $sql .= $virgula . " c240_atonormativo = null ";
            else 
                $sql .= $virgula . " c240_atonormativo = {$this->c240_atonormativo} ";
            $virgula = ",";
        }

        if ($this->verificaExercicioNormativo()) {
            if (db_getsession("DB_anousu") > 2022)
                $sql .= $virgula . " c240_exercicioatonormativo = null ";
            else 
                $sql .= $virgula . " c240_exercicioatonormativo = {$this->c240_exercicioatonormativo} ";  
            $virgula = ",";
        }

        if ($this->verificaValorAporte()) {
            $sql .= $virgula . " c240_valoraporte = {$this->c240_valoraporte} ";
            $virgula = ",";
        }

        if ($this->verificaDataRepasse()) {
            if (db_getsession("DB_anousu") > 2022)
                $sql .= $virgula . " c240_datarepasse = '{$this->c240_datarepasse}' ";
            else 
                $sql .= $virgula . " c240_datarepasse = null ";    
            $virgula = ",";
        }

        $sql .= " WHERE ";

        if ($c240_sequencial != null) {
            $sql .= " c240_sequencial = $c240_sequencial ";
        }

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->c240_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->c240_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteracao efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->c240_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($c240_sequencial = null, $dbwhere = null)
    {
        $sql = " DELETE FROM {$this->nomeTabela} WHERE ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($c240_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c240_sequencial = $c240_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }

        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $c240_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $c240_sequencial;
                $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $c240_sequencial;
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

    function sql_query($c240_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
            if ($c240_sequencial != null) {
                $sql2 .= " WHERE c240_sequencial = $c240_sequencial ";
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

    function sql_query_file($c240_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
            if ($c240_sequencial != null) {
                $sql2 .= " where c240_sequencial = $c240_sequencial ";
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
        $nomeCampo = "c240_sequencial";
        $descricaoCampo = "Sequencial";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function verificaCodigoDIRP()
    {
        $nomeCampo = "c240_coddipr";
        $descricaoCampo = "Código DIRP";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaTipoEnte()
    {
        $nomeCampo = "c240_tipoente";
        $descricaoCampo = "Tipo Ente";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaDataSICOM()
    {
        $nomeCampo = "c240_datasicom";
        $descricaoCampo = "Data SICOM";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function verificaMesCompetencia()
    {
        $nomeCampo = "c240_mescompetencia";
        $descricaoCampo = "Mês da Competência";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaExercicioCompetencia()
    {
        $nomeCampo = "c240_exerciciocompetencia";
        $descricaoCampo = "Exercício da Competencia";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function verificaTipoFundo()
    {
        $nomeCampo = "c240_tipofundo";
        $descricaoCampo = "Tipo de Fundo";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaAporte()
    {
        $nomeCampo = "c240_tipoaporte";
        $descricaoCampo = "Tipo de Aporte";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function verificaDescricao()
    {
        $nomeCampo = "c240_descricao";
        $descricaoCampo = "Descrição";
        if (trim($this->$nomeCampo) == "" and trim($GLOBALS["HTTP_POST_VARS"][$nomeCampo]) == "" and $this->c240_tipoaporte == 5) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;
    }

    public function verificaAtoNormativo()
    {
        $nomeCampo = "c240_atonormativo";
        $descricaoCampo = "Ato Normativo";
        if (db_getsession("DB_anousu") < 2023)
            return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
        else 
            return true;
          
    }

    public function verificaExercicioNormativo()
    {
        $nomeCampo = "c240_exercicioatonormativo";
        $descricaoCampo = "Exercício Normativo";
        if (db_getsession("DB_anousu") < 2023)
            return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
            else 
            return true;    
    }

    public function verificaValorAporte()
    {
        $nomeCampo = "c240_valoraporte";
        $descricaoCampo = "Valor de Aporte";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function verificaDataRepasse()
    {
        $nomeCampo = "c240_datarepasse";
        $descricaoCampo = "Valor da Data do Repasse";
        if (db_getsession("DB_anousu") > 2022)
            return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    public function validacaoCampoTexto($nomeCampo, $descricaoCampo)
    {
        if (trim($this->$nomeCampo) == "" and trim($GLOBALS["HTTP_POST_VARS"][$nomeCampo]) == "") {
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
