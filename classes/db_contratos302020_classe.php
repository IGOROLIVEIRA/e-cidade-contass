<?
//MODULO: sicom
//CLASSE DA ENTIDADE contratos302020
class cl_contratos302020 { 
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
   var $si89_sequencial = 0;
   var $si89_tiporegistro = 0; 
   var $si89_codorgao = null; 
   var $si89_codunidadesub = null; 
   var $si89_nrocontrato = 0; 
   var $si89_dtassinaturacontoriginal_dia = null; 
   var $si89_dtassinaturacontoriginal_mes = null; 
   var $si89_dtassinaturacontoriginal_ano = null; 
   var $si89_dtassinaturacontoriginal = null; 
   var $si89_tipoapostila = null; 
   var $si89_nroseqapostila = 0; 
   var $si89_dataapostila_dia = null; 
   var $si89_dataapostila_mes = null; 
   var $si89_dataapostila_ano = null; 
   var $si89_dataapostila = null; 
   var $si89_tipoalteracaoapostila = 0; 
   var $si89_dscalteracao = null; 
   var $si89_valorapostila = 0; 
   var $si89_mes = 0; 
   var $si89_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si89_sequencial = int8 = sequencial 
                 si89_tiporegistro = int8 = Tipo do  registro 
                 si89_codorgao = varchar(2) = Código do órgão 
                 si89_codunidadesub = varchar(8) = Código da unidade 
                 si89_nrocontrato = int8 = Número do  Contrato Original 
                 si89_dtassinaturacontoriginal = date = Data da assinatura  do Contrato 
                 si89_tipoapostila = varchar(2) = Tipo de Apostila 
                 si89_nroseqapostila = int8 = Número sequencial  da apostila 
                 si89_dataapostila = date = Data da apostila 
                 si89_tipoalteracaoapostila = int8 = Tipo de alteração 
                 si89_dscalteracao = varchar(250) = Descrição da  alteração 
                 si89_valorapostila = float8 = Valor da Aposlila 
                 si89_mes = int8 = Mês 
                 si89_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_contratos302020() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("contratos302020"); 
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
       $this->si89_sequencial = ($this->si89_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_sequencial"]:$this->si89_sequencial);
       $this->si89_tiporegistro = ($this->si89_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_tiporegistro"]:$this->si89_tiporegistro);
       $this->si89_codorgao = ($this->si89_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_codorgao"]:$this->si89_codorgao);
       $this->si89_codunidadesub = ($this->si89_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_codunidadesub"]:$this->si89_codunidadesub);
       $this->si89_nrocontrato = ($this->si89_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_nrocontrato"]:$this->si89_nrocontrato);
       if($this->si89_dtassinaturacontoriginal == ""){
         $this->si89_dtassinaturacontoriginal_dia = ($this->si89_dtassinaturacontoriginal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_dtassinaturacontoriginal_dia"]:$this->si89_dtassinaturacontoriginal_dia);
         $this->si89_dtassinaturacontoriginal_mes = ($this->si89_dtassinaturacontoriginal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_dtassinaturacontoriginal_mes"]:$this->si89_dtassinaturacontoriginal_mes);
         $this->si89_dtassinaturacontoriginal_ano = ($this->si89_dtassinaturacontoriginal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_dtassinaturacontoriginal_ano"]:$this->si89_dtassinaturacontoriginal_ano);
         if($this->si89_dtassinaturacontoriginal_dia != ""){
            $this->si89_dtassinaturacontoriginal = $this->si89_dtassinaturacontoriginal_ano."-".$this->si89_dtassinaturacontoriginal_mes."-".$this->si89_dtassinaturacontoriginal_dia;
         }
       }
       $this->si89_tipoapostila = ($this->si89_tipoapostila == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_tipoapostila"]:$this->si89_tipoapostila);
       $this->si89_nroseqapostila = ($this->si89_nroseqapostila == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_nroseqapostila"]:$this->si89_nroseqapostila);
       if($this->si89_dataapostila == ""){
         $this->si89_dataapostila_dia = ($this->si89_dataapostila_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_dataapostila_dia"]:$this->si89_dataapostila_dia);
         $this->si89_dataapostila_mes = ($this->si89_dataapostila_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_dataapostila_mes"]:$this->si89_dataapostila_mes);
         $this->si89_dataapostila_ano = ($this->si89_dataapostila_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_dataapostila_ano"]:$this->si89_dataapostila_ano);
         if($this->si89_dataapostila_dia != ""){
            $this->si89_dataapostila = $this->si89_dataapostila_ano."-".$this->si89_dataapostila_mes."-".$this->si89_dataapostila_dia;
         }
       }
       $this->si89_tipoalteracaoapostila = ($this->si89_tipoalteracaoapostila == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_tipoalteracaoapostila"]:$this->si89_tipoalteracaoapostila);
       $this->si89_dscalteracao = ($this->si89_dscalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_dscalteracao"]:$this->si89_dscalteracao);
       $this->si89_valorapostila = ($this->si89_valorapostila == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_valorapostila"]:$this->si89_valorapostila);
       $this->si89_mes = ($this->si89_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_mes"]:$this->si89_mes);
       $this->si89_instit = ($this->si89_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_instit"]:$this->si89_instit);
     }else{
       $this->si89_sequencial = ($this->si89_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si89_sequencial"]:$this->si89_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si89_sequencial){ 
      $this->atualizacampos();
     if($this->si89_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si89_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si89_nrocontrato == null ){ 
       $this->si89_nrocontrato = "0";
     }
     if($this->si89_dtassinaturacontoriginal == null ){ 
       $this->si89_dtassinaturacontoriginal = "null";
     }
     if($this->si89_nroseqapostila == null ){ 
       $this->si89_nroseqapostila = "0";
     }
     if($this->si89_dataapostila == null ){ 
       $this->si89_dataapostila = "null";
     }
     if($this->si89_tipoalteracaoapostila == null ){ 
       $this->si89_tipoalteracaoapostila = "0";
     }
     if($this->si89_valorapostila == null ){ 
       $this->si89_valorapostila = "0";
     }
     if($this->si89_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si89_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si89_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si89_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si89_sequencial == "" || $si89_sequencial == null ){
       $result = db_query("select nextval('contratos302020_si89_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contratos302020_si89_sequencial_seq do campo: si89_sequencial"; 
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si89_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from contratos302020_si89_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si89_sequencial)){
         $this->erro_sql = " Campo si89_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si89_sequencial = $si89_sequencial; 
       }
     }
     if(($this->si89_sequencial == null) || ($this->si89_sequencial == "") ){ 
       $this->erro_sql = " Campo si89_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into contratos302020(
                                       si89_sequencial 
                                      ,si89_tiporegistro 
                                      ,si89_codorgao 
                                      ,si89_codunidadesub 
                                      ,si89_nrocontrato 
                                      ,si89_dtassinaturacontoriginal 
                                      ,si89_tipoapostila 
                                      ,si89_nroseqapostila 
                                      ,si89_dataapostila 
                                      ,si89_tipoalteracaoapostila 
                                      ,si89_dscalteracao 
                                      ,si89_valorapostila 
                                      ,si89_mes 
                                      ,si89_instit 
                       )
                values (
                                $this->si89_sequencial 
                               ,$this->si89_tiporegistro 
                               ,'$this->si89_codorgao' 
                               ,'$this->si89_codunidadesub' 
                               ,$this->si89_nrocontrato 
                               ,".($this->si89_dtassinaturacontoriginal == "null" || $this->si89_dtassinaturacontoriginal == ""?"null":"'".$this->si89_dtassinaturacontoriginal."'")." 
                               ,'$this->si89_tipoapostila' 
                               ,$this->si89_nroseqapostila 
                               ,".($this->si89_dataapostila == "null" || $this->si89_dataapostila == ""?"null":"'".$this->si89_dataapostila."'")." 
                               ,$this->si89_tipoalteracaoapostila 
                               ,'$this->si89_dscalteracao' 
                               ,$this->si89_valorapostila 
                               ,$this->si89_mes 
                               ,$this->si89_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "contratos302020 ($this->si89_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "contratos302020 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "contratos302020 ($this->si89_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si89_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si89_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010485,'$this->si89_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010318,2010485,'','".AddSlashes(pg_result($resaco,0,'si89_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010486,'','".AddSlashes(pg_result($resaco,0,'si89_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010487,'','".AddSlashes(pg_result($resaco,0,'si89_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010488,'','".AddSlashes(pg_result($resaco,0,'si89_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010489,'','".AddSlashes(pg_result($resaco,0,'si89_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010490,'','".AddSlashes(pg_result($resaco,0,'si89_dtassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010491,'','".AddSlashes(pg_result($resaco,0,'si89_tipoapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010492,'','".AddSlashes(pg_result($resaco,0,'si89_nroseqapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010493,'','".AddSlashes(pg_result($resaco,0,'si89_dataapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010494,'','".AddSlashes(pg_result($resaco,0,'si89_tipoalteracaoapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010495,'','".AddSlashes(pg_result($resaco,0,'si89_dscalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010496,'','".AddSlashes(pg_result($resaco,0,'si89_valorapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2010497,'','".AddSlashes(pg_result($resaco,0,'si89_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010318,2011602,'','".AddSlashes(pg_result($resaco,0,'si89_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si89_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update contratos302020 set ";
     $virgula = "";
     if(trim($this->si89_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_sequencial"])){ 
        if(trim($this->si89_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si89_sequencial"])){ 
           $this->si89_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si89_sequencial = $this->si89_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si89_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_tiporegistro"])){ 
       $sql  .= $virgula." si89_tiporegistro = $this->si89_tiporegistro ";
       $virgula = ",";
       if(trim($this->si89_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si89_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si89_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_codorgao"])){ 
       $sql  .= $virgula." si89_codorgao = '$this->si89_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si89_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_codunidadesub"])){ 
       $sql  .= $virgula." si89_codunidadesub = '$this->si89_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si89_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_nrocontrato"])){ 
        if(trim($this->si89_nrocontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si89_nrocontrato"])){ 
           $this->si89_nrocontrato = "0" ; 
        } 
       $sql  .= $virgula." si89_nrocontrato = $this->si89_nrocontrato ";
       $virgula = ",";
     }
     if(trim($this->si89_dtassinaturacontoriginal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_dtassinaturacontoriginal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si89_dtassinaturacontoriginal_dia"] !="") ){ 
       $sql  .= $virgula." si89_dtassinaturacontoriginal = '$this->si89_dtassinaturacontoriginal' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si89_dtassinaturacontoriginal_dia"])){ 
         $sql  .= $virgula." si89_dtassinaturacontoriginal = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si89_tipoapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_tipoapostila"])){ 
       $sql  .= $virgula." si89_tipoapostila = '$this->si89_tipoapostila' ";
       $virgula = ",";
     }
     if(trim($this->si89_nroseqapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_nroseqapostila"])){ 
        if(trim($this->si89_nroseqapostila)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si89_nroseqapostila"])){ 
           $this->si89_nroseqapostila = "0" ; 
        } 
       $sql  .= $virgula." si89_nroseqapostila = $this->si89_nroseqapostila ";
       $virgula = ",";
     }
     if(trim($this->si89_dataapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_dataapostila_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si89_dataapostila_dia"] !="") ){ 
       $sql  .= $virgula." si89_dataapostila = '$this->si89_dataapostila' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si89_dataapostila_dia"])){ 
         $sql  .= $virgula." si89_dataapostila = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si89_tipoalteracaoapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_tipoalteracaoapostila"])){ 
        if(trim($this->si89_tipoalteracaoapostila)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si89_tipoalteracaoapostila"])){ 
           $this->si89_tipoalteracaoapostila = "0" ; 
        } 
       $sql  .= $virgula." si89_tipoalteracaoapostila = $this->si89_tipoalteracaoapostila ";
       $virgula = ",";
     }
     if(trim($this->si89_dscalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_dscalteracao"])){ 
       $sql  .= $virgula." si89_dscalteracao = '$this->si89_dscalteracao' ";
       $virgula = ",";
     }
     if(trim($this->si89_valorapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_valorapostila"])){ 
        if(trim($this->si89_valorapostila)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si89_valorapostila"])){ 
           $this->si89_valorapostila = "0" ; 
        } 
       $sql  .= $virgula." si89_valorapostila = $this->si89_valorapostila ";
       $virgula = ",";
     }
     if(trim($this->si89_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_mes"])){ 
       $sql  .= $virgula." si89_mes = $this->si89_mes ";
       $virgula = ",";
       if(trim($this->si89_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si89_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si89_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si89_instit"])){ 
       $sql  .= $virgula." si89_instit = $this->si89_instit ";
       $virgula = ",";
       if(trim($this->si89_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si89_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si89_sequencial!=null){
       $sql .= " si89_sequencial = $this->si89_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si89_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010485,'$this->si89_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_sequencial"]) || $this->si89_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010485,'".AddSlashes(pg_result($resaco,$conresaco,'si89_sequencial'))."','$this->si89_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_tiporegistro"]) || $this->si89_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010486,'".AddSlashes(pg_result($resaco,$conresaco,'si89_tiporegistro'))."','$this->si89_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_codorgao"]) || $this->si89_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010487,'".AddSlashes(pg_result($resaco,$conresaco,'si89_codorgao'))."','$this->si89_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_codunidadesub"]) || $this->si89_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010488,'".AddSlashes(pg_result($resaco,$conresaco,'si89_codunidadesub'))."','$this->si89_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_nrocontrato"]) || $this->si89_nrocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010489,'".AddSlashes(pg_result($resaco,$conresaco,'si89_nrocontrato'))."','$this->si89_nrocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_dtassinaturacontoriginal"]) || $this->si89_dtassinaturacontoriginal != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010490,'".AddSlashes(pg_result($resaco,$conresaco,'si89_dtassinaturacontoriginal'))."','$this->si89_dtassinaturacontoriginal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_tipoapostila"]) || $this->si89_tipoapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010491,'".AddSlashes(pg_result($resaco,$conresaco,'si89_tipoapostila'))."','$this->si89_tipoapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_nroseqapostila"]) || $this->si89_nroseqapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010492,'".AddSlashes(pg_result($resaco,$conresaco,'si89_nroseqapostila'))."','$this->si89_nroseqapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_dataapostila"]) || $this->si89_dataapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010493,'".AddSlashes(pg_result($resaco,$conresaco,'si89_dataapostila'))."','$this->si89_dataapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_tipoalteracaoapostila"]) || $this->si89_tipoalteracaoapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010494,'".AddSlashes(pg_result($resaco,$conresaco,'si89_tipoalteracaoapostila'))."','$this->si89_tipoalteracaoapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_dscalteracao"]) || $this->si89_dscalteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010495,'".AddSlashes(pg_result($resaco,$conresaco,'si89_dscalteracao'))."','$this->si89_dscalteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_valorapostila"]) || $this->si89_valorapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010496,'".AddSlashes(pg_result($resaco,$conresaco,'si89_valorapostila'))."','$this->si89_valorapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_mes"]) || $this->si89_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2010497,'".AddSlashes(pg_result($resaco,$conresaco,'si89_mes'))."','$this->si89_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si89_instit"]) || $this->si89_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010318,2011602,'".AddSlashes(pg_result($resaco,$conresaco,'si89_instit'))."','$this->si89_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "contratos302020 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si89_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos302020 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si89_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si89_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si89_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si89_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010485,'$si89_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010318,2010485,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010486,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010487,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010488,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010489,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010490,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_dtassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010491,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_tipoapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010492,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_nroseqapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010493,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_dataapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010494,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_tipoalteracaoapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010495,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_dscalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010496,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_valorapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2010497,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010318,2011602,'','".AddSlashes(pg_result($resaco,$iresaco,'si89_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from contratos302020
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si89_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si89_sequencial = $si89_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "contratos302020 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si89_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos302020 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si89_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si89_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:contratos302020";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si89_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos302020 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si89_sequencial!=null ){
         $sql2 .= " where contratos302020.si89_sequencial = $si89_sequencial "; 
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
   function sql_query_file ( $si89_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos302020 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si89_sequencial!=null ){
         $sql2 .= " where contratos302020.si89_sequencial = $si89_sequencial "; 
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
