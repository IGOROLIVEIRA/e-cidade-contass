<?
//MODULO: sicom
//CLASSE DA ENTIDADE dadoscomplementalrf
class cl_dadoscomplementalrf { 
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
   var $si10_sequencial = 0; 
   var $si10_saldoconsessao = 0; 
   var $si10_receitaprivatizacao = 0; 
   var $si10_instifinacontribuinte = 0; 
   var $si10_valinstituicaofinanc = 0; 
   var $si10_valorcontribuinte = 0; 
   var $si10_valorcompromissado = 0; 
   var $si10_valorliquidado = 0; 
   var $si10_mescompetencia = 0; 
   var $si10_instituicaofinac = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si10_sequencial = int8 = Sequencial 
                 si10_saldoconsessao = float8 = Saldo atual das concessões de Garantias: 
                 si10_receitaprivatizacao = float8 = Receita de Privatização: 
                 si10_instifinacontribuinte = float8 = Valor Inscrito RP não Proc.Contribuinte 
                 si10_valinstituicaofinanc = float8 = Valor concedido Inst.Financeira: 
                 si10_valorcontribuinte = float8 = Valor Liq. Incentivo a Contribuinte: 
                 si10_valorcompromissado = float8 = Total dos valores compromissados: 
                 si10_valorliquidado = float8 = Valor Liquidado 
                 si10_mescompetencia = int8 = Mês de Competência 
                 si10_instituicaofinac = float8 = Valor Inscrito RP não Prc In.Financeira 
                 ";
   //funcao construtor da classe 
   function cl_dadoscomplementalrf() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dadoscomplementalrf"); 
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
       $this->si10_sequencial = ($this->si10_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_sequencial"]:$this->si10_sequencial);
       $this->si10_saldoconsessao = ($this->si10_saldoconsessao == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_saldoconsessao"]:$this->si10_saldoconsessao);
       $this->si10_receitaprivatizacao = ($this->si10_receitaprivatizacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_receitaprivatizacao"]:$this->si10_receitaprivatizacao);
       $this->si10_instifinacontribuinte = ($this->si10_instifinacontribuinte == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_instifinacontribuinte"]:$this->si10_instifinacontribuinte);
       $this->si10_valinstituicaofinanc = ($this->si10_valinstituicaofinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_valinstituicaofinanc"]:$this->si10_valinstituicaofinanc);
       $this->si10_valorcontribuinte = ($this->si10_valorcontribuinte == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_valorcontribuinte"]:$this->si10_valorcontribuinte);
       $this->si10_valorcompromissado = ($this->si10_valorcompromissado == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_valorcompromissado"]:$this->si10_valorcompromissado);
       $this->si10_valorliquidado = ($this->si10_valorliquidado == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_valorliquidado"]:$this->si10_valorliquidado);
       $this->si10_mescompetencia = ($this->si10_mescompetencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_mescompetencia"]:$this->si10_mescompetencia);
       $this->si10_instituicaofinac = ($this->si10_instituicaofinac == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_instituicaofinac"]:$this->si10_instituicaofinac);
     }else{
       $this->si10_sequencial = ($this->si10_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si10_sequencial"]:$this->si10_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si10_sequencial){ 
      $this->atualizacampos();
     if($this->si10_saldoconsessao == null ){ 
       $this->erro_sql = " Campo Saldo atual das concessões de Garantias: nao Informado.";
       $this->erro_campo = "si10_saldoconsessao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si10_receitaprivatizacao == null ){ 
       $this->erro_sql = " Campo Receita de Privatização: nao Informado.";
       $this->erro_campo = "si10_receitaprivatizacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si10_instifinacontribuinte == null ){ 
       $this->erro_sql = " Campo Valor Inscrito RP não Proc.Contribuinte nao Informado.";
       $this->erro_campo = "si10_instifinacontribuinte";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si10_valinstituicaofinanc == null ){ 
       $this->erro_sql = " Campo Valor concedido Inst.Financeira: nao Informado.";
       $this->erro_campo = "si10_valinstituicaofinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si10_valorcontribuinte == null ){ 
       $this->erro_sql = " Campo Valor Liq. Incentivo a Contribuinte: nao Informado.";
       $this->erro_campo = "si10_valorcontribuinte";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si10_valorcompromissado == null ){ 
       $this->erro_sql = " Campo Total dos valores compromissados: nao Informado.";
       $this->erro_campo = "si10_valorcompromissado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si10_valorliquidado == null ){ 
       $this->erro_sql = " Campo Valor Liquidado nao Informado.";
       $this->erro_campo = "si10_valorliquidado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si10_mescompetencia == null ){ 
       $this->erro_sql = " Campo Mês de Competência nao Informado.";
       $this->erro_campo = "si10_mescompetencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si10_instituicaofinac == null ){ 
       $this->erro_sql = " Campo Valor Inscrito RP não Prc In.Financeira nao Informado.";
       $this->erro_campo = "si10_instituicaofinac";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
      
     if(($this->si10_sequencial == null) || ($this->si10_sequencial == "") ){
			$result = db_query("select nextval('sic_dadoscomplementalrf_si10_sequencial')");
			if($result==false){
				$this->erro_banco = str_replace("\n","",@pg_last_error());
				$this->erro_sql   = "Verifique o cadastro da sequencia: sic_dadoscomplementalrf_si10_sequencial do campo: si10_sequencial";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
			$this->si10_sequencial = pg_result($result,0,0);
		}else{
			$result = db_query("select last_value from sic_dadoscomplementalrf_si10_sequencial");
			if(($result != false) && (pg_result($result,0,0) < $si10_sequencial)){
				$this->erro_sql = " Campo si10_sequencial maior que último número da sequencia.";
				$this->erro_banco = "Sequencia menor que este número.";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}else{
				$this->si10_sequencial = $si10_sequencial;
			}
		}
     
     $anousu  = db_getsession("DB_anousu");
     $sql = "insert into dadoscomplementalrf(
                                       si10_sequencial 
                                      ,si10_saldoconsessao 
                                      ,si10_receitaprivatizacao 
                                      ,si10_instifinacontribuinte 
                                      ,si10_valinstituicaofinanc 
                                      ,si10_valorcontribuinte 
                                      ,si10_valorcompromissado 
                                      ,si10_valorliquidado 
                                      ,si10_mescompetencia 
                                      ,si10_instituicaofinac 
                                      ,si10_anocompetencia
                       )
                values (
                                $this->si10_sequencial 
                               ,$this->si10_saldoconsessao 
                               ,$this->si10_receitaprivatizacao 
                               ,$this->si10_instifinacontribuinte 
                               ,$this->si10_valinstituicaofinanc 
                               ,$this->si10_valorcontribuinte 
                               ,$this->si10_valorcompromissado 
                               ,$this->si10_valorliquidado 
                               ,$this->si10_mescompetencia 
                               ,$this->si10_instituicaofinac
                               ,'$anousu' 
                      )"; //echo $sql;exit; 
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Dados complementares LRF ($this->si10_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Dados complementares LRF já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Dados complementares LRF ($this->si10_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si10_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si10_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009499,'$this->si10_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010234,2009499,'','".AddSlashes(pg_result($resaco,0,'si10_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010234,2009500,'','".AddSlashes(pg_result($resaco,0,'si10_saldoconsessao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010234,2009504,'','".AddSlashes(pg_result($resaco,0,'si10_receitaprivatizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010234,2009510,'','".AddSlashes(pg_result($resaco,0,'si10_instifinacontribuinte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010234,2009508,'','".AddSlashes(pg_result($resaco,0,'si10_valinstituicaofinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010234,2009507,'','".AddSlashes(pg_result($resaco,0,'si10_valorcontribuinte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010234,2009503,'','".AddSlashes(pg_result($resaco,0,'si10_valorcompromissado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010234,2009502,'','".AddSlashes(pg_result($resaco,0,'si10_valorliquidado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010234,2009501,'','".AddSlashes(pg_result($resaco,0,'si10_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010234,2009509,'','".AddSlashes(pg_result($resaco,0,'si10_instituicaofinac'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si10_sequencial=null) { 
      $this->atualizacampos();
      $anousu  = db_getsession("DB_anousu");
     $sql = " update dadoscomplementalrf set ";
     $virgula = "";
     if(trim($this->si10_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_sequencial"])){ 
       $sql  .= $virgula." si10_sequencial = $this->si10_sequencial ";
       $sql  .= " ,si10_anocompetencia = '$anousu'";
       $virgula = ",";
       if(trim($this->si10_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "si10_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si10_saldoconsessao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_saldoconsessao"])){ 
       $sql  .= $virgula." si10_saldoconsessao = $this->si10_saldoconsessao ";
       $virgula = ",";
       if(trim($this->si10_saldoconsessao) == null ){ 
         $this->erro_sql = " Campo Saldo atual das concessões de Garantias: nao Informado.";
         $this->erro_campo = "si10_saldoconsessao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si10_receitaprivatizacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_receitaprivatizacao"])){ 
       $sql  .= $virgula." si10_receitaprivatizacao = $this->si10_receitaprivatizacao ";
       $virgula = ",";
       if(trim($this->si10_receitaprivatizacao) == null ){ 
         $this->erro_sql = " Campo Receita de Privatização: nao Informado.";
         $this->erro_campo = "si10_receitaprivatizacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si10_instifinacontribuinte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_instifinacontribuinte"])){ 
       $sql  .= $virgula." si10_instifinacontribuinte = $this->si10_instifinacontribuinte ";
       $virgula = ",";
       if(trim($this->si10_instifinacontribuinte) == null ){ 
         $this->erro_sql = " Campo Valor Inscrito RP não Proc.Contribuinte nao Informado.";
         $this->erro_campo = "si10_instifinacontribuinte";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si10_valinstituicaofinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_valinstituicaofinanc"])){ 
       $sql  .= $virgula." si10_valinstituicaofinanc = $this->si10_valinstituicaofinanc ";
       $virgula = ",";
       if(trim($this->si10_valinstituicaofinanc) == null ){ 
         $this->erro_sql = " Campo Valor concedido Inst.Financeira: nao Informado.";
         $this->erro_campo = "si10_valinstituicaofinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si10_valorcontribuinte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_valorcontribuinte"])){ 
       $sql  .= $virgula." si10_valorcontribuinte = $this->si10_valorcontribuinte ";
       $virgula = ",";
       if(trim($this->si10_valorcontribuinte) == null ){ 
         $this->erro_sql = " Campo Valor Liq. Incentivo a Contribuinte: nao Informado.";
         $this->erro_campo = "si10_valorcontribuinte";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si10_valorcompromissado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_valorcompromissado"])){ 
       $sql  .= $virgula." si10_valorcompromissado = $this->si10_valorcompromissado ";
       $virgula = ",";
       if(trim($this->si10_valorcompromissado) == null ){ 
         $this->erro_sql = " Campo Total dos valores compromissados: nao Informado.";
         $this->erro_campo = "si10_valorcompromissado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si10_valorliquidado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_valorliquidado"])){ 
       $sql  .= $virgula." si10_valorliquidado = $this->si10_valorliquidado ";
       $virgula = ",";
       if(trim($this->si10_valorliquidado) == null ){ 
         $this->erro_sql = " Campo Valor Liquidado nao Informado.";
         $this->erro_campo = "si10_valorliquidado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si10_mescompetencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_mescompetencia"])){ 
       $sql  .= $virgula." si10_mescompetencia = $this->si10_mescompetencia ";
       $virgula = ",";
       if(trim($this->si10_mescompetencia) == null ){ 
         $this->erro_sql = " Campo Mês de Competência nao Informado.";
         $this->erro_campo = "si10_mescompetencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si10_instituicaofinac)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si10_instituicaofinac"])){ 
       $sql  .= $virgula." si10_instituicaofinac = $this->si10_instituicaofinac ";
       $virgula = ",";
       if(trim($this->si10_instituicaofinac) == null ){ 
         $this->erro_sql = " Campo Valor Inscrito RP não Prc In.Financeira nao Informado.";
         $this->erro_campo = "si10_instituicaofinac";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si10_sequencial!=null){
       $sql .= " si10_sequencial = $this->si10_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si10_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009499,'$this->si10_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_sequencial"]) || $this->si10_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009499,'".AddSlashes(pg_result($resaco,$conresaco,'si10_sequencial'))."','$this->si10_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_saldoconsessao"]) || $this->si10_saldoconsessao != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009500,'".AddSlashes(pg_result($resaco,$conresaco,'si10_saldoconsessao'))."','$this->si10_saldoconsessao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_receitaprivatizacao"]) || $this->si10_receitaprivatizacao != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009504,'".AddSlashes(pg_result($resaco,$conresaco,'si10_receitaprivatizacao'))."','$this->si10_receitaprivatizacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_instifinacontribuinte"]) || $this->si10_instifinacontribuinte != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009510,'".AddSlashes(pg_result($resaco,$conresaco,'si10_instifinacontribuinte'))."','$this->si10_instifinacontribuinte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_valinstituicaofinanc"]) || $this->si10_valinstituicaofinanc != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009508,'".AddSlashes(pg_result($resaco,$conresaco,'si10_valinstituicaofinanc'))."','$this->si10_valinstituicaofinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_valorcontribuinte"]) || $this->si10_valorcontribuinte != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009507,'".AddSlashes(pg_result($resaco,$conresaco,'si10_valorcontribuinte'))."','$this->si10_valorcontribuinte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_valorcompromissado"]) || $this->si10_valorcompromissado != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009503,'".AddSlashes(pg_result($resaco,$conresaco,'si10_valorcompromissado'))."','$this->si10_valorcompromissado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_valorliquidado"]) || $this->si10_valorliquidado != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009502,'".AddSlashes(pg_result($resaco,$conresaco,'si10_valorliquidado'))."','$this->si10_valorliquidado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_mescompetencia"]) || $this->si10_mescompetencia != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009501,'".AddSlashes(pg_result($resaco,$conresaco,'si10_mescompetencia'))."','$this->si10_mescompetencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si10_instituicaofinac"]) || $this->si10_instituicaofinac != "")
           $resac = db_query("insert into db_acount values($acount,2010234,2009509,'".AddSlashes(pg_result($resaco,$conresaco,'si10_instituicaofinac'))."','$this->si10_instituicaofinac',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados complementares LRF nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si10_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dados complementares LRF nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si10_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si10_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si10_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si10_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009499,'$si10_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010234,2009499,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010234,2009500,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_saldoconsessao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010234,2009504,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_receitaprivatizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010234,2009510,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_instifinacontribuinte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010234,2009508,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_valinstituicaofinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010234,2009507,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_valorcontribuinte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010234,2009503,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_valorcompromissado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010234,2009502,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_valorliquidado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010234,2009501,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010234,2009509,'','".AddSlashes(pg_result($resaco,$iresaco,'si10_instituicaofinac'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from dadoscomplementalrf
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si10_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si10_sequencial = $si10_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados complementares LRF nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si10_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dados complementares LRF nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si10_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si10_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dadoscomplementalrf";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si10_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select  ";
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
     $sql .= " from dadoscomplementalrf ";
     $sql2 = "";
     if($dbwhere==""){
       if($si10_sequencial!=null ){
         $sql2 .= " where dadoscomplementalrf.si10_sequencial = $si10_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by si10_mescompetencia,si10_anocompetencia";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }//echo $sql;exit;
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $si10_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dadoscomplementalrf ";
     $sql2 = "";
     if($dbwhere==""){
       if($si10_sequencial!=null ){
         $sql2 .= " where dadoscomplementalrf.si10_sequencial = $si10_sequencial "; 
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
}
?>
