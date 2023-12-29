<?
//MODULO: empenho
//CLASSE DA ENTIDADE empefdreinf
class cl_empefdreinf
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
    var $efd60_sequencial = 0;
    var $efd60_numemp = 0;
    var $efd60_codemp = null;
    var $efd60_anousu = 0;
    var $efd60_cessaomaoobra = null;
    var $efd60_aquisicaoprodrural = null;
    var $efd60_instit = 0;
    var $efd60_possuicno = null;
    var $efd60_numcno = null;
    var $efd60_indprestservico = null;
    var $efd60_prescontricprb = null;
    var $efd60_tiposervico = null;
    var $efd60_prodoptacp  = null;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 efd60_numemp = int4 = Número
                 efd60_codemp = varchar(15) = Empenho
                 efd60_anousu = int4 = Exercício
                 efd60_cessaomaoobra = int8 = Cessão de mão de obra/empreitada
                 efd60_aquisicaoprodrural = int8 = Aquisição de Produção Rural
                 efd60_instit = int4 = codigo da instituicao
                 efd60_possuicno = int8 = Possui Cadastro Nacional de Obras (CNO)
                 efd60_numcno = varchar(12) = Número do CNO
                 efd60_indprestservico = int8 = Indicativo de Prestação de Serviços em Obra de Construção Civil
                 efd60_prescontricprb = int8 = Prestador é contribuinte da CPRB
                 efd60_tiposervico = int8 = Tipo de Serviço
                 efd60_prodoptacp  = int8 =  O Produtor Rural opta pela CP sobre a folha
                 ";
    //funcao construtor da classe
    function cl_empefdreinf()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("empefdreinf");
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
            $this->efd60_numemp = ($this->efd60_numemp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_numemp"] : $this->efd60_numemp);
            $this->efd60_codemp = ($this->efd60_codemp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_codemp"] : $this->efd60_codemp);
            $this->efd60_anousu = ($this->efd60_anousu == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_anousu"] : $this->efd60_anousu);
            $this->efd60_cessaomaoobra = ($this->efd60_cessaomaoobra == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_cessaomaoobra"] : $this->efd60_cessaomaoobra);
            $this->efd60_aquisicaoprodrural = ($this->efd60_aquisicaoprodrural == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_aquisicaoprodrural"] : $this->efd60_aquisicaoprodrural);
            $this->efd60_instit = ($this->efd60_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_instit"] : $this->efd60_instit);
            $this->efd60_possuicno = ($this->efd60_possuicno == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_possuicno"] : $this->efd60_possuicno);
            $this->efd60_numcno = ($this->efd60_numcno == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_numcno"] : $this->efd60_numcno);
            $this->efd60_indprestservico = ($this->efd60_indprestservico == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_indprestservico"] : $this->efd60_indprestservico);
            $this->efd60_prescontricprb = ($this->efd60_prescontricprb == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_prescontricprb"] : $this->efd60_prescontricprb);
            $this->efd60_tiposervico = ($this->efd60_tiposervico == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_tiposervico"] : $this->efd60_tiposervico);
            $this->efd60_prodoptacp = ($this->efd60_prodoptacp == "" ? @$GLOBALS["HTTP_POST_VARS"]["efd60_prodoptacp"] : $this->efd60_prodoptacp);
        } 
    } 
    // funcao para inclusao
    function incluir($efd60_numemp)
    {
        $this->atualizacampos();
        if ($this->efd60_codemp == null) {
            $this->erro_sql = " Campo Empenho nao Informado.";
            $this->erro_campo = "efd60_codemp";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->efd60_sequencial == "" || $this->efd60_sequencial == null ){
            $result = db_query("select nextval('empefdreinf_efd60_sequencial_seq')");
            if($result==false){
              $this->erro_banco = str_replace("\n","",@pg_last_error());
              $this->erro_sql   = "Verifique o cadastro da sequencia: empefdreinf_efd60_sequencial_seq do campo: efd60_sequencial";
              $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
              $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
              $this->erro_status = "0";
              return false;
            }
            $this->efd60_sequencial = pg_result($result,0,0);
          }else{
            $result = db_query("select last_value from empefdreinf_efd60_sequencial_seq");
            if(($result != false) && (pg_result($result,0,0) < $this->efd60_sequencial)){
              $this->erro_sql = " Campo efd60_sequencial maior que último número da sequencia.";
              $this->erro_banco = "Sequencia menor que este número.";
              $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
              $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
              $this->erro_status = "0";
              return false;
            }
          }
        if ($this->efd60_anousu == null) {
            $this->erro_sql = " Campo Exercício nao Informado.";
            $this->erro_campo = "efd60_anousu";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd60_numemp == "" || $this->efd60_numemp == null) {
            $this->efd60_numemp = $efd60_numemp;
        }
        if (($this->efd60_numemp == null) || ($this->efd60_numemp == "")) {
            $this->erro_sql = " Campo efd60_numemp nao declarado.";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd60_instit == null) {
            $this->erro_sql = " Campo codigo da instituicao nao Informado.";
            $this->erro_campo = "efd60_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->efd60_cessaomaoobra == null) {
            $this->efd60_cessaomaoobra = 'null';
        }
        if ($this->efd60_possuicno == null) {
            $this->efd60_possuicno = 'null';
        }
        if ($this->efd60_indprestservico == null) {
            $this->efd60_indprestservico = 'null';
        }
        if ($this->efd60_prescontricprb == null) {
            $this->efd60_prescontricprb = 'null';
        }
        if ($this->efd60_prodoptacp == null) {
            $this->efd60_prodoptacp = 'null';
        }
        if ($this->efd60_aquisicaoprodrural == null) {
            $this->efd60_aquisicaoprodrural = 'null';
        }
        if ($this->efd60_tiposervico == null) {
            $this->efd60_tiposervico = 'null';
        }

        $sql = "insert into empefdreinf(
                                       efd60_sequencial
                                      ,efd60_numemp
                                      ,efd60_codemp
                                      ,efd60_anousu
                                      ,efd60_cessaomaoobra
                                      ,efd60_aquisicaoprodrural
                                      ,efd60_instit
                                      ,efd60_possuicno
                                      ,efd60_numcno
                                      ,efd60_indprestservico
                                      ,efd60_prescontricprb
                                      ,efd60_tiposervico
                                      ,efd60_prodoptacp
                       )
                values (
                                $this->efd60_sequencial
                               ,$this->efd60_numemp
                               ,'$this->efd60_codemp'
                               ,$this->efd60_anousu
                               ,$this->efd60_cessaomaoobra
                               ,$this->efd60_aquisicaoprodrural
                               ,$this->efd60_instit
                               ,$this->efd60_possuicno
                               ,'$this->efd60_numcno'
                               ,$this->efd60_indprestservico
                               ,$this->efd60_prescontricprb
                               ,$this->efd60_tiposervico
                               ,$this->efd60_prodoptacp
                      )"; 
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "Empenhos para EFD-REINF nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "Empenhos para EFD-REINF já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "Empenhos para EFD-REINF nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->efd60_numemp;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }
    // funcao para alteracao
    function alterar($efd60_numemp = null)
    {
        $this->atualizacampos();
        $sql = " update empefdreinf set ";
        $virgula = "";
        if (trim($this->efd60_cessaomaoobra) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd60_cessaomaoobra"])) {
            $sql  .= $virgula . " efd60_cessaomaoobra = " . ($this->efd60_cessaomaoobra == '' ? 'null' : $this->efd60_cessaomaoobra);
            $virgula = ",";
        }
        if (trim($this->efd60_aquisicaoprodrural) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd60_aquisicaoprodrural"])) {
            $sql  .= $virgula . " efd60_aquisicaoprodrural = " . ($this->efd60_aquisicaoprodrural == '' ? 'null' : $this->efd60_aquisicaoprodrural);
            $virgula = ",";
        }
        if (trim($this->efd60_possuicno) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd60_possuicno"])) {
            $sql  .= $virgula . " efd60_possuicno = " . ($this->efd60_possuicno == '' ? 'null' : $this->efd60_possuicno);
            $virgula = ",";
        }
        if (trim($this->efd60_numcno) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd60_numcno"])) {
            $sql  .= $virgula . " efd60_numcno = " . ($this->efd60_numcno == '' ? 'null' : "'$this->efd60_numcno'");
            $virgula = ",";
        }
        if (trim($this->efd60_indprestservico) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd60_indprestservico"])) {
            $sql  .= $virgula . " efd60_indprestservico = " . ($this->efd60_indprestservico == '' ? 'null' : $this->efd60_indprestservico);
            $virgula = ",";
        }
        if (trim($this->efd60_prescontricprb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd60_prescontricprb"])) {
            $sql  .= $virgula . " efd60_prescontricprb = " . ($this->efd60_prescontricprb == '' ? 'null' : $this->efd60_prescontricprb);
            $virgula = ",";
        }
        if (trim($this->efd60_tiposervico) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd60_tiposervico"])) {
            $sql  .= $virgula . " efd60_tiposervico = " . ($this->efd60_tiposervico == '' ? 'null' : $this->efd60_tiposervico);
            $virgula = ",";
        }
        if (trim($this->efd60_prodoptacp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["efd60_prodoptacp"])) {
            $sql  .= $virgula . " efd60_prodoptacp = " . ($this->efd60_prodoptacp == '' ? 'null' : $this->efd60_prodoptacp);
            $virgula = ",";
        }        
        $sql .= " where ";
        if ($efd60_numemp != null) {
            $sql .= " efd60_numemp = $efd60_numemp";
        } 
    
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = "";
            $this->erro_sql   = "Empenhos para EFD-REINF nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $efd60_numemp;
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Empenhos para EFD-REINF nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->efd60_numemp;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->efd60_numemp;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir($efd60_numemp = null, $dbwhere = null)
    {
        if ($dbwhere == null || $dbwhere == "") {
            $resaco = $this->sql_record($this->sql_query_file($efd60_numemp));
        } else {
            $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
        }
        if (($resaco != false) || ($this->numrows != 0)) {
            for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac, 0, 0);
                $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
                $resac = db_query("insert into db_acountkey values($acount,5594,'$efd60_numemp','E')");
                $resac = db_query("insert into db_acount values($acount,889,5594,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_numemp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5595,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_codemp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5596,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_anousu')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5597,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_coddot')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5598,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_numcgm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5599,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_emiss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5600,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_vencim')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5656,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_vlrorc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5657,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_vlremp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5658,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_vlrliq')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5659,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_vlrpag')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5660,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_vlranu')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5661,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_codtipo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5662,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_resumo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5662,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_informacaoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5679,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_destin')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5684,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_salant')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5663,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5889,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_codcom')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5890,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_tipol')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,5891,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_numerol')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,7383,'','" . AddSlashes(pg_result($resaco, $iresaco, 'migra_elemento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,889,10817,'','" . AddSlashes(pg_result($resaco, $iresaco, 'efd60_concarpeculiar')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }
        $sql = " delete from empefdreinf
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($efd60_numemp != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " efd60_numemp = $efd60_numemp ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "empefdreinfs para EFD-REINF nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $efd60_numemp;
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Empenhos para EFD-REINF nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $efd60_numemp;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $efd60_numemp;
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
            $this->erro_sql   = "Erro ao selecionar os registros";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql   = "Record Vazio na Tabela:empefdreinf";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql
    function sql_query_file($efd60_numemp = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from empefdreinf ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($efd60_numemp != null) {
                $sql2 .= " where empefdreinf.efd60_numemp = $efd60_numemp ";
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