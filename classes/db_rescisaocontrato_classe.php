<?
//MODULO: sicom
//CLASSE DA ENTIDADE rescisaocontrato
class cl_rescisaocontrato { 
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
   var $si176_sequencial = 0; 
   var $si176_nrocontrato = 0; 
   var $si176_dataassinaturacontoriginal_dia = null; 
   var $si176_dataassinaturacontoriginal_mes = null; 
   var $si176_dataassinaturacontoriginal_ano = null; 
   var $si176_dataassinaturacontoriginal = null; 
   var $si1176_datarescisao_dia = null; 
   var $si1176_datarescisao_mes = null; 
   var $si1176_datarescisao_ano = null; 
   var $si1176_datarescisao = null; 
   var $si176_valorcancelamentocontrato = 0; 
   var $si176_ano = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si176_sequencial = int8 = sequencial 
                 si176_nrocontrato = int8 = Número do Contrato Original 
                 si176_dataassinaturacontoriginal = date = Data da assinatura  do Contrato 
                 si1176_datarescisao = date = Data da Rescisão Contratual 
                 si176_valorcancelamentocontrato = float8 = Valor do Cancelamento 
                 si176_ano = int8 = Ano 
                 ";
   //funcao construtor da classe 
   function cl_rescisaocontrato() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("rescisaocontrato"); 
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
       $this->si176_sequencial = ($this->si176_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si176_sequencial"]:$this->si176_sequencial);
       $this->si176_nrocontrato = ($this->si176_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si176_nrocontrato"]:$this->si176_nrocontrato);
       if($this->si176_dataassinaturacontoriginal == ""){
         $this->si176_dataassinaturacontoriginal_dia = ($this->si176_dataassinaturacontoriginal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si176_dataassinaturacontoriginal_dia"]:$this->si176_dataassinaturacontoriginal_dia);
         $this->si176_dataassinaturacontoriginal_mes = ($this->si176_dataassinaturacontoriginal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si176_dataassinaturacontoriginal_mes"]:$this->si176_dataassinaturacontoriginal_mes);
         $this->si176_dataassinaturacontoriginal_ano = ($this->si176_dataassinaturacontoriginal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si176_dataassinaturacontoriginal_ano"]:$this->si176_dataassinaturacontoriginal_ano);
         if($this->si176_dataassinaturacontoriginal_dia != ""){
            $this->si176_dataassinaturacontoriginal = $this->si176_dataassinaturacontoriginal_ano."-".$this->si176_dataassinaturacontoriginal_mes."-".$this->si176_dataassinaturacontoriginal_dia;
         }
       }
       if($this->si1176_datarescisao == ""){
         $this->si1176_datarescisao_dia = ($this->si1176_datarescisao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si1176_datarescisao_dia"]:$this->si1176_datarescisao_dia);
         $this->si1176_datarescisao_mes = ($this->si1176_datarescisao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si1176_datarescisao_mes"]:$this->si1176_datarescisao_mes);
         $this->si1176_datarescisao_ano = ($this->si1176_datarescisao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si1176_datarescisao_ano"]:$this->si1176_datarescisao_ano);
         if($this->si1176_datarescisao_dia != ""){
            $this->si1176_datarescisao = $this->si1176_datarescisao_ano."-".$this->si1176_datarescisao_mes."-".$this->si1176_datarescisao_dia;
         }
       }
       $this->si176_valorcancelamentocontrato = ($this->si176_valorcancelamentocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si176_valorcancelamentocontrato"]:$this->si176_valorcancelamentocontrato);
       $this->si176_ano = ($this->si176_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si176_ano"]:$this->si176_ano);
     }else{
       $this->si176_sequencial = ($this->si176_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si176_sequencial"]:$this->si176_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si176_sequencial){ 
      $this->atualizacampos();
     if($this->si176_nrocontrato == null ){ 
       $this->erro_sql = " Campo Número do Contrato Original nao Informado.";
       $this->erro_campo = "si176_nrocontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si176_dataassinaturacontoriginal == null ){ 
       $this->erro_sql = " Campo Data da assinatura  do Contrato nao Informado.";
       $this->erro_campo = "si176_dataassinaturacontoriginal_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si1176_datarescisao == null ){ 
       $this->erro_sql = " Campo Data da Rescisão Contratual nao Informado.";
       $this->erro_campo = "si1176_datarescisao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si176_valorcancelamentocontrato == null ){ 
       $this->erro_sql = " Campo Valor do Cancelamento nao Informado.";
       $this->erro_campo = "si176_valorcancelamentocontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si176_ano == null ){ 
       $this->erro_sql = " Campo Ano nao Informado.";
       $this->erro_campo = "si176_ano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si176_sequencial == "" || $si176_sequencial == null ){
       $result = db_query("select nextval('rescisaocontrato_si176_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rescisaocontrato_si176_sequencial_seq do campo: si176_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si176_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from rescisaocontrato_si176_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si176_sequencial)){
         $this->erro_sql = " Campo si176_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si176_sequencial = $si176_sequencial; 
       }
     }
     if(($this->si176_sequencial == null) || ($this->si176_sequencial == "") ){ 
       $this->erro_sql = " Campo si176_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rescisaocontrato(
                                       si176_sequencial 
                                      ,si176_nrocontrato 
                                      ,si176_dataassinaturacontoriginal 
                                      ,si1176_datarescisao 
                                      ,si176_valorcancelamentocontrato 
                                      ,si176_ano 
                       )
                values (
                                $this->si176_sequencial 
                               ,$this->si176_nrocontrato 
                               ,".($this->si176_dataassinaturacontoriginal == "null" || $this->si176_dataassinaturacontoriginal == ""?"null":"'".$this->si176_dataassinaturacontoriginal."'")." 
                               ,".($this->si1176_datarescisao == "null" || $this->si1176_datarescisao == ""?"null":"'".$this->si1176_datarescisao."'")." 
                               ,$this->si176_valorcancelamentocontrato 
                               ,$this->si176_ano 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "rescisaocontrato ($this->si176_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "rescisaocontrato já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "rescisaocontrato ($this->si176_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si176_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si176_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011516,'$this->si176_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010411,2011516,'','".AddSlashes(pg_result($resaco,0,'si176_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010411,2011517,'','".AddSlashes(pg_result($resaco,0,'si176_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010411,2011518,'','".AddSlashes(pg_result($resaco,0,'si176_dataassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010411,2011519,'','".AddSlashes(pg_result($resaco,0,'si1176_datarescisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010411,2011520,'','".AddSlashes(pg_result($resaco,0,'si176_valorcancelamentocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010411,2011521,'','".AddSlashes(pg_result($resaco,0,'si176_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si176_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rescisaocontrato set ";
     $virgula = "";
     if(trim($this->si176_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si176_sequencial"])){ 
       $sql  .= $virgula." si176_sequencial = $this->si176_sequencial ";
       $virgula = ",";
       if(trim($this->si176_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si176_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si176_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si176_nrocontrato"])){ 
       $sql  .= $virgula." si176_nrocontrato = $this->si176_nrocontrato ";
       $virgula = ",";
       if(trim($this->si176_nrocontrato) == null ){ 
         $this->erro_sql = " Campo Número do Contrato Original nao Informado.";
         $this->erro_campo = "si176_nrocontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si176_dataassinaturacontoriginal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si176_dataassinaturacontoriginal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si176_dataassinaturacontoriginal_dia"] !="") ){ 
       $sql  .= $virgula." si176_dataassinaturacontoriginal = '$this->si176_dataassinaturacontoriginal' ";
       $virgula = ",";
       if(trim($this->si176_dataassinaturacontoriginal) == null ){ 
         $this->erro_sql = " Campo Data da assinatura  do Contrato nao Informado.";
         $this->erro_campo = "si176_dataassinaturacontoriginal_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si176_dataassinaturacontoriginal_dia"])){ 
         $sql  .= $virgula." si176_dataassinaturacontoriginal = null ";
         $virgula = ",";
         if(trim($this->si176_dataassinaturacontoriginal) == null ){ 
           $this->erro_sql = " Campo Data da assinatura  do Contrato nao Informado.";
           $this->erro_campo = "si176_dataassinaturacontoriginal_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si1176_datarescisao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si1176_datarescisao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si1176_datarescisao_dia"] !="") ){ 
       $sql  .= $virgula." si1176_datarescisao = '$this->si1176_datarescisao' ";
       $virgula = ",";
       if(trim($this->si1176_datarescisao) == null ){ 
         $this->erro_sql = " Campo Data da Rescisão Contratual nao Informado.";
         $this->erro_campo = "si1176_datarescisao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si1176_datarescisao_dia"])){ 
         $sql  .= $virgula." si1176_datarescisao = null ";
         $virgula = ",";
         if(trim($this->si1176_datarescisao) == null ){ 
           $this->erro_sql = " Campo Data da Rescisão Contratual nao Informado.";
           $this->erro_campo = "si1176_datarescisao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si176_valorcancelamentocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si176_valorcancelamentocontrato"])){ 
       $sql  .= $virgula." si176_valorcancelamentocontrato = $this->si176_valorcancelamentocontrato ";
       $virgula = ",";
       if(trim($this->si176_valorcancelamentocontrato) == null ){ 
         $this->erro_sql = " Campo Valor do Cancelamento nao Informado.";
         $this->erro_campo = "si176_valorcancelamentocontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si176_ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si176_ano"])){ 
       $sql  .= $virgula." si176_ano = $this->si176_ano ";
       $virgula = ",";
       if(trim($this->si176_ano) == null ){ 
         $this->erro_sql = " Campo Ano nao Informado.";
         $this->erro_campo = "si176_ano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si176_sequencial!=null){
       $sql .= " si176_sequencial = $this->si176_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si176_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011516,'$this->si176_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si176_sequencial"]) || $this->si176_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010411,2011516,'".AddSlashes(pg_result($resaco,$conresaco,'si176_sequencial'))."','$this->si176_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si176_nrocontrato"]) || $this->si176_nrocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010411,2011517,'".AddSlashes(pg_result($resaco,$conresaco,'si176_nrocontrato'))."','$this->si176_nrocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si176_dataassinaturacontoriginal"]) || $this->si176_dataassinaturacontoriginal != "")
           $resac = db_query("insert into db_acount values($acount,2010411,2011518,'".AddSlashes(pg_result($resaco,$conresaco,'si176_dataassinaturacontoriginal'))."','$this->si176_dataassinaturacontoriginal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si1176_datarescisao"]) || $this->si1176_datarescisao != "")
           $resac = db_query("insert into db_acount values($acount,2010411,2011519,'".AddSlashes(pg_result($resaco,$conresaco,'si1176_datarescisao'))."','$this->si1176_datarescisao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si176_valorcancelamentocontrato"]) || $this->si176_valorcancelamentocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010411,2011520,'".AddSlashes(pg_result($resaco,$conresaco,'si176_valorcancelamentocontrato'))."','$this->si176_valorcancelamentocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si176_ano"]) || $this->si176_ano != "")
           $resac = db_query("insert into db_acount values($acount,2010411,2011521,'".AddSlashes(pg_result($resaco,$conresaco,'si176_ano'))."','$this->si176_ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rescisaocontrato nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si176_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rescisaocontrato nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si176_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si176_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si176_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si176_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011516,'$si176_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010411,2011516,'','".AddSlashes(pg_result($resaco,$iresaco,'si176_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010411,2011517,'','".AddSlashes(pg_result($resaco,$iresaco,'si176_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010411,2011518,'','".AddSlashes(pg_result($resaco,$iresaco,'si176_dataassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010411,2011519,'','".AddSlashes(pg_result($resaco,$iresaco,'si1176_datarescisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010411,2011520,'','".AddSlashes(pg_result($resaco,$iresaco,'si176_valorcancelamentocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010411,2011521,'','".AddSlashes(pg_result($resaco,$iresaco,'si176_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from rescisaocontrato
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si176_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si176_sequencial = $si176_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rescisaocontrato nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si176_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rescisaocontrato nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si176_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si176_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rescisaocontrato";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si176_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rescisaocontrato ";
     $sql .= "      inner join contratos  on  contratos.si172_sequencial = rescisaocontrato.si176_nrocontrato";
     $sql .= "      inner join pcorcamforne  on  pcorcamforne.pc21_orcamforne = contratos.si172_fornecedor";
     $sql .= "      inner join liclicita  on  liclicita.l20_codigo = contratos.si172_licitacao";
     $sql2 = "";
     if($dbwhere==""){
       if($si176_sequencial!=null ){
         $sql2 .= " where rescisaocontrato.si176_sequencial = $si176_sequencial "; 
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
   function sql_query_file ( $si176_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rescisaocontrato ";
     $sql2 = "";
     if($dbwhere==""){
       if($si176_sequencial!=null ){
         $sql2 .= " where rescisaocontrato.si176_sequencial = $si176_sequencial "; 
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
