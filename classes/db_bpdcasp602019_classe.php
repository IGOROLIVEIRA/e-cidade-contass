<?
//MODULO: sicom
//CLASSE DA ENTIDADE bpdcasp602019
class cl_bpdcasp602019 { 
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
   var $si213_sequencial = 0; 
   var $si213_tiporegistro = 0; 
   var $si213_vlatospotenativosgarancontrarecebi = 0; 
   var $si213_vlatospotenativodirconveoutroinstr = 0; 
   var $si213_vlatospotenativosdireitoscontratua = 0; 
   var $si213_vlatospotenativosoutrosatos = 0; 
   var $si213_vlatospotenpassivgarancontraconced = 0; 
   var $si213_vlatospotepassobriconvoutrinst = 0; 
   var $si213_vlatospotenpassivoobrigacocontratu = 0; 
   var $si213_vlatospotenpassivooutrosatos = 0; 
   var $si213_ano = 0;
   var $si213_periodo = 0;
   var $si213_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si213_sequencial = int4 = si213_sequencial 
                 si213_tiporegistro = int4 = si213_tiporegistro 
                 si213_vlatospotenativosgarancontrarecebi = float4 = si213_vlatospotenativosgarancontrarecebi 
                 si213_vlatospotenativodirconveoutroinstr = float4 = si213_vlatospotenativodirconveoutroinstr 
                 si213_vlatospotenativosdireitoscontratua = float4 = si213_vlatospotenativosdireitoscontratua 
                 si213_vlatospotenativosoutrosatos = float4 = si213_vlatospotenativosoutrosatos 
                 si213_vlatospotenpassivgarancontraconced = float4 = si213_vlatospotenpassivgarancontraconced 
                 si213_vlatospotepassobriconvoutrinst = float4 = si213_vlatospotepassobriconvoutrinst 
                 si213_vlatospotenpassivoobrigacocontratu = float4 = si213_vlatospotenpassivoobrigacocontratu 
                 si213_vlatospotenpassivooutrosatos = float4 = si213_vlatospotenpassivooutrosatos 
                 ";
   //funcao construtor da classe 
   function cl_bpdcasp602019() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bpdcasp602019"); 
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
       $this->si213_sequencial = ($this->si213_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_sequencial"]:$this->si213_sequencial);
       $this->si213_tiporegistro = ($this->si213_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_tiporegistro"]:$this->si213_tiporegistro);
       $this->si213_vlatospotenativosgarancontrarecebi = ($this->si213_vlatospotenativosgarancontrarecebi == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativosgarancontrarecebi"]:$this->si213_vlatospotenativosgarancontrarecebi);
       $this->si213_vlatospotenativodirconveoutroinstr = ($this->si213_vlatospotenativodirconveoutroinstr == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativodirconveoutroinstr"]:$this->si213_vlatospotenativodirconveoutroinstr);
       $this->si213_vlatospotenativosdireitoscontratua = ($this->si213_vlatospotenativosdireitoscontratua == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativosdireitoscontratua"]:$this->si213_vlatospotenativosdireitoscontratua);
       $this->si213_vlatospotenativosoutrosatos = ($this->si213_vlatospotenativosoutrosatos == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativosoutrosatos"]:$this->si213_vlatospotenativosoutrosatos);
       $this->si213_vlatospotenpassivgarancontraconced = ($this->si213_vlatospotenpassivgarancontraconced == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenpassivgarancontraconced"]:$this->si213_vlatospotenpassivgarancontraconced);
       $this->si213_vlatospotepassobriconvoutrinst = ($this->si213_vlatospotepassobriconvoutrinst == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_vlatospotepassobriconvoutrinst"]:$this->si213_vlatospotepassobriconvoutrinst);
       $this->si213_vlatospotenpassivoobrigacocontratu = ($this->si213_vlatospotenpassivoobrigacocontratu == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenpassivoobrigacocontratu"]:$this->si213_vlatospotenpassivoobrigacocontratu);
       $this->si213_vlatospotenpassivooutrosatos = ($this->si213_vlatospotenpassivooutrosatos == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenpassivooutrosatos"]:$this->si213_vlatospotenpassivooutrosatos);
       $this->si213_ano = ($this->si213_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_ano"]:$this->si213_ano);
       $this->si213_periodo = ($this->si213_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_periodo"]:$this->si213_periodo);
       $this->si213_institu = ($this->si213_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_institu"]:$this->si213_institu);
     }else{
       $this->si213_sequencial = ($this->si213_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si213_sequencial"]:$this->si213_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si213_sequencial){ 
      $this->atualizacampos();
     if($this->si213_tiporegistro == null ){
       $this->erro_sql = " Campo si213_tiporegistro não informado.";
       $this->erro_campo = "si213_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si213_vlatospotenativosgarancontrarecebi == null ){
         $this->si213_vlatospotenativosgarancontrarecebi = 0;
     }
     if($this->si213_vlatospotenativodirconveoutroinstr == null ){
         $this->si213_vlatospotenativodirconveoutroinstr = 0;
     }
     if($this->si213_vlatospotenativosdireitoscontratua == null ){
         $this->si213_vlatospotenativosdireitoscontratua = 0;
     }
     if($this->si213_vlatospotenativosoutrosatos == null ){
         $this->si213_vlatospotenativosoutrosatos = 0;
     }
     if($this->si213_vlatospotenpassivgarancontraconced == null ){
         $this->si213_vlatospotenpassivgarancontraconced = 0;
     }
     if($this->si213_vlatospotepassobriconvoutrinst == null ){
         $this->si213_vlatospotepassobriconvoutrinst = 0;
     }
     if($this->si213_vlatospotenpassivoobrigacocontratu == null ){
         $this->si213_vlatospotenpassivoobrigacocontratu = 0;
     }
     if($this->si213_vlatospotenpassivooutrosatos == null ){
         $this->si213_vlatospotenpassivooutrosatos = 0;
     }

     $sql = "insert into bpdcasp602019(
                                       si213_sequencial 
                                      ,si213_tiporegistro 
                                      ,si213_vlatospotenativosgarancontrarecebi 
                                      ,si213_vlatospotenativodirconveoutroinstr 
                                      ,si213_vlatospotenativosdireitoscontratua 
                                      ,si213_vlatospotenativosoutrosatos 
                                      ,si213_vlatospotenpassivgarancontraconced 
                                      ,si213_vlatospotepassobriconvoutrinst 
                                      ,si213_vlatospotenpassivoobrigacocontratu 
                                      ,si213_vlatospotenpassivooutrosatos 
                                      ,si213_ano
                                      ,si213_periodo
                                      ,si213_institu
                       )
                values (
                                (select nextval('bpdcasp602019_si213_sequencial_seq'))
                               ,$this->si213_tiporegistro 
                               ,$this->si213_vlatospotenativosgarancontrarecebi 
                               ,$this->si213_vlatospotenativodirconveoutroinstr 
                               ,$this->si213_vlatospotenativosdireitoscontratua 
                               ,$this->si213_vlatospotenativosoutrosatos 
                               ,$this->si213_vlatospotenpassivgarancontraconced 
                               ,$this->si213_vlatospotepassobriconvoutrinst 
                               ,$this->si213_vlatospotenpassivoobrigacocontratu 
                               ,$this->si213_vlatospotenpassivooutrosatos 
                               ,$this->si213_ano
                               ,$this->si213_periodo
                               ,$this->si213_institu
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bpdcasp602019 ($this->si213_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bpdcasp602019 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bpdcasp602019 ($this->si213_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si213_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     return true;
   } 
   // funcao para alteracao
   function alterar ($si213_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bpdcasp602019 set ";
     $virgula = "";
     if(trim($this->si213_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_sequencial"])){ 
       $sql  .= $virgula." si213_sequencial = $this->si213_sequencial ";
       $virgula = ",";
       if(trim($this->si213_sequencial) == null ){ 
         $this->erro_sql = " Campo si213_sequencial não informado.";
         $this->erro_campo = "si213_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si213_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_tiporegistro"])){ 
       $sql  .= $virgula." si213_tiporegistro = $this->si213_tiporegistro ";
       $virgula = ",";
       if(trim($this->si213_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si213_tiporegistro não informado.";
         $this->erro_campo = "si213_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si213_vlatospotenativosgarancontrarecebi)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativosgarancontrarecebi"])){ 
       $sql  .= $virgula." si213_vlatospotenativosgarancontrarecebi = $this->si213_vlatospotenativosgarancontrarecebi ";
       $virgula = ",";
       if(trim($this->si213_vlatospotenativosgarancontrarecebi) == null ){ 
         $this->erro_sql = " Campo si213_vlatospotenativosgarancontrarecebi não informado.";
         $this->erro_campo = "si213_vlatospotenativosgarancontrarecebi";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si213_vlatospotenativodirconveoutroinstr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativodirconveoutroinstr"])){ 
       $sql  .= $virgula." si213_vlatospotenativodirconveoutroinstr = $this->si213_vlatospotenativodirconveoutroinstr ";
       $virgula = ",";
       if(trim($this->si213_vlatospotenativodirconveoutroinstr) == null ){ 
         $this->erro_sql = " Campo si213_vlatospotenativodirconveoutroinstr não informado.";
         $this->erro_campo = "si213_vlatospotenativodirconveoutroinstr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si213_vlatospotenativosdireitoscontratua)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativosdireitoscontratua"])){ 
       $sql  .= $virgula." si213_vlatospotenativosdireitoscontratua = $this->si213_vlatospotenativosdireitoscontratua ";
       $virgula = ",";
       if(trim($this->si213_vlatospotenativosdireitoscontratua) == null ){ 
         $this->erro_sql = " Campo si213_vlatospotenativosdireitoscontratua não informado.";
         $this->erro_campo = "si213_vlatospotenativosdireitoscontratua";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si213_vlatospotenativosoutrosatos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativosoutrosatos"])){ 
       $sql  .= $virgula." si213_vlatospotenativosoutrosatos = $this->si213_vlatospotenativosoutrosatos ";
       $virgula = ",";
       if(trim($this->si213_vlatospotenativosoutrosatos) == null ){ 
         $this->erro_sql = " Campo si213_vlatospotenativosoutrosatos não informado.";
         $this->erro_campo = "si213_vlatospotenativosoutrosatos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si213_vlatospotenpassivgarancontraconced)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenpassivgarancontraconced"])){ 
       $sql  .= $virgula." si213_vlatospotenpassivgarancontraconced = $this->si213_vlatospotenpassivgarancontraconced ";
       $virgula = ",";
       if(trim($this->si213_vlatospotenpassivgarancontraconced) == null ){ 
         $this->erro_sql = " Campo si213_vlatospotenpassivgarancontraconced não informado.";
         $this->erro_campo = "si213_vlatospotenpassivgarancontraconced";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si213_vlatospotepassobriconvoutrinst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotepassobriconvoutrinst"])){ 
       $sql  .= $virgula." si213_vlatospotepassobriconvoutrinst = $this->si213_vlatospotepassobriconvoutrinst ";
       $virgula = ",";
       if(trim($this->si213_vlatospotepassobriconvoutrinst) == null ){ 
         $this->erro_sql = " Campo si213_vlatospotepassobriconvoutrinst não informado.";
         $this->erro_campo = "si213_vlatospotepassobriconvoutrinst";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si213_vlatospotenpassivoobrigacocontratu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenpassivoobrigacocontratu"])){ 
       $sql  .= $virgula." si213_vlatospotenpassivoobrigacocontratu = $this->si213_vlatospotenpassivoobrigacocontratu ";
       $virgula = ",";
       if(trim($this->si213_vlatospotenpassivoobrigacocontratu) == null ){ 
         $this->erro_sql = " Campo si213_vlatospotenpassivoobrigacocontratu não informado.";
         $this->erro_campo = "si213_vlatospotenpassivoobrigacocontratu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si213_vlatospotenpassivooutrosatos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenpassivooutrosatos"])){ 
       $sql  .= $virgula." si213_vlatospotenpassivooutrosatos = $this->si213_vlatospotenpassivooutrosatos ";
       $virgula = ",";
       if(trim($this->si213_vlatospotenpassivooutrosatos) == null ){ 
         $this->erro_sql = " Campo si213_vlatospotenpassivooutrosatos não informado.";
         $this->erro_campo = "si213_vlatospotenpassivooutrosatos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si213_sequencial!=null){
       $sql .= " si213_sequencial = $this->si213_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si213_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009430,'$this->si213_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_sequencial"]) || $this->si213_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009430,'".AddSlashes(pg_result($resaco,$conresaco,'si213_sequencial'))."','$this->si213_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_tiporegistro"]) || $this->si213_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009431,'".AddSlashes(pg_result($resaco,$conresaco,'si213_tiporegistro'))."','$this->si213_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativosgarancontrarecebi"]) || $this->si213_vlatospotenativosgarancontrarecebi != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009433,'".AddSlashes(pg_result($resaco,$conresaco,'si213_vlatospotenativosgarancontrarecebi'))."','$this->si213_vlatospotenativosgarancontrarecebi',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativodirconveoutroinstr"]) || $this->si213_vlatospotenativodirconveoutroinstr != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009434,'".AddSlashes(pg_result($resaco,$conresaco,'si213_vlatospotenativodirconveoutroinstr'))."','$this->si213_vlatospotenativodirconveoutroinstr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativosdireitoscontratua"]) || $this->si213_vlatospotenativosdireitoscontratua != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009435,'".AddSlashes(pg_result($resaco,$conresaco,'si213_vlatospotenativosdireitoscontratua'))."','$this->si213_vlatospotenativosdireitoscontratua',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenativosoutrosatos"]) || $this->si213_vlatospotenativosoutrosatos != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009436,'".AddSlashes(pg_result($resaco,$conresaco,'si213_vlatospotenativosoutrosatos'))."','$this->si213_vlatospotenativosoutrosatos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenpassivgarancontraconced"]) || $this->si213_vlatospotenpassivgarancontraconced != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009437,'".AddSlashes(pg_result($resaco,$conresaco,'si213_vlatospotenpassivgarancontraconced'))."','$this->si213_vlatospotenpassivgarancontraconced',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotepassobriconvoutrinst"]) || $this->si213_vlatospotepassobriconvoutrinst != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009438,'".AddSlashes(pg_result($resaco,$conresaco,'si213_vlatospotepassobriconvoutrinst'))."','$this->si213_vlatospotepassobriconvoutrinst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenpassivoobrigacocontratu"]) || $this->si213_vlatospotenpassivoobrigacocontratu != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009439,'".AddSlashes(pg_result($resaco,$conresaco,'si213_vlatospotenpassivoobrigacocontratu'))."','$this->si213_vlatospotenpassivoobrigacocontratu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si213_vlatospotenpassivooutrosatos"]) || $this->si213_vlatospotenpassivooutrosatos != "")
             $resac = db_query("insert into db_acount values($acount,1010207,1009440,'".AddSlashes(pg_result($resaco,$conresaco,'si213_vlatospotenpassivooutrosatos'))."','$this->si213_vlatospotenpassivooutrosatos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp602019 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si213_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp602019 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si213_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si213_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si213_sequencial=null,$dbwhere=null) { 

     $sql = " delete from bpdcasp602019
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si213_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si213_sequencial = $si213_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp602019 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si213_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp602019 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si213_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si213_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
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
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:bpdcasp602019";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si213_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp602019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si213_sequencial!=null ){
         $sql2 .= " where bpdcasp602019.si213_sequencial = $si213_sequencial "; 
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
   function sql_query_file ( $si213_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp602019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si213_sequencial!=null ){
         $sql2 .= " where bpdcasp602019.si213_sequencial = $si213_sequencial "; 
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
