<?php
//MODULO: itbi
//CLASSE DA ENTIDADE itbi_divida
class cl_itbi_divida {
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
    var $it36_guia = 0;
    var $it36_coddiv = 0;
    var $it36_data_dia = null;
    var $it36_data_mes = null;
    var $it36_data_ano = null;
    var $it36_data = null;
    var $it36_usuario = 0;
    var $it36_observacao = null;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 it36_guia = int8 = Guia de ITBI
                 it36_coddiv = int8 = Código da D.A
                 it36_data = date = Data da Inscrição em D.A
                 it36_usuario = int8 = Codigo do Usuario
                 it36_observacao = text = Observações
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
            $this->it36_guia = ($this->it36_guia == ""?@$GLOBALS["HTTP_POST_VARS"]["it36_guia"]:$this->it36_guia);
            $this->it36_coddiv = ($this->it36_coddiv == ""?@$GLOBALS["HTTP_POST_VARS"]["it36_coddiv"]:$this->it36_coddiv);
            if($this->it36_data == ""){
                $this->it36_data_dia = @$GLOBALS["HTTP_POST_VARS"]["it36_data_dia"];
                $this->it36_data_mes = @$GLOBALS["HTTP_POST_VARS"]["it36_data_mes"];
                $this->it36_data_ano = @$GLOBALS["HTTP_POST_VARS"]["it36_data_ano"];
                if($this->it36_data_dia != ""){
                    $this->it36_data = $this->it36_data_ano."-".$this->it36_data_mes."-".$this->it36_data_dia;
                }
            }
            $this->it36_usuario = ($this->it36_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["it36_usuario"]:$this->it36_usuario);
            $this->it36_observacao = ($this->it36_observacao == ""?@$GLOBALS["HTTP_POST_VARS"]["it36_observacao"]:$this->it36_observacao);
        }
    }
    // funcao para inclusao
    function incluir (){
        $this->atualizacampos();
        if($this->it36_guia == null ){
            $this->erro_sql = " Campo Guia de ITBI nao Informado.";
            $this->erro_campo = "it36_guia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it36_coddiv == null ){
            $this->erro_sql = " Campo CGM do Transmitente nao Informado.";
            $this->erro_campo = "it36_coddiv";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it36_data == null ){
            $this->erro_sql = " Campo Data da Transferencia nao Informado.";
            $this->erro_campo = "it36_data_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it36_usuario == null ){
            $this->erro_sql = " Campo Codigo do Usuario nao Informado.";
            $this->erro_campo = "it36_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->it36_observacao == null ){
            $this->erro_sql = " Campo Observacao da Transferencia nao Informado.";
            $this->erro_campo = "it36_observacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into itbi_divida(
                                       it36_guia
                                      ,it36_coddiv
                                      ,it36_data
                                      ,it36_usuario
                                      ,it36_observacao
                       )
                values (
                                $this->it36_guia
                               ,$this->it36_coddiv
                               ,".($this->it36_data == "null" || $this->it36_data == ""?"null":"'".$this->it36_data."'")."
                               ,$this->it36_usuario
                               ,'$this->it36_observacao'
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
    function alterar ( $it36_guia=null ) {
        $this->atualizacampos();
        $sql = " update itbi_divida set ";
        $virgula = "";
        if(trim($this->it36_guia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it36_guia"])){
            if(trim($this->it36_guia)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it36_guia"])){
                $this->it36_guia = "0" ;
            }
            $sql  .= $virgula." it36_guia = $this->it36_guia ";
            $virgula = ",";
            if(trim($this->it36_guia) == null ){
                $this->erro_sql = " Campo Guia de ITBI nao Informado.";
                $this->erro_campo = "it36_guia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->it36_coddiv)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it36_coddiv"])){
            if(trim($this->it36_coddiv)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it36_coddiv"])){
                $this->it36_coddiv = "0" ;
            }
            $sql  .= $virgula." it36_coddiv = $this->it36_coddiv ";
            $virgula = ",";
            if(trim($this->it36_coddiv) == null ){
                $this->erro_sql = " Campo CGM do Transmitente nao Informado.";
                $this->erro_campo = "it36_coddiv";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->it36_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it36_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["it36_data_dia"] !="") ){
            $sql  .= $virgula." it36_data = '$this->it36_data' ";
            $virgula = ",";
            if(trim($this->it36_data) == null ){
                $this->erro_sql = " Campo Data da Transferencia nao Informado.";
                $this->erro_campo = "it36_data_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if(isset($GLOBALS["HTTP_POST_VARS"]["it36_data_dia"])){
                $sql  .= $virgula." it36_data = null ";
                $virgula = ",";
                if(trim($this->it36_data) == null ){
                    $this->erro_sql = " Campo Data da Transferencia nao Informado.";
                    $this->erro_campo = "it36_data_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if(trim($this->it36_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it36_usuario"])){
            if(trim($this->it36_usuario)=="" && isset($GLOBALS["HTTP_POST_VARS"]["it36_usuario"])){
                $this->it36_usuario = "0" ;
            }
            $sql  .= $virgula." it36_usuario = $this->it36_usuario ";
            $virgula = ",";
            if(trim($this->it36_usuario) == null ){
                $this->erro_sql = " Campo Codigo do Usuario nao Informado.";
                $this->erro_campo = "it36_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->it36_observacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["it36_observacao"])){
            $sql  .= $virgula." it36_observacao = '$this->it36_observacao' ";
            $virgula = ",";
            if(trim($this->it36_observacao) == null ){
                $this->erro_sql = " Campo Observacao da Transferencia nao Informado.";
                $this->erro_campo = "it36_observacao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where it36_guia = $it36_guia ";
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
    function excluir ( $it36_guia=null ) {
        $this->atualizacampos(true);
        $sql = " delete from itbi_divida
                    where ";
        $sql2 = "";
        $sql2 = "it36_guia = $it36_guia";
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
    function sql_query ( $it36_guia = null,$campos="itbi_divida.it36_guia,*",$ordem=null,$dbwhere=""){
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
        $sql .= " from itbi_divida ";
        $sql2 = "";
        if($dbwhere==""){
            if( $it36_guia != "" && $it36_guia != null){
                $sql2 = " where itbi_divida.it36_guia = $it36_guia";
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
    function sql_query_file ( $it36_guia = null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from itbi_divida ";
        $sql2 = "";
        if($dbwhere==""){
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

    public function sql_query_vencidos($dataVencimento)
    {
        return "SELECT DISTINCT it01_guia
               FROM itbi
               INNER JOIN itbitransacao ON it04_codigo = it01_tipotransacao
               INNER JOIN itbinome ON itbinome.it03_guia = itbi.it01_guia
               AND itbinome.it03_tipo = 'C'
               inner JOIN itbiavalia ON itbiavalia.it14_guia = itbi.it01_guia
               LEFT JOIN itbicancela ON itbicancela.it16_guia = itbi.it01_guia
               WHERE it14_dtvenc <= '{$dataVencimento}'
                 AND NOT exists
                   (SELECT arrepaga.k00_numpre
                    FROM arrepaga
                    INNER JOIN itbinumpre ON itbinumpre.it15_numpre = arrepaga.k00_numpre
                    WHERE itbinumpre.it15_guia = itbi.it01_guia)
                 AND it16_guia IS NULL
                 AND NOT exists (
                     SELECT 1 FROM itbi_divida where it16_guia = itbi.it01_guia
                 )
               ORDER BY 1";
    }
}
