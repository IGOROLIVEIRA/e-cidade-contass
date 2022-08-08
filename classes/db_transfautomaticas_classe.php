<?php
//MODULO: itbi
//CLASSE DA ENTIDADE transfautomaticas
class cl_transfautomaticas {
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
    var $it35_guia = 0;
    var $it35_transmitente = 0;
    var $it35_comprador = 0;
    var $it35_data_dia = null;
    var $it35_data_mes = null;
    var $it35_data_ano = null;
    var $it35_data = null;
    var $it35_usuario = 0;
    var $it35_numpre = 0;
    var $it35_status = 0;
    var $it35_observacao = null;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 it35_guia = int8 = Guia de ITBI 
                 it35_transmitente = int8 = CGM do Transmitente 
                 it35_comprador = int8 = CGM do Comprador 
                 it35_data = date = Data da Transferencia 
                 it35_usuario = int8 = Codigo do Usuario 
                 it35_numpre = int8 = Codigo do Numpre 
                 it35_status = int8 = Status da Transferencia 
                 it35_observacao = text = Observacao da Transferencia 
                 ";
    //funcao construtor da classe
    function cl_transfautomaticas() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("transfautomaticas");
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
            $this->it35_guia = ($this->it35_guia == ""?@$GLOBALS["HTTP_POST_VARS"]["it35_guia"]:$this->it35_guia);
            $this->it35_transmitente = ($this->it35_transmitente == ""?@$GLOBALS["HTTP_POST_VARS"]["it35_transmitente"]:$this->it35_transmitente);
            $this->it35_comprador = ($this->it35_comprador == ""?@$GLOBALS["HTTP_POST_VARS"]["it35_comprador"]:$this->it35_comprador);
            if($this->it35_data == ""){
                $this->it35_data_dia = @$GLOBALS["HTTP_POST_VARS"]["it35_data_dia"];
                $this->it35_data_mes = @$GLOBALS["HTTP_POST_VARS"]["it35_data_mes"];
                $this->it35_data_ano = @$GLOBALS["HTTP_POST_VARS"]["it35_data_ano"];
                if($this->it35_data_dia != ""){
                    $this->it35_data = $this->it35_data_ano."-".$this->it35_data_mes."-".$this->it35_data_dia;
                }
            }
            $this->it35_usuario = ($this->it35_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["it35_usuario"]:$this->it35_usuario);
            $this->it35_numpre = ($this->it35_numpre == ""?@$GLOBALS["HTTP_POST_VARS"]["it35_numpre"]:$this->it35_numpre);
            $this->it35_status = ($this->it35_status == ""?@$GLOBALS["HTTP_POST_VARS"]["it35_status"]:$this->it35_status);
            $this->it35_observacao = ($this->it35_observacao == ""?@$GLOBALS["HTTP_POST_VARS"]["it35_observacao"]:$this->it35_observacao);
        }
    }
    // funcao para inclusao
    function incluir (){
        $this->atualizacampos();
        if($this->it35_guia == null ){
            $this->erro_sql = " Campo Guia de ITBI nao Informado.";
            $this->erro_campo = "it35_guia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it35_transmitente == null ){
            $this->erro_sql = " Campo CGM do Transmitente nao Informado.";
            $this->erro_campo = "it35_transmitente";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it35_comprador == null ){
            $this->erro_sql = " Campo CGM do Comprador nao Informado.";
            $this->erro_campo = "it35_comprador";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it35_data == null ){
            $this->erro_sql = " Campo Data da Transferencia nao Informado.";
            $this->erro_campo = "it35_data_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it35_usuario == null ){
            $this->erro_sql = " Campo Codigo do Usuario nao Informado.";
            $this->erro_campo = "it35_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it35_numpre == null ){
            $this->erro_sql = " Campo Codigo do Numpre nao Informado.";
            $this->erro_campo = "it35_numpre";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it35_status == null ){
            $this->erro_sql = " Campo Status da Transferencia nao Informado.";
            $this->erro_campo = "it35_status";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it35_observacao == null ){
            $this->erro_sql = " Campo Observacao da Transferencia nao Informado.";
            $this->erro_campo = "it35_observacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into transfautomaticas(
                                       it35_guia 
                                      ,it35_transmitente 
                                      ,it35_comprador 
                                      ,it35_data 
                                      ,it35_usuario 
                                      ,it35_numpre 
                                      ,it35_status 
                                      ,it35_observacao 
                       )
                values (
                                $this->it35_guia 
                               ,$this->it35_transmitente 
                               ,$this->it35_comprador 
                               ,".($this->it35_data == "null" || $this->it35_data == ""?"null":"'".$this->it35_data."'")." 
                               ,$this->it35_usuario 
                               ,$this->it35_numpre 
                               ,$this->it35_status 
                               ,'$this->it35_observacao' 
                      )";
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                $this->erro_sql   = "Registra as transferencias automaticas () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Registra as transferencias automaticas já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }else{
                $this->erro_sql   = "Registra as transferencias automaticas () nao Incluído. Inclusao Abortada.";
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
    function alterar ( $it35_guia=null ) {
        $this->atualizacampos();
        $sql = " update transfautomaticas set ";
        $virgula = "";
        if(trim($this->it35_guia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it35_guia"])){
            if(trim($this->it35_guia)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it35_guia"])){
                $this->it35_guia = "0" ;
            }
            $sql  .= $virgula." it35_guia = $this->it35_guia ";
            $virgula = ",";
            if(trim($this->it35_guia) == null ){
                $this->erro_sql = " Campo Guia de ITBI nao Informado.";
                $this->erro_campo = "it35_guia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->it35_transmitente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it35_transmitente"])){
            if(trim($this->it35_transmitente)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it35_transmitente"])){
                $this->it35_transmitente = "0" ;
            }
            $sql  .= $virgula." it35_transmitente = $this->it35_transmitente ";
            $virgula = ",";
            if(trim($this->it35_transmitente) == null ){
                $this->erro_sql = " Campo CGM do Transmitente nao Informado.";
                $this->erro_campo = "it35_transmitente";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->it35_comprador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it35_comprador"])){
            if(trim($this->it35_comprador)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it35_comprador"])){
                $this->it35_comprador = "0" ;
            }
            $sql  .= $virgula." it35_comprador = $this->it35_comprador ";
            $virgula = ",";
            if(trim($this->it35_comprador) == null ){
                $this->erro_sql = " Campo CGM do Comprador nao Informado.";
                $this->erro_campo = "it35_comprador";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->it35_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it35_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["it35_data_dia"] !="") ){
            $sql  .= $virgula." it35_data = '$this->it35_data' ";
            $virgula = ",";
            if(trim($this->it35_data) == null ){
                $this->erro_sql = " Campo Data da Transferencia nao Informado.";
                $this->erro_campo = "it35_data_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if(isset($GLOBALS["HTTP_POST_VARS"]["it35_data_dia"])){
                $sql  .= $virgula." it35_data = null ";
                $virgula = ",";
                if(trim($this->it35_data) == null ){
                    $this->erro_sql = " Campo Data da Transferencia nao Informado.";
                    $this->erro_campo = "it35_data_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if(trim($this->it35_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it35_usuario"])){
            if(trim($this->it35_usuario)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it35_usuario"])){
                $this->it35_usuario = "0" ;
            }
            $sql  .= $virgula." it35_usuario = $this->it35_usuario ";
            $virgula = ",";
            if(trim($this->it35_usuario) == null ){
                $this->erro_sql = " Campo Codigo do Usuario nao Informado.";
                $this->erro_campo = "it35_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->it35_numpre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it35_numpre"])){
            if(trim($this->it35_numpre)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it35_numpre"])){
                $this->it35_numpre = "0" ;
            }
            $sql  .= $virgula." it35_numpre = $this->it35_numpre ";
            $virgula = ",";
            if(trim($this->it35_numpre) == null ){
                $this->erro_sql = " Campo Codigo do Numpre nao Informado.";
                $this->erro_campo = "it35_numpre";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->it35_status)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it35_status"])){
            if(trim($this->it35_status)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it35_status"])){
                $this->it35_status = "0" ;
            }
            $sql  .= $virgula." it35_status = $this->it35_status ";
            $virgula = ",";
            if(trim($this->it35_status) == null ){
                $this->erro_sql = " Campo Status da Transferencia nao Informado.";
                $this->erro_campo = "it35_status";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->it35_observacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it35_observacao"])){
            $sql  .= $virgula." it35_observacao = '$this->it35_observacao' ";
            $virgula = ",";
            if(trim($this->it35_observacao) == null ){
                $this->erro_sql = " Campo Observacao da Transferencia nao Informado.";
                $this->erro_campo = "it35_observacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where it35_guia = $it35_guia ";
        $result = @pg_exec($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Registra as transferencias automaticas nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Registra as transferencias automaticas nao foi Alterado. Alteracao Executada.\\n";
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
    function excluir ( $it35_guia=null ) {
        $this->atualizacampos(true);
        $sql = " delete from transfautomaticas
                    where ";
        $sql2 = "";
        $sql2 = "it35_guia = $it35_guia";
        $result = @pg_exec($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Registra as transferencias automaticas nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Registra as transferencias automaticas nao Encontrado. Exclusão não Efetuada.\\n";
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
    function sql_query ( $it35_guia = null,$campos="transfautomaticas.it35_guia,*",$ordem=null,$dbwhere=""){
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
        $sql .= " from transfautomaticas ";
        $sql2 = "";
        if($dbwhere==""){
            if( $it35_guia != "" && $it35_guia != null){
                $sql2 = " where transfautomaticas.it35_guia = $it35_guia";
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
    function sql_query_file ( $it35_guia = null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from transfautomaticas ";
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
