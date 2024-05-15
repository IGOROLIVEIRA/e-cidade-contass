<?php
//MODULO: esocial
//CLASSE DA ENTIDADE eventos1005
class cl_eventos1005
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
    public $eso06_sequencial = 0;
    public $eso06_tipoinscricao = 'f';
    public $eso06_nroinscricaoobra = null;
    public $eso06_codcnaf = null;
    public $eso06_aliquotarat = null;
    public $eso06_fatoracidentario = null;
    public $eso06_codtipoprocessorat = 0;
    public $eso06_nroprocessos1070rat = null;
    public $eso06_codindicativosuspensaos1070rat = null;
    public $eso06_codtipoprocessofap = 0;
    public $eso06_nroprocessos1070fap = null;
    public $eso06_codindicativosuspensaos1070fap = null;
    public $eso06_tipocaepf = 0;
    public $eso06_subscontribuicaoobra = 0;
    public $eso06_nroprocessojudicia = 0;
    public $eso06_nroinscricaoenteducativa = 0;
    public $eso06_nroprocessocontratacaodeficiencia = 0;
    public $eso06_instit = 0;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 eso06_sequencial = int8 = Sequencial
                 eso06_tipoinscricao = bool = eso06_tipoinscricao
                 eso06_nroinscricaoobra = varchar(14) = eso06_nroinscricaoobra
                 eso06_codcnaf = varchar(7) = eso06_codcnaf
                 eso06_aliquotarat = varchar(1) = eso06_aliquotarat
                 eso06_fatoracidentario = varchar(5) = eso06_fatoracidentario
                 eso06_codtipoprocessorat = int4 = eso06_codtipoprocessorat
                 eso06_nroprocessos1070rat = int8 = eso06_nroprocessos1070rat
                 eso06_codindicativosuspensaos1070rat = int8 = eso06_codindicativosuspensaos1070rat
                 eso06_codtipoprocessofap = int4 = eso06_codtipoprocessofap
                 eso06_nroprocessos1070fap = int8 = eso06_nroprocessos1070fap
                 eso06_codindicativosuspensaos1070fap = int8 = eso06_codindicativosuspensaos1070fap
                 eso06_tipocaepf = int4 = eso06_tipocaepf
                 eso06_subscontribuicaoobra = int4 = eso06_subscontribuicaoobra
                 eso06_nroprocessojudicia = int8 = eso06_nroprocessojudicia
                 eso06_nroinscricaoenteducativa = int8 = eso06_nroinscricaoenteducativa
                 eso06_nroprocessocontratacaodeficiencia = int8 = eso06_nroprocessocontratacaodeficiencia
                 eso06_instit = int4 = eso06_instit
                 ";

    //funcao construtor da classe
    function __construct()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("eventos1005");
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
            $this->eso06_sequencial = ($this->eso06_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_sequencial"] : $this->eso06_sequencial);
            $this->eso06_tipoinscricao = ($this->eso06_tipoinscricao == "f" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_tipoinscricao"] : $this->eso06_tipoinscricao);
            $this->eso06_nroinscricaoobra = ($this->eso06_nroinscricaoobra == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_nroinscricaoobra"] : $this->eso06_nroinscricaoobra);
            $this->eso06_codcnaf = ($this->eso06_codcnaf == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_codcnaf"] : $this->eso06_codcnaf);
            $this->eso06_aliquotarat = ($this->eso06_aliquotarat == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_aliquotarat"] : $this->eso06_aliquotarat);
            $this->eso06_fatoracidentario = ($this->eso06_fatoracidentario == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_fatoracidentario"] : $this->eso06_fatoracidentario);
            $this->eso06_codtipoprocessorat = ($this->eso06_codtipoprocessorat == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_codtipoprocessorat"] : $this->eso06_codtipoprocessorat);
            $this->eso06_nroprocessos1070rat = ($this->eso06_nroprocessos1070rat == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_nroprocessos1070rat"] : $this->eso06_nroprocessos1070rat);
            $this->eso06_codindicativosuspensaos1070rat = ($this->eso06_codindicativosuspensaos1070rat == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_codindicativosuspensaos1070rat"] : $this->eso06_codindicativosuspensaos1070rat);
            $this->eso06_codtipoprocessofap = ($this->eso06_codtipoprocessofap == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_codtipoprocessofap"] : $this->eso06_codtipoprocessofap);
            $this->eso06_nroprocessos1070fap = ($this->eso06_nroprocessos1070fap == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_nroprocessos1070fap"] : $this->eso06_nroprocessos1070fap);
            $this->eso06_codindicativosuspensaos1070fap = ($this->eso06_codindicativosuspensaos1070fap == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_codindicativosuspensaos1070fap"] : $this->eso06_codindicativosuspensaos1070fap);
            $this->eso06_tipocaepf = ($this->eso06_tipocaepf == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_tipocaepf"] : $this->eso06_tipocaepf);
            $this->eso06_subscontribuicaoobra = ($this->eso06_subscontribuicaoobra == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_subscontribuicaoobra"] : $this->eso06_subscontribuicaoobra);
            $this->eso06_nroprocessojudicia = ($this->eso06_nroprocessojudicia == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_nroprocessojudicia"] : $this->eso06_nroprocessojudicia);
            $this->eso06_nroinscricaoenteducativa = ($this->eso06_nroinscricaoenteducativa == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_nroinscricaoenteducativa"] : $this->eso06_nroinscricaoenteducativa);
            $this->eso06_nroprocessocontratacaodeficiencia = ($this->eso06_nroprocessocontratacaodeficiencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_nroprocessocontratacaodeficiencia"] : $this->eso06_nroprocessocontratacaodeficiencia);
            $this->eso06_instit = ($this->eso06_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["eso06_instit"] : $this->eso06_instit);
        }
    }

    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();
        if ($this->eso06_sequencial == null) {
            $result = db_query("select nextval('eventos1005_eso06_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: eventos1005_eso06_sequencial_seq do campo: eso06_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->eso06_sequencial = pg_result($result, 0, 0);
        }
        if ($this->eso06_tipoinscricao == null) {
            $this->erro_sql = " Campo eso06_tipoinscricao não informado.";
            $this->erro_campo = "eso06_tipoinscricao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso06_nroinscricaoobra == null) {
            $this->erro_sql = " Campo eso06_nroinscricaoobra não informado.";
            $this->erro_campo = "eso06_nroinscricaoobra";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso06_codcnaf == null) {
            $this->erro_sql = " Campo eso06_codcnaf não informado.";
            $this->erro_campo = "eso06_codcnaf";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso06_aliquotarat == "") {
            $this->eso06_aliquotarat = "";
        }
        if ($this->eso06_fatoracidentario == "") {
            $this->eso06_fatoracidentario = null;
        }
        if ($this->eso06_codtipoprocessorat == "") {
            $this->eso06_codtipoprocessorat = "null";
        }
        if ($this->eso06_nroprocessos1070rat == "") {
            $this->eso06_nroprocessos1070rat = "";
        }
        if ($this->eso06_codindicativosuspensaos1070rat == "") {
            $this->eso06_codindicativosuspensaos1070rat = "";
        }
        if ($this->eso06_codtipoprocessofap == "") {
            $this->eso06_codtipoprocessofap = "null";
        }
        if ($this->eso06_nroprocessos1070fap == "") {
            $this->eso06_nroprocessos1070fap = "";
        }
        if ($this->eso06_codindicativosuspensaos1070fap == "") {
            $this->eso06_codindicativosuspensaos1070fap = "";
        }
        if ($this->eso06_tipocaepf == "") {
            $this->eso06_tipocaepf = "null";
        }
        if ($this->eso06_subscontribuicaoobra == "") {
            $this->eso06_subscontribuicaoobra = "null";
        }
        if ($this->eso06_nroprocessojudicia == "") {
            $this->eso06_nroprocessojudicia = "null";
        }
        if ($this->eso06_nroinscricaoenteducativa == "") {
            $this->eso06_nroinscricaoenteducativa = "null";
        }
        if ($this->eso06_nroprocessocontratacaodeficiencia == "") {
            $this->eso06_nroprocessocontratacaodeficiencia = "null";
        }
        if ($this->eso06_instit == null) {
            $this->erro_sql = " Campo eso06_instit não informado.";
            $this->erro_campo = "eso06_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into eventos1005(
                                       eso06_sequencial
                                      ,eso06_tipoinscricao
                                      ,eso06_nroinscricaoobra
                                      ,eso06_codcnaf
                                      ,eso06_aliquotarat
                                      ,eso06_fatoracidentario
                                      ,eso06_codtipoprocessorat
                                      ,eso06_nroprocessos1070rat
                                      ,eso06_codindicativosuspensaos1070rat
                                      ,eso06_codtipoprocessofap
                                      ,eso06_nroprocessos1070fap
                                      ,eso06_codindicativosuspensaos1070fap
                                      ,eso06_tipocaepf
                                      ,eso06_subscontribuicaoobra
                                      ,eso06_nroprocessojudicia
                                      ,eso06_nroinscricaoenteducativa
                                      ,eso06_nroprocessocontratacaodeficiencia
                                      ,eso06_instit
                       )
                values (
                                $this->eso06_sequencial
                               ,'$this->eso06_tipoinscricao'
                               ,'$this->eso06_nroinscricaoobra'
                               ,'$this->eso06_codcnaf'
                               ,'$this->eso06_aliquotarat'
                               ,'$this->eso06_fatoracidentario'
                               ,$this->eso06_codtipoprocessorat
                               ,'$this->eso06_nroprocessos1070rat'
                               ,'$this->eso06_codindicativosuspensaos1070rat'
                               ,'$this->eso06_codtipoprocessofap'
                               ,'$this->eso06_nroprocessos1070fap'
                               ,'$this->eso06_codindicativosuspensaos1070fap'
                               ,$this->eso06_tipocaepf
                               ,$this->eso06_subscontribuicaoobra
                               ,'$this->eso06_nroprocessojudicia'
                               ,'$this->eso06_nroinscricaoenteducativa'
                               ,'$this->eso06_nroprocessocontratacaodeficiencia'
                               ,$this->eso06_instit
                      )";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "eventos1005 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "eventos1005 já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "eventos1005 () nao Incluído. Inclusao Abortada.";
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
    function alterar($eso06_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update eventos1005 set ";
        $virgula = "";
        if (trim($this->eso06_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_sequencial"])) {
            $sql  .= $virgula . " eso06_sequencial = $this->eso06_sequencial ";
            $virgula = ",";
            if (trim($this->eso06_sequencial) == null) {
                $this->erro_sql = " Campo Sequencial não informado.";
                $this->erro_campo = "eso06_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso06_tipoinscricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_tipoinscricao"])) {
            $sql  .= $virgula . " eso06_tipoinscricao = '$this->eso06_tipoinscricao' ";
            $virgula = ",";
            if (trim($this->eso06_tipoinscricao) == null) {
                $this->erro_sql = " Campo eso06_tipoinscricao não informado.";
                $this->erro_campo = "eso06_tipoinscricao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso06_nroinscricaoobra) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_nroinscricaoobra"])) {
            $sql  .= $virgula . " eso06_nroinscricaoobra = '$this->eso06_nroinscricaoobra' ";
            $virgula = ",";
            if (trim($this->eso06_nroinscricaoobra) == null) {
                $this->erro_sql = " Campo eso06_nroinscricaoobra não informado.";
                $this->erro_campo = "eso06_nroinscricaoobra";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso06_codcnaf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_codcnaf"])) {
            $sql  .= $virgula . " eso06_codcnaf = '$this->eso06_codcnaf' ";
            $virgula = ",";
            if (trim($this->eso06_codcnaf) == null) {
                $this->erro_sql = " Campo eso06_codcnaf não informado.";
                $this->erro_campo = "eso06_codcnaf";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso06_aliquotarat) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_aliquotarat"])) {
            $sql  .= $virgula . " eso06_aliquotarat = '$this->eso06_aliquotarat' ";
            $virgula = ",";
            if (trim($this->eso06_aliquotarat) == null) {
                $this->eso06_aliquotarat = "null";
            }
        }
        if (trim($this->eso06_fatoracidentario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_fatoracidentario"])) {
            $sql  .= $virgula . " eso06_fatoracidentario = '$this->eso06_fatoracidentario' ";
            $virgula = ",";
            if (trim($this->eso06_fatoracidentario) == null) {
                $this->eso06_fatoracidentario = "null";
            }
        }
        if (trim($this->eso06_codtipoprocessorat) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_codtipoprocessorat"])) {
            $sql  .= $virgula . " eso06_codtipoprocessorat = $this->eso06_codtipoprocessorat ";
            $virgula = ",";
            if (trim($this->eso06_codtipoprocessorat) == null) {
                $this->eso06_codtipoprocessorat = "null";
            }
        }
        if (trim($this->eso06_nroprocessos1070rat) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_nroprocessos1070rat"])) {
            $sql  .= $virgula . " eso06_nroprocessos1070rat = '$this->eso06_nroprocessos1070rat' ";
            $virgula = ",";
            if (trim($this->eso06_nroprocessos1070rat) == null) {
                $this->eso06_nroprocessos1070rat = "null";
            }
        }
        if (trim($this->eso06_codindicativosuspensaos1070rat) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_codindicativosuspensaos1070rat"])) {
            $sql  .= $virgula . " eso06_codindicativosuspensaos1070rat = '$this->eso06_codindicativosuspensaos1070rat' ";
            $virgula = ",";
            if (trim($this->eso06_codindicativosuspensaos1070rat) == null) {
                $this->eso06_codindicativosuspensaos1070rat = "null";
            }
        }
        if (trim($this->eso06_codtipoprocessofap) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_codtipoprocessofap"])) {
            $sql  .= $virgula . " eso06_codtipoprocessofap = $this->eso06_codtipoprocessofap ";
            $virgula = ",";
            if (trim($this->eso06_codtipoprocessofap) == null) {
                $this->eso06_codtipoprocessofap = "null";
            }
        }
        if (trim($this->eso06_nroprocessos1070fap) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_nroprocessos1070fap"])) {
            $sql  .= $virgula . " eso06_nroprocessos1070fap = '$this->eso06_nroprocessos1070fap' ";
            $virgula = ",";
            if (trim($this->eso06_nroprocessos1070fap) == null) {
                $this->eso06_nroprocessos1070fap = "null";
            }
        }
        if (trim($this->eso06_codindicativosuspensaos1070fap) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_codindicativosuspensaos1070fap"])) {
            $sql  .= $virgula . " eso06_codindicativosuspensaos1070fap = '$this->eso06_codindicativosuspensaos1070fap' ";
            $virgula = ",";
            if (trim($this->eso06_codindicativosuspensaos1070fap) == null) {
                $this->eso06_codindicativosuspensaos1070fap = "null";
            }
        }
        if (trim($this->eso06_tipocaepf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_tipocaepf"])) {
            $sql  .= $virgula . " eso06_tipocaepf = $this->eso06_tipocaepf ";
            $virgula = ",";
            if (trim($this->eso06_tipocaepf) == null) {
                $this->eso06_tipocaepf = "null";
            }
        }
        if (trim($this->eso06_subscontribuicaoobra) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_subscontribuicaoobra"])) {
            $sql  .= $virgula . " eso06_subscontribuicaoobra = $this->eso06_subscontribuicaoobra ";
            $virgula = ",";
            if (trim($this->eso06_subscontribuicaoobra) == null) {
                $this->eso06_subscontribuicaoobra = "null";
            }
        }
        if (trim($this->eso06_nroprocessojudicia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_nroprocessojudicia"])) {
            $sql  .= $virgula . " eso06_nroprocessojudicia = '$this->eso06_nroprocessojudicia' ";
            $virgula = ",";
            if (trim($this->eso06_nroprocessojudicia) == null) {
                $this->eso06_nroprocessojudicia = "null";
            }
        }
        if (trim($this->eso06_nroinscricaoenteducativa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_nroinscricaoenteducativa"])) {
            $sql  .= $virgula . " eso06_nroinscricaoenteducativa = '$this->eso06_nroinscricaoenteducativa' ";
            $virgula = ",";
            if (trim($this->eso06_nroinscricaoenteducativa) == null) {
                $this->eso06_nroinscricaoenteducativa = "null";
            }
        }
        if (trim($this->eso06_nroprocessocontratacaodeficiencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_nroprocessocontratacaodeficiencia"])) {
            $sql  .= $virgula . " eso06_nroprocessocontratacaodeficiencia = '$this->eso06_nroprocessocontratacaodeficiencia' ";
            $virgula = ",";
            if (trim($this->eso06_nroprocessocontratacaodeficiencia) == null) {
                $this->eso06_nroprocessocontratacaodeficiencia = "null";
            }
        }
        if (trim($this->eso06_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["eso06_instit"])) {
            $sql  .= $virgula . " eso06_instit = $this->eso06_instit ";
            $virgula = ",";
            if (trim($this->eso06_instit) == null) {
                $this->erro_sql = " Campo eso06_instit não informado.";
                $this->erro_campo = "eso06_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        $sql .= "eso06_sequencial = $this->eso06_sequencial";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "eventos1005 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "eventos1005 nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir($eso06_sequencial = null, $dbwhere = null)
    {

        $sql = " delete from eventos1005
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            $sql2 = "eso06_sequencial = '$eso06_sequencial'";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "eventos1005 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "eventos1005 nao Encontrado. Exclusão não Efetuada.\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:eventos1005";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query($eso06_sequencial = null, $campos = "eventos1005.eso06_sequencial,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from eventos1005 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($eso06_sequencial != "" && $eso06_sequencial != null) {
                $sql2 = " where eventos1005.eso06_sequencial = '$eso06_sequencial'";
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
    function sql_query_file($eso06_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from eventos1005 ";
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
