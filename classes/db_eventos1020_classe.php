<?php
//MODULO: esocial
//CLASSE DA ENTIDADE eventos1020
class cl_eventos1020
{
    // cria variaveis de erro
    public $rotulo     = null;
    public $query_sql  = null;
    public $numrows    = 0;
    public $numrows_incluir = 0;
    public $numrows_alterar = 0;
    public $numrows_excluir = 0;
    public $erro_status = null;
    public $erro_sql   = null;
    public $erro_banco = null;
    public $erro_msg   = null;
    public $erro_campo = null;
    public $pagina_retorno = null;
    // cria variaveis do arquivo
    public $eso08_sequencial = 0;
    public $eso08_codempregadorlotacao = null;
    public $eso08_codtipolotacao = 0;
    public $eso08_codtipoinscricao = "";
    public $eso08_numeroinscricao = "";
    public $eso08_codfpas = 0;
    public $eso08_codterceiros = "";
    public $eso08_codterceiroscombinado = "";
    public $eso08_codterceirosprocjudicial = "";
    public $eso08_nroprocessojudicial = "";
    public $eso08_codindicasuspensao = "";
    public $eso08_tipoinscricaocontratante = 0;
    public $eso08_numeroinscricaocontratante = "";
    public $eso08_tipoinscricaoproprietario = 0;
    public $eso08_nroinscricaoproprietario = "";
    public $eso08_aliquotarat = 'f';
    public $eso08_fatoracidentario = "";
    public $eso08_instit = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 eso08_sequencial = int8 = eso08_sequencial
                 eso08_codempregadorlotacao = text = eso08_codempregadorlotacao
                 eso08_codtipolotacao = int4 = eso08_codtipolotacao
                 eso08_codtipoinscricao = varchar(14) = eso08_codtipoinscricao
                 eso08_numeroinscricao = varchar(14) = eso08_numeroinscricao
                 eso08_codfpas = int4 = eso08_codfpas
                 eso08_codterceiros = varchar(50) = eso08_codterceiros
                 eso08_codterceiroscombinado = varchar(50) = eso08_codterceiroscombinado
                 eso08_codterceirosprocjudicial = int4 = eso08_codterceirosprocjudicial
                 eso08_nroprocessojudicial = int8 = eso08_nroprocessojudicial
                 eso08_codindicasuspensao = int8 = eso08_codindicasuspensao
                 eso08_tipoinscricaocontratante = int4 = eso08_tipoinscricaocontratante
                 eso08_numeroinscricaocontratante = varchar(50) = eso08_numeroinscricaocontratante
                 eso08_tipoinscricaoproprietario = int4 = eso08_tipoinscricaoproprietario
                 eso08_nroinscricaoproprietario = varchar(50) = eso08_nroinscricaoproprietario
                 eso08_aliquotarat = bool = eso08_aliquotarat
                 eso08_fatoracidentario = varchar(50) = eso08_fatoracidentario
                 eso08_instit = int4 = eso08_instit
                 ";

    //funcao construtor da classe
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("eventos1020");
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
            $this->eso08_sequencial = ($this->eso08_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_sequencial"] : $this->eso08_sequencial);
            $this->eso08_codempregadorlotacao = ($this->eso08_codempregadorlotacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_codempregadorlotacao"] : $this->eso08_codempregadorlotacao);
            $this->eso08_codtipolotacao = ($this->eso08_codtipolotacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_codtipolotacao"] : $this->eso08_codtipolotacao);
            $this->eso08_codtipoinscricao = ($this->eso08_codtipoinscricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_codtipoinscricao"] : $this->eso08_codtipoinscricao);
            $this->eso08_numeroinscricao = ($this->eso08_numeroinscricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_numeroinscricao"] : $this->eso08_numeroinscricao);
            $this->eso08_codfpas = ($this->eso08_codfpas == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_codfpas"] : $this->eso08_codfpas);
            $this->eso08_codterceiros = ($this->eso08_codterceiros == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_codterceiros"] : $this->eso08_codterceiros);
            $this->eso08_codterceiroscombinado = ($this->eso08_codterceiroscombinado == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_codterceiroscombinado"] : $this->eso08_codterceiroscombinado);
            $this->eso08_codterceirosprocjudicial = ($this->eso08_codterceirosprocjudicial == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_codterceirosprocjudicial"] : $this->eso08_codterceirosprocjudicial);
            $this->eso08_nroprocessojudicial = ($this->eso08_nroprocessojudicial == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_nroprocessojudicial"] : $this->eso08_nroprocessojudicial);
            $this->eso08_codindicasuspensao = ($this->eso08_codindicasuspensao == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_codindicasuspensao"] : $this->eso08_codindicasuspensao);
            $this->eso08_tipoinscricaocontratante = ($this->eso08_tipoinscricaocontratante == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_tipoinscricaocontratante"] : $this->eso08_tipoinscricaocontratante);
            $this->eso08_numeroinscricaocontratante = ($this->eso08_numeroinscricaocontratante == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_numeroinscricaocontratante"] : $this->eso08_numeroinscricaocontratante);
            $this->eso08_tipoinscricaoproprietario = ($this->eso08_tipoinscricaoproprietario == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_tipoinscricaoproprietario"] : $this->eso08_tipoinscricaoproprietario);
            $this->eso08_nroinscricaoproprietario = ($this->eso08_nroinscricaoproprietario == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_nroinscricaoproprietario"] : $this->eso08_nroinscricaoproprietario);
            $this->eso08_aliquotarat = ($this->eso08_aliquotarat == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_aliquotarat"] : $this->eso08_aliquotarat);
            $this->eso08_fatoracidentario = ($this->eso08_fatoracidentario == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_fatoracidentario"] : $this->eso08_fatoracidentario);
            $this->eso08_instit = ($this->eso08_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso08_instit"] : $this->eso08_instit);
        } else {
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();
        if ($this->eso08_sequencial == null) {
            $result = db_query("select nextval('eventos1020_eso08_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: eventos1020_eso08_sequencial_seq do campo: eso08_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->eso08_sequencial = pg_result($result, 0, 0);
        }
        if ($this->eso08_codempregadorlotacao == null) {
            $this->erro_sql = " Campo eso08_codempregadorlotacao não informado.";
            $this->erro_campo = "eso08_codempregadorlotacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso08_codtipolotacao == null) {
            $this->erro_sql = " Campo eso08_codtipolotacao não informado.";
            $this->erro_campo = "eso08_codtipolotacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->eso08_codtipoinscricao == "") {
            $this->eso08_codtipoinscricao = "0";
        }

        if ($this->eso08_numeroinscricao == "") {
            $this->eso08_numeroinscricao = "0";
        }

        if ($this->eso08_codfpas == null) {
            $this->erro_sql = " Campo eso08_codfpas não informado.";
            $this->erro_campo = "eso08_codfpas";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->eso08_codterceiros == null) {
            $this->erro_sql = " Campo eso08_codterceiros não informado.";
            $this->erro_campo = "eso08_codterceiros";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        // if ($this->eso08_codterceiroscombinado == "") {
        //     $this->eso08_codterceiroscombinado = "null";
        // }

        // if ($this->eso08_codterceirosprocjudicial == "") {
        //     $this->eso08_codterceirosprocjudicial = "null";
        // }

        // if ($this->eso08_nroprocessojudicial == "") {
        //     $this->eso08_nroprocessojudicial = "null";
        // }

        // if ($this->eso08_codindicasuspensao == "") {
        //     $this->eso08_codindicasuspensao = "null";
        // }

        // if ($this->eso08_tipoinscricaocontratante == "") {
        //     $this->eso08_tipoinscricaocontratante = "null";
        // }

        // if ($this->eso08_numeroinscricaocontratante == "") {
        //     $this->eso08_numeroinscricaocontratante = "null";
        // }

        // if ($this->eso08_tipoinscricaoproprietario == "") {
        //     $this->eso08_tipoinscricaoproprietario = "null";
        // }
        // if ($this->eso08_nroinscricaoproprietario == "") {
        //     $this->eso08_nroinscricaoproprietario = "null";
        // }
        // if ($this->eso08_aliquotarat == "") {
        //     $this->eso08_aliquotarat = "null";
        // }
        // if ($this->eso08_fatoracidentario == "") {
        //     $this->eso08_fatoracidentario = "null";
        // }

        if ($this->eso08_instit == null) {
            $this->erro_sql = " Campo eso08_instit não informado.";
            $this->erro_campo = "eso08_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into eventos1020(
                                       eso08_sequencial
                                      ,eso08_codempregadorlotacao
                                      ,eso08_codtipolotacao
                                      ,eso08_codtipoinscricao
                                      ,eso08_numeroinscricao
                                      ,eso08_codfpas
                                      ,eso08_codterceiros
                                      ,eso08_codterceiroscombinado
                                      ,eso08_codterceirosprocjudicial
                                      ,eso08_nroprocessojudicial
                                      ,eso08_codindicasuspensao
                                      ,eso08_tipoinscricaocontratante
                                      ,eso08_numeroinscricaocontratante
                                      ,eso08_tipoinscricaoproprietario
                                      ,eso08_nroinscricaoproprietario
                                      ,eso08_aliquotarat
                                      ,eso08_fatoracidentario
                                      ,eso08_instit
                       )
                values (
                                $this->eso08_sequencial
                               ,'$this->eso08_codempregadorlotacao'
                               ,'$this->eso08_codtipolotacao'
                               ,'$this->eso08_codtipoinscricao'
                               ,'$this->eso08_numeroinscricao'
                               ,$this->eso08_codfpas
                               ,'$this->eso08_codterceiros'
                               ,'$this->eso08_codterceiroscombinado'
                               ,'$this->eso08_codterceirosprocjudicial'
                               ,'$this->eso08_nroprocessojudicial'
                               ,'$this->eso08_codindicasuspensao'
                               ,'$this->eso08_tipoinscricaocontratante'
                               ,'$this->eso08_numeroinscricaocontratante'
                               ,'$this->eso08_tipoinscricaoproprietario'
                               ,'$this->eso08_nroinscricaoproprietario'
                               ,'$this->eso08_aliquotarat'
                               ,'$this->eso08_fatoracidentario'
                               ,$this->eso08_instit
                      )";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "eventos1020 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "eventos1020 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "eventos1020 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {
        }
        return true;
    }

    // funcao para alteracao
    function alterar($eso08_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update eventos1020 set ";
        $virgula = "";
        if (trim($this->eso08_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_sequencial"])) {
            $sql  .= $virgula . " eso08_sequencial = $this->eso08_sequencial ";
            $virgula = ",";
            if (trim($this->eso08_sequencial) == null) {
                $this->erro_sql = " Campo eso08_sequencial não informado.";
                $this->erro_campo = "eso08_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso08_codempregadorlotacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_codempregadorlotacao"])) {
            $sql  .= $virgula . " eso08_codempregadorlotacao = '$this->eso08_codempregadorlotacao' ";
            $virgula = ",";
            if (trim($this->eso08_codempregadorlotacao) == null) {
                $this->erro_sql = " Campo eso08_codempregadorlotacao não informado.";
                $this->erro_campo = "eso08_codempregadorlotacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso08_codtipolotacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_codtipolotacao"])) {
            $sql  .= $virgula . " eso08_codtipolotacao = '$this->eso08_codtipolotacao' ";
            $virgula = ",";
            if (trim($this->eso08_codtipolotacao) == null) {
                $this->erro_sql = " Campo eso08_codtipolotacao não informado.";
                $this->erro_campo = "eso08_codtipolotacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso08_codtipoinscricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_codtipoinscricao"])) {
            $sql  .= $virgula . " eso08_codtipoinscricao = '$this->eso08_codtipoinscricao' ";
            $virgula = ",";
            if (trim($this->eso08_codtipoinscricao) == null) {
                $this->erro_sql = " Campo eso08_codtipoinscricao não informado.";
                $this->erro_campo = "eso08_codtipoinscricao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso08_numeroinscricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_numeroinscricao"])) {
            $sql  .= $virgula . " eso08_numeroinscricao = '$this->eso08_numeroinscricao' ";
            $virgula = ",";
            if (trim($this->eso08_numeroinscricao) == null) {
                $this->erro_sql = " Campo eso08_numeroinscricao não informado.";
                $this->erro_campo = "eso08_numeroinscricao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso08_codfpas) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_codfpas"])) {
            $sql  .= $virgula . " eso08_codfpas = $this->eso08_codfpas ";
            $virgula = ",";
            if (trim($this->eso08_codfpas) == null) {
                $this->erro_sql = " Campo eso08_codfpas não informado.";
                $this->erro_campo = "eso08_codfpas";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso08_codterceiros) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_codterceiros"])) {
            $sql  .= $virgula . " eso08_codterceiros = '$this->eso08_codterceiros' ";
            $virgula = ",";
            if (trim($this->eso08_codterceiros) == null) {
                $this->erro_sql = " Campo eso08_codterceiros não informado.";
                $this->erro_campo = "eso08_codterceiros";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso08_codterceiroscombinado) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_codterceiroscombinado"])) {
            $sql  .= $virgula . " eso08_codterceiroscombinado = '$this->eso08_codterceiroscombinado' ";
            $virgula = ",";
        }
        if (trim($this->eso08_codterceirosprocjudicial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_codterceirosprocjudicial"])) {
            $sql  .= $virgula . " eso08_codterceirosprocjudicial = '$this->eso08_codterceirosprocjudicial' ";
            $virgula = ",";
        }
        if (trim($this->eso08_nroprocessojudicial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_nroprocessojudicial"])) {
            $sql  .= $virgula . " eso08_nroprocessojudicial = '$this->eso08_nroprocessojudicial' ";
            $virgula = ",";
        }
        if (trim($this->eso08_codindicasuspensao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_codindicasuspensao"])) {
            $sql  .= $virgula . " eso08_codindicasuspensao = '$this->eso08_codindicasuspensao' ";
            $virgula = ",";
        }
        if (trim($this->eso08_tipoinscricaocontratante) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_tipoinscricaocontratante"])) {
            $sql  .= $virgula . " eso08_tipoinscricaocontratante = '$this->eso08_tipoinscricaocontratante' ";
            $virgula = ",";
            if (trim($this->eso08_tipoinscricaocontratante) == null) {
                $this->erro_sql = " Campo eso08_tipoinscricaocontratante não informado.";
                $this->erro_campo = "eso08_tipoinscricaocontratante";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso08_numeroinscricaocontratante) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_numeroinscricaocontratante"])) {
            $sql  .= $virgula . " eso08_numeroinscricaocontratante = '$this->eso08_numeroinscricaocontratante' ";
            $virgula = ",";
        }
        if (trim($this->eso08_tipoinscricaoproprietario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_tipoinscricaoproprietario"])) {
            $sql  .= $virgula . " eso08_tipoinscricaoproprietario = '$this->eso08_tipoinscricaoproprietario' ";
            $virgula = ",";
            if (trim($this->eso08_tipoinscricaoproprietario) == null) {
                $this->erro_sql = " Campo eso08_tipoinscricaoproprietario não informado.";
                $this->erro_campo = "eso08_tipoinscricaoproprietario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso08_nroinscricaoproprietario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_nroinscricaoproprietario"])) {
            $sql  .= $virgula . " eso08_nroinscricaoproprietario = '$this->eso08_nroinscricaoproprietario' ";
            $virgula = ",";
        }
        if (trim($this->eso08_aliquotarat) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_aliquotarat"])) {
            $sql  .= $virgula . " eso08_aliquotarat = '$this->eso08_aliquotarat' ";
            $virgula = ",";
        }
        if (trim($this->eso08_fatoracidentario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_fatoracidentario"])) {
            $sql  .= $virgula . " eso08_fatoracidentario = '$this->eso08_fatoracidentario' ";
            $virgula = ",";
        }
        if (trim($this->eso08_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso08_instit"])) {
            $sql  .= $virgula . " eso08_instit = $this->eso08_instit ";
            $virgula = ",";
            if (trim($this->eso08_instit) == null) {
                $this->erro_sql = " Campo eso08_instit não informado.";
                $this->erro_campo = "eso08_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "eso08_sequencial = $this->eso08_sequencial";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "eventos1020 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "eventos1020 nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($eso08_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from eventos1020
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "eso08_sequencial = '$eso08_sequencial'";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "eventos1020 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "eventos1020 nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:eventos1020";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query($eso08_sequencial = null, $campos = "eventos1020.eso08_sequencial,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from eventos1020 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($eso08_sequencial != "" && $eso08_sequencial != null) {
                $sql2 = " where eventos1020.eso08_sequencial = '$eso08_sequencial'";
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
    function sql_query_file($eso08_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from eventos1020 ";
        $sql2 = "";
        if ($dbwhere == "") {
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
