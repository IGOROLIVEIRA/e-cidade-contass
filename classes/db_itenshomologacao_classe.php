<?
//MODULO: licitacao
//CLASSE DA ENTIDADE itenshomologacao
class cl_itenshomologacao {
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
    var $l203_sequencial = 0;
    var $l203_homologaadjudicacao = 0;
    var $l203_fornecedor = 0;
    var $l203_item = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 l203_sequencial = int4 = Sequencial 
                 l203_homologaadjudicacao = int4 = Homologa adjudicacão 
                 l203_item = int4 = Item 
                 l203_fornecedor int8 = Fornecedor
                 ";
    //funcao construtor da classe
    function cl_itenshomologacao() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("itenshomologacao");
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
            $this->l203_sequencial = ($this->l203_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l203_sequencial"]:$this->l203_sequencial);
            $this->l203_homologaadjudicacao = ($this->l203_homologaadjudicacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l203_homologaadjudicacao"]:$this->l203_homologaadjudicacao);
            $this->l203_item = ($this->l203_item == ""?@$GLOBALS["HTTP_POST_VARS"]["l203_item"]:$this->l203_item);
            $this->l203_fornecedor = ($this->l203_fornecedor == ""?@$GLOBALS["HTTP_POST_VARS"]["l203_fornecedor"]:$this->l203_fornecedor);
        }else{
            $this->l203_sequencial = ($this->l203_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l203_sequencial"]:$this->l203_sequencial);
        }
    }
    // funcao para inclusao
    function incluir ($l203_sequencial){

        $this->atualizacampos();
        if($this->l203_homologaadjudicacao == null ){
            $this->erro_sql = " Campo Homologa adjudicacão nao Informado.";
            $this->erro_campo = "l203_homologaadjudicacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->l203_item == null ){
            $this->erro_sql = " Campo Item nao Informado.";
            $this->erro_campo = "l203_item";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($l203_sequencial == "" || $l203_sequencial == null ){
            $result = db_query("select nextval('itenshomologacao_l203_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: itenshomologacao_l203_sequencial_seq do campo: l203_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->l203_sequencial = pg_result($result,0,0);
        }else{
            $result = db_query("select last_value from itenshomologacao_l203_sequencial_seq");
            if(($result != false) && (pg_result($result,0,0) < $l203_sequencial)){
                $this->erro_sql = " Campo l203_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }else{
                $this->l203_sequencial = $l203_sequencial;
            }
        }
        if(($this->l203_sequencial == null) || ($this->l203_sequencial == "") ){
            $this->erro_sql = " Campo l203_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if(($this->l203_fornecedor == null) || ($this->l203_fornecedor == "") ){
            $this->erro_sql = " Campo l203_fornecedor nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into itenshomologacao(
                                       l203_sequencial 
                                      ,l203_homologaadjudicacao 
                                      ,l203_item
                                      ,l203_fornecedor 
                       )
                values (
                                $this->l203_sequencial 
                               ,$this->l203_homologaadjudicacao 
                               ,$this->l203_item
                               ,$this->l203_fornecedor 
                      )";

        $result = db_query($sql);

        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                $this->erro_sql   = "Itens da Homologação ($this->l203_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Itens da Homologação já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }else{
                $this->erro_sql   = "Itens da Homologação ($this->l203_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->l203_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $resaco = $this->sql_record($this->sql_query_file($this->l203_sequencial));
        if(($resaco!=false)||($this->numrows!=0)){
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac,0,0);
            $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
            $resac = db_query("insert into db_acountkey values($acount,2009450,'$this->l203_sequencial','I')");
            $resac = db_query("insert into db_acount values($acount,2010224,2009450,'','".AddSlashes(pg_result($resaco,0,'l203_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010224,2009451,'','".AddSlashes(pg_result($resaco,0,'l203_homologaadjudicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010224,2009452,'','".AddSlashes(pg_result($resaco,0,'l203_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        }
        return true;
    }
    // funcao para alteracao
    function alterar ($l203_sequencial=null) {
        $this->atualizacampos();
        $sql = " update itenshomologacao set ";
        $virgula = "";
        if(trim($this->l203_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l203_sequencial"])){
            $sql  .= $virgula." l203_sequencial = $this->l203_sequencial ";
            $virgula = ",";
            if(trim($this->l203_sequencial) == null ){
                $this->erro_sql = " Campo Sequencial nao Informado.";
                $this->erro_campo = "l203_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->l203_homologaadjudicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l203_homologaadjudicacao"])){
            $sql  .= $virgula." l203_homologaadjudicacao = $this->l203_homologaadjudicacao ";
            $virgula = ",";
            if(trim($this->l203_homologaadjudicacao) == null ){
                $this->erro_sql = " Campo Homologa adjudicacão nao Informado.";
                $this->erro_campo = "l203_homologaadjudicacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->l203_item)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l203_item"])){
            $sql  .= $virgula." l203_item = $this->l203_item ";
            $virgula = ",";
            if(trim($this->l203_item) == null ){
                $this->erro_sql = " Campo Item nao Informado.";
                $this->erro_campo = "l203_item";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if(trim($this->l203_fornecedor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l203_fornecedor"])){
            $sql  .= $virgula." l203_fornecedor = $this->l203_fornecedor ";
            $virgula = ",";
            if(trim($this->l203_fornecedor) == null ){
                $this->erro_sql = " Campo Item nao Informado.";
                $this->erro_campo = "l203_fornecedor";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        $sql .= " where ";
        if($l203_sequencial!=null){
            $sql .= " l203_sequencial = $this->l203_sequencial";
        }
        $resaco = $this->sql_record($this->sql_query_file($this->l203_sequencial));
        if($this->numrows>0){
            for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,2009450,'$this->l203_sequencial','A')");
                if(isset($GLOBALS["HTTP_POST_VARS"]["l203_sequencial"]) || $this->l203_sequencial != "")
                    $resac = db_query("insert into db_acount values($acount,2010224,2009450,'".AddSlashes(pg_result($resaco,$conresaco,'l203_sequencial'))."','$this->l203_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["l203_homologaadjudicacao"]) || $this->l203_homologaadjudicacao != "")
                    $resac = db_query("insert into db_acount values($acount,2010224,2009451,'".AddSlashes(pg_result($resaco,$conresaco,'l203_homologaadjudicacao'))."','$this->l203_homologaadjudicacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["l203_item"]) || $this->l203_item != "")
                    $resac = db_query("insert into db_acount values($acount,2010224,2009452,'".AddSlashes(pg_result($resaco,$conresaco,'l203_item'))."','$this->l203_item',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        $result = db_query($sql);

        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Itens da Homologação nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->l203_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Itens da Homologação nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->l203_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->l203_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir ($l203_sequencial=null,$dbwhere=null) {
        if($dbwhere==null || $dbwhere==""){
            $resaco = $this->sql_record($this->sql_query_file($l203_sequencial));
        }else{
            $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
        }
        if(($resaco!=false)||($this->numrows!=0)){
            for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,2009450,'$l203_sequencial','E')");
                $resac = db_query("insert into db_acount values($acount,2010224,2009450,'','".AddSlashes(pg_result($resaco,$iresaco,'l203_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010224,2009451,'','".AddSlashes(pg_result($resaco,$iresaco,'l203_homologaadjudicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010224,2009452,'','".AddSlashes(pg_result($resaco,$iresaco,'l203_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        $sql = " delete from itenshomologacao
                    where ";
        $sql2 = "";
        if($dbwhere==null || $dbwhere ==""){
            if($l203_sequencial != ""){
                if($sql2!=""){
                    $sql2 .= " and ";
                }
                $sql2 .= " l203_sequencial = $l203_sequencial ";
            }
        }else{
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Itens da Homologação nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$l203_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Itens da Homologação nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$l203_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$l203_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:itenshomologacao";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql
    function sql_query ( $l203_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
        $sql = "select ";
        if($campos != "*" ){
            $campos_sql = split("#",$campos);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }else{
            $sql .= $campos;
        }
        $sql .= " from itenshomologacao ";
        $sql .= "      inner join pcmater  on  pcmater.pc01_codmater = itenshomologacao.l203_item";
        $sql .= "      inner join homologacaoadjudica  on  homologacaoadjudica.l202_sequencial = itenshomologacao.l203_homologaadjudicacao";
        $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = pcmater.pc01_id_usuario";
        $sql .= "      inner join pcsubgrupo  on  pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo";
        $sql .= "      inner join liclicita  on  liclicita.l20_codigo = homologacaoadjudica.l202_licitacao";
        $sql2 = "";
        if($dbwhere==""){
            if($l203_sequencial!=null ){
                $sql2 .= " where itenshomologacao.l203_sequencial = $l203_sequencial ";
            }
        }else if($dbwhere != ""){
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if($ordem != null ){
            $sql .= " order by ";
            $campos_sql = split("#",$ordem);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
    // funcao do sql
    function sql_query_file ( $l203_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
        $sql = "select ";
        if($campos != "*" ){
            $campos_sql = split("#",$campos);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }else{
            $sql .= $campos;
        }
        $sql .= " from itenshomologacao ";
        $sql2 = "";
        if($dbwhere==""){
            if($l203_sequencial!=null ){
                $sql2 .= " where itenshomologacao.l203_sequencial = $l203_sequencial ";
            }
        }else if($dbwhere != ""){
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if($ordem != null ){
            $sql .= " order by ";
            $campos_sql = split("#",$ordem);
            $virgula = "";
            for($i=0;$i<sizeof($campos_sql);$i++){
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    function getItensContratos($iLicitacao,$item){

        $sqlItensContrato = "SELECT ac16_sequencial
            FROM acordo
            INNER JOIN acordoposicao ON ac26_acordo = ac16_sequencial
            INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
            WHERE ac16_licitacao = $iLicitacao and ac20_pcmater = $item";
        $oResultItens = db_query($sqlItensContrato);
        return db_utils::getColectionByRecord($oResultItens);
    }

    function getitensPcmater($iLicitacao,$item){

        $sqlItens = "SELECT pc01_codmater
            FROM liclicitem
            INNER JOIN pcprocitem ON pc81_codprocitem = l21_codpcprocitem
            inner join solicitempcmater on pc16_solicitem = pc81_solicitem
            inner join pcmater on pc01_codmater = pc16_codmater
            WHERE l21_codliclicita = $iLicitacao
                AND l21_codpcprocitem IN ($item)";
        $oResult = db_query($sqlItens);
        return db_utils::getColectionByRecord($oResult);
    }

}
?>
