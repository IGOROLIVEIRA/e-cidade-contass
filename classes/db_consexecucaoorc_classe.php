<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE consexecucaoorc
class cl_consexecucaoorc { 
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
   var $c202_sequencial = 0; 
   var $c202_consconsorcios = 0; 
   var $c202_mescompetencia = 0; 
   var $c202_funcao = 0; 
   var $c202_subfuncao = 0; 
   var $c202_elemento = 0; 
   var $c202_valorempenhado = 0; 
   var $c202_valorempenhadoanu = 0; 
   var $c202_valorliquidado = 0;
   var $c202_valorliquidadoanu = 0;  
   var $c202_valorpago = 0; 
   var $c202_valorpagoanu = 0; 
   var $c202_mesreferenciasicom = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 c202_sequencial = int8 = Código Sequencial 
                 c202_consconsorcios = int8 = Código Consórcio 
                 c202_mescompetencia = int8 = Mês Competência 
                 c202_funcao = int8 = Código da Função 
                 c202_subfuncao = int8 = SubFunção 
                 c202_codfontrecursos = int8 = Código da fonte de recursos
                 c202_elemento = int8 = Elemento 
                 c202_valorempenhado = float8 = Valor Empenhado no Mês 
                 c202_valorempenhadoanu = float8 = Valor Anulado no Mês 
                 c202_valorliquidado = float8 = Valor Liquidado no Mês 
                 c202_valorliquidadoanu = float8 = Valor Liquidado Anulado no Mês
                 c202_valorpago = float8 = Valor Pago no Mês 
                 c202_valorpagoanu = float8 = Valor Pago Anulado no Mês 
                 c202_mesreferenciasicom = int8 = Mês de Referência SICOM
                 ";
   //funcao construtor da classe 
   function cl_consexecucaoorc() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("consexecucaoorc"); 
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
       $this->c202_sequencial = ($this->c202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_sequencial"]:$this->c202_sequencial);
       $this->c202_consconsorcios = ($this->c202_consconsorcios == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_consconsorcios"]:$this->c202_consconsorcios);
       $this->c202_mescompetencia = ($this->c202_mescompetencia == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_mescompetencia"]:$this->c202_mescompetencia);
       $this->c202_funcao = ($this->c202_funcao == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_funcao"]:$this->c202_funcao);
       $this->c202_subfuncao = ($this->c202_subfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_subfuncao"]:$this->c202_subfuncao);
       $this->c202_codfontrecursos = ($this->c202_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_codfontrecursos"]:$this->c202_codfontrecursos);
       $this->c202_elemento = ($this->c202_elemento == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_elemento"]:$this->c202_elemento);
       $this->c202_valorempenhado = ($this->c202_valorempenhado == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_valorempenhado"]:$this->c202_valorempenhado);
       $this->c202_valorempenhadoanu = ($this->c202_valorempenhadoanu == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_valorempenhadoanu"]:$this->c202_valorempenhadoanu);
       $this->c202_valorliquidado = ($this->c202_valorliquidado == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_valorliquidado"]:$this->c202_valorliquidado);
       $this->c202_valorliquidadoanu = ($this->c202_valorliquidadoanu == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_valorliquidadoanu"]:$this->c202_valorliquidadoanu);
       $this->c202_valorpago = ($this->c202_valorpago == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_valorpago"]:$this->c202_valorpago);
       $this->c202_valorpagoanu = ($this->c202_valorpagoanu == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_valorpagoanu"]:$this->c202_valorpagoanu);
       $this->c202_mesreferenciasicom = ($this->c202_mesreferenciasicom == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_mesreferenciasicom"]:$this->c202_mesreferenciasicom);
     }else{
       $this->c202_sequencial = ($this->c202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c202_sequencial"]:$this->c202_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c202_sequencial){ 
      $this->atualizacampos();
     if($this->c202_consconsorcios == null ){ 
       $this->erro_sql = " Campo Código Consórcio nao Informado.";
       $this->erro_campo = "c202_consconsorcios";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_mescompetencia == null ){ 
       $this->erro_sql = " Campo Mês Competência nao Informado.";
       $this->erro_campo = "c202_mescompetencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_mesreferenciasicom == null ){ 
      $this->erro_sql = " Campo Mês de Referência SICOM nao Informado.";
      $this->erro_campo = "c202_mesreferenciasicom";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     if($this->c202_funcao == null ){ 
       $this->erro_sql = " Campo Código da Função nao Informado.";
       $this->erro_campo = "c202_funcao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_subfuncao == null ){ 
       $this->erro_sql = " Campo SubFunção nao Informado.";
       $this->erro_campo = "c202_subfuncao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_codfontrecursos == null ){ 
       $this->erro_sql = " Campo Fonte de recursos nao Informado.";
       $this->erro_campo = "c202_codfontrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     /**
      * adicionado para verificar o tamanho do campo
      */
     if(strlen($this->c202_codfontrecursos) != 3 ){ 
       $this->erro_sql = " Campo Fonte deve conter 3 dígitos.";
       $this->erro_campo = "c202_codfontrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_elemento == null ){ 
       $this->erro_sql = " Campo Elemento nao Informado.";
       $this->erro_campo = "c202_elemento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     /**
      * adicionado para verificar o tamanho do campo
      */
     if(strlen($this->c202_elemento) != 8 ){ 
       $this->erro_sql = " Campo Elemento deve conter 8 dígitos.";
       $this->erro_campo = "c202_elemento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_valorempenhado == null ){ 
       $this->erro_sql = " Campo Valor Empenhado no Mês nao Informado.";
       $this->erro_campo = "c202_valorempenhado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_valorempenhadoanu == null ){ 
       $this->erro_sql = " Campo Valor Anulado no Mês nao Informado.";
       $this->erro_campo = "c202_valorempenhadoanu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_valorliquidado == null ){ 
       $this->erro_sql = " Campo Valor Liquidado no Mês nao Informado.";
       $this->erro_campo = "c202_valorliquidado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
   if($this->c202_valorliquidadoanu == null ){ 
       $this->erro_sql = " Campo Valor Liquidado Anulado no Mês nao Informado.";
       $this->erro_campo = "c202_valorliquidadoanu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_valorpago == null ){ 
       $this->erro_sql = " Campo Valor Pago no Mês nao Informado.";
       $this->erro_campo = "c202_valorpago";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c202_valorpagoanu == null ){ 
       $this->erro_sql = " Campo Valor Pago Anulado no Mês nao Informado.";
       $this->erro_campo = "c202_valorpagoanu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($c202_sequencial == "" || $c202_sequencial == null ){
       $result = db_query("select nextval('consexecucaoorc_c202_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: consexecucaoorc_c202_sequencial_seq do campo: c202_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->c202_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from consexecucaoorc_c202_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c202_sequencial)){
         $this->erro_sql = " Campo c202_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c202_sequencial = $c202_sequencial; 
       }
     }
     if(($this->c202_sequencial == null) || ($this->c202_sequencial == "") ){ 
       $this->erro_sql = " Campo c202_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into consexecucaoorc(
                                       c202_sequencial 
                                      ,c202_consconsorcios 
                                      ,c202_mescompetencia 
                                      ,c202_funcao 
                                      ,c202_subfuncao 
                                      ,c202_codfontrecursos
                                      ,c202_elemento 
                                      ,c202_valorempenhado 
                                      ,c202_valorempenhadoanu 
                                      ,c202_valorliquidado
                                      ,c202_valorliquidadoanu 
                                      ,c202_valorpago 
                                      ,c202_valorpagoanu 
                                      ,c202_anousu
                                      ,c202_mesreferenciasicom
                       )
                values (
                                $this->c202_sequencial 
                               ,$this->c202_consconsorcios 
                               ,$this->c202_mescompetencia 
                               ,$this->c202_funcao 
                               ,$this->c202_subfuncao 
                               ,$this->c202_codfontrecursos
                               ,$this->c202_elemento 
                               ,$this->c202_valorempenhado 
                               ,$this->c202_valorempenhadoanu 
                               ,$this->c202_valorliquidado
                               ,$this->c202_valorliquidadoanu 
                               ,$this->c202_valorpago 
                               ,$this->c202_valorpagoanu
                               ,".db_getsession("DB_anousu")." 
                               ,$this->c202_mesreferenciasicom 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Execução Orçamentária da Despesa ($this->c202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Execução Orçamentária da Despesa já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Execução Orçamentária da Despesa ($this->c202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c202_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->c202_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009417,'$this->c202_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010219,2009417,'','".AddSlashes(pg_result($resaco,0,'c202_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009418,'','".AddSlashes(pg_result($resaco,0,'c202_consconsorcios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009419,'','".AddSlashes(pg_result($resaco,0,'c202_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009420,'','".AddSlashes(pg_result($resaco,0,'c202_funcao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009421,'','".AddSlashes(pg_result($resaco,0,'c202_subfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009422,'','".AddSlashes(pg_result($resaco,0,'c202_elemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009423,'','".AddSlashes(pg_result($resaco,0,'c202_valorempenhado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009424,'','".AddSlashes(pg_result($resaco,0,'c202_valorempenhadoanu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009425,'','".AddSlashes(pg_result($resaco,0,'c202_valorliquidado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009426,'','".AddSlashes(pg_result($resaco,0,'c202_valorpago'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010219,2009427,'','".AddSlashes(pg_result($resaco,0,'c202_valorpagoanu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($c202_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update consexecucaoorc set ";
     $virgula = "";
     if(trim($this->c202_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_sequencial"])){ 
       $sql  .= $virgula." c202_sequencial = $this->c202_sequencial ";
       $virgula = ",";
       if(trim($this->c202_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "c202_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_consconsorcios)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_consconsorcios"])){ 
       $sql  .= $virgula." c202_consconsorcios = $this->c202_consconsorcios ";
       $virgula = ",";
       if(trim($this->c202_consconsorcios) == null ){ 
         $this->erro_sql = " Campo Código Consórcio nao Informado.";
         $this->erro_campo = "c202_consconsorcios";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_mescompetencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_mescompetencia"])){ 
       $sql  .= $virgula." c202_mescompetencia = $this->c202_mescompetencia ";
       $virgula = ",";
       if(trim($this->c202_mescompetencia) == null ){ 
         $this->erro_sql = " Campo Mês Competência nao Informado.";
         $this->erro_campo = "c202_mescompetencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_mesreferenciasicom)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_mesreferenciasicom"])){ 
      $sql  .= $virgula." c202_mesreferenciasicom = $this->c202_mesreferenciasicom ";
      $virgula = ",";
      if(trim($this->c202_mesreferenciasicom) == null ){ 
        $this->erro_sql = " Campo Mês de Referência SICOM nao Informado.";
        $this->erro_campo = "c202_mesreferenciasicom";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
     if(trim($this->c202_funcao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_funcao"])){ 
       $sql  .= $virgula." c202_funcao = $this->c202_funcao ";
       $virgula = ",";
       if(trim($this->c202_funcao) == null ){ 
         $this->erro_sql = " Campo Código da Função nao Informado.";
         $this->erro_campo = "c202_funcao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_subfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_subfuncao"])){ 
       $sql  .= $virgula." c202_subfuncao = $this->c202_subfuncao ";
       $virgula = ",";
       if(trim($this->c202_subfuncao) == null ){ 
         $this->erro_sql = " Campo SubFunção nao Informado.";
         $this->erro_campo = "c202_subfuncao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_codfontrecursos"])){ 
       $sql  .= $virgula." c202_codfontrecursos = $this->c202_codfontrecursos ";
       $virgula = ",";
       if(trim($this->c202_codfontrecursos) == null ){ 
         $this->erro_sql = " Campo fonte de recursos nao Informado.";
         $this->erro_campo = "c202_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       /**
        * adicionado para verificar o tamanho do campo
        */
       if(strlen($this->c202_codfontrecursos) != 3 ){ 
         $this->erro_sql = " Campo Fonte deve conter 3 dígitos.";
         $this->erro_campo = "c202_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_elemento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_elemento"])){ 
       $sql  .= $virgula." c202_elemento = $this->c202_elemento ";
       $virgula = ",";
       if(trim($this->c202_elemento) == null ){ 
         $this->erro_sql = " Campo Elemento nao Informado.";
         $this->erro_campo = "c202_elemento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       /**
        * adicionado para verificar o tamanho do campo
        */
       if(strlen($this->c202_elemento) != 8 ){ 
         $this->erro_sql = " Campo Elemento deve conter 8 dígitos.";
         $this->erro_campo = "c202_elemento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_valorempenhado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_valorempenhado"])){ 
       $sql  .= $virgula." c202_valorempenhado = $this->c202_valorempenhado ";
       $virgula = ",";
       if(trim($this->c202_valorempenhado) == null ){ 
         $this->erro_sql = " Campo Valor Empenhado no Mês nao Informado.";
         $this->erro_campo = "c202_valorempenhado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_valorempenhadoanu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_valorempenhadoanu"])){ 
       $sql  .= $virgula." c202_valorempenhadoanu = $this->c202_valorempenhadoanu ";
       $virgula = ",";
       if(trim($this->c202_valorempenhadoanu) == null ){ 
         $this->erro_sql = " Campo Valor Anulado no Mês nao Informado.";
         $this->erro_campo = "c202_valorempenhadoanu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_valorliquidado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_valorliquidado"])){ 
       $sql  .= $virgula." c202_valorliquidado = $this->c202_valorliquidado ";
       $virgula = ",";
       if(trim($this->c202_valorliquidado) == null ){ 
         $this->erro_sql = " Campo Valor Liquidado no Mês nao Informado.";
         $this->erro_campo = "c202_valorliquidado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
   if(trim($this->c202_valorliquidadoanu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_valorliquidadoanu"])){ 
       $sql  .= $virgula." c202_valorliquidadoanu = $this->c202_valorliquidadoanu ";
       $virgula = ",";
       if(trim($this->c202_valorliquidadoanu) == null ){ 
         $this->erro_sql = " Campo Valor Liquidado Anulado no Mês nao Informado.";
         $this->erro_campo = "c202_valorliquidadoanu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_valorpago)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_valorpago"])){ 
       $sql  .= $virgula." c202_valorpago = $this->c202_valorpago ";
       $virgula = ",";
       if(trim($this->c202_valorpago) == null ){ 
         $this->erro_sql = " Campo Valor Pago no Mês nao Informado.";
         $this->erro_campo = "c202_valorpago";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c202_valorpagoanu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c202_valorpagoanu"])){ 
       $sql  .= $virgula." c202_valorpagoanu = $this->c202_valorpagoanu ";
       $virgula = ",";
       if(trim($this->c202_valorpagoanu) == null ){ 
         $this->erro_sql = " Campo Valor Pago Anulado no Mês nao Informado.";
         $this->erro_campo = "c202_valorpagoanu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($c202_sequencial!=null){
       $sql .= " c202_sequencial = $this->c202_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->c202_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009417,'$this->c202_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_sequencial"]) || $this->c202_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009417,'".AddSlashes(pg_result($resaco,$conresaco,'c202_sequencial'))."','$this->c202_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_consconsorcios"]) || $this->c202_consconsorcios != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009418,'".AddSlashes(pg_result($resaco,$conresaco,'c202_consconsorcios'))."','$this->c202_consconsorcios',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_mescompetencia"]) || $this->c202_mescompetencia != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009419,'".AddSlashes(pg_result($resaco,$conresaco,'c202_mescompetencia'))."','$this->c202_mescompetencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_funcao"]) || $this->c202_funcao != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009420,'".AddSlashes(pg_result($resaco,$conresaco,'c202_funcao'))."','$this->c202_funcao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_subfuncao"]) || $this->c202_subfuncao != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009421,'".AddSlashes(pg_result($resaco,$conresaco,'c202_subfuncao'))."','$this->c202_subfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_elemento"]) || $this->c202_elemento != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009422,'".AddSlashes(pg_result($resaco,$conresaco,'c202_elemento'))."','$this->c202_elemento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_valorempenhado"]) || $this->c202_valorempenhado != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009423,'".AddSlashes(pg_result($resaco,$conresaco,'c202_valorempenhado'))."','$this->c202_valorempenhado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_valorempenhadoanu"]) || $this->c202_valorempenhadoanu != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009424,'".AddSlashes(pg_result($resaco,$conresaco,'c202_valorempenhadoanu'))."','$this->c202_valorempenhadoanu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_valorliquidado"]) || $this->c202_valorliquidado != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009425,'".AddSlashes(pg_result($resaco,$conresaco,'c202_valorliquidado'))."','$this->c202_valorliquidado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_valorpago"]) || $this->c202_valorpago != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009426,'".AddSlashes(pg_result($resaco,$conresaco,'c202_valorpago'))."','$this->c202_valorpago',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c202_valorpagoanu"]) || $this->c202_valorpagoanu != "")
           $resac = db_query("insert into db_acount values($acount,2010219,2009427,'".AddSlashes(pg_result($resaco,$conresaco,'c202_valorpagoanu'))."','$this->c202_valorpagoanu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Execução Orçamentária da Despesa nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c202_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Execução Orçamentária da Despesa nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($c202_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($c202_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009417,'$c202_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010219,2009417,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009418,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_consconsorcios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009419,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009420,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_funcao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009421,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_subfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009422,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_elemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009423,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_valorempenhado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009424,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_valorempenhadoanu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009425,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_valorliquidado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009426,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_valorpago'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010219,2009427,'','".AddSlashes(pg_result($resaco,$iresaco,'c202_valorpagoanu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from consexecucaoorc
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c202_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c202_sequencial = $c202_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Execução Orçamentária da Despesa nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c202_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Execução Orçamentária da Despesa nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c202_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:consexecucaoorc";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $c202_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consexecucaoorc ";
     $sql .= "      inner join orcfuncao  on  orcfuncao.o52_funcao = consexecucaoorc.c202_funcao";
     $sql .= "      inner join orcsubfuncao  on  orcsubfuncao.o53_subfuncao = consexecucaoorc.c202_subfuncao";
     $sql .= "      inner join consconsorcios  on  consconsorcios.c200_sequencial = consexecucaoorc.c202_consconsorcios";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = consconsorcios.c200_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($c202_sequencial!=null ){
         $sql2 .= " where consexecucaoorc.c202_sequencial = $c202_sequencial "; 
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
   function sql_query_file ( $c202_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consexecucaoorc ";
     $sql2 = "";
     if($dbwhere==""){
       if($c202_sequencial!=null ){
         $sql2 .= " where consexecucaoorc.c202_sequencial = $c202_sequencial "; 
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
