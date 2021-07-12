<?
//MODULO: sicom
//CLASSE DA ENTIDADE obelac102014
class cl_obelac102014 { 
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
   var $si139_sequencial = 0; 
   var $si139_tiporegistro = 0; 
   var $si139_codreduzido = 0; 
   var $si139_codorgao = null; 
   var $si139_codunidadesub = null; 
   var $si139_nrolancamento = 0; 
   var $si139_dtlancamento_dia = null; 
   var $si139_dtlancamento_mes = null; 
   var $si139_dtlancamento_ano = null; 
   var $si139_dtlancamento = null; 
   var $si139_tipolancamento = 0; 
   var $si139_nroempenho = 0; 
   var $si139_dtempenho_dia = null; 
   var $si139_dtempenho_mes = null; 
   var $si139_dtempenho_ano = null; 
   var $si139_dtempenho = null; 
   var $si139_nroliquidacao = 0; 
   var $si139_dtliquidacao_dia = null; 
   var $si139_dtliquidacao_mes = null; 
   var $si139_dtliquidacao_ano = null; 
   var $si139_dtliquidacao = null; 
   var $si139_esplancamento = null; 
   var $si139_valorlancamento = 0; 
   var $si139_mes = 0; 
   var $si139_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si139_sequencial = int8 = sequencial 
                 si139_tiporegistro = int8 = Tipo do  registro 
                 si139_codreduzido = int8 = Código Identificador do registro 
                 si139_codorgao = varchar(2) = Código do órgão 
                 si139_codunidadesub = varchar(8) = Código da unidade 
                 si139_nrolancamento = int8 = Número do  lançamento 
                 si139_dtlancamento = date = Data do  Lançamento 
                 si139_tipolancamento = int8 = Tipo de  Lançamento 
                 si139_nroempenho = int8 = Número do  empenho 
                 si139_dtempenho = date = Data do empenho 
                 si139_nroliquidacao = int8 = Número da  Liquidação 
                 si139_dtliquidacao = date = Data da  Liquidação do  empenho 
                 si139_esplancamento = varchar(200) = Especificação do  Lançamento 
                 si139_valorlancamento = float8 = Valor do  Lançamento 
                 si139_mes = int8 = Mês 
                 si139_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_obelac102014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("obelac102014"); 
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
       $this->si139_sequencial = ($this->si139_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_sequencial"]:$this->si139_sequencial);
       $this->si139_tiporegistro = ($this->si139_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_tiporegistro"]:$this->si139_tiporegistro);
       $this->si139_codreduzido = ($this->si139_codreduzido == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_codreduzido"]:$this->si139_codreduzido);
       $this->si139_codorgao = ($this->si139_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_codorgao"]:$this->si139_codorgao);
       $this->si139_codunidadesub = ($this->si139_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_codunidadesub"]:$this->si139_codunidadesub);
       $this->si139_nrolancamento = ($this->si139_nrolancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_nrolancamento"]:$this->si139_nrolancamento);
       if($this->si139_dtlancamento == ""){
         $this->si139_dtlancamento_dia = ($this->si139_dtlancamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_dtlancamento_dia"]:$this->si139_dtlancamento_dia);
         $this->si139_dtlancamento_mes = ($this->si139_dtlancamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_dtlancamento_mes"]:$this->si139_dtlancamento_mes);
         $this->si139_dtlancamento_ano = ($this->si139_dtlancamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_dtlancamento_ano"]:$this->si139_dtlancamento_ano);
         if($this->si139_dtlancamento_dia != ""){
            $this->si139_dtlancamento = $this->si139_dtlancamento_ano."-".$this->si139_dtlancamento_mes."-".$this->si139_dtlancamento_dia;
         }
       }
       $this->si139_tipolancamento = ($this->si139_tipolancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_tipolancamento"]:$this->si139_tipolancamento);
       $this->si139_nroempenho = ($this->si139_nroempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_nroempenho"]:$this->si139_nroempenho);
       if($this->si139_dtempenho == ""){
         $this->si139_dtempenho_dia = ($this->si139_dtempenho_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_dtempenho_dia"]:$this->si139_dtempenho_dia);
         $this->si139_dtempenho_mes = ($this->si139_dtempenho_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_dtempenho_mes"]:$this->si139_dtempenho_mes);
         $this->si139_dtempenho_ano = ($this->si139_dtempenho_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_dtempenho_ano"]:$this->si139_dtempenho_ano);
         if($this->si139_dtempenho_dia != ""){
            $this->si139_dtempenho = $this->si139_dtempenho_ano."-".$this->si139_dtempenho_mes."-".$this->si139_dtempenho_dia;
         }
       }
       $this->si139_nroliquidacao = ($this->si139_nroliquidacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_nroliquidacao"]:$this->si139_nroliquidacao);
       if($this->si139_dtliquidacao == ""){
         $this->si139_dtliquidacao_dia = ($this->si139_dtliquidacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_dtliquidacao_dia"]:$this->si139_dtliquidacao_dia);
         $this->si139_dtliquidacao_mes = ($this->si139_dtliquidacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_dtliquidacao_mes"]:$this->si139_dtliquidacao_mes);
         $this->si139_dtliquidacao_ano = ($this->si139_dtliquidacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_dtliquidacao_ano"]:$this->si139_dtliquidacao_ano);
         if($this->si139_dtliquidacao_dia != ""){
            $this->si139_dtliquidacao = $this->si139_dtliquidacao_ano."-".$this->si139_dtliquidacao_mes."-".$this->si139_dtliquidacao_dia;
         }
       }
       $this->si139_esplancamento = ($this->si139_esplancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_esplancamento"]:$this->si139_esplancamento);
       $this->si139_valorlancamento = ($this->si139_valorlancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_valorlancamento"]:$this->si139_valorlancamento);
       $this->si139_mes = ($this->si139_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_mes"]:$this->si139_mes);
       $this->si139_instit = ($this->si139_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_instit"]:$this->si139_instit);
     }else{
       $this->si139_sequencial = ($this->si139_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si139_sequencial"]:$this->si139_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si139_sequencial){ 
      $this->atualizacampos();
     if($this->si139_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si139_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si139_codreduzido == null ){ 
       $this->si139_codreduzido = "0";
     }
     if($this->si139_nrolancamento == null ){ 
       $this->si139_nrolancamento = "0";
     }
     if($this->si139_dtlancamento == null ){ 
       $this->si139_dtlancamento = "null";
     }
     if($this->si139_tipolancamento == null ){ 
       $this->si139_tipolancamento = "0";
     }
     if($this->si139_nroempenho == null ){ 
       $this->si139_nroempenho = "0";
     }
     if($this->si139_dtempenho == null ){ 
       $this->si139_dtempenho = "null";
     }
     if($this->si139_nroliquidacao == null ){ 
       $this->si139_nroliquidacao = "0";
     }
     if($this->si139_dtliquidacao == null ){ 
       $this->si139_dtliquidacao = "null";
     }
     if($this->si139_valorlancamento == null ){ 
       $this->si139_valorlancamento = "0";
     }
     if($this->si139_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si139_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si139_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si139_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si139_sequencial == "" || $si139_sequencial == null ){
       $result = db_query("select nextval('obelac102014_si139_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: obelac102014_si139_sequencial_seq do campo: si139_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si139_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from obelac102014_si139_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si139_sequencial)){
         $this->erro_sql = " Campo si139_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si139_sequencial = $si139_sequencial; 
       }
     }
     if(($this->si139_sequencial == null) || ($this->si139_sequencial == "") ){ 
       $this->erro_sql = " Campo si139_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into obelac102014(
                                       si139_sequencial 
                                      ,si139_tiporegistro 
                                      ,si139_codreduzido 
                                      ,si139_codorgao 
                                      ,si139_codunidadesub 
                                      ,si139_nrolancamento 
                                      ,si139_dtlancamento 
                                      ,si139_tipolancamento 
                                      ,si139_nroempenho 
                                      ,si139_dtempenho 
                                      ,si139_nroliquidacao 
                                      ,si139_dtliquidacao 
                                      ,si139_esplancamento 
                                      ,si139_valorlancamento 
                                      ,si139_mes 
                                      ,si139_instit 
                       )
                values (
                                $this->si139_sequencial 
                               ,$this->si139_tiporegistro 
                               ,$this->si139_codreduzido 
                               ,'$this->si139_codorgao' 
                               ,'$this->si139_codunidadesub' 
                               ,$this->si139_nrolancamento 
                               ,".($this->si139_dtlancamento == "null" || $this->si139_dtlancamento == ""?"null":"'".$this->si139_dtlancamento."'")." 
                               ,$this->si139_tipolancamento 
                               ,$this->si139_nroempenho 
                               ,".($this->si139_dtempenho == "null" || $this->si139_dtempenho == ""?"null":"'".$this->si139_dtempenho."'")." 
                               ,$this->si139_nroliquidacao 
                               ,".($this->si139_dtliquidacao == "null" || $this->si139_dtliquidacao == ""?"null":"'".$this->si139_dtliquidacao."'")." 
                               ,'$this->si139_esplancamento' 
                               ,$this->si139_valorlancamento 
                               ,$this->si139_mes 
                               ,$this->si139_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "obelac102014 ($this->si139_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "obelac102014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "obelac102014 ($this->si139_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si139_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si139_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011008,'$this->si139_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010368,2011008,'','".AddSlashes(pg_result($resaco,0,'si139_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011009,'','".AddSlashes(pg_result($resaco,0,'si139_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011010,'','".AddSlashes(pg_result($resaco,0,'si139_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011011,'','".AddSlashes(pg_result($resaco,0,'si139_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011012,'','".AddSlashes(pg_result($resaco,0,'si139_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011013,'','".AddSlashes(pg_result($resaco,0,'si139_nrolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011014,'','".AddSlashes(pg_result($resaco,0,'si139_dtlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011015,'','".AddSlashes(pg_result($resaco,0,'si139_tipolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011016,'','".AddSlashes(pg_result($resaco,0,'si139_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011017,'','".AddSlashes(pg_result($resaco,0,'si139_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011018,'','".AddSlashes(pg_result($resaco,0,'si139_nroliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011019,'','".AddSlashes(pg_result($resaco,0,'si139_dtliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011020,'','".AddSlashes(pg_result($resaco,0,'si139_esplancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011021,'','".AddSlashes(pg_result($resaco,0,'si139_valorlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011022,'','".AddSlashes(pg_result($resaco,0,'si139_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010368,2011652,'','".AddSlashes(pg_result($resaco,0,'si139_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si139_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update obelac102014 set ";
     $virgula = "";
     if(trim($this->si139_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_sequencial"])){ 
        if(trim($this->si139_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si139_sequencial"])){ 
           $this->si139_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si139_sequencial = $this->si139_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si139_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_tiporegistro"])){ 
       $sql  .= $virgula." si139_tiporegistro = $this->si139_tiporegistro ";
       $virgula = ",";
       if(trim($this->si139_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si139_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si139_codreduzido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_codreduzido"])){ 
        if(trim($this->si139_codreduzido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si139_codreduzido"])){ 
           $this->si139_codreduzido = "0" ; 
        } 
       $sql  .= $virgula." si139_codreduzido = $this->si139_codreduzido ";
       $virgula = ",";
     }
     if(trim($this->si139_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_codorgao"])){ 
       $sql  .= $virgula." si139_codorgao = '$this->si139_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si139_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_codunidadesub"])){ 
       $sql  .= $virgula." si139_codunidadesub = '$this->si139_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si139_nrolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_nrolancamento"])){ 
        if(trim($this->si139_nrolancamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si139_nrolancamento"])){ 
           $this->si139_nrolancamento = "0" ; 
        } 
       $sql  .= $virgula." si139_nrolancamento = $this->si139_nrolancamento ";
       $virgula = ",";
     }
     if(trim($this->si139_dtlancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si139_dtlancamento_dia"] !="") ){ 
       $sql  .= $virgula." si139_dtlancamento = '$this->si139_dtlancamento' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si139_dtlancamento_dia"])){ 
         $sql  .= $virgula." si139_dtlancamento = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si139_tipolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_tipolancamento"])){ 
        if(trim($this->si139_tipolancamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si139_tipolancamento"])){ 
           $this->si139_tipolancamento = "0" ; 
        } 
       $sql  .= $virgula." si139_tipolancamento = $this->si139_tipolancamento ";
       $virgula = ",";
     }
     if(trim($this->si139_nroempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_nroempenho"])){ 
        if(trim($this->si139_nroempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si139_nroempenho"])){ 
           $this->si139_nroempenho = "0" ; 
        } 
       $sql  .= $virgula." si139_nroempenho = $this->si139_nroempenho ";
       $virgula = ",";
     }
     if(trim($this->si139_dtempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_dtempenho_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si139_dtempenho_dia"] !="") ){ 
       $sql  .= $virgula." si139_dtempenho = '$this->si139_dtempenho' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si139_dtempenho_dia"])){ 
         $sql  .= $virgula." si139_dtempenho = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si139_nroliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_nroliquidacao"])){ 
        if(trim($this->si139_nroliquidacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si139_nroliquidacao"])){ 
           $this->si139_nroliquidacao = "0" ; 
        } 
       $sql  .= $virgula." si139_nroliquidacao = $this->si139_nroliquidacao ";
       $virgula = ",";
     }
     if(trim($this->si139_dtliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_dtliquidacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si139_dtliquidacao_dia"] !="") ){ 
       $sql  .= $virgula." si139_dtliquidacao = '$this->si139_dtliquidacao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si139_dtliquidacao_dia"])){ 
         $sql  .= $virgula." si139_dtliquidacao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si139_esplancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_esplancamento"])){ 
       $sql  .= $virgula." si139_esplancamento = '$this->si139_esplancamento' ";
       $virgula = ",";
     }
     if(trim($this->si139_valorlancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_valorlancamento"])){ 
        if(trim($this->si139_valorlancamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si139_valorlancamento"])){ 
           $this->si139_valorlancamento = "0" ; 
        } 
       $sql  .= $virgula." si139_valorlancamento = $this->si139_valorlancamento ";
       $virgula = ",";
     }
     if(trim($this->si139_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_mes"])){ 
       $sql  .= $virgula." si139_mes = $this->si139_mes ";
       $virgula = ",";
       if(trim($this->si139_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si139_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si139_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si139_instit"])){ 
       $sql  .= $virgula." si139_instit = $this->si139_instit ";
       $virgula = ",";
       if(trim($this->si139_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si139_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si139_sequencial!=null){
       $sql .= " si139_sequencial = $this->si139_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si139_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011008,'$this->si139_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_sequencial"]) || $this->si139_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011008,'".AddSlashes(pg_result($resaco,$conresaco,'si139_sequencial'))."','$this->si139_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_tiporegistro"]) || $this->si139_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011009,'".AddSlashes(pg_result($resaco,$conresaco,'si139_tiporegistro'))."','$this->si139_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_codreduzido"]) || $this->si139_codreduzido != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011010,'".AddSlashes(pg_result($resaco,$conresaco,'si139_codreduzido'))."','$this->si139_codreduzido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_codorgao"]) || $this->si139_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011011,'".AddSlashes(pg_result($resaco,$conresaco,'si139_codorgao'))."','$this->si139_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_codunidadesub"]) || $this->si139_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011012,'".AddSlashes(pg_result($resaco,$conresaco,'si139_codunidadesub'))."','$this->si139_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_nrolancamento"]) || $this->si139_nrolancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011013,'".AddSlashes(pg_result($resaco,$conresaco,'si139_nrolancamento'))."','$this->si139_nrolancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_dtlancamento"]) || $this->si139_dtlancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011014,'".AddSlashes(pg_result($resaco,$conresaco,'si139_dtlancamento'))."','$this->si139_dtlancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_tipolancamento"]) || $this->si139_tipolancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011015,'".AddSlashes(pg_result($resaco,$conresaco,'si139_tipolancamento'))."','$this->si139_tipolancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_nroempenho"]) || $this->si139_nroempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011016,'".AddSlashes(pg_result($resaco,$conresaco,'si139_nroempenho'))."','$this->si139_nroempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_dtempenho"]) || $this->si139_dtempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011017,'".AddSlashes(pg_result($resaco,$conresaco,'si139_dtempenho'))."','$this->si139_dtempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_nroliquidacao"]) || $this->si139_nroliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011018,'".AddSlashes(pg_result($resaco,$conresaco,'si139_nroliquidacao'))."','$this->si139_nroliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_dtliquidacao"]) || $this->si139_dtliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011019,'".AddSlashes(pg_result($resaco,$conresaco,'si139_dtliquidacao'))."','$this->si139_dtliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_esplancamento"]) || $this->si139_esplancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011020,'".AddSlashes(pg_result($resaco,$conresaco,'si139_esplancamento'))."','$this->si139_esplancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_valorlancamento"]) || $this->si139_valorlancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011021,'".AddSlashes(pg_result($resaco,$conresaco,'si139_valorlancamento'))."','$this->si139_valorlancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_mes"]) || $this->si139_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011022,'".AddSlashes(pg_result($resaco,$conresaco,'si139_mes'))."','$this->si139_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si139_instit"]) || $this->si139_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010368,2011652,'".AddSlashes(pg_result($resaco,$conresaco,'si139_instit'))."','$this->si139_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "obelac102014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si139_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "obelac102014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si139_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si139_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si139_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si139_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011008,'$si139_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010368,2011008,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011009,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011010,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011011,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011012,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011013,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_nrolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011014,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_dtlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011015,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_tipolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011016,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011017,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011018,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_nroliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011019,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_dtliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011020,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_esplancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011021,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_valorlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011022,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010368,2011652,'','".AddSlashes(pg_result($resaco,$iresaco,'si139_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from obelac102014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si139_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si139_sequencial = $si139_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "obelac102014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si139_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "obelac102014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si139_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si139_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:obelac102014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si139_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from obelac102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si139_sequencial!=null ){
         $sql2 .= " where obelac102014.si139_sequencial = $si139_sequencial "; 
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
   function sql_query_file ( $si139_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from obelac102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si139_sequencial!=null ){
         $sql2 .= " where obelac102014.si139_sequencial = $si139_sequencial "; 
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
