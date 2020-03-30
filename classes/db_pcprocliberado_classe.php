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
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: Caixa
//CLASSE DA ENTIDADE pcprocliberado
class cl_pcprocliberado {
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
    var $e233_sequencial = 0;
    var $e233_codproc = 0;
    var $e233_id_usuario = 0;
    var $e233_data_dia = null;
    var $e233_data_mes = null;
    var $e233_data_ano = null;
    var $e233_data = null;
    var $e233_hora = null;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 e233_sequencial = int4 = Sequencial 
                 e233_codproc = int4 = Cod Processo de Compra 
                 e233_id_usuario = int4 = Cod Usuario 
                 e233_data = date = Data 
                 e233_hora = char(5) = Hora 
                 ";
    //funcao construtor da classe
    function cl_pcprocliberado() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("pcprocliberado");
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
            $this->e233_sequencial = ($this->e233_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["e233_sequencial"]:$this->e233_sequencial);
            $this->e233_codproc = ($this->e233_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["e233_codproc"]:$this->e233_codproc);
            $this->e233_id_usuario = ($this->e233_id_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["e233_id_usuario"]:$this->e233_id_usuario);
            if($this->e233_data == ""){
                $this->e233_data_dia = ($this->e233_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["e233_data_dia"]:$this->e233_data_dia);
                $this->e233_data_mes = ($this->e233_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["e233_data_mes"]:$this->e233_data_mes);
                $this->e233_data_ano = ($this->e233_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["e233_data_ano"]:$this->e233_data_ano);
                if($this->e233_data_dia != ""){
                    $this->e233_data = $this->e233_data_ano."-".$this->e233_data_mes."-".$this->e233_data_dia;
                }
            }
            $this->e233_hora = ($this->e233_hora == ""?@$GLOBALS["HTTP_POST_VARS"]["e233_hora"]:$this->e233_hora);
        }else{
            $this->e233_sequencial = ($this->e233_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["e233_sequencial"]:$this->e233_sequencial);
        }
    }
    // funcao para inclusao
    function incluir ($e233_sequencial){
        $this->atualizacampos();
        if($this->e233_codproc == null ){
            $this->erro_sql = " Campo Cod Processo de Compra nao Informado.";
            $this->erro_campo = "e233_codproc";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->e233_id_usuario == null ){
            $this->erro_sql = " Campo Cod Usuario nao Informado.";
            $this->erro_campo = "e233_id_usuario";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->e233_data == null ){
            $this->erro_sql = " Campo Data nao Informado.";
            $this->erro_campo = "e233_data_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->e233_hora == null ){
            $this->erro_sql = " Campo Hora nao Informado.";
            $this->erro_campo = "e233_hora";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($e233_sequencial == "" || $e233_sequencial == null ){
            $result = db_query("select nextval('contint_e233_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: contint_e233_sequencial_seq do campo: e233_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->e233_sequencial = pg_result($result,0,0);
        }else{
            $result = db_query("select last_value from contint_e233_sequencial_seq");
            if(($result != false) && (pg_result($result,0,0) < $e233_sequencial)){
                $this->erro_sql = " Campo e233_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }else{
                $this->e233_sequencial = $e233_sequencial;
            }
        }
        if(($this->e233_sequencial == null) || ($this->e233_sequencial == "") ){
            $this->erro_sql = " Campo e233_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into pcprocliberado(
                                       e233_sequencial 
                                      ,e233_codproc 
                                      ,e233_id_usuario 
                                      ,e233_data 
                                      ,e233_hora 
                       )
                values (
                                $this->e233_sequencial 
                               ,$this->e233_codproc 
                               ,$this->e233_id_usuario 
                               ,".($this->e233_data == "null" || $this->e233_data == ""?"null":"'".$this->e233_data."'")." 
                               ,'$this->e233_hora' 
                      )";
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                $this->erro_sql   = "Processo de Compra Liberado ($this->e233_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Processo de Compra Liberado já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }else{
                $this->erro_sql   = "Processo de Compra Liberado ($this->e233_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->e233_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
    }
    // funcao para alteracao
    function alterar ($e233_sequencial=null) {
        $this->atualizacampos();
        $sql = " update empautorizliberada set ";
        $virgula = "";
        if(trim($this->e233_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e233_sequencial"])){
            $sql  .= $virgula." e233_sequencial = $this->e233_sequencial ";
            $virgula = ",";
            if(trim($this->e233_sequencial) == null ){
                $this->erro_sql = " Campo Sequencial nao Informado.";
                $this->erro_campo = "e233_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->e233_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e233_codproc"])){
            $sql  .= $virgula." e233_codproc = $this->e233_codproc ";
            $virgula = ",";
            if(trim($this->e233_codproc) == null ){
                $this->erro_sql = " Campo Numero Autorizacao nao Informado.";
                $this->erro_campo = "e233_codproc";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->e233_id_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e233_id_usuario"])){
            $sql  .= $virgula." e233_id_usuario = $this->e233_id_usuario ";
            $virgula = ",";
            if(trim($this->e233_id_usuario) == null ){
                $this->erro_sql = " Campo Cod Usuario nao Informado.";
                $this->erro_campo = "e233_id_usuario";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->e233_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e233_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["e233_data_dia"] !="") ){
            $sql  .= $virgula." e233_data = '$this->e233_data' ";
            $virgula = ",";
            if(trim($this->e233_data) == null ){
                $this->erro_sql = " Campo Data nao Informado.";
                $this->erro_campo = "e233_data_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if(isset($GLOBALS["HTTP_POST_VARS"]["e233_data_dia"])){
                $sql  .= $virgula." e233_data = null ";
                $virgula = ",";
                if(trim($this->e233_data) == null ){
                    $this->erro_sql = " Campo Data nao Informado.";
                    $this->erro_campo = "e233_data_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if(trim($this->e233_hora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e233_hora"])){
            $sql  .= $virgula." e233_hora = '$this->e233_hora' ";
            $virgula = ",";
            if(trim($this->e233_hora) == null ){
                $this->erro_sql = " Campo Hora nao Informado.";
                $this->erro_campo = "e233_hora";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        if($e233_sequencial!=null){
            $sql .= " e233_sequencial = $this->e233_sequencial";
        }
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Processo de Compra Liberado nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->e233_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Processo de Compra Liberado nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->e233_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->e233_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir ($e233_sequencial=null,$dbwhere=null) {

        $sql = " delete from pcprocliberado
                    where ";
        $sql2 = "";
        if($dbwhere==null || $dbwhere ==""){
            if($e233_sequencial != ""){
                if($sql2!=""){
                    $sql2 .= " and ";
                }
                $sql2 .= " e233_sequencial = $e233_sequencial ";
            }
        }else{
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Processo de Compra Liberado nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$e233_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Processo de Compra Liberado nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$e233_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$e233_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:pcprocliberado";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql
    function sql_query ( $e233_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from pcprocliberado ";
        $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = pcprocliberado.e233_id_usuario";
        $sql .= "      inner join pcproc  on  pcproc.pc80_codproc = pcprocliberado.e233_codproc ";
        $sql2 = "";
        if($dbwhere==""){
            if($e233_sequencial!=null ){
                $sql2 .= " where pcprocliberado.e233_sequencial = $e233_sequencial ";
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
    function sql_query_file ( $e233_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from pcprocliberado ";
        $sql2 = "";
        if($dbwhere==""){
            if($e233_sequencial!=null ){
                $sql2 .= " where pcprocliberado.e233_sequencial = $e233_sequencial ";
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

    function liberarProcessoCompra ($aProcCompras) {

        if (!db_utils::inTransaction()) {
            throw new Exception('Nao existe transação com o banco de dados ativa.');
        }

        foreach ($aProcCompras as $oProcCompra) {

            $sCampos = "pcprocliberado.*";
            $sWhere  = "e233_codproc = {$oProcCompra->iNumProc}";

            $sSqlProcCompraLiberado  = $this->sql_query( null,$sCampos,null, $sWhere);
            $rsSqlProcCompraLiberado = $this->sql_record($sSqlProcCompraLiberado);

            if ($oProcCompra->lLiberar) {

                if ($this->numrows == 0) {

                    $this->e233_codproc     = $oProcCompra->iNumProc;
                    $this->e233_id_usuario = db_getsession('DB_id_usuario');
                    $this->e233_data       = date("Y-m-d", db_getsession("DB_datausu"));
                    $this->e233_hora       = db_hora();
                    $this->incluir(null);
                    if ( $this->erro_status == 0 ){
                        throw new Exception($this->erro_msg);
                    }

                }

            } else {
                if ($this->numrows > 0) {

                    $oAutorizacoesLiberadas = db_utils::fieldsMemory($rsSqlProcCompraLiberado,0);

                    $this->excluir($oAutorizacoesLiberadas->e233_sequencial);
                    if ( $this->erro_status == 0 ){
                        throw new Exception($this->erro_msg);
                    }
                }

            }

        }
    }
}
?>