<?
//MODULO: sicom
//CLASSE DA ENTIDADE consor222014
class cl_consor222014 { 
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
   var $si19_sequencial = 0; 
   var $si19_tiporegistro = 0; 
   var $si19_cnpjconsorcio = null; 
   var $si19_vldispcaixa = 0; 
   var $si19_mes = 0; 
   var $si19_reg20 = 0; 
   var $si19_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si19_sequencial = int8 = sequencial 
                 si19_tiporegistro = int8 = Tipo do registro 
                 si19_cnpjconsorcio = varchar(14) = Código do  Consórcio 
                 si19_vldispcaixa = float8 = Valor da  disponibilidade 
                 si19_mes = int8 = Mês 
                 si19_reg20 = int8 = reg20 
                 si19_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_consor222014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("consor222014"); 
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
       $this->si19_sequencial = ($this->si19_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si19_sequencial"]:$this->si19_sequencial);
       $this->si19_tiporegistro = ($this->si19_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si19_tiporegistro"]:$this->si19_tiporegistro);
       $this->si19_cnpjconsorcio = ($this->si19_cnpjconsorcio == ""?@$GLOBALS["HTTP_POST_VARS"]["si19_cnpjconsorcio"]:$this->si19_cnpjconsorcio);
       $this->si19_vldispcaixa = ($this->si19_vldispcaixa == ""?@$GLOBALS["HTTP_POST_VARS"]["si19_vldispcaixa"]:$this->si19_vldispcaixa);
       $this->si19_mes = ($this->si19_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si19_mes"]:$this->si19_mes);
       $this->si19_reg20 = ($this->si19_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si19_reg20"]:$this->si19_reg20);
       $this->si19_instit = ($this->si19_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si19_instit"]:$this->si19_instit);
     }else{
       $this->si19_sequencial = ($this->si19_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si19_sequencial"]:$this->si19_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si19_sequencial){ 
      $this->atualizacampos();
     if($this->si19_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si19_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si19_vldispcaixa == null ){ 
       $this->si19_vldispcaixa = "0";
     }
     if($this->si19_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si19_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si19_reg20 == null ){ 
       $this->si19_reg20 = "0";
     }
     if($this->si19_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si19_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si19_sequencial == "" || $si19_sequencial == null ){
       $result = db_query("select nextval('consor222014_si19_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: consor222014_si19_sequencial_seq do campo: si19_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si19_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from consor222014_si19_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si19_sequencial)){
         $this->erro_sql = " Campo si19_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si19_sequencial = $si19_sequencial; 
       }
     }
     if(($this->si19_sequencial == null) || ($this->si19_sequencial == "") ){ 
       $this->erro_sql = " Campo si19_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into consor222014(
                                       si19_sequencial 
                                      ,si19_tiporegistro 
                                      ,si19_cnpjconsorcio 
                                      ,si19_vldispcaixa 
                                      ,si19_mes 
                                      ,si19_reg20 
                                      ,si19_instit 
                       )
                values (
                                $this->si19_sequencial 
                               ,$this->si19_tiporegistro 
                               ,'$this->si19_cnpjconsorcio' 
                               ,$this->si19_vldispcaixa 
                               ,$this->si19_mes 
                               ,$this->si19_reg20 
                               ,$this->si19_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "consor222014 ($this->si19_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "consor222014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "consor222014 ($this->si19_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si19_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si19_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009646,'$this->si19_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010247,2009646,'','".AddSlashes(pg_result($resaco,0,'si19_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010247,2009643,'','".AddSlashes(pg_result($resaco,0,'si19_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010247,2009644,'','".AddSlashes(pg_result($resaco,0,'si19_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010247,2009645,'','".AddSlashes(pg_result($resaco,0,'si19_vldispcaixa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010247,2009739,'','".AddSlashes(pg_result($resaco,0,'si19_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010247,2011324,'','".AddSlashes(pg_result($resaco,0,'si19_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010247,2011537,'','".AddSlashes(pg_result($resaco,0,'si19_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si19_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update consor222014 set ";
     $virgula = "";
     if(trim($this->si19_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si19_sequencial"])){ 
        if(trim($this->si19_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si19_sequencial"])){ 
           $this->si19_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si19_sequencial = $this->si19_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si19_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si19_tiporegistro"])){ 
       $sql  .= $virgula." si19_tiporegistro = $this->si19_tiporegistro ";
       $virgula = ",";
       if(trim($this->si19_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si19_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si19_cnpjconsorcio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si19_cnpjconsorcio"])){ 
       $sql  .= $virgula." si19_cnpjconsorcio = '$this->si19_cnpjconsorcio' ";
       $virgula = ",";
     }
     if(trim($this->si19_vldispcaixa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si19_vldispcaixa"])){ 
        if(trim($this->si19_vldispcaixa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si19_vldispcaixa"])){ 
           $this->si19_vldispcaixa = "0" ; 
        } 
       $sql  .= $virgula." si19_vldispcaixa = $this->si19_vldispcaixa ";
       $virgula = ",";
     }
     if(trim($this->si19_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si19_mes"])){ 
       $sql  .= $virgula." si19_mes = $this->si19_mes ";
       $virgula = ",";
       if(trim($this->si19_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si19_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si19_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si19_reg20"])){ 
        if(trim($this->si19_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si19_reg20"])){ 
           $this->si19_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si19_reg20 = $this->si19_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si19_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si19_instit"])){ 
       $sql  .= $virgula." si19_instit = $this->si19_instit ";
       $virgula = ",";
       if(trim($this->si19_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si19_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si19_sequencial!=null){
       $sql .= " si19_sequencial = $this->si19_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si19_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009646,'$this->si19_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si19_sequencial"]) || $this->si19_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010247,2009646,'".AddSlashes(pg_result($resaco,$conresaco,'si19_sequencial'))."','$this->si19_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si19_tiporegistro"]) || $this->si19_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010247,2009643,'".AddSlashes(pg_result($resaco,$conresaco,'si19_tiporegistro'))."','$this->si19_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si19_cnpjconsorcio"]) || $this->si19_cnpjconsorcio != "")
           $resac = db_query("insert into db_acount values($acount,2010247,2009644,'".AddSlashes(pg_result($resaco,$conresaco,'si19_cnpjconsorcio'))."','$this->si19_cnpjconsorcio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si19_vldispcaixa"]) || $this->si19_vldispcaixa != "")
           $resac = db_query("insert into db_acount values($acount,2010247,2009645,'".AddSlashes(pg_result($resaco,$conresaco,'si19_vldispcaixa'))."','$this->si19_vldispcaixa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si19_mes"]) || $this->si19_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010247,2009739,'".AddSlashes(pg_result($resaco,$conresaco,'si19_mes'))."','$this->si19_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si19_reg20"]) || $this->si19_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010247,2011324,'".AddSlashes(pg_result($resaco,$conresaco,'si19_reg20'))."','$this->si19_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si19_instit"]) || $this->si19_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010247,2011537,'".AddSlashes(pg_result($resaco,$conresaco,'si19_instit'))."','$this->si19_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "consor222014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si19_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "consor222014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si19_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si19_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si19_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si19_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009646,'$si19_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010247,2009646,'','".AddSlashes(pg_result($resaco,$iresaco,'si19_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010247,2009643,'','".AddSlashes(pg_result($resaco,$iresaco,'si19_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010247,2009644,'','".AddSlashes(pg_result($resaco,$iresaco,'si19_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010247,2009645,'','".AddSlashes(pg_result($resaco,$iresaco,'si19_vldispcaixa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010247,2009739,'','".AddSlashes(pg_result($resaco,$iresaco,'si19_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010247,2011324,'','".AddSlashes(pg_result($resaco,$iresaco,'si19_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010247,2011537,'','".AddSlashes(pg_result($resaco,$iresaco,'si19_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from consor222014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si19_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si19_sequencial = $si19_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "consor222014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si19_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "consor222014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si19_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si19_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:consor222014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si19_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consor222014 ";
     $sql .= "      left  join consor202014  on  consor202014.si17_sequencial = consor222014.si19_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si19_sequencial!=null ){
         $sql2 .= " where consor222014.si19_sequencial = $si19_sequencial "; 
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
   function sql_query_file ( $si19_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consor222014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si19_sequencial!=null ){
         $sql2 .= " where consor222014.si19_sequencial = $si19_sequencial "; 
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
