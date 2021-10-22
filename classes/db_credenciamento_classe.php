<?
//MODULO: licitacao
//CLASSE DA ENTIDADE credenciamento
class cl_credenciamento {
    // cria variaveis de erro
    var $rotulo     = null;
    var $query_sql  = null;
    var $numrows    = 0;
    var $numrows_incluir = 0;
    var $numrows_alterar = 0;
    var $numrows_excluir = 0;
    var $erro_status= null;
    var $erro_sql   = null;
    var $erro_banco = null;
    var $erro_msg   = null;
    var $erro_campo = null;
    var $pagina_retorno = null;
    // cria variaveis do arquivo
    var $l205_sequencial = 0;
    var $l205_fornecedor = 0;
    var $l205_datacred_dia = null;
    var $l205_datacred_mes = null;
    var $l205_datacred_ano = null;
    var $l205_datacred = null;
    var $l205_inscriestadual = null;
    var $l205_item = 0;
    var $l205_licitacao = 0;
    var $l205_datacreditem = null;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 l205_sequencial = int4 = Sequencial
                 l205_fornecedor = int4 = Fornecedor
                 l205_datacred = date = Data Credenciamento
                 l205_inscriestadual = varchar(10) = Inscrição Estadual
                 l205_item = int8 = Item
                 l205_licitacao = int4 = Licitação
                 l205_datacreditem = date = Data Credenciamento do item
                 ";
    //funcao construtor da classe
    function cl_credenciamento() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("credenciamento");
        $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
    }
    //funcao erro
    function erro($mostra,$retorna) {
        if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
            echo "<script>alert(\"".$this->erro_msg."\");</script>";
            if($retorna==true){
                echo "<script>location.href='".$this->pagina_retorno."'</script>";
            }
        }
    }
    // funcao para atualizar campos
    function atualizacampos($exclusao=false) {
        if($exclusao==false){
            $this->l205_sequencial = ($this->l205_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_sequencial"]:$this->l205_sequencial);
            $this->l205_fornecedor = ($this->l205_fornecedor == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_fornecedor"]:$this->l205_fornecedor);
            if($this->l205_datacred == ""){
                $this->l205_datacred_dia = ($this->l205_datacred_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_datacred_dia"]:$this->l205_datacred_dia);
                $this->l205_datacred_mes = ($this->l205_datacred_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_datacred_mes"]:$this->l205_datacred_mes);
                $this->l205_datacred_ano = ($this->l205_datacred_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_datacred_ano"]:$this->l205_datacred_ano);
                if($this->l205_datacred_dia != ""){
                    $this->l205_datacred = $this->l205_datacred_ano."-".$this->l205_datacred_mes."-".$this->l205_datacred_dia;
                }
            }
            $this->l205_inscriestadual = ($this->l205_inscriestadual == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_inscriestadual"]:$this->l205_inscriestadual);
            $this->l205_item = ($this->l205_item == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_item"]:$this->l205_item);
            $this->l205_licitacao = ($this->l205_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_licitacao"]:$this->l205_licitacao);
            $this->l205_datacreditem = ($this->l205_datacreditem == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_datacreditem"]:$this->l205_datacreditem);
        }else{
            $this->l205_sequencial = ($this->l205_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l205_sequencial"]:$this->l205_sequencial);
        }
    }
    // funcao para inclusao
    function incluir ($l205_sequencial){
        $this->atualizacampos();
        if($this->l205_fornecedor == null ){
            $this->erro_sql = " Campo Fornecedor nao Informado.";
            $this->erro_campo = "l205_fornecedor";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->l205_datacred == null ){
            $this->erro_sql = " Campo Data Credenciamento nao Informado.";
            $this->erro_campo = "l205_datacred_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        /*if($this->l205_inscriestadual == null && $this->verifica_fisica_juridica($this->l205_fornecedor) == 'j'){
          $this->erro_sql = " Campo Inscrição Estadual nao Informado.";
          $this->erro_campo = "l205_inscriestadual";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }*/
        if($this->l205_item == null ){
            $this->erro_sql = " Campo Item nao Informado.";
            $this->erro_campo = "l205_item";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->l205_licitacao == null ){
            $this->erro_sql = " Campo Licitação nao Informado.";
            $this->erro_campo = "l205_licitacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($l205_sequencial == "" || $l205_sequencial == null ){
            $result = db_query("select nextval('credenciamento_l205_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: credenciamento_l205_sequencial_seq do campo: l205_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l205_sequencial = pg_result($result,0,0);
        }else{
            $result = db_query("select last_value from credenciamento_l205_sequencial_seq");
            if(($result != false) && (pg_result($result,0,0) < $l205_sequencial)){
                $this->erro_sql = " Campo l205_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }else{
                $this->l205_sequencial = $l205_sequencial;
            }
        }
        if(($this->l205_sequencial == null) || ($this->l205_sequencial == "") ){
            $this->erro_sql = " Campo l205_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if(($this->l205_datacreditem == null) || ($this->l205_datacreditem == "") ){
            $this->erro_sql = " Campo Data Credenciamento item não informado";
            $this->erro_banco = "Campo vazio";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into credenciamento(
                                       l205_sequencial
                                      ,l205_fornecedor
                                      ,l205_datacred
                                      ,l205_inscriestadual
                                      ,l205_item
                                      ,l205_licitacao
                                      ,l205_datacreditem
                       )
                values (
                                $this->l205_sequencial
                               ,$this->l205_fornecedor
                               ,".($this->l205_datacred == "null" || $this->l205_datacred == ""?"null":"'".$this->l205_datacred."'")."
                               ,'$this->l205_inscriestadual'
                               ,$this->l205_item
                               ,$this->l205_licitacao
                               ,'$this->l205_datacreditem'
                      )";

        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                $this->erro_sql   = "Credenciamento ($this->l205_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Credenciamento já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }else{
                $this->erro_sql   = "Credenciamento ($this->l205_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->l205_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $resaco = $this->sql_record($this->sql_query_file($this->l205_sequencial));
        if(($resaco!=false)||($this->numrows!=0)){
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac,0,0);
            $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
            $resac = db_query("insert into db_acountkey values($acount,2009474,'$this->l205_sequencial','I')");
            $resac = db_query("insert into db_acount values($acount,2010229,2009474,'','".AddSlashes(pg_result($resaco,0,'l205_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010229,2009475,'','".AddSlashes(pg_result($resaco,0,'l205_fornecedor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010229,2009476,'','".AddSlashes(pg_result($resaco,0,'l205_datacred'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010229,2009478,'','".AddSlashes(pg_result($resaco,0,'l205_inscriestadual'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010229,2009477,'','".AddSlashes(pg_result($resaco,0,'l205_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010229,2009479,'','".AddSlashes(pg_result($resaco,0,'l205_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        }
        return true;
    }
    // funcao para alteracao
    function alterar ($l205_sequencial=null) {
        $this->atualizacampos();
        $sql = " update credenciamento set ";
        $virgula = "";
        if(trim($this->l205_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l205_sequencial"])){
            $sql  .= $virgula." l205_sequencial = $this->l205_sequencial ";
            $virgula = ",";
            if(trim($this->l205_sequencial) == null ){
                $this->erro_sql = " Campo Sequencial nao Informado.";
                $this->erro_campo = "l205_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->l205_fornecedor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l205_fornecedor"])){
            $sql  .= $virgula." l205_fornecedor = $this->l205_fornecedor ";
            $virgula = ",";
            if(trim($this->l205_fornecedor) == null ){
                $this->erro_sql = " Campo Fornecedor nao Informado.";
                $this->erro_campo = "l205_fornecedor";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->l205_datacred)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l205_datacred_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l205_datacred_dia"] !="") ){
            $sql  .= $virgula." l205_datacred = '$this->l205_datacred' ";
            $virgula = ",";
            if(trim($this->l205_datacred) == null ){
                $this->erro_sql = " Campo Data Credenciamento nao Informado.";
                $this->erro_campo = "l205_datacred_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if(isset($GLOBALS["HTTP_POST_VARS"]["l205_datacred_dia"])){
                $sql  .= $virgula." l205_datacred = null ";
                $virgula = ",";
                if(trim($this->l205_datacred) == null ){
                    $this->erro_sql = " Campo Data Credenciamento nao Informado.";
                    $this->erro_campo = "l205_datacred_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if(trim($this->l205_inscriestadual)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l205_inscriestadual"])){
            $sql  .= $virgula." l205_inscriestadual = '$this->l205_inscriestadual' ";
            $virgula = ",";
            if(trim($this->l205_inscriestadual) == null ){
                $this->erro_sql = " Campo Inscrição Estadual nao Informado.";
                $this->erro_campo = "l205_inscriestadual";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->l205_item)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l205_item"])){
            $sql  .= $virgula." l205_item = $this->l205_item ";
            $virgula = ",";
            if(trim($this->l205_item) == null ){
                $this->erro_sql = " Campo Item nao Informado.";
                $this->erro_campo = "l205_item";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if(trim($this->l205_datacreditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l205_datacreditem"])){
            $sql  .= $virgula." l205_datacreditem = '$this->l205_datacreditem' ";
            $virgula = ",";
            if(trim($this->l205_datacreditem) == null ){
                $this->erro_sql = " Campo data credenciamento item nao Informado.";
                $this->erro_campo = "l205_datacreditem";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if(trim($this->l205_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l205_licitacao"])){
            $sql  .= $virgula." l205_licitacao = $this->l205_licitacao ";
            $virgula = ",";
            if(trim($this->l205_licitacao) == null ){
                $this->erro_sql = " Campo Licitação nao Informado.";
                $this->erro_campo = "l205_licitacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        if($this->l205_sequencial != null){
            $sql .= " l205_sequencial = $this->l205_sequencial";
        }
        $resaco = $this->sql_record($this->sql_query_file($this->l205_sequencial));
        if($this->numrows>0){
            for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,2009474,'$this->l205_sequencial','A')");
                if(isset($GLOBALS["HTTP_POST_VARS"]["l205_sequencial"]) || $this->l205_sequencial != "")
                    $resac = db_query("insert into db_acount values($acount,2010229,2009474,'".AddSlashes(pg_result($resaco,$conresaco,'l205_sequencial'))."','$this->l205_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["l205_fornecedor"]) || $this->l205_fornecedor != "")
                    $resac = db_query("insert into db_acount values($acount,2010229,2009475,'".AddSlashes(pg_result($resaco,$conresaco,'l205_fornecedor'))."','$this->l205_fornecedor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["l205_datacred"]) || $this->l205_datacred != "")
                    $resac = db_query("insert into db_acount values($acount,2010229,2009476,'".AddSlashes(pg_result($resaco,$conresaco,'l205_datacred'))."','$this->l205_datacred',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["l205_inscriestadual"]) || $this->l205_inscriestadual != "")
                    $resac = db_query("insert into db_acount values($acount,2010229,2009478,'".AddSlashes(pg_result($resaco,$conresaco,'l205_inscriestadual'))."','$this->l205_inscriestadual',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["l205_item"]) || $this->l205_item != "")
                    $resac = db_query("insert into db_acount values($acount,2010229,2009477,'".AddSlashes(pg_result($resaco,$conresaco,'l205_item'))."','$this->l205_item',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["l205_licitacao"]) || $this->l205_licitacao != "")
                    $resac = db_query("insert into db_acount values($acount,2010229,2009479,'".AddSlashes(pg_result($resaco,$conresaco,'l205_licitacao'))."','$this->l205_licitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Credenciamento nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->l205_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Credenciamento nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->l205_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->l205_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir ($l205_sequencial=null,$dbwhere=null, $licitacao) {
        if($dbwhere==null || $dbwhere==""){
            $resaco = $this->sql_record($this->sql_query_file($l205_sequencial));
        }else{
            $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
        }
        if(($resaco!=false)||($this->numrows!=0)){
            for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,2009474,'$l205_sequencial','E')");
                $resac = db_query("insert into db_acount values($acount,2010229,2009474,'','".AddSlashes(pg_result($resaco,$iresaco,'l205_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010229,2009475,'','".AddSlashes(pg_result($resaco,$iresaco,'l205_fornecedor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010229,2009476,'','".AddSlashes(pg_result($resaco,$iresaco,'l205_datacred'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010229,2009478,'','".AddSlashes(pg_result($resaco,$iresaco,'l205_inscriestadual'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010229,2009477,'','".AddSlashes(pg_result($resaco,$iresaco,'l205_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010229,2009479,'','".AddSlashes(pg_result($resaco,$iresaco,'l205_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        $sql = " delete from credenciamento
                    where ";
        $sql2 = "";
        if($dbwhere==null || $dbwhere ==""){
            if($l205_sequencial != ""){
                if($sql2!=""){
                    $sql2 .= " and ";
                }
                $sql2 .= " l205_sequencial = $l205_sequencial ";
            }
        }else{
            $sql2 = "l205_fornecedor = $dbwhere and l205_licitacao = $licitacao";
        }
        $result = db_query($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Credenciamento nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$l205_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Credenciamento nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$l205_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$l205_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    function excluir_cred_licitacao ($licitacao) {
        $sql = " delete from credenciamento
                    where l205_licitacao = $licitacao";

        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Credenciamento nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$l205_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Credenciamento nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$l205_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$l205_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao do recordset
    function sql_record($sql) {
        $result = db_query($sql);
        if($result==false){
            $this->numrows    = 0;
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Erro ao selecionar os registros.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if($this->numrows==0){
            $this->erro_banco = "";
            $this->erro_sql   = "Record Vazio na Tabela:credenciamento";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql
    function sql_query ( $l205_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
        $sql = "select ";
        if($campos != "*" ){
            $campos_sql = explode("#",$campos);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }else{
            $sql .= $campos;
        }
        $sql .= " from credenciamento ";
        $sql2 = "";
        if($dbwhere==""){
            if($l205_sequencial!=null ){
                $sql2 .= " where credenciamento.l205_sequencial = $l205_sequencial ";
            }
        }else if($dbwhere != ""){
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if($ordem != null ){
            $sql .= " order by ";
            $campos_sql = explode("#",$ordem);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
    // funcao do sql
    function sql_query_file ( $l205_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
        $sql = "select ";
        if($campos != "*" ){
            $campos_sql = explode("#",$campos);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }else{
            $sql .= $campos;
        }
        $sql .= " from credenciamento ";
        $sql .= " inner join liclicita on l20_codigo = l205_licitacao ";
        $sql2 = "";
        if($dbwhere==""){
            if($l205_sequencial!=null ){
                $sql2 .= " where credenciamento.l205_sequencial = $l205_sequencial ";
            }
        }else if($dbwhere != ""){
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if($ordem != null ){
            $sql .= " order by ";
            $campos_sql = explode("#",$ordem);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    function itensCredenciados ( $l21_codigo=null,$campos="*",$ordem=null,$dbwhere=""){
        $sql = "select ";
        if($campos != "*" ){
            $campos_sql = explode("#",$campos);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }else{
            $sql .= $campos;
        }
        $sql .= " from liclicitem ";
        $sql .= "      inner join pcprocitem           on liclicitem.l21_codpcprocitem        = pcprocitem.pc81_codprocitem";
        $sql .= "      inner join pcproc               on pcproc.pc80_codproc                 = pcprocitem.pc81_codproc";
        $sql .= "      inner join solicitem            on solicitem.pc11_codigo               = pcprocitem.pc81_solicitem";
        $sql .= "      inner join solicita             on solicita.pc10_numero                = solicitem.pc11_numero";
        $sql .= "      inner join db_depart            on db_depart.coddepto                  = solicita.pc10_depto";
        $sql .= "      left  join liclicita            on liclicita.l20_codigo                = liclicitem.l21_codliclicita";
        $sql .= "      left  join cflicita             on cflicita.l03_codigo                 = liclicita.l20_codtipocom";
        $sql .= "      left  join pctipocompra         on pctipocompra.pc50_codcom            = cflicita.l03_codcom";
        $sql .= "      left  join solicitemunid        on solicitemunid.pc17_codigo           = solicitem.pc11_codigo";
        $sql .= "      left  join matunid              on matunid.m61_codmatunid              = solicitemunid.pc17_unid";
        $sql .= "      left  join pcorcamitemlic       on l21_codigo                          = pc26_liclicitem ";
        $sql .= "      left  join pcorcamval           on pc26_orcamitem                      = pc23_orcamitem ";
        $sql .= "      left  join db_usuarios          on pcproc.pc80_usuario                 = db_usuarios.id_usuario";
        $sql .= "      left  join solicitempcmater     on solicitempcmater.pc16_solicitem     = solicitem.pc11_codigo";
        $sql .= "      left  join pcmater              on pcmater.pc01_codmater               = solicitempcmater.pc16_codmater";
        $sql .= "      left  join pcsubgrupo           on pcsubgrupo.pc04_codsubgrupo         = pcmater.pc01_codsubgrupo";
        $sql .= "      left  join pctipo               on pctipo.pc05_codtipo                 = pcsubgrupo.pc04_codtipo";
        $sql .= "      left  join solicitemele         on solicitemele.pc18_solicitem         = solicitem.pc11_codigo";
        $sql .= "      left  join orcelemento          on orcelemento.o56_codele              = solicitemele.pc18_codele";
        $sql .= "                                     and orcelemento.o56_anousu              = ".db_getsession("DB_anousu");
        $sql .= "      left  join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem";
        $sql .= "      left  join empautitem           on empautitem.e55_autori               = empautitempcprocitem.e73_autori";
        $sql .= "                                     and empautitem.e55_sequen               = empautitempcprocitem.e73_sequen";
        $sql .= "      left  join empautoriza          on empautoriza.e54_autori              = empautitem.e55_autori ";
        $sql .= "      left  join empempaut            on empempaut.e61_autori                = empautitem.e55_autori ";
        $sql .= "      left  join empempenho           on empempenho.e60_numemp               = empempaut.e61_numemp ";
        $sql .= "      left  join pcdotac              on solicitem.pc11_codigo               = pcdotac.pc13_codigo ";
        $sql .= "      inner  join credenciamento       on pcprocitem.pc81_codprocitem         = credenciamento.l205_item ";
        $sql2 = "";
        if($dbwhere==""){
            if($l21_codigo!=null ){
                $sql2 .= " where liclicitem.l21_codigo = $l21_codigo ";
            }
        }else if($dbwhere != ""){
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if($ordem != null ){
            $sql .= " order by ";
            $campos_sql = explode("#",$ordem);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    function verifica_fisica_juridica($num_cgm) {
        $sql = "select z01_cgccpf from cgm where z01_numcgm = $num_cgm";
        $result = db_query($sql);
        if (strlen(pg_result($result,0,0)) == 11) {
            return 'f';
        } else {
            return 'j';
        }
    }
}
?>
