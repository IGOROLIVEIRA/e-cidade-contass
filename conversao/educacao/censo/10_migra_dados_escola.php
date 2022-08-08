<?
 /**
  * Programa para atualização das tabelas Auxilizares do Censo.
  * Atualizacao da tabela censoorgemissrg
  */
 include (__DIR__ . "/../../../libs/db_conn.php");
 
 /**
  * Dados de Conexao
  */
 /*
 $aDadosConexao = parse_ini_file("libs/db_conecta_avaliacoes.ini");
 $DB_SERVIDOR = $aDadosConexao["host"];
 $DB_BASE     = $aDadosConexao["dbname"];
 $DB_PORTA    = $aDadosConexao["port"];
 $DB_USUARIO  = $aDadosConexao["user"];
 $DB_SENHA    = $aDadosConexao["password"];
 */
 $conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA") or die ("Erro na conexão com o banco de dados");
 require_once(__DIR__ . "/../../../libs/db_utils.php");
 require_once(__DIR__ . "/../../../libs/db_stdlibwebseller.php");

 pg_query("select fc_startsession()");
 $sSqlEscolas  = "select ed18_i_codigo, ";  
 $sSqlEscolas .= "       ed18_c_nome, ";
 $sSqlEscolas .= "       escolaestrutura.*";
 $sSqlEscolas .= "  from escola ";
 $sSqlEscolas .= "       inner join escolaestrutura on ed18_i_codigo = ed255_i_escola";
 echo "Aguarde, iniciando a migração dos dados do censo das escolas\n";
 $rsEscolas   = pg_query($sSqlEscolas);
 $aEscolas    = db_utils::getCollectionByRecord($rsEscolas);
 pg_query("begin");
 foreach ($aEscolas as $oEscola) {
   
   echo "Migrando dados da Escola {$oEscola->ed18_c_nome} ";
   try {

    /**
     * Iniciando a verificando da avaliacao;
     */
     $sSqlVerificaAvaliacao  = "select ed308_avaliacaogruporesposta";
     $sSqlVerificaAvaliacao .= "  from escoladadoscenso ";
     $sSqlVerificaAvaliacao .= " where ed308_escola = {$oEscola->ed18_i_codigo} ";
     $rsAvaliacaoEscola      = pg_query($sSqlVerificaAvaliacao);
     if (!$rsAvaliacaoEscola) {
       throw new Exception("Erro ao selecionar dados da avaliacao da Escola. ".pg_last_error());
     }
     if (pg_num_rows($rsAvaliacaoEscola) == 0) {

       $sCodigoGrupoAvaliacao          = "select nextval('avaliacaogruporesposta_db107_sequencial_seq') as proximo_codigo";
       $rsCodigoGrupo                  = pg_query($sCodigoGrupoAvaliacao);
       $iCodigoGrupoAvaliacao          = db_utils::fieldsMemory($rsCodigoGrupo, 0)->proximo_codigo;
       $sInsertAvaliacaoGrupoResposta  = "insert into avaliacaogruporesposta ";
       $sInsertAvaliacaoGrupoResposta .= "            (db107_sequencial,";
       $sInsertAvaliacaoGrupoResposta .= "             db107_usuario,   ";
       $sInsertAvaliacaoGrupoResposta .= "             db107_datalancamento, ";
       $sInsertAvaliacaoGrupoResposta .= "             db107_hora)" ;
       $sInsertAvaliacaoGrupoResposta .= "     values  ({$iCodigoGrupoAvaliacao}, ";
       $sInsertAvaliacaoGrupoResposta .= "              1,  ";
       $sInsertAvaliacaoGrupoResposta .= "              current_date, ";
       $sInsertAvaliacaoGrupoResposta .= "              '00:00' ";
       $sInsertAvaliacaoGrupoResposta .= "             )";

       $rsInsertAvaliacaoGrupo         = pg_query($sInsertAvaliacaoGrupoResposta);
       if (!$rsInsertAvaliacaoGrupo) {
          throw new exception ("Erro ao inserir dados da avaliacao da escola");
       }
       $sInsertDadosCensoEscola  = "insert into escoladadoscenso ";
       $sInsertDadosCensoEscola .= "            (ed308_sequencial, ";
       $sInsertDadosCensoEscola .= "             ed308_avaliacaogruporesposta,";
       $sInsertDadosCensoEscola .= "            ed308_escola)";
       $sInsertDadosCensoEscola .= "     values (nextval('escoladadoscenso_ed308_sequencial_seq'), ";
       $sInsertDadosCensoEscola .= "            {$iCodigoGrupoAvaliacao}, ";
       $sInsertDadosCensoEscola .= "            {$oEscola->ed18_i_codigo})";
       $rsInsertDadosEscolaCenso = pg_query($sInsertDadosCensoEscola);
       if (!$rsInsertDadosEscolaCenso) {
          throw new exception ("Erro ao inserir dados do censo da escola");
       }
     } else {

        $iCodigoGrupoAvaliacao = db_utils::fieldsMemory($rsAvaliacaoEscola, 0)->ed308_avaliacaogruporesposta;
     }
     echo $oEscola->ed18_i_codigo." -- ".$iCodigoGrupoAvaliacao."\n";
     /**
      * iniciamos a migração das dependencias das escolas.
      * para isso fazemso um de-para do campo 
      */ 
     $aRespostasEscola = array(); 
     $lTemDiretoria    = substr($oEscola->ed255_c_dependencias, 0, 1) == 1?true:false;
     if ($lTemDiretoria) {
       $aRespostasEscola[] = 3000000;
     }
     $lTemSalaProfessores  = substr($oEscola->ed255_c_dependencias, 1, 1) == 1?true:false;
     if ($lTemSalaProfessores) {
       $aRespostasEscola[] = 3000001;
     }
     $lTemLaboratorioInformatica  = substr($oEscola->ed255_c_dependencias, 2, 1) == 1?true:false;
     if ($lTemLaboratorioInformatica) {
       $aRespostasEscola[] = 3000002;
     }
     $lTemLaboratorioCiencias  = substr($oEscola->ed255_c_dependencias, 3, 1) == 1?true:false;
     if ($lTemLaboratorioInformatica) {
       $aRespostasEscola[] = 3000003;
     }
     $lTemSalaAEE  = substr($oEscola->ed255_c_dependencias, 4, 1) == 1?true:false;
     if ($lTemSalaAEE) {
       $aRespostasEscola[] = 3000004;
     }
     $lTemQuadraEsportesCoberta  = substr($oEscola->ed255_c_dependencias, 5, 1) == 1?true:false;
     if ($lTemQuadraEsportesCoberta) {
       $aRespostasEscola[] = 3000005;
     }
     $lTemQuadraEsportesDesCoberta  = substr($oEscola->ed255_c_dependencias, 6, 1) == 1?true:false;
     if ($lTemQuadraEsportesDesCoberta) {
       $aRespostasEscola[] = 3000006;
     }
     $lTemCozinha  = substr($oEscola->ed255_c_dependencias, 7, 1) == 1?true:false;
     if ($lTemCozinha) {
       $aRespostasEscola[] = 3000007;
     }
     $lTemBiblioteca  = substr($oEscola->ed255_c_dependencias, 8 , 1) == 1?true:false;
     if ($lTemBiblioteca) {
       $aRespostasEscola[] = 3000008 ;
     }
     $lTemSalaDeLeitura  = substr($oEscola->ed255_c_dependencias, 9, 1) == 1?true:false;
     if ($lTemSalaDeLeitura) {
       $aRespostasEscola[] = 3000009;
     }
     $lTemParqueInfantil  = substr($oEscola->ed255_c_dependencias, 10, 1) == 1?true:false;
     if ($lTemParqueInfantil) {
       $aRespostasEscola[] = 3000010;
     }
     $lTemBercario  = substr($oEscola->ed255_c_dependencias, 11, 1) == 1?true:false;
     if ($lTemBercario) {
       $aRespostasEscola[] = 3000011;
     }
     $lTemSanitarioForaDoPredio  = substr($oEscola->ed255_c_dependencias, 12, 1) == 1?true:false;
     if ($lTemSanitarioForaDoPredio) {
       $aRespostasEscola[] = 3000012;
     }
     $lTemSanitarioDentroDoPredio  = substr($oEscola->ed255_c_dependencias, 13, 1) == 1?true:false;
     if ($lTemSanitarioDentroDoPredio) {
       $aRespostasEscola[] = 3000013;
     }
     $lTemSanitarioEducacaInfantil  = substr($oEscola->ed255_c_dependencias, 14, 1) == 1?true:false;
     if ($lTemSanitarioEducacaInfantil) {
       $aRespostasEscola[] = 3000014;
     }
     $lTemSanitarioEspecial  = substr($oEscola->ed255_c_dependencias, 15, 1) == 1?true:false;
     if ($lTemSanitarioEspecial) {
       $aRespostasEscola[] = 3000015;
     }
    
     /**
      * Dados sobre Computadores;
      */

      /**
       * Possui computares
       */
     $aRespostasEscola[]  = $oEscola->ed255_i_computadores == 1?3000030:3000031;
     
     /**
      * Quantidade de computadores
      */
     $aRespostasEscola[] = array(3000032,  $oEscola->ed255_i_qtdcomp);
    
     
     /**
      * Quantidade de computadores Admin
      */
     $aRespostasEscola[] = array(3000033,  $oEscola->ed255_i_qtdcompadm);
     
     
     /**
      * Quantidade de computadores Alunos
      */
     $aRespostasEscola[] = array(3000113,  $oEscola->ed255_i_qtdcompalu);

     /**
      * Possui acesso internet
      */
     $aRespostasEscola[]  = $oEscola->ed255_i_internet == 1?3000035:3000036;
     
     /**
      * Possui acesso banda larga
      */
     $aRespostasEscola[]  = $oEscola->ed255_i_internet == 1?3000037:3000038;
     
     /**
      * Dados do local de funcionamento
      */
     $lTemPredioEscolar  = substr($oEscola->ed255_c_localizacao, 0, 1) == 1?true:false;
     if ($lTemPredioEscolar) {
       $aRespostasEscola[] = 3000039;
     }

     $lTemIgreja  = substr($oEscola->ed255_c_localizacao, 1, 1) == 1?true:false;
     if ($lTemIgreja) {
       $aRespostasEscola[] = 3000040;
     }

     $lSalaEmpresa  = substr($oEscola->ed255_c_localizacao, 2, 1) == 1?true:false;
     if ($lSalaEmpresa) {
       $aRespostasEscola[] = 3000041;
     }

     $lCasaProfessor = substr($oEscola->ed255_c_localizacao, 3, 1) == 1?true:false;
     if ($lCasaProfessor) {
       $aRespostasEscola[] = 3000042;
     }

     $lSalasEmOutraEscola  = substr($oEscola->ed255_c_localizacao, 4, 1) == 1?true:false;
     if ($lSalasEmOutraEscola) {
       $aRespostasEscola[] = 3000043;
     }

     $lGalpao  = substr($oEscola->ed255_c_localizacao, 5, 1) == 1?true:false;
     if ($lGalpao) {
       $aRespostasEscola[] = 3000044;
     }
     $lUnidadePrisional  = substr($oEscola->ed255_c_localizacao, 6, 1) == 1?true:false;
     if ($lUnidadePrisional) {
       $aRespostasEscola[] = 3000045;
     }
     $lOutros  = substr($oEscola->ed255_c_localizacao, 7, 1) == 1?true:false;
     if ($lOutros) {
       $aRespostasEscola[] = 3000045;
     }
     /**
      *Forma de Ocupação do Predio.
      */
     switch ($oEscola->ed255_i_formaocupacao) {
      
       case 1:
         $aRespostasEscola[] = 3000047;
         break;

       case 2:
         $aRespostasEscola[] = 3000048;
         break;

       case 3:
         $aRespostasEscola[] = 3000049;
         break;

     }
     /**
      * Esgoto Sanitario;
      */
     $lRedePublica  = substr($oEscola->ed255_c_esgotosanitario, 0, 1) == 1?true:false;
     if ($lRedePublica) {
       $aRespostasEscola[] = 3000050;
     }
     
     $lFossa  = substr($oEscola->ed255_c_esgotosanitario, 1, 1) == 1?true:false;
     if ($lFossa) {
       $aRespostasEscola[] = 3000051;
     }

     $lInexistente  = substr($oEscola->ed255_c_esgotosanitario, 2, 1) == 1?true:false;
     if ($lInexistente) {
       $aRespostasEscola[] = 3000052;
     }

    /**
     * Materiais Especificos
     */

     $lNaoUtiliza  = substr($oEscola->ed255_c_materdidatico, 0, 1) == 1?true:false;

     if ($lNaoUtiliza) {
       $aRespostasEscola[] = 3000053;
     }

     $lQuilombola  = substr($oEscola->ed255_c_materdidatico, 1, 1) == 1?true:false;
     if ($lQuilombola) {
       $aRespostasEscola[] = 3000054;
     }

     $lIndigena  = substr($oEscola->ed255_c_materdidatico, 2, 1) == 1?true:false;
     if ($lIndigena) {
       $aRespostasEscola[] = 3000055;
     }

     /**
      *Equipamentos Existentes
      */
       
     $lTelevisao  = substr($oEscola->ed255_c_equipamentos, 0, 1) == 1?true:false;
     if ($lTelevisao) {
       $aRespostasEscola[] = 3000056;
     }
     $lVideoCassete  = substr($oEscola->ed255_c_equipamentos, 1, 1) == 1?true:false;
     if ($lVideoCassete) {
       $aRespostasEscola[] = 3000057;
     }
     $lDVD  = substr($oEscola->ed255_c_equipamentos, 2, 1) == 1?true:false;
     if ($lDVD) {
       $aRespostasEscola[] = 3000058;
     }
     $lAntenaParabolica  = substr($oEscola->ed255_c_equipamentos, 3, 1) == 1?true:false;
     if ($lAntenaParabolica) {
       $aRespostasEscola[] = 3000059;
     }
     $lCopiadora  = substr($oEscola->ed255_c_equipamentos, 4, 1) == 1?true:false;
     if ($lCopiadora) {
       $aRespostasEscola[] = 3000060;
     }
     $lRetroprojetor  = substr($oEscola->ed255_c_equipamentos, 5, 1) == 1?true:false;
     if ($lRetroprojetor) {
       $aRespostasEscola[] = 3000061;
     }
     $lImpressora  = substr($oEscola->ed255_c_equipamentos, 6, 1) == 1?true:false;
     if ($lImpressora) {
       $aRespostasEscola[] = 3000062;
     }
     /**
      * Destinação Lixo
      */
       
     $lColetaPeriodica  = substr($oEscola->ed255_c_destinolixo, 0, 1) == 1?true:false;
     if ($lColetaPeriodica) {
       $aRespostasEscola[] = 3000067;
     }
     $lQueima  = substr($oEscola->ed255_c_destinolixo, 1, 1) == 1?true:false;
     if ($lQueima) {
       $aRespostasEscola[] = 3000068;
     }
     $lJogaOutraArea  = substr($oEscola->ed255_c_destinolixo, 2, 1) == 1?true:false;
     if ($lJogaOutraArea) {
       $aRespostasEscola[] = 3000069;
     }
     $lRecicla  = substr($oEscola->ed255_c_destinolixo, 3, 1) == 1?true:false;
     if ($lRecicla) {
       $aRespostasEscola[] = 3000070;
     }
     $lEnterra  = substr($oEscola->ed255_c_destinolixo, 4, 1) == 1?true:false;
     if ($lEnterra) {
       $aRespostasEscola[] = 3000071;
     }
     $lOutros  = substr($oEscola->ed255_c_destinolixo, 5, 1) == 1?true:false;
     if ($lOutros) {
       $aRespostasEscola[] = 3000072;
     }
     /**
      * Abastecimento de Agua
     */ 
     $lRedePublica  = substr($oEscola->ed255_c_abastagua, 0, 1) == 1?true:false;
     if ($lRedePublica) {
       $aRespostasEscola[] = 3000088;
     }
     $lPocoArtesiano  = substr($oEscola->ed255_c_abastagua, 1, 1) == 1?true:false;
     if ($lPocoArtesiano) {
       $aRespostasEscola[] = 3000089;
     }
     $lCacimba  = substr($oEscola->ed255_c_abastagua, 2, 1) == 1?true:false;
     if ($lCacimba) {
       $aRespostasEscola[] = 3000090;
     }
     $lFonte  = substr($oEscola->ed255_c_abastagua, 3, 1) == 1?true:false;
     if ($lFonte) {
       $aRespostasEscola[] = 3000091;
     }

     $lInexistente  = substr($oEscola->ed255_c_abastagua, 4, 1) == 1?true:false;
     if ($lInexistente) {
       $aRespostasEscola[] = 3000092;
     }
    
     /**
      *Abastecimento de Energia
      */
     $lRedePublica  = substr($oEscola->ed255_c_abastenergia, 0 , 1) == 1?true:false;
     if ($lRedePublica) {
       $aRespostasEscola[] = 3000093;
     }
     $lGerador  = substr($oEscola->ed255_c_abastenergia, 1, 1) == 1?true:false;
     if ($lGerador) {
       $aRespostasEscola[] = 3000094;
     }
     $lEnergiaAlternativa  = substr($oEscola->ed255_c_abastenergia, 2, 1) == 1?true:false;
     if ($lEnergiaAlternativa) {
       $aRespostasEscola[] = 3000095;
     }

     $lInexistente  = substr($oEscola->ed255_c_abastenergia, 3, 1) == 1?true:false;
     if ($lInexistente) {
       $aRespostasEscola[] = 3000096;
     }
     
     /**
      * Predio Compartilhado
      */

     $aRespostasEscola[]  = $oEscola->ed255_i_compartilhado == 1?3000097:3000098;

     /**
      * Agua dos alunos 
      */
     $aRespostasEscola[]  = $oEscola->ed255_i_aguafiltrada == 1?3000100:3000099;

     /**
      *Alimentação dos alunos
      */
     $aRespostasEscola[]  = $oEscola->ed255_i_aguafiltrada == 1?3000101:3000102;

     /**
      *ed255_i_salaexistente
      */
     $aRespostasEscola[]  = array(3000103, $oEscola->ed255_i_salaexistente);

     /**
      *ed255_i_salautilizada
      */
     $aRespostasEscola[]  = array(3000104, $oEscola->ed255_i_salautilizada);
     switch ($oEscola->ed255_i_ativcomplementar) {
     
       case 0:
       
         $aRespostasEscola[] = 3000105;
         break;
       case 1:
         
         $aRespostasEscola[] = 3000106;
         break;
       
       case 2:

         $aRespostasEscola[] = 3000107;
         break;
     }
     switch ($oEscola->ed255_i_aee) {
     
       case 0:
       
         $aRespostasEscola[] = 3000108;
         break;
       case 1:
         
         $aRespostasEscola[] = 3000109;
         break;
       
       case 2:

         $aRespostasEscola[] = 3000110;
         break;
     }
    /**
     *Ensino fUNDAMENTAL EM CICLOS
     */
    $aRespostasEscola[]  = $oEscola->ed255_i_efciclos == 1?3000111:3000112;


     /*
      * Deletamos todos os dados da avaliacao da escola.
      */
     $sSqlRespostasEscola     = "select db108_avaliacaoresposta, db108_sequencial ";
     $sSqlRespostasEscola    .= "  from avaliacaogrupoperguntaresposta ";
     $sSqlRespostasEscola    .= " where db108_avaliacaogruporesposta = {$iCodigoGrupoAvaliacao} ";
     $rsRespostas             = pg_query($sSqlRespostasEscola);
     $aRespostasEscolaSalvas  = db_utils::getCollectionByRecord($rsRespostas);
     foreach ($aRespostasEscolaSalvas as $oResposta) {
       
       $sDeleteGrupoResposta = "delete from avaliacaogrupoperguntaresposta where  db108_sequencial = {$oResposta->db108_sequencial} ";
       pg_query($sDeleteGrupoResposta);

       $sDeleteResposta = "delete from avaliacaoresposta where db106_sequencial = {$oResposta->db108_avaliacaoresposta} ";
       pg_query($sDeleteResposta);
     }
     /**
      * Incluimos as respostas da escola
      */
      foreach ($aRespostasEscola as $mResposta) {

        $sTextoResposta = '';
        if (is_array($mResposta)) {

          $iCodigoResposta = $mResposta[0];
          $sTextoResposta  = $mResposta[1];
        } else {
          $iCodigoResposta  = $mResposta;  
        }
        $sNextvalAvaliacaoResposta = "select nextval('avaliacaoresposta_db106_sequencial_seq') as proximo_codigo";
        $iProximoCodigoResposta    = db_utils::fieldsMemory(pg_query($sNextvalAvaliacaoResposta), 0)->proximo_codigo;
        $sInsertAvaliacaoResposta  = "insert into avaliacaoresposta ";
        $sInsertAvaliacaoResposta .= "       (db106_sequencial, ";
        $sInsertAvaliacaoResposta .= "        db106_avaliacaoperguntaopcao,";
        $sInsertAvaliacaoResposta .= "        db106_resposta ) ";
        $sInsertAvaliacaoResposta .= " values ({$iProximoCodigoResposta}, ";
        $sInsertAvaliacaoResposta .= "         {$iCodigoResposta}, ";
        $sInsertAvaliacaoResposta .= "         '{$sTextoResposta}' )";

        $rsInsertAvaliacaoResposta = pg_query($sInsertAvaliacaoResposta);
        if (!$rsInsertAvaliacaoResposta) {
         throw new Exception("Erro ao incluir Resposta");
        }
       
        $sInsertGrupoResposta  = "insert into avaliacaogrupoperguntaresposta ";
        $sInsertGrupoResposta .= "            (db108_sequencial,";
        $sInsertGrupoResposta .= "             db108_avaliacaogruporesposta, ";
        $sInsertGrupoResposta .= "            db108_avaliacaoresposta) ";
        $sInsertGrupoResposta .= " values (nextval('avaliacaogrupoperguntaresposta_db108_sequencial_seq'),";
        $sInsertGrupoResposta .= "        {$iCodigoGrupoAvaliacao},";
        $sInsertGrupoResposta .= "        {$iProximoCodigoResposta} )";
        $rsInsertGrupoResposta = pg_query($sInsertGrupoResposta);
        if (!$rsInsertGrupoResposta) {
          throw new Exception("Erro ao incluir grupo de  Resposta");
        }
      }
     unset($aRespostasEscolaSalvas);
     print_r($aRespostasEscola);
     pg_query("commit");
   } catch (Exception $eErro) {

     pg_query("rollback");
     echo $eErro->getMessage();  
   }
 }
 pg_query("commit");
 echo "Fim da Migração dos dados das Escolas\n";
 ?>
