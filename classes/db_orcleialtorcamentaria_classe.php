<?
//MODULO: orcamento
//CLASSE DA ENTIDADE orcleialtorcamentaria
class cl_orcleialtorcamentaria { 
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
   var $o200_sequencial = 0; 
   var $o200_orcprojetolei = 0; 
   var $o200_tipoleialteracao = 0; 
   var $o200_artleialteracao = null; 
   var $o200_descrartigo = null; 
   var $o200_vlautorizado = 0;
   var $o200_percautorizado = 0;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o200_sequencial = int8 = Código Sequencial 
                 o200_orcprojetolei = int8 = Código do Projeto de Lei 
                 o200_tipoleialteracao = int8 = Tipo de Lei Alteração 
                 o200_artleialteracao = varchar(6) = Artigo da Lei de Alteração 
                 o200_descrartigo = text = Descrição Artigo 
                 o200_vlautorizado = float8 = Valor Autorizado 
                 o200_percautorizado = float8 = Percentual Autorizado 
                 ";
   //funcao construtor da classe 
   function cl_orcleialtorcamentaria() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("orcleialtorcamentaria"); 
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
       $this->o200_sequencial = ($this->o200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o200_sequencial"]:$this->o200_sequencial);
       $this->o200_orcprojetolei = ($this->o200_orcprojetolei == ""?@$GLOBALS["HTTP_POST_VARS"]["o200_orcprojetolei"]:$this->o200_orcprojetolei);
       $this->o200_tipoleialteracao = ($this->o200_tipoleialteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["o200_tipoleialteracao"]:$this->o200_tipoleialteracao);
       $this->o200_artleialteracao = ($this->o200_artleialteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["o200_artleialteracao"]:$this->o200_artleialteracao);
       $this->o200_descrartigo = ($this->o200_descrartigo == ""?@$GLOBALS["HTTP_POST_VARS"]["o200_descrartigo"]:$this->o200_descrartigo);
       $this->o200_vlautorizado = ($this->o200_vlautorizado == ""?@$GLOBALS["HTTP_POST_VARS"]["o200_vlautorizado"]:$this->o200_vlautorizado);
       $this->o200_percautorizado = ($this->o200_percautorizado == ""?@$GLOBALS["HTTP_POST_VARS"]["o200_percautorizado"]:$this->o200_percautorizado);
     }else{
       $this->o200_sequencial = ($this->o200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o200_sequencial"]:$this->o200_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($o200_sequencial){ 
      $this->atualizacampos();
     if($this->o200_orcprojetolei == null ){ 
       $this->erro_sql = " Campo Código do Projeto de Lei nao Informado.";
       $this->erro_campo = "o200_orcprojetolei";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o200_tipoleialteracao == null ){ 
       $this->erro_sql = " Campo Tipo de Lei Alteração nao Informado.";
       $this->erro_campo = "o200_tipoleialteracao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o200_artleialteracao == null ){ 
       $this->erro_sql = " Campo Artigo da Lei de Alteração nao Informado.";
       $this->erro_campo = "o200_artleialteracao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o200_descrartigo == null ){ 
       $this->erro_sql = " Campo Descrição Artigo nao Informado.";
       $this->erro_campo = "o200_descrartigo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($o200_sequencial == "" || $o200_sequencial == null ){
       $result = db_query("select nextval('orcleialtorcamentaria_o200_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: orcleialtorcamentaria_o200_sequencial_seq do campo: o200_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->o200_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from orcleialtorcamentaria_o200_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $o200_sequencial)){
         $this->erro_sql = " Campo o200_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->o200_sequencial = $o200_sequencial; 
       }
     }
     if(($this->o200_sequencial == null) || ($this->o200_sequencial == "") ){ 
       $this->erro_sql = " Campo o200_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into orcleialtorcamentaria(
                                       o200_sequencial 
                                      ,o200_orcprojetolei 
                                      ,o200_tipoleialteracao 
                                      ,o200_artleialteracao 
                                      ,o200_descrartigo 
                                      ,o200_vlautorizado 
                                      ,o200_percautorizado
                       )
                values (
                                $this->o200_sequencial 
                               ,$this->o200_orcprojetolei 
                               ,$this->o200_tipoleialteracao 
                               ,'$this->o200_artleialteracao' 
                               ,'$this->o200_descrartigo' 
                               ,".($this->o200_vlautorizado==0?'0':$this->o200_vlautorizado)." 
                               ,".($this->o200_percautorizado==0?'0':$this->o200_percautorizado)." 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Lei de Alteração Orçamentária ($this->o200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Lei de Alteração Orçamentária já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Lei de Alteração Orçamentária ($this->o200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o200_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->o200_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011286,'$this->o200_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010394,2011286,'','".AddSlashes(pg_result($resaco,0,'o200_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010394,2011287,'','".AddSlashes(pg_result($resaco,0,'o200_orcprojetolei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010394,2011288,'','".AddSlashes(pg_result($resaco,0,'o200_tipoleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010394,2011289,'','".AddSlashes(pg_result($resaco,0,'o200_artleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010394,2011290,'','".AddSlashes(pg_result($resaco,0,'o200_descrartigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010394,2011291,'','".AddSlashes(pg_result($resaco,0,'o200_vlautorizado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o200_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update orcleialtorcamentaria set ";
     $virgula = "";
     if(trim($this->o200_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o200_sequencial"])){ 
       $sql  .= $virgula." o200_sequencial = $this->o200_sequencial ";
       $virgula = ",";
       if(trim($this->o200_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "o200_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o200_orcprojetolei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o200_orcprojetolei"])){ 
       $sql  .= $virgula." o200_orcprojetolei = $this->o200_orcprojetolei ";
       $virgula = ",";
       if(trim($this->o200_orcprojetolei) == null ){ 
         $this->erro_sql = " Campo Código do Projeto de Lei nao Informado.";
         $this->erro_campo = "o200_orcprojetolei";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o200_tipoleialteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o200_tipoleialteracao"])){ 
       $sql  .= $virgula." o200_tipoleialteracao = $this->o200_tipoleialteracao ";
       $virgula = ",";
       if(trim($this->o200_tipoleialteracao) == null ){ 
         $this->erro_sql = " Campo Tipo de Lei Alteração nao Informado.";
         $this->erro_campo = "o200_tipoleialteracao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o200_artleialteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o200_artleialteracao"])){ 
       $sql  .= $virgula." o200_artleialteracao = '$this->o200_artleialteracao' ";
       $virgula = ",";
       if(trim($this->o200_artleialteracao) == null ){ 
         $this->erro_sql = " Campo Artigo da Lei de Alteração nao Informado.";
         $this->erro_campo = "o200_artleialteracao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o200_descrartigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o200_descrartigo"])){ 
       $sql  .= $virgula." o200_descrartigo = '$this->o200_descrartigo' ";
       $virgula = ",";
       if(trim($this->o200_descrartigo) == null ){ 
         $this->erro_sql = " Campo Descrição Artigo nao Informado.";
         $this->erro_campo = "o200_descrartigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o200_vlautorizado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o200_vlautorizado"])){
       $sql  .= $virgula." o200_vlautorizado = '$this->o200_vlautorizado' ";
       $virgula = ",";
     }
     if(trim($this->o200_percautorizado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o200_percautorizado"])){ 
       $sql  .= $virgula." o200_percautorizado = $this->o200_percautorizado ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($o200_sequencial!=null){
       $sql .= " o200_sequencial = $this->o200_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->o200_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011286,'$this->o200_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o200_sequencial"]) || $this->o200_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010394,2011286,'".AddSlashes(pg_result($resaco,$conresaco,'o200_sequencial'))."','$this->o200_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o200_orcprojetolei"]) || $this->o200_orcprojetolei != "")
           $resac = db_query("insert into db_acount values($acount,2010394,2011287,'".AddSlashes(pg_result($resaco,$conresaco,'o200_orcprojetolei'))."','$this->o200_orcprojetolei',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o200_tipoleialteracao"]) || $this->o200_tipoleialteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010394,2011288,'".AddSlashes(pg_result($resaco,$conresaco,'o200_tipoleialteracao'))."','$this->o200_tipoleialteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o200_artleialteracao"]) || $this->o200_artleialteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010394,2011289,'".AddSlashes(pg_result($resaco,$conresaco,'o200_artleialteracao'))."','$this->o200_artleialteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o200_descrartigo"]) || $this->o200_descrartigo != "")
           $resac = db_query("insert into db_acount values($acount,2010394,2011290,'".AddSlashes(pg_result($resaco,$conresaco,'o200_descrartigo'))."','$this->o200_descrartigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o200_vlautorizado"]) || $this->o200_vlautorizado != "")
           $resac = db_query("insert into db_acount values($acount,2010394,2011291,'".AddSlashes(pg_result($resaco,$conresaco,'o200_vlautorizado'))."','$this->o200_vlautorizado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Lei de Alteração Orçamentária nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o200_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Lei de Alteração Orçamentária nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o200_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($o200_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011286,'$o200_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010394,2011286,'','".AddSlashes(pg_result($resaco,$iresaco,'o200_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010394,2011287,'','".AddSlashes(pg_result($resaco,$iresaco,'o200_orcprojetolei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010394,2011288,'','".AddSlashes(pg_result($resaco,$iresaco,'o200_tipoleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010394,2011289,'','".AddSlashes(pg_result($resaco,$iresaco,'o200_artleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010394,2011290,'','".AddSlashes(pg_result($resaco,$iresaco,'o200_descrartigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010394,2011291,'','".AddSlashes(pg_result($resaco,$iresaco,'o200_vlautorizado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from orcleialtorcamentaria
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($o200_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " o200_sequencial = $o200_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Lei de Alteração Orçamentária nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o200_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Lei de Alteração Orçamentária nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o200_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:orcleialtorcamentaria";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $o200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcleialtorcamentaria ";
     $sql .= "      inner join orcprojetolei  on  orcprojetolei.o138_sequencial = orcleialtorcamentaria.o200_orcprojetolei";
     $sql .= "      inner join db_config  on  db_config.codigo = orcprojetolei.o138_instit";
     $sql2 = "";
     if($dbwhere==""){
       if($o200_sequencial!=null ){
         $sql2 .= " where orcleialtorcamentaria.o200_sequencial = $o200_sequencial "; 
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
   function sql_query_file ( $o200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcleialtorcamentaria ";
     $sql2 = "";
     if($dbwhere==""){
       if($o200_sequencial!=null ){
         $sql2 .= " where orcleialtorcamentaria.o200_sequencial = $o200_sequencial "; 
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
