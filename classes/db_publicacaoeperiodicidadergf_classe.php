<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE publicacaoeperiodicidadergf
class cl_publicacaoeperiodicidadergf {
    // cria variaveis de erro
    var $rotulo     = null;
    var $query_sql  = null;
    var $numrows    = 0;
    var $erro_status= null;
    var $erro_sql   = null;
    var $erro_banco = null;
    var $erro_msg   = null;
    var $erro_campo = null;
    var $pagina_retorno = null;
    // cria variaveis do arquivo
    var $c221_dadoscomplementareslrf = 0;
    var $c221_publicrgf = 0;
    var $c221_dtpublicacaorelatoriorgf = 0;
    var $c221_localpublicacaorgf = 0;
    var $c221_tpperiodo = 0;
    var $c221_exerciciotpperiodo = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 c221_dadoscomplementareslrf = int4 = Sequencial DCLRF
                 c221_publicrgf = int4 = Houve publicação do RGF
                 c221_dtpublicacaorelatoriorgf = date = Data da Publicação do RGF
                 c221_localpublicacaorgf = int4 = Local da Publicação da RGF
                 c221_tpperiodo = int4 = Periodo a que se refere a data de public
                 c221_exerciciotpperiodo = int4 = Exercício a que se refere o período
                 ";
    //funcao construtor da classe
    function cl_publicacaoeperiodicidadergf() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("publicacaoeperiodicidadergf");
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
            $this->c221_dadoscomplementareslrf = ($this->c221_dadoscomplementareslrf == ""?@$GLOBALS["HTTP_POST_VARS"]["c221_dadoscomplementareslrf"]:$this->c221_dadoscomplementareslrf);
            $this->c221_publicrgf = ($this->c221_publicrgf == ""?@$GLOBALS["HTTP_POST_VARS"]["c221_publicrgf"]:$this->c221_publicrgf);
            $this->c221_dtpublicacaorelatoriorgf = ($this->c221_dtpublicacaorelatoriorgf == ""?@$GLOBALS["HTTP_POST_VARS"]["c221_dtpublicacaorelatoriorgf"]:$this->c221_dtpublicacaorelatoriorgf);
            $this->c221_localpublicacaorgf = ($this->c221_localpublicacaorgf == ""?@$GLOBALS["HTTP_POST_VARS"]["c221_localpublicacaorgf"]:$this->c221_localpublicacaorgf);
            $this->c221_tpperiodo = ($this->c221_tpperiodo == ""?@$GLOBALS["HTTP_POST_VARS"]["c221_tpperiodo"]:$this->c221_tpperiodo);
            $this->c221_exerciciotpperiodo = ($this->c221_exerciciotpperiodo == ""?@$GLOBALS["HTTP_POST_VARS"]["c221_exerciciotpperiodo"]:$this->c221_exerciciotpperiodo);
        }else{
        }
    }
    // funcao para inclusao
    function incluir (){
        $this->atualizacampos();

        if($this->c221_dadoscomplementareslrf == null ){
            $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
            $this->erro_campo = "c221_dadoscomplementareslrf";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->c221_publicrgf == null ){
            $this->erro_sql = " Campo Houve publicação do RGF nao Informado.";
            $this->erro_campo = "c221_publicrgf";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->c221_exerciciotpperiodo == null || $this->c221_exerciciotpperiodo == ""){
            $this->c221_exerciciotpperiodo = 'null';
        }

        $sql ="insert into publicacaoeperiodicidadergf(
                                       c221_dadoscomplementareslrf
                                      ,c221_publicrgf
                                      ,c221_dtpublicacaorelatoriorgf
                                      ,c221_localpublicacaorgf
                                      ,c221_tpperiodo
                                      ,c221_exerciciotpperiodo
                       )
                values (
                                $this->c221_dadoscomplementareslrf
                               ,$this->c221_publicrgf
                               ,".($this->c221_dtpublicacaorelatoriorgf == "null" || $this->c221_dtpublicacaorelatoriorgf == ""?"null":"'".$this->c221_dtpublicacaorelatoriorgf."'")."
                               ,'$this->c221_localpublicacaorgf'
                               ,$this->c221_tpperiodo
                               ,$this->c221_exerciciotpperiodo
                      )";

        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                $this->erro_sql   = "Publicação e Periodicidade do RGF da LRF () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Publicação e Periodicidade do RGF da LRF já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }else{
                $this->erro_sql   = "Publicação e Periodicidade do RGF da LRF () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        return true;
    }
    // funcao para alteracao
    function alterar ( $c221_dadoscomplementareslrf=null ) {
        $this->atualizacampos();
        $sql = " update publicacaoeperiodicidadergf set ";
        $virgula = "";
        if(trim($this->c221_dadoscomplementareslrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c221_dadoscomplementareslrf"])){
            if(trim($this->c221_dadoscomplementareslrf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c221_dadoscomplementareslrf"])){
                $this->c221_dadoscomplementareslrf = "0" ;
            }
            $sql  .= $virgula." c221_dadoscomplementareslrf = $this->c221_dadoscomplementareslrf ";
            $virgula = ",";
            if(trim($this->c221_dadoscomplementareslrf) == null ){
                $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
                $this->erro_campo = "c221_dadoscomplementareslrf";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->c221_publicrgf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c221_publicrgf"])){
            if(trim($this->c221_publicrgf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c221_publicrgf"])){
                $this->c221_publicrgf = "0" ;
            }
            $sql  .= $virgula." c221_publicrgf = $this->c221_publicrgf ";
            $virgula = ",";
            if(trim($this->c221_publicrgf) == null ){
                $this->erro_sql = " Campo Houve publicação do RGF nao Informado.";
                $this->erro_campo = "c221_publicrgf";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if($this->c221_dtpublicacaorelatoriorgf || $this->c221_dtpublicacaorelatoriorgf == null){
            if($this->c221_dtpublicacaorelatoriorgf == "" || $this->c221_dtpublicacaorelatoriorgf == null){
                $sql  .= $virgula." c221_dtpublicacaorelatoriorgf = null";
            }else{
                $sql  .= $virgula." c221_dtpublicacaorelatoriorgf = '$this->c221_dtpublicacaorelatoriorgf' ";
            }
            $virgula = ",";
        }
        if($this->c221_localpublicacaorgf || $this->c221_localpublicacaorgf == null){
            if(trim($this->c221_localpublicacaorgf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c221_localpublicacaorgf"])){
                $this->c221_localpublicacaorgf = "0" ;
            }
            $sql  .= $virgula." c221_localpublicacaorgf = '$this->c221_localpublicacaorgf' ";
            $virgula = ",";
        }
        if(trim($this->c221_tpperiodo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c221_tpperiodo"])){
            if(trim($this->c221_tpperiodo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c221_tpperiodo"])){
                $this->c221_tpperiodo = "0" ;
            }
            $sql  .= $virgula." c221_tpperiodo = $this->c221_tpperiodo ";
            $virgula = ",";
            if(trim($this->c221_tpperiodo) == null ){
                $this->erro_sql = " Campo Periodo a que se refere a data de public nao Informado.";
                $this->erro_campo = "c221_tpperiodo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if($this->c221_exerciciotpperiodo || $this->c221_exerciciotpperiodo == null){
            if($this->c221_exerciciotpperiodo == null || $this->c221_exerciciotpperiodo == ""){
                $sql .= $virgula . " c221_exerciciotpperiodo = null";
            }else {
                $sql .= $virgula . " c221_exerciciotpperiodo = $this->c221_exerciciotpperiodo ";
            }
            $virgula = ",";
        }
        $sql .= " where c221_dadoscomplementareslrf = $c221_dadoscomplementareslrf ";
        $result = @pg_exec($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Publicação e Periodicidade do RGF da LRF nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Publicação e Periodicidade do RGF da LRF nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir ( $c221_dadoscomplementareslrf=null ) {
        $this->atualizacampos(true);
        $sql = " delete from publicacaoeperiodicidadergf
                    where ";
        $sql2 = "";
        $sql2 = "c221_dadoscomplementareslrf = $c221_dadoscomplementareslrf";
        $result = @pg_exec($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Publicação e Periodicidade do RGF da LRF nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Publicação e Periodicidade do RGF da LRF nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                return true;
            }
        }
    }
    // funcao do recordset
    function sql_record($sql) {
        $result = @pg_query($sql);
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
            $this->erro_sql   = "Dados do Grupo nao Encontrado";
            $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql
    function sql_query ( $c221_dadoscomplementareslrf = null,$campos="publicacaoeperiodicidadergf.c221_dadoscomplementareslrf,*",$ordem=null,$dbwhere=""){
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
        $sql .= " from publicacaoeperiodicidadergf ";
        $sql .= "      inner join   on  . = publicacaoeperiodicidadergf.c219_dadoscomplementareslrf and  . = publicacaoeperiodicidadergf.c220_dadoscomplementareslrf and  . = publicacaoeperiodicidadergf.c221_dadoscomplementareslrf";
        $sql2 = "";
        if($dbwhere==""){
            if( $c221_dadoscomplementareslrf != "" && $c221_dadoscomplementareslrf != null){
                $sql2 = " where publicacaoeperiodicidadergf.c221_dadoscomplementareslrf = $c221_dadoscomplementareslrf";
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
    function sql_query_file ( $c221_dadoscomplementareslrf = null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from publicacaoeperiodicidadergf ";
        $sql2 = "";
        if($dbwhere==""){
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
}
?>
