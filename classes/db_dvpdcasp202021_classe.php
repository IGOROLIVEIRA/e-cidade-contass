<?
//MODULO: sicom
//CLASSE DA ENTIDADE dvpdcasp202120
class cl_dvpdcasp202120 { 
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
   var $si217_sequencial = 0; 
   var $si217_tiporegistro = 0; 
   var $si217_vldiminutivapessoaencargos = 0; 
   var $si217_vlprevassistenciais = 0; 
   var $si217_vlservicoscapitalfixo = 0; 
   var $si217_vldiminutivavariacoesfinanceiras = 0; 
   var $si217_vltransfconcedidas = 0; 
   var $si217_vldesvaloativoincorpopassivo = 0; 
   var $si217_vltributarias = 0; 
   var $si217_vlmercadoriavendidoservicos = 0; 
   var $si217_vloutrasvariacoespatridiminutivas = 0; 
   var $si217_vltotalvpdiminutivas = 0; 
   var $si217_ano = 0;
   var $si217_periodo = 0;
   var $si217_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si217_sequencial = int4 = si217_sequencial 
                 si217_tiporegistro = int4 = si217_tiporegistro 
                 si217_vldiminutivapessoaencargos = float4 = si217_vldiminutivapessoaencargos 
                 si217_vlprevassistenciais = float4 = si217_vlprevassistenciais 
                 si217_vlservicoscapitalfixo = float4 = si217_vlservicoscapitalfixo 
                 si217_vldiminutivavariacoesfinanceiras = float4 = si217_vldiminutivavariacoesfinanceiras 
                 si217_vltransfconcedidas = float4 = si217_vltransfconcedidas 
                 si217_vldesvaloativoincorpopassivo = float4 = si217_vldesvaloativoincorpopassivo 
                 si217_vltributarias = float4 = si217_vltributarias 
                 si217_vlmercadoriavendidoservicos = float4 = si217_vlmercadoriavendidoservicos 
                 si217_vloutrasvariacoespatridiminutivas = float4 = si217_vloutrasvariacoespatridiminutivas 
                 si217_vltotalvpdiminutivas = float4 = si217_vltotalvpdiminutivas 
                 ";
   //funcao construtor da classe 
   function cl_dvpdcasp202120() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dvpdcasp202120"); 
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
       $this->si217_sequencial = ($this->si217_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_sequencial"]:$this->si217_sequencial);
       $this->si217_tiporegistro = ($this->si217_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_tiporegistro"]:$this->si217_tiporegistro);
       $this->si217_vldiminutivapessoaencargos = ($this->si217_vldiminutivapessoaencargos == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vldiminutivapessoaencargos"]:$this->si217_vldiminutivapessoaencargos);
       $this->si217_vlprevassistenciais = ($this->si217_vlprevassistenciais == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vlprevassistenciais"]:$this->si217_vlprevassistenciais);
       $this->si217_vlservicoscapitalfixo = ($this->si217_vlservicoscapitalfixo == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vlservicoscapitalfixo"]:$this->si217_vlservicoscapitalfixo);
       $this->si217_vldiminutivavariacoesfinanceiras = ($this->si217_vldiminutivavariacoesfinanceiras == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vldiminutivavariacoesfinanceiras"]:$this->si217_vldiminutivavariacoesfinanceiras);
       $this->si217_vltransfconcedidas = ($this->si217_vltransfconcedidas == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vltransfconcedidas"]:$this->si217_vltransfconcedidas);
       $this->si217_vldesvaloativoincorpopassivo = ($this->si217_vldesvaloativoincorpopassivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vldesvaloativoincorpopassivo"]:$this->si217_vldesvaloativoincorpopassivo);
       $this->si217_vltributarias = ($this->si217_vltributarias == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vltributarias"]:$this->si217_vltributarias);
       $this->si217_vlmercadoriavendidoservicos = ($this->si217_vlmercadoriavendidoservicos == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vlmercadoriavendidoservicos"]:$this->si217_vlmercadoriavendidoservicos);
       $this->si217_vloutrasvariacoespatridiminutivas = ($this->si217_vloutrasvariacoespatridiminutivas == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vloutrasvariacoespatridiminutivas"]:$this->si217_vloutrasvariacoespatridiminutivas);
       $this->si217_vltotalvpdiminutivas = ($this->si217_vltotalvpdiminutivas == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_vltotalvpdiminutivas"]:$this->si217_vltotalvpdiminutivas);
       $this->si217_ano = ($this->si217_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_ano"]:$this->si217_ano);
       $this->si217_periodo = ($this->si217_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_periodo"]:$this->si217_periodo);
       $this->si217_institu = ($this->si217_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_institu"]:$this->si217_institu);
     }else{
       $this->si217_sequencial = ($this->si217_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si217_sequencial"]:$this->si217_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si217_sequencial){ 
      $this->atualizacampos();
     if($this->si217_tiporegistro == null ){ 
       $this->erro_sql = " Campo si217_tiporegistro não informado.";
       $this->erro_campo = "si217_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si217_vldiminutivapessoaencargos == null ){
       $this->si217_vldiminutivapessoaencargos = 0;
     }
     if($this->si217_vlprevassistenciais == null ){
       $this->si217_vlprevassistenciais = 0;
     }
     if($this->si217_vlservicoscapitalfixo == null ){
       $this->si217_vlservicoscapitalfixo = 0;
     }
     if($this->si217_vldiminutivavariacoesfinanceiras == null ){
       $this->si217_vldiminutivavariacoesfinanceiras = 0;
     }
     if($this->si217_vltransfconcedidas == null ){
       $this->si217_vltransfconcedidas = 0;
     }
     if($this->si217_vldesvaloativoincorpopassivo == null ){
       $this->si217_vldesvaloativoincorpopassivo = 0;
     }
     if($this->si217_vltributarias == null ){
       $this->si217_vltributarias = 0;
     }
     if($this->si217_vlmercadoriavendidoservicos == null ){
       $this->si217_vlmercadoriavendidoservicos = 0;
     }
     if($this->si217_vloutrasvariacoespatridiminutivas == null ){
       $this->si217_vloutrasvariacoespatridiminutivas = 0;
     }
     if($this->si217_vltotalvpdiminutivas == null ){
       $this->si217_vltotalvpdiminutivas = 0;
     }

     $sql = "insert into dvpdcasp202120(
                                       si217_sequencial 
                                      ,si217_tiporegistro 
                                      ,si217_vldiminutivapessoaencargos 
                                      ,si217_vlprevassistenciais 
                                      ,si217_vlservicoscapitalfixo 
                                      ,si217_vldiminutivavariacoesfinanceiras 
                                      ,si217_vltransfconcedidas 
                                      ,si217_vldesvaloativoincorpopassivo 
                                      ,si217_vltributarias 
                                      ,si217_vlmercadoriavendidoservicos 
                                      ,si217_vloutrasvariacoespatridiminutivas 
                                      ,si217_vltotalvpdiminutivas 
                                      ,si217_ano
                                      ,si217_periodo
                                      ,si217_institu
                       )
                values (
                                (select nextval('dvpdcasp202120_si217_sequencial_seq'))
                               ,$this->si217_tiporegistro 
                               ,$this->si217_vldiminutivapessoaencargos 
                               ,$this->si217_vlprevassistenciais 
                               ,$this->si217_vlservicoscapitalfixo 
                               ,$this->si217_vldiminutivavariacoesfinanceiras 
                               ,$this->si217_vltransfconcedidas 
                               ,$this->si217_vldesvaloativoincorpopassivo 
                               ,$this->si217_vltributarias 
                               ,$this->si217_vlmercadoriavendidoservicos 
                               ,$this->si217_vloutrasvariacoespatridiminutivas 
                               ,$this->si217_vltotalvpdiminutivas 
                               ,$this->si217_ano
                               ,$this->si217_periodo
                               ,$this->si217_institu
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dvpdcasp202120 ($this->si217_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dvpdcasp202120 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dvpdcasp202120 ($this->si217_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si217_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ($si217_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dvpdcasp202120 set ";
     $virgula = "";
     if(trim($this->si217_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_sequencial"])){ 
       $sql  .= $virgula." si217_sequencial = $this->si217_sequencial ";
       $virgula = ",";
       if(trim($this->si217_sequencial) == null ){ 
         $this->erro_sql = " Campo si217_sequencial não informado.";
         $this->erro_campo = "si217_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_tiporegistro"])){ 
       $sql  .= $virgula." si217_tiporegistro = $this->si217_tiporegistro ";
       $virgula = ",";
       if(trim($this->si217_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si217_tiporegistro não informado.";
         $this->erro_campo = "si217_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vldiminutivapessoaencargos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vldiminutivapessoaencargos"])){ 
       $sql  .= $virgula." si217_vldiminutivapessoaencargos = $this->si217_vldiminutivapessoaencargos ";
       $virgula = ",";
       if(trim($this->si217_vldiminutivapessoaencargos) == null ){ 
         $this->erro_sql = " Campo si217_vldiminutivapessoaencargos não informado.";
         $this->erro_campo = "si217_vldiminutivapessoaencargos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vlprevassistenciais)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vlprevassistenciais"])){ 
       $sql  .= $virgula." si217_vlprevassistenciais = $this->si217_vlprevassistenciais ";
       $virgula = ",";
       if(trim($this->si217_vlprevassistenciais) == null ){ 
         $this->erro_sql = " Campo si217_vlprevassistenciais não informado.";
         $this->erro_campo = "si217_vlprevassistenciais";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vlservicoscapitalfixo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vlservicoscapitalfixo"])){ 
       $sql  .= $virgula." si217_vlservicoscapitalfixo = $this->si217_vlservicoscapitalfixo ";
       $virgula = ",";
       if(trim($this->si217_vlservicoscapitalfixo) == null ){ 
         $this->erro_sql = " Campo si217_vlservicoscapitalfixo não informado.";
         $this->erro_campo = "si217_vlservicoscapitalfixo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vldiminutivavariacoesfinanceiras)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vldiminutivavariacoesfinanceiras"])){ 
       $sql  .= $virgula." si217_vldiminutivavariacoesfinanceiras = $this->si217_vldiminutivavariacoesfinanceiras ";
       $virgula = ",";
       if(trim($this->si217_vldiminutivavariacoesfinanceiras) == null ){ 
         $this->erro_sql = " Campo si217_vldiminutivavariacoesfinanceiras não informado.";
         $this->erro_campo = "si217_vldiminutivavariacoesfinanceiras";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vltransfconcedidas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vltransfconcedidas"])){ 
       $sql  .= $virgula." si217_vltransfconcedidas = $this->si217_vltransfconcedidas ";
       $virgula = ",";
       if(trim($this->si217_vltransfconcedidas) == null ){ 
         $this->erro_sql = " Campo si217_vltransfconcedidas não informado.";
         $this->erro_campo = "si217_vltransfconcedidas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vldesvaloativoincorpopassivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vldesvaloativoincorpopassivo"])){ 
       $sql  .= $virgula." si217_vldesvaloativoincorpopassivo = $this->si217_vldesvaloativoincorpopassivo ";
       $virgula = ",";
       if(trim($this->si217_vldesvaloativoincorpopassivo) == null ){ 
         $this->erro_sql = " Campo si217_vldesvaloativoincorpopassivo não informado.";
         $this->erro_campo = "si217_vldesvaloativoincorpopassivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vltributarias)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vltributarias"])){ 
       $sql  .= $virgula." si217_vltributarias = $this->si217_vltributarias ";
       $virgula = ",";
       if(trim($this->si217_vltributarias) == null ){ 
         $this->erro_sql = " Campo si217_vltributarias não informado.";
         $this->erro_campo = "si217_vltributarias";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vlmercadoriavendidoservicos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vlmercadoriavendidoservicos"])){ 
       $sql  .= $virgula." si217_vlmercadoriavendidoservicos = $this->si217_vlmercadoriavendidoservicos ";
       $virgula = ",";
       if(trim($this->si217_vlmercadoriavendidoservicos) == null ){ 
         $this->erro_sql = " Campo si217_vlmercadoriavendidoservicos não informado.";
         $this->erro_campo = "si217_vlmercadoriavendidoservicos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vloutrasvariacoespatridiminutivas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vloutrasvariacoespatridiminutivas"])){ 
       $sql  .= $virgula." si217_vloutrasvariacoespatridiminutivas = $this->si217_vloutrasvariacoespatridiminutivas ";
       $virgula = ",";
       if(trim($this->si217_vloutrasvariacoespatridiminutivas) == null ){ 
         $this->erro_sql = " Campo si217_vloutrasvariacoespatridiminutivas não informado.";
         $this->erro_campo = "si217_vloutrasvariacoespatridiminutivas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si217_vltotalvpdiminutivas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si217_vltotalvpdiminutivas"])){ 
       $sql  .= $virgula." si217_vltotalvpdiminutivas = $this->si217_vltotalvpdiminutivas ";
       $virgula = ",";
       if(trim($this->si217_vltotalvpdiminutivas) == null ){ 
         $this->erro_sql = " Campo si217_vltotalvpdiminutivas não informado.";
         $this->erro_campo = "si217_vltotalvpdiminutivas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si217_sequencial!=null){
       $sql .= " si217_sequencial = $this->si217_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si217_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009461,'$this->si217_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_sequencial"]) || $this->si217_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009461,'".AddSlashes(pg_result($resaco,$conresaco,'si217_sequencial'))."','$this->si217_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_tiporegistro"]) || $this->si217_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009462,'".AddSlashes(pg_result($resaco,$conresaco,'si217_tiporegistro'))."','$this->si217_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vldiminutivapessoaencargos"]) || $this->si217_vldiminutivapessoaencargos != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009464,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vldiminutivapessoaencargos'))."','$this->si217_vldiminutivapessoaencargos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vlprevassistenciais"]) || $this->si217_vlprevassistenciais != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009465,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vlprevassistenciais'))."','$this->si217_vlprevassistenciais',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vlservicoscapitalfixo"]) || $this->si217_vlservicoscapitalfixo != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009466,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vlservicoscapitalfixo'))."','$this->si217_vlservicoscapitalfixo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vldiminutivavariacoesfinanceiras"]) || $this->si217_vldiminutivavariacoesfinanceiras != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009467,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vldiminutivavariacoesfinanceiras'))."','$this->si217_vldiminutivavariacoesfinanceiras',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vltransfconcedidas"]) || $this->si217_vltransfconcedidas != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009468,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vltransfconcedidas'))."','$this->si217_vltransfconcedidas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vldesvaloativoincorpopassivo"]) || $this->si217_vldesvaloativoincorpopassivo != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009469,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vldesvaloativoincorpopassivo'))."','$this->si217_vldesvaloativoincorpopassivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vltributarias"]) || $this->si217_vltributarias != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009470,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vltributarias'))."','$this->si217_vltributarias',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vlmercadoriavendidoservicos"]) || $this->si217_vlmercadoriavendidoservicos != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009471,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vlmercadoriavendidoservicos'))."','$this->si217_vlmercadoriavendidoservicos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vloutrasvariacoespatridiminutivas"]) || $this->si217_vloutrasvariacoespatridiminutivas != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009472,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vloutrasvariacoespatridiminutivas'))."','$this->si217_vloutrasvariacoespatridiminutivas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si217_vltotalvpdiminutivas"]) || $this->si217_vltotalvpdiminutivas != "")
             $resac = db_query("insert into db_acount values($acount,1010211,1009473,'".AddSlashes(pg_result($resaco,$conresaco,'si217_vltotalvpdiminutivas'))."','$this->si217_vltotalvpdiminutivas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dvpdcasp202120 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si217_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dvpdcasp202120 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si217_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si217_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si217_sequencial=null,$dbwhere=null) {
     $sql = " delete from dvpdcasp202120
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si217_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si217_sequencial = $si217_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dvpdcasp202120 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si217_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dvpdcasp202120 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si217_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si217_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dvpdcasp202120";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si217_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dvpdcasp202120 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si217_sequencial!=null ){
         $sql2 .= " where dvpdcasp202120.si217_sequencial = $si217_sequencial "; 
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
   function sql_query_file ( $si217_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dvpdcasp202120 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si217_sequencial!=null ){
         $sql2 .= " where dvpdcasp202120.si217_sequencial = $si217_sequencial "; 
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
