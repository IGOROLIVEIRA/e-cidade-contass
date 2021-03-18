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

//MODULO: licitação
//CLASSE DA ENTIDADE pccfeditalnum
class cl_pccfeditalnum {
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
   var $l47_instit = 0;
   var $l47_anousu = 0;
   var $l47_numero = 0;
   var $l47_timestamp = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 l47_instit = int4 = instituicao 
                 l47_anousu = int4 = Ano 
                 l47_numero = int8 = Numeração 
                 l47_timestamp = timestamp = Timestamp
                 ";
   //funcao construtor da classe
   function cl_pccfeditalnum() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("pccfeditalnum");
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
       $this->l47_instit = ($this->l47_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["l47_instit"]:$this->l47_instit);
       $this->l47_anousu = ($this->l47_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["l47_anousu"]:$this->l47_anousu);
       $this->l47_numero = ($this->l47_numero == ""?@$GLOBALS["HTTP_POST_VARS"]["l47_numero"]:$this->l47_numero);
       $this->l47_timestamp = ($this->l47_timestamp == ""?@$GLOBALS["HTTP_POST_VARS"]["l47_timestamp"]:$this->l47_timestamp);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();
     if($this->l47_instit == null ){
       $this->erro_sql = " Campo Instituição não Informado.";
       $this->erro_campo = "l47_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l47_anousu == null ){
       $this->erro_sql = " Campo Ano não Informado.";
       $this->erro_campo = "l47_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l47_numero == null ){
       $this->erro_sql = " Campo Numeração nao Informado.";
       $this->erro_campo = "l47_numero";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(!$this->l47_timestamp || $this->l47_timestamp == null){
        $this->l47_timestamp = "to_timestamp(now()::varchar, 'YYYY-MM-DD HH24:mi:ss')::timestamp without time zone";
     }
     $sql = "insert into pccfeditalnum(
                                       l47_instit 
                                      ,l47_anousu 
                                      ,l47_numero
                                      ,l47_timestamp
                       )
                values (
                                $this->l47_instit 
                               ,$this->l47_anousu 
                               ,$this->l47_numero
                               ,$this->l47_timestamp
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "pccfeditalnum () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "pccfeditalnum já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "pccfeditalnum () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   }
   // funcao para alteracao
   function alterar ( $l47_numero=null, $dbwhere=null ) {
      $this->atualizacampos();
     $sql = " update pccfeditalnum set ";
     $virgula = "";
     if(trim($this->l47_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l47_instit"])){
       $sql  .= $virgula." l47_instit = $this->l47_instit ";
       $virgula = ",";
       if(trim($this->l47_instit) == null ){
         $this->erro_sql = " Campo instituicao nao Informado.";
         $this->erro_campo = "l47_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l47_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l47_anousu"])){
       $sql  .= $virgula." l47_anousu = $this->l47_anousu ";
       $virgula = ",";
       if(trim($this->l47_anousu) == null ){
         $this->erro_sql = " Campo Ano nao Informado.";
         $this->erro_campo = "l47_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l47_numero)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l47_numero"])){
       $sql  .= $virgula." l47_numero = $this->l47_numero ";
       $virgula = ",";
       if(trim($this->l47_numero) == null ){
         $this->erro_sql = " Campo Numeração nao Informado.";
         $this->erro_campo = "l47_numero";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }

      if(!$this->l47_timestamp || !isset($GLOBALS["HTTP_POST_VARS"]["l47_timestamp"])){
          $sql .= $virgula." l47_timestamp = to_timestamp(now()::varchar, 'YYYY-MM-DD HH24:mi:ss')::timestamp without time zone ";
      }

     $sql .= " where ";
     $sql2 = "";
     if($dbwhere == null || !$dbwhere){
       $sql2 = " l47_numero = $l47_numero";
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "pccfeditalnum nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "pccfeditalnum nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ( $oid=null ,$dbwhere=null) {
     $sql = " delete from pccfeditalnum
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
       $sql2 = "oid = '$oid'";
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "pccfeditalnum nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "pccfeditalnum nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:pccfeditalnum";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function alterar_where ( $oid=null,$dbwhere="" ) {
      $this->atualizacampos();
     $sql = " update pccfeditalnum set ";
     $virgula = "";
     if(trim($this->l47_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l47_instit"])){
       $sql  .= $virgula." l47_instit = $this->l47_instit ";
       $virgula = ",";
       if(trim($this->l47_instit) == null ){
         $this->erro_sql = " Campo instituicao nao Informado.";
         $this->erro_campo = "l47_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l47_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l47_anousu"])){
       $sql  .= $virgula." l47_anousu = $this->l47_anousu ";
       $virgula = ",";
       if(trim($this->l47_anousu) == null ){
         $this->erro_sql = " Campo Ano nao Informado.";
         $this->erro_campo = "l47_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l47_numero)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l47_numero"])){
       $sql  .= $virgula." l47_numero = $this->l47_numero ";
       $virgula = ",";
       if(trim($this->l47_numero) == null ){
         $this->erro_sql = " Campo Numeração nao Informado.";
         $this->erro_campo = "l47_numero";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($dbwhere==""){
       if( $oid != "" && $oid != null){
       	  $sql .= " where ";
          $sql .= "oid = '$oid'";
       }
     }else if($dbwhere != ""){
       $sql .= " where $dbwhere";
     }

     $result = @pg_exec($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "pccfeditalnum nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "pccfeditalnum nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   
    function sql_query ( $sequencial = null, $campos="*", $ordem=null, $dbwhere=""){

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

        $sql .= " from pccfeditalnum ";
        $sql .= "      inner join db_config  on  db_config.codigo = pccfeditalnum.l47_instit";
        $sql2 = "";
        
        if($dbwhere==""){
            if( $sequencial != "" && $sequencial != null){
                $sql2 = " where pccfeditalnum.sequencial = '$sequencial'";
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
    function sql_query_file ( $sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     
        $sql .= " from pccfeditalnum ";
        $sql2 = "";

        if($dbwhere != ""){
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

   function sql_query_numero_geral ($anousu,$instit,$campos="",$ordem=null,$dbwhere=""){
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
     $sql .= " max (l20_numero) as num_licita from ( select l20_codigo,l20_codtipocom,l20_numero,l20_datacria,l20_instit from liclicita where l20_instit=$instit and l20_codtipocom in (select l03_codigo from cflicita where l03_codigo not in (select l03_codigo from cflicita inner join pccflicitapar on l25_codcflicita=l03_codigo and l25_anousu=$anousu)) and extract (year from l20_datacria)=$anousu ) as x  ";

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


function sql_query_edital( $oid = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from pccfeditalnum ";
     $sql .= " inner join liclicita     on liclicita.l20_nroedital          = pccfeditalnum.l47_numero ";
     $sql .= " inner join pccflicitapar on pccflicitapar.l25_codcflicita = liclicita.l20_codtipocom ";
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




}
?>
