<?
//MODULO: licitacao
//CLASSE DA ENTIDADE precomedio
class cl_precomedio { 
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
   var $l209_sequencial = 0; 
   var $l209_licitacao = 0; 
   var $l209_datacotacao_dia = null; 
   var $l209_datacotacao_mes = null; 
   var $l209_datacotacao_ano = null; 
   var $l209_datacotacao = null; 
   var $l209_item = 0; 
   var $l209_valor = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 l209_sequencial = int8 = sequencial 
                 l209_licitacao = int8 = Licitação 
                 l209_datacotacao = date = Data da Cotação 
                 l209_item = int8 = Item 
                 l209_valor = float8 = Valor 
                 ";
   //funcao construtor da classe 
   function cl_precomedio() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("precomedio"); 
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
       $this->l209_sequencial = ($this->l209_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l209_sequencial"]:$this->l209_sequencial);
       $this->l209_licitacao = ($this->l209_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l209_licitacao"]:$this->l209_licitacao);
       if($this->l209_datacotacao == ""){
         $this->l209_datacotacao_dia = ($this->l209_datacotacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l209_datacotacao_dia"]:$this->l209_datacotacao_dia);
         $this->l209_datacotacao_mes = ($this->l209_datacotacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l209_datacotacao_mes"]:$this->l209_datacotacao_mes);
         $this->l209_datacotacao_ano = ($this->l209_datacotacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l209_datacotacao_ano"]:$this->l209_datacotacao_ano);
         if($this->l209_datacotacao_dia != ""){
            $this->l209_datacotacao = $this->l209_datacotacao_ano."-".$this->l209_datacotacao_mes."-".$this->l209_datacotacao_dia;
         }
       }
       $this->l209_item = ($this->l209_item == ""?@$GLOBALS["HTTP_POST_VARS"]["l209_item"]:$this->l209_item);
       $this->l209_valor = ($this->l209_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["l209_valor"]:$this->l209_valor);
     }else{
       $this->l209_sequencial = ($this->l209_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l209_sequencial"]:$this->l209_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($l209_sequencial){ 
      $this->atualizacampos();
     if($this->l209_licitacao == null ){ 
       $this->erro_sql = " Campo Licitação nao Informado.";
       $this->erro_campo = "l209_licitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l209_datacotacao == null ){ 
       $this->erro_sql = " Campo Data da Cotação nao Informado.";
       $this->erro_campo = "l209_datacotacao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l209_item == null ){ 
       $this->erro_sql = " Campo Item nao Informado.";
       $this->erro_campo = "l209_item";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
    /* if($this->l209_valor == null ){ 
       $this->erro_sql = " Campo Valor nao Informado.";
       $this->erro_campo = "l209_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
     if($l209_sequencial == "" || $l209_sequencial == null ){
       $result = db_query("select nextval('precomedio_l209_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: precomedio_l209_sequencial_seq do campo: l209_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->l209_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from precomedio_l209_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $l209_sequencial)){
         $this->erro_sql = " Campo l209_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->l209_sequencial = $l209_sequencial; 
       }
     }
     if(($this->l209_sequencial == null) || ($this->l209_sequencial == "") ){ 
       $this->erro_sql = " Campo l209_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into precomedio(
                                       l209_sequencial 
                                      ,l209_licitacao 
                                      ,l209_datacotacao 
                                      ,l209_item 
                                      ,l209_valor 
                       )
                values (
                                $this->l209_sequencial 
                               ,$this->l209_licitacao 
                               ,".($this->l209_datacotacao == "null" || $this->l209_datacotacao == ""?"null":"'".$this->l209_datacotacao."'")." 
                               ,$this->l209_item 
                               ,".($this->l209_valor==null?0:$this->l209_valor)." 
                      )";
     $result = db_query($sql); 
     
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "precomedio ($this->l209_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "precomedio já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "precomedio ($this->l209_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l209_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->l209_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011688,'$this->l209_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010412,2011688,'','".AddSlashes(pg_result($resaco,0,'l209_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010412,2011689,'','".AddSlashes(pg_result($resaco,0,'l209_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010412,2011690,'','".AddSlashes(pg_result($resaco,0,'l209_datacotacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010412,2011691,'','".AddSlashes(pg_result($resaco,0,'l209_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010412,2011693,'','".AddSlashes(pg_result($resaco,0,'l209_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($l209_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update precomedio set ";
     $virgula = "";
     if(trim($this->l209_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l209_sequencial"])){ 
       $sql  .= $virgula." l209_sequencial = $this->l209_sequencial ";
       $virgula = ",";
       if(trim($this->l209_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "l209_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l209_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l209_licitacao"])){ 
       $sql  .= $virgula." l209_licitacao = $this->l209_licitacao ";
       $virgula = ",";
       if(trim($this->l209_licitacao) == null ){ 
         $this->erro_sql = " Campo Licitação nao Informado.";
         $this->erro_campo = "l209_licitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l209_datacotacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l209_datacotacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l209_datacotacao_dia"] !="") ){ 
       $sql  .= $virgula." l209_datacotacao = '$this->l209_datacotacao' ";
       $virgula = ",";
       if(trim($this->l209_datacotacao) == null ){ 
         $this->erro_sql = " Campo Data da Cotação nao Informado.";
         $this->erro_campo = "l209_datacotacao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l209_datacotacao_dia"])){ 
         $sql  .= $virgula." l209_datacotacao = null ";
         $virgula = ",";
         if(trim($this->l209_datacotacao) == null ){ 
           $this->erro_sql = " Campo Data da Cotação nao Informado.";
           $this->erro_campo = "l209_datacotacao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->l209_item)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l209_item"])){ 
       $sql  .= $virgula." l209_item = $this->l209_item ";
       $virgula = ",";
       if(trim($this->l209_item) == null ){ 
         $this->erro_sql = " Campo Item nao Informado.";
         $this->erro_campo = "l209_item";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l209_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l209_valor"])){ 
       $sql  .= $virgula." l209_valor = $this->l209_valor ";
       $virgula = ",";
       if(trim($this->l209_valor) == null ){ 
         $this->erro_sql = " Campo Valor nao Informado.";
         $this->erro_campo = "l209_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($l209_sequencial!=null){
       $sql .= " l209_sequencial = $this->l209_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->l209_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011688,'$this->l209_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l209_sequencial"]) || $this->l209_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010412,2011688,'".AddSlashes(pg_result($resaco,$conresaco,'l209_sequencial'))."','$this->l209_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l209_licitacao"]) || $this->l209_licitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010412,2011689,'".AddSlashes(pg_result($resaco,$conresaco,'l209_licitacao'))."','$this->l209_licitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l209_datacotacao"]) || $this->l209_datacotacao != "")
           $resac = db_query("insert into db_acount values($acount,2010412,2011690,'".AddSlashes(pg_result($resaco,$conresaco,'l209_datacotacao'))."','$this->l209_datacotacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l209_item"]) || $this->l209_item != "")
           $resac = db_query("insert into db_acount values($acount,2010412,2011691,'".AddSlashes(pg_result($resaco,$conresaco,'l209_item'))."','$this->l209_item',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l209_valor"]) || $this->l209_valor != "")
           $resac = db_query("insert into db_acount values($acount,2010412,2011693,'".AddSlashes(pg_result($resaco,$conresaco,'l209_valor'))."','$this->l209_valor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "precomedio nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->l209_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "precomedio nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->l209_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l209_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($l209_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($l209_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011688,'$l209_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010412,2011688,'','".AddSlashes(pg_result($resaco,$iresaco,'l209_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010412,2011689,'','".AddSlashes(pg_result($resaco,$iresaco,'l209_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010412,2011690,'','".AddSlashes(pg_result($resaco,$iresaco,'l209_datacotacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010412,2011691,'','".AddSlashes(pg_result($resaco,$iresaco,'l209_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010412,2011693,'','".AddSlashes(pg_result($resaco,$iresaco,'l209_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from precomedio
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($l209_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " l209_sequencial = $l209_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "precomedio nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$l209_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "precomedio nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$l209_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$l209_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:precomedio";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $l209_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from precomedio ";
     $sql2 = "";
     if($dbwhere==""){
       if($l209_sequencial!=null ){
         $sql2 .= " where precomedio.l209_sequencial = $l209_sequencial "; 
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
   function sql_query_file ( $l209_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from precomedio ";
     $sql2 = "";
     if($dbwhere==""){
       if($l209_sequencial!=null ){
         $sql2 .= " where precomedio.l209_sequencial = $l209_sequencial "; 
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
}
?>
