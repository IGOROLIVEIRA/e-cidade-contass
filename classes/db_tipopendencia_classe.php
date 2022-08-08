<?
//MODULO: caixa
//CLASSE DA ENTIDADE tipopendencia
class cl_tipopendencia { 
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
   var $k202_sequencial = 0; 
   var $k202_tipopendencia = null; 
   var $k202_descricao = null; 
   var $k202_valor = 0; 
   var $k202_data_dia = null; 
   var $k202_data_mes = null; 
   var $k202_data_ano = null; 
   var $k202_data = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 k202_sequencial = int8 =  
                 k202_tipopendencia = varchar(30) =  
                 k202_descricao = varchar(20) = Descricao 
                 k202_valor = float8 = Valor 
                 k202_data = date = Data 
                 ";
   //funcao construtor da classe 
   function cl_tipopendencia() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("tipopendencia"); 
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
       $this->k202_sequencial = ($this->k202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["k202_sequencial"]:$this->k202_sequencial);
       $this->k202_tipopendencia = ($this->k202_tipopendencia == ""?@$GLOBALS["HTTP_POST_VARS"]["k202_tipopendencia"]:$this->k202_tipopendencia);
       $this->k202_descricao = ($this->k202_descricao == ""?@$GLOBALS["HTTP_POST_VARS"]["k202_descricao"]:$this->k202_descricao);
       $this->k202_valor = ($this->k202_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["k202_valor"]:$this->k202_valor);
       if($this->k202_data == ""){
         $this->k202_data_dia = ($this->k202_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k202_data_dia"]:$this->k202_data_dia);
         $this->k202_data_mes = ($this->k202_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k202_data_mes"]:$this->k202_data_mes);
         $this->k202_data_ano = ($this->k202_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k202_data_ano"]:$this->k202_data_ano);
         if($this->k202_data_dia != ""){
            $this->k202_data = $this->k202_data_ano."-".$this->k202_data_mes."-".$this->k202_data_dia;
         }
       }
     }else{
       $this->k202_sequencial = ($this->k202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["k202_sequencial"]:$this->k202_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($k202_sequencial){ 
      $this->atualizacampos();
     if($this->k202_tipopendencia == null ){ 
       $this->erro_sql = " Campo  nao Informado.";
       $this->erro_campo = "k202_tipopendencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k202_descricao == null ){ 
       $this->erro_sql = " Campo Descricao nao Informado.";
       $this->erro_campo = "k202_descricao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k202_valor == null ){ 
       $this->erro_sql = " Campo Valor nao Informado.";
       $this->erro_campo = "k202_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k202_data == null ){ 
       $this->erro_sql = " Campo Data nao Informado.";
       $this->erro_campo = "k202_data_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
    if(($this->k202_sequencial == null) || ($this->k202_sequencial == "") ){ 
     	$result = db_query("select nextval('cai_tipopendencia_k202_sequencial_seq')");
     	if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: cai_tipopendencia_k202_sequencial_seq do campo: k202_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
	   }
	   $this->k202_sequencial = pg_result($result,0,0);
     }else{
	$result = db_query("select last_value from cai_tipoconciliacao_k202_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $k202_sequencial)){
         $this->erro_sql = " Campo k202_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
		 $this->k202_sequencial = $k202_sequencial; 
       }
     }
     
     $sql = "insert into tipopendencia(
                                       k202_sequencial 
                                      ,k202_tipopendencia 
                                      ,k202_descricao 
                                      ,k202_valor 
                                      ,k202_data 
                       )
                values (
                                $this->k202_sequencial 
                               ,'$this->k202_tipopendencia' 
                               ,'$this->k202_descricao' 
                               ,$this->k202_valor 
                               ,".($this->k202_data == "null" || $this->k202_data == ""?"null":"'".$this->k202_data."'")." 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->k202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->k202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k202_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->k202_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,1009259,'$this->k202_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010212,2009356,'','".AddSlashes(pg_result($resaco,0,'k202_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010212,2009357,'','".AddSlashes(pg_result($resaco,0,'k202_tipopendencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010212,2009355,'','".AddSlashes(pg_result($resaco,0,'k202_descricao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010212,2009358,'','".AddSlashes(pg_result($resaco,0,'k202_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010212,2009354,'','".AddSlashes(pg_result($resaco,0,'k202_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($k202_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update tipopendencia set ";
     $virgula = "";
     if(trim($this->k202_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k202_sequencial"])){ 
       $sql  .= $virgula." k202_sequencial = $this->k202_sequencial ";
       $virgula = ",";
       if(trim($this->k202_sequencial) == null ){ 
         $this->erro_sql = " Campo  nao Informado.";
         $this->erro_campo = "k202_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k202_tipopendencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k202_tipopendencia"])){ 
       $sql  .= $virgula." k202_tipopendencia = '$this->k202_tipopendencia' ";
       $virgula = ",";
       if(trim($this->k202_tipopendencia) == null ){ 
         $this->erro_sql = " Campo  nao Informado.";
         $this->erro_campo = "k202_tipopendencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k202_descricao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k202_descricao"])){ 
       $sql  .= $virgula." k202_descricao = '$this->k202_descricao' ";
       $virgula = ",";
       if(trim($this->k202_descricao) == null ){ 
         $this->erro_sql = " Campo Descricao nao Informado.";
         $this->erro_campo = "k202_descricao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k202_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k202_valor"])){ 
       $sql  .= $virgula." k202_valor = $this->k202_valor ";
       $virgula = ",";
       if(trim($this->k202_valor) == null ){ 
         $this->erro_sql = " Campo Valor nao Informado.";
         $this->erro_campo = "k202_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k202_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k202_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k202_data_dia"] !="") ){ 
       $sql  .= $virgula." k202_data = '$this->k202_data' ";
       $virgula = ",";
       if(trim($this->k202_data) == null ){ 
         $this->erro_sql = " Campo Data nao Informado.";
         $this->erro_campo = "k202_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["k202_data_dia"])){ 
         $sql  .= $virgula." k202_data = null ";
         $virgula = ",";
         if(trim($this->k202_data) == null ){ 
           $this->erro_sql = " Campo Data nao Informado.";
           $this->erro_campo = "k202_data_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if($k202_sequencial!=null){
       $sql .= " k202_sequencial = $this->k202_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->k202_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009259,'$this->k202_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k202_sequencial"]) || $this->k202_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010212,2009356,'".AddSlashes(pg_result($resaco,$conresaco,'k202_sequencial'))."','$this->k202_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k202_tipopendencia"]) || $this->k202_tipopendencia != "")
           $resac = db_query("insert into db_acount values($acount,2010212,2009357,'".AddSlashes(pg_result($resaco,$conresaco,'k202_tipopendencia'))."','$this->k202_tipopendencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k202_descricao"]) || $this->k202_descricao != "")
           $resac = db_query("insert into db_acount values($acount,2010212,2009355,'".AddSlashes(pg_result($resaco,$conresaco,'k202_descricao'))."','$this->k202_descricao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k202_valor"]) || $this->k202_valor != "")
           $resac = db_query("insert into db_acount values($acount,2010212,2009358,'".AddSlashes(pg_result($resaco,$conresaco,'k202_valor'))."','$this->k202_valor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k202_data"]) || $this->k202_data != "")
           $resac = db_query("insert into db_acount values($acount,2010212,2009354,'".AddSlashes(pg_result($resaco,$conresaco,'k202_data'))."','$this->k202_data',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }		
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k202_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($k202_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($k202_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009259,'$k202_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010212,2009356,'','".AddSlashes(pg_result($resaco,$iresaco,'k202_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010212,2009357,'','".AddSlashes(pg_result($resaco,$iresaco,'k202_tipopendencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010212,2009355,'','".AddSlashes(pg_result($resaco,$iresaco,'k202_descricao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010212,2009358,'','".AddSlashes(pg_result($resaco,$iresaco,'k202_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010212,2009354,'','".AddSlashes(pg_result($resaco,$iresaco,'k202_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from tipopendencia
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($k202_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " k202_sequencial = $k202_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$k202_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$k202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{ 
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$k202_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:tipopendencia";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $k202_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from tipopendencia ";
     $sql2 = "";
     if($dbwhere==""){
       if($k202_sequencial!=null ){
         $sql2 .= " where tipopendencia.k202_sequencial = $k202_sequencial "; 
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
   function sql_query_file ( $k202_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from tipopendencia ";
     $sql2 = "";
     if($dbwhere==""){
       if($k202_sequencial!=null ){
         $sql2 .= " where tipopendencia.k202_sequencial = $k202_sequencial "; 
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
