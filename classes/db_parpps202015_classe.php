<?
//MODULO: sicom
//CLASSE DA ENTIDADE parpps202015
class cl_parpps202015 { 
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
   var $si155_sequencial = 0; 
   var $si155_tiporegistro = 0; 
   var $si155_codorgao = null; 
   var $si155_exercicio = 0; 
   var $si155_vlreceitaprevidenciaria = 0; 
   var $si155_vldespesaprevidenciaria = 0; 
   var $si155_mes = 0; 
   var $si155_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si155_sequencial = int8 = sequencial 
                 si155_tiporegistro = int8 = Tipo do  registro 
                 si155_codorgao = varchar(2) = Código do órgão 
                 si155_exercicio = int8 = Exercício 
                 si155_vlreceitaprevidenciaria = float8 = Valor projetado  das receitas 
                 si155_vldespesaprevidenciaria = float8 = Valor projetado das despesas 
                 si155_mes = int8 = Mês 
                 si155_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_parpps202015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("parpps202015"); 
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
       $this->si155_sequencial = ($this->si155_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si155_sequencial"]:$this->si155_sequencial);
       $this->si155_tiporegistro = ($this->si155_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si155_tiporegistro"]:$this->si155_tiporegistro);
       $this->si155_codorgao = ($this->si155_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si155_codorgao"]:$this->si155_codorgao);
       $this->si155_exercicio = ($this->si155_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si155_exercicio"]:$this->si155_exercicio);
       $this->si155_vlreceitaprevidenciaria = ($this->si155_vlreceitaprevidenciaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si155_vlreceitaprevidenciaria"]:$this->si155_vlreceitaprevidenciaria);
       $this->si155_vldespesaprevidenciaria = ($this->si155_vldespesaprevidenciaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si155_vldespesaprevidenciaria"]:$this->si155_vldespesaprevidenciaria);
       $this->si155_mes = ($this->si155_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si155_mes"]:$this->si155_mes);
       $this->si155_instit = ($this->si155_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si155_instit"]:$this->si155_instit);
     }else{
       $this->si155_sequencial = ($this->si155_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si155_sequencial"]:$this->si155_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si155_sequencial){ 
      $this->atualizacampos();
     if($this->si155_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si155_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si155_exercicio == null ){ 
       $this->si155_exercicio = "0";
     }
     if($this->si155_vlreceitaprevidenciaria == null ){ 
       $this->si155_vlreceitaprevidenciaria = "0";
     }
     if($this->si155_vldespesaprevidenciaria == null ){ 
       $this->si155_vldespesaprevidenciaria = "0";
     }
     if($this->si155_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si155_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si155_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si155_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si155_sequencial == "" || $si155_sequencial == null ){
       $result = db_query("select nextval('parpps202015_si155_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: parpps202015_si155_sequencial_seq do campo: si155_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si155_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from parpps202015_si155_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si155_sequencial)){
         $this->erro_sql = " Campo si155_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si155_sequencial = $si155_sequencial; 
       }
     }
     if(($this->si155_sequencial == null) || ($this->si155_sequencial == "") ){ 
       $this->erro_sql = " Campo si155_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into parpps202015(
                                       si155_sequencial 
                                      ,si155_tiporegistro 
                                      ,si155_codorgao 
                                      ,si155_exercicio 
                                      ,si155_vlreceitaprevidenciaria 
                                      ,si155_vldespesaprevidenciaria 
                                      ,si155_mes 
                                      ,si155_instit 
                       )
                values (
                                $this->si155_sequencial 
                               ,$this->si155_tiporegistro 
                               ,'$this->si155_codorgao' 
                               ,$this->si155_exercicio 
                               ,$this->si155_vlreceitaprevidenciaria 
                               ,$this->si155_vldespesaprevidenciaria 
                               ,$this->si155_mes 
                               ,$this->si155_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "parpps202015 ($this->si155_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "parpps202015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "parpps202015 ($this->si155_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si155_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si155_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011187,'$this->si155_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010384,2011187,'','".AddSlashes(pg_result($resaco,0,'si155_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010384,2011188,'','".AddSlashes(pg_result($resaco,0,'si155_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010384,2011189,'','".AddSlashes(pg_result($resaco,0,'si155_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010384,2011190,'','".AddSlashes(pg_result($resaco,0,'si155_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010384,2011191,'','".AddSlashes(pg_result($resaco,0,'si155_vlreceitaprevidenciaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010384,2011192,'','".AddSlashes(pg_result($resaco,0,'si155_vldespesaprevidenciaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010384,2011193,'','".AddSlashes(pg_result($resaco,0,'si155_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010384,2011668,'','".AddSlashes(pg_result($resaco,0,'si155_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si155_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update parpps202015 set ";
     $virgula = "";
     if(trim($this->si155_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si155_sequencial"])){ 
        if(trim($this->si155_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si155_sequencial"])){ 
           $this->si155_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si155_sequencial = $this->si155_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si155_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si155_tiporegistro"])){ 
       $sql  .= $virgula." si155_tiporegistro = $this->si155_tiporegistro ";
       $virgula = ",";
       if(trim($this->si155_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si155_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si155_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si155_codorgao"])){ 
       $sql  .= $virgula." si155_codorgao = '$this->si155_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si155_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si155_exercicio"])){ 
        if(trim($this->si155_exercicio)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si155_exercicio"])){ 
           $this->si155_exercicio = "0" ; 
        } 
       $sql  .= $virgula." si155_exercicio = $this->si155_exercicio ";
       $virgula = ",";
     }
     if(trim($this->si155_vlreceitaprevidenciaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si155_vlreceitaprevidenciaria"])){ 
        if(trim($this->si155_vlreceitaprevidenciaria)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si155_vlreceitaprevidenciaria"])){ 
           $this->si155_vlreceitaprevidenciaria = "0" ; 
        } 
       $sql  .= $virgula." si155_vlreceitaprevidenciaria = $this->si155_vlreceitaprevidenciaria ";
       $virgula = ",";
     }
     if(trim($this->si155_vldespesaprevidenciaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si155_vldespesaprevidenciaria"])){ 
        if(trim($this->si155_vldespesaprevidenciaria)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si155_vldespesaprevidenciaria"])){ 
           $this->si155_vldespesaprevidenciaria = "0" ; 
        } 
       $sql  .= $virgula." si155_vldespesaprevidenciaria = $this->si155_vldespesaprevidenciaria ";
       $virgula = ",";
     }
     if(trim($this->si155_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si155_mes"])){ 
       $sql  .= $virgula." si155_mes = $this->si155_mes ";
       $virgula = ",";
       if(trim($this->si155_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si155_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si155_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si155_instit"])){ 
       $sql  .= $virgula." si155_instit = $this->si155_instit ";
       $virgula = ",";
       if(trim($this->si155_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si155_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si155_sequencial!=null){
       $sql .= " si155_sequencial = $this->si155_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si155_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011187,'$this->si155_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si155_sequencial"]) || $this->si155_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010384,2011187,'".AddSlashes(pg_result($resaco,$conresaco,'si155_sequencial'))."','$this->si155_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si155_tiporegistro"]) || $this->si155_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010384,2011188,'".AddSlashes(pg_result($resaco,$conresaco,'si155_tiporegistro'))."','$this->si155_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si155_codorgao"]) || $this->si155_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010384,2011189,'".AddSlashes(pg_result($resaco,$conresaco,'si155_codorgao'))."','$this->si155_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si155_exercicio"]) || $this->si155_exercicio != "")
           $resac = db_query("insert into db_acount values($acount,2010384,2011190,'".AddSlashes(pg_result($resaco,$conresaco,'si155_exercicio'))."','$this->si155_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si155_vlreceitaprevidenciaria"]) || $this->si155_vlreceitaprevidenciaria != "")
           $resac = db_query("insert into db_acount values($acount,2010384,2011191,'".AddSlashes(pg_result($resaco,$conresaco,'si155_vlreceitaprevidenciaria'))."','$this->si155_vlreceitaprevidenciaria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si155_vldespesaprevidenciaria"]) || $this->si155_vldespesaprevidenciaria != "")
           $resac = db_query("insert into db_acount values($acount,2010384,2011192,'".AddSlashes(pg_result($resaco,$conresaco,'si155_vldespesaprevidenciaria'))."','$this->si155_vldespesaprevidenciaria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si155_mes"]) || $this->si155_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010384,2011193,'".AddSlashes(pg_result($resaco,$conresaco,'si155_mes'))."','$this->si155_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si155_instit"]) || $this->si155_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010384,2011668,'".AddSlashes(pg_result($resaco,$conresaco,'si155_instit'))."','$this->si155_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "parpps202015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si155_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "parpps202015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si155_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si155_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si155_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si155_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011187,'$si155_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010384,2011187,'','".AddSlashes(pg_result($resaco,$iresaco,'si155_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010384,2011188,'','".AddSlashes(pg_result($resaco,$iresaco,'si155_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010384,2011189,'','".AddSlashes(pg_result($resaco,$iresaco,'si155_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010384,2011190,'','".AddSlashes(pg_result($resaco,$iresaco,'si155_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010384,2011191,'','".AddSlashes(pg_result($resaco,$iresaco,'si155_vlreceitaprevidenciaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010384,2011192,'','".AddSlashes(pg_result($resaco,$iresaco,'si155_vldespesaprevidenciaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010384,2011193,'','".AddSlashes(pg_result($resaco,$iresaco,'si155_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010384,2011668,'','".AddSlashes(pg_result($resaco,$iresaco,'si155_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from parpps202015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si155_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si155_sequencial = $si155_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "parpps202015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si155_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "parpps202015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si155_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si155_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:parpps202015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si155_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from parpps202015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si155_sequencial!=null ){
         $sql2 .= " where parpps202015.si155_sequencial = $si155_sequencial "; 
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
   function sql_query_file ( $si155_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from parpps202015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si155_sequencial!=null ){
         $sql2 .= " where parpps202015.si155_sequencial = $si155_sequencial "; 
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
