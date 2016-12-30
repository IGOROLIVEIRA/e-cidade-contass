<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp202017
class cl_dfcdcasp202017 { 
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
   var $si220_sequencial = 0; 
   var $si220_tiporegistro = 0; 
   var $si220_exercicio = 0; 
   var $si220_vldesembolsopessoaldespesas = 0; 
   var $si220_vldesembolsojurosencargdivida = 0; 
   var $si220_vldesembolsotransfconcedidas = 0; 
   var $si220_vloutrosdesembolsos = 0; 
   var $si220_vltotaldesembolsosativoperacionais = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si220_sequencial = int4 = si220_sequencial 
                 si220_tiporegistro = int4 = si220_tiporegistro 
                 si220_exercicio = int4 = si220_exercicio 
                 si220_vldesembolsopessoaldespesas = float4 = si220_vldesembolsopessoaldespesas 
                 si220_vldesembolsojurosencargdivida = float4 = si220_vldesembolsojurosencargdivida 
                 si220_vldesembolsotransfconcedidas = float4 = si220_vldesembolsotransfconcedidas 
                 si220_vloutrosdesembolsos = float4 = si220_vloutrosdesembolsos 
                 si220_vltotaldesembolsosativoperacionais = float4 = si220_vltotaldesembolsosativoperacionais 
                 ";
   //funcao construtor da classe 
   function cl_dfcdcasp202017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp202017"); 
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
       $this->si220_sequencial = ($this->si220_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si220_sequencial"]:$this->si220_sequencial);
       $this->si220_tiporegistro = ($this->si220_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si220_tiporegistro"]:$this->si220_tiporegistro);
       $this->si220_exercicio = ($this->si220_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si220_exercicio"]:$this->si220_exercicio);
       $this->si220_vldesembolsopessoaldespesas = ($this->si220_vldesembolsopessoaldespesas == ""?@$GLOBALS["HTTP_POST_VARS"]["si220_vldesembolsopessoaldespesas"]:$this->si220_vldesembolsopessoaldespesas);
       $this->si220_vldesembolsojurosencargdivida = ($this->si220_vldesembolsojurosencargdivida == ""?@$GLOBALS["HTTP_POST_VARS"]["si220_vldesembolsojurosencargdivida"]:$this->si220_vldesembolsojurosencargdivida);
       $this->si220_vldesembolsotransfconcedidas = ($this->si220_vldesembolsotransfconcedidas == ""?@$GLOBALS["HTTP_POST_VARS"]["si220_vldesembolsotransfconcedidas"]:$this->si220_vldesembolsotransfconcedidas);
       $this->si220_vloutrosdesembolsos = ($this->si220_vloutrosdesembolsos == ""?@$GLOBALS["HTTP_POST_VARS"]["si220_vloutrosdesembolsos"]:$this->si220_vloutrosdesembolsos);
       $this->si220_vltotaldesembolsosativoperacionais = ($this->si220_vltotaldesembolsosativoperacionais == ""?@$GLOBALS["HTTP_POST_VARS"]["si220_vltotaldesembolsosativoperacionais"]:$this->si220_vltotaldesembolsosativoperacionais);
     }else{
       $this->si220_sequencial = ($this->si220_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si220_sequencial"]:$this->si220_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si220_sequencial){ 
      $this->atualizacampos();
     if($this->si220_tiporegistro == null ){ 
       $this->erro_sql = " Campo si220_tiporegistro não informado.";
       $this->erro_campo = "si220_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si220_exercicio == null ){ 
       $this->erro_sql = " Campo si220_exercicio não informado.";
       $this->erro_campo = "si220_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si220_vldesembolsopessoaldespesas == null ){ 
       $this->erro_sql = " Campo si220_vldesembolsopessoaldespesas não informado.";
       $this->erro_campo = "si220_vldesembolsopessoaldespesas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si220_vldesembolsojurosencargdivida == null ){ 
       $this->erro_sql = " Campo si220_vldesembolsojurosencargdivida não informado.";
       $this->erro_campo = "si220_vldesembolsojurosencargdivida";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si220_vldesembolsotransfconcedidas == null ){ 
       $this->erro_sql = " Campo si220_vldesembolsotransfconcedidas não informado.";
       $this->erro_campo = "si220_vldesembolsotransfconcedidas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si220_vloutrosdesembolsos == null ){ 
       $this->erro_sql = " Campo si220_vloutrosdesembolsos não informado.";
       $this->erro_campo = "si220_vloutrosdesembolsos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si220_vltotaldesembolsosativoperacionais == null ){ 
       $this->erro_sql = " Campo si220_vltotaldesembolsosativoperacionais não informado.";
       $this->erro_campo = "si220_vltotaldesembolsosativoperacionais";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si220_sequencial = $si220_sequencial; 
     if(($this->si220_sequencial == null) || ($this->si220_sequencial == "") ){ 
       $this->erro_sql = " Campo si220_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dfcdcasp202017(
                                       si220_sequencial 
                                      ,si220_tiporegistro 
                                      ,si220_exercicio 
                                      ,si220_vldesembolsopessoaldespesas 
                                      ,si220_vldesembolsojurosencargdivida 
                                      ,si220_vldesembolsotransfconcedidas 
                                      ,si220_vloutrosdesembolsos 
                                      ,si220_vltotaldesembolsosativoperacionais 
                       )
                values (
                                $this->si220_sequencial 
                               ,$this->si220_tiporegistro 
                               ,$this->si220_exercicio 
                               ,$this->si220_vldesembolsopessoaldespesas 
                               ,$this->si220_vldesembolsojurosencargdivida 
                               ,$this->si220_vldesembolsotransfconcedidas 
                               ,$this->si220_vloutrosdesembolsos 
                               ,$this->si220_vltotaldesembolsosativoperacionais 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp202017 ($this->si220_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dfcdcasp202017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dfcdcasp202017 ($this->si220_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si220_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si220_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009485,'$this->si220_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010214,1009485,'','".AddSlashes(pg_result($resaco,0,'si220_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010214,1009486,'','".AddSlashes(pg_result($resaco,0,'si220_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010214,1009487,'','".AddSlashes(pg_result($resaco,0,'si220_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010214,1009488,'','".AddSlashes(pg_result($resaco,0,'si220_vldesembolsopessoaldespesas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010214,1009489,'','".AddSlashes(pg_result($resaco,0,'si220_vldesembolsojurosencargdivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010214,1009490,'','".AddSlashes(pg_result($resaco,0,'si220_vldesembolsotransfconcedidas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010214,1009491,'','".AddSlashes(pg_result($resaco,0,'si220_vloutrosdesembolsos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010214,1009492,'','".AddSlashes(pg_result($resaco,0,'si220_vltotaldesembolsosativoperacionais'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si220_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dfcdcasp202017 set ";
     $virgula = "";
     if(trim($this->si220_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si220_sequencial"])){ 
       $sql  .= $virgula." si220_sequencial = $this->si220_sequencial ";
       $virgula = ",";
       if(trim($this->si220_sequencial) == null ){ 
         $this->erro_sql = " Campo si220_sequencial não informado.";
         $this->erro_campo = "si220_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si220_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si220_tiporegistro"])){ 
       $sql  .= $virgula." si220_tiporegistro = $this->si220_tiporegistro ";
       $virgula = ",";
       if(trim($this->si220_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si220_tiporegistro não informado.";
         $this->erro_campo = "si220_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si220_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si220_exercicio"])){ 
       $sql  .= $virgula." si220_exercicio = $this->si220_exercicio ";
       $virgula = ",";
       if(trim($this->si220_exercicio) == null ){ 
         $this->erro_sql = " Campo si220_exercicio não informado.";
         $this->erro_campo = "si220_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si220_vldesembolsopessoaldespesas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si220_vldesembolsopessoaldespesas"])){ 
       $sql  .= $virgula." si220_vldesembolsopessoaldespesas = $this->si220_vldesembolsopessoaldespesas ";
       $virgula = ",";
       if(trim($this->si220_vldesembolsopessoaldespesas) == null ){ 
         $this->erro_sql = " Campo si220_vldesembolsopessoaldespesas não informado.";
         $this->erro_campo = "si220_vldesembolsopessoaldespesas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si220_vldesembolsojurosencargdivida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si220_vldesembolsojurosencargdivida"])){ 
       $sql  .= $virgula." si220_vldesembolsojurosencargdivida = $this->si220_vldesembolsojurosencargdivida ";
       $virgula = ",";
       if(trim($this->si220_vldesembolsojurosencargdivida) == null ){ 
         $this->erro_sql = " Campo si220_vldesembolsojurosencargdivida não informado.";
         $this->erro_campo = "si220_vldesembolsojurosencargdivida";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si220_vldesembolsotransfconcedidas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si220_vldesembolsotransfconcedidas"])){ 
       $sql  .= $virgula." si220_vldesembolsotransfconcedidas = $this->si220_vldesembolsotransfconcedidas ";
       $virgula = ",";
       if(trim($this->si220_vldesembolsotransfconcedidas) == null ){ 
         $this->erro_sql = " Campo si220_vldesembolsotransfconcedidas não informado.";
         $this->erro_campo = "si220_vldesembolsotransfconcedidas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si220_vloutrosdesembolsos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si220_vloutrosdesembolsos"])){ 
       $sql  .= $virgula." si220_vloutrosdesembolsos = $this->si220_vloutrosdesembolsos ";
       $virgula = ",";
       if(trim($this->si220_vloutrosdesembolsos) == null ){ 
         $this->erro_sql = " Campo si220_vloutrosdesembolsos não informado.";
         $this->erro_campo = "si220_vloutrosdesembolsos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si220_vltotaldesembolsosativoperacionais)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si220_vltotaldesembolsosativoperacionais"])){ 
       $sql  .= $virgula." si220_vltotaldesembolsosativoperacionais = $this->si220_vltotaldesembolsosativoperacionais ";
       $virgula = ",";
       if(trim($this->si220_vltotaldesembolsosativoperacionais) == null ){ 
         $this->erro_sql = " Campo si220_vltotaldesembolsosativoperacionais não informado.";
         $this->erro_campo = "si220_vltotaldesembolsosativoperacionais";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si220_sequencial!=null){
       $sql .= " si220_sequencial = $this->si220_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si220_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009485,'$this->si220_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si220_sequencial"]) || $this->si220_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010214,1009485,'".AddSlashes(pg_result($resaco,$conresaco,'si220_sequencial'))."','$this->si220_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si220_tiporegistro"]) || $this->si220_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010214,1009486,'".AddSlashes(pg_result($resaco,$conresaco,'si220_tiporegistro'))."','$this->si220_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si220_exercicio"]) || $this->si220_exercicio != "")
             $resac = db_query("insert into db_acount values($acount,1010214,1009487,'".AddSlashes(pg_result($resaco,$conresaco,'si220_exercicio'))."','$this->si220_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si220_vldesembolsopessoaldespesas"]) || $this->si220_vldesembolsopessoaldespesas != "")
             $resac = db_query("insert into db_acount values($acount,1010214,1009488,'".AddSlashes(pg_result($resaco,$conresaco,'si220_vldesembolsopessoaldespesas'))."','$this->si220_vldesembolsopessoaldespesas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si220_vldesembolsojurosencargdivida"]) || $this->si220_vldesembolsojurosencargdivida != "")
             $resac = db_query("insert into db_acount values($acount,1010214,1009489,'".AddSlashes(pg_result($resaco,$conresaco,'si220_vldesembolsojurosencargdivida'))."','$this->si220_vldesembolsojurosencargdivida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si220_vldesembolsotransfconcedidas"]) || $this->si220_vldesembolsotransfconcedidas != "")
             $resac = db_query("insert into db_acount values($acount,1010214,1009490,'".AddSlashes(pg_result($resaco,$conresaco,'si220_vldesembolsotransfconcedidas'))."','$this->si220_vldesembolsotransfconcedidas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si220_vloutrosdesembolsos"]) || $this->si220_vloutrosdesembolsos != "")
             $resac = db_query("insert into db_acount values($acount,1010214,1009491,'".AddSlashes(pg_result($resaco,$conresaco,'si220_vloutrosdesembolsos'))."','$this->si220_vloutrosdesembolsos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si220_vltotaldesembolsosativoperacionais"]) || $this->si220_vltotaldesembolsosativoperacionais != "")
             $resac = db_query("insert into db_acount values($acount,1010214,1009492,'".AddSlashes(pg_result($resaco,$conresaco,'si220_vltotaldesembolsosativoperacionais'))."','$this->si220_vltotaldesembolsosativoperacionais',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp202017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si220_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp202017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si220_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si220_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si220_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si220_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009485,'$si220_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010214,1009485,'','".AddSlashes(pg_result($resaco,$iresaco,'si220_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010214,1009486,'','".AddSlashes(pg_result($resaco,$iresaco,'si220_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010214,1009487,'','".AddSlashes(pg_result($resaco,$iresaco,'si220_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010214,1009488,'','".AddSlashes(pg_result($resaco,$iresaco,'si220_vldesembolsopessoaldespesas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010214,1009489,'','".AddSlashes(pg_result($resaco,$iresaco,'si220_vldesembolsojurosencargdivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010214,1009490,'','".AddSlashes(pg_result($resaco,$iresaco,'si220_vldesembolsotransfconcedidas'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010214,1009491,'','".AddSlashes(pg_result($resaco,$iresaco,'si220_vloutrosdesembolsos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010214,1009492,'','".AddSlashes(pg_result($resaco,$iresaco,'si220_vltotaldesembolsosativoperacionais'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from dfcdcasp202017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si220_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si220_sequencial = $si220_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp202017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si220_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp202017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si220_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si220_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp202017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si220_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp202017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si220_sequencial!=null ){
         $sql2 .= " where dfcdcasp202017.si220_sequencial = $si220_sequencial "; 
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
   function sql_query_file ( $si220_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dfcdcasp202017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si220_sequencial!=null ){
         $sql2 .= " where dfcdcasp202017.si220_sequencial = $si220_sequencial "; 
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
