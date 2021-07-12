<?
//MODULO: sicom
//CLASSE DA ENTIDADE cvc202016
class cl_cvc202016 { 
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
   var $si147_sequencial = 0; 
   var $si147_tiporegistro = 0; 
   var $si147_codorgao = null; 
   var $si147_codunidadesub = null; 
   var $si147_codveiculo = null; 
   var $si147_origemgasto = 0; 
   var $si147_codunidadesubempenho = null; 
   var $si147_nroempenho = 0; 
   var $si147_dtempenho_dia = null; 
   var $si147_dtempenho_mes = null; 
   var $si147_dtempenho_ano = null; 
   var $si147_dtempenho = null; 
   var $si147_marcacaoinicial = 0; 
   var $si147_marcacaofinal = 0; 
   var $si147_tipogasto = null; 
   var $si147_qtdeutilizada = 0; 
   var $si147_vlgasto = 0; 
   var $si147_dscpecasservicos = null; 
   var $si147_atestadocontrole = null; 
   var $si147_mes = 0; 
   var $si147_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si147_sequencial = int8 = sequencial 
                 si147_tiporegistro = int8 = Tipo do  registro 
                 si147_codorgao = varchar(2) = Código do órgão 
                 si147_codunidadesub = varchar(8) = Código da unidade 
                 si147_codveiculo = varchar(10) = Código do veículo 
                 si147_origemgasto = int8 = Origem do Gasto 
                 si147_codunidadesubempenho = varchar(8) = Código da  unidade empenho 
                 si147_nroempenho = int8 = Número do  empenho 
                 si147_dtempenho = date = Data do  empenho 
                 si147_marcacaoinicial = int8 = Horímetro inicial  do veículo 
                 si147_marcacaofinal = int8 = Horímetro final do  veículo 
                 si147_tipogasto = varchar(2) = Tipo do gasto 
                 si147_qtdeutilizada = float8 = Quantidade  utilizada no  período 
                 si147_vlgasto = float8 = Valor gasto 
                 si147_dscpecasservicos = varchar(50) = Descrição da  peça ou serviço 
                 si147_atestadocontrole = varchar(1) = Atestado pelo  controle interno 
                 si147_mes = int8 = Mês 
                 si147_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_cvc202016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("cvc202016"); 
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
       $this->si147_sequencial = ($this->si147_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_sequencial"]:$this->si147_sequencial);
       $this->si147_tiporegistro = ($this->si147_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_tiporegistro"]:$this->si147_tiporegistro);
       $this->si147_codorgao = ($this->si147_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_codorgao"]:$this->si147_codorgao);
       $this->si147_codunidadesub = ($this->si147_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_codunidadesub"]:$this->si147_codunidadesub);
       $this->si147_codveiculo = ($this->si147_codveiculo == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_codveiculo"]:$this->si147_codveiculo);
       $this->si147_origemgasto = ($this->si147_origemgasto == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_origemgasto"]:$this->si147_origemgasto);
       $this->si147_codunidadesubempenho = ($this->si147_codunidadesubempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_codunidadesubempenho"]:$this->si147_codunidadesubempenho);
       $this->si147_nroempenho = ($this->si147_nroempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_nroempenho"]:$this->si147_nroempenho);
       if($this->si147_dtempenho == ""){
         $this->si147_dtempenho_dia = ($this->si147_dtempenho_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_dtempenho_dia"]:$this->si147_dtempenho_dia);
         $this->si147_dtempenho_mes = ($this->si147_dtempenho_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_dtempenho_mes"]:$this->si147_dtempenho_mes);
         $this->si147_dtempenho_ano = ($this->si147_dtempenho_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_dtempenho_ano"]:$this->si147_dtempenho_ano);
         if($this->si147_dtempenho_dia != ""){
            $this->si147_dtempenho = $this->si147_dtempenho_ano."-".$this->si147_dtempenho_mes."-".$this->si147_dtempenho_dia;
         }
       }
       $this->si147_marcacaoinicial = ($this->si147_marcacaoinicial == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_marcacaoinicial"]:$this->si147_marcacaoinicial);
       $this->si147_marcacaofinal = ($this->si147_marcacaofinal == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_marcacaofinal"]:$this->si147_marcacaofinal);
       $this->si147_tipogasto = ($this->si147_tipogasto == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_tipogasto"]:$this->si147_tipogasto);
       $this->si147_qtdeutilizada = ($this->si147_qtdeutilizada == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_qtdeutilizada"]:$this->si147_qtdeutilizada);
       $this->si147_vlgasto = ($this->si147_vlgasto == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_vlgasto"]:$this->si147_vlgasto);
       $this->si147_dscpecasservicos = ($this->si147_dscpecasservicos == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_dscpecasservicos"]:$this->si147_dscpecasservicos);
       $this->si147_atestadocontrole = ($this->si147_atestadocontrole == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_atestadocontrole"]:$this->si147_atestadocontrole);
       $this->si147_mes = ($this->si147_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_mes"]:$this->si147_mes);
       $this->si147_instit = ($this->si147_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_instit"]:$this->si147_instit);
     }else{
       $this->si147_sequencial = ($this->si147_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si147_sequencial"]:$this->si147_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si147_sequencial){ 
      $this->atualizacampos();
     if($this->si147_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si147_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si147_origemgasto == null ){ 
       $this->si147_origemgasto = "0";
     }
     if($this->si147_nroempenho == null ){ 
       $this->si147_nroempenho = "0";
     }
     if($this->si147_dtempenho == null ){ 
       $this->si147_dtempenho = "null";
     }
     if($this->si147_marcacaoinicial == null ){ 
       $this->si147_marcacaoinicial = "0";
     }
     if($this->si147_marcacaofinal == null ){ 
       $this->si147_marcacaofinal = "0";
     }
     if($this->si147_qtdeutilizada == null ){ 
       $this->si147_qtdeutilizada = "0";
     }
     if($this->si147_vlgasto == null ){ 
       $this->si147_vlgasto = "0";
     }
     if($this->si147_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si147_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si147_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si147_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si147_sequencial == "" || $si147_sequencial == null ){
       $result = db_query("select nextval('cvc202016_si147_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: cvc202016_si147_sequencial_seq do campo: si147_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si147_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from cvc202016_si147_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si147_sequencial)){
         $this->erro_sql = " Campo si147_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si147_sequencial = $si147_sequencial; 
       }
     }
     if(($this->si147_sequencial == null) || ($this->si147_sequencial == "") ){ 
       $this->erro_sql = " Campo si147_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into cvc202016(
                                       si147_sequencial 
                                      ,si147_tiporegistro 
                                      ,si147_codorgao 
                                      ,si147_codunidadesub 
                                      ,si147_codveiculo 
                                      ,si147_origemgasto 
                                      ,si147_codunidadesubempenho 
                                      ,si147_nroempenho 
                                      ,si147_dtempenho 
                                      ,si147_marcacaoinicial 
                                      ,si147_marcacaofinal 
                                      ,si147_tipogasto 
                                      ,si147_qtdeutilizada 
                                      ,si147_vlgasto 
                                      ,si147_dscpecasservicos 
                                      ,si147_atestadocontrole 
                                      ,si147_mes 
                                      ,si147_instit 
                       )
                values (
                                $this->si147_sequencial 
                               ,$this->si147_tiporegistro 
                               ,'$this->si147_codorgao' 
                               ,'$this->si147_codunidadesub' 
                               ,'$this->si147_codveiculo' 
                               ,$this->si147_origemgasto 
                               ,'$this->si147_codunidadesubempenho' 
                               ,$this->si147_nroempenho 
                               ,".($this->si147_dtempenho == "null" || $this->si147_dtempenho == ""?"null":"'".$this->si147_dtempenho."'")." 
                               ,$this->si147_marcacaoinicial 
                               ,$this->si147_marcacaofinal 
                               ,'$this->si147_tipogasto' 
                               ,$this->si147_qtdeutilizada 
                               ,$this->si147_vlgasto 
                               ,'$this->si147_dscpecasservicos' 
                               ,'$this->si147_atestadocontrole' 
                               ,$this->si147_mes 
                               ,$this->si147_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "cvc202016 ($this->si147_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "cvc202016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "cvc202016 ($this->si147_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si147_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si147_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011107,'$this->si147_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010376,2011107,'','".AddSlashes(pg_result($resaco,0,'si147_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011108,'','".AddSlashes(pg_result($resaco,0,'si147_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011109,'','".AddSlashes(pg_result($resaco,0,'si147_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011110,'','".AddSlashes(pg_result($resaco,0,'si147_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011111,'','".AddSlashes(pg_result($resaco,0,'si147_codveiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011112,'','".AddSlashes(pg_result($resaco,0,'si147_origemgasto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011113,'','".AddSlashes(pg_result($resaco,0,'si147_codunidadesubempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011114,'','".AddSlashes(pg_result($resaco,0,'si147_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011115,'','".AddSlashes(pg_result($resaco,0,'si147_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011116,'','".AddSlashes(pg_result($resaco,0,'si147_marcacaoinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011117,'','".AddSlashes(pg_result($resaco,0,'si147_marcacaofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011118,'','".AddSlashes(pg_result($resaco,0,'si147_tipogasto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011119,'','".AddSlashes(pg_result($resaco,0,'si147_qtdeutilizada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011120,'','".AddSlashes(pg_result($resaco,0,'si147_vlgasto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011121,'','".AddSlashes(pg_result($resaco,0,'si147_dscpecasservicos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011122,'','".AddSlashes(pg_result($resaco,0,'si147_atestadocontrole'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011123,'','".AddSlashes(pg_result($resaco,0,'si147_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010376,2011660,'','".AddSlashes(pg_result($resaco,0,'si147_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si147_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update cvc202016 set ";
     $virgula = "";
     if(trim($this->si147_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_sequencial"])){ 
        if(trim($this->si147_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si147_sequencial"])){ 
           $this->si147_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si147_sequencial = $this->si147_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si147_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_tiporegistro"])){ 
       $sql  .= $virgula." si147_tiporegistro = $this->si147_tiporegistro ";
       $virgula = ",";
       if(trim($this->si147_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si147_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si147_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_codorgao"])){ 
       $sql  .= $virgula." si147_codorgao = '$this->si147_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si147_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_codunidadesub"])){ 
       $sql  .= $virgula." si147_codunidadesub = '$this->si147_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si147_codveiculo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_codveiculo"])){ 
       $sql  .= $virgula." si147_codveiculo = '$this->si147_codveiculo' ";
       $virgula = ",";
     }
     if(trim($this->si147_origemgasto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_origemgasto"])){ 
        if(trim($this->si147_origemgasto)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si147_origemgasto"])){ 
           $this->si147_origemgasto = "0" ; 
        } 
       $sql  .= $virgula." si147_origemgasto = $this->si147_origemgasto ";
       $virgula = ",";
     }
     if(trim($this->si147_codunidadesubempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_codunidadesubempenho"])){ 
       $sql  .= $virgula." si147_codunidadesubempenho = '$this->si147_codunidadesubempenho' ";
       $virgula = ",";
     }
     if(trim($this->si147_nroempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_nroempenho"])){ 
        if(trim($this->si147_nroempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si147_nroempenho"])){ 
           $this->si147_nroempenho = "0" ; 
        } 
       $sql  .= $virgula." si147_nroempenho = $this->si147_nroempenho ";
       $virgula = ",";
     }
     if(trim($this->si147_dtempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_dtempenho_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si147_dtempenho_dia"] !="") ){ 
       $sql  .= $virgula." si147_dtempenho = '$this->si147_dtempenho' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si147_dtempenho_dia"])){ 
         $sql  .= $virgula." si147_dtempenho = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si147_marcacaoinicial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_marcacaoinicial"])){ 
        if(trim($this->si147_marcacaoinicial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si147_marcacaoinicial"])){ 
           $this->si147_marcacaoinicial = "0" ; 
        } 
       $sql  .= $virgula." si147_marcacaoinicial = $this->si147_marcacaoinicial ";
       $virgula = ",";
     }
     if(trim($this->si147_marcacaofinal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_marcacaofinal"])){ 
        if(trim($this->si147_marcacaofinal)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si147_marcacaofinal"])){ 
           $this->si147_marcacaofinal = "0" ; 
        } 
       $sql  .= $virgula." si147_marcacaofinal = $this->si147_marcacaofinal ";
       $virgula = ",";
     }
     if(trim($this->si147_tipogasto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_tipogasto"])){ 
       $sql  .= $virgula." si147_tipogasto = '$this->si147_tipogasto' ";
       $virgula = ",";
     }
     if(trim($this->si147_qtdeutilizada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_qtdeutilizada"])){ 
        if(trim($this->si147_qtdeutilizada)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si147_qtdeutilizada"])){ 
           $this->si147_qtdeutilizada = "0" ; 
        } 
       $sql  .= $virgula." si147_qtdeutilizada = $this->si147_qtdeutilizada ";
       $virgula = ",";
     }
     if(trim($this->si147_vlgasto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_vlgasto"])){ 
        if(trim($this->si147_vlgasto)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si147_vlgasto"])){ 
           $this->si147_vlgasto = "0" ; 
        } 
       $sql  .= $virgula." si147_vlgasto = $this->si147_vlgasto ";
       $virgula = ",";
     }
     if(trim($this->si147_dscpecasservicos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_dscpecasservicos"])){ 
       $sql  .= $virgula." si147_dscpecasservicos = '$this->si147_dscpecasservicos' ";
       $virgula = ",";
     }
     if(trim($this->si147_atestadocontrole)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_atestadocontrole"])){ 
       $sql  .= $virgula." si147_atestadocontrole = '$this->si147_atestadocontrole' ";
       $virgula = ",";
     }
     if(trim($this->si147_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_mes"])){ 
       $sql  .= $virgula." si147_mes = $this->si147_mes ";
       $virgula = ",";
       if(trim($this->si147_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si147_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si147_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si147_instit"])){ 
       $sql  .= $virgula." si147_instit = $this->si147_instit ";
       $virgula = ",";
       if(trim($this->si147_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si147_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si147_sequencial!=null){
       $sql .= " si147_sequencial = $this->si147_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si147_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011107,'$this->si147_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_sequencial"]) || $this->si147_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011107,'".AddSlashes(pg_result($resaco,$conresaco,'si147_sequencial'))."','$this->si147_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_tiporegistro"]) || $this->si147_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011108,'".AddSlashes(pg_result($resaco,$conresaco,'si147_tiporegistro'))."','$this->si147_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_codorgao"]) || $this->si147_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011109,'".AddSlashes(pg_result($resaco,$conresaco,'si147_codorgao'))."','$this->si147_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_codunidadesub"]) || $this->si147_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011110,'".AddSlashes(pg_result($resaco,$conresaco,'si147_codunidadesub'))."','$this->si147_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_codveiculo"]) || $this->si147_codveiculo != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011111,'".AddSlashes(pg_result($resaco,$conresaco,'si147_codveiculo'))."','$this->si147_codveiculo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_origemgasto"]) || $this->si147_origemgasto != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011112,'".AddSlashes(pg_result($resaco,$conresaco,'si147_origemgasto'))."','$this->si147_origemgasto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_codunidadesubempenho"]) || $this->si147_codunidadesubempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011113,'".AddSlashes(pg_result($resaco,$conresaco,'si147_codunidadesubempenho'))."','$this->si147_codunidadesubempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_nroempenho"]) || $this->si147_nroempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011114,'".AddSlashes(pg_result($resaco,$conresaco,'si147_nroempenho'))."','$this->si147_nroempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_dtempenho"]) || $this->si147_dtempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011115,'".AddSlashes(pg_result($resaco,$conresaco,'si147_dtempenho'))."','$this->si147_dtempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_marcacaoinicial"]) || $this->si147_marcacaoinicial != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011116,'".AddSlashes(pg_result($resaco,$conresaco,'si147_marcacaoinicial'))."','$this->si147_marcacaoinicial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_marcacaofinal"]) || $this->si147_marcacaofinal != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011117,'".AddSlashes(pg_result($resaco,$conresaco,'si147_marcacaofinal'))."','$this->si147_marcacaofinal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_tipogasto"]) || $this->si147_tipogasto != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011118,'".AddSlashes(pg_result($resaco,$conresaco,'si147_tipogasto'))."','$this->si147_tipogasto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_qtdeutilizada"]) || $this->si147_qtdeutilizada != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011119,'".AddSlashes(pg_result($resaco,$conresaco,'si147_qtdeutilizada'))."','$this->si147_qtdeutilizada',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_vlgasto"]) || $this->si147_vlgasto != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011120,'".AddSlashes(pg_result($resaco,$conresaco,'si147_vlgasto'))."','$this->si147_vlgasto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_dscpecasservicos"]) || $this->si147_dscpecasservicos != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011121,'".AddSlashes(pg_result($resaco,$conresaco,'si147_dscpecasservicos'))."','$this->si147_dscpecasservicos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_atestadocontrole"]) || $this->si147_atestadocontrole != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011122,'".AddSlashes(pg_result($resaco,$conresaco,'si147_atestadocontrole'))."','$this->si147_atestadocontrole',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_mes"]) || $this->si147_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011123,'".AddSlashes(pg_result($resaco,$conresaco,'si147_mes'))."','$this->si147_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si147_instit"]) || $this->si147_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010376,2011660,'".AddSlashes(pg_result($resaco,$conresaco,'si147_instit'))."','$this->si147_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "cvc202016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si147_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "cvc202016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si147_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si147_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si147_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si147_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011107,'$si147_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010376,2011107,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011108,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011109,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011110,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011111,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_codveiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011112,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_origemgasto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011113,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_codunidadesubempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011114,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011115,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011116,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_marcacaoinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011117,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_marcacaofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011118,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_tipogasto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011119,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_qtdeutilizada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011120,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_vlgasto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011121,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_dscpecasservicos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011122,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_atestadocontrole'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011123,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010376,2011660,'','".AddSlashes(pg_result($resaco,$iresaco,'si147_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from cvc202016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si147_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si147_sequencial = $si147_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "cvc202016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si147_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "cvc202016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si147_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si147_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:cvc202016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si147_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from cvc202016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si147_sequencial!=null ){
         $sql2 .= " where cvc202016.si147_sequencial = $si147_sequencial "; 
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
   function sql_query_file ( $si147_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from cvc202016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si147_sequencial!=null ){
         $sql2 .= " where cvc202016.si147_sequencial = $si147_sequencial "; 
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
