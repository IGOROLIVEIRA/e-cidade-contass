<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se não, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: contabilidade
//CLASSE DA ENTIDADE dipr
class cl_dipr
{
    // cria variaveis de erro
    var $rotulo     = null;
    var $query_sql  = null;
    var $numrows    = 0;
    var $numrows_incluir = 0;
    var $numrows_alterar = 0;
    var $numrows_excluir = 0;
    var $erro_status = null;
    var $erro_sql   = null;
    var $erro_banco = null;
    var $erro_msg   = null;
    var $erro_campo = null;
    var $pagina_retorno = null;
    // cria variaveis do arquivo
    var $c236_sequencial = 0;
    var $c236_codhist = 0;
    var $c236_compl = 'f';
    var $c236_descr = null;
    var $c236_dtatonormacrirpps = null;
    var $c236_dtatonormacrirpps_dia = null;
    var $c236_dtatonormacrirpps_mes = null;
    var $c236_dtatonormacrirpps_ano = null;
    var $c236_tipocadastro = 0;
    var $c236_nroatonormasegremassa = 0;
    var $c236_dtatonormasegremassa = null;
    var $c236_dtatonormasegremassa_dia = null;
    var $c236_dtatonormasegremassa_mes= null;
    var $c236_dtatonormasegremassa_ano = null;
    var $c236_planodefatuarial = null;
    var $c236_atonormplanodefat = 0;
    var $c236_dtatoplanodefat = null;
    var $c236_dtatoplanodefat_dia = null;
    var $c236_dtatoplanodefat_mes = null;
    var $c236_dtatoplanodefat_ano = null;
    var $c236_orgao = 0;
    var $c236_massainstituida = 0;
    var $c236_beneficiotesouro = 0;
    var $c236_atonormativo = 0;
    var $c236_exercicionormativo = 0;
    var $c236_numcgmexecutivo = 0;
    var $c236_numcgmlegislativo = 0;
    var $c236_numcgmgestora = 0;
    var $c236_numcgmautarquia = 0;
    var $c236_coddipr = 0;
    var $nomeTabela = "dipr";
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        c236_coddipr int4 NOT NULL,
        c236_orgao int8,
        c236_massainstituida bool,
        c236_beneficiotesouro bool,
        c236_atonormativo int8,
        c236_exercicionormativo int4,
        c236_numcgmexecutivo int8,
        c236_numcgmlegislativo int8,
        c236_numcgmgestora int8,
        c236_numcgmautarquia int8,
        c236_tipocadastro int8, 
        c236_dtatonormacrirpps date,
        c236_nroatonormasegremassa int8,
        c236_dtatonormasegremassa date,
        c236_planodefatuarial int8,
        c236_atonormplanodefat int8,
        c236_dtatoplanodefat date";

    //funcao construtor da classe
    function cl_dipr()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo($this->nomeTabela);
        $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
    }

    //funcao erro
    function erro($mostra, $retorna)
    {
        if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
            echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
            if ($retorna == true) {
                echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
            }
        }
    }

    // funcao para atualizar campos
    function atualizacampos($exclusao = false)
    {
        $this->c236_coddipr = ($this->c236_coddipr == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_coddipr"] : $this->c236_coddipr);
        if ($exclusao == false) {
            $this->c236_orgao = ($this->c236_orgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_orgao"] : $this->c236_orgao);
            $this->c236_massainstituida = ($this->c236_massainstituida == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_massainstituida"] : $this->c236_massainstituida);
            $this->c236_beneficiotesouro = ($this->c236_beneficiotesouro == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_beneficiotesouro"] : $this->c236_beneficiotesouro);
            $this->c236_atonormativo = ($this->c236_atonormativo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_atonormativo"] : $this->c236_atonormativo);
            $this->c236_exercicionormativo = ($this->c236_exercicionormativo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_exercicionormativo"] : $this->c236_exercicionormativo);
            $this->c236_numcgmexecutivo = ($this->c236_numcgmexecutivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_numcgmexecutivo"] : $this->c236_numcgmexecutivo);
            $this->c236_numcgmlegislativo = ($this->c236_numcgmlegislativo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_numcgmlegislativo"] : $this->c236_numcgmlegislativo);
            $this->c236_numcgmgestora = ($this->c236_numcgmgestora == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_numcgmgestora"] : $this->c236_numcgmgestora);
            $this->c236_numcgmautarquia = ($this->c236_numcgmautarquia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_numcgmautarquia"] : $this->c236_numcgmautarquia);
            $this->c236_tipocadastro = ($this->c236_tipocadastro == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_tipocadastro"] : $this->c236_tipocadastro);
            if ($this->c236_dtatonormacrirpps == "") {
                $this->c236_dtatonormacrirpps_dia = ($this->c236_dtatonormacrirpps_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_dtatonormacrirpps_dia"] : $this->c236_dtatonormacrirpps_dia);
                $this->c236_dtatonormacrirpps_mes = ($this->c236_dtatonormacrirpps_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_dtatonormacrirpps_mes"] : $this->c236_dtatonormacrirpps_mes);
                $this->c236_dtatonormacrirpps_ano = ($this->c236_dtatonormacrirpps_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_dtatonormacrirpps_ano"] : $this->c236_dtatonormacrirpps_ano);
                if ($this->c236_dtatonormacrirpps_dia != "") {
                    $this->c236_dtatonormacrirpps = $this->c236_dtatonormacrirpps_ano . "-" . $this->c236_dtatonormacrirpps_mes . "-" . $this->c236_dtatonormacrirpps_dia;
                }
            }
            $this->c236_nroatonormasegremassa = ($this->c236_nroatonormasegremassa == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_nroatonormasegremassa"] : $this->c236_nroatonormasegremassa);
            if ($this->c236_dtatonormasegremassa == "") {
                $this->c236_dtatonormasegremassa_dia = ($this->c236_dtatonormasegremassa_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_dtatonormasegremassa_dia"] : $this->c236_dtatonormasegremassa_dia);
                $this->c236_dtatonormasegremassa_mes = ($this->c236_dtatonormasegremassa_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_dtatonormasegremassa_mes"] : $this->c236_dtatonormasegremassa_mes);
                $this->c236_dtatonormasegremassa_ano = ($this->c236_dtatonormasegremassa_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_dtatonormasegremassa_ano"] : $this->c236_dtatonormasegremassa_ano);
                if ($this->c236_dtatonormasegremassa_dia != "") {
                    $this->c236_dtatonormasegremassa = $this->c236_dtatonormasegremassa_ano . "-" . $this->c236_dtatonormasegremassa_mes . "-" . $this->c236_dtatonormasegremassa_dia;
                }
            }
            $this->c236_planodefatuarial = ($this->c236_planodefatuarial == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_planodefatuarial"] : $this->c236_planodefatuarial);
            $this->c236_atonormplanodefat = ($this->c236_atonormplanodefat == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_atonormplanodefat"] : $this->c236_atonormplanodefat);
            if ($this->c236_dtatoplanodefat == "") {
                $this->c236_dtatoplanodefat_dia = ($this->c236_dtatoplanodefat_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_dtatoplanodefat_dia"] : $this->c236_dtatoplanodefat_dia);
                $this->c236_dtatoplanodefat_mes = ($this->c236_dtatoplanodefat_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_dtatoplanodefat_mes"] : $this->c236_dtatoplanodefat_mes);
                $this->c236_dtatoplanodefat_ano = ($this->c236_dtatoplanodefat_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["c236_dtatoplanodefat_ano"] : $this->c236_dtatoplanodefat_ano);
                if ($this->c236_dtatoplanodefat_dia != "") {
                    $this->c236_dtatoplanodefat = $this->c236_dtatoplanodefat_ano . "-" . $this->c236_dtatoplanodefat_mes . "-" . $this->c236_dtatoplanodefat_dia;
                }
            }
        }
    }

    // Condição que não permite salvar os dados caso a massa instituída por lei seja sim
    public function verificarCondicaoMassaInstituidaPorLei($nomeCampo)
    {
        if ($this->c236_massainstituida === "f") {
            $this->$nomeCampo = "null";
            return;
        }
        $this->$nomeCampo = ($this->nomeCampo == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampo] : $this->$nomeCampo);
    }

    // funcao para Inclusão
    function incluir()
    {
        $this->atualizacampos();
        if (!$this->verificaOrgao())
            return false;

        if (!$this->verificaMassaInstituida())
            return false;

        if (!$this->verificaBeneficioTesouro())
            return false;

        if (!$this->verificaDtAtoNormaCriRpps())
            return false; 
            
        if (!$this->verificaNroAtoNormaSegreMassa())
            return false; 
            
        if (!$this->verificaDataAtoSossegragacao())
            return false;     
               
        if (!$this->verificaAtoNormativo())
            return false;
            
        if (!$this->verificaPlanoDeFatuarial())
            return false;    
                 
        if (!$this->verificaAtoPlanoDeFatuarial())
            return false; 
            
        if (!$this->verificaDataAtoEquacionamento())
            return false;     

        if (!$this->verificaExercicioNormativo())
            return false;

        if (!$this->verificaCgmExecutivo())
            return false;

        if (!$this->verificaCgmLegislativo())
            return false;

        if (!$this->verificaCgmGestora())
            return false;
        
        if (!$this->verificaCgmAutarquia())
            return false;   

        if (!$this->verificaTipoCadastro())
            return false;   
        
        if(db_getsession("DB_anousu") > 2022){
            $this->c236_exercicionormativo =  'null' ;  
        }  
        
        if($this->c236_planodefatuarial != 1 or db_getsession("DB_anousu") < 2023){
            $this->c236_atonormplanodefat = 'null' ;
            $this->c236_dtatoplanodefat = 'null' ;
        }else{
            $this->c236_dtatoplanodefat = "'$this->c236_dtatoplanodefat'";
        }
        
        if($this->c236_massainstituida != 't' or db_getsession("DB_anousu") < 2023){
            $this->c236_nroatonormasegremassa = 'null' ;
            $this->c236_dtatonormasegremassa = 'null' ;
        }else{
            $this->c236_dtatonormasegremassa = "'$this->c236_dtatonormasegremassa'";
        }
        
            $sql  = "INSERT INTO {$this->nomeTabela} ( ";
            $sql .= "c236_orgao, ";
            $sql .= "c236_massainstituida, ";
            $sql .= "c236_beneficiotesouro, ";
            $sql .= "c236_atonormativo, ";
            $sql .= "c236_exercicionormativo, ";
            $sql .= "c236_numcgmexecutivo, ";
            $sql .= "c236_numcgmlegislativo, ";
            $sql .= "c236_numcgmgestora, ";
            $sql .= "c236_numcgmautarquia, ";
            $sql .= "c236_tipocadastro, ";
            $sql .= "c236_dtatonormacrirpps, ";
            $sql .= "c236_nroatonormasegremassa, ";
            $sql .= "c236_dtatonormasegremassa, ";
            $sql .= "c236_planodefatuarial, ";
            $sql .= "c236_atonormplanodefat, ";
            $sql .= "c236_dtatoplanodefat ";
            $sql .= ") VALUES ( ";
            $sql .= "{$this->c236_orgao}, ";
            $sql .= "'{$this->c236_massainstituida}', ";
            $sql .= "'{$this->c236_beneficiotesouro}', ";
            $sql .= "{$this->c236_atonormativo}, ";
            $sql .= "{$this->c236_exercicionormativo}, ";
            $sql .= "{$this->c236_numcgmexecutivo}, ";
            $sql .= "{$this->c236_numcgmlegislativo}, ";
            $sql .= "{$this->c236_numcgmgestora}, ";
            $sql .= "{$this->c236_numcgmautarquia}, ";
            $sql .= "{$this->c236_tipocadastro}, ";
            $sql .= "'{$this->c236_dtatonormacrirpps}', ";
            $sql .= "{$this->c236_nroatonormasegremassa}, ";
            $sql .= "{$this->c236_dtatonormasegremassa},";
            $sql .= "{$this->c236_planodefatuarial}, ";
            $sql .= "{$this->c236_atonormplanodefat}, ";
            $sql .= "{$this->c236_dtatoplanodefat} ); ";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "DIRP não Incluída. Inclusão Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "DIRP já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "DIRP não Incluído. Inclusão Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->c236_coddipr;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    function alterar($c236_coddipr = null)
    {
        $this->atualizacampos();

        if (!$this->verificaMassaInstituida())
            return false;

        if (!$this->verificaBeneficioTesouro())
            return false;

        if (!$this->verificaDtAtoNormaCriRpps())
            return false; 
            
        if (!$this->verificaNroAtoNormaSegreMassa())
            return false; 
            
        if (!$this->verificaDataAtoSossegragacao())
            return false;     
               
        if (!$this->verificaAtoNormativo())
            return false;
            
        if (!$this->verificaPlanoDeFatuarial())
            return false;    
                 
        if (!$this->verificaAtoPlanoDeFatuarial())
            return false; 
            
        if (!$this->verificaDataAtoEquacionamento())
            return false;     
           
        if (!$this->verificaExercicioNormativo())
            return false;

        if (!$this->verificaCgmExecutivo())
            return false;

        if (!$this->verificaCgmLegislativo())
            return false;
            
        if (!$this->verificaCgmGestora())
            return false;
            
        if (!$this->verificaCgmAutarquia())
            return false;    
        if (!$this->verificaTipoCadastro())
            return false;   
        
        if(db_getsession("DB_anousu") > 2022){
            $this->c236_exercicionormativo =  'null' ;  
        }  

        $sql = " UPDATE {$this->nomeTabela} SET ";
        $virgula = "";
        if(db_getsession("DB_anousu") > 2022){
            if ($this->verificaCodDirp()) {
                $sql .= $virgula . " c236_coddipr = {$this->c236_coddipr} ";
                $virgula = ",";
            }
    
            if ($this->verificaOrgao()) {
                $sql  .= $virgula . " c236_orgao = '$this->c236_orgao' ";
                $virgula = ",";
            }
    
            if ($this->verificaMassaInstituida()) {
                $sql  .= $virgula . " c236_massainstituida = '$this->c236_massainstituida' ";
                $virgula = ",";
            }
    
            if ($this->verificaBeneficioTesouro()) {
                $sql  .= $virgula . " c236_beneficiotesouro = '$this->c236_beneficiotesouro' ";
                $virgula = ",";
            }
    
            if ($this->verificaAtoNormativo()) {
                $sql  .= $virgula . " c236_atonormativo = $this->c236_atonormativo ";
                $virgula = ",";
            }
    
            if ($this->verificaDtAtoNormaCriRpps ()) {
                if($this->c236_dtatonormacrirpps == null)
                    $sql  .= $virgula . " c236_dtatonormacrirpps = null  ";
                else
                    $sql  .= $virgula . " c236_dtatonormacrirpps = '$this->c236_dtatonormacrirpps'  ";
                $virgula = ",";
            }
    
            if ($this->verificaNroAtoNormaSegreMassa()) {
            
                if($this->c236_massainstituida == 't' & db_getsession("DB_anousu") > 2022){
                    $sql  .= $virgula . " c236_nroatonormasegremassa = '$this->c236_nroatonormasegremassa' ";  
                }else{
                    $sql  .= $virgula . " c236_nroatonormasegremassa = null ";
                }
               
                $virgula = ",";
            }
    
            if ($this->verificaDataAtoSossegragacao()) {
                if ($this->c236_massainstituida == "t" && db_getsession("DB_anousu") > 2022)
                    $sql  .= $virgula . " c236_dtatonormasegremassa = '$this->c236_dtatonormasegremassa' ";
                else    
                    $sql  .= $virgula . " c236_dtatonormasegremassa = null ";
                $virgula = ",";
            }
    
            if ($this->verificaPlanoDeFatuarial()) {
                $sql  .= $virgula . " c236_planodefatuarial = '$this->c236_planodefatuarial' ";
                $virgula = ",";
            }
    
            if ($this->verificaAtoPlanoDeFatuarial()) {
                if($this->c236_planodefatuarial == 1 && db_getsession("DB_anousu") > 2022)
                    $sql  .= $virgula . " c236_atonormplanodefat = '$this->c236_atonormplanodefat' ";
                else  
                    $sql  .= $virgula . " c236_atonormplanodefat = null ";  
                $virgula = ",";
            }
    
            if ($this->verificaDataAtoEquacionamento()) {
                if ($this->c236_planodefatuarial == 1 && db_getsession("DB_anousu") > 2022)
                    $sql  .= $virgula . " c236_dtatoplanodefat = '$this->c236_dtatoplanodefat' ";
                else    
                    $sql  .= $virgula . " c236_dtatoplanodefat = null " ;
                $virgula = ",";
            }        
                
            if ($this->verificaCgmExecutivo()) {
                $sql  .= $virgula . " c236_numcgmexecutivo = '$this->c236_numcgmexecutivo' ";
                $virgula = ",";
            }
    
            if ($this->verificaCgmLegislativo()) {
                $sql  .= $virgula . " c236_numcgmlegislativo = '$this->c236_numcgmlegislativo' ";
                $virgula = ",";
            }
    
            if ($this->verificaCgmGestora()) {
                $sql  .= $virgula . " c236_numcgmgestora = '$this->c236_numcgmgestora' ";
                $virgula = ",";
            }

            if ($this->verificaCgmAutarquia()) {
                $sql  .= $virgula . " c236_numcgmautarquia = '$this->c236_numcgmautarquia' ";
                $virgula = ",";
            }
               
            if ($this->verificaTipoCadastro()) {
                $sql  .= $virgula . " c236_tipocadastro = '$this->c236_tipocadastro' ";
                $virgula = ",";
            }        
        }else{
            if ($this->verificaCodDirp()) {
                $sql .= $virgula . " c236_coddipr = {$this->c236_coddipr} ";
                $virgula = ",";
            }
    
            if ($this->verificaOrgao()) {
                $sql  .= $virgula . " c236_orgao = '$this->c236_orgao' ";
                $virgula = ",";
            }
    
            if ($this->verificaMassaInstituida()) {
                $sql  .= $virgula . " c236_massainstituida = '$this->c236_massainstituida' ";
                $virgula = ",";
            }
    
            if ($this->verificaBeneficioTesouro()) {
                $sql  .= $virgula . " c236_beneficiotesouro = '$this->c236_beneficiotesouro' ";
                $virgula = ",";
            }
    
            if ($this->verificaAtoNormativo()) {
                $sql  .= $virgula . " c236_atonormativo = $this->c236_atonormativo ";
                $virgula = ",";
            }
                            
            if ($this->verificaExercicioNormativo()) {
                if(db_getsession("DB_anousu") > 2022){
                    $sql  .= $virgula . " c236_exercicionormativo =  null " ;  
                }else{
                    $sql  .= $virgula . " c236_exercicionormativo = $this->c236_exercicionormativo ";
                } 
                $virgula = ",";
            }
    
            if ($this->verificaCgmExecutivo()) {
                $sql  .= $virgula . " c236_numcgmexecutivo = '$this->c236_numcgmexecutivo' ";
                $virgula = ",";
            }
    
            if ($this->verificaCgmLegislativo()) {
                $sql  .= $virgula . " c236_numcgmlegislativo = '$this->c236_numcgmlegislativo' ";
                $virgula = ",";
            }
    
            if ($this->verificaCgmGestora()) {
                $sql  .= $virgula . " c236_numcgmgestora = '$this->c236_numcgmgestora' ";
                $virgula = ",";
            }

            if ($this->verificaCgmAutarquia()) {
                $sql  .= $virgula . " c236_numcgmautarquia = '$this->c236_numcgmautarquia' ";
                $virgula = ",";
            }

        }
      

        $sql .= " WHERE ";

        if ($c236_coddipr != null) {
            $sql .= " c236_coddipr = $c236_coddipr ";
        }

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->c236_coddipr;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->c236_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteracao efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->c236_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($c236_coddipr = null, $dbwhere = null)
    {
        $sql = " DELETE FROM {$this->nomeTabela} WHERE ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($c236_coddipr != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c236_coddipr = $c236_coddipr ";
            }
        } else {
            $sql2 = $dbwhere;
        }

        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $c236_coddipr;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $c236_coddipr;
                $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $c236_coddipr;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    function sql_record($sql)
    {
        $result = db_query($sql);
        if ($result == false) {
            $this->numrows    = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Erro ao selecionar os registros.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql   = "Record Vazio na Tabela:dipr";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    function sql_query($c236_coddipr = null, $campos = "*", $ordem = null, $dbwhere = "")
    {
        $sql = "SELECT ";
        if ($campos != "*") {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " FROM {$this->nomeTabela} ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c236_coddipr != null) {
                $sql2 .= " WHERE c236_coddipr = $c236_coddipr ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    function sql_query_file($c236_coddipr = null, $campos = "*", $ordem = null, $dbwhere = "")
    {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from {$this->nomeTabela} ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c236_coddipr != null) {
                $sql2 .= " where c236_coddipr = $c236_coddipr ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    function verificaCodDirp()
    {
        if (trim($this->c236_coddipr) == "" and !isset($GLOBALS["HTTP_POST_VARS"]["c236_coddipr"])) {
            $this->erroCampo("Campo Codigo DIRP não Informado.", "c236_coddipr");
            return false;
        }
        return true;
    }

    function verificaOrgao()
    {
        if (trim($this->c236_orgao) == "" and !isset($GLOBALS["HTTP_POST_VARS"]["c236_orgao"])) {
            $this->erroCampo("Campo Orgão não Informado.", "c236_orgao");
            return false;
        }
        return true;
    }

    function verificaMassaInstituida()
    {
        if (trim($this->c236_massainstituida) == "0") {
            $this->erroCampo("Campo Massa Instituída não Informado.", "c236_massainstituida");
            return false;
        }
        return true;
    }

    function verificaBeneficioTesouro()
    {
        if (trim($this->c236_beneficiotesouro) == "0") {
            $this->erroCampo("Campo Benefício Tesouro não Informado.", "c236_beneficiotesouro");
            return false;
        }
        return true;
    }

    function verificaAtoNormativo()
    {
        if ($this->c236_atonormativo == null) {
            $this->erroCampo("Campo Ato Normativo não Informado.", "c236_atonormativo");
            return false;
        }
        return true;
    }

    function verificaDtAtoNormaCriRpps()
    {   
        if (($this->c236_dtatonormacrirpps == '' || $this->c236_dtatonormacrirpps == null) && db_getsession("DB_anousu") > 2022) {
            $this->erroCampo("Campo Data do ato normativo de criação do RPPS não Informado.", "c236_dtatonormacrirpps" );
            return false;
        }
        return true;
    }

    function verificaNroAtoNormaSegreMassa()
    {
        if ($this->c236_nroatonormasegremassa == null && $this->c236_massainstituida == "t" && db_getsession("DB_anousu") > 2022) {
            $this->erroCampo("Campo Número do ato normativo que implementou ou desfez a segregação da massa não Informado.", "c236_nroatonormasegremassa");
            return false;
        }
        return true;
    }

    function verificaDataAtoSossegragacao()
    {
       
        if ($this->c236_dtatonormasegremassa == null && $this->c236_massainstituida == "t" && db_getsession("DB_anousu") > 2022) {
            $this->erroCampo("Campo Data do ato normativo que implementou ou desfez a segregação da massa não Informado.", "c236_dtatonormasegremassa");
            return false;
        }
        return true;
    }

    function verificaAtoPlanoDeFatuarial()
    {
        if ($this->c236_atonormplanodefat == null && $this->c236_planodefatuarial == 1 && db_getsession("DB_anousu") > 2022) {
            $this->erroCampo("Campo Ato normativo que estabeleceu o plano de equacionamento do déficit atuarial não Informado.", "c236_atonormplanodefat");
            return false;
        }
        return true;
    }

    function verificaDataAtoEquacionamento()
    {
        if ($this->c236_dtatoplanodefat == null && $this->c236_planodefatuarial == 1 && db_getsession("DB_anousu") > 2022) {
            $this->erroCampo("Campo Data do ato normativo que estabeleceu o plano de equacionamento do déficit atuarial não Informado.", "c236_dtatoplanodefat");
            return false;
        }
        return true;
    }
    
    function verificaPlanoDeFatuarial()
    {   
        if ($this->c236_planodefatuarial == 0 && db_getsession("DB_anousu") > 2022) {
            $this->erroCampo("Campo Houve necessidade de implementar plano de equacionamento de déficit atuarial? não Informado.", "c236_planodefatuarial");
            return false;
        }
        return true;
    }

    function verificaExercicioNormativo()
    {
        if ($this->c236_exercicionormativo == null && db_getsession("DB_anousu") < 2023) {
            $this->erroCampo("Campo Exercicio Normativo não Informado.", "c236_exercicionormativo");
            return false;
        }
        return true;
    }

    function verificaCgmExecutivo()
    {
        if ($this->c236_numcgmexecutivo == null) {
            $this->erroCampo("Campo Unidade Gestora Executivo não Informado.", "c236_numcgmexecutivo");
            return false;
        }
        return true;
    }

    function verificaCgmLegislativo()
    {
        if ($this->c236_numcgmlegislativo == null) {
            $this->erroCampo("Campo Administração Direta Legislativo não Informado.", "c236_numcgmlegislativo");
            return false;
        }
        return true;
    }

    function verificaCgmGestora()
    {
        if ($this->c236_numcgmgestora == null) {
            $this->erroCampo("Campo Unidade Gestora não Informado.", "c236_numcgmgestora");
            return false;
        }
        return true;
    } 

    function verificaCgmAutarquia()
    {
        if ($this->c236_numcgmautarquia == null) {
            $this->erroCampo("Campo Autarquia não Informado.", "c236_numcgmautarquia");
            return false;
        }
        return true;
    } 
    
    function verificaTipoCadastro()
    {
        if ($this->c236_tipocadastro == null && db_getsession("DB_anousu") > 2022) {
            $this->erroCampo("Campo Tipo de Cadastro: não Informado.", "c236_tipocadastro");
            return false;
        }
        return true;
    } 
    
    function erroCampo($descricao, $campo)
    {
        $this->erro_sql = $descricao;
        $this->erro_campo = $campo;
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
    }
}
