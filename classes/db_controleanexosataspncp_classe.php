<?
//MODULO: acordos
//CLASSE DA ENTIDADE controleanexosataspncp
class cl_controleanexosataspncp
{
    // cria variaveis de erro
    var $rotulo     = null;
    var $query_sql  = null;
    var $numrows    = 0;
    var $erro_status = null;
    var $erro_sql   = null;
    var $erro_banco = null;
    var $erro_msg   = null;
    var $erro_campo = null;
    var $pagina_retorno = null;
    // cria variaveis do arquivo
    var $l217_sequencial = 0;
    var $l217_licanexoataspncp = 0;
    var $l217_usuario = 0;
    var $l217_dataenvio_dia = null;
    var $l217_dataenvio_mes = null;
    var $l217_dataenvio_ano = null;
    var $l217_dataenvio = null;
    var $l217_sequencialata = null;
    var $l217_tipoanexo = null;
    var $l217_instit = 0;
    var $l217_anocompra = 0;
    var $l217_sequencialpncp = 0;
    var $l217_sequencialarquivo = 0;

    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 l217_sequencial = int8 = Sequencial Anexos
                 l217_licanexoataspncp = int8 = Código da licitacao
                 l217_usuario = int8 = Código do Usuário
                 l217_dataenvio = date = Data Lançamento
                 l217_sequencialata = varchar(250) = Número de Controle Anexo PNCP
                 l217_tipoanexo = varchar(30) = Tipo de Anexo
                 l217_instit = int8 = Tipo de Instituição
                 l217_anocompra = int8 = Ano Empenho PNCP
                 l217_sequencialpncp = int8 = Sequencial PNCP
                 l217_sequencialarquivo = int8 = Sequencial Anexos PNCP
                 ";
    //funcao construtor da classe
    function cl_controleanexosataspncp()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("controleanexosataspncp");
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
            $this->l217_sequencial = ($this->l217_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_sequencial"] : $this->l217_sequencial);
            $this->l217_licanexoataspncp = ($this->l217_licanexoataspncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_licanexoataspncp"] : $this->l217_licanexoataspncp);
            $this->l217_usuario = ($this->l217_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_usuario"] : $this->l217_usuario);
            if ($this->l217_dataenvio == "") {
                $this->l217_dataenvio_dia = @$GLOBALS["HTTP_POST_VARS"]["l217_dataenvio_dia"];
                $this->l217_dataenvio_mes = @$GLOBALS["HTTP_POST_VARS"]["l217_dataenvio_mes"];
                $this->l217_dataenvio_ano = @$GLOBALS["HTTP_POST_VARS"]["l217_dataenvio_ano"];
                if ($this->l217_dataenvio_dia != "") {
                    $this->l217_dataenvio = $this->l217_dataenvio_ano . "-" . $this->l217_dataenvio_mes . "-" . $this->l217_dataenvio_dia;
                }
            }
            $this->l217_sequencialata = ($this->l217_sequencialata == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_sequencialata"] : $this->l217_sequencialata);
            $this->l217_tipoanexo = ($this->l217_tipoanexo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_tipoanexo"] : $this->l217_tipoanexo);
            $this->l217_instit = ($this->l217_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_instit"] : $this->l217_instit);
            $this->l217_anocompra = ($this->l217_anocompra == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_anocompra"] : $this->l217_anocompra);
            $this->l217_sequencialpncp = ($this->l217_sequencialpncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_sequencialpncp"] : $this->l217_sequencialpncp);
            $this->l217_sequencialarquivo = ($this->l217_sequencialarquivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l217_sequencialarquivo"] : $this->l217_sequencialarquivo);
        }
    }
    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();
        if ($this->l217_licanexoataspncp == null) {
            $this->l217_licanexoataspncp = "NULL";
        }

        if ($this->l217_usuario == null) {
            $this->erro_sql = " Campo Código do Usuário nao Informado.";
            $this->erro_campo = "l217_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_dataenvio == null) {
            $this->erro_sql = " Campo Data Lançamento nao Informado.";
            $this->erro_campo = "l217_dataenvio_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_sequencialata == null) {
            $this->erro_sql = " Campo Número de Controle Anexo PNCP nao Informado.";
            $this->erro_campo = "l217_sequencialata";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_tipoanexo == null) {
            $this->erro_sql = " Campo Tipo de Anexo nao Informado.";
            $this->erro_campo = "l217_tipoanexo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_instit == null) {
            $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
            $this->erro_campo = "l217_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_anocompra == null) {
            $this->erro_sql = " Campo Ano PNCP nao Informado.";
            $this->erro_campo = "l217_anocompra";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_sequencialpncp == null) {
            $this->erro_sql = " Campo Sequencial PNCP nao Informado.";
            $this->erro_campo = "l217_sequencialpncp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_sequencialarquivo == null) {
            $this->erro_sql = " Campo Sequencial Anexos PNCP nao Informado.";
            $this->erro_campo = "l217_sequencialarquivo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->l217_sequencial == "" || $this->l217_sequencial == null) {
            $result = db_query("select nextval('controleanexosataspncp_l217_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: controleanexosataspncp_l217_sequencial_seq do campo: l217_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l217_sequencial = pg_result($result, 0, 0);
        }

        $sql = "insert into controleanexosataspncp(
                                       l217_sequencial
                                      ,l217_licanexoataspncp
                                      ,l217_usuario
                                      ,l217_dataenvio
                                      ,l217_sequencialata
                                      ,l217_tipoanexo
                                      ,l217_instit
                                      ,l217_anocompra
                                      ,l217_sequencialpncp
                                      ,l217_sequencialarquivo
                       )
                values (
                                $this->l217_sequencial
                               ,$this->l217_licanexoataspncp
                               ,$this->l217_usuario
                               ," . ($this->l217_dataenvio == "null" || $this->l217_dataenvio == "" ? "null" : "'" . $this->l217_dataenvio . "'") . "
                               ,$this->l217_sequencialata
                               ,$this->l217_tipoanexo
                               ,$this->l217_instit
                               ,$this->l217_anocompra
                               ,$this->l217_sequencialpncp
                               ,$this->l217_sequencialarquivo
                               )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = " () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = " já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = " () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
    }
    // funcao para alteracao
    function alterar($l217_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update controleanexosataspncp set ";
        $virgula = "";
        if (trim($this->l217_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_sequencial"])) {
            if (trim($this->l217_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l217_sequencial"])) {
                $this->l217_sequencial = "0";
            }
            $sql  .= $virgula . " l217_sequencial = $this->l217_sequencial ";
            $virgula = ",";
            if (trim($this->l217_sequencial) == null) {
                $this->erro_sql = " Campo Sequencial Anexos nao Informado.";
                $this->erro_campo = "l217_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_licanexoataspncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_licanexoataspncp"])) {
            if (trim($this->l217_licanexoataspncp) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l217_licanexoataspncp"])) {
                $this->l217_licanexoataspncp = "0";
            }
            $sql  .= $virgula . " l217_licanexoataspncp = $this->l217_licanexoataspncp ";
            $virgula = ",";
            if (trim($this->l217_licanexoataspncp) == null) {
                $this->erro_sql = " Campo Código do Acordo nao Informado.";
                $this->erro_campo = "l217_licanexoataspncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_usuario"])) {
            if (trim($this->l217_usuario) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l217_usuario"])) {
                $this->l217_usuario = "0";
            }
            $sql  .= $virgula . " l217_usuario = $this->l217_usuario ";
            $virgula = ",";
            if (trim($this->l217_usuario) == null) {
                $this->erro_sql = " Campo Código do Usuário nao Informado.";
                $this->erro_campo = "l217_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_dataenvio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_dataenvio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l217_dataenvio_dia"] != "")) {
            $sql  .= $virgula . " l217_dataenvio = '$this->l217_dataenvio' ";
            $virgula = ",";
            if (trim($this->l217_dataenvio) == null) {
                $this->erro_sql = " Campo Data Lançamento nao Informado.";
                $this->erro_campo = "l217_dataenvio_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["l217_dataenvio_dia"])) {
                $sql  .= $virgula . " l217_dataenvio = null ";
                $virgula = ",";
                if (trim($this->l217_dataenvio) == null) {
                    $this->erro_sql = " Campo Data Lançamento nao Informado.";
                    $this->erro_campo = "l217_dataenvio_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if (trim($this->l217_sequencialata) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_sequencialata"])) {
            $sql  .= $virgula . " l217_sequencialata = '$this->l217_sequencialata' ";
            $virgula = ",";
            if (trim($this->l217_sequencialata) == null) {
                $this->erro_sql = " Campo Número de Controle Anexo PNCP nao Informado.";
                $this->erro_campo = "l217_sequencialata";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_tipoanexo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_tipoanexo"])) {
            $sql  .= $virgula . " l217_tipoanexo = '$this->l217_tipoanexo' ";
            $virgula = ",";
            if (trim($this->l217_tipoanexo) == null) {
                $this->erro_sql = " Campo Tipo de Anexo nao Informado.";
                $this->erro_campo = "l217_tipoanexo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_instit"])) {
            if (trim($this->l217_instit) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l217_instit"])) {
                $this->l217_instit = "0";
            }
            $sql  .= $virgula . " l217_instit = $this->l217_instit ";
            $virgula = ",";
            if (trim($this->l217_instit) == null) {
                $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
                $this->erro_campo = "l217_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_anocompra) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_anocompra"])) {
            if (trim($this->l217_anocompra) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l217_anocompra"])) {
                $this->l217_anocompra = "0";
            }
            $sql  .= $virgula . " l217_anocompra = $this->l217_anocompra ";
            $virgula = ",";
            if (trim($this->l217_anocompra) == null) {
                $this->erro_sql = " Campo Ano Empenho PNCP nao Informado.";
                $this->erro_campo = "l217_anocompra";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_sequencialpncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_sequencialpncp"])) {
            if (trim($this->l217_sequencialpncp) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l217_sequencialpncp"])) {
                $this->l217_sequencialpncp = "0";
            }
            $sql  .= $virgula . " l217_sequencialpncp = $this->l217_sequencialpncp ";
            $virgula = ",";
            if (trim($this->l217_sequencialpncp) == null) {
                $this->erro_sql = " Campo Sequencial PNCP nao Informado.";
                $this->erro_campo = "l217_sequencialpncp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->l217_sequencialarquivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l217_sequencialarquivo"])) {
            if (trim($this->l217_sequencialarquivo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["l217_sequencialarquivo"])) {
                $this->l217_sequencialarquivo = "0";
            }
            $sql  .= $virgula . " l217_sequencialarquivo = $this->l217_sequencialarquivo ";
            $virgula = ",";
            if (trim($this->l217_sequencialarquivo) == null) {
                $this->erro_sql = " Campo Sequencial Anexos PNCP nao Informado.";
                $this->erro_campo = "l217_sequencialarquivo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where l217_sequencial = $l217_sequencial ";
        $result = @pg_exec($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir($l217_sequencial = null)
    {
        $this->atualizacampos(true);
        $sql = " delete from controleanexosataspncp
                    where ";
        $sql2 = "";
        $sql2 = "l217_sequencial = $l217_sequencial";
        //  echo $sql.$sql2;
        $result = @pg_exec($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir_licitacao($l217_licanexoataspncp = null)
    {
        $this->atualizacampos(true);
        $sql = " delete from controleanexosataspncp
                    where ";
        $sql2 = "";
        $sql2 = "l217_licanexoataspncp = $l217_licanexoataspncp";
        //  echo $sql.$sql2;
        $result = @pg_exec($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                return true;
            }
        }
    }

    // funcao do recordset
    function sql_record($sql)
    {
        $result = @pg_query($sql);
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
            $this->erro_sql   = "Dados do Grupo nao Encontrado";
            $this->erro_msg   = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql
    function sql_query($l217_sequencial = null, $campos = "controleanexosataspncp.l217_sequencial,*", $ordem = null, $dbwhere = "")
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
        $sql .= " from controleanexosataspncp ";
        $sql .= " left join acocontroletermospncp on l214_acordo = l217_licanexoataspncp ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($l217_sequencial != "" && $l217_sequencial != null) {
                $sql2 = " where controleanexosataspncp.l217_sequencial = $l217_sequencial";
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
    function sql_query_file($l217_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from controleanexosataspncp ";
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
