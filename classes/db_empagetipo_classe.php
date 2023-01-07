<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

//MODULO: Empenho
//CLASSE DA ENTIDADE empagetipo
class cl_empagetipo {
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
   var $e83_codtipo = 0;
   var $e83_descr = null;
   var $e83_conta = 0;
   var $e83_codmod = 0;
   var $e83_convenio = null;
   var $e83_sequencia = 0;
   var $e83_codigocompromisso = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 e83_codtipo = int4 = Tipo
                 e83_descr = varchar(60) = Descrição
                 e83_conta = int4 = Código Conta
                 e83_codmod = int4 = Modelo
                 e83_convenio = varchar(20) = Convenio
                 e83_sequencia = int4 = Seq. Cheque
                 e83_codigocompromisso = varchar(4) = Código do Compromisso
                 ";
   //funcao construtor da classe
   function cl_empagetipo() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("empagetipo");
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
       $this->e83_codtipo = ($this->e83_codtipo == ""?@$GLOBALS["HTTP_POST_VARS"]["e83_codtipo"]:$this->e83_codtipo);
       $this->e83_descr = ($this->e83_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["e83_descr"]:$this->e83_descr);
       $this->e83_conta = ($this->e83_conta == ""?@$GLOBALS["HTTP_POST_VARS"]["e83_conta"]:$this->e83_conta);
       $this->e83_codmod = ($this->e83_codmod == ""?@$GLOBALS["HTTP_POST_VARS"]["e83_codmod"]:$this->e83_codmod);
       $this->e83_convenio = ($this->e83_convenio == ""?@$GLOBALS["HTTP_POST_VARS"]["e83_convenio"]:$this->e83_convenio);
       $this->e83_sequencia = ($this->e83_sequencia == ""?@$GLOBALS["HTTP_POST_VARS"]["e83_sequencia"]:$this->e83_sequencia);
       $this->e83_codigocompromisso = ($this->e83_codigocompromisso == ""?@$GLOBALS["HTTP_POST_VARS"]["e83_codigocompromisso"]:$this->e83_codigocompromisso);
     }else{
       $this->e83_codtipo = ($this->e83_codtipo == ""?@$GLOBALS["HTTP_POST_VARS"]["e83_codtipo"]:$this->e83_codtipo);
     }
   }
   // funcao para inclusao
   function incluir ($e83_codtipo){
      $this->atualizacampos();
     if($this->e83_descr == null ){
       $this->erro_sql = " Campo Descrição nao Informado.";
       $this->erro_campo = "e83_descr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e83_conta == null ){
       $this->erro_sql = " Campo Código Conta nao Informado.";
       $this->erro_campo = "e83_conta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e83_codmod == null ){
       $this->erro_sql = " Campo Modelo nao Informado.";
       $this->erro_campo = "e83_codmod";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e83_convenio == null ){
       $this->erro_sql = " Campo Convenio nao Informado.";
       $this->erro_campo = "e83_convenio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e83_sequencia == null ){
       $this->erro_sql = " Campo Seq. Cheque nao Informado.";
       $this->erro_campo = "e83_sequencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($e83_codtipo == "" || $e83_codtipo == null ){
       $result = db_query("select nextval('empagetipo_e83_codtipo_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: empagetipo_e83_codtipo_seq do campo: e83_codtipo";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->e83_codtipo = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from empagetipo_e83_codtipo_seq");
       if(($result != false) && (pg_result($result,0,0) < $e83_codtipo)){
         $this->erro_sql = " Campo e83_codtipo maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->e83_codtipo = $e83_codtipo;
       }
     }
     if(($this->e83_codtipo == null) || ($this->e83_codtipo == "") ){
       $this->erro_sql = " Campo e83_codtipo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->setSequenciaCheque($this->e83_conta);
     $sql = "insert into empagetipo(
                                       e83_codtipo
                                      ,e83_descr
                                      ,e83_conta
                                      ,e83_codmod
                                      ,e83_convenio
                                      ,e83_sequencia
                                      ,e83_codigocompromisso
                       )
                values (
                                $this->e83_codtipo
                               ,'$this->e83_descr'
                               ,$this->e83_conta
                               ,$this->e83_codmod
                               ,'$this->e83_convenio'
                               ,$this->e83_sequencia
                               ,'$this->e83_codigocompromisso'
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Tipo agenda ($this->e83_codtipo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Tipo agenda já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Tipo agenda ($this->e83_codtipo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->e83_codtipo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->e83_codtipo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,6179,'$this->e83_codtipo','I')");
       $resac = db_query("insert into db_acount values($acount,997,6179,'','".AddSlashes(pg_result($resaco,0,'e83_codtipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,997,6180,'','".AddSlashes(pg_result($resaco,0,'e83_descr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,997,6181,'','".AddSlashes(pg_result($resaco,0,'e83_conta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,997,6182,'','".AddSlashes(pg_result($resaco,0,'e83_codmod'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,997,6199,'','".AddSlashes(pg_result($resaco,0,'e83_convenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,997,6200,'','".AddSlashes(pg_result($resaco,0,'e83_sequencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,997,15012,'','".AddSlashes(pg_result($resaco,0,'e83_codigocompromisso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($e83_codtipo=null) {
      $this->atualizacampos();
     $sql = " update empagetipo set ";
     $virgula = "";
     if(trim($this->e83_codtipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e83_codtipo"])){
       $sql  .= $virgula." e83_codtipo = $this->e83_codtipo ";
       $virgula = ",";
       if(trim($this->e83_codtipo) == null ){
         $this->erro_sql = " Campo Tipo nao Informado.";
         $this->erro_campo = "e83_codtipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e83_descr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e83_descr"])){
       $sql  .= $virgula." e83_descr = '$this->e83_descr' ";
       $virgula = ",";
       if(trim($this->e83_descr) == null ){
         $this->erro_sql = " Campo Descrição nao Informado.";
         $this->erro_campo = "e83_descr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e83_conta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e83_conta"])){
       $sql  .= $virgula." e83_conta = $this->e83_conta ";
       $virgula = ",";
       if(trim($this->e83_conta) == null ){
         $this->erro_sql = " Campo Código Conta nao Informado.";
         $this->erro_campo = "e83_conta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e83_codmod)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e83_codmod"])){
       $sql  .= $virgula." e83_codmod = $this->e83_codmod ";
       $virgula = ",";
       if(trim($this->e83_codmod) == null ){
         $this->erro_sql = " Campo Modelo nao Informado.";
         $this->erro_campo = "e83_codmod";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e83_convenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e83_convenio"])){
       $sql  .= $virgula." e83_convenio = '$this->e83_convenio' ";
       $virgula = ",";
       if(trim($this->e83_convenio) == null ){
         $this->erro_sql = " Campo Convenio nao Informado.";
         $this->erro_campo = "e83_convenio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e83_sequencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e83_sequencia"])){
       $sql  .= $virgula." e83_sequencia = $this->e83_sequencia ";
       $virgula = ",";
       if(trim($this->e83_sequencia) == null ){
         $this->erro_sql = " Campo Seq. Cheque nao Informado.";
         $this->erro_campo = "e83_sequencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e83_codigocompromisso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e83_codigocompromisso"])){
       $sql  .= $virgula." e83_codigocompromisso = '$this->e83_codigocompromisso' ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($e83_codtipo!=null){
       $sql .= " e83_codtipo = $this->e83_codtipo";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->e83_codtipo));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,6179,'$this->e83_codtipo','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e83_codtipo"]) || $this->e83_codtipo != "")
           $resac = db_query("insert into db_acount values($acount,997,6179,'".AddSlashes(pg_result($resaco,$conresaco,'e83_codtipo'))."','$this->e83_codtipo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e83_descr"]) || $this->e83_descr != "")
           $resac = db_query("insert into db_acount values($acount,997,6180,'".AddSlashes(pg_result($resaco,$conresaco,'e83_descr'))."','$this->e83_descr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e83_conta"]) || $this->e83_conta != "")
           $resac = db_query("insert into db_acount values($acount,997,6181,'".AddSlashes(pg_result($resaco,$conresaco,'e83_conta'))."','$this->e83_conta',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e83_codmod"]) || $this->e83_codmod != "")
           $resac = db_query("insert into db_acount values($acount,997,6182,'".AddSlashes(pg_result($resaco,$conresaco,'e83_codmod'))."','$this->e83_codmod',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e83_convenio"]) || $this->e83_convenio != "")
           $resac = db_query("insert into db_acount values($acount,997,6199,'".AddSlashes(pg_result($resaco,$conresaco,'e83_convenio'))."','$this->e83_convenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e83_sequencia"]) || $this->e83_sequencia != "")
           $resac = db_query("insert into db_acount values($acount,997,6200,'".AddSlashes(pg_result($resaco,$conresaco,'e83_sequencia'))."','$this->e83_sequencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["e83_codigocompromisso"]) || $this->e83_codigocompromisso != "")
           $resac = db_query("insert into db_acount values($acount,997,15012,'".AddSlashes(pg_result($resaco,$conresaco,'e83_codigocompromisso'))."','$this->e83_codigocompromisso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $this->setSequenciaCheque($this->e83_conta);
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Tipo agenda nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->e83_codtipo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Tipo agenda nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->e83_codtipo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->e83_codtipo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($e83_codtipo=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($e83_codtipo));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,6179,'$e83_codtipo','E')");
         $resac = db_query("insert into db_acount values($acount,997,6179,'','".AddSlashes(pg_result($resaco,$iresaco,'e83_codtipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,997,6180,'','".AddSlashes(pg_result($resaco,$iresaco,'e83_descr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,997,6181,'','".AddSlashes(pg_result($resaco,$iresaco,'e83_conta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,997,6182,'','".AddSlashes(pg_result($resaco,$iresaco,'e83_codmod'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,997,6199,'','".AddSlashes(pg_result($resaco,$iresaco,'e83_convenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,997,6200,'','".AddSlashes(pg_result($resaco,$iresaco,'e83_sequencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,997,15012,'','".AddSlashes(pg_result($resaco,$iresaco,'e83_codigocompromisso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from empagetipo
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($e83_codtipo != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " e83_codtipo = $e83_codtipo ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Tipo agenda nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$e83_codtipo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Tipo agenda nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$e83_codtipo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$e83_codtipo;
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
        $this->erro_sql   = "Record Vazio na Tabela:empagetipo";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $e83_codtipo=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from empagetipo ";
     $sql .= "      inner join saltes  on  saltes.k13_conta = empagetipo.e83_conta";
     $sql .= "      inner join empagemod  on  empagemod.e84_codmod = empagetipo.e83_codmod";
     $sql .= "      inner join conplanoreduz on saltes.k13_reduz = conplanoreduz.c61_reduz and conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . " and conplanoreduz.c61_instit = " . db_getsession("DB_instit");
     $sql2 = "";
     if($dbwhere==""){
       if($e83_codtipo!=null ){
         $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
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
   function sql_query_file ( $e83_codtipo=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from empagetipo ";
     $sql2 = "";
     if($dbwhere==""){
       if($e83_codtipo!=null ){
         $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
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
   function getMaxCheque($iConta) {

    if (!class_exists("db_utils")) {
      require_once("libs/db_utils.php");
    }
    if ($iConta == '' ) {

      return false;
    }
    $iAnoUsu = db_getsession("DB_anousu");
    $iInstit = db_getsession("DB_instit");
    $sql     = "SELECT c63_agencia , ";
    $sql    .= "       c63_conta,    ";
    $sql    .= "       c63_banco     ";
    $sql    .= "  from conplanoconta ";
    $sql    .= "       inner join conplanoreduz on c61_codcon = c63_codcon ";
    $sql    .= "                               and c61_anousu = c63_anousu";
    $sql    .= "       inner join saltes        on k13_reduz  = c61_reduz";
    $sql    .= " where c61_anousu = {$iAnoUsu} ";
    $sql    .= "   and c61_instit = {$iInstit} ";
    $sql    .= "   and k13_conta  = {$iConta}";
    $rsConta = $this->sql_record($sql);
    if ($this->numrows > 0) {

      $oContas = db_utils::fieldsMemory($rsConta, 0);
      $sSqlAgenciasConta  = "SELECT max(e83_sequencia) as total ";
      $sSqlAgenciasConta .= "  from conplanoconta ";
      $sSqlAgenciasConta .= "       inner join conplanoreduz on c61_codcon = c63_codcon ";
      $sSqlAgenciasConta .= "                               and c61_anousu = c63_anousu";
      $sSqlAgenciasConta .= "       inner join saltes     on c61_reduz = k13_reduz ";
      $sSqlAgenciasConta .= "       inner join empagetipo on k13_conta = e83_conta ";
      $sSqlAgenciasConta .= " where c63_anousu  = {$iAnoUsu}";
      $sSqlAgenciasConta .= "   and trim(c63_agencia) = '{$oContas->c63_agencia}'";
      $sSqlAgenciasConta .= "   and trim(c63_conta)   = '{$oContas->c63_conta}'";
      $sSqlAgenciasConta .= "   and trim(c63_banco)   = '{$oContas->c63_banco}'";
      $sSqlAgenciasConta .= "   and c63_anousu  = {$iAnoUsu}";
      $rsAgencias         = $this->sql_record($sSqlAgenciasConta);
      if ($this->numrows > 0) {

        $oCheque = db_utils::fieldsMemory($rsAgencias, 0);
        return $oCheque->total;

      }
    }
  }
   function setSequenciaCheque($iConta) {

    if (!class_exists("db_utils")) {
      require_once("libs/db_utils.php");
    }
    if ($iConta == '' ) {

      $sql    = "select e83_conta from empagetipo where e83_codtipo = {$this->e83_codtipo}";
      $rs     = pg_query($sql);
      $iConta = pg_result($rs,0,"e83_conta");
    }
    $iAnoUsu = db_getsession("DB_anousu");
    $iInstit = db_getsession("DB_instit");
    $sql     = "SELECT c63_agencia , ";
    $sql    .= "       c63_conta,    ";
    $sql    .= "       c63_banco     ";
    $sql    .= "  from conplanoconta ";
    $sql    .= "       inner join conplanoreduz on c61_codcon = c63_codcon ";
    $sql    .= "                                and c61_anousu = c63_anousu";
    $sql    .= " where c61_anousu = {$iAnoUsu} ";
    $sql    .= "   and c61_instit = {$iInstit} ";
    $sql    .= "   and c61_reduz  = {$iConta}";
    $rsConta = $this->sql_record($sql);
    if ($this->numrows > 0) {

      $oContas = db_utils::fieldsMemory($rsConta, 0);
      $sSqlAgenciasConta  = "SELECT * ";
      $sSqlAgenciasConta .= "  from conplanoconta ";
      $sSqlAgenciasConta .= "       inner join conplanoreduz on c61_codcon = c63_codcon ";
      $sSqlAgenciasConta .= "                               and c61_anousu = c63_anousu";
      $sSqlAgenciasConta .= " where c63_anousu  = {$iAnoUsu}";
      $sSqlAgenciasConta .= "   and trim(c63_agencia) = '{$oContas->c63_agencia}'";
      $sSqlAgenciasConta .= "   and trim(c63_conta)   = '{$oContas->c63_conta}'";
      $sSqlAgenciasConta .= "   and trim(c63_banco)   = '{$oContas->c63_banco}'";
      $rsAgencias         = $this->sql_record($sSqlAgenciasConta);
      if ($this->numrows > 0) {

        $iTotAgencias = $this->numrows;
        for ($iInd = 0; $iInd < $iTotAgencias; $iInd++) {

          $oAgencia = db_utils::fieldsMemory($rsAgencias, $iInd);
          $rsUpdate  = pg_query("update empagetipo set e83_sequencia = {$this->e83_sequencia} where e83_conta = {$oAgencia->c61_reduz}");

          if (!$rsUpdate) {

            $this->erro_msg = "erro ao Atualizar numeracao do cheque";
            return false;
          }

        }
      }
    }
  }
   function sql_query_conplano ( $e83_codtipo=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from empagetipo ";
    $sql .= " 	    inner join saltes on k13_conta = e83_conta ";
    $sql .= " 	    inner join conplanoreduz on c61_reduz = k13_reduz and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit=".db_getsession("DB_instit");
    $sql .= " 	    inner join conplano on c60_codcon = c61_codcon and c60_anousu = c61_anousu ";
    $sql2 = "";
    if($dbwhere==""){
      if($e83_codtipo!=null ){
        $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
      }
    }else if($dbwhere != ""){
      $sql2 = " where $dbwhere";
    }
    $sql2 .= ($sql2!=""?" and ":" where ") . " c61_instit = " . db_getsession("DB_instit");
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
   function sql_query_conplanoconta ( $e83_codtipo=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from empagetipo ";
    $sql .= " 	    inner join saltes on k13_conta = e83_conta ";
    $sql .= " 	    inner join conplanoreduz on c61_reduz = k13_reduz and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit=".db_getsession("DB_instit");
    $sql .= " 	    inner join conplano on c60_codcon = c61_codcon and c60_anousu = c61_anousu ";
    $sql .= " 	    inner join conplanoconta on c60_codcon = c63_codcon and c60_anousu = c63_anousu ";
    $sql2 = "";
    if($dbwhere==""){
      if($e83_codtipo!=null ){
        $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
      }
    }else if($dbwhere != ""){
      $sql2 = " where $dbwhere";
    }
    $sql2 .= ($sql2!=""?" and ":" where ") . " c61_instit = " . db_getsession("DB_instit");
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
   function sql_query_conta ($e83_codtipo=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from pagordem  ";
    $sql .= "  inner join empagemov  on e81_numemp  = e50_numemp ";
    $sql .= "  inner join empagepag  on e85_codmov  = e81_codmov";
    $sql .= "  inner join empagetipo on e83_codtipo = e85_codtipo";
    $sql2 = "";
    if($dbwhere==""){
      if($e83_codtipo!=null ){
        $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
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
   function sql_query_contapaga ( $e83_codtipo=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from empagetipo ";
    $sql .= "      inner join saltes     on  saltes.k13_conta = empagetipo.e83_conta";
    $sql .= " 	    inner join conplanoreduz on c61_reduz = saltes.k13_reduz and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit=".db_getsession("DB_instit");
    $sql2 = "";
    if($dbwhere==""){
      if($e83_codtipo!=null ){
        $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
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
   function sql_query_contas_vinculadas ($e83_codtipo = null, $campos = "*", $ordem = null, $sWhere, $lVinculadas = false, 
                                        $op = null, $lSomenteCorrente = false, $lContaUnicaFundeb = false, $sWhere2 = null,
                                        $numemp = null) {

   $sSql = "select ";
    if($campos != "*" ){
      $campos_sql = explode("#",$campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sSql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }else{
      $sSql .= $campos;
    }
    /* PARA ATENDER A Portaria n° 3992/GM/MS/2017 DO MINISTERIO DA SAÚDE. QUE PERMITE PAGAMENTO DESTAS FONTES COM A MESMA CONTA BANCARIA */
    /* Acrescentado fonte 159 e 259 para atender alterações do TCE/MG a partir de 2020 */
    $iAnoUsu = db_getsession("DB_anousu");
    $aFontes = array('148','149','150','151','152', '159', '248','249','250','251','252', '259');
    $sqlFonteEmp = " select o15_codtri from empempenho ";
    if($iAnoUsu>2022){
        $aFontes = array('148','149','150','151','152', '159', '248','249','250','251','252', '259','16000000','16020000');
        $sqlFonteEmp = " select o15_codigo from empempenho ";
    }
    $sqlFonteEmp .= "   inner join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu ";    
    if ($op != null) {
        $sqlFonteEmp .= " inner join pagordem on e60_numemp=e50_numemp ";
    }    
    $sqlFonteEmp .= " inner join orctiporec on o58_codigo=o15_codigo ";
    if ($numemp != null) {
        $sqlFonteEmp .= " where e60_numemp = ".$numemp;    
    } else {
        $sqlFonteEmp .= " where e50_codord = ".$op;
    }    
    //ano empenho
    $sqlanoEmp = " select e60_anousu from empempenho ";
    $sqlanoEmp .= "   inner join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu ";    
    if ($op != null) {
        $sqlanoEmp .= " inner join pagordem on e60_numemp=e50_numemp ";
    }    
    $sqlanoEmp .= " inner join orctiporec on o58_codigo=o15_codigo ";
    if ($numemp != null) {
        $sqlanoEmp .= " where e60_numemp = ".$numemp;    
    } else {
        $sqlanoEmp .= " where e50_codord = ".$op;
    }    
    $rsResultFonteEmp = db_query($sqlFonteEmp);
    $iFonteEmpenho = db_utils::fieldsMemory($rsResultFonteEmp, 0)->o15_codtri;
    if($iAnoUsu > 2022)
      $iFonteEmpenho = db_utils::fieldsMemory($rsResultFonteEmp, 0)->o15_codigo;
    $rsResultAnoEmp = db_query($sqlanoEmp);
    $iAnoEmpenho = db_utils::fieldsMemory($rsResultAnoEmp, 0)->e60_anousu;
   
  if($iAnoUsu>2022){
      if(strlen($iFonteEmpenho) == 4)
         $iFonteEmpenho= substr($iFonteEmpenho,1,3);

      if(in_array($iFonteEmpenho,$aFontes) and db_getsession("DB_anousu") > 2017){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('148','149','150','151','152', '159', '248','249','250','251','252', '259')) and";
      $whereFonte2 = " ";
      return array($$whereFonte,$whereFonte2);
      } 
      elseif($iFonteEmpenho == '100' || $iFonteEmpenho == '200' || substr($iFonteEmpenho, 1, 7) == '5000000') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('100','200','15000000','25000000')) and";
      
      } 
      elseif($iFonteEmpenho == '101' || $iFonteEmpenho == '201' || substr($iFonteEmpenho, 1, 7) == '5000001') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('101','201','15000001','25000001')) and";
      
      } 
      elseif($iFonteEmpenho == '102' || $iFonteEmpenho == '202' || substr($iFonteEmpenho, 1, 7) == '5000002') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('102','202','15000002','25000002')) and";
      
      } 
      elseif($iFonteEmpenho == '103' || $iFonteEmpenho == '203' || substr($iFonteEmpenho,1,6) == '800000' ) {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('103','203','18000001','18000002','18000000','28000001','28000002','28000000') and";
      
      } 
      elseif($iFonteEmpenho == '104' || $iFonteEmpenho == '204' || substr($iFonteEmpenho, 1, 7) == '8010000') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('104','204','18010000','18010000')) and";
      
      } 
      elseif($iFonteEmpenho == '105' || $iFonteEmpenho == '205' || substr($iFonteEmpenho, 1, 7) == '8020000') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('105','205','103','18020000','18000000','18000001','18000002','28020000','28000000','28000001','28000002')) and";
      
      }
      elseif($iFonteEmpenho == '106' || $iFonteEmpenho == '206' || substr($iFonteEmpenho, 1, 7) == '5760010') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('106','206','15760010','25760010')) and";
      
      }
      elseif($iFonteEmpenho == '107' || $iFonteEmpenho == '207' || substr($iFonteEmpenho, 1, 7) == '5440000') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('107','207','15440000','25440000')) and";
      
      }
      elseif($iFonteEmpenho == '108' || $iFonteEmpenho == '208' || substr($iFonteEmpenho, 1, 7) == '7080000') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('108','208','17080000','27080000')) and";
      
      }
      elseif($iFonteEmpenho == '112' || $iFonteEmpenho == '212' || substr($iFonteEmpenho, 1, 7) == '6590020') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('112','212','16590020','26590020')) and";
      
      }
      elseif($iFonteEmpenho == '113' || $iFonteEmpenho == '213' || substr($iFonteEmpenho, 1, 7) == '5990030') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('113','213','15990030','25990030')) and";
      
      }
      elseif($iFonteEmpenho == '116' || $iFonteEmpenho == '216' || substr($iFonteEmpenho, 1, 7) == '7500000') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('116','216','17500000','27500000')) and";
      
      }
      elseif($iFonteEmpenho == '117' || $iFonteEmpenho == '217' || substr($iFonteEmpenho, 1, 7) == '7510000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('117','217','17510000','27510000','100','200','15000000','25000000')) and"; 
        
      }
      elseif($lContaUnicaFundeb && ($iFonteEmpenho == '118' || $iFonteEmpenho == '218' || $iFonteEmpenho == '119' || $iFonteEmpenho == '219' || $iFonteEmpenho == '166' || $iFonteEmpenho == '266' || $iFonteEmpenho == '167' || $iFonteEmpenho == '267')
      || substr($iFonteEmpenho, 1, 7) == '5400007' || substr($iFonteEmpenho, 1, 7) == '5400000' || substr($iFonteEmpenho, 1, 7) == '5420007' || substr($iFonteEmpenho, 1, 7) == '5420000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('118','218','119', '219', '166','167','266','267','15400007','15400000','15420007','15420000','25400007','25400000','25420007','25420000')) and";
      
      }
      elseif($iFonteEmpenho == '120' || $iFonteEmpenho == '220' || substr($iFonteEmpenho, 1, 7) == '5760000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('120','220','15760000','25760000')) and"; 
        
      }
      elseif($iFonteEmpenho == '121' || $iFonteEmpenho == '221' || substr($iFonteEmpenho, 1, 7) == '6220000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('121','221','16220000','26220000')) and"; 
        
      } 
      elseif($iFonteEmpenho == '122' || $iFonteEmpenho == '222' || substr($iFonteEmpenho, 1, 7) == '5700000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('122','222','15700000','25700000','171','122','15710000','25710000')) and"; 
        
      }
      elseif($iFonteEmpenho == '123' || $iFonteEmpenho == '223' || substr($iFonteEmpenho, 1, 7) == '6310000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('123','223','16310000','26310000','176','16320000','26320000')) and";
        
      }
      elseif($iFonteEmpenho == '124' || $iFonteEmpenho == '224' || substr($iFonteEmpenho, 1, 7) == '7000000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('124','224','17000000','27000000','181','17010000','27010000')) and";
        
      }
      elseif($iFonteEmpenho == '129' || $iFonteEmpenho == '229' || substr($iFonteEmpenho, 1, 7) == '6600000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('129','229','16600000','26600000')) and"; 
        
      }
      elseif($iFonteEmpenho == '130' || $iFonteEmpenho == '230' || substr($iFonteEmpenho, 1, 7) == '8990040'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('130','230','18990040','28990040')) and"; 
        
      }
      elseif($iFonteEmpenho == '131' || $iFonteEmpenho == '231' || substr($iFonteEmpenho, 1, 7) == '7590050'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('131','231','17590050','27590050')) and"; 
        
      } 
      elseif($iFonteEmpenho == '132' || $iFonteEmpenho == '232' || substr($iFonteEmpenho, 1, 7) == '6040000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('159','132','16040000','16000000','16020000','26040000','26000000','26020000')) and"; 
      
      }
      elseif($iFonteEmpenho == '133' || $iFonteEmpenho == '233' || substr($iFonteEmpenho, 1, 7) == '7150000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('133','233','17150000','27150000')) and"; 
        
      }
      elseif($iFonteEmpenho == '134' || $iFonteEmpenho == '234' || substr($iFonteEmpenho, 1, 7) == '7160000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('134','234',17160000','27160000')) and"; 
        
      }
      elseif($iFonteEmpenho == '135' || $iFonteEmpenho == '235' || substr($iFonteEmpenho, 1, 7) == '7170000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('135','235','17170000','27170000')) and"; 
        
      } 
      elseif($iFonteEmpenho == '136' || $iFonteEmpenho == '236' || substr($iFonteEmpenho, 1, 7) == '7180000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('136','236','17180000','27180000','100','200','15000000','25000000')) and"; 
        
      }
      elseif($iFonteEmpenho == '142' || $iFonteEmpenho == '242' || substr($iFonteEmpenho, 1, 7) == '6650000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('142','242','16650000','26650000')) and"; 
        
      } 
      elseif($iFonteEmpenho == '143' || $iFonteEmpenho == '243' || substr($iFonteEmpenho, 1, 7) == '5510000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('143','243,'15510000','25510000')) and"; 
        
      } 
      elseif($iFonteEmpenho == '144' || $iFonteEmpenho == '244' || substr($iFonteEmpenho, 1, 7) == '5520000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('144','244','15520000','25520000')) and"; 
        
      } 
      elseif($iFonteEmpenho == '145' || $iFonteEmpenho == '245' || substr($iFonteEmpenho, 1, 7) == '5530000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('145','245','15530000','25530000')) and"; 
        
      } 
      elseif($iFonteEmpenho == '146' || $iFonteEmpenho == '246' || substr($iFonteEmpenho, 1, 7) == '5690000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('146','246','15690000','25690000')) and"; 
        
      } 
      elseif($iFonteEmpenho == '147' || $iFonteEmpenho == '247' || substr($iFonteEmpenho, 1, 7) == '5500000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('147','247','15500000','25500000')) and"; 
        
      }
      elseif($iFonteEmpenho == '153' || $iFonteEmpenho == '253' || substr($iFonteEmpenho,1,7) == '6010000' || substr($iFonteEmpenho,1,7) == '6030000' ) {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('153','253','16010000','16030000','26010000','26030000') and";
      
      } 
      elseif($iFonteEmpenho == '154' || $iFonteEmpenho == '254' || substr($iFonteEmpenho, 1, 7) == '6590000') {
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('154','254','159','259','16590000','16000000','16020000','26590000','26000000','26020000')) and";
      
      }
      elseif($iFonteEmpenho == '155' || $iFonteEmpenho == '255' || substr($iFonteEmpenho, 1, 7) == '6210000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('155','255','16210000','26210000')) and"; 
        
      }
      elseif($iFonteEmpenho == '156' || $iFonteEmpenho == '256' || substr($iFonteEmpenho, 1, 7) == '6610000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('156','256','16610000','26610000')) and"; 
        
      }
      elseif($iFonteEmpenho == '157' || $iFonteEmpenho == '257' || substr($iFonteEmpenho, 1, 7) == '7520000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('157','257','17520000','27520000')) and"; 
        
      }
      elseif($iFonteEmpenho == '158' || $iFonteEmpenho == '258' || substr($iFonteEmpenho, 1, 7) == '8990060'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('158','258','18990060','28990060')) and"; 
        
      }
      elseif($iFonteEmpenho == '159' || $iFonteEmpenho == '259' || substr($iFonteEmpenho, 1, 7) == '6000000' || substr($iFonteEmpenho, 1, 7) == '6020000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('159','259','16000000','16020000','26000000','26020000')) and"; 
        
      }
      elseif($iFonteEmpenho == '160' || $iFonteEmpenho == '260' || $iFonteEmpenho == '17040000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('186','17040000',286','27040000')) and";
      
      }
      elseif($iFonteEmpenho == '161' || $iFonteEmpenho == '261' || substr($iFonteEmpenho, 1, 7) == '7070000' ){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('100','200','161','261','17070000','15000000','27070000','25000000')) and";
      
      }
      elseif($iFonteEmpenho == '162' || $iFonteEmpenho == '262' || substr($iFonteEmpenho, 1, 7) == '7490120'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('162','262','17490120','27490120')) and"; 
        
      }
      elseif($iFonteEmpenho == '163' || $iFonteEmpenho == '263' || substr($iFonteEmpenho, 1, 7) == '7130070'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('163','263','17130070','27130070')) and"; 
        
      }
      elseif($iFonteEmpenho == '164' || $iFonteEmpenho == '264' || substr($iFonteEmpenho, 1, 7) == '7060000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('164','264','17060000','27060000')) and"; 
        
      }
      elseif($iFonteEmpenho == '165' || $iFonteEmpenho == '265' || substr($iFonteEmpenho, 1, 7) == '8990000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('165','265','18990000','28990000')) and"; 
        
      }
      elseif($iFonteEmpenho == '166' || $iFonteEmpenho == '266' || substr($iFonteEmpenho, 1, 7) == '5420007'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('166','266','15420007','25420007')) and"; 
        
      }
      elseif($iFonteEmpenho == '167' || $iFonteEmpenho == '267' || substr($iFonteEmpenho, 1, 7) == '5420000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('167','267','15420000','25420000')) and"; 
        
      }
      elseif($iFonteEmpenho == '168' || $iFonteEmpenho == '268' || substr($iFonteEmpenho, 1, 7) == '7100100'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('168','268','17100100','27100100')) and"; 
        
      }
      elseif($iFonteEmpenho == '169' || $iFonteEmpenho == '269' || substr($iFonteEmpenho, 1, 7) == '7100000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('169','269','17100000','27100000')) and"; 
        
      }
      elseif($iFonteEmpenho == '170' || $iFonteEmpenho == '270' || substr($iFonteEmpenho, 1, 7) == '5010000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('100','200','170','15010000','15000000','270','25010000','25000000')) and"; 
      
      }
      elseif($iFonteEmpenho == '171' || $iFonteEmpenho == '271' || substr($iFonteEmpenho, 1, 7) == '5710000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('171','271','15710000','25710000')) and"; 
        
      }
      elseif($iFonteEmpenho == '172' || $iFonteEmpenho == '272' || substr($iFonteEmpenho, 1, 7) == '5720000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('172','272','15720000','25720000')) and"; 
        
      }
      elseif($iFonteEmpenho == '173' || $iFonteEmpenho == '273' || substr($iFonteEmpenho, 1, 7) == '5750000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('173','273','15750000','25750000')) and"; 
        
      }
      elseif($iFonteEmpenho == '174' || $iFonteEmpenho == '274' || substr($iFonteEmpenho, 1, 7) == '5740000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('174','274','15740000','25740000')) and"; 
        
      }
      elseif($iFonteEmpenho == '175' || $iFonteEmpenho == '275' || substr($iFonteEmpenho, 1, 7) == '5730000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('175','275','15730000','25730000')) and"; 
        
      }
      elseif($iFonteEmpenho == '176' || $iFonteEmpenho == '276' || substr($iFonteEmpenho, 1, 7) == '6320000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('176','276','16320000','26320000')) and"; 
        
      }
      elseif($iFonteEmpenho == '177' || $iFonteEmpenho == '277' || substr($iFonteEmpenho, 1, 7) == '6330000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('177','277','26330000','26330000')) and"; 
        
      }
      elseif($iFonteEmpenho == '178' || $iFonteEmpenho == '278' || substr($iFonteEmpenho, 1, 7) == '6360000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('178','278','16360000','26360000')) and"; 
        
      }
      elseif($iFonteEmpenho == '179' || $iFonteEmpenho == '279' || substr($iFonteEmpenho, 1, 7) == '6340000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('179','279','16340000','26340000')) and"; 
        
      }
      elseif($iFonteEmpenho == '180' || $iFonteEmpenho == '280' || substr($iFonteEmpenho, 1, 7) == '6350000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('180','280','16350000','26350000')) and"; 
        
      }
      elseif($iFonteEmpenho == '181' || $iFonteEmpenho == '281' || substr($iFonteEmpenho, 1, 7) == '7010000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('181','281','17010000','27010000')) and"; 
        
      }
      elseif($iFonteEmpenho == '182' || $iFonteEmpenho == '282' || substr($iFonteEmpenho, 1, 7) == '7020000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('182','282','17020000','27020000')) and"; 
        
      }
      elseif($iFonteEmpenho == '183' || $iFonteEmpenho == '283' || substr($iFonteEmpenho, 1, 7) == '7030000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('183','283','17030000','27030000')) and"; 
        
      }
      elseif($iFonteEmpenho == '184' || $iFonteEmpenho == '284' || substr($iFonteEmpenho, 1, 7) == '7090000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('184','284','17090000','27090000')) and"; 
        
      }
      elseif($iFonteEmpenho == '185' || $iFonteEmpenho == '285' || substr($iFonteEmpenho, 1, 7) == '7530000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('185','285','17530000','27530000')) and"; 
        
      }
      elseif($iFonteEmpenho == '186' || $iFonteEmpenho == '286' || substr($iFonteEmpenho, 1, 7) == '7040000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('186','286','17040000','27040000')) and"; 
        
      }
      elseif($iFonteEmpenho == '187' || $iFonteEmpenho == '287' || substr($iFonteEmpenho, 1, 7) == '7050000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('187','287','17050000','27050000')) and"; 
        
      }
      elseif($iFonteEmpenho == '188' || $iFonteEmpenho == '288' || substr($iFonteEmpenho, 1, 7) == '5000000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('188','288','15000000','25000000')) and"; 
        
      }
      elseif($iFonteEmpenho == '189' || $iFonteEmpenho == '289' || substr($iFonteEmpenho, 1, 7) == '5000000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('189','289','15000000','25000000')) and"; 
        
      }
      elseif($iFonteEmpenho == '190' || $iFonteEmpenho == '290' || substr($iFonteEmpenho, 1, 7) == '7540000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('190','290','17540000','27540000')) and"; 
        
      }
      elseif($iFonteEmpenho == '191' || $iFonteEmpenho == '291' || substr($iFonteEmpenho, 1, 7) == '7540000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('191','291','17540000','27540000' )) and"; 
        
      }
      elseif($iFonteEmpenho == '192' || $iFonteEmpenho == '292' || substr($iFonteEmpenho, 1, 7) == '7550000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('192','292','17550000','27550000')) and"; 
        
      }
      elseif($iFonteEmpenho == '193' || $iFonteEmpenho == '293' || substr($iFonteEmpenho, 1, 7) == '8990000'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('193','293','18990000','28990000')) and"; 
        
      }
      else
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ('$iFonteEmpenho')) and"; 
      
  }else{
    if(in_array($iFonteEmpenho,$aFontes) and db_getsession("DB_anousu") > 2017){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('148','149','150','151','152', '159', '248','249','250','251','252', '259')) and";
      $whereFonte2 = " ";
    }elseif(substr($iFonteEmpenho, 1, 2) == '05') {
        $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('105','205','103')) and";
    }elseif(substr($iFonteEmpenho, 1, 2) == '54') {
        $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('154','254','159')) and";
    }elseif($lContaUnicaFundeb && (substr($iFonteEmpenho, 1, 2) == '18' || substr($iFonteEmpenho, 1, 2) == '19' || substr($iFonteEmpenho, 1, 2) == '66' || substr($iFonteEmpenho, 1, 2) == '67')){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('118','218','119', '219', '166','167','266','267')) and";
    }elseif(substr($iFonteEmpenho, 1, 2) == '61'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('100','161','261')) and";
    }elseif(substr($iFonteEmpenho, 1, 2) == '70'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('100','170')) and";  
    }elseif(substr($iFonteEmpenho, 1, 2) == '60'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('186')) and";
    }elseif($iFonteEmpenho == '136'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('$iFonteEmpenho','100')) and";   
    }elseif($iFonteEmpenho == '117'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('$iFonteEmpenho','100')) and";   
    }elseif(substr($iFonteEmpenho, 1, 2) == '22'){
        $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('$iFonteEmpenho','122')) and";
    }elseif(substr($iFonteEmpenho, 1, 2) == '32'){
        $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('159','132')) and";    
    }elseif(substr($iFonteEmpenho, 1, 2) != '60'){ // OC11508 Verificação adicionada para permitir utilização do recurso 160/260 na fonte 100
      $whereFonte = " ";
      $whereFonte2 = " AND (SELECT substr(o15_codtri,2,2) FROM orctiporec WHERE o15_codigo = c61_codigo) = (SELECT substr(o15_codtri,2,2) FROM orctiporec WHERE o15_codigo = o58_codigo) ";
    }
    if($iAnoUsu > 2021 and $iAnoEmpenho <2022){
      if(substr($iFonteEmpenho, 1, 2) == '22'){
      $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('$iFonteEmpenho','171','122')) and";  
      }elseif(substr($iFonteEmpenho, 1, 2) == '23'){
        $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('$iFonteEmpenho','176')) and";
      }elseif(substr($iFonteEmpenho, 1, 2) == '24'){
        $whereFonte = "c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ('$iFonteEmpenho','181')) and";
      } 
    }
  }

    $sSql .= "from empagetipo left join ";
    $sSql .= "( select distinct c61_codcon, c61_reduz,c61_codigo, c61_anousu from ";
    $sSql .= "  empempenho";
    $sSql .= "  inner join orcdotacao on e60_coddot    = o58_coddot and e60_anousu = o58_anousu";
    $sSql .= "  inner join conplanoreduz on (c61_anousu = o58_anousu or c61_anousu = ".db_getsession("DB_anousu").")";
    $sSql .= "                   ".$whereFonte2."      ";
    $sSql .= "  left join pagordem on e60_numemp       = e50_numemp ";
    $sSql .= "  left join saltes   on c61_reduz = k13_conta ";
    $sSql .= " where ".$whereFonte." c61_instit=".db_getsession("DB_instit")  ;
    if ($sWhere != '') {
      $sSql .= " and {$sWhere}";
    }
    $sSql .= " )";
    $sSql .= " as x on e83_conta = c61_reduz";

    if ($lSomenteCorrente) {
        $sSql .= "  JOIN conplano ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu
                    JOIN conplanocontabancaria ON c60_codcon = c56_codcon AND c60_anousu = c56_anousu
                    JOIN contabancaria ON c56_contabancaria = db83_sequencial AND db83_tipoconta = 1 ";
    }
    

    $sSql .= " where c61_reduz is not null ";
    if (USE_PCASP) {
      $sSql .= " and c61_anousu =".db_getsession("DB_anousu");
    }
    /* OC11508 Verificação adicionada para permitir utilização do recurso 160/260 na fonte 100 */
    if($iAnoUsu < 2022){
        if(substr($iFonteEmpenho, 1, 2) == '60') {
          $sSql .= " and e83_descr like '%FEP' ";
        }
    }
    /* OC12503 Verificação adicionada para permitir utilização do recurso 161/261 na fonte 100 */
    if(substr($iFonteEmpenho, 1, 2) == '61') {
        $sSql .= " or e83_descr ilike '%fpm%' ";
    }
   
    if ($lVinculadas) {

      $sSql .= " or e83_conta in ";
      $sSql .= " (select c61_reduz from conplanoreduz where c61_anousu =".db_getsession("DB_anousu");
      $sSql .= " and c61_codigo = 1 and c61_instit = ".db_getsession("DB_instit").")";

    }

    if (isset($sWhere2) && $sWhere2 != '') {
        $sSql .= " and {$sWhere2} ";
    }

    // if ($lSomenteCorrente) {
    //     $sSql .= "  JOIN conplano ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu
    //                 JOIN conplanocontabancaria ON c60_codcon = c56_codcon AND c60_anousu = c56_anousu
    //                 JOIN contabancaria ON c56_contabancaria = db83_sequencial AND db83_tipoconta = 1 ";
    //     // $sSql .= " AND EXISTS (SELECT contabancaria.*,c60_codcon,c60_descr,c61_anousu FROM conplanoreduz 
    //     // JOIN conplano ON conplanoreduz.c61_codcon = conplano.c60_codcon 
    //     // AND conplanoreduz.c61_anousu = conplano.c60_anousu
    //     // JOIN conplanocontabancaria ON conplano.c60_codcon = conplanocontabancaria.c56_codcon 
    //     // AND conplano.c60_anousu = conplanocontabancaria.c56_anousu
    //     // JOIN contabancaria ON conplanocontabancaria.c56_contabancaria = contabancaria.db83_sequencial
    //     // WHERE conplanoreduz.c61_anousu = ". db_getsession('DB_anousu') ." AND contabancaria.db83_tipoconta = 1 AND conplanoreduz.c61_reduz = e83_conta) ";
    // }
  //  echo $sSql;exit;
    return $sSql;

  }
   function sql_query_emprec ( $e83_codtipo=null,$campos="*",$ordem=null,$dbwhere="",$dbwhere02=""){
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
    $sql .= " from empagetipo ";
    $sql .= " 	    inner join conplanoreduz  on c61_reduz  = e83_conta ";
    $sql .= "                               and c61_anousu = " . db_getsession("DB_anousu");
    $sql .= "                               and c61_instit = " . db_getsession("DB_instit");

    $sql .= "      inner join orcdotacao     on o58_codigo = c61_codigo ";
    $sql .= "      inner join empempenho     on e60_coddot = o58_coddot ";
    $sql .= "                               and e60_anousu = o58_anousu "; // Verificar Anousu do Empenho para Buscar ORCDOTACAO

    $sql .= "       left join pagordem       on e50_numemp = e60_numemp ";


    /*$sql .= " 	    inner join (
      select o58_codigo,e60_numemp from empempenho";
      $sql .= "   		   inner join orcdotacao  on  orcdotacao.o58_anousu = empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot";
      $sql .= "   		   left join  pagordem on e50_numemp = e60_numemp ";

      if($dbwhere02 != ""){
      $sql .= " where $dbwhere02";
      }
      $sql .= "   		   group by e60_numemp,o58_codigo";
      $sql .= "   		)as x on x.o58_codigo = c61_codigo      ";*/

    $sql2 = "";
    if($dbwhere==""){
      if($e83_codtipo!=null ){
        $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
      }
    }else if($dbwhere != "" && $dbwhere02 != ""){
      $sql2 = " where $dbwhere and $dbwhere02";
    }else if($dbwhere != "" && $dbwhere02 == ""){
      $sql2 = " where $dbwhere ";
    }else if($dbwhere == "" && $dbwhere02 != ""){
      $sql2 = " where $dbwhere02";
    }
    $sql2 .= ($sql2!=""?" and ":" where ") . " c61_instit = " . db_getsession("DB_instit");
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
   function sql_query_rec ( $e83_codtipo=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from empagetipo ";
    $sql .= " 	    inner join conplanoreduz on c61_reduz = e83_conta and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit=".db_getsession("DB_instit");
    $sql .= " 	    inner join saltes        on c61_reduz = k13_reduz ";
    $sql .= " 	    inner join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu ";
    $sql2 = "";
    if($dbwhere==""){
      if($e83_codtipo!=null ){
        $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
      }
    }else if($dbwhere != ""){
      $sql2 = " where $dbwhere";
    }
    $sql2 .= ($sql2!=""?" and ":" where ") . " c61_instit = " . db_getsession("DB_instit");
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
   function sql_query_reduz ( $e83_codtipo=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from empagetipo ";
    $sql .= " 	    inner join saltes on k13_conta = e83_conta ";
    $sql .= " 	    inner join conplanoreduz on c61_reduz = k13_reduz and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit=".db_getsession("DB_instit");
    $sql .= " 	    left  join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu ";
    $sql2 = "";
    if($dbwhere==""){
      if($e83_codtipo!=null ){
        $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
      }
    }else if($dbwhere != ""){
      $sql2 = " where $dbwhere";
    }
    $sql2 .= ($sql2!=""?" and ":" where ") . " c61_instit = " . db_getsession("DB_instit");
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

  function sql_query_conplano_conta_bancaria ( $e83_codtipo=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from empagetipo ";
    $sql .= " 	    inner join saltes on k13_conta = e83_conta ";
    $sql .= " 	    inner join conplanoreduz on c61_reduz = k13_reduz and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit=".db_getsession("DB_instit");
    $sql .= "       inner join conplano on c61_codcon = c60_codcon and c61_anousu = c60_anousu ";
    $sql .= "       inner join conplanocontabancaria on c60_codcon = c56_codcon and c60_anousu = c56_anousu ";
    $sql .= "       inner join contabancaria on c56_contabancaria = db83_sequencial ";
    $sql2 = "";
    if($dbwhere==""){
      if($e83_codtipo!=null ){
        $sql2 .= " where empagetipo.e83_codtipo = $e83_codtipo ";
      }
    }else if($dbwhere != ""){
      $sql2 = " where $dbwhere";
    }
    $sql2 .= ($sql2!=""?" and ":" where ") . " c61_instit = " . db_getsession("DB_instit");
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

  function teste($num_1,$num_2){
    $total = $num_1 + $num_2;

    return $total;

  }
}
?>