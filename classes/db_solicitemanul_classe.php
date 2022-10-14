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

//MODULO: empenho
//CLASSE DA ENTIDADE solicitemanul
class cl_solicitemanul { 
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
   var $pc28_sequencial = 0; 
   var $pc28_empempitem = 0; 
   var $pc28_solicitem = 0; 
   var $pc28_vlranu = 0; 
   var $pc28_qtd = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 pc28_sequencial = int4 = Código Sequencial 
                 pc28_solicitem = int4 = Código da Solicitação 
                 pc28_vlranu = float4 = Valor Anulado 
                 pc28_qtd = float4 = Quantidade Anulada 
                 ";
   //funcao construtor da classe 
   function cl_solicitemanul() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("solicitemanul"); 
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
       $this->pc28_sequencial = ($this->pc28_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["pc28_sequencial"]:$this->pc28_sequencial);
       $this->pc28_solicitem = ($this->pc28_solicitem == ""?@$GLOBALS["HTTP_POST_VARS"]["pc28_solicitem"]:$this->pc28_solicitem);
       $this->pc28_vlranu = ($this->pc28_vlranu == ""?@$GLOBALS["HTTP_POST_VARS"]["pc28_vlranu"]:$this->pc28_vlranu);
       $this->pc28_qtd = ($this->pc28_qtd == ""?@$GLOBALS["HTTP_POST_VARS"]["pc28_qtd"]:$this->pc28_qtd);
     }else{
       $this->pc28_sequencial = ($this->pc28_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["pc28_sequencial"]:$this->pc28_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($pc28_sequencial){ 
      $this->atualizacampos();
     if($this->pc28_solicitem == null ){ 
       $this->erro_sql = " Campo Código do Item na Solicitação nao Informado.";
       $this->erro_campo = "pc28_solicitem";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->pc28_vlranu == null ){ 
       $this->erro_sql = " Valor Anulado nao Informado.";
       $this->erro_campo = "pc28_vlranu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->pc28_qtd == null ){ 
        $this->erro_sql = " Quantidade Anulada nao Informada.";
        $this->erro_campo = "pc28_qtd";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
     }
     if($pc28_sequencial == "" || $pc28_sequencial == null ){
       $result = db_query("select nextval('solicitemanul_pc28_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: solicitemanul_pc28_sequencial_seq do campo: pc28_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->pc28_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from solicitemanul_pc28_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $pc28_sequencial)){
         $this->erro_sql = " Campo pc28_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->pc28_sequencial = $pc28_sequencial; 
       }
     }
     if(($this->pc28_sequencial == null) || ($this->pc28_sequencial == "") ){ 
       $this->erro_sql = " Campo pc28_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into solicitemanul(
                                       pc28_sequencial 
                                      ,pc28_solicitem 
                                      ,pc28_vlranu 
                                      ,pc28_qtd 
                       )
                values (
                                $this->pc28_sequencial 
                               ,$this->pc28_solicitem 
                               ,$this->pc28_vlranu 
                               ,$this->pc28_qtd 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Itens da solicitação ($this->pc28_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Itens da solicitação já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Itens da solicitação ($this->pc28_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc28_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->pc28_sequencial));

     return true;
   } 
   // funcao para alteracao
   function alterar ($pc28_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update solicitemanul set ";
     $virgula = "";
     if(trim($this->pc28_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc28_sequencial"])){ 
       $sql  .= $virgula." pc28_sequencial = $this->pc28_sequencial ";
       $virgula = ",";
       if(trim($this->pc28_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "pc28_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc28_solicitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc28_solicitem"])){ 
       $sql  .= $virgula." pc28_solicitem = $this->pc28_solicitem ";
       $virgula = ",";
       if(trim($this->pc28_solicitem) == null ){ 
         $this->erro_sql = " Campo Código do Item da Solicitação nao Informado.";
         $this->erro_campo = "pc28_solicitem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc28_vlranu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc28_vlranu"])){ 
       $sql  .= $virgula." pc28_vlranu = $this->pc28_vlranu ";
       $virgula = ",";
       if(trim($this->pc28_vlranu) == null ){ 
         $this->erro_sql = " Campo Valor Anulado nao Informado.";
         $this->erro_campo = "pc28_vlranu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc28_qtd)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc28_qtd"])){ 
        if(trim($this->pc28_qtd)=="" && isset($GLOBALS["HTTP_POST_VARS"]["pc28_qtd"])){ 
           $this->pc28_qtd = "0" ; 
        } 
       $sql  .= $virgula." pc28_qtd = $this->pc28_qtd ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($pc28_sequencial!=null){
       $sql .= " pc28_sequencial = $this->pc28_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->pc28_sequencial));

     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Itens da solicitação nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc28_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Itens da solicitação nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc28_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc28_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($pc28_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($pc28_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,10911,'$pc28_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,1883,10911,'','".AddSlashes(pg_result($resaco,$iresaco,'pc28_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1883,10912,'','".AddSlashes(pg_result($resaco,$iresaco,'pc28_empempitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1883,10913,'','".AddSlashes(pg_result($resaco,$iresaco,'pc28_solicitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1883,10914,'','".AddSlashes(pg_result($resaco,$iresaco,'pc28_vlranu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1883,10969,'','".AddSlashes(pg_result($resaco,$iresaco,'pc28_qtd'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from solicitemanul
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($pc28_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " pc28_sequencial = $pc28_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Itens da solicitação nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$pc28_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Itens da solicitação nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$pc28_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$pc28_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:solicitemanul";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query ( $pc28_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from solicitemanul ";
     $sql .= "      inner join solicitem on solicitem.pc11_codigo = solicitemanul.pc28_solicitem";
     $sql2 = "";
     if($dbwhere==""){
       if($pc28_sequencial!=null ){
         $sql2 .= " where solicitemanul.pc28_sequencial = $pc28_sequencial "; 
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
   function sql_query_file ( $pc28_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from solicitemanul ";
     $sql2 = "";
     if($dbwhere==""){
       if($pc28_sequencial!=null ){
         $sql2 .= " where solicitemanul.pc28_sequencial = $pc28_sequencial "; 
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
}
?>