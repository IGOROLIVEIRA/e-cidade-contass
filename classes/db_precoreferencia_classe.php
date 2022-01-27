<?
//MODULO: sicom
//CLASSE DA ENTIDADE precoreferencia
class cl_precoreferencia { 
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
   var $si01_sequencial = 0; 
   var $si01_processocompra = 0; 
   var $si01_datacotacao_dia = null; 
   var $si01_datacotacao_mes = null; 
   var $si01_datacotacao_ano = null; 
   var $si01_datacotacao = null; 
   var $si01_tipoprecoreferencia = 0; 
   var $si01_justificativa = null;
   var $si01_cotacaoitem = 0; 
   var $si01_tipoCotacao = 0; 
   var $si01_numcgmCotacao = 0;
   var $si01_tipoOrcamento = 0; 
   var $si01_numcgmOrcamento = 0;

   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si01_sequencial = int8 = codigo sequencial 
                 si01_processocompra = int8 = numero do processo de compra 
                 si01_datacotacao = date = data da cotacao 
                 si01_tipoprecoreferencia = int8 = Tipo de Preco de Referencia 
                 si01_justificativa = text = Justificativa
                 si01_cotacaoitem = int4 = Cotação Item
                 si01_tipo = int = Tipo de responsável
                 si01_numcgm = int  =   Num CGM responsável
                 ";
   //funcao construtor da classe 
   function cl_precoreferencia() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("precoreferencia"); 
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
       $this->si01_sequencial = ($this->si01_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_sequencial"]:$this->si01_sequencial);
       $this->si01_processocompra = ($this->si01_processocompra == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_processocompra"]:$this->si01_processocompra);
       if($this->si01_datacotacao == ""){
         $this->si01_datacotacao_dia = ($this->si01_datacotacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_datacotacao_dia"]:$this->si01_datacotacao_dia);
         $this->si01_datacotacao_mes = ($this->si01_datacotacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_datacotacao_mes"]:$this->si01_datacotacao_mes);
         $this->si01_datacotacao_ano = ($this->si01_datacotacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_datacotacao_ano"]:$this->si01_datacotacao_ano);
         if($this->si01_datacotacao_dia != ""){
            $this->si01_datacotacao = $this->si01_datacotacao_ano."-".$this->si01_datacotacao_mes."-".$this->si01_datacotacao_dia;
         }
       }
       $this->si01_tipoprecoreferencia = ($this->si01_tipoprecoreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_tipoprecoreferencia"]:$this->si01_tipoprecoreferencia);
       $this->si01_justificativa = ($this->si01_justificativa == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_justificativa"]:$this->si01_justificativa);
       $this->si01_cotacaoitem = ($this->si01_cotacaoitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_cotacaoitem"]:$this->si01_cotacaoitem);
       $this->si01_tipoCotacao = ($this->si01_tipoCotacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_tipoCotacao"]:$this->si01_tipoCotacao);
       $this->si01_numcgmCotacao = ($this->si01_numcgmCotacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_numcgmCotacao"]:$this->si01_numcgmCotacao);
       $this->si01_tipoOrcamento = ($this->si01_tipoOrcamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_tipoOrcamento"]:$this->si01_tipoOrcamento);
       $this->si01_numcgmOrcamento = ($this->si01_numcgmOrcamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_numcgmOrcamento"]:$this->si01_numcgmOrcamento);
     }else{
       $this->si01_sequencial = ($this->si01_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_sequencial"]:$this->si01_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si01_sequencial){ 
      $this->atualizacampos();
     if($this->si01_processocompra == null ){ 
       $this->erro_sql = " Campo numero do processo de compra nao Informado.";
       $this->erro_campo = "si01_processocompra";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si01_datacotacao == null ){ 
       $this->erro_sql = " Campo data da cotacao nao Informado.";
       $this->erro_campo = "si01_datacotacao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(strtotime($this->si01_datacotacao) < strtotime($this->getDataPcCompras($this->si01_processocompra))){
       $this->erro_sql = " Campo data da cotacao nao pode ser anterior a data do processo de compras.";
       $this->erro_campo = "si01_datacotacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si01_tipoprecoreferencia == null ){ 
       $this->erro_sql = " Campo Tipo de Preco de Referencia nao Informado.";
       $this->erro_campo = "si01_tipoprecoreferencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

    if($this->si01_numcgmCotacao == null ){ 
      $this->erro_sql = " Campo Responsável pela Cotação não Informado.";
      $this->erro_campo = "si01_numcgmCotacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si01_numcgmOrcamento == null ){ 
      $this->erro_sql = " Campo Responsável pelo Recurso Orçamentário não Informado.";
      $this->erro_campo = "si01_numcgmOrcamento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     
     $sSql = "select distinct pc21_orcamforne from pcproc 
              join pcprocitem on pc80_codproc = pc81_codproc 
              join pcorcamitemproc on pc81_codprocitem = pc31_pcprocitem
              join pcorcamitem on pc31_orcamitem = pc22_orcamitem
              join pcorcamval on pc22_orcamitem = pc23_orcamitem
              join pcorcamforne on pc23_orcamforne = pc21_orcamforne
              where pc80_codproc = {$this->si01_processocompra}";
     
     $rsResult = db_query($sSql);
     
     if (pg_num_rows($rsResult) < 3) {
     
     	 if($this->si01_justificativa == null ){ 
         $this->erro_sql = " Campo Justificativa nao Informado.";
         $this->erro_campo = "si01_justificativa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     	
     }
      
     if($si01_sequencial == "" || $si01_sequencial == null ){
       $result = db_query("select nextval('sic_precoreferencia_si01_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: sic_precoreferencia_si01_sequencial_seq do campo: si01_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si01_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from sic_precoreferencia_si01_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si01_sequencial)){
         $this->erro_sql = " Campo si01_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si01_sequencial = $si01_sequencial; 
       }
     }
     if(($this->si01_sequencial == null) || ($this->si01_sequencial == "") ){ 
       $this->erro_sql = " Campo si01_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into precoreferencia(
                                       si01_sequencial 
                                      ,si01_processocompra 
                                      ,si01_datacotacao 
                                      ,si01_tipoprecoreferencia 
                                      ,si01_justificativa
                                      ,si01_cotacaoitem
                                      ,si01_tipoCotacao 
                                      ,si01_numcgmCotacao
                                      ,si01_tipoOrcamento 
                                      ,si01_numcgmOrcamento 
                       )
                values (
                                $this->si01_sequencial 
                               ,$this->si01_processocompra 
                               ,".($this->si01_datacotacao == "null" || $this->si01_datacotacao == ""?"null":"'".$this->si01_datacotacao."'")." 
                               ,$this->si01_tipoprecoreferencia 
                               ,'$this->si01_justificativa'
                               ,$this->si01_cotacaoitem
                               ,$this->si01_tipoCotacao 
                               ,$this->si01_numcgmCotacao
                               ,$this->si01_tipoOrcamento 
                               ,$this->si01_numcgmOrcamento  
                      )";
     $result = db_query($sql); 
     
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Preco de Referencia ($this->si01_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Preco de Referencia já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Preco de Referencia ($this->si01_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si01_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si01_sequencial)); 
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009252,'$this->si01_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010195,2009252,'','".AddSlashes(pg_result($resaco,0,'si01_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010195,2009247,'','".AddSlashes(pg_result($resaco,0,'si01_processocompra'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010195,2009248,'','".AddSlashes(pg_result($resaco,0,'si01_datacotacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010195,2009250,'','".AddSlashes(pg_result($resaco,0,'si01_tipoprecoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010195,2009251,'','".AddSlashes(pg_result($resaco,0,'si01_justificativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si01_sequencial=null) { 
      $this->atualizacampos();

     if(strtotime($this->si01_datacotacao) < strtotime($this->getDataPcCompras($this->si01_processocompra))){
       $this->erro_sql = " Campo data da cotacao nao pode ser anterior a data do processo de compras.";
       $this->erro_campo = "si01_datacotacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = " update precoreferencia set ";
     $virgula = "";
     if(trim($this->si01_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_sequencial"])){ 
       $sql  .= $virgula." si01_sequencial = $this->si01_sequencial ";
       $virgula = ",";
       if(trim($this->si01_sequencial) == null ){ 
         $this->erro_sql = " Campo codigo sequencial nao Informado.";
         $this->erro_campo = "si01_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     } 
     if(trim($this->si01_processocompra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_processocompra"])){ 
       $sql  .= $virgula." si01_processocompra = $this->si01_processocompra ";
       $virgula = ",";
       if(trim($this->si01_processocompra) == null ){ 
         $this->erro_sql = " Campo numero do processo de compra nao Informado.";
         $this->erro_campo = "si01_processocompra";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si01_cotacaoitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_cotacaoitem"])){ 
      $sql  .= $virgula." si01_cotacaoitem = $this->si01_cotacaoitem ";
      $virgula = ",";
      if(trim($this->si01_cotacaoitem) == null ){ 
        $this->erro_sql = " Campo cotaçãop por item nao Informado.";
        $this->erro_campo = "si01_cotacaoitem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si01_numcgmCotacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_numcgmCotacao"])){ 
      $sql  .= $virgula." si01_numcgmCotacao = $this->si01_numcgmCotacao ";
      $virgula = ",";
      if(trim($this->si01_numcgmCotacao) == null ){ 
        $this->erro_sql = " Campo cotaçãop por item nao Informado.";
        $this->erro_campo = "si01_numcgmCotacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si01_numcgmOrcamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_numcgmOrcamento"])){ 
      $sql  .= $virgula." si01_numcgmOrcamento = $this->si01_numcgmOrcamento ";
      $virgula = ",";
      if(trim($this->si01_numcgmOrcamento) == null ){ 
        $this->erro_sql = " Campo cotaçãop por item nao Informado.";
        $this->erro_campo = "si01_numcgmOrcamento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si01_tipoCotacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_tipoCotacao"])){ 
      $sql  .= $virgula." si01_tipoCotacao = $this->si01_tipoCotacao ";
      $virgula = ",";
      if(trim($this->si01_tipoCotacao) == null ){ 
        $this->erro_sql = " Campo cotaçãop por item nao Informado.";
        $this->erro_campo = "si01_tipoCotacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si01_tipoOrcamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_tipoOrcamento"])){ 
      $sql  .= $virgula." si01_tipoOrcamento = $this->si01_tipoOrcamento ";
      $virgula = ",";
      if(trim($this->si01_tipoOrcamento) == null ){ 
        $this->erro_sql = " Campo cotaçãop por item nao Informado.";
        $this->erro_campo = "si01_tipoOrcamento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
     if(trim($this->si01_datacotacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_datacotacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si01_datacotacao_dia"] !="") ){ 
       $sql  .= $virgula." si01_datacotacao = '$this->si01_datacotacao' ";
       $virgula = ",";
       if(trim($this->si01_datacotacao) == null ){ 
         $this->erro_sql = " Campo data da cotacao nao Informado.";
         $this->erro_campo = "si01_datacotacao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si01_datacotacao_dia"])){ 
         $sql  .= $virgula." si01_datacotacao = null ";
         $virgula = ",";
         if(trim($this->si01_datacotacao) == null ){ 
           $this->erro_sql = " Campo data da cotacao nao Informado.";
           $this->erro_campo = "si01_datacotacao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si01_tipoprecoreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_tipoprecoreferencia"])){ 
       $sql  .= $virgula." si01_tipoprecoreferencia = $this->si01_tipoprecoreferencia ";
       $virgula = ",";
       if(trim($this->si01_tipoprecoreferencia) == null ){ 
         $this->erro_sql = " Campo Tipo de Preco de Referencia nao Informado.";
         $this->erro_campo = "si01_tipoprecoreferencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
   $sSql = "select distinct pc21_orcamforne from pcproc
              join pcprocitem on pc80_codproc = pc81_codproc 
              join pcorcamitemproc on pc81_codprocitem = pc31_pcprocitem
              join pcorcamitem on pc31_orcamitem = pc22_orcamitem
              join pcorcamval on pc22_orcamitem = pc23_orcamitem
              join pcorcamforne on pc23_orcamforne = pc21_orcamforne
              where pc80_codproc = {$this->si01_processocompra}";
     
     $rsResult = db_query($sSql);
     
     if (pg_num_rows($rsResult) >= 3 ) {
        if(trim($this->si01_justificativa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_justificativa"])){ 
	          $sql  .= $virgula." si01_justificativa = '$this->si01_justificativa' ";
	          $virgula = ",";
        }
     }else{
      if(trim($this->si01_justificativa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_justificativa"])){ 
        $sql  .= $virgula." si01_justificativa = '$this->si01_justificativa' ";
        $virgula = ",";
        if(trim($this->si01_justificativa) == null ){ 
          $this->erro_sql = " Campo Justificativa não Informada.";
          $this->erro_campo = "si01_justificativa";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
     }

     $sql .= " where ";
     if($si01_sequencial!=null){
       $sql .= " si01_sequencial = $this->si01_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si01_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009252,'$this->si01_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_sequencial"]) || $this->si01_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010195,2009252,'".AddSlashes(pg_result($resaco,$conresaco,'si01_sequencial'))."','$this->si01_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_processocompra"]) || $this->si01_processocompra != "")
           $resac = db_query("insert into db_acount values($acount,2010195,2009247,'".AddSlashes(pg_result($resaco,$conresaco,'si01_processocompra'))."','$this->si01_processocompra',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_datacotacao"]) || $this->si01_datacotacao != "")
           $resac = db_query("insert into db_acount values($acount,2010195,2009248,'".AddSlashes(pg_result($resaco,$conresaco,'si01_datacotacao'))."','$this->si01_datacotacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_tipoprecoreferencia"]) || $this->si01_tipoprecoreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010195,2009250,'".AddSlashes(pg_result($resaco,$conresaco,'si01_tipoprecoreferencia'))."','$this->si01_tipoprecoreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_justificativa"]) || $this->si01_justificativa != "")
           $resac = db_query("insert into db_acount values($acount,2010195,2009251,'".AddSlashes(pg_result($resaco,$conresaco,'si01_justificativa'))."','$this->si01_justificativa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Preco de Referencia nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si01_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Preco de Referencia nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si01_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si01_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si01_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si01_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009252,'$si01_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010195,2009252,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010195,2009247,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_processocompra'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010195,2009248,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_datacotacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010195,2009250,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_tipoprecoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010195,2009251,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_justificativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     
     $sql = "delete from itemprecoreferencia where si02_precoreferencia = $si01_sequencial";
     $result = db_query($sql);
     
     $sql = " delete from precoreferencia
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si01_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si01_sequencial = $si01_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Preco de Referencia nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si01_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Preco de Referencia nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si01_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si01_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:precoreferencia";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si01_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from precoreferencia ";
     $sql .= "      inner join pcproc  on  pcproc.pc80_codproc = precoreferencia.si01_processocompra";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = pcproc.pc80_usuario";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = pcproc.pc80_depto";
     $sql2 = "";
     if($dbwhere==""){
       if($si01_sequencial!=null ){
         $sql2 .= " where precoreferencia.si01_sequencial = $si01_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $si01_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from precoreferencia ";
     $sql2 = "";
     if($dbwhere==""){
       if($si01_sequencial!=null ){
         $sql2 .= " where precoreferencia.si01_sequencial = $si01_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }

  /**
   * Função que retorna a data do processo de compras
   * @param $codproc
   * @return mixed
   */
  public function getDataPcCompras($codproc){
    $sSql = "select pc80_data from compras.pcproc where pc80_codproc = $codproc";
    $resSsql = db_query($sSql) or die(pg_last_error());
    return db_utils::fieldsMemory($resSsql, 0)->pc80_data;
  }
}
?>
