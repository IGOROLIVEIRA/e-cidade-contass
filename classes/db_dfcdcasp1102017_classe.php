<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp1102017
class cl_dfcdcasp1102017 { 
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
   var $si229_sequencial = 0; 
   var $si229_tiporegistro = 0; 
   var $si229_exercicio = 0; 
   var $si229_vlcaixaequivalentecaixainicial = 0; 
   var $si229_vlcaixaequivalentecaixafinal = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si229_sequencial = int4 = si229_sequencial 
                 si229_tiporegistro = int4 = si229_tiporegistro 
                 si229_exercicio = int4 = si229_exercicio 
                 si229_vlcaixaequivalentecaixainicial = float4 = si229_vlcaixaequivalentecaixainicial 
                 si229_vlcaixaequivalentecaixafinal = float4 = si229_vlcaixaequivalentecaixafinal 
                 ";
   //funcao construtor da classe 
   function cl_dfcdcasp1102017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp1102017"); 
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
       $this->si229_sequencial = ($this->si229_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_sequencial"]:$this->si229_sequencial);
       $this->si229_tiporegistro = ($this->si229_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_tiporegistro"]:$this->si229_tiporegistro);
       $this->si229_exercicio = ($this->si229_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_exercicio"]:$this->si229_exercicio);
       $this->si229_vlcaixaequivalentecaixainicial = ($this->si229_vlcaixaequivalentecaixainicial == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixainicial"]:$this->si229_vlcaixaequivalentecaixainicial);
       $this->si229_vlcaixaequivalentecaixafinal = ($this->si229_vlcaixaequivalentecaixafinal == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixafinal"]:$this->si229_vlcaixaequivalentecaixafinal);
     }else{
       $this->si229_sequencial = ($this->si229_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_sequencial"]:$this->si229_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si229_sequencial){ 
      $this->atualizacampos();
     if($this->si229_tiporegistro == null ){ 
       $this->erro_sql = " Campo si229_tiporegistro não informado.";
       $this->erro_campo = "si229_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si229_exercicio == null ){ 
       $this->erro_sql = " Campo si229_exercicio não informado.";
       $this->erro_campo = "si229_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si229_vlcaixaequivalentecaixainicial == null ){ 
       $this->erro_sql = " Campo si229_vlcaixaequivalentecaixainicial não informado.";
       $this->erro_campo = "si229_vlcaixaequivalentecaixainicial";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si229_vlcaixaequivalentecaixafinal == null ){ 
       $this->erro_sql = " Campo si229_vlcaixaequivalentecaixafinal não informado.";
       $this->erro_campo = "si229_vlcaixaequivalentecaixafinal";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si229_sequencial = $si229_sequencial; 
     if(($this->si229_sequencial == null) || ($this->si229_sequencial == "") ){ 
       $this->erro_sql = " Campo si229_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dfcdcasp1102017(
                                       si229_sequencial 
                                      ,si229_tiporegistro 
                                      ,si229_exercicio 
                                      ,si229_vlcaixaequivalentecaixainicial 
                                      ,si229_vlcaixaequivalentecaixafinal 
                       )
                values (
                                $this->si229_sequencial 
                               ,$this->si229_tiporegistro 
                               ,$this->si229_exercicio 
                               ,$this->si229_vlcaixaequivalentecaixainicial 
                               ,$this->si229_vlcaixaequivalentecaixafinal 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp1102017 ($this->si229_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dfcdcasp1102017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dfcdcasp1102017 ($this->si229_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si229_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si229_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009537,'$this->si229_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010223,1009537,'','".AddSlashes(pg_result($resaco,0,'si229_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010223,1009538,'','".AddSlashes(pg_result($resaco,0,'si229_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010223,1009539,'','".AddSlashes(pg_result($resaco,0,'si229_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010223,1009540,'','".AddSlashes(pg_result($resaco,0,'si229_vlcaixaequivalentecaixainicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010223,1009541,'','".AddSlashes(pg_result($resaco,0,'si229_vlcaixaequivalentecaixafinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si229_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dfcdcasp1102017 set ";
     $virgula = "";
     if(trim($this->si229_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si229_sequencial"])){ 
       $sql  .= $virgula." si229_sequencial = $this->si229_sequencial ";
       $virgula = ",";
       if(trim($this->si229_sequencial) == null ){ 
         $this->erro_sql = " Campo si229_sequencial não informado.";
         $this->erro_campo = "si229_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si229_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si229_tiporegistro"])){ 
       $sql  .= $virgula." si229_tiporegistro = $this->si229_tiporegistro ";
       $virgula = ",";
       if(trim($this->si229_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si229_tiporegistro não informado.";
         $this->erro_campo = "si229_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si229_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si229_exercicio"])){ 
       $sql  .= $virgula." si229_exercicio = $this->si229_exercicio ";
       $virgula = ",";
       if(trim($this->si229_exercicio) == null ){ 
         $this->erro_sql = " Campo si229_exercicio não informado.";
         $this->erro_campo = "si229_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si229_vlcaixaequivalentecaixainicial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixainicial"])){ 
       $sql  .= $virgula." si229_vlcaixaequivalentecaixainicial = $this->si229_vlcaixaequivalentecaixainicial ";
       $virgula = ",";
       if(trim($this->si229_vlcaixaequivalentecaixainicial) == null ){ 
         $this->erro_sql = " Campo si229_vlcaixaequivalentecaixainicial não informado.";
         $this->erro_campo = "si229_vlcaixaequivalentecaixainicial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si229_vlcaixaequivalentecaixafinal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixafinal"])){ 
       $sql  .= $virgula." si229_vlcaixaequivalentecaixafinal = $this->si229_vlcaixaequivalentecaixafinal ";
       $virgula = ",";
       if(trim($this->si229_vlcaixaequivalentecaixafinal) == null ){ 
         $this->erro_sql = " Campo si229_vlcaixaequivalentecaixafinal não informado.";
         $this->erro_campo = "si229_vlcaixaequivalentecaixafinal";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si229_sequencial!=null){
       $sql .= " si229_sequencial = $this->si229_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si229_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009537,'$this->si229_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si229_sequencial"]) || $this->si229_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010223,1009537,'".AddSlashes(pg_result($resaco,$conresaco,'si229_sequencial'))."','$this->si229_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si229_tiporegistro"]) || $this->si229_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010223,1009538,'".AddSlashes(pg_result($resaco,$conresaco,'si229_tiporegistro'))."','$this->si229_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si229_exercicio"]) || $this->si229_exercicio != "")
             $resac = db_query("insert into db_acount values($acount,1010223,1009539,'".AddSlashes(pg_result($resaco,$conresaco,'si229_exercicio'))."','$this->si229_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixainicial"]) || $this->si229_vlcaixaequivalentecaixainicial != "")
             $resac = db_query("insert into db_acount values($acount,1010223,1009540,'".AddSlashes(pg_result($resaco,$conresaco,'si229_vlcaixaequivalentecaixainicial'))."','$this->si229_vlcaixaequivalentecaixainicial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixafinal"]) || $this->si229_vlcaixaequivalentecaixafinal != "")
             $resac = db_query("insert into db_acount values($acount,1010223,1009541,'".AddSlashes(pg_result($resaco,$conresaco,'si229_vlcaixaequivalentecaixafinal'))."','$this->si229_vlcaixaequivalentecaixafinal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp1102017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si229_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp1102017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si229_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si229_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si229_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si229_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009537,'$si229_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010223,1009537,'','".AddSlashes(pg_result($resaco,$iresaco,'si229_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010223,1009538,'','".AddSlashes(pg_result($resaco,$iresaco,'si229_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010223,1009539,'','".AddSlashes(pg_result($resaco,$iresaco,'si229_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010223,1009540,'','".AddSlashes(pg_result($resaco,$iresaco,'si229_vlcaixaequivalentecaixainicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010223,1009541,'','".AddSlashes(pg_result($resaco,$iresaco,'si229_vlcaixaequivalentecaixafinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from dfcdcasp1102017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si229_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si229_sequencial = $si229_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp1102017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si229_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp1102017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si229_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si229_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp1102017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si229_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp1102017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si229_sequencial!=null ){
         $sql2 .= " where dfcdcasp1102017.si229_sequencial = $si229_sequencial "; 
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
   function sql_query_file ( $si229_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp1102017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si229_sequencial!=null ){
         $sql2 .= " where dfcdcasp1102017.si229_sequencial = $si229_sequencial "; 
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
