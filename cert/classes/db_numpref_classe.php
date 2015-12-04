<?
//MODULO: caixa
//CLASSE DA ENTIDADE numpref
class cl_numpref { 
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
   var $k03_anousu = 0; 
   var $k03_numpre = 0; 
   var $k03_defope = 0; 
   var $k03_recjur = 0; 
   var $k03_numsli = 0; 
   var $k03_impend = 'f'; 
   var $k03_unipri = 'f'; 
   var $k03_codbco = 0; 
   var $k03_codage = null; 
   var $k03_recmul = 0; 
   var $k03_calrec = 'f'; 
   var $k03_msg = null; 
   var $k03_msgcarne = null; 
   var $k03_msgbanco = null; 
   var $k03_certissvar = 'f'; 
   var $k03_diasjust = 0; 
   var $k03_reccert = 'f'; 
   var $k03_taxagrupo = 0; 
   var $k03_tipocodcert = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 k03_anousu = int4 = Exercício 
                 k03_numpre = int4 = Numeração 
                 k03_defope = int4 = Operação 
                 k03_recjur = int4 = Receita Juros 
                 k03_numsli = int4 = Slip 
                 k03_impend = bool = Imprime Endereço 
                 k03_unipri = bool = Única/Primeira 
                 k03_codbco = int4 = Banco 
                 k03_codage = char(5) = Agência 
                 k03_recmul = int4 = Receita Multa 
                 k03_calrec = bool = Receita Cálculo 
                 k03_msg = text = Mensagem 
                 k03_msgcarne = text = Mensagem exibida no carne 
                 k03_msgbanco = text = Mensagem do local de pagamento exibida no carne 
                 k03_certissvar = bool = Libera Variável 
                 k03_diasjust = int4 = Dias Justif. 
                 k03_reccert = bool = Recibo na certidão 
                 k03_taxagrupo = int4 = Código do grupo de taxas 
                 k03_tipocodcert = int4 = Tipo de Codificação 
                 ";
   //funcao construtor da classe 
   function cl_numpref() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("numpref"); 
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
       $this->k03_anousu = ($this->k03_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_anousu"]:$this->k03_anousu);
       $this->k03_numpre = ($this->k03_numpre == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_numpre"]:$this->k03_numpre);
       $this->k03_defope = ($this->k03_defope == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_defope"]:$this->k03_defope);
       $this->k03_recjur = ($this->k03_recjur == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_recjur"]:$this->k03_recjur);
       $this->k03_numsli = ($this->k03_numsli == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_numsli"]:$this->k03_numsli);
       $this->k03_impend = ($this->k03_impend == "f"?@$GLOBALS["HTTP_POST_VARS"]["k03_impend"]:$this->k03_impend);
       $this->k03_unipri = ($this->k03_unipri == "f"?@$GLOBALS["HTTP_POST_VARS"]["k03_unipri"]:$this->k03_unipri);
       $this->k03_codbco = ($this->k03_codbco == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_codbco"]:$this->k03_codbco);
       $this->k03_codage = ($this->k03_codage == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_codage"]:$this->k03_codage);
       $this->k03_recmul = ($this->k03_recmul == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_recmul"]:$this->k03_recmul);
       $this->k03_calrec = ($this->k03_calrec == "f"?@$GLOBALS["HTTP_POST_VARS"]["k03_calrec"]:$this->k03_calrec);
       $this->k03_msg = ($this->k03_msg == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_msg"]:$this->k03_msg);
       $this->k03_msgcarne = ($this->k03_msgcarne == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_msgcarne"]:$this->k03_msgcarne);
       $this->k03_msgbanco = ($this->k03_msgbanco == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_msgbanco"]:$this->k03_msgbanco);
       $this->k03_certissvar = ($this->k03_certissvar == "f"?@$GLOBALS["HTTP_POST_VARS"]["k03_certissvar"]:$this->k03_certissvar);
       $this->k03_diasjust = ($this->k03_diasjust == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_diasjust"]:$this->k03_diasjust);
       $this->k03_reccert = ($this->k03_reccert == "f"?@$GLOBALS["HTTP_POST_VARS"]["k03_reccert"]:$this->k03_reccert);
       $this->k03_taxagrupo = ($this->k03_taxagrupo == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_taxagrupo"]:$this->k03_taxagrupo);
       $this->k03_tipocodcert = ($this->k03_tipocodcert == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_tipocodcert"]:$this->k03_tipocodcert);
     }else{
       $this->k03_anousu = ($this->k03_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["k03_anousu"]:$this->k03_anousu);
     }
   }
   // funcao para inclusao
   function incluir ($k03_anousu){ 
      $this->atualizacampos();
     if($this->k03_numpre == null ){ 
       $this->k03_numpre = "0";
     }
     if($this->k03_defope == null ){ 
       $this->erro_sql = " Campo Operação nao Informado.";
       $this->erro_campo = "k03_defope";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_recjur == null ){ 
       $this->erro_sql = " Campo Receita Juros nao Informado.";
       $this->erro_campo = "k03_recjur";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_numsli == null ){ 
       $this->erro_sql = " Campo Slip nao Informado.";
       $this->erro_campo = "k03_numsli";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_impend == null ){ 
       $this->erro_sql = " Campo Imprime Endereço nao Informado.";
       $this->erro_campo = "k03_impend";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_unipri == null ){ 
       $this->erro_sql = " Campo Única/Primeira nao Informado.";
       $this->erro_campo = "k03_unipri";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_codbco == null ){ 
       $this->erro_sql = " Campo Banco nao Informado.";
       $this->erro_campo = "k03_codbco";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_codage == null ){ 
       $this->erro_sql = " Campo Agência nao Informado.";
       $this->erro_campo = "k03_codage";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_recmul == null ){ 
       $this->erro_sql = " Campo Receita Multa nao Informado.";
       $this->erro_campo = "k03_recmul";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_calrec == null ){ 
       $this->erro_sql = " Campo Receita Cálculo nao Informado.";
       $this->erro_campo = "k03_calrec";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_msg == null ){ 
       $this->erro_sql = " Campo Mensagem nao Informado.";
       $this->erro_campo = "k03_msg";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_msgcarne == null ){ 
       $this->erro_sql = " Campo Mensagem exibida no carne nao Informado.";
       $this->erro_campo = "k03_msgcarne";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_msgbanco == null ){ 
       $this->erro_sql = " Campo Mensagem do local de pagamento exibida no carne nao Informado.";
       $this->erro_campo = "k03_msgbanco";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_certissvar == null ){ 
       $this->erro_sql = " Campo Libera Variável nao Informado.";
       $this->erro_campo = "k03_certissvar";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_diasjust == null ){ 
       $this->erro_sql = " Campo Dias Justif. nao Informado.";
       $this->erro_campo = "k03_diasjust";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_reccert == null ){ 
       $this->erro_sql = " Campo Recibo na certidão nao Informado.";
       $this->erro_campo = "k03_reccert";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_taxagrupo == null ){ 
       $this->erro_sql = " Campo Código do grupo de taxas nao Informado.";
       $this->erro_campo = "k03_taxagrupo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k03_tipocodcert == null ){ 
       $this->erro_sql = " Campo Tipo de Codificação nao Informado.";
       $this->erro_campo = "k03_tipocodcert";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($k03_numpre == "" || $k03_numpre == null ){
       $result = @pg_query("select nextval('numpref_k03_numpre_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: numpref_k03_numpre_seq do campo: k03_numpre"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->k03_numpre = pg_result($result,0,0); 
     }else{
       $result = @pg_query("select last_value from numpref_k03_numpre_seq");
       if(($result != false) && (pg_result($result,0,0) < $k03_numpre)){
         $this->erro_sql = " Campo k03_numpre maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->k03_numpre = $k03_numpre; 
       }
     }
     if(($this->k03_anousu == null) || ($this->k03_anousu == "") ){ 
       $this->erro_sql = " Campo k03_anousu nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into numpref(
                                       k03_anousu 
                                      ,k03_numpre 
                                      ,k03_defope 
                                      ,k03_recjur 
                                      ,k03_numsli 
                                      ,k03_impend 
                                      ,k03_unipri 
                                      ,k03_codbco 
                                      ,k03_codage 
                                      ,k03_recmul 
                                      ,k03_calrec 
                                      ,k03_msg 
                                      ,k03_msgcarne 
                                      ,k03_msgbanco 
                                      ,k03_certissvar 
                                      ,k03_diasjust 
                                      ,k03_reccert 
                                      ,k03_taxagrupo 
                                      ,k03_tipocodcert 
                       )
                values (
                                $this->k03_anousu 
                               ,$this->k03_numpre 
                               ,$this->k03_defope 
                               ,$this->k03_recjur 
                               ,$this->k03_numsli 
                               ,'$this->k03_impend' 
                               ,'$this->k03_unipri' 
                               ,$this->k03_codbco 
                               ,'$this->k03_codage' 
                               ,$this->k03_recmul 
                               ,'$this->k03_calrec' 
                               ,'$this->k03_msg' 
                               ,'$this->k03_msgcarne' 
                               ,'$this->k03_msgbanco' 
                               ,'$this->k03_certissvar' 
                               ,$this->k03_diasjust 
                               ,'$this->k03_reccert' 
                               ,$this->k03_taxagrupo 
                               ,$this->k03_tipocodcert 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Numerações ($this->k03_anousu) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Numerações já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Numerações ($this->k03_anousu) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k03_anousu;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->k03_anousu));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,1904,'$this->k03_anousu','I')");
       $resac = pg_query("insert into db_acount values($acount,318,1904,'','".AddSlashes(pg_result($resaco,0,'k03_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1905,'','".AddSlashes(pg_result($resaco,0,'k03_numpre'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1906,'','".AddSlashes(pg_result($resaco,0,'k03_defope'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1907,'','".AddSlashes(pg_result($resaco,0,'k03_recjur'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1908,'','".AddSlashes(pg_result($resaco,0,'k03_numsli'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1909,'','".AddSlashes(pg_result($resaco,0,'k03_impend'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1910,'','".AddSlashes(pg_result($resaco,0,'k03_unipri'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1911,'','".AddSlashes(pg_result($resaco,0,'k03_codbco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1912,'','".AddSlashes(pg_result($resaco,0,'k03_codage'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1913,'','".AddSlashes(pg_result($resaco,0,'k03_recmul'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1914,'','".AddSlashes(pg_result($resaco,0,'k03_calrec'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,1915,'','".AddSlashes(pg_result($resaco,0,'k03_msg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,7918,'','".AddSlashes(pg_result($resaco,0,'k03_msgcarne'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,7925,'','".AddSlashes(pg_result($resaco,0,'k03_msgbanco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,7943,'','".AddSlashes(pg_result($resaco,0,'k03_certissvar'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,8737,'','".AddSlashes(pg_result($resaco,0,'k03_diasjust'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,8797,'','".AddSlashes(pg_result($resaco,0,'k03_reccert'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,8799,'','".AddSlashes(pg_result($resaco,0,'k03_taxagrupo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,318,9419,'','".AddSlashes(pg_result($resaco,0,'k03_tipocodcert'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($k03_anousu=null) { 
      $this->atualizacampos();
     $sql = " update numpref set ";
     $virgula = "";
     if(trim($this->k03_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_anousu"])){ 
       $sql  .= $virgula." k03_anousu = $this->k03_anousu ";
       $virgula = ",";
       if(trim($this->k03_anousu) == null ){ 
         $this->erro_sql = " Campo Exercício nao Informado.";
         $this->erro_campo = "k03_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_numpre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_numpre"])){ 
        if(trim($this->k03_numpre)=="" && isset($GLOBALS["HTTP_POST_VARS"]["k03_numpre"])){ 
           $this->k03_numpre = "0" ; 
        } 
       $sql  .= $virgula." k03_numpre = $this->k03_numpre ";
       $virgula = ",";
     }
     if(trim($this->k03_defope)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_defope"])){ 
       $sql  .= $virgula." k03_defope = $this->k03_defope ";
       $virgula = ",";
       if(trim($this->k03_defope) == null ){ 
         $this->erro_sql = " Campo Operação nao Informado.";
         $this->erro_campo = "k03_defope";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_recjur)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_recjur"])){ 
       $sql  .= $virgula." k03_recjur = $this->k03_recjur ";
       $virgula = ",";
       if(trim($this->k03_recjur) == null ){ 
         $this->erro_sql = " Campo Receita Juros nao Informado.";
         $this->erro_campo = "k03_recjur";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_numsli)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_numsli"])){ 
       $sql  .= $virgula." k03_numsli = $this->k03_numsli ";
       $virgula = ",";
       if(trim($this->k03_numsli) == null ){ 
         $this->erro_sql = " Campo Slip nao Informado.";
         $this->erro_campo = "k03_numsli";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_impend)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_impend"])){ 
       $sql  .= $virgula." k03_impend = '$this->k03_impend' ";
       $virgula = ",";
       if(trim($this->k03_impend) == null ){ 
         $this->erro_sql = " Campo Imprime Endereço nao Informado.";
         $this->erro_campo = "k03_impend";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_unipri)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_unipri"])){ 
       $sql  .= $virgula." k03_unipri = '$this->k03_unipri' ";
       $virgula = ",";
       if(trim($this->k03_unipri) == null ){ 
         $this->erro_sql = " Campo Única/Primeira nao Informado.";
         $this->erro_campo = "k03_unipri";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_codbco)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_codbco"])){ 
       $sql  .= $virgula." k03_codbco = $this->k03_codbco ";
       $virgula = ",";
       if(trim($this->k03_codbco) == null ){ 
         $this->erro_sql = " Campo Banco nao Informado.";
         $this->erro_campo = "k03_codbco";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_codage)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_codage"])){ 
       $sql  .= $virgula." k03_codage = '$this->k03_codage' ";
       $virgula = ",";
       if(trim($this->k03_codage) == null ){ 
         $this->erro_sql = " Campo Agência nao Informado.";
         $this->erro_campo = "k03_codage";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_recmul)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_recmul"])){ 
       $sql  .= $virgula." k03_recmul = $this->k03_recmul ";
       $virgula = ",";
       if(trim($this->k03_recmul) == null ){ 
         $this->erro_sql = " Campo Receita Multa nao Informado.";
         $this->erro_campo = "k03_recmul";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_calrec)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_calrec"])){ 
       $sql  .= $virgula." k03_calrec = '$this->k03_calrec' ";
       $virgula = ",";
       if(trim($this->k03_calrec) == null ){ 
         $this->erro_sql = " Campo Receita Cálculo nao Informado.";
         $this->erro_campo = "k03_calrec";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_msg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_msg"])){ 
       $sql  .= $virgula." k03_msg = '$this->k03_msg' ";
       $virgula = ",";
       if(trim($this->k03_msg) == null ){ 
         $this->erro_sql = " Campo Mensagem nao Informado.";
         $this->erro_campo = "k03_msg";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_msgcarne)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_msgcarne"])){ 
       $sql  .= $virgula." k03_msgcarne = '$this->k03_msgcarne' ";
       $virgula = ",";
       if(trim($this->k03_msgcarne) == null ){ 
         $this->erro_sql = " Campo Mensagem exibida no carne nao Informado.";
         $this->erro_campo = "k03_msgcarne";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_msgbanco)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_msgbanco"])){ 
       $sql  .= $virgula." k03_msgbanco = '$this->k03_msgbanco' ";
       $virgula = ",";
       if(trim($this->k03_msgbanco) == null ){ 
         $this->erro_sql = " Campo Mensagem do local de pagamento exibida no carne nao Informado.";
         $this->erro_campo = "k03_msgbanco";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_certissvar)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_certissvar"])){ 
       $sql  .= $virgula." k03_certissvar = '$this->k03_certissvar' ";
       $virgula = ",";
       if(trim($this->k03_certissvar) == null ){ 
         $this->erro_sql = " Campo Libera Variável nao Informado.";
         $this->erro_campo = "k03_certissvar";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_diasjust)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_diasjust"])){ 
       $sql  .= $virgula." k03_diasjust = $this->k03_diasjust ";
       $virgula = ",";
       if(trim($this->k03_diasjust) == null ){ 
         $this->erro_sql = " Campo Dias Justif. nao Informado.";
         $this->erro_campo = "k03_diasjust";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_reccert)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_reccert"])){ 
       $sql  .= $virgula." k03_reccert = '$this->k03_reccert' ";
       $virgula = ",";
       if(trim($this->k03_reccert) == null ){ 
         $this->erro_sql = " Campo Recibo na certidão nao Informado.";
         $this->erro_campo = "k03_reccert";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_taxagrupo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_taxagrupo"])){ 
       $sql  .= $virgula." k03_taxagrupo = $this->k03_taxagrupo ";
       $virgula = ",";
       if(trim($this->k03_taxagrupo) == null ){ 
         $this->erro_sql = " Campo Código do grupo de taxas nao Informado.";
         $this->erro_campo = "k03_taxagrupo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k03_tipocodcert)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k03_tipocodcert"])){ 
       $sql  .= $virgula." k03_tipocodcert = $this->k03_tipocodcert ";
       $virgula = ",";
       if(trim($this->k03_tipocodcert) == null ){ 
         $this->erro_sql = " Campo Tipo de Codificação nao Informado.";
         $this->erro_campo = "k03_tipocodcert";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($k03_anousu!=null){
       $sql .= " k03_anousu = $this->k03_anousu";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->k03_anousu));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,1904,'$this->k03_anousu','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_anousu"]))
           $resac = pg_query("insert into db_acount values($acount,318,1904,'".AddSlashes(pg_result($resaco,$conresaco,'k03_anousu'))."','$this->k03_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_numpre"]))
           $resac = pg_query("insert into db_acount values($acount,318,1905,'".AddSlashes(pg_result($resaco,$conresaco,'k03_numpre'))."','$this->k03_numpre',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_defope"]))
           $resac = pg_query("insert into db_acount values($acount,318,1906,'".AddSlashes(pg_result($resaco,$conresaco,'k03_defope'))."','$this->k03_defope',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_recjur"]))
           $resac = pg_query("insert into db_acount values($acount,318,1907,'".AddSlashes(pg_result($resaco,$conresaco,'k03_recjur'))."','$this->k03_recjur',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_numsli"]))
           $resac = pg_query("insert into db_acount values($acount,318,1908,'".AddSlashes(pg_result($resaco,$conresaco,'k03_numsli'))."','$this->k03_numsli',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_impend"]))
           $resac = pg_query("insert into db_acount values($acount,318,1909,'".AddSlashes(pg_result($resaco,$conresaco,'k03_impend'))."','$this->k03_impend',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_unipri"]))
           $resac = pg_query("insert into db_acount values($acount,318,1910,'".AddSlashes(pg_result($resaco,$conresaco,'k03_unipri'))."','$this->k03_unipri',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_codbco"]))
           $resac = pg_query("insert into db_acount values($acount,318,1911,'".AddSlashes(pg_result($resaco,$conresaco,'k03_codbco'))."','$this->k03_codbco',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_codage"]))
           $resac = pg_query("insert into db_acount values($acount,318,1912,'".AddSlashes(pg_result($resaco,$conresaco,'k03_codage'))."','$this->k03_codage',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_recmul"]))
           $resac = pg_query("insert into db_acount values($acount,318,1913,'".AddSlashes(pg_result($resaco,$conresaco,'k03_recmul'))."','$this->k03_recmul',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_calrec"]))
           $resac = pg_query("insert into db_acount values($acount,318,1914,'".AddSlashes(pg_result($resaco,$conresaco,'k03_calrec'))."','$this->k03_calrec',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_msg"]))
           $resac = pg_query("insert into db_acount values($acount,318,1915,'".AddSlashes(pg_result($resaco,$conresaco,'k03_msg'))."','$this->k03_msg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_msgcarne"]))
           $resac = pg_query("insert into db_acount values($acount,318,7918,'".AddSlashes(pg_result($resaco,$conresaco,'k03_msgcarne'))."','$this->k03_msgcarne',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_msgbanco"]))
           $resac = pg_query("insert into db_acount values($acount,318,7925,'".AddSlashes(pg_result($resaco,$conresaco,'k03_msgbanco'))."','$this->k03_msgbanco',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_certissvar"]))
           $resac = pg_query("insert into db_acount values($acount,318,7943,'".AddSlashes(pg_result($resaco,$conresaco,'k03_certissvar'))."','$this->k03_certissvar',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_diasjust"]))
           $resac = pg_query("insert into db_acount values($acount,318,8737,'".AddSlashes(pg_result($resaco,$conresaco,'k03_diasjust'))."','$this->k03_diasjust',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_reccert"]))
           $resac = pg_query("insert into db_acount values($acount,318,8797,'".AddSlashes(pg_result($resaco,$conresaco,'k03_reccert'))."','$this->k03_reccert',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_taxagrupo"]))
           $resac = pg_query("insert into db_acount values($acount,318,8799,'".AddSlashes(pg_result($resaco,$conresaco,'k03_taxagrupo'))."','$this->k03_taxagrupo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k03_tipocodcert"]))
           $resac = pg_query("insert into db_acount values($acount,318,9419,'".AddSlashes(pg_result($resaco,$conresaco,'k03_tipocodcert'))."','$this->k03_tipocodcert',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Numerações nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k03_anousu;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Numerações nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k03_anousu;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k03_anousu;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($k03_anousu=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($k03_anousu));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,1904,'$k03_anousu','E')");
         $resac = pg_query("insert into db_acount values($acount,318,1904,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1905,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_numpre'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1906,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_defope'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1907,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_recjur'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1908,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_numsli'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1909,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_impend'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1910,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_unipri'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1911,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_codbco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1912,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_codage'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1913,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_recmul'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1914,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_calrec'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,1915,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_msg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,7918,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_msgcarne'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,7925,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_msgbanco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,7943,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_certissvar'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,8737,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_diasjust'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,8797,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_reccert'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,8799,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_taxagrupo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,318,9419,'','".AddSlashes(pg_result($resaco,$iresaco,'k03_tipocodcert'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from numpref
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($k03_anousu != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " k03_anousu = $k03_anousu ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Numerações nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$k03_anousu;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Numerações nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$k03_anousu;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$k03_anousu;
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
     $result = @pg_query($sql);
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
        $this->erro_sql   = "Record Vazio na Tabela:numpref";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $k03_anousu=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from numpref ";
     $sql .= "      inner join taxagrupo  on  taxagrupo.k06_taxagrupo = numpref.k03_taxagrupo";
     $sql2 = "";
     if($dbwhere==""){
       if($k03_anousu!=null ){
         $sql2 .= " where numpref.k03_anousu = $k03_anousu "; 
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
   function sql_query_file ( $k03_anousu=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from numpref ";
     $sql2 = "";
     if($dbwhere==""){
       if($k03_anousu!=null ){
         $sql2 .= " where numpref.k03_anousu = $k03_anousu "; 
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
   function sql_numpre(){
    $result = @pg_query("select nextval('numpref_k03_numpre_seq')");
     return pg_result($result,0,0);
  }
}
?>
