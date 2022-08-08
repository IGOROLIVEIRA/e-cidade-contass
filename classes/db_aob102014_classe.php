<?
//MODULO: sicom
//CLASSE DA ENTIDADE aob102014
class cl_aob102014 { 
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
   var $si141_sequencial = 0; 
   var $si141_tiporegistro = 0; 
   var $si141_codreduzido = 0; 
   var $si141_codorgao = null; 
   var $si141_codunidadesub = null; 
   var $si141_nrolancamento = 0; 
   var $si141_dtlancamento_dia = null; 
   var $si141_dtlancamento_mes = null; 
   var $si141_dtlancamento_ano = null; 
   var $si141_dtlancamento = null; 
   var $si141_nroanulacaolancamento = 0; 
   var $si141_dtanulacaolancamento_dia = null; 
   var $si141_dtanulacaolancamento_mes = null; 
   var $si141_dtanulacaolancamento_ano = null; 
   var $si141_dtanulacaolancamento = null; 
   var $si141_nroempenho = 0; 
   var $si141_dtempenho_dia = null; 
   var $si141_dtempenho_mes = null; 
   var $si141_dtempenho_ano = null; 
   var $si141_dtempenho = null; 
   var $si141_nroliquidacao = 0; 
   var $si141_dtliquidacao_dia = null; 
   var $si141_dtliquidacao_mes = null; 
   var $si141_dtliquidacao_ano = null; 
   var $si141_dtliquidacao = null; 
   var $si141_valoranulacaolancamento = 0; 
   var $si141_mes = 0; 
   var $si141_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si141_sequencial = int8 = sequencial 
                 si141_tiporegistro = int8 = Tipo do  registro 
                 si141_codreduzido = int8 = Código Identificador do registro 
                 si141_codorgao = varchar(2) = Código do órgão 
                 si141_codunidadesub = varchar(8) = Código da  unidade 
                 si141_nrolancamento = int8 = Número do  lançamento 
                 si141_dtlancamento = date = Data do lançamento 
                 si141_nroanulacaolancamento = int8 = Número da anulação  do lançamento 
                 si141_dtanulacaolancamento = date = Data da anulação do  lançamento 
                 si141_nroempenho = int8 = Número do empenho 
                 si141_dtempenho = date = Data do empenho 
                 si141_nroliquidacao = int8 = Número da liquidação 
                 si141_dtliquidacao = date = Data da liquidação do empenho 
                 si141_valoranulacaolancamento = float8 = Valor da anulação do  lançamento 
                 si141_mes = int8 = Mês 
                 si141_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_aob102014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aob102014"); 
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
       $this->si141_sequencial = ($this->si141_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_sequencial"]:$this->si141_sequencial);
       $this->si141_tiporegistro = ($this->si141_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_tiporegistro"]:$this->si141_tiporegistro);
       $this->si141_codreduzido = ($this->si141_codreduzido == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_codreduzido"]:$this->si141_codreduzido);
       $this->si141_codorgao = ($this->si141_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_codorgao"]:$this->si141_codorgao);
       $this->si141_codunidadesub = ($this->si141_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_codunidadesub"]:$this->si141_codunidadesub);
       $this->si141_nrolancamento = ($this->si141_nrolancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_nrolancamento"]:$this->si141_nrolancamento);
       if($this->si141_dtlancamento == ""){
         $this->si141_dtlancamento_dia = ($this->si141_dtlancamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtlancamento_dia"]:$this->si141_dtlancamento_dia);
         $this->si141_dtlancamento_mes = ($this->si141_dtlancamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtlancamento_mes"]:$this->si141_dtlancamento_mes);
         $this->si141_dtlancamento_ano = ($this->si141_dtlancamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtlancamento_ano"]:$this->si141_dtlancamento_ano);
         if($this->si141_dtlancamento_dia != ""){
            $this->si141_dtlancamento = $this->si141_dtlancamento_ano."-".$this->si141_dtlancamento_mes."-".$this->si141_dtlancamento_dia;
         }
       }
       $this->si141_nroanulacaolancamento = ($this->si141_nroanulacaolancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_nroanulacaolancamento"]:$this->si141_nroanulacaolancamento);
       if($this->si141_dtanulacaolancamento == ""){
         $this->si141_dtanulacaolancamento_dia = ($this->si141_dtanulacaolancamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtanulacaolancamento_dia"]:$this->si141_dtanulacaolancamento_dia);
         $this->si141_dtanulacaolancamento_mes = ($this->si141_dtanulacaolancamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtanulacaolancamento_mes"]:$this->si141_dtanulacaolancamento_mes);
         $this->si141_dtanulacaolancamento_ano = ($this->si141_dtanulacaolancamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtanulacaolancamento_ano"]:$this->si141_dtanulacaolancamento_ano);
         if($this->si141_dtanulacaolancamento_dia != ""){
            $this->si141_dtanulacaolancamento = $this->si141_dtanulacaolancamento_ano."-".$this->si141_dtanulacaolancamento_mes."-".$this->si141_dtanulacaolancamento_dia;
         }
       }
       $this->si141_nroempenho = ($this->si141_nroempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_nroempenho"]:$this->si141_nroempenho);
       if($this->si141_dtempenho == ""){
         $this->si141_dtempenho_dia = ($this->si141_dtempenho_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtempenho_dia"]:$this->si141_dtempenho_dia);
         $this->si141_dtempenho_mes = ($this->si141_dtempenho_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtempenho_mes"]:$this->si141_dtempenho_mes);
         $this->si141_dtempenho_ano = ($this->si141_dtempenho_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtempenho_ano"]:$this->si141_dtempenho_ano);
         if($this->si141_dtempenho_dia != ""){
            $this->si141_dtempenho = $this->si141_dtempenho_ano."-".$this->si141_dtempenho_mes."-".$this->si141_dtempenho_dia;
         }
       }
       $this->si141_nroliquidacao = ($this->si141_nroliquidacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_nroliquidacao"]:$this->si141_nroliquidacao);
       if($this->si141_dtliquidacao == ""){
         $this->si141_dtliquidacao_dia = ($this->si141_dtliquidacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtliquidacao_dia"]:$this->si141_dtliquidacao_dia);
         $this->si141_dtliquidacao_mes = ($this->si141_dtliquidacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtliquidacao_mes"]:$this->si141_dtliquidacao_mes);
         $this->si141_dtliquidacao_ano = ($this->si141_dtliquidacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_dtliquidacao_ano"]:$this->si141_dtliquidacao_ano);
         if($this->si141_dtliquidacao_dia != ""){
            $this->si141_dtliquidacao = $this->si141_dtliquidacao_ano."-".$this->si141_dtliquidacao_mes."-".$this->si141_dtliquidacao_dia;
         }
       }
       $this->si141_valoranulacaolancamento = ($this->si141_valoranulacaolancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_valoranulacaolancamento"]:$this->si141_valoranulacaolancamento);
       $this->si141_mes = ($this->si141_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_mes"]:$this->si141_mes);
       $this->si141_instit = ($this->si141_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_instit"]:$this->si141_instit);
     }else{
       $this->si141_sequencial = ($this->si141_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si141_sequencial"]:$this->si141_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si141_sequencial){ 
      $this->atualizacampos();
     if($this->si141_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si141_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si141_codreduzido == null ){ 
       $this->si141_codreduzido = "0";
     }
     if($this->si141_nrolancamento == null ){ 
       $this->si141_nrolancamento = "0";
     }
     if($this->si141_dtlancamento == null ){ 
       $this->si141_dtlancamento = "null";
     }
     if($this->si141_nroanulacaolancamento == null ){ 
       $this->si141_nroanulacaolancamento = "0";
     }
     if($this->si141_dtanulacaolancamento == null ){ 
       $this->si141_dtanulacaolancamento = "null";
     }
     if($this->si141_nroempenho == null ){ 
       $this->si141_nroempenho = "0";
     }
     if($this->si141_dtempenho == null ){ 
       $this->si141_dtempenho = "null";
     }
     if($this->si141_nroliquidacao == null ){ 
       $this->si141_nroliquidacao = "0";
     }
     if($this->si141_dtliquidacao == null ){ 
       $this->si141_dtliquidacao = "null";
     }
     if($this->si141_valoranulacaolancamento == null ){ 
       $this->si141_valoranulacaolancamento = "0";
     }
     if($this->si141_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si141_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si141_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si141_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si141_sequencial == "" || $si141_sequencial == null ){
       $result = db_query("select nextval('aob102014_si141_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aob102014_si141_sequencial_seq do campo: si141_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si141_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aob102014_si141_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si141_sequencial)){
         $this->erro_sql = " Campo si141_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si141_sequencial = $si141_sequencial; 
       }
     }
     if(($this->si141_sequencial == null) || ($this->si141_sequencial == "") ){ 
       $this->erro_sql = " Campo si141_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into aob102014(
                                       si141_sequencial 
                                      ,si141_tiporegistro 
                                      ,si141_codreduzido 
                                      ,si141_codorgao 
                                      ,si141_codunidadesub 
                                      ,si141_nrolancamento 
                                      ,si141_dtlancamento 
                                      ,si141_nroanulacaolancamento 
                                      ,si141_dtanulacaolancamento 
                                      ,si141_nroempenho 
                                      ,si141_dtempenho 
                                      ,si141_nroliquidacao 
                                      ,si141_dtliquidacao 
                                      ,si141_valoranulacaolancamento 
                                      ,si141_mes 
                                      ,si141_instit 
                       )
                values (
                                $this->si141_sequencial 
                               ,$this->si141_tiporegistro 
                               ,$this->si141_codreduzido 
                               ,'$this->si141_codorgao' 
                               ,'$this->si141_codunidadesub' 
                               ,$this->si141_nrolancamento 
                               ,".($this->si141_dtlancamento == "null" || $this->si141_dtlancamento == ""?"null":"'".$this->si141_dtlancamento."'")." 
                               ,$this->si141_nroanulacaolancamento 
                               ,".($this->si141_dtanulacaolancamento == "null" || $this->si141_dtanulacaolancamento == ""?"null":"'".$this->si141_dtanulacaolancamento."'")." 
                               ,$this->si141_nroempenho 
                               ,".($this->si141_dtempenho == "null" || $this->si141_dtempenho == ""?"null":"'".$this->si141_dtempenho."'")." 
                               ,$this->si141_nroliquidacao 
                               ,".($this->si141_dtliquidacao == "null" || $this->si141_dtliquidacao == ""?"null":"'".$this->si141_dtliquidacao."'")." 
                               ,$this->si141_valoranulacaolancamento 
                               ,$this->si141_mes 
                               ,$this->si141_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "aob102014 ($this->si141_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "aob102014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "aob102014 ($this->si141_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si141_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si141_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011030,'$this->si141_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010370,2011030,'','".AddSlashes(pg_result($resaco,0,'si141_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011031,'','".AddSlashes(pg_result($resaco,0,'si141_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011032,'','".AddSlashes(pg_result($resaco,0,'si141_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011033,'','".AddSlashes(pg_result($resaco,0,'si141_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011034,'','".AddSlashes(pg_result($resaco,0,'si141_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011035,'','".AddSlashes(pg_result($resaco,0,'si141_nrolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011354,'','".AddSlashes(pg_result($resaco,0,'si141_dtlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011036,'','".AddSlashes(pg_result($resaco,0,'si141_nroanulacaolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011037,'','".AddSlashes(pg_result($resaco,0,'si141_dtanulacaolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011356,'','".AddSlashes(pg_result($resaco,0,'si141_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011358,'','".AddSlashes(pg_result($resaco,0,'si141_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011359,'','".AddSlashes(pg_result($resaco,0,'si141_nroliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011360,'','".AddSlashes(pg_result($resaco,0,'si141_dtliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011038,'','".AddSlashes(pg_result($resaco,0,'si141_valoranulacaolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011039,'','".AddSlashes(pg_result($resaco,0,'si141_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010370,2011654,'','".AddSlashes(pg_result($resaco,0,'si141_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si141_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aob102014 set ";
     $virgula = "";
     if(trim($this->si141_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_sequencial"])){ 
        if(trim($this->si141_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si141_sequencial"])){ 
           $this->si141_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si141_sequencial = $this->si141_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si141_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_tiporegistro"])){ 
       $sql  .= $virgula." si141_tiporegistro = $this->si141_tiporegistro ";
       $virgula = ",";
       if(trim($this->si141_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si141_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si141_codreduzido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_codreduzido"])){ 
        if(trim($this->si141_codreduzido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si141_codreduzido"])){ 
           $this->si141_codreduzido = "0" ; 
        } 
       $sql  .= $virgula." si141_codreduzido = $this->si141_codreduzido ";
       $virgula = ",";
     }
     if(trim($this->si141_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_codorgao"])){ 
       $sql  .= $virgula." si141_codorgao = '$this->si141_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si141_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_codunidadesub"])){ 
       $sql  .= $virgula." si141_codunidadesub = '$this->si141_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si141_nrolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_nrolancamento"])){ 
        if(trim($this->si141_nrolancamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si141_nrolancamento"])){ 
           $this->si141_nrolancamento = "0" ; 
        } 
       $sql  .= $virgula." si141_nrolancamento = $this->si141_nrolancamento ";
       $virgula = ",";
     }
     if(trim($this->si141_dtlancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si141_dtlancamento_dia"] !="") ){ 
       $sql  .= $virgula." si141_dtlancamento = '$this->si141_dtlancamento' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si141_dtlancamento_dia"])){ 
         $sql  .= $virgula." si141_dtlancamento = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si141_nroanulacaolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_nroanulacaolancamento"])){ 
        if(trim($this->si141_nroanulacaolancamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si141_nroanulacaolancamento"])){ 
           $this->si141_nroanulacaolancamento = "0" ; 
        } 
       $sql  .= $virgula." si141_nroanulacaolancamento = $this->si141_nroanulacaolancamento ";
       $virgula = ",";
     }
     if(trim($this->si141_dtanulacaolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_dtanulacaolancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si141_dtanulacaolancamento_dia"] !="") ){ 
       $sql  .= $virgula." si141_dtanulacaolancamento = '$this->si141_dtanulacaolancamento' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si141_dtanulacaolancamento_dia"])){ 
         $sql  .= $virgula." si141_dtanulacaolancamento = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si141_nroempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_nroempenho"])){ 
        if(trim($this->si141_nroempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si141_nroempenho"])){ 
           $this->si141_nroempenho = "0" ; 
        } 
       $sql  .= $virgula." si141_nroempenho = $this->si141_nroempenho ";
       $virgula = ",";
     }
     if(trim($this->si141_dtempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_dtempenho_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si141_dtempenho_dia"] !="") ){ 
       $sql  .= $virgula." si141_dtempenho = '$this->si141_dtempenho' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si141_dtempenho_dia"])){ 
         $sql  .= $virgula." si141_dtempenho = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si141_nroliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_nroliquidacao"])){ 
        if(trim($this->si141_nroliquidacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si141_nroliquidacao"])){ 
           $this->si141_nroliquidacao = "0" ; 
        } 
       $sql  .= $virgula." si141_nroliquidacao = $this->si141_nroliquidacao ";
       $virgula = ",";
     }
     if(trim($this->si141_dtliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_dtliquidacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si141_dtliquidacao_dia"] !="") ){ 
       $sql  .= $virgula." si141_dtliquidacao = '$this->si141_dtliquidacao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si141_dtliquidacao_dia"])){ 
         $sql  .= $virgula." si141_dtliquidacao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si141_valoranulacaolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_valoranulacaolancamento"])){ 
        if(trim($this->si141_valoranulacaolancamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si141_valoranulacaolancamento"])){ 
           $this->si141_valoranulacaolancamento = "0" ; 
        } 
       $sql  .= $virgula." si141_valoranulacaolancamento = $this->si141_valoranulacaolancamento ";
       $virgula = ",";
     }
     if(trim($this->si141_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_mes"])){ 
       $sql  .= $virgula." si141_mes = $this->si141_mes ";
       $virgula = ",";
       if(trim($this->si141_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si141_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si141_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si141_instit"])){ 
       $sql  .= $virgula." si141_instit = $this->si141_instit ";
       $virgula = ",";
       if(trim($this->si141_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si141_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si141_sequencial!=null){
       $sql .= " si141_sequencial = $this->si141_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si141_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011030,'$this->si141_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_sequencial"]) || $this->si141_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011030,'".AddSlashes(pg_result($resaco,$conresaco,'si141_sequencial'))."','$this->si141_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_tiporegistro"]) || $this->si141_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011031,'".AddSlashes(pg_result($resaco,$conresaco,'si141_tiporegistro'))."','$this->si141_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_codreduzido"]) || $this->si141_codreduzido != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011032,'".AddSlashes(pg_result($resaco,$conresaco,'si141_codreduzido'))."','$this->si141_codreduzido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_codorgao"]) || $this->si141_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011033,'".AddSlashes(pg_result($resaco,$conresaco,'si141_codorgao'))."','$this->si141_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_codunidadesub"]) || $this->si141_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011034,'".AddSlashes(pg_result($resaco,$conresaco,'si141_codunidadesub'))."','$this->si141_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_nrolancamento"]) || $this->si141_nrolancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011035,'".AddSlashes(pg_result($resaco,$conresaco,'si141_nrolancamento'))."','$this->si141_nrolancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_dtlancamento"]) || $this->si141_dtlancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011354,'".AddSlashes(pg_result($resaco,$conresaco,'si141_dtlancamento'))."','$this->si141_dtlancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_nroanulacaolancamento"]) || $this->si141_nroanulacaolancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011036,'".AddSlashes(pg_result($resaco,$conresaco,'si141_nroanulacaolancamento'))."','$this->si141_nroanulacaolancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_dtanulacaolancamento"]) || $this->si141_dtanulacaolancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011037,'".AddSlashes(pg_result($resaco,$conresaco,'si141_dtanulacaolancamento'))."','$this->si141_dtanulacaolancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_nroempenho"]) || $this->si141_nroempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011356,'".AddSlashes(pg_result($resaco,$conresaco,'si141_nroempenho'))."','$this->si141_nroempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_dtempenho"]) || $this->si141_dtempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011358,'".AddSlashes(pg_result($resaco,$conresaco,'si141_dtempenho'))."','$this->si141_dtempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_nroliquidacao"]) || $this->si141_nroliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011359,'".AddSlashes(pg_result($resaco,$conresaco,'si141_nroliquidacao'))."','$this->si141_nroliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_dtliquidacao"]) || $this->si141_dtliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011360,'".AddSlashes(pg_result($resaco,$conresaco,'si141_dtliquidacao'))."','$this->si141_dtliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_valoranulacaolancamento"]) || $this->si141_valoranulacaolancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011038,'".AddSlashes(pg_result($resaco,$conresaco,'si141_valoranulacaolancamento'))."','$this->si141_valoranulacaolancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_mes"]) || $this->si141_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011039,'".AddSlashes(pg_result($resaco,$conresaco,'si141_mes'))."','$this->si141_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si141_instit"]) || $this->si141_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010370,2011654,'".AddSlashes(pg_result($resaco,$conresaco,'si141_instit'))."','$this->si141_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aob102014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si141_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aob102014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si141_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si141_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si141_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si141_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011030,'$si141_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010370,2011030,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011031,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011032,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011033,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011034,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011035,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_nrolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011354,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_dtlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011036,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_nroanulacaolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011037,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_dtanulacaolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011356,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011358,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011359,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_nroliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011360,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_dtliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011038,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_valoranulacaolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011039,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010370,2011654,'','".AddSlashes(pg_result($resaco,$iresaco,'si141_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from aob102014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si141_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si141_sequencial = $si141_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aob102014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si141_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aob102014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si141_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si141_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:aob102014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si141_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aob102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si141_sequencial!=null ){
         $sql2 .= " where aob102014.si141_sequencial = $si141_sequencial "; 
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
   function sql_query_file ( $si141_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aob102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si141_sequencial!=null ){
         $sql2 .= " where aob102014.si141_sequencial = $si141_sequencial "; 
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
