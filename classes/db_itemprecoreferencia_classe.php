<?
//MODULO: sicom
//CLASSE DA ENTIDADE itemprecoreferencia
class cl_itemprecoreferencia {
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
   var $si02_sequencial = 0;
   var $si02_precoreferencia = 0;
   var $si02_itemproccompra = 0;
   var $si02_vlprecoreferencia = 0;
   var $si02_vltotalprecoreferencia = 0;
   var $si02_vlpercreferencia = 0;
   var $si02_coditem = 0;
   //var $si02_descritem = null;
   var $si02_qtditem = 0;
   var $si02_codunidadeitem = 0;
   var $si02_reservado = "f";
   var $si02_tabela = "f";
   var $si02_taxa = "f";
   var $si02_criterioadjudicacao = 0;
   var $si02_mediapercentual = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si02_sequencial = int8 = codigo sequencial
                 si02_precoreferencia = int8 = codigo do preco de referencia
                 si02_itemproccompra = int8 = Codigo do Item
                 si02_vlprecoreferencia = float8 = Valor do preco de referencia
                 si02_coditem = int8 = Codigo do Item Material
                 si02_qtditem =  int8 = quantidade item 
                 si02_codunidadeitem = int8 = codigo da unidade
                 si02_reservado = bool = Reservado 
                 si02_tabela = bool = Tabela
                 si02_taxa = bool = Taxa
                 si02_criterioadjudicacao = int8 = criterio 
                 si02_mediapercentual = float8 = Media percentual
                 si02_vltotalprecoreferencia = float8 = Valor total do preco de referencia
                 ";
   //funcao construtor da classe
   function cl_itemprecoreferencia() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("itemprecoreferencia");
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
       $this->si02_sequencial = ($this->si02_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_sequencial"]:$this->si02_sequencial);
       $this->si02_precoreferencia = ($this->si02_precoreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_precoreferencia"]:$this->si02_precoreferencia);
       $this->si02_itemproccompra = ($this->si02_itemproccompra == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_itemproccompra"]:$this->si02_itemproccompra);
       $this->si02_vlprecoreferencia = ($this->si02_vlprecoreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_vlprecoreferencia"]:$this->si02_vlprecoreferencia);
       $this->si02_vltotalprecoreferencia = ($this->si02_vltotalprecoreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_vltotalprecoreferencia"]:$this->si02_vltotalprecoreferencia);
       $this->si02_coditem = ($this->si02_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_coditem"]:$this->si02_coditem);
       //$this->si02_descritem = ($this->si02_descritem == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_descritem"]:$this->si02_descritem);
       $this->si02_qtditem = ($this->si02_qtditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_qtditem"]:$this->si02_qtditem);
       $this->si02_codunidadeitem = ($this->si02_codunidadeitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_codunidadeitem"]:$this->si02_codunidadeitem);
       $this->si02_reservado = ($this->si02_reservado == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_reservado"]:$this->si02_reservado);
       $this->si02_tabela = ($this->si02_tabela == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_tabela"]:$this->si02_tabela);
       $this->si02_taxa = ($this->si02_taxa == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_taxa"]:$this->si02_taxa);
       $this->si02_criterioadjudicacao = ($this->si02_criterioadjudicacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_criterioadjudicacao"]:$this->si02_criterioadjudicacao); 
       $this->si02_mediapercentual = ($this->si02_mediapercentual == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_mediapercentual"]:$this->si02_mediapercentual); 
      }else{
       $this->si02_sequencial = ($this->si02_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si02_sequencial"]:$this->si02_sequencial);
     }
   }
   // funcao para inclusao 
   function incluir ($si02_sequencial){
      $this->atualizacampos();
     if($this->si02_precoreferencia == null ){
       $this->erro_sql = " Campo codigo do preco de referencia nao Informado.";
       $this->erro_campo = "si02_precoreferencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si02_itemproccompra == null ){
       $this->erro_sql = " Campo Codigo do Item nao Informado.";
       $this->erro_campo = "si02_itemproccompra";
       $this->erro_banco = "";
       $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si02_vlprecoreferencia == null ){
       $this->erro_sql = " Campo Valor do preco de referencia nao Informado.";
       $this->erro_campo = "si02_vlprecoreferencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si02_vltotalprecoreferencia == null ){
      $this->erro_sql = " Campo Valor Total do preco de referencia nao Informado.";
      $this->erro_campo = "si02_vltotalprecoreferencia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     if($this->si02_coditem == null ){
      $this->erro_sql = " Campo codigo do item do material no informado.";
      $this->erro_campo = "si02_coditem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    /*if($this->si02_descritem == null ){
      $this->erro_sql = " Campo descricao do item no informado.";
      $this->erro_campo = "si02_descritem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }*/
    if($this->si02_qtditem == null ){
      $this->erro_sql = " Campo quantidade do item no informado.";
      $this->erro_campo = "si02_qtditem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    } 
    if($this->si02_codunidadeitem == null ){
      $this->erro_sql = " Campo codigo unidade do item no informado.";
      $this->erro_campo = "si02_codunidadeitem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si02_criterioadjudicacao == null ){
      $this->erro_sql = " Campo critrio de ajudicacao no informado.";
      $this->erro_campo = "si02_criterioadjudicacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si02_reservado == null ){
      $this->si02_reservado = "f";
    }
    if($this->si02_tabela == null ){
      $this->si02_tabela = "f";
    }
    if($this->si02_taxa == null ){
      $this->si02_taxa = "f";
    }
    if($this->si02_mediapercentual == null ){
      $this->si02_mediapercentual = 0;
    }
    
    

   if($si02_sequencial == "" || $si02_sequencial == null ){
       $result = db_query("select nextval('sic_itemprecoreferencia_si02_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: sic_itemprecoreferencia_si02_sequencial_seq do campo: si02_sequencial";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si02_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from sic_itemprecoreferencia_si02_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si02_sequencial)){
         $this->erro_sql = " Campo si02_sequencial maior que ltimo nmero da sequencia.";
         $this->erro_banco = "Sequencia menor que este nmero.";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si02_sequencial = $si02_sequencial;
       }
     }
     if(($this->si02_sequencial == null) || ($this->si02_sequencial == "") ){
       $this->erro_sql = " Campo si02_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into itemprecoreferencia(
                                       si02_sequencial
                                      ,si02_precoreferencia
                                      ,si02_itemproccompra
                                      ,si02_vlprecoreferencia
                                      ,si02_vlpercreferencia
                                      ,si02_coditem
                                      ,si02_qtditem
                                      ,si02_codunidadeitem
                                      ,si02_reservado
                                      ,si02_tabela
                                      ,si02_taxa
                                      ,si02_criterioadjudicacao
                                      ,si02_mediapercentual
                                      ,si02_vltotalprecoreferencia
                       )
                values (
                                $this->si02_sequencial
                               ,$this->si02_precoreferencia
                               ,$this->si02_itemproccompra
                               ,$this->si02_vlprecoreferencia
                               ,$this->si02_vlpercreferencia
                               ,$this->si02_coditem
                               ,$this->si02_qtditem
                               ,$this->si02_codunidadeitem
                               ,'$this->si02_reservado'
                               ,'$this->si02_tabela'
                               ,'$this->si02_taxa'
                               ,$this->si02_criterioadjudicacao
                               ,$this->si02_mediapercentual
                               ,$this->si02_vltotalprecoreferencia
                      )";
                 
     $result = db_query($sql);
     
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Item do preco de referencia ($this->si02_sequencial) nao Includo. Inclusao Abortada.";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Item do preco de referencia j Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Item do preco de referencia ($this->si02_sequencial) nao Includo. Inclusao Abortada.";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si02_sequencial;
     $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si02_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009253,'$this->si02_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010196,2009253,'','".AddSlashes(pg_result($resaco,0,'si02_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010196,2009255,'','".AddSlashes(pg_result($resaco,0,'si02_precoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010196,2009258,'','".AddSlashes(pg_result($resaco,0,'si02_itemproccompra'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010196,2009257,'','".AddSlashes(pg_result($resaco,0,'si02_vlprecoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010196,2009257,'','".AddSlashes(pg_result($resaco,0,'si02_vltotalprecoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($si02_sequencial=null) {
    
      $this->atualizacampos();
      
     $sql = " update itemprecoreferencia set ";
     $virgula = "";
     if(trim($this->si02_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si02_sequencial"])){
       $sql  .= $virgula." si02_sequencial = $this->si02_sequencial ";
       $virgula = ",";
       if(trim($this->si02_sequencial) == null ){
         $this->erro_sql = " Campo codigo sequencial nao Informado.";
         $this->erro_campo = "si02_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si02_precoreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si02_precoreferencia"])){
       $sql  .= $virgula." si02_precoreferencia = $this->si02_precoreferencia ";
       $virgula = ",";
       if(trim($this->si02_precoreferencia) == null ){
         $this->erro_sql = " Campo codigo do preco de referencia nao Informado.";
         $this->erro_campo = "si02_precoreferencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si02_itemproccompra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si02_itemproccompra"])){
       $sql  .= $virgula." si02_itemproccompra = $this->si02_itemproccompra ";
       $virgula = ",";
       if(trim($this->si02_itemproccompra) == null ){
         $this->erro_sql = " Campo Codigo do Item nao Informado.";
         $this->erro_campo = "si02_itemproccompra";
         $this->erro_banco = "";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si02_vlprecoreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si02_vlprecoreferencia"])){
       $sql  .= $virgula." si02_vlprecoreferencia = $this->si02_vlprecoreferencia ";
       $virgula = ",";
       if(trim($this->si02_vlprecoreferencia) == null ){
         $this->erro_sql = " Campo Valor do preco de referencia nao Informado.";
         $this->erro_campo = "si02_vlprecoreferencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si02_vltotalprecoreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si02_vltotalprecoreferencia"])){
      $sql  .= $virgula." si02_vltotalprecoreferencia = $this->si02_vltotalprecoreferencia ";
      $virgula = ",";
      if(trim($this->si02_vltotalprecoreferencia) == null ){
        $this->erro_sql = " Campo Valor Total do preco de referencia nao Informado.";
        $this->erro_campo = "si02_vltotalprecoreferencia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
     if(trim($this->si02_vlpercreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si02_vlpercreferencia"])){
       $sql  .= $virgula." si02_vlpercreferencia = $this->si02_vlpercreferencia ";
       $virgula = ",";
       if(trim($this->si02_vlpercreferencia) == null ){
         $this->erro_sql = " Campo Media de desconto referencia nao Informado.";
         $this->erro_campo = "si02_vlpercreferencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si02_qtditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si02_qtditem"])){
      $sql  .= $virgula." si02_qtditem = $this->si02_qtditem ";
      $virgula = ",";
      if(trim($this->si02_qtditem) == null ){
        $this->erro_sql = " Campo Media de desconto referencia nao Informado.";
        $this->erro_campo = "si02_qtditem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      }
     $sql .= " where ";  
     if($si02_sequencial==null){
        $sql .= " si02_sequencial = $this->si02_sequencial";
     }else{
        $sql .= " si02_sequencial = $si02_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si02_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009253,'$this->si02_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si02_sequencial"]) || $this->si02_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010196,2009253,'".AddSlashes(pg_result($resaco,$conresaco,'si02_sequencial'))."','$this->si02_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si02_precoreferencia"]) || $this->si02_precoreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010196,2009255,'".AddSlashes(pg_result($resaco,$conresaco,'si02_precoreferencia'))."','$this->si02_precoreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si02_itemproccompra"]) || $this->si02_itemproccompra != "")
           $resac = db_query("insert into db_acount values($acount,2010196,2009258,'".AddSlashes(pg_result($resaco,$conresaco,'si02_itemproccompra'))."','$this->si02_itemproccompra',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si02_vlprecoreferencia"]) || $this->si02_vlprecoreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010196,2009257,'".AddSlashes(pg_result($resaco,$conresaco,'si02_vlprecoreferencia'))."','$this->si02_vlprecoreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si02_vltotalprecoreferencia"]) || $this->si02_vltotalprecoreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010196,2009257,'".AddSlashes(pg_result($resaco,$conresaco,'si02_vltotalprecoreferencia'))."','$this->si02_vltotalprecoreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");  
       }
     }
     
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Item do preco de referencia nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si02_sequencial;
       $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Item do preco de referencia nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si02_sequencial;
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alterao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si02_sequencial;
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si02_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si02_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009253,'$si02_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010196,2009253,'','".AddSlashes(pg_result($resaco,$iresaco,'si02_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010196,2009255,'','".AddSlashes(pg_result($resaco,$iresaco,'si02_precoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010196,2009258,'','".AddSlashes(pg_result($resaco,$iresaco,'si02_itemproccompra'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010196,2009257,'','".AddSlashes(pg_result($resaco,$iresaco,'si02_vlprecoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010196,2009257,'','".AddSlashes(pg_result($resaco,$iresaco,'si02_vltotalprecoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from itemprecoreferencia
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si02_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si02_sequencial = $si02_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Item do preco de referencia nao Excludo. Excluso Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si02_sequencial;
       $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Item do preco de referencia nao Encontrado. Excluso no Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si02_sequencial;
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Excluso efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si02_sequencial;
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
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
       $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:itemprecoreferencia";
        $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si02_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from itemprecoreferencia ";
     $sql .= "      inner join precoreferencia  on  precoreferencia.si01_sequencial = itemprecoreferencia.si02_precoreferencia";
     $sql .= "      inner join pcproc  on  pcproc.pc80_codproc = precoreferencia.si01_processocompra";
     $sql2 = "";
     if($dbwhere==""){
       if($si02_sequencial!=null ){
         $sql2 .= " where itemprecoreferencia.si02_sequencial = $si02_sequencial ";
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
   function sql_query_file ( $si02_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from itemprecoreferencia ";
     $sql2 = "";
     if($dbwhere==""){
       if($si02_sequencial!=null ){
         $sql2 .= " where itemprecoreferencia.si02_sequencial = $si02_sequencial ";
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

  public function sql_query_precoreferencia($pc80_codproc){
    $sSql  = "select si01_sequencial "; 
    $sSql .= " from sicom.precoreferencia "; 
    $sSql .= " where si01_processocompra=$pc80_codproc";

    return $sSql;

  }



  public function sql_query_precoreferensequncial($si01_sequencial,$pc23_orcamitem){
    $sSql  = "select si02_sequencial ";  
    $sSql  .= "from sicom.itemprecoreferencia "; 
    $sSql  .= "where si02_precoreferencia = $si01_sequencial and si02_itemproccompra = $pc23_orcamitem "; 

    return $sSql;
  }

  public function sql_query_codprocesso($pc11_numero){
    $sSql  = "select pc81_codproc ";  
    $sSql  .= "from pcprocitem "; 
    $sSql  .= "where pc81_solicitem = $pc11_numero "; 

    return $sSql;
  }

  public function queryValorTotalPrecoReferencia($si01_processocompra){
    $sSql = "select pc13_coddot, sum(round(si02_vlprecoreferencia, si01_casasdecimais) * pcdotac.pc13_quant) as valortotal from itemprecoreferencia
             inner join pcorcamitem on si02_itemproccompra = pc22_orcamitem
             inner join precoreferencia on si01_sequencial = si02_precoreferencia
             inner join pcorcamitemproc on pc31_orcamitem = pc22_orcamitem
             inner join pcprocitem on pc31_pcprocitem = pc81_codprocitem
             inner join solicitem on pc81_solicitem = pc11_codigo
             inner join pcdotac on pc13_codigo = pc11_codigo
             where si02_precoreferencia = (select si01_sequencial from precoreferencia
             where si01_processocompra = $si01_processocompra) group by pcdotac.pc13_coddot order by pc13_coddot;";

    return $sSql;

  }
}
?>
