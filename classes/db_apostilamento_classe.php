<?
//MODULO: sicom
//CLASSE DA ENTIDADE apostilamento
class cl_apostilamento { 
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
   var $si03_sequencial = 0; 
   var $si03_licitacao = 0; 
   var $si03_numcontrato = 0; 
   var $si03_dataassinacontrato_dia = null; 
   var $si03_dataassinacontrato_mes = null; 
   var $si03_dataassinacontrato_ano = null; 
   var $si03_dataassinacontrato = null; 
   var $si03_tipoapostila = 0; 
   var $si03_dataapostila_dia = null; 
   var $si03_dataapostila_mes = null; 
   var $si03_dataapostila_ano = null; 
   var $si03_dataapostila = null; 
   var $si03_descrapostila = null; 
   var $si03_tipoalteracaoapostila = 0; 
   var $si03_numapostilamento = 0; 
   var $si03_valorapostila = 0; 
   var $si03_instit = 0; 
   var $si03_numcontratoanosanteriores = 0;
   var $si03_acordoposicao = null;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si03_sequencial = int8 = Codigo Sequencial 
                 si03_licitacao = int8 = Numero da licitacao 
                 si03_numcontrato = int8 = N Contrato 
                 si03_dataassinacontrato = date = Data Ass Contrato 
                 si03_tipoapostila = int8 = TIpo de Apostila 
                 si03_dataapostila = date = Data da Apostila 
                 si03_descrapostila = text = Descricao das alteracoes 
                 si03_tipoalteracaoapostila = int8 = Tipo de alteração Apostila 
                 si03_numapostilamento = int8 = Numero  Seq. Apostila 
                 si03_valorapostila = float8 = Valor da Aposlila 
                 si03_instit = int8 = Instituição 
                 si03_numcontratoanosanteriores = int8 = Numero Contrato de Anos Anteriores
                 si03_acordoposicao = int8 = Acordo Posicao 
                 si03_acordo = int8 = Acordo 

                 ";
   //funcao construtor da classe 
   function cl_apostilamento() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("apostilamento"); 
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
       $this->si03_sequencial = ($this->si03_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_sequencial"]:$this->si03_sequencial);
       $this->si03_licitacao = ($this->si03_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_licitacao"]:$this->si03_licitacao);
       $this->si03_numcontrato = ($this->si03_numcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_numcontrato"]:$this->si03_numcontrato);
       if($this->si03_dataassinacontrato == ""){
         $this->si03_dataassinacontrato_dia = ($this->si03_dataassinacontrato_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_dataassinacontrato_dia"]:$this->si03_dataassinacontrato_dia);
         $this->si03_dataassinacontrato_mes = ($this->si03_dataassinacontrato_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_dataassinacontrato_mes"]:$this->si03_dataassinacontrato_mes);
         $this->si03_dataassinacontrato_ano = ($this->si03_dataassinacontrato_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_dataassinacontrato_ano"]:$this->si03_dataassinacontrato_ano);
         if($this->si03_dataassinacontrato_dia != ""){
            $this->si03_dataassinacontrato = $this->si03_dataassinacontrato_ano."-".$this->si03_dataassinacontrato_mes."-".$this->si03_dataassinacontrato_dia;
         }
       }
       $this->si03_tipoapostila = ($this->si03_tipoapostila == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_tipoapostila"]:$this->si03_tipoapostila);
       if($this->si03_dataapostila == ""){
         $this->si03_dataapostila_dia = ($this->si03_dataapostila_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_dataapostila_dia"]:$this->si03_dataapostila_dia);
         $this->si03_dataapostila_mes = ($this->si03_dataapostila_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_dataapostila_mes"]:$this->si03_dataapostila_mes);
         $this->si03_dataapostila_ano = ($this->si03_dataapostila_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_dataapostila_ano"]:$this->si03_dataapostila_ano);
         if($this->si03_dataapostila_dia != ""){
            $this->si03_dataapostila = $this->si03_dataapostila_ano."-".$this->si03_dataapostila_mes."-".$this->si03_dataapostila_dia;
         }
       }
       $this->si03_descrapostila = ($this->si03_descrapostila == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_descrapostila"]:$this->si03_descrapostila);
       $this->si03_tipoalteracaoapostila = ($this->si03_tipoalteracaoapostila == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_tipoalteracaoapostila"]:$this->si03_tipoalteracaoapostila);
       $this->si03_numapostilamento = ($this->si03_numapostilamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_numapostilamento"]:$this->si03_numapostilamento);
       $this->si03_valorapostila = ($this->si03_valorapostila == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_valorapostila"]:$this->si03_valorapostila);
       $this->si03_instit = ($this->si03_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_instit"]:$this->si03_instit);
       $this->si03_numcontratoanosanteriores = ($this->si03_numcontratoanosanteriores == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_numcontratoanosanteriores"]:$this->si03_numcontratoanosanteriores);
       $this->si03_acordoposicao = ($this->si03_acordoposicao == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_acordoposicao"]:$this->si03_acordoposicao);
       $this->si03_acordo = ($this->si03_acordo == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_acordo"]:$this->si03_acordo);
     }else{
       $this->si03_sequencial = ($this->si03_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si03_sequencial"]:$this->si03_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si03_sequencial){ 
      $this->atualizacampos();
     if($this->si03_licitacao == null ){ 
       $this->si03_licitacao = "0";
     }
     if($this->si03_numcontrato == null && ($this->si03_numcontratoanosanteriores == null || $this->si03_numcontratoanosanteriores == 0)){
       $this->erro_sql = " Campo N Contrato nao Informado.";
       $this->erro_campo = "si03_numcontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si03_dataassinacontrato == null ){ 
       $this->erro_sql = " Campo Data Ass Contrato nao Informado.";
       $this->erro_campo = "si03_dataassinacontrato_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si03_tipoapostila == null ){ 
       $this->erro_sql = " Campo TIpo de Apostila nao Informado.";
       $this->erro_campo = "si03_tipoapostila";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si03_dataapostila == null ){ 
       $this->erro_sql = " Campo Data da Apostila nao Informado.";
       $this->erro_campo = "si03_dataapostila_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si03_descrapostila == null ){ 
       $this->erro_sql = " Campo Descricao das alteracoes nao Informado.";
       $this->erro_campo = "si03_descrapostila";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si03_tipoalteracaoapostila == null ){ 
       $this->erro_sql = " Campo Tipo de alteração Apostila nao Informado.";
       $this->erro_campo = "si03_tipoalteracaoapostila";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si03_numapostilamento == null ){ 
       $this->erro_sql = " Campo Numero  Seq. Apostila nao Informado.";
       $this->erro_campo = "si03_numapostilamento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si03_valorapostila == null && $this->si03_tipoapostila != 3){
       $this->erro_sql = " Campo Valor da Aposlila nao Informado.";
       $this->erro_campo = "si03_valorapostila";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si03_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si03_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si03_sequencial == "" || $si03_sequencial == null ){
       $result = db_query("select nextval('apostilamento_si03_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: apostilamento_si03_sequencial_seq do campo: si03_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si03_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from apostilamento_si03_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si03_sequencial)){
         $this->erro_sql = " Campo si03_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si03_sequencial = $si03_sequencial; 
       }
     }
     if(($this->si03_sequencial == null) || ($this->si03_sequencial == "") ){ 
       $this->erro_sql = " Campo si03_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into apostilamento(
                                       si03_sequencial 
                                      ,si03_licitacao 
                                      ,si03_numcontrato 
                                      ,si03_dataassinacontrato 
                                      ,si03_tipoapostila 
                                      ,si03_dataapostila 
                                      ,si03_descrapostila 
                                      ,si03_tipoalteracaoapostila 
                                      ,si03_numapostilamento 
                                      ,si03_valorapostila 
                                      ,si03_instit
                                      ,si03_numcontratoanosanteriores 
                                      ,si03_acordoposicao
                                      ,si03_acordo
                       )
                values (
                                $this->si03_sequencial 
                               ,".($this->si03_licitacao==0 ? 'null' : $this->si03_licitacao)." 
                               ,".($this->si03_numcontrato=="null" ? 'null' : $this->si03_numcontrato)."
                               ,".($this->si03_dataassinacontrato == "null" || $this->si03_dataassinacontrato == ""?"null":"'".$this->si03_dataassinacontrato."'")." 
                               ,$this->si03_tipoapostila 
                               ,".($this->si03_dataapostila == "null" || $this->si03_dataapostila == ""?"null":"'".$this->si03_dataapostila."'")." 
                               ,'$this->si03_descrapostila' 
                               ,$this->si03_tipoalteracaoapostila 
                               ,$this->si03_numapostilamento 
                               ,".($this->si03_valorapostila == null ? 0 : $this->si03_valorapostila)."
                               ,$this->si03_instit
                               ,".($this->si03_numcontratoanosanteriores==null ? '0' : $this->si03_numcontratoanosanteriores)." 
                               ,".($this->si03_acordoposicao == null || $this->si03_acordoposicao == ""?"null":$this->si03_acordoposicao)."
                               ,".($this->si03_acordo == null || $this->si03_acordo == ""?"null":$this->si03_acordo)."
                      )";
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "apostilamento ($this->si03_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "apostilamento já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "apostilamento ($this->si03_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si03_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si03_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009267,'$this->si03_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010197,2009267,'','".AddSlashes(pg_result($resaco,0,'si03_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2009260,'','".AddSlashes(pg_result($resaco,0,'si03_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2009262,'','".AddSlashes(pg_result($resaco,0,'si03_numcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2009263,'','".AddSlashes(pg_result($resaco,0,'si03_dataassinacontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2009264,'','".AddSlashes(pg_result($resaco,0,'si03_tipoapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2009265,'','".AddSlashes(pg_result($resaco,0,'si03_dataapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2009266,'','".AddSlashes(pg_result($resaco,0,'si03_descrapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2011514,'','".AddSlashes(pg_result($resaco,0,'si03_tipoalteracaoapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2009268,'','".AddSlashes(pg_result($resaco,0,'si03_numapostilamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2011515,'','".AddSlashes(pg_result($resaco,0,'si03_valorapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010197,2011686,'','".AddSlashes(pg_result($resaco,0,'si03_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si03_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update apostilamento set ";
     $virgula = "";
     if(trim($this->si03_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_sequencial"])){ 
       $sql  .= $virgula." si03_sequencial = $this->si03_sequencial ";
       $virgula = ",";
       if(trim($this->si03_sequencial) == null ){ 
         $this->erro_sql = " Campo Codigo Sequencial nao Informado.";
         $this->erro_campo = "si03_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si03_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_licitacao"])){ 
        if(trim($this->si03_licitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si03_licitacao"])){ 
           $this->si03_licitacao = "0" ; 
        } 
       $sql  .= $virgula." si03_licitacao = ".($this->si03_licitacao==0 ? 'null' : $this->si03_licitacao);
       $virgula = ",";
     }
     if(trim($this->si03_numcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_numcontrato"])){ 
       $sql  .= $virgula." si03_numcontrato = $this->si03_numcontrato ";
       $virgula = ",";
       if($this->si03_numcontrato == null && ($this->si03_numcontratoanosanteriores == null || $this->si03_numcontratoanosanteriores == 0)){
         $this->erro_sql = " Campo N Contrato nao Informado.";
         $this->erro_campo = "si03_numcontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si03_dataassinacontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_dataassinacontrato_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si03_dataassinacontrato_dia"] !="") ){ 
       $sql  .= $virgula." si03_dataassinacontrato = '$this->si03_dataassinacontrato' ";
       $virgula = ",";
       if(trim($this->si03_dataassinacontrato) == null ){ 
         $this->erro_sql = " Campo Data Ass Contrato nao Informado.";
         $this->erro_campo = "si03_dataassinacontrato_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si03_dataassinacontrato_dia"])){ 
         $sql  .= $virgula." si03_dataassinacontrato = null ";
         $virgula = ",";
         if(trim($this->si03_dataassinacontrato) == null ){ 
           $this->erro_sql = " Campo Data Ass Contrato nao Informado.";
           $this->erro_campo = "si03_dataassinacontrato_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si03_tipoapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_tipoapostila"])){ 
       $sql  .= $virgula." si03_tipoapostila = $this->si03_tipoapostila ";
       $virgula = ",";
       if(trim($this->si03_tipoapostila) == null ){ 
         $this->erro_sql = " Campo TIpo de Apostila nao Informado.";
         $this->erro_campo = "si03_tipoapostila";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si03_dataapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_dataapostila_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si03_dataapostila_dia"] !="") ){ 
       $sql  .= $virgula." si03_dataapostila = '$this->si03_dataapostila' ";
       $virgula = ",";
       if(trim($this->si03_dataapostila) == null ){ 
         $this->erro_sql = " Campo Data da Apostila nao Informado.";
         $this->erro_campo = "si03_dataapostila_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si03_dataapostila_dia"])){ 
         $sql  .= $virgula." si03_dataapostila = null ";
         $virgula = ",";
         if(trim($this->si03_dataapostila) == null ){ 
           $this->erro_sql = " Campo Data da Apostila nao Informado.";
           $this->erro_campo = "si03_dataapostila_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si03_descrapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_descrapostila"])){ 
       $sql  .= $virgula." si03_descrapostila = '$this->si03_descrapostila' ";
       $virgula = ",";
       if(trim($this->si03_descrapostila) == null ){ 
         $this->erro_sql = " Campo Descricao das alteracoes nao Informado.";
         $this->erro_campo = "si03_descrapostila";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si03_tipoalteracaoapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_tipoalteracaoapostila"])){ 
       $sql  .= $virgula." si03_tipoalteracaoapostila = $this->si03_tipoalteracaoapostila ";
       $virgula = ",";
       if(trim($this->si03_tipoalteracaoapostila) == null ){ 
         $this->erro_sql = " Campo Tipo de alteração Apostila nao Informado.";
         $this->erro_campo = "si03_tipoalteracaoapostila";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si03_numapostilamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_numapostilamento"])){ 
       $sql  .= $virgula." si03_numapostilamento = $this->si03_numapostilamento ";
       $virgula = ",";
       if(trim($this->si03_numapostilamento) == null ){ 
         $this->erro_sql = " Campo Numero  Seq. Apostila nao Informado.";
         $this->erro_campo = "si03_numapostilamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si03_valorapostila)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_valorapostila"])){ 
       $sql  .= $virgula." si03_valorapostila = $this->si03_valorapostila ";
       $virgula = ",";
       if(trim($this->si03_valorapostila) == null ){ 
         $this->erro_sql = " Campo Valor da Aposlila nao Informado.";
         $this->erro_campo = "si03_valorapostila";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si03_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_instit"])){ 
       $sql  .= $virgula." si03_instit = $this->si03_instit ";
       $virgula = ",";
       if(trim($this->si03_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si03_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si03_numcontratoanosanteriores)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_numcontratoanosanteriores"])){ 
       $sql  .= $virgula." si03_numcontratoanosanteriores = ".($this->si03_numcontratoanosanteriores==null?'0':$this->si03_numcontratoanosanteriores);
       $virgula = ",";
       if($this->si03_numcontrato == null && ($this->si03_numcontratoanosanteriores == null || $this->si03_numcontratoanosanteriores == 0)){
         $this->erro_sql = " Campo N Contrato nao Informado.";
         $this->erro_campo = "si03_numcontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si03_acordoposicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_acordoposicao"])){ 
       $sql  .= $virgula." si03_acordoposicao = $this->si03_acordoposicao ";
       $virgula = ",";
     }
     if(trim($this->si03_acordo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si03_acordo"])){ 
       $sql  .= $virgula." si03_acordo = $this->si03_acordo ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($si03_sequencial!=null){
       $sql .= " si03_sequencial = $this->si03_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si03_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009267,'$this->si03_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_sequencial"]) || $this->si03_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2009267,'".AddSlashes(pg_result($resaco,$conresaco,'si03_sequencial'))."','$this->si03_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_licitacao"]) || $this->si03_licitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2009260,'".AddSlashes(pg_result($resaco,$conresaco,'si03_licitacao'))."','$this->si03_licitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_numcontrato"]) || $this->si03_numcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2009262,'".AddSlashes(pg_result($resaco,$conresaco,'si03_numcontrato'))."','$this->si03_numcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_dataassinacontrato"]) || $this->si03_dataassinacontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2009263,'".AddSlashes(pg_result($resaco,$conresaco,'si03_dataassinacontrato'))."','$this->si03_dataassinacontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_tipoapostila"]) || $this->si03_tipoapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2009264,'".AddSlashes(pg_result($resaco,$conresaco,'si03_tipoapostila'))."','$this->si03_tipoapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_dataapostila"]) || $this->si03_dataapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2009265,'".AddSlashes(pg_result($resaco,$conresaco,'si03_dataapostila'))."','$this->si03_dataapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_descrapostila"]) || $this->si03_descrapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2009266,'".AddSlashes(pg_result($resaco,$conresaco,'si03_descrapostila'))."','$this->si03_descrapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_tipoalteracaoapostila"]) || $this->si03_tipoalteracaoapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2011514,'".AddSlashes(pg_result($resaco,$conresaco,'si03_tipoalteracaoapostila'))."','$this->si03_tipoalteracaoapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_numapostilamento"]) || $this->si03_numapostilamento != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2009268,'".AddSlashes(pg_result($resaco,$conresaco,'si03_numapostilamento'))."','$this->si03_numapostilamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_valorapostila"]) || $this->si03_valorapostila != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2011515,'".AddSlashes(pg_result($resaco,$conresaco,'si03_valorapostila'))."','$this->si03_valorapostila',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si03_instit"]) || $this->si03_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010197,2011686,'".AddSlashes(pg_result($resaco,$conresaco,'si03_instit'))."','$this->si03_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "apostilamento nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si03_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "apostilamento nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si03_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si03_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si03_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si03_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009267,'$si03_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010197,2009267,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2009260,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2009262,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_numcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2009263,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_dataassinacontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2009264,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_tipoapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2009265,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_dataapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2009266,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_descrapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2011514,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_tipoalteracaoapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2009268,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_numapostilamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2011515,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_valorapostila'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010197,2011686,'','".AddSlashes(pg_result($resaco,$iresaco,'si03_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from apostilamento
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si03_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si03_sequencial = $si03_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "apostilamento nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si03_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "apostilamento nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si03_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si03_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:apostilamento";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si03_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from apostilamento ";
     $sql .= "      left  join liclicita  on  liclicita.l20_codigo = apostilamento.si03_licitacao";
     $sql .= "      left  join contratos  on  contratos.si172_sequencial = apostilamento.si03_numcontrato";
     $sql .= "      left  join db_config  on  db_config.codigo = liclicita.l20_instit";
     $sql .= "      left  join db_usuarios  on  db_usuarios.id_usuario = liclicita.l20_id_usucria";
     $sql2 = "";
     if($dbwhere==""){
       if($si03_sequencial!=null ){
         $sql2 .= " where apostilamento.si03_sequencial = $si03_sequencial "; 
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
   function sql_query_file ( $si03_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from apostilamento ";
     $sql2 = "";
     if($dbwhere==""){
       if($si03_sequencial!=null ){
         $sql2 .= " where apostilamento.si03_sequencial = $si03_sequencial "; 
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
