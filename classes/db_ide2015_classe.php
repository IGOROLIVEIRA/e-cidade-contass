<?
//MODULO: sicom
//CLASSE DA ENTIDADE ide2015
class cl_ide2015 { 
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
   var $si11_sequencial = 0; 
   var $si11_codmunicipio = null; 
   var $si11_cnpjmunicipio = null; 
   var $si11_codorgao = null; 
   var $si11_tipoorgao = null; 
   var $si11_exercicioreferencia = 0; 
   var $si11_mesreferencia = null; 
   var $si11_datageracao_dia = null; 
   var $si11_datageracao_mes = null; 
   var $si11_datageracao_ano = null; 
   var $si11_datageracao = null; 
   var $si11_codcontroleremessa = null; 
   var $si11_mes = 0; 
   var $si11_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si11_sequencial = int8 = sequencial 
                 si11_codmunicipio = varchar(5) = Cod Municipio 
                 si11_cnpjmunicipio = varchar(14) = CNPJ Municipio 
                 si11_codorgao = varchar(2) = cod Orgão 
                 si11_tipoorgao = varchar(2) = tipo Orgão 
                 si11_exercicioreferencia = int8 = Exercício de  referência 
                 si11_mesreferencia = varchar(2) = Mês de referência 
                 si11_datageracao = date = Data de geração 
                 si11_codcontroleremessa = varchar(20) = Código de controle 
                 si11_mes = int8 = Mês 
                 si11_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ide2015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ide2015"); 
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
       $this->si11_sequencial = ($this->si11_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_sequencial"]:$this->si11_sequencial);
       $this->si11_codmunicipio = ($this->si11_codmunicipio == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_codmunicipio"]:$this->si11_codmunicipio);
       $this->si11_cnpjmunicipio = ($this->si11_cnpjmunicipio == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_cnpjmunicipio"]:$this->si11_cnpjmunicipio);
       $this->si11_codorgao = ($this->si11_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_codorgao"]:$this->si11_codorgao);
       $this->si11_tipoorgao = ($this->si11_tipoorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_tipoorgao"]:$this->si11_tipoorgao);
       $this->si11_exercicioreferencia = ($this->si11_exercicioreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_exercicioreferencia"]:$this->si11_exercicioreferencia);
       $this->si11_mesreferencia = ($this->si11_mesreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_mesreferencia"]:$this->si11_mesreferencia);
       if($this->si11_datageracao == ""){
         $this->si11_datageracao_dia = ($this->si11_datageracao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_datageracao_dia"]:$this->si11_datageracao_dia);
         $this->si11_datageracao_mes = ($this->si11_datageracao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_datageracao_mes"]:$this->si11_datageracao_mes);
         $this->si11_datageracao_ano = ($this->si11_datageracao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_datageracao_ano"]:$this->si11_datageracao_ano);
         if($this->si11_datageracao_dia != ""){
            $this->si11_datageracao = $this->si11_datageracao_ano."-".$this->si11_datageracao_mes."-".$this->si11_datageracao_dia;
         }
       }
       $this->si11_codcontroleremessa = ($this->si11_codcontroleremessa == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_codcontroleremessa"]:$this->si11_codcontroleremessa);
       $this->si11_mes = ($this->si11_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_mes"]:$this->si11_mes);
       $this->si11_instit = ($this->si11_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_instit"]:$this->si11_instit);
     }else{
       $this->si11_sequencial = ($this->si11_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si11_sequencial"]:$this->si11_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si11_sequencial){ 
      $this->atualizacampos();
     if($this->si11_exercicioreferencia == null ){ 
       $this->si11_exercicioreferencia = "0";
     }
     if($this->si11_datageracao == null ){ 
       $this->si11_datageracao = "null";
     }
     if($this->si11_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si11_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si11_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si11_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si11_sequencial == "" || $si11_sequencial == null ){
       $result = db_query("select nextval('ide2015_si11_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ide2015_si11_sequencial_seq do campo: si11_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si11_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ide2015_si11_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si11_sequencial)){
         $this->erro_sql = " Campo si11_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si11_sequencial = $si11_sequencial; 
       }
     }
     if(($this->si11_sequencial == null) || ($this->si11_sequencial == "") ){ 
       $this->erro_sql = " Campo si11_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ide2015(
                                       si11_sequencial 
                                      ,si11_codmunicipio 
                                      ,si11_cnpjmunicipio 
                                      ,si11_codorgao 
                                      ,si11_tipoorgao 
                                      ,si11_exercicioreferencia 
                                      ,si11_mesreferencia 
                                      ,si11_datageracao 
                                      ,si11_codcontroleremessa 
                                      ,si11_mes 
                                      ,si11_instit 
                       )
                values (
                                $this->si11_sequencial 
                               ,'$this->si11_codmunicipio' 
                               ,'$this->si11_cnpjmunicipio' 
                               ,'$this->si11_codorgao' 
                               ,'$this->si11_tipoorgao' 
                               ,$this->si11_exercicioreferencia 
                               ,'$this->si11_mesreferencia' 
                               ,".($this->si11_datageracao == "null" || $this->si11_datageracao == ""?"null":"'".$this->si11_datageracao."'")." 
                               ,'$this->si11_codcontroleremessa' 
                               ,$this->si11_mes 
                               ,$this->si11_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ide2015 ($this->si11_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ide2015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ide2015 ($this->si11_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si11_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si11_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009578,'$this->si11_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010239,2009578,'','".AddSlashes(pg_result($resaco,0,'si11_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2009579,'','".AddSlashes(pg_result($resaco,0,'si11_codmunicipio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2009580,'','".AddSlashes(pg_result($resaco,0,'si11_cnpjmunicipio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2009581,'','".AddSlashes(pg_result($resaco,0,'si11_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2009582,'','".AddSlashes(pg_result($resaco,0,'si11_tipoorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2009583,'','".AddSlashes(pg_result($resaco,0,'si11_exercicioreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2009584,'','".AddSlashes(pg_result($resaco,0,'si11_mesreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2009585,'','".AddSlashes(pg_result($resaco,0,'si11_datageracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2009586,'','".AddSlashes(pg_result($resaco,0,'si11_codcontroleremessa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2009732,'','".AddSlashes(pg_result($resaco,0,'si11_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010239,2011530,'','".AddSlashes(pg_result($resaco,0,'si11_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si11_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ide2015 set ";
     $virgula = "";
     if(trim($this->si11_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_sequencial"])){ 
        if(trim($this->si11_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si11_sequencial"])){ 
           $this->si11_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si11_sequencial = $this->si11_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si11_codmunicipio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_codmunicipio"])){ 
       $sql  .= $virgula." si11_codmunicipio = '$this->si11_codmunicipio' ";
       $virgula = ",";
     }
     if(trim($this->si11_cnpjmunicipio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_cnpjmunicipio"])){ 
       $sql  .= $virgula." si11_cnpjmunicipio = '$this->si11_cnpjmunicipio' ";
       $virgula = ",";
     }
     if(trim($this->si11_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_codorgao"])){ 
       $sql  .= $virgula." si11_codorgao = '$this->si11_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si11_tipoorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_tipoorgao"])){ 
       $sql  .= $virgula." si11_tipoorgao = '$this->si11_tipoorgao' ";
       $virgula = ",";
     }
     if(trim($this->si11_exercicioreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_exercicioreferencia"])){ 
        if(trim($this->si11_exercicioreferencia)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si11_exercicioreferencia"])){ 
           $this->si11_exercicioreferencia = "0" ; 
        } 
       $sql  .= $virgula." si11_exercicioreferencia = $this->si11_exercicioreferencia ";
       $virgula = ",";
     }
     if(trim($this->si11_mesreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_mesreferencia"])){ 
       $sql  .= $virgula." si11_mesreferencia = '$this->si11_mesreferencia' ";
       $virgula = ",";
     }
     if(trim($this->si11_datageracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_datageracao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si11_datageracao_dia"] !="") ){ 
       $sql  .= $virgula." si11_datageracao = '$this->si11_datageracao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si11_datageracao_dia"])){ 
         $sql  .= $virgula." si11_datageracao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si11_codcontroleremessa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_codcontroleremessa"])){ 
       $sql  .= $virgula." si11_codcontroleremessa = '$this->si11_codcontroleremessa' ";
       $virgula = ",";
     }
     if(trim($this->si11_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_mes"])){ 
       $sql  .= $virgula." si11_mes = $this->si11_mes ";
       $virgula = ",";
       if(trim($this->si11_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si11_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si11_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si11_instit"])){ 
       $sql  .= $virgula." si11_instit = $this->si11_instit ";
       $virgula = ",";
       if(trim($this->si11_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si11_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si11_sequencial!=null){
       $sql .= " si11_sequencial = $this->si11_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si11_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009578,'$this->si11_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_sequencial"]) || $this->si11_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009578,'".AddSlashes(pg_result($resaco,$conresaco,'si11_sequencial'))."','$this->si11_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_codmunicipio"]) || $this->si11_codmunicipio != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009579,'".AddSlashes(pg_result($resaco,$conresaco,'si11_codmunicipio'))."','$this->si11_codmunicipio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_cnpjmunicipio"]) || $this->si11_cnpjmunicipio != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009580,'".AddSlashes(pg_result($resaco,$conresaco,'si11_cnpjmunicipio'))."','$this->si11_cnpjmunicipio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_codorgao"]) || $this->si11_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009581,'".AddSlashes(pg_result($resaco,$conresaco,'si11_codorgao'))."','$this->si11_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_tipoorgao"]) || $this->si11_tipoorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009582,'".AddSlashes(pg_result($resaco,$conresaco,'si11_tipoorgao'))."','$this->si11_tipoorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_exercicioreferencia"]) || $this->si11_exercicioreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009583,'".AddSlashes(pg_result($resaco,$conresaco,'si11_exercicioreferencia'))."','$this->si11_exercicioreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_mesreferencia"]) || $this->si11_mesreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009584,'".AddSlashes(pg_result($resaco,$conresaco,'si11_mesreferencia'))."','$this->si11_mesreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_datageracao"]) || $this->si11_datageracao != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009585,'".AddSlashes(pg_result($resaco,$conresaco,'si11_datageracao'))."','$this->si11_datageracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_codcontroleremessa"]) || $this->si11_codcontroleremessa != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009586,'".AddSlashes(pg_result($resaco,$conresaco,'si11_codcontroleremessa'))."','$this->si11_codcontroleremessa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_mes"]) || $this->si11_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2009732,'".AddSlashes(pg_result($resaco,$conresaco,'si11_mes'))."','$this->si11_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si11_instit"]) || $this->si11_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010239,2011530,'".AddSlashes(pg_result($resaco,$conresaco,'si11_instit'))."','$this->si11_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ide2015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si11_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ide2015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si11_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si11_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si11_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si11_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009578,'$si11_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010239,2009578,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2009579,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_codmunicipio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2009580,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_cnpjmunicipio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2009581,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2009582,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_tipoorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2009583,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_exercicioreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2009584,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_mesreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2009585,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_datageracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2009586,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_codcontroleremessa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2009732,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010239,2011530,'','".AddSlashes(pg_result($resaco,$iresaco,'si11_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ide2015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si11_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si11_sequencial = $si11_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ide2015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si11_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ide2015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si11_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si11_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ide2015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si11_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ide2015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si11_sequencial!=null ){
         $sql2 .= " where ide2015.si11_sequencial = $si11_sequencial "; 
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
   function sql_query_file ( $si11_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ide2015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si11_sequencial!=null ){
         $sql2 .= " where ide2015.si11_sequencial = $si11_sequencial "; 
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
