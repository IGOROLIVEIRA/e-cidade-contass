<?
//MODULO: sicom
//CLASSE DA ENTIDADE flpgo102017
class cl_flpgo102017 {
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
    var $si195_sequencial = 0;
    var $si195_tiporegistro = 0;
    var $si195_nrodocumento = 0;
    var $si195_codreduzidopessoa = 0;
    var $si195_regime = null;
    var $si195_indtipopagamento = null;
    var $si195_indsituacaoservidorpensionista = null;
    var $si195_dscsituacao = null;
    var $si195_datconcessaoaposentadoriapensao_dia = null;
    var $si195_datconcessaoaposentadoriapensao_mes = null;
    var $si195_datconcessaoaposentadoriapensao_ano = null;
    var $si195_datconcessaoaposentadoriapensao = null;
    var $si195_dsccargo = null;
    var $si195_sglcargo = null;
    var $si195_dscsiglacargo = null;
    var $si195_reqcargo = 0;
    var $si195_indcessao = null;
    var $si195_dsclotacao = null;
    var $si195_vlrcargahorariasemanal = 0;
    var $si195_datefetexercicio_dia = null;
    var $si195_datefetexercicio_mes = null;
    var $si195_datefetexercicio_ano = null;
    var $si195_datefetexercicio = null;
    var $si195_datexclusao_dia = null;
    var $si195_datexclusao_mes = null;
    var $si195_datexclusao_ano = null;
    var $si195_datexclusao = null;
    var $si195_vlrremuneracaobruta = 0;
    var $si195_natsaldoliquido = null;
    var $si195_vlrremuneracaoliquida = 0;
    var $si195_vlrdeducoes = 0;
    var $si195_mes = 0;
    var $si195_inst = 0;
    // cria propriedade com as variaveis do arquivo 
    var $campos = "
                 si195_sequencial = int8 = si195_sequencial 
                 si195_tiporegistro = int8 = Tipo registro 
                 si195_nrodocumento = int8 = Número do CPF
                 si195_codreduzidopessoa = int8 = Código identificador da pessoa
                 si195_regime = varchar(1) = Civil (C) ou Militar (M) 
                 si195_indtipopagamento = varchar(1) = Tipo de pagamento 
                 si195_indsituacaoservidorpensionista = varchar(1) = Indica a situação do servidor público
                 si195_dscsituacao = varchar(150) = Descrição da situação do servidor público
                 si195_datconcessaoaposentadoriapensao = date = Data de concessão da aposentadoria 
                 si195_dsccargo = varchar(120) = Nome do cargo 
                 si195_sglcargo = varchar(3) = Sigla de Cargo
                 si195_dscsiglacargo = varchar(150) = Descrição do tipo de cargo, função, emprego
                 si195_reqcargo = int8 = Requisito do Cargo 
                 si195_indcessao = varchar(3) = Servidor Cedido com ônus 
                 si195_dsclotacao = varchar(120) = Descrição da lotação 
                 si195_vlrcargahorariasemanal = int8 = Valor da carga horaria 
                 si195_datefetexercicio = date = Data de exercício no cargo 
                 si195_datexclusao = date = Data de exclusão
                 si195_vlrremuneracaobruta = float8 = Valor total dos rendimentos 
                 si195_natsaldoliquido = varchar(1) = Natureza do saldo remuneratório liquido 
                 si195_vlrremuneracaoliquida = float8 = Valor total dos rendimentos liquidos 
                 si195_vlrdeducoes = float8 = Valor das deduções obrigatórias
                 si195_mes = int8 = si195_mes 
                 si195_inst = int8 = si195_inst 
                 ";
    //funcao construtor da classe 
    function cl_flpgo102017() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("flpgo102017");
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
            $this->si195_sequencial = ($this->si195_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_sequencial"]:$this->si195_sequencial);
            $this->si195_tiporegistro = ($this->si195_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_tiporegistro"]:$this->si195_tiporegistro);
            $this->si195_nrodocumento = ($this->si195_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_nrodocumento"]:$this->si195_nrodocumento);
            $this->si195_regime = ($this->si195_regime == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_regime"]:$this->si195_regime);
            $this->si195_indtipopagamento = ($this->si195_indtipopagamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_indtipopagamento"]:$this->si195_indtipopagamento);
            $this->si195_indsituacaoservidorpensionista = ($this->si195_indsituacaoservidorpensionista == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_indsituacaoservidorpensionista"]:$this->si195_indsituacaoservidorpensionista);
            $this->si195_dscsituacao = ($this->si195_dscsituacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_dscsituacao"]:$this->si195_dscsituacao);
            if($this->si195_datconcessaoaposentadoriapensao == ""){
                $this->si195_datconcessaoaposentadoriapensao_dia = ($this->si195_datconcessaoaposentadoriapensao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_datconcessaoaposentadoriapensao_dia"]:$this->si195_datconcessaoaposentadoriapensao_dia);
                $this->si195_datconcessaoaposentadoriapensao_mes = ($this->si195_datconcessaoaposentadoriapensao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_datconcessaoaposentadoriapensao_mes"]:$this->si195_datconcessaoaposentadoriapensao_mes);
                $this->si195_datconcessaoaposentadoriapensao_ano = ($this->si195_datconcessaoaposentadoriapensao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_datconcessaoaposentadoriapensao_ano"]:$this->si195_datconcessaoaposentadoriapensao_ano);
                if($this->si195_datconcessaoaposentadoriapensao_dia != ""){
                    $this->si195_datconcessaoaposentadoriapensao = $this->si195_datconcessaoaposentadoriapensao_ano."-".$this->si195_datconcessaoaposentadoriapensao_mes."-".$this->si195_datconcessaoaposentadoriapensao_dia;
                }
            }
            $this->si195_dsccargo = ($this->si195_dsccargo == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_dsccargo"]:$this->si195_dsccargo);
            $this->si195_sglcargo = ($this->si195_sglcargo == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_sglcargo"]:$this->si195_sglcargo);
            $this->si195_dscsiglacargo = ($this->si195_dscsiglacargo == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_dscsiglacargo"]:$this->si195_dscsiglacargo);
            $this->si195_reqcargo = ($this->si195_reqcargo == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_reqcargo"]:$this->si195_reqcargo);
            $this->si195_indcessao = ($this->si195_indcessao == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_indcessao"]:$this->si195_indcessao);
            $this->si195_dsclotacao = ($this->si195_dsclotacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_dsclotacao"]:$this->si195_dsclotacao);
            $this->si195_vlrcargahorariasemanal = ($this->si195_vlrcargahorariasemanal == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_vlrcargahorariasemanal"]:$this->si195_vlrcargahorariasemanal);
            if($this->si195_datefetexercicio == ""){
                $this->si195_datefetexercicio_dia = ($this->si195_datefetexercicio_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_datefetexercicio_dia"]:$this->si195_datefetexercicio_dia);
                $this->si195_datefetexercicio_mes = ($this->si195_datefetexercicio_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_datefetexercicio_mes"]:$this->si195_datefetexercicio_mes);
                $this->si195_datefetexercicio_ano = ($this->si195_datefetexercicio_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_datefetexercicio_ano"]:$this->si195_datefetexercicio_ano);
                if($this->si195_datefetexercicio_dia != ""){
                    $this->si195_datefetexercicio = $this->si195_datefetexercicio_ano."-".$this->si195_datefetexercicio_mes."-".$this->si195_datefetexercicio_dia;
                }
            }
            if($this->si195_datexclusao == ""){
                $this->si195_datexclusao_dia = ($this->si195_datexclusao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_datexclusao_dia"]:$this->si195_datexclusao_dia);
                $this->si195_datexclusao_mes = ($this->si195_datexclusao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_datexclusao_mes"]:$this->si195_datexclusao_mes);
                $this->si195_datexclusao_ano = ($this->si195_datexclusao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_datexclusao_ano"]:$this->si195_datexclusao_ano);
                if($this->si195_datexclusao_dia != ""){
                    $this->si195_datexclusao = $this->si195_datexclusao_ano."-".$this->si195_datexclusao_mes."-".$this->si195_datexclusao_dia;
                }
            }
            $this->si195_vlrremuneracaobruta = ($this->si195_vlrremuneracaobruta == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_vlrremuneracaobruta"]:$this->si195_vlrremuneracaobruta);
            $this->si195_natsaldoliquido = ($this->si195_natsaldoliquido == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_natsaldoliquido"]:$this->si195_natsaldoliquido);
            $this->si195_vlrremuneracaoliquida = ($this->si195_vlrremuneracaoliquida == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_vlrremuneracaoliquida"]:$this->si195_vlrremuneracaoliquida);
            $this->si195_vlrdeducoes = ($this->si195_vlrdeducoes == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_vlrdeducoes"]:$this->si195_vlrdeducoes);
            $this->si195_mes = ($this->si195_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_mes"]:$this->si195_mes);
            $this->si195_inst = ($this->si195_inst == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_inst"]:$this->si195_inst);
        }else{
            $this->si195_sequencial = ($this->si195_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_sequencial"]:$this->si195_sequencial);
        }
    }
    // funcao para inclusao
    function incluir ($si195_sequencial){
        $this->atualizacampos();

        if($this->si195_tiporegistro == null ){
            $this->erro_sql = " Campo Tipo registro não informado.";
            $this->erro_campo = "si195_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_nrodocumento == null ){
            $this->erro_sql = " Campo Número do CPF não informado.";
            $this->erro_campo = "si195_nrodocumento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_codreduzidopessoa == null ){
            $this->erro_sql = " Campo codigo reduzido pessoa não informado.";
            $this->erro_campo = "si195_nrodocumento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_regime == null ){
            $this->erro_sql = " Campo Civil (C) ou Militar (M) não informado.";
            $this->erro_campo = "si195_regime";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_indtipopagamento == null ){
            $this->erro_sql = " Campo Tipo de pagamento não informado.";
            $this->erro_campo = "si195_indtipopagamento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_indsituacaoservidorpensionista == null ){
            $this->erro_sql = " Campo Indica a situação do servidor público não informado.";
            $this->erro_campo = "si195_indsituacaoservidorpensionista";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_datconcessaoaposentadoriapensao == null ){
            $this->si195_datconcessaoaposentadoriapensao = "null";
        }
        if($this->si195_dsccargo == null ){
            $this->erro_sql = " Campo Nome do cargo não informado.";
            $this->erro_campo = "si195_dsccargo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_sglcargo == null ){
            $this->erro_sql = " Campo Sigla de Cargo não informado. ".$this->si195_codreduzidopessoa;
            $this->erro_campo = "si195_sglcargo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_reqcargo == null ){
            $this->erro_sql = " Campo Requisito do Cargo não informado.";
            $this->erro_campo = "si195_reqcargo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_vlrcargahorariasemanal == null ){
            $this->si195_vlrcargahorariasemanal = "0";
        }
        if($this->si195_datefetexercicio == null ){
            $this->erro_sql = " Campo Data de exercício no cargo não informado.";
            $this->erro_campo = "si195_datefetexercicio_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_datexclusao == null ){
            $this->si195_datexclusao = "null";
        }
        if($this->si195_vlrremuneracaobruta == null ){
            $this->erro_sql = " Campo Valor total dos rendimentos não informado.";
            $this->erro_campo = "si195_vlrremuneracaobruta";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_natsaldoliquido == null ){
            $this->erro_sql = " Campo Natureza do saldo remuneratório liquido não informado.";
            $this->erro_campo = "si195_natsaldoliquido";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_vlrremuneracaoliquida == null ){
            $this->erro_sql = " Campo Valor total dos rendimentos liquidos não informado.";
            $this->erro_campo = "si195_vlrremuneracaoliquida";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_vlrdeducoes == null ){
            $this->erro_sql = " Campo Valor das deduções obrigatórias não informado.";
            $this->erro_campo = "si195_vlrdeducoes";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_mes == null ){
            $this->erro_sql = " Campo si195_mes não informado.";
            $this->erro_campo = "si195_mes";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si195_inst == null ){
            $this->erro_sql = " Campo si195_inst não informado.";
            $this->erro_campo = "si195_inst";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($si195_sequencial == "" || $si195_sequencial == null ){
            $result = db_query("select nextval('flpgo102017_si195_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: flpgo102017_si195_sequencial_seq do campo: si195_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->si195_sequencial = pg_result($result,0,0);
        }else{
            $result = db_query("select last_value from flpgo102017_si195_sequencial_seq");
            if(($result != false) && (pg_result($result,0,0) < $si195_sequencial)){
                $this->erro_sql = " Campo si195_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }else{
                $this->si195_sequencial = $si195_sequencial;
            }
        }
        if(($this->si195_sequencial == null) || ($this->si195_sequencial == "") ){
            $this->erro_sql = " Campo si195_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into flpgo102017(
                                       si195_sequencial 
                                      ,si195_tiporegistro 
                                      ,si195_nrodocumento
                                      ,si195_codreduzidopessoa
                                      ,si195_regime 
                                      ,si195_indtipopagamento 
                                      ,si195_indsituacaoservidorpensionista
                                      ,si195_dscsituacao
                                      ,si195_datconcessaoaposentadoriapensao 
                                      ,si195_dsccargo 
                                      ,si195_sglcargo
                                      ,si195_dscsiglacargo
                                      ,si195_reqcargo 
                                      ,si195_indcessao 
                                      ,si195_dsclotacao 
                                      ,si195_vlrcargahorariasemanal 
                                      ,si195_datefetexercicio 
                                      ,si195_datexclusao
                                      ,si195_vlrremuneracaobruta 
                                      ,si195_natsaldoliquido 
                                      ,si195_vlrremuneracaoliquida 
                                      ,si195_vlrdeducoes
                                      ,si195_mes 
                                      ,si195_inst 
                       )
                values (
                                $this->si195_sequencial 
                               ,$this->si195_tiporegistro 
                               ,'$this->si195_nrodocumento'
                               ,$this->si195_codreduzidopessoa
                               ,'$this->si195_regime' 
                               ,'$this->si195_indtipopagamento' 
                               ,'$this->si195_indsituacaoservidorpensionista'
                               ,'$this->si195_dscsituacao'
                               ,".($this->si195_datconcessaoaposentadoriapensao == "null" || $this->si195_datconcessaoaposentadoriapensao == ""?"null":"'".$this->si195_datconcessaoaposentadoriapensao."'")." 
                               ,'$this->si195_dsccargo' 
                               ,'$this->si195_sglcargo'
                               ,'$this->si195_dscsiglacargo'
                               ,$this->si195_reqcargo 
                               ,'$this->si195_indcessao' 
                               ,'$this->si195_dsclotacao' 
                               ,$this->si195_vlrcargahorariasemanal 
                               ,".($this->si195_datefetexercicio == "null" || $this->si195_datefetexercicio == ""?"null":"'".$this->si195_datefetexercicio."'")." 
                               ,".($this->si195_datexclusao == "null" || $this->si195_datexclusao == ""?"null":"'".$this->si195_datexclusao."'")."
                               ,'$this->si195_vlrremuneracaobruta'
                               ,'$this->si195_natsaldoliquido' 
                               ,'$this->si195_vlrremuneracaoliquida'
                               ,'$this->si195_vlrdeducoes'
                               ,$this->si195_mes 
                               ,$this->si195_inst 
                      )";

        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                $this->erro_sql   = "flpgo102017 ($this->si195_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "flpgo102017 já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }else{
                $this->erro_sql   = "flpgo102017 ($this->si195_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->si195_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            $resaco = $this->sql_record($this->sql_query_file($this->si195_sequencial  ));
            if(($resaco!=false)||($this->numrows!=0)){

                /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,1009276,'$this->si195_sequencial','I')");
                $resac = db_query("insert into db_acount values($acount,1010195,1009276,'','".AddSlashes(pg_result($resaco,0,'si195_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009277,'','".AddSlashes(pg_result($resaco,0,'si195_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009278,'','".AddSlashes(pg_result($resaco,0,'si195_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009279,'','".AddSlashes(pg_result($resaco,0,'si195_regime'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009280,'','".AddSlashes(pg_result($resaco,0,'si195_indtipopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009281,'','".AddSlashes(pg_result($resaco,0,'si195_indsituacaoservidorpensionista'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009282,'','".AddSlashes(pg_result($resaco,0,'si195_datconcessaoaposentadoriapensao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009283,'','".AddSlashes(pg_result($resaco,0,'si195_dsccargo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009284,'','".AddSlashes(pg_result($resaco,0,'si195_sglcargo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009285,'','".AddSlashes(pg_result($resaco,0,'si195_reqcargo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009286,'','".AddSlashes(pg_result($resaco,0,'si195_indcessao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009287,'','".AddSlashes(pg_result($resaco,0,'si195_dsclotacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009288,'','".AddSlashes(pg_result($resaco,0,'si195_vlrcargahorariasemanal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009289,'','".AddSlashes(pg_result($resaco,0,'si195_datefetexercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009290,'','".AddSlashes(pg_result($resaco,0,'si195_datexclusao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009291,'','".AddSlashes(pg_result($resaco,0,'si195_natsaldobruto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009292,'','".AddSlashes(pg_result($resaco,0,'si195_vlrremuneracaobruta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009293,'','".AddSlashes(pg_result($resaco,0,'si195_natsaldoliquido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009294,'','".AddSlashes(pg_result($resaco,0,'si195_vlrremuneracaoliquida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009295,'','".AddSlashes(pg_result($resaco,0,'si195_vlrdeducoes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009297,'','".AddSlashes(pg_result($resaco,0,'si195_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,1009298,'','".AddSlashes(pg_result($resaco,0,'si195_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
            }
        }
        return true;
    }
    // funcao para alteracao
    function alterar ($si195_sequencial=null) {
        $this->atualizacampos();
        $sql = " update flpgo102017 set ";
        $virgula = "";
        if(trim($this->si195_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_sequencial"])){
            $sql  .= $virgula." si195_sequencial = $this->si195_sequencial ";
            $virgula = ",";
            if(trim($this->si195_sequencial) == null ){
                $this->erro_sql = " Campo si195_sequencial não informado.";
                $this->erro_campo = "si195_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_tiporegistro"])){
            $sql  .= $virgula." si195_tiporegistro = $this->si195_tiporegistro ";
            $virgula = ",";
            if(trim($this->si195_tiporegistro) == null ){
                $this->erro_sql = " Campo Tipo registro não informado.";
                $this->erro_campo = "si195_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_nrodocumento"])){
            $sql  .= $virgula." si195_nrodocumento = $this->si195_nrodocumento ";
            $virgula = ",";
            if(trim($this->si195_nrodocumento) == null ){
                $this->erro_sql = " Campo Número do CPF não informado.";
                $this->erro_campo = "si195_nrodocumento";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_regime)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_regime"])){
            $sql  .= $virgula." si195_regime = '$this->si195_regime' ";
            $virgula = ",";
            if(trim($this->si195_regime) == null ){
                $this->erro_sql = " Campo Civil (C) ou Militar (M) não informado.";
                $this->erro_campo = "si195_regime";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_indtipopagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_indtipopagamento"])){
            $sql  .= $virgula." si195_indtipopagamento = '$this->si195_indtipopagamento' ";
            $virgula = ",";
            if(trim($this->si195_indtipopagamento) == null ){
                $this->erro_sql = " Campo Tipo de pagamento não informado.";
                $this->erro_campo = "si195_indtipopagamento";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_indsituacaoservidorpensionista)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_indsituacaoservidorpensionista"])){
            $sql  .= $virgula." si195_indsituacaoservidorpensionista = '$this->si195_indsituacaoservidorpensionista' ";
            $virgula = ",";
            if(trim($this->si195_indsituacaoservidorpensionista) == null ){
                $this->erro_sql = " Campo Indica a situação do servidor público não informado.";
                $this->erro_campo = "si195_indsituacaoservidorpensionista";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_dscsituacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_dscsituacao"])) {
            $sql .= $virgula . " si195_dscsituacao = '$this->si195_dscsituacao' ";
            $virgula = ",";
        }
        if(trim($this->si195_datconcessaoaposentadoriapensao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_datconcessaoaposentadoriapensao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si195_datconcessaoaposentadoriapensao_dia"] !="") ){
            $sql  .= $virgula." si195_datconcessaoaposentadoriapensao = '$this->si195_datconcessaoaposentadoriapensao' ";
            $virgula = ",";
        }     else{
            if(isset($GLOBALS["HTTP_POST_VARS"]["si195_datconcessaoaposentadoriapensao_dia"])){
                $sql  .= $virgula." si195_datconcessaoaposentadoriapensao = null ";
                $virgula = ",";
            }
        }
        if(trim($this->si195_dsccargo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_dsccargo"])){
            $sql  .= $virgula." si195_dsccargo = '$this->si195_dsccargo' ";
            $virgula = ",";
            if(trim($this->si195_dsccargo) == null ){
                $this->erro_sql = " Campo Nome do cargo não informado.";
                $this->erro_campo = "si195_dsccargo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_sglcargo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_sglcargo"])){
            $sql  .= $virgula." si195_sglcargo = '$this->si195_sglcargo' ";
            $virgula = ",";
            if(trim($this->si195_sglcargo) == null ){
                $this->erro_sql = " Campo Sigla de Cargo não informado. ". $this->si195_codreduzidopessoa;
                $this->erro_campo = "si195_sglcargo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_dscsiglacargo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_dscsiglacargo"])){
            $sql  .= $virgula." si195_dscsiglacargo = '$this->si195_dscsiglacargo' ";
            $virgula = ",";
        }
        if(trim($this->si195_reqcargo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_reqcargo"])){
            $sql  .= $virgula." si195_reqcargo = $this->si195_reqcargo ";
            $virgula = ",";
            if(trim($this->si195_reqcargo) == null ){
                $this->erro_sql = " Campo Requisito do Cargo não informado.";
                $this->erro_campo = "si195_reqcargo";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_indcessao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_indcessao"])){
            $sql  .= $virgula." si195_indcessao = '$this->si195_indcessao' ";
            $virgula = ",";
        }
        if(trim($this->si195_dsclotacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_dsclotacao"])){
            $sql  .= $virgula." si195_dsclotacao = '$this->si195_dsclotacao' ";
            $virgula = ",";
        }
        if(trim($this->si195_vlrcargahorariasemanal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_vlrcargahorariasemanal"])){
            if(trim($this->si195_vlrcargahorariasemanal)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si195_vlrcargahorariasemanal"])){
                $this->si195_vlrcargahorariasemanal = "0" ;
            }
            $sql  .= $virgula." si195_vlrcargahorariasemanal = $this->si195_vlrcargahorariasemanal ";
            $virgula = ",";
        }
        if(trim($this->si195_datefetexercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_datefetexercicio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si195_datefetexercicio_dia"] !="") ){
            $sql  .= $virgula." si195_datefetexercicio = '$this->si195_datefetexercicio' ";
            $virgula = ",";
            if(trim($this->si195_datefetexercicio) == null ){
                $this->erro_sql = " Campo Data de exercício no cargo não informado.";
                $this->erro_campo = "si195_datefetexercicio_dia";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }     else{
            if(isset($GLOBALS["HTTP_POST_VARS"]["si195_datefetexercicio_dia"])){
                $sql  .= $virgula." si195_datefetexercicio = null ";
                $virgula = ",";
                if(trim($this->si195_datefetexercicio) == null ){
                    $this->erro_sql = " Campo Data de exercício no cargo não informado.";
                    $this->erro_campo = "si195_datefetexercicio_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }
        if(trim($this->si195_datexclusao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_datexclusao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si195_datexclusao_dia"] !="") ){
            $sql  .= $virgula." si195_datexclusao = '$this->si195_datexclusao' ";
            $virgula = ",";
        }     else{
            if(isset($GLOBALS["HTTP_POST_VARS"]["si195_datexclusao_dia"])){
                $sql  .= $virgula." si195_datexclusao = null ";
                $virgula = ",";
            }
        }
        if(trim($this->si195_vlrremuneracaobruta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_vlrremuneracaobruta"])){
            $sql  .= $virgula." si195_vlrremuneracaobruta = $this->si195_vlrremuneracaobruta ";
            $virgula = ",";
            if(trim($this->si195_vlrremuneracaobruta) == null ){
                $this->erro_sql = " Campo Valor total dos rendimentos não informado.";
                $this->erro_campo = "si195_vlrremuneracaobruta";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_natsaldoliquido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_natsaldoliquido"])){
            $sql  .= $virgula." si195_natsaldoliquido = '$this->si195_natsaldoliquido' ";
            $virgula = ",";
            if(trim($this->si195_natsaldoliquido) == null ){
                $this->erro_sql = " Campo Natureza do saldo remuneratório liquido não informado.";
                $this->erro_campo = "si195_natsaldoliquido";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_vlrremuneracaoliquida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_vlrremuneracaoliquida"])){
            $sql  .= $virgula." si195_vlrremuneracaoliquida = $this->si195_vlrremuneracaoliquida ";
            $virgula = ",";
            if(trim($this->si195_vlrremuneracaoliquida) == null ){
                $this->erro_sql = " Campo Valor total dos rendimentos liquidos não informado.";
                $this->erro_campo = "si195_vlrremuneracaoliquida";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_vlrdeducoes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_vlrdeducoes"])){
            $sql  .= $virgula." si195_vlrdeducoes = $this->si195_vlrdeducoes ";
            $virgula = ",";
            if(trim($this->si195_vlrdeducoes) == null ){
                $this->erro_sql = " Campo Valor das deduções obrigatórias não informado.";
                $this->erro_campo = "si195_vlrdeducoes";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_mes"])){
            $sql  .= $virgula." si195_mes = $this->si195_mes ";
            $virgula = ",";
            if(trim($this->si195_mes) == null ){
                $this->erro_sql = " Campo si195_mes não informado.";
                $this->erro_campo = "si195_mes";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si195_inst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_inst"])){
            $sql  .= $virgula." si195_inst = $this->si195_inst ";
            $virgula = ",";
            if(trim($this->si195_inst) == null ){
                $this->erro_sql = " Campo si195_inst não informado.";
                $this->erro_campo = "si195_inst";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        if($si195_sequencial!=null){
            $sql .= " si195_sequencial = $this->si195_sequencial";
        }
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

            $resaco = $this->sql_record($this->sql_query_file($this->si195_sequencial));
            if($this->numrows>0){

                for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac,0,0);
                    $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                    $resac = db_query("insert into db_acountkey values($acount,1009276,'$this->si195_sequencial','A')");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_sequencial"]) || $this->si195_sequencial != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009276,'".AddSlashes(pg_result($resaco,$conresaco,'si195_sequencial'))."','$this->si195_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_tiporegistro"]) || $this->si195_tiporegistro != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009277,'".AddSlashes(pg_result($resaco,$conresaco,'si195_tiporegistro'))."','$this->si195_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_nrodocumento"]) || $this->si195_nrodocumento != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009278,'".AddSlashes(pg_result($resaco,$conresaco,'si195_nrodocumento'))."','$this->si195_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_regime"]) || $this->si195_regime != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009279,'".AddSlashes(pg_result($resaco,$conresaco,'si195_regime'))."','$this->si195_regime',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_indtipopagamento"]) || $this->si195_indtipopagamento != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009280,'".AddSlashes(pg_result($resaco,$conresaco,'si195_indtipopagamento'))."','$this->si195_indtipopagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_indsituacaoservidorpensionista"]) || $this->si195_indsituacaoservidorpensionista != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009281,'".AddSlashes(pg_result($resaco,$conresaco,'si195_indsituacaoservidorpensionista'))."','$this->si195_indsituacaoservidorpensionista',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_datconcessaoaposentadoriapensao"]) || $this->si195_datconcessaoaposentadoriapensao != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009282,'".AddSlashes(pg_result($resaco,$conresaco,'si195_datconcessaoaposentadoriapensao'))."','$this->si195_datconcessaoaposentadoriapensao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_dsccargo"]) || $this->si195_dsccargo != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009283,'".AddSlashes(pg_result($resaco,$conresaco,'si195_dsccargo'))."','$this->si195_dsccargo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_sglcargo"]) || $this->si195_sglcargo != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009284,'".AddSlashes(pg_result($resaco,$conresaco,'si195_sglcargo'))."','$this->si195_sglcargo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_reqcargo"]) || $this->si195_reqcargo != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009285,'".AddSlashes(pg_result($resaco,$conresaco,'si195_reqcargo'))."','$this->si195_reqcargo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_indcessao"]) || $this->si195_indcessao != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009286,'".AddSlashes(pg_result($resaco,$conresaco,'si195_indcessao'))."','$this->si195_indcessao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_dsclotacao"]) || $this->si195_dsclotacao != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009287,'".AddSlashes(pg_result($resaco,$conresaco,'si195_dsclotacao'))."','$this->si195_dsclotacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_vlrcargahorariasemanal"]) || $this->si195_vlrcargahorariasemanal != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009288,'".AddSlashes(pg_result($resaco,$conresaco,'si195_vlrcargahorariasemanal'))."','$this->si195_vlrcargahorariasemanal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_datefetexercicio"]) || $this->si195_datefetexercicio != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009289,'".AddSlashes(pg_result($resaco,$conresaco,'si195_datefetexercicio'))."','$this->si195_datefetexercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_datexclusao"]) || $this->si195_datexclusao != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009290,'".AddSlashes(pg_result($resaco,$conresaco,'si195_datexclusao'))."','$this->si195_datexclusao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_vlrremuneracaobruta"]) || $this->si195_vlrremuneracaobruta != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009292,'".AddSlashes(pg_result($resaco,$conresaco,'si195_vlrremuneracaobruta'))."','$this->si195_vlrremuneracaobruta',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_natsaldoliquido"]) || $this->si195_natsaldoliquido != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009293,'".AddSlashes(pg_result($resaco,$conresaco,'si195_natsaldoliquido'))."','$this->si195_natsaldoliquido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_vlrremuneracaoliquida"]) || $this->si195_vlrremuneracaoliquida != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009294,'".AddSlashes(pg_result($resaco,$conresaco,'si195_vlrremuneracaoliquida'))."','$this->si195_vlrremuneracaoliquida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_vlrdeducoes"]) || $this->si195_vlrdeducoes != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009295,'".AddSlashes(pg_result($resaco,$conresaco,'si195_vlrdeducoes'))."','$this->si195_vlrdeducoes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_mes"]) || $this->si195_mes != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009297,'".AddSlashes(pg_result($resaco,$conresaco,'si195_mes'))."','$this->si195_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si195_inst"]) || $this->si195_inst != "")
                        $resac = db_query("insert into db_acount values($acount,1010195,1009298,'".AddSlashes(pg_result($resaco,$conresaco,'si195_inst'))."','$this->si195_inst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                }
            }
        }
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "flpgo102017 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->si195_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "flpgo102017 nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->si195_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->si195_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao 
    function excluir ($si195_sequencial=null,$dbwhere=null) {

        /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
          && ($lSessaoDesativarAccount === false))) {
   
          if ($dbwhere==null || $dbwhere=="") {
   
            $resaco = $this->sql_record($this->sql_query_file($si195_sequencial));
          } else { 
            $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
          }
          if (($resaco != false) || ($this->numrows!=0)) {
   
            for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
   
              $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
              $acount = pg_result($resac,0,0);
              $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
              $resac  = db_query("insert into db_acountkey values($acount,1009276,'$si195_sequencial','E')");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009276,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009277,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009278,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009279,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_regime'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009280,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_indtipopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009281,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_indsituacaoservidorpensionista'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009282,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_datconcessaoaposentadoriapensao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009283,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_dsccargo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009284,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_sglcargo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009285,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_reqcargo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009286,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_indcessao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009287,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_dsclotacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009288,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_vlrcargahorariasemanal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009289,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_datefetexercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009290,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_datexclusao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009291,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_natsaldobruto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009292,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_vlrremuneracaobruta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009293,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_natsaldoliquido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009294,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_vlrremuneracaoliquida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009295,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_vlrdeducoes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009297,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
              $resac  = db_query("insert into db_acount values($acount,1010195,1009298,'','".AddSlashes(pg_result($resaco,$iresaco,'si195_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
          }
        }*/
        $sql = " delete from flpgo102017
                    where ";
        $sql2 = "";
        if($dbwhere==null || $dbwhere ==""){
            if($si195_sequencial != ""){
                if($sql2!=""){
                    $sql2 .= " and ";
                }
                $sql2 .= " si195_sequencial = $si195_sequencial ";
            }
        }else{
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "flpgo102017 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$si195_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "flpgo102017 nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$si195_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$si195_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:flpgo102017";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql 
    function sql_query ( $si195_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from flpgo102017 ";
        $sql2 = "";
        if($dbwhere==""){
            if($si195_sequencial!=null ){
                $sql2 .= " where flpgo102017.si195_sequencial = $si195_sequencial ";
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
    function sql_query_file ( $si195_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from flpgo102017 ";
        $sql2 = "";
        if($dbwhere==""){
            if($si195_sequencial!=null ){
                $sql2 .= " where flpgo102017.si195_sequencial = $si195_sequencial ";
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
