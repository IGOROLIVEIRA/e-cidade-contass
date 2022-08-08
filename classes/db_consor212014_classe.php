<?
//MODULO: sicom
//CLASSE DA ENTIDADE consor212014
class cl_consor212014 { 
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
   var $si18_sequencial = 0; 
   var $si18_tiporegistro = 0; 
   var $si18_cnpjconsorcio = null; 
   var $si18_codfuncao = null; 
   var $si18_codsubfuncao = null; 
   var $si18_naturezadespesa = 0; 
   var $si18_subelemento = null; 
   var $si18_vlempenhado = 0; 
   var $si18_vlanulacaoempenho = 0; 
   var $si18_vlliquidado = 0; 
   var $si18_vlanulacaoliquidacao = 0; 
   var $si18_vlpago = 0; 
   var $si18_vlanulacaopagamento = 0; 
   var $si18_mes = 0; 
   var $si18_reg20 = 0; 
   var $si18_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si18_sequencial = int8 = sequencial 
                 si18_tiporegistro = int8 = Tipo do registro 
                 si18_cnpjconsorcio = varchar(14) = Código do  Consórcio 
                 si18_codfuncao = varchar(2) = Código da função 
                 si18_codsubfuncao = varchar(3) = Código da  Subfunção 
                 si18_naturezadespesa = int8 = Código da natureza 
                 si18_subelemento = varchar(2) = Subelemento da  despesa 
                 si18_vlempenhado = float8 = Valor empenhado  no mês 
                 si18_vlanulacaoempenho = float8 = Valor de empenhos  anulados no mês 
                 si18_vlliquidado = float8 = Valor liquidado no  mês 
                 si18_vlanulacaoliquidacao = float8 = Valor de  liquidações 
                 si18_vlpago = float8 = Valor pago no mês 
                 si18_vlanulacaopagamento = float8 = Valor de  pagamentos 
                 si18_mes = int8 = Mês 
                 si18_reg20 = int8 = reg20 
                 si18_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_consor212014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("consor212014"); 
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
       $this->si18_sequencial = ($this->si18_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_sequencial"]:$this->si18_sequencial);
       $this->si18_tiporegistro = ($this->si18_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_tiporegistro"]:$this->si18_tiporegistro);
       $this->si18_cnpjconsorcio = ($this->si18_cnpjconsorcio == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_cnpjconsorcio"]:$this->si18_cnpjconsorcio);
       $this->si18_codfuncao = ($this->si18_codfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_codfuncao"]:$this->si18_codfuncao);
       $this->si18_codsubfuncao = ($this->si18_codsubfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_codsubfuncao"]:$this->si18_codsubfuncao);
       $this->si18_naturezadespesa = ($this->si18_naturezadespesa == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_naturezadespesa"]:$this->si18_naturezadespesa);
       $this->si18_subelemento = ($this->si18_subelemento == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_subelemento"]:$this->si18_subelemento);
       $this->si18_vlempenhado = ($this->si18_vlempenhado == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_vlempenhado"]:$this->si18_vlempenhado);
       $this->si18_vlanulacaoempenho = ($this->si18_vlanulacaoempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaoempenho"]:$this->si18_vlanulacaoempenho);
       $this->si18_vlliquidado = ($this->si18_vlliquidado == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_vlliquidado"]:$this->si18_vlliquidado);
       $this->si18_vlanulacaoliquidacao = ($this->si18_vlanulacaoliquidacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaoliquidacao"]:$this->si18_vlanulacaoliquidacao);
       $this->si18_vlpago = ($this->si18_vlpago == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_vlpago"]:$this->si18_vlpago);
       $this->si18_vlanulacaopagamento = ($this->si18_vlanulacaopagamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaopagamento"]:$this->si18_vlanulacaopagamento);
       $this->si18_mes = ($this->si18_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_mes"]:$this->si18_mes);
       $this->si18_reg20 = ($this->si18_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_reg20"]:$this->si18_reg20);
       $this->si18_instit = ($this->si18_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_instit"]:$this->si18_instit);
     }else{
       $this->si18_sequencial = ($this->si18_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si18_sequencial"]:$this->si18_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si18_sequencial){ 
      $this->atualizacampos();
     if($this->si18_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si18_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si18_naturezadespesa == null ){ 
       $this->si18_naturezadespesa = "0";
     }
     if($this->si18_vlempenhado == null ){ 
       $this->si18_vlempenhado = "0";
     }
     if($this->si18_vlanulacaoempenho == null ){ 
       $this->si18_vlanulacaoempenho = "0";
     }
     if($this->si18_vlliquidado == null ){ 
       $this->si18_vlliquidado = "0";
     }
     if($this->si18_vlanulacaoliquidacao == null ){ 
       $this->si18_vlanulacaoliquidacao = "0";
     }
     if($this->si18_vlpago == null ){ 
       $this->si18_vlpago = "0";
     }
     if($this->si18_vlanulacaopagamento == null ){ 
       $this->si18_vlanulacaopagamento = "0";
     }
     if($this->si18_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si18_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si18_reg20 == null ){ 
       $this->si18_reg20 = "0";
     }
     if($this->si18_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si18_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si18_sequencial == "" || $si18_sequencial == null ){
       $result = db_query("select nextval('consor212014_si18_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: consor212014_si18_sequencial_seq do campo: si18_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si18_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from consor212014_si18_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si18_sequencial)){
         $this->erro_sql = " Campo si18_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si18_sequencial = $si18_sequencial; 
       }
     }
     if(($this->si18_sequencial == null) || ($this->si18_sequencial == "") ){ 
       $this->erro_sql = " Campo si18_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into consor212014(
                                       si18_sequencial 
                                      ,si18_tiporegistro 
                                      ,si18_cnpjconsorcio 
                                      ,si18_codfuncao 
                                      ,si18_codsubfuncao 
                                      ,si18_naturezadespesa 
                                      ,si18_subelemento 
                                      ,si18_vlempenhado 
                                      ,si18_vlanulacaoempenho 
                                      ,si18_vlliquidado 
                                      ,si18_vlanulacaoliquidacao 
                                      ,si18_vlpago 
                                      ,si18_vlanulacaopagamento 
                                      ,si18_mes 
                                      ,si18_reg20 
                                      ,si18_instit 
                       )
                values (
                                $this->si18_sequencial 
                               ,$this->si18_tiporegistro 
                               ,'$this->si18_cnpjconsorcio' 
                               ,'$this->si18_codfuncao' 
                               ,'$this->si18_codsubfuncao' 
                               ,$this->si18_naturezadespesa 
                               ,'$this->si18_subelemento' 
                               ,$this->si18_vlempenhado 
                               ,$this->si18_vlanulacaoempenho 
                               ,$this->si18_vlliquidado 
                               ,$this->si18_vlanulacaoliquidacao 
                               ,$this->si18_vlpago 
                               ,$this->si18_vlanulacaopagamento 
                               ,$this->si18_mes 
                               ,$this->si18_reg20 
                               ,$this->si18_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "consor212014 ($this->si18_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "consor212014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "consor212014 ($this->si18_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si18_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si18_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009630,'$this->si18_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010246,2009630,'','".AddSlashes(pg_result($resaco,0,'si18_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009631,'','".AddSlashes(pg_result($resaco,0,'si18_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009632,'','".AddSlashes(pg_result($resaco,0,'si18_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009633,'','".AddSlashes(pg_result($resaco,0,'si18_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009634,'','".AddSlashes(pg_result($resaco,0,'si18_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009635,'','".AddSlashes(pg_result($resaco,0,'si18_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009636,'','".AddSlashes(pg_result($resaco,0,'si18_subelemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009637,'','".AddSlashes(pg_result($resaco,0,'si18_vlempenhado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009638,'','".AddSlashes(pg_result($resaco,0,'si18_vlanulacaoempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009639,'','".AddSlashes(pg_result($resaco,0,'si18_vlliquidado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009640,'','".AddSlashes(pg_result($resaco,0,'si18_vlanulacaoliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009641,'','".AddSlashes(pg_result($resaco,0,'si18_vlpago'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009642,'','".AddSlashes(pg_result($resaco,0,'si18_vlanulacaopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2009738,'','".AddSlashes(pg_result($resaco,0,'si18_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2011323,'','".AddSlashes(pg_result($resaco,0,'si18_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010246,2011536,'','".AddSlashes(pg_result($resaco,0,'si18_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si18_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update consor212014 set ";
     $virgula = "";
     if(trim($this->si18_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_sequencial"])){ 
        if(trim($this->si18_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si18_sequencial"])){ 
           $this->si18_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si18_sequencial = $this->si18_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si18_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_tiporegistro"])){ 
       $sql  .= $virgula." si18_tiporegistro = $this->si18_tiporegistro ";
       $virgula = ",";
       if(trim($this->si18_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si18_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si18_cnpjconsorcio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_cnpjconsorcio"])){ 
       $sql  .= $virgula." si18_cnpjconsorcio = '$this->si18_cnpjconsorcio' ";
       $virgula = ",";
     }
     if(trim($this->si18_codfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_codfuncao"])){ 
       $sql  .= $virgula." si18_codfuncao = '$this->si18_codfuncao' ";
       $virgula = ",";
     }
     if(trim($this->si18_codsubfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_codsubfuncao"])){ 
       $sql  .= $virgula." si18_codsubfuncao = '$this->si18_codsubfuncao' ";
       $virgula = ",";
     }
     if(trim($this->si18_naturezadespesa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_naturezadespesa"])){ 
        if(trim($this->si18_naturezadespesa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si18_naturezadespesa"])){ 
           $this->si18_naturezadespesa = "0" ; 
        } 
       $sql  .= $virgula." si18_naturezadespesa = $this->si18_naturezadespesa ";
       $virgula = ",";
     }
     if(trim($this->si18_subelemento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_subelemento"])){ 
       $sql  .= $virgula." si18_subelemento = '$this->si18_subelemento' ";
       $virgula = ",";
     }
     if(trim($this->si18_vlempenhado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_vlempenhado"])){ 
        if(trim($this->si18_vlempenhado)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si18_vlempenhado"])){ 
           $this->si18_vlempenhado = "0" ; 
        } 
       $sql  .= $virgula." si18_vlempenhado = $this->si18_vlempenhado ";
       $virgula = ",";
     }
     if(trim($this->si18_vlanulacaoempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaoempenho"])){ 
        if(trim($this->si18_vlanulacaoempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaoempenho"])){ 
           $this->si18_vlanulacaoempenho = "0" ; 
        } 
       $sql  .= $virgula." si18_vlanulacaoempenho = $this->si18_vlanulacaoempenho ";
       $virgula = ",";
     }
     if(trim($this->si18_vlliquidado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_vlliquidado"])){ 
        if(trim($this->si18_vlliquidado)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si18_vlliquidado"])){ 
           $this->si18_vlliquidado = "0" ; 
        } 
       $sql  .= $virgula." si18_vlliquidado = $this->si18_vlliquidado ";
       $virgula = ",";
     }
     if(trim($this->si18_vlanulacaoliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaoliquidacao"])){ 
        if(trim($this->si18_vlanulacaoliquidacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaoliquidacao"])){ 
           $this->si18_vlanulacaoliquidacao = "0" ; 
        } 
       $sql  .= $virgula." si18_vlanulacaoliquidacao = $this->si18_vlanulacaoliquidacao ";
       $virgula = ",";
     }
     if(trim($this->si18_vlpago)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_vlpago"])){ 
        if(trim($this->si18_vlpago)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si18_vlpago"])){ 
           $this->si18_vlpago = "0" ; 
        } 
       $sql  .= $virgula." si18_vlpago = $this->si18_vlpago ";
       $virgula = ",";
     }
     if(trim($this->si18_vlanulacaopagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaopagamento"])){ 
        if(trim($this->si18_vlanulacaopagamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaopagamento"])){ 
           $this->si18_vlanulacaopagamento = "0" ; 
        } 
       $sql  .= $virgula." si18_vlanulacaopagamento = $this->si18_vlanulacaopagamento ";
       $virgula = ",";
     }
     if(trim($this->si18_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_mes"])){ 
       $sql  .= $virgula." si18_mes = $this->si18_mes ";
       $virgula = ",";
       if(trim($this->si18_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si18_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si18_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_reg20"])){ 
        if(trim($this->si18_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si18_reg20"])){ 
           $this->si18_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si18_reg20 = $this->si18_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si18_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si18_instit"])){ 
       $sql  .= $virgula." si18_instit = $this->si18_instit ";
       $virgula = ",";
       if(trim($this->si18_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si18_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si18_sequencial!=null){
       $sql .= " si18_sequencial = $this->si18_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si18_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009630,'$this->si18_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_sequencial"]) || $this->si18_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009630,'".AddSlashes(pg_result($resaco,$conresaco,'si18_sequencial'))."','$this->si18_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_tiporegistro"]) || $this->si18_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009631,'".AddSlashes(pg_result($resaco,$conresaco,'si18_tiporegistro'))."','$this->si18_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_cnpjconsorcio"]) || $this->si18_cnpjconsorcio != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009632,'".AddSlashes(pg_result($resaco,$conresaco,'si18_cnpjconsorcio'))."','$this->si18_cnpjconsorcio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_codfuncao"]) || $this->si18_codfuncao != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009633,'".AddSlashes(pg_result($resaco,$conresaco,'si18_codfuncao'))."','$this->si18_codfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_codsubfuncao"]) || $this->si18_codsubfuncao != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009634,'".AddSlashes(pg_result($resaco,$conresaco,'si18_codsubfuncao'))."','$this->si18_codsubfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_naturezadespesa"]) || $this->si18_naturezadespesa != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009635,'".AddSlashes(pg_result($resaco,$conresaco,'si18_naturezadespesa'))."','$this->si18_naturezadespesa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_subelemento"]) || $this->si18_subelemento != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009636,'".AddSlashes(pg_result($resaco,$conresaco,'si18_subelemento'))."','$this->si18_subelemento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_vlempenhado"]) || $this->si18_vlempenhado != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009637,'".AddSlashes(pg_result($resaco,$conresaco,'si18_vlempenhado'))."','$this->si18_vlempenhado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaoempenho"]) || $this->si18_vlanulacaoempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009638,'".AddSlashes(pg_result($resaco,$conresaco,'si18_vlanulacaoempenho'))."','$this->si18_vlanulacaoempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_vlliquidado"]) || $this->si18_vlliquidado != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009639,'".AddSlashes(pg_result($resaco,$conresaco,'si18_vlliquidado'))."','$this->si18_vlliquidado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaoliquidacao"]) || $this->si18_vlanulacaoliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009640,'".AddSlashes(pg_result($resaco,$conresaco,'si18_vlanulacaoliquidacao'))."','$this->si18_vlanulacaoliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_vlpago"]) || $this->si18_vlpago != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009641,'".AddSlashes(pg_result($resaco,$conresaco,'si18_vlpago'))."','$this->si18_vlpago',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_vlanulacaopagamento"]) || $this->si18_vlanulacaopagamento != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009642,'".AddSlashes(pg_result($resaco,$conresaco,'si18_vlanulacaopagamento'))."','$this->si18_vlanulacaopagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_mes"]) || $this->si18_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2009738,'".AddSlashes(pg_result($resaco,$conresaco,'si18_mes'))."','$this->si18_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_reg20"]) || $this->si18_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2011323,'".AddSlashes(pg_result($resaco,$conresaco,'si18_reg20'))."','$this->si18_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si18_instit"]) || $this->si18_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010246,2011536,'".AddSlashes(pg_result($resaco,$conresaco,'si18_instit'))."','$this->si18_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "consor212014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si18_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "consor212014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si18_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si18_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si18_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si18_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009630,'$si18_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010246,2009630,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009631,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009632,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009633,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009634,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009635,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009636,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_subelemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009637,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_vlempenhado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009638,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_vlanulacaoempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009639,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_vlliquidado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009640,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_vlanulacaoliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009641,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_vlpago'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009642,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_vlanulacaopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2009738,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2011323,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010246,2011536,'','".AddSlashes(pg_result($resaco,$iresaco,'si18_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from consor212014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si18_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si18_sequencial = $si18_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "consor212014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si18_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "consor212014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si18_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si18_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:consor212014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si18_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consor212014 ";
     $sql .= "      left  join consor202014  on  consor202014.si17_sequencial = consor212014.si18_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si18_sequencial!=null ){
         $sql2 .= " where consor212014.si18_sequencial = $si18_sequencial "; 
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
   function sql_query_file ( $si18_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consor212014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si18_sequencial!=null ){
         $sql2 .= " where consor212014.si18_sequencial = $si18_sequencial "; 
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
