<?
//MODULO: sicom
//CLASSE DA ENTIDADE contratos402015
class cl_contratos402015 { 
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
   var $si91_sequencial = 0; 
   var $si91_tiporegistro = 0; 
   var $si91_codorgao = null; 
   var $si91_codunidadesub = null; 
   var $si91_nrocontrato = 0; 
   var $si91_dtassinaturacontoriginal_dia = null; 
   var $si91_dtassinaturacontoriginal_mes = null; 
   var $si91_dtassinaturacontoriginal_ano = null; 
   var $si91_dtassinaturacontoriginal = null; 
   var $si91_datarescisao_dia = null; 
   var $si91_datarescisao_mes = null; 
   var $si91_datarescisao_ano = null; 
   var $si91_datarescisao = null; 
   var $si91_valorcancelamentocontrato = 0; 
   var $si91_mes = 0; 
   var $si91_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si91_sequencial = int8 = sequencial 
                 si91_tiporegistro = int8 = Tipo do  registro 
                 si91_codorgao = varchar(2) = Código do órgão 
                 si91_codunidadesub = varchar(8) = Código da unidade 
                 si91_nrocontrato = int8 = Número do  Contrato Original 
                 si91_dtassinaturacontoriginal = date = Data da assinatura  do Contrato 
                 si91_datarescisao = date = Data da Rescisão Contratual 
                 si91_valorcancelamentocontrato = float8 = Valor do  Cancelamento do Contrato 
                 si91_mes = int8 = Mês 
                 si91_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_contratos402015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("contratos402015"); 
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
       $this->si91_sequencial = ($this->si91_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_sequencial"]:$this->si91_sequencial);
       $this->si91_tiporegistro = ($this->si91_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_tiporegistro"]:$this->si91_tiporegistro);
       $this->si91_codorgao = ($this->si91_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_codorgao"]:$this->si91_codorgao);
       $this->si91_codunidadesub = ($this->si91_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_codunidadesub"]:$this->si91_codunidadesub);
       $this->si91_nrocontrato = ($this->si91_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_nrocontrato"]:$this->si91_nrocontrato);
       if($this->si91_dtassinaturacontoriginal == ""){
         $this->si91_dtassinaturacontoriginal_dia = ($this->si91_dtassinaturacontoriginal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_dtassinaturacontoriginal_dia"]:$this->si91_dtassinaturacontoriginal_dia);
         $this->si91_dtassinaturacontoriginal_mes = ($this->si91_dtassinaturacontoriginal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_dtassinaturacontoriginal_mes"]:$this->si91_dtassinaturacontoriginal_mes);
         $this->si91_dtassinaturacontoriginal_ano = ($this->si91_dtassinaturacontoriginal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_dtassinaturacontoriginal_ano"]:$this->si91_dtassinaturacontoriginal_ano);
         if($this->si91_dtassinaturacontoriginal_dia != ""){
            $this->si91_dtassinaturacontoriginal = $this->si91_dtassinaturacontoriginal_ano."-".$this->si91_dtassinaturacontoriginal_mes."-".$this->si91_dtassinaturacontoriginal_dia;
         }
       }
       if($this->si91_datarescisao == ""){
         $this->si91_datarescisao_dia = ($this->si91_datarescisao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_datarescisao_dia"]:$this->si91_datarescisao_dia);
         $this->si91_datarescisao_mes = ($this->si91_datarescisao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_datarescisao_mes"]:$this->si91_datarescisao_mes);
         $this->si91_datarescisao_ano = ($this->si91_datarescisao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_datarescisao_ano"]:$this->si91_datarescisao_ano);
         if($this->si91_datarescisao_dia != ""){
            $this->si91_datarescisao = $this->si91_datarescisao_ano."-".$this->si91_datarescisao_mes."-".$this->si91_datarescisao_dia;
         }
       }
       $this->si91_valorcancelamentocontrato = ($this->si91_valorcancelamentocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_valorcancelamentocontrato"]:$this->si91_valorcancelamentocontrato);
       $this->si91_mes = ($this->si91_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_mes"]:$this->si91_mes);
       $this->si91_instit = ($this->si91_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_instit"]:$this->si91_instit);
     }else{
       $this->si91_sequencial = ($this->si91_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si91_sequencial"]:$this->si91_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si91_sequencial){ 
      $this->atualizacampos();
     if($this->si91_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si91_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si91_nrocontrato == null ){ 
       $this->si91_nrocontrato = "0";
     }
     if($this->si91_dtassinaturacontoriginal == null ){ 
       $this->si91_dtassinaturacontoriginal = "null";
     }
     if($this->si91_datarescisao == null ){ 
       $this->si91_datarescisao = "null";
     }
     if($this->si91_valorcancelamentocontrato == null ){ 
       $this->si91_valorcancelamentocontrato = "0";
     }
     if($this->si91_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si91_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si91_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si91_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si91_sequencial == "" || $si91_sequencial == null ){
       $result = db_query("select nextval('contratos402015_si91_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contratos402015_si91_sequencial_seq do campo: si91_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si91_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from contratos402015_si91_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si91_sequencial)){
         $this->erro_sql = " Campo si91_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si91_sequencial = $si91_sequencial; 
       }
     }
     if(($this->si91_sequencial == null) || ($this->si91_sequencial == "") ){ 
       $this->erro_sql = " Campo si91_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into contratos402015(
                                       si91_sequencial 
                                      ,si91_tiporegistro 
                                      ,si91_codorgao 
                                      ,si91_codunidadesub 
                                      ,si91_nrocontrato 
                                      ,si91_dtassinaturacontoriginal 
                                      ,si91_datarescisao 
                                      ,si91_valorcancelamentocontrato 
                                      ,si91_mes 
                                      ,si91_instit 
                       )
                values (
                                $this->si91_sequencial 
                               ,$this->si91_tiporegistro 
                               ,'$this->si91_codorgao' 
                               ,'$this->si91_codunidadesub' 
                               ,$this->si91_nrocontrato 
                               ,".($this->si91_dtassinaturacontoriginal == "null" || $this->si91_dtassinaturacontoriginal == ""?"null":"'".$this->si91_dtassinaturacontoriginal."'")." 
                               ,".($this->si91_datarescisao == "null" || $this->si91_datarescisao == ""?"null":"'".$this->si91_datarescisao."'")." 
                               ,$this->si91_valorcancelamentocontrato 
                               ,$this->si91_mes 
                               ,$this->si91_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "contratos402015 ($this->si91_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "contratos402015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "contratos402015 ($this->si91_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si91_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si91_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010499,'$this->si91_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010319,2010499,'','".AddSlashes(pg_result($resaco,0,'si91_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010319,2010500,'','".AddSlashes(pg_result($resaco,0,'si91_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010319,2010501,'','".AddSlashes(pg_result($resaco,0,'si91_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010319,2010502,'','".AddSlashes(pg_result($resaco,0,'si91_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010319,2010503,'','".AddSlashes(pg_result($resaco,0,'si91_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010319,2010504,'','".AddSlashes(pg_result($resaco,0,'si91_dtassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010319,2010506,'','".AddSlashes(pg_result($resaco,0,'si91_datarescisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010319,2010507,'','".AddSlashes(pg_result($resaco,0,'si91_valorcancelamentocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010319,2010509,'','".AddSlashes(pg_result($resaco,0,'si91_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010319,2011603,'','".AddSlashes(pg_result($resaco,0,'si91_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si91_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update contratos402015 set ";
     $virgula = "";
     if(trim($this->si91_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_sequencial"])){ 
        if(trim($this->si91_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si91_sequencial"])){ 
           $this->si91_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si91_sequencial = $this->si91_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si91_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_tiporegistro"])){ 
       $sql  .= $virgula." si91_tiporegistro = $this->si91_tiporegistro ";
       $virgula = ",";
       if(trim($this->si91_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si91_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si91_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_codorgao"])){ 
       $sql  .= $virgula." si91_codorgao = '$this->si91_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si91_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_codunidadesub"])){ 
       $sql  .= $virgula." si91_codunidadesub = '$this->si91_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si91_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_nrocontrato"])){ 
        if(trim($this->si91_nrocontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si91_nrocontrato"])){ 
           $this->si91_nrocontrato = "0" ; 
        } 
       $sql  .= $virgula." si91_nrocontrato = $this->si91_nrocontrato ";
       $virgula = ",";
     }
     if(trim($this->si91_dtassinaturacontoriginal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_dtassinaturacontoriginal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si91_dtassinaturacontoriginal_dia"] !="") ){ 
       $sql  .= $virgula." si91_dtassinaturacontoriginal = '$this->si91_dtassinaturacontoriginal' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si91_dtassinaturacontoriginal_dia"])){ 
         $sql  .= $virgula." si91_dtassinaturacontoriginal = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si91_datarescisao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_datarescisao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si91_datarescisao_dia"] !="") ){ 
       $sql  .= $virgula." si91_datarescisao = '$this->si91_datarescisao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si91_datarescisao_dia"])){ 
         $sql  .= $virgula." si91_datarescisao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si91_valorcancelamentocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_valorcancelamentocontrato"])){ 
        if(trim($this->si91_valorcancelamentocontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si91_valorcancelamentocontrato"])){ 
           $this->si91_valorcancelamentocontrato = "0" ; 
        } 
       $sql  .= $virgula." si91_valorcancelamentocontrato = $this->si91_valorcancelamentocontrato ";
       $virgula = ",";
     }
     if(trim($this->si91_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_mes"])){ 
       $sql  .= $virgula." si91_mes = $this->si91_mes ";
       $virgula = ",";
       if(trim($this->si91_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si91_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si91_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si91_instit"])){ 
       $sql  .= $virgula." si91_instit = $this->si91_instit ";
       $virgula = ",";
       if(trim($this->si91_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si91_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si91_sequencial!=null){
       $sql .= " si91_sequencial = $this->si91_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si91_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010499,'$this->si91_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_sequencial"]) || $this->si91_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2010499,'".AddSlashes(pg_result($resaco,$conresaco,'si91_sequencial'))."','$this->si91_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_tiporegistro"]) || $this->si91_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2010500,'".AddSlashes(pg_result($resaco,$conresaco,'si91_tiporegistro'))."','$this->si91_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_codorgao"]) || $this->si91_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2010501,'".AddSlashes(pg_result($resaco,$conresaco,'si91_codorgao'))."','$this->si91_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_codunidadesub"]) || $this->si91_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2010502,'".AddSlashes(pg_result($resaco,$conresaco,'si91_codunidadesub'))."','$this->si91_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_nrocontrato"]) || $this->si91_nrocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2010503,'".AddSlashes(pg_result($resaco,$conresaco,'si91_nrocontrato'))."','$this->si91_nrocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_dtassinaturacontoriginal"]) || $this->si91_dtassinaturacontoriginal != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2010504,'".AddSlashes(pg_result($resaco,$conresaco,'si91_dtassinaturacontoriginal'))."','$this->si91_dtassinaturacontoriginal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_datarescisao"]) || $this->si91_datarescisao != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2010506,'".AddSlashes(pg_result($resaco,$conresaco,'si91_datarescisao'))."','$this->si91_datarescisao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_valorcancelamentocontrato"]) || $this->si91_valorcancelamentocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2010507,'".AddSlashes(pg_result($resaco,$conresaco,'si91_valorcancelamentocontrato'))."','$this->si91_valorcancelamentocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_mes"]) || $this->si91_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2010509,'".AddSlashes(pg_result($resaco,$conresaco,'si91_mes'))."','$this->si91_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si91_instit"]) || $this->si91_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010319,2011603,'".AddSlashes(pg_result($resaco,$conresaco,'si91_instit'))."','$this->si91_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "contratos402015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si91_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos402015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si91_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si91_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si91_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si91_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010499,'$si91_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010319,2010499,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010319,2010500,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010319,2010501,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010319,2010502,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010319,2010503,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010319,2010504,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_dtassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010319,2010506,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_datarescisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010319,2010507,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_valorcancelamentocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010319,2010509,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010319,2011603,'','".AddSlashes(pg_result($resaco,$iresaco,'si91_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from contratos402015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si91_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si91_sequencial = $si91_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "contratos402015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si91_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos402015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si91_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si91_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:contratos402015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si91_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos402015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si91_sequencial!=null ){
         $sql2 .= " where contratos402015.si91_sequencial = $si91_sequencial "; 
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
   function sql_query_file ( $si91_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos402015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si91_sequencial!=null ){
         $sql2 .= " where contratos402015.si91_sequencial = $si91_sequencial "; 
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
