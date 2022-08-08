<?
//MODULO: licitacao
//CLASSE DA ENTIDADE licpregao
class cl_licpregao { 
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
   var $l45_sequencial = 0; 
   var $l45_data_dia = null; 
   var $l45_data_mes = null; 
   var $l45_data_ano = null; 
   var $l45_data = null; 
   var $l45_numatonomeacao = null; 
   var $l45_descrnomeacao = null;
   var $l45_validade_dia = null; 
   var $l45_validade_mes = null; 
   var $l45_validade_ano = null; 
   var $l45_validade = null; 
   var $l45_tipo = 0;
   var $l45_instit = 0;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 l45_sequencial = int8 = Sequencial 
                 l45_data = date = Data 
                 l45_validade = date = Validade 
                 l45_tipo = int8 = Tipo 
                 l45_descrnomeacao= int8 = Tipo
                 l45_numatonomeacao= int8 = Tipo
                 l45_instit = int4 = codigo da instituicao
                 ";
   //funcao construtor da classe 
   function cl_licpregao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("licpregao"); 
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
       $this->l45_sequencial = ($this->l45_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_sequencial"]:$this->l45_sequencial);
       if($this->l45_data == ""){
         $this->l45_data_dia = ($this->l45_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_data_dia"]:$this->l45_data_dia);
         $this->l45_data_mes = ($this->l45_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_data_mes"]:$this->l45_data_mes);
         $this->l45_data_ano = ($this->l45_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_data_ano"]:$this->l45_data_ano);
         if($this->l45_data_dia != ""){
            $this->l45_data = $this->l45_data_ano."-".$this->l45_data_mes."-".$this->l45_data_dia;
         }
       }
       $this->l45_instit = ($this->l45_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_instit"]:$this->l45_instit);
       $this->l45_descrnomeacao = ($this->l45_descrnomeacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_descrnomeacao"]:$this->l45_descrnomeacao);
       $this->l45_numatonomeacao = ($this->l45_numatonomeacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_numatonomeacao"]:$this->l45_numatonomeacao);
       if($this->l45_validade == ""){
         $this->l45_validade_dia = ($this->l45_validade_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_validade_dia"]:$this->l45_validade_dia);
         $this->l45_validade_mes = ($this->l45_validade_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_validade_mes"]:$this->l45_validade_mes);
         $this->l45_validade_ano = ($this->l45_validade_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_validade_ano"]:$this->l45_validade_ano);
         if($this->l45_validade_dia != ""){
            $this->l45_validade = $this->l45_validade_ano."-".$this->l45_validade_mes."-".$this->l45_validade_dia;
         }
       }
       $this->l45_tipo = ($this->l45_tipo == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_tipo"]:$this->l45_tipo);
     }else{
       $this->l45_sequencial = ($this->l45_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l45_sequencial"]:$this->l45_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($l45_sequencial){ 
      $this->atualizacampos();
     if($this->l45_data == null ){ 
       $this->erro_sql = " Campo Data não informado.";
       $this->erro_campo = "l45_data_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
  
     if($this->l45_validade == null ){ 
       $this->erro_sql = " Campo Validade não informado.";
       $this->erro_campo = "l45_validade_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l45_tipo == null ){ 
       $this->erro_sql = " Campo Tipo não informado.";
       $this->erro_campo = "l45_tipo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       
    if(($this->l45_sequencial == null) || ($this->l45_sequencial == "") ){
      $result = db_query("select nextval('licpregao_l45_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: lic_licpregao_l45_sequencial_seq do campo: l45_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->l45_sequencial = pg_result($result,0,0);
    }else{
      $result = db_query("select last_value from licpregao_l45_sequencial_seq");
      if(($result != false) && (pg_result($result,0,0) < $l45_sequencial)){
        $this->erro_sql = " Campo l45_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }else{
        $this->l45_sequencial = $l45_sequencial;
      }
    }


     $sql = "insert into licpregao(
                                       l45_sequencial 
                                      ,l45_data 
                                      ,l45_validade 
                                      ,l45_tipo 
                                      ,l45_descrnomeacao
                                      ,l45_numatonomeacao
                                      ,l45_instit
                       )
                values (
                                $this->l45_sequencial 
                               ,".($this->l45_data == "null" || $this->l45_data == ""?"null":"'".$this->l45_data."'")." 
                               ,".($this->l45_validade == "null" || $this->l45_validade == ""?"null":"'".$this->l45_validade."'")." 
                               ,$this->l45_tipo 
                                ,$this->l45_descrnomeacao
                                ,$this->l45_numatonomeacao
                                ,$this->l45_instit
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "licpregao ($this->l45_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "licpregao já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "licpregao ($this->l45_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l45_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->l45_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009529,'$this->l45_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,2010235,2009529,'','".AddSlashes(pg_result($resaco,0,'l45_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010235,2009530,'','".AddSlashes(pg_result($resaco,0,'l45_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010235,2009532,'','".AddSlashes(pg_result($resaco,0,'l45_validade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010235,2009533,'','".AddSlashes(pg_result($resaco,0,'l45_tipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($l45_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update licpregao set ";
     $virgula = "";
     if(trim($this->l45_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l45_sequencial"])){ 
       $sql  .= $virgula." l45_sequencial = $this->l45_sequencial ";
       $virgula = ",";
       if(trim($this->l45_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "l45_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l45_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l45_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l45_data_dia"] !="") ){ 
       $sql  .= $virgula." l45_data = '$this->l45_data' ";
       $virgula = ",";
       if(trim($this->l45_data) == null ){ 
         $this->erro_sql = " Campo Data não informado.";
         $this->erro_campo = "l45_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l45_data_dia"])){ 
         $sql  .= $virgula." l45_data = null ";
         $virgula = ",";
         if(trim($this->l45_data) == null ){ 
           $this->erro_sql = " Campo Data não informado.";
           $this->erro_campo = "l45_data_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
  
     if(trim($this->l45_validade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l45_validade_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l45_validade_dia"] !="") ){ 
       $sql  .= $virgula." l45_validade = '$this->l45_validade' ";
       $virgula = ",";
       if(trim($this->l45_validade) == null ){ 
         $this->erro_sql = " Campo Validade não informado.";
         $this->erro_campo = "l45_validade_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l45_validade_dia"])){ 
         $sql  .= $virgula." l45_validade = null ";
         $virgula = ",";
         if(trim($this->l45_validade) == null ){ 
           $this->erro_sql = " Campo Validade não informado.";
           $this->erro_campo = "l45_validade_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->l45_tipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l45_tipo"])){ 
       $sql  .= $virgula." l45_tipo = $this->l45_tipo ";
       $virgula = ",";
       if(trim($this->l45_tipo) == null ){ 
         $this->erro_sql = " Campo Tipo não informado.";
         $this->erro_campo = "l45_tipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
   if(trim($this->l45_descrnomeacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l45_descrnomeacao"])){ 
       $sql  .= $virgula." l45_descrnomeacao = '$this->l45_descrnomeacao' ";
       $virgula = ",";
       if(trim($this->l45_descrnomeacao) == null ){ 
         $this->erro_sql = " Campo Desc. ato de Nomeacao não informado.";
         $this->erro_campo = "l45_descrnomeacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
   if(trim($this->l45_numatonomeacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l45_numatonomeacao"])){ 
       $sql  .= $virgula." l45_numatonomeacao = '$this->l45_numatonomeacao' ";
       $virgula = ",";
       if(trim($this->l45_numatonomeacao) == null ){ 
         $this->erro_sql = " Campo Nº ato nomeacao não informado.";
         $this->erro_campo = "l45_numatonomeacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }

       if(trim($this->l45_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l45_instit"])){
           $sql  .= $virgula." l45_instit = $this->l45_instit ";
           $virgula = ",";
           if(trim($this->l45_instit) == null ){
               $this->erro_sql = " Campo codigo da instituicao não Informado.";
               $this->erro_campo = "l45_instit";
               $this->erro_banco = "";
               $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
               $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
               $this->erro_status = "0";
               return false;
           }
       }
     
     
     
     
     
     $sql .= " where ";
     if($l45_sequencial!=null){
       $sql .= " l45_sequencial = $this->l45_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->l45_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2009529,'$this->l45_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["l45_sequencial"]) || $this->l45_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,2010235,2009529,'".AddSlashes(pg_result($resaco,$conresaco,'l45_sequencial'))."','$this->l45_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["l45_data"]) || $this->l45_data != "")
             $resac = db_query("insert into db_acount values($acount,2010235,2009530,'".AddSlashes(pg_result($resaco,$conresaco,'l45_data'))."','$this->l45_data',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         
           if(isset($GLOBALS["HTTP_POST_VARS"]["l45_validade"]) || $this->l45_validade != "")
             $resac = db_query("insert into db_acount values($acount,2010235,2009532,'".AddSlashes(pg_result($resaco,$conresaco,'l45_validade'))."','$this->l45_validade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["l45_tipo"]) || $this->l45_tipo != "")
             $resac = db_query("insert into db_acount values($acount,2010235,2009533,'".AddSlashes(pg_result($resaco,$conresaco,'l45_tipo'))."','$this->l45_tipo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "licpregao nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->l45_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "licpregao nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->l45_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l45_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($l45_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($l45_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2009529,'$l45_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,2010235,2009529,'','".AddSlashes(pg_result($resaco,$iresaco,'l45_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2010235,2009530,'','".AddSlashes(pg_result($resaco,$iresaco,'l45_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           
           $resac  = db_query("insert into db_acount values($acount,2010235,2009532,'','".AddSlashes(pg_result($resaco,$iresaco,'l45_validade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2010235,2009533,'','".AddSlashes(pg_result($resaco,$iresaco,'l45_tipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from licpregao
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($l45_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " l45_sequencial = $l45_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "licpregao nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$l45_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "licpregao nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$l45_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$l45_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:licpregao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $l45_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from licpregao ";
     $sql2 = "";
     if($dbwhere==""){
       if($l45_sequencial!=null ){
         $sql2 .= " where licpregao.l45_sequencial = $l45_sequencial "; 
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
   function sql_query_file ( $l45_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from licpregao ";
     $sql2 = "";
     if($dbwhere==""){
       if($l45_sequencial!=null ){
         $sql2 .= " where licpregao.l45_sequencial = $l45_sequencial "; 
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
