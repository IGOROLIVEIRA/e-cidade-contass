<?php
require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/db_utils.php';
require_once 'dbforms/db_funcoes.php';
require_once 'classes/db_acordo_classe.php';
require_once 'classes/db_acordoacordogarantia_classe.php';
require_once 'classes/db_acordoacordopenalidade_classe.php';
require_once 'classes/db_acordoitem_classe.php';
require_once 'classes/db_acordoaux_classe.php';
require_once 'classes/db_parametroscontratos_classe.php';
require_once 'classes/db_manutencaoacordo_classe.php';
require_once 'classes/db_acordoposicao_classe.php';
$clacordo = new cl_acordo;
$clmanutencaoacordo = new cl_manutencaoacordo;
$clacordoposicao = new cl_acordoposicao;

$clacordo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('ac17_sequencial');
$clrotulo->label('descrdepto');
$clrotulo->label('ac02_sequencial');
$clrotulo->label('ac08_descricao');
$clrotulo->label('ac50_descricao');
$clrotulo->label('z01_nome');
$clrotulo->label('ac16_licitacao');
$clrotulo->label('l20_objeto');
$clrotulo->label('ac16_dataassinatura');
$clrotulo->label('ac35_dataassinaturatermoaditivo');
$clrotulo->label('ac35_datareferencia');
$clrotulo->label('ac26_numeroaditamento');
$clrotulo->label('ac16_datareferencia');
if (isset($alterar)) {
  if (empty($_POST['ac16_adesaoregpreco'])) {
    unset($_POST['ac16_adesaoregpreco']);
    unset($GLOBALS["HTTP_POST_VARS"]["ac16_adesaoregpreco"]);
  }
  if (empty($_POST['ac16_licoutroorgao'])) {
    unset($_POST['ac16_licoutroorgao']);
    unset($GLOBALS["HTTP_POST_VARS"]["ac16_licoutroorgao"]);
  }
  if (empty($_POST['ac16_licitacao'])) {
    unset($_POST['ac16_licitacao']);
    unset($GLOBALS["HTTP_POST_VARS"]["ac16_licitacao"]);
  }
}

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

$anousu = db_getsession('DB_anousu');
$instit = db_getsession('DB_instit');



if (isset($alterar)) {
  $sqlerro = false;
  $aditivo = false;
  $erro_msg = "";
  db_inicio_transacao();

  $ac26_sequencial = $_POST['ac26_sequencial'];
  $ac26_numeroapostilamento = $_POST['ac26_numeroapostilamento'];
  $ac18_datainicio = $_POST['ac18_datainicio'];
  $ac18_datafim = $_POST['ac18_datafim'];
  $si03_dataapostila = $_POST['si03_dataapostila'];
  $si03_datareferencia = $_POST['si03_datareferencia'];

  for ($i = 0; $i < count($ac26_sequencial); $i++) {
    $posicao = $ac26_sequencial[$i];
    $numeroapostilamento = $ac26_numeroapostilamento[$i];
    $datainicio = implode('-', array_reverse(explode('/', $ac18_datainicio[$i])));
    $datafim = implode('-', array_reverse(explode('/', $ac18_datafim[$i])));
    $dataapostila = implode('-', array_reverse(explode('/', $si03_dataapostila[$i])));
    $dataapostilareferencia = implode('-', array_reverse(explode('/', $si03_datareferencia[$i])));
    $dataassinatura = implode('-', array_reverse(explode('/', $ac16_dataassinatura)));


    if (
      $datainicio < $dataassinatura  || $datafim < $dataassinatura
      || $dataapostila < $dataassinatura
    ) {
      $erro = true;
      $erro_msg = "Apostilamento: $posicao \nData de assinatura/vigencia de apostilamento não pode ser \nanterior a data de assinatura do contrato";
    }

    if ($datainicio > $datafim) {
      $erro = true;
      $erro_msg = "Apostilamento: $posicao \nData inicial da vigencia nao pode ser posterior a data fim.";
    }

    if ($erro != true) {
      db_query("update acordovigencia set ac18_datainicio = '$datainicio', ac18_datafim = '$datafim' WHERE ac18_acordoposicao = $posicao;");
      db_query("update apostilamento set si03_dataapostila = '$dataapostila',si03_datareferencia = '$dataapostilareferencia' WHERE si03_acordoposicao = $posicao;");
      db_query("update acordoposicao set ac26_numeroapostilamento = '$numeroapostilamento' WHERE ac26_sequencial = $posicao;");
    }
  }

  if ($erro) {
    db_msgbox($erro_msg);
    $erro_msg = "";
  }

  $clacordo->alteracaoCriterioReajuste($ac16_sequencial,$ac16_reajuste,$ac16_criterioreajuste,$ac16_datareajuste,$ac16_periodoreajuste,$ac16_indicereajuste,$ac16_descricaoreajuste,$ac16_descricaoindice);

  $rsPosicoes = db_query(
    "select distinct
                ac26_sequencial as POSICAO,
                            ac18_sequencial,
                            ac18_datainicio,
                            ac18_datafim,
                            ac35_dataassinaturatermoaditivo
              from
                acordoposicao
              inner join acordo on
                acordo.ac16_sequencial = acordoposicao.ac26_acordo
                inner join acordoposicaotipo on
                acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
                inner join cgm on
                cgm.z01_numcgm = acordo.ac16_contratado
                inner join db_depart on
                db_depart.coddepto = acordo.ac16_coddepto
                inner join acordogrupo on
                acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
                inner join acordosituacao on
                acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
                left join acordocomissao on
                acordocomissao.ac08_sequencial = acordo.ac16_acordocomissao
                inner join acordovigencia on
                ac26_sequencial = ac18_acordoposicao
                left join acordoposicaoaditamento on
                ac26_sequencial = ac35_acordoposicao
                inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
                where ac16_sequencial = '$ac16_sequencial'"
  );

  $consultaAditivo = db_query("select distinct
                ac26_sequencial as POSICAO,
                            ac18_sequencial,
                            ac16_datainicio,
                            ac16_datafim,
                            ac18_datainicio,
                            ac18_datafim,
                            ac35_dataassinaturatermoaditivo,
                            ac26_numeroaditamento
              from
                acordoposicao
              inner join acordo on
                acordo.ac16_sequencial = acordoposicao.ac26_acordo
                inner join acordoposicaotipo on
                acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
                inner join cgm on
                cgm.z01_numcgm = acordo.ac16_contratado
                inner join db_depart on
                db_depart.coddepto = acordo.ac16_coddepto
                inner join acordogrupo on
                acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
                inner join acordosituacao on
                acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
                inner join acordovigencia on
                ac26_sequencial = ac18_acordoposicao
                inner join acordoposicaoaditamento on
                ac26_sequencial = ac35_acordoposicao
                inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
                where ac16_sequencial = '$ac16_sequencial' order by posicao");

  if (pg_num_rows($rsPosicoes) > 1) {
    $aditivo = true;

    $rsApostilamento = db_query(
      " select * from apostilamento
      join acordoposicao on ac26_sequencial=si03_acordoposicao
      join acordovigencia on ac18_acordoposicao=ac26_sequencial
      where ac26_acordo='$ac16_sequencial';"
    );

    $rsAditivo = db_query(
      "select distinct
        ac26_sequencial as POSICAO,
                    ac18_sequencial,
                    ac16_datainicio,
                    ac16_datafim,
                    ac18_datainicio,
                    ac18_datafim,
                    ac35_dataassinaturatermoaditivo,
                    ac35_datapublicacao,
                    ac26_numeroaditamento
      from
        acordoposicao
      inner join acordo on
        acordo.ac16_sequencial = acordoposicao.ac26_acordo
        inner join acordoposicaotipo on
        acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
        inner join cgm on
        cgm.z01_numcgm = acordo.ac16_contratado
        inner join db_depart on
        db_depart.coddepto = acordo.ac16_coddepto
        inner join acordogrupo on
        acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
        inner join acordosituacao on
        acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
        inner join acordovigencia on
        ac26_sequencial = ac18_acordoposicao
        inner join acordoposicaoaditamento on
        ac26_sequencial = ac35_acordoposicao
        inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
        where ac16_sequencial = '$ac16_sequencial' order by posicao"
    );

    for ($iCont = 0; $iCont < pg_num_rows($consultaAditivo); $iCont++) {
      $oPosicao = db_utils::fieldsMemory($consultaAditivo, $iCont);
      $numeroaditamento = "ac26_numeroaditamento_{$oPosicao->ac18_sequencial}";
      $clacordoposicao->ac26_numeroaditamento = $$numeroaditamento;

      if (empty($clacordoposicao->ac26_numeroaditamento)) {
        db_msgbox("O preenchimento do número do aditamento é obrigatório !");
        $erro = true;
      }
    }
  }




  if ($ac16_licitacao != null) {
    $resultado = db_query("select * from liclicita where l20_codigo = '$ac16_licitacao'");
    $licitacao = db_utils::fieldsMemory($resultado, 0);
    $clacordo->ac16_numeroprocesso = $licitacao->l20_edital;

    $resultadocflicita = db_query("Select * from cflicita inner join liclicita on cflicita.l03_codigo = liclicita.l20_codtipocom where l03_codigo = '$licitacao->l20_codtipocom' and l20_codigo = '$ac16_licitacao';
    ");

    $cflicita = db_utils::fieldsMemory($resultadocflicita, 0);
    db_query("update acordo set ac16_numodalidade = '$licitacao->l20_numero', ac16_tipomodalidade = '$cflicita->l03_descr' WHERE ac16_sequencial = '$ac16_sequencial';");
  }

  $ac16_datainicio = implode('-', array_reverse(explode('/', $ac16_datainicio)));
  $ac16_datafim = implode('-', array_reverse(explode('/', $ac16_datafim)));

  if ($ac16_numeroacordo != $ac16_numeroacordo_old) {
    $sWhere = "ac16_numeroacordo = '$ac16_numeroacordo' and ac16_anousu = $anousu and ac16_instit = $instit ";

    $numero_geral = $clacordo->sql_record($clacordo->sql_query_file(null, '*', null, $sWhere));

    if ($clacordo->numrows > 0) {
      db_msgbox("Já existe acordo com o número $ac16_numeroacordo");
      $erro = true;
    }
  }

  if ($ac26_numeroaditamento != $ac26_numeroaditamento_old) {
    $sWhere = "ac26_numeroaditamento = '$ac26_numeroaditamento' and ac26_acordo = $ac16_sequencial";

    $numadt = $clacordoposicao->sql_record($clacordoposicao->sql_query(null, 'ac26_sequencial', null, $sWhere));

    if ($clacordoposicao->numrows > 0) {
      db_msgbox("Já existe aditamento com o número $ac26_numeroaditamento");
      $erro = true;
    }
  }

  for ($iCont = 0; $iCont < pg_num_rows($rsPosicoes); $iCont++) {
    $oPosicao = db_utils::fieldsMemory($rsPosicoes, $iCont);

    if ($aditivo) {

      $inicio = 'ac18_datainicio_' . $oPosicao->ac18_sequencial;
      $fim = 'ac18_datafim_' . $oPosicao->ac18_sequencial;
      $dataaditivo = 'ac35_dataassinaturatermoaditivo_' . $oPosicao->ac18_sequencial;
      $dataaditivoreferencia = 'ac35_datareferencia_' . $oPosicao->ac18_sequencial;

      $dTinicio = '';
      $dTfim = '';
      $dTassaditivo = '';
      $dTassaditivoreferencia = '';

      $dTinicio = implode('-', array_reverse(explode('/', $$inicio)));
      $dTfim = implode('-', array_reverse(explode('/', $$fim)));
      $dTassaditivo = implode('-', array_reverse(explode('/', $$dataaditivo)));
      $dTassaditivoreferencia = implode('-', array_reverse(explode('/', $$dataaditivoreferencia)));
      $dataassinatura = implode('-', array_reverse(explode('/', $ac16_dataassinatura)));

      if ($dTassaditivo != "") {



        if ($dTinicio > $dTfim) {
          $erro = true;
          $erro_msg = "Aditamento: $oPosicao->posicao \nData inicial da vigencia nao pode ser posterior a data fim.";
        }
        if (
          $dTinicio < $dataassinatura  || $dTfim < $dataassinatura
          || $dTassaditivo < $dataassinatura
        ) {
          $erro = true;
          $erro_msg = "Aditamento: $oPosicao->posicao \nData de assinatura/vigencia de aditamento não pode ser \nanterior a data de assinatura do contrato";
        }
      }
    }
  }
  if ($erro_msg != "") {
    db_msgbox($erro_msg);
  }



  if (!isset($erro)) {

    $resprimeirapos = db_query("select min(ac26_sequencial) as primeirapos from acordoposicao where ac26_acordo=$ac16_sequencial");
    $oDaoprimeirapos = pg_result($resprimeirapos, 0);
    for ($iCont = 0; $iCont < pg_num_rows($rsPosicoes); $iCont++) {
      $oPosicao = db_utils::fieldsMemory($rsPosicoes, $iCont);

      if ($aditivo) {     

        $inicio = 'ac18_datainicio_' . $oPosicao->ac18_sequencial;
        $fim = 'ac18_datafim_' . $oPosicao->ac18_sequencial;
        $dataaditivo = 'ac35_dataassinaturatermoaditivo_' . $oPosicao->ac18_sequencial;
        $dataaditivoreferencia = 'ac35_datareferencia_' . $oPosicao->ac18_sequencial;
        $datapublicacao = 'ac35_datapublicacao_' . $oPosicao->ac18_sequencial;

        $dTinicio = '';
        $dTfim = '';
        $dTassaditivo = '';
        $dTassaditivoreferencia = '';

        $dTinicio = implode('-', array_reverse(explode('/', $$inicio)));
        $dTfim = implode('-', array_reverse(explode('/', $$fim)));
        $dTassaditivo = implode('-', array_reverse(explode('/', $$dataaditivo)));
        $dTassaditivoreferencia = implode('-', array_reverse(explode('/', $$dataaditivoreferencia)));

        if($$datapublicacao != ""){
          $ac35_datapublicacao = implode('-', array_reverse(explode('/', $$datapublicacao)));
          db_query("update acordoposicaoaditamento set ac35_datapublicacao = '$ac35_datapublicacao' where ac35_acordoposicao = '$oPosicao->posicao'");
        }

        if (!empty($dTinicio) && !empty($dTfim)) {
          db_query("update acordovigencia  set ac18_datainicio = '$dTinicio', ac18_datafim  = '$dTfim' where ac18_acordoposicao  = '$oPosicao->posicao'");
          db_query("update acordoitemperiodo set ac41_datainicial = '$dTinicio', ac41_datafinal = '$dTfim' where ac41_acordoposicao = '$oPosicao->posicao'");
        }
        if (!empty($dTassaditivo)) {
          db_query("update acordoposicaoaditamento set ac35_dataassinaturatermoaditivo = '$dTassaditivo' where ac35_acordoposicao = '$oPosicao->posicao'");
        }
        if (!empty($dTassaditivoreferencia)) {
          db_query("update acordoposicaoaditamento set ac35_datareferencia = '$dTassaditivoreferencia' where ac35_acordoposicao = '$oPosicao->posicao'");
        }
      } else {
        $dTinicio = implode('-', array_reverse(explode('/', $ac16_datainicio)));
        $dTfim = implode('-', array_reverse(explode('/', $ac16_datafim)));

        db_query("update acordovigencia  set ac18_datainicio = '$dTinicio', ac18_datafim  = '$dTfim' where ac18_acordoposicao  = '$oPosicao->posicao'");
        db_query("update acordoitemperiodo set ac41_datainicial = '$dTinicio', ac41_datafinal = '$dTfim' where ac41_acordoposicao = '$oPosicao->posicao'");
      }
      if ($oDaoprimeirapos == $oPosicao->posicao) {
        $dTinicio = implode('-', array_reverse(explode('/', $ac16_datainicio)));
        $dTfim = implode('-', array_reverse(explode('/', $ac16_datafim)));
        db_query("update acordovigencia  set ac18_datainicio = '$dTinicio', ac18_datafim  = '$dTfim' where ac18_acordoposicao  = '$oPosicao->posicao'");
      }


      $resmanut = db_query("select nextval('db_manut_log_manut_sequencial_seq') as seq");
      $seq = pg_result($resmanut, 0, 0);

      $result = db_query("insert into db_manut_log values($seq,'Vigencia anterior: " . $oPosicao->ac16_datainicio . ' - ' . $oPosicao->ac16_datafim . ' atual: ' . $ac16_datainicio . ' - ' . $ac16_datafim . "  '," . db_getsession('DB_datausu') . ',' . db_getsession('DB_id_usuario') . ')');

      $numeroaditamento = "ac26_numeroaditamento_{$oPosicao->ac18_sequencial}";
      $clacordoposicao->ac26_numeroaditamento = $$numeroaditamento;
      $clacordoposicao->alterar_numaditamento($oPosicao->posicao);
    }

    $clacordo->ac16_numero = $ac16_numeroacordo;
    $clacordo->alterar($ac16_sequencial);

    if ($clacordo->erro_status == '0') {
      db_msgbox($clacordo->erro_msg);
      $sqlerro = true;
    }

      $sSqlMaxmanutac = $clmanutencaoacordo->sql_query_file(null, "max(manutac_sequencial)", null, "manutac_acordo = $ac16_sequencial");
      $clmanutencaoacordo->sql_record($sSqlMaxmanutac);

      if ($clmanutencaoacordo->numrows > 0) {
        $clmanutencaoacordo->excluir('', "manutac_acordo = $ac16_sequencial");
      }

      $clmanutencaoacordo->manutac_acordo = $ac16_sequencial;
      $clmanutencaoacordo->manutac_codunidsubanterior = $manutac_codunidsubanterior;
      $clmanutencaoacordo->manutac_numeroant = $manutac_numeroant;
      $clmanutencaoacordo->incluir();
    
   
    function alteracaoTipoOrigem($ac16_tipoorigem,$ac16_licitacao,$ac16_licoutroorgao,$ac16_adesaoregpreco,$ac16_sequencial,$ac16_origem){
      if ($ac16_tipoorigem == 1) {

        if($ac16_origem == 2){
           db_msgbox(" Usuário: Para a origem Licitação, só poderão ser selecionados os tipos origem Licitação ou Dispensas e Inexigibilidades");
           return true;
        }
        
        $rsPc50_codcom = db_query("select pc50_codcom from pctipocompra where pc50_pctipocompratribunal = 13;");
        $pc50_codcom = db_utils::fieldsMemory($rsPc50_codcom, 0)->pc50_codcom;

        db_query("UPDATE empautoriza
        SET e54_adesaoregpreco = null, e54_numerl = null, e54_nummodalidade = null,e54_codlicitacao = null,e54_licoutrosorgaos = null,e54_codcom = $pc50_codcom
        where e54_autori in (select ac45_empautoriza from acordoempautoriza where ac45_acordo = $ac16_sequencial);");
        
        db_query("UPDATE empempenho
        SET e60_numerol = null,e60_codcom = $pc50_codcom
        where e60_numemp in (select e100_numemp from empempenhocontrato where e100_acordo = $ac16_sequencial);");

        db_query("UPDATE acordo SET ac16_licitacao = null, ac16_licoutroorgao = null,ac16_adesaoregpreco = null where ac16_sequencial = $ac16_sequencial");

        return false;
      }
  
      if ($ac16_tipoorigem == 2 || $ac16_tipoorigem == 3) {

        if($ac16_licitacao == ""){
          db_msgbox("Informe a licitação");
          return true;
        } 
  
        $rsLiclicita = db_query("select l03_codcom,l20_edital,l20_anousu,l20_numero from liclicita 
        inner join cflicita on l03_codigo = l20_codtipocom where l20_codigo = $ac16_licitacao;");
        $l20_edital = db_utils::fieldsMemory($rsLiclicita, 0)->l20_edital;
        $l20_anousu = db_utils::fieldsMemory($rsLiclicita, 0)->l20_anousu;
        $l20_numero = db_utils::fieldsMemory($rsLiclicita, 0)->l20_numero;
        $pc50_codcom = db_utils::fieldsMemory($rsLiclicita, 0)->l03_codcom;
  
        $e54_numerl = "$l20_edital/$l20_anousu";
  
        db_query("UPDATE empautoriza
        SET e54_adesaoregpreco = null,e54_nummodalidade = $l20_numero,e54_licoutrosorgaos = null,e54_numerl = '$e54_numerl', e54_codcom = $pc50_codcom, e54_codlicitacao = $ac16_licitacao
        where e54_autori in (select ac45_empautoriza from acordoempautoriza where ac45_acordo = $ac16_sequencial);");
  
        db_query("UPDATE empempenho
        SET e60_numerol = '$e54_numerl',e60_codcom = $pc50_codcom
        where e60_numemp in (select e100_numemp from empempenhocontrato where e100_acordo = $ac16_sequencial);");

        db_query("UPDATE acordo SET ac16_licitacao = $ac16_licitacao, ac16_licoutroorgao = null,ac16_adesaoregpreco = null where ac16_sequencial = $ac16_sequencial");


        return false;

      }
  
      if ($ac16_tipoorigem == 4) {

        if($ac16_origem == 2){
          db_msgbox(" Usuário: Para a origem Licitação, só poderão ser selecionados os tipos origem Licitação ou Dispensas e Inexigibilidades");
          return true;
       }

        if($ac16_adesaoregpreco == ""){
          db_msgbox("Informe a adesão de registro de preço");
          return true;
        } 

        $rsPc50_codcom = db_query("select pc50_codcom from pctipocompra where pc50_pctipocompratribunal = 104;");
        $pc50_codcom = db_utils::fieldsMemory($rsPc50_codcom, 0)->pc50_codcom;
  
        $rsAdesaoregprecos = db_query("select si06_numeroadm,si06_anomodadm,si06_nummodadm from adesaoregprecos where si06_sequencial = $ac16_adesaoregpreco");
        $si06_numeroadm = db_utils::fieldsMemory($rsAdesaoregprecos, 0)->si06_numeroadm;
        $si06_anomodadm = db_utils::fieldsMemory($rsAdesaoregprecos, 0)->si06_anomodadm;
        $si06_nummodadm = db_utils::fieldsMemory($rsAdesaoregprecos, 0)->si06_nummodadm;
  
  
        $e54_numerl = "$si06_numeroadm/$si06_anomodadm";
  
        db_query("UPDATE empautoriza
        SET e54_adesaoregpreco = $ac16_adesaoregpreco, e54_numerl = '$e54_numerl', e54_nummodalidade = $si06_nummodadm, e54_codcom = $pc50_codcom,e54_licoutrosorgaos = null,e54_codlicitacao = null
        where e54_autori in (select ac45_empautoriza from acordoempautoriza where ac45_acordo = $ac16_sequencial);");
  
        db_query("UPDATE empempenho
        SET e60_numerol = '$e54_numerl',e60_codcom = $pc50_codcom
        where e60_numemp in (select e100_numemp from empempenhocontrato where e100_acordo = $ac16_sequencial);");

        db_query("UPDATE acordo SET ac16_licitacao = null, ac16_licoutroorgao = null,ac16_adesaoregpreco = $ac16_adesaoregpreco where ac16_sequencial = $ac16_sequencial");

        return false;

      }
  
      if ($ac16_tipoorigem == 5 || $ac16_tipoorigem == 6 || $ac16_tipoorigem == 7 || $ac16_tipoorigem == 8 || $ac16_tipoorigem == 9) {
          
        if($ac16_origem == 2){
          db_msgbox(" Usuário: Para a origem Licitação, só poderão ser selecionados os tipos origem Licitação ou Dispensas e Inexigibilidades");
          return true;
       }

        if($ac16_licoutroorgao == ""){
          db_msgbox("Informe a licitação de outro órgão");
          return true;
        } 

        $aCodtribunal = array(5 => "105", 6 => "106", 7 => "107", 8 => "108", 9 => "109");
        $pc50_pctipocompratribunal = $aCodtribunal[$ac16_tipoorigem];
  
  
        $rsPc50_codcom = db_query("select pc50_codcom from pctipocompra where pc50_pctipocompratribunal = $pc50_pctipocompratribunal;");
        $pc50_codcom = db_utils::fieldsMemory($rsPc50_codcom, 0)->pc50_codcom;
  
        $rsLiclicita = db_query("select lic211_processo,lic211_anousu,lic211_numero from liclicitaoutrosorgaos where lic211_sequencial = $ac16_licoutroorgao;");
        $l20_edital = db_utils::fieldsMemory($rsLiclicita, 0)->lic211_processo;
        $l20_anousu = db_utils::fieldsMemory($rsLiclicita, 0)->lic211_anousu;
        $lic211_numero = db_utils::fieldsMemory($rsLiclicita, 0)->lic211_numero;
  
  
        $e54_numerl = "$l20_edital/$l20_anousu";
  
        db_query("UPDATE empautoriza
        SET e54_adesaoregpreco = null,e54_nummodalidade = $lic211_numero,e54_licoutrosorgaos = $ac16_licoutroorgao,e54_numerl = '$e54_numerl', e54_codcom = $pc50_codcom, e54_codlicitacao = null
        where e54_autori in (select ac45_empautoriza from acordoempautoriza where ac45_acordo = $ac16_sequencial);");
  
        db_query("UPDATE empempenho
        SET e60_numerol = '$e54_numerl',e60_codcom = $pc50_codcom
        where e60_numemp in (select e100_numemp from empempenhocontrato where e100_acordo = $ac16_sequencial);");

        db_query("UPDATE acordo SET ac16_licitacao = null, ac16_licoutroorgao = $ac16_licoutroorgao,ac16_adesaoregpreco = null where ac16_sequencial = $ac16_sequencial");

        return false;

      }
    }

    $sqlerro = alteracaoTipoOrigem($ac16_tipoorigem,$ac16_licitacao,$ac16_licoutroorgao,$ac16_adesaoregpreco,$ac16_sequencial,$ac16_origem);


    if ($sqlerro == false && $clacordo->erro_status != '0') {
      db_msgbox('Alteração efetuada');

      $rsApostilamento = db_query(
        " select * from apostilamento
        join acordoposicao on ac26_sequencial=si03_acordoposicao
        join acordovigencia on ac18_acordoposicao=ac26_sequencial
        where ac26_acordo='$ac16_sequencial';"
      );

      if ($aditivo) {

        $rsAditivo = db_query(
          "select distinct
                ac26_sequencial as POSICAO,
                            ac18_sequencial,
                            ac16_datainicio,
                            ac16_datafim,
                            ac18_datainicio,
                            ac18_datafim,
                            ac35_dataassinaturatermoaditivo,
                            ac35_datareferencia,
                            ac35_datapublicacao,
                            ac26_numeroaditamento
              from
                acordoposicao
              inner join acordo on
                acordo.ac16_sequencial = acordoposicao.ac26_acordo
                inner join acordoposicaotipo on
                acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
                inner join cgm on
                cgm.z01_numcgm = acordo.ac16_contratado
                inner join db_depart on
                db_depart.coddepto = acordo.ac16_coddepto
                inner join acordogrupo on
                acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
                inner join acordosituacao on
                acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
                inner join acordovigencia on
                ac26_sequencial = ac18_acordoposicao
                inner join acordoposicaoaditamento on
                ac26_sequencial = ac35_acordoposicao
                inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
                where ac16_sequencial = '$ac16_sequencial' order by posicao"
        );
        $result = $clacordo->sql_record($clacordo->sql_query_vinculos($ac16_sequencial, "ac16_sequencial,ac16_resumoobjeto,ac16_datareferencia,ac16_datapublicacao,ac16_veiculodivulgacao,ac16_acordosituacao, ac16_objeto,ac16_origem,ac16_tipoorigem,ac16_licitacao,l20_objeto,ac16_adesaoregpreco,si06_objetoadesao,orgao.z01_nome,ac16_licoutroorgao,ac16_acordogrupo,ac02_descricao,ac16_numeroacordo,ac16_dataassinatura,ac16_datainicio,ac16_datafim,ac16_criterioreajuste,ac16_reajuste,ac16_datareajuste,ac16_periodoreajuste,ac16_indicereajuste,ac16_descricaoreajuste,ac16_descricaoindice", null, ""));

        db_fieldsmemory($result, 0);
      }
    }
  }



  db_fim_transacao($sqlerro);

  $db_opcao = 2;
  $db_botao = true;
} elseif (isset($chavepesquisa)) {
  $db_opcao = 2;
  $db_botao = true;
  $result = $clacordo->sql_record($clacordo->sql_query_vinculos($chavepesquisa, "ac16_sequencial,ac16_resumoobjeto,ac16_datareferencia,ac16_datapublicacao,ac16_veiculodivulgacao,ac16_acordosituacao, ac16_objeto,ac16_origem,ac16_tipoorigem,ac16_licitacao,l20_objeto,ac16_adesaoregpreco,si06_objetoadesao,orgao.z01_nome,ac16_licoutroorgao,ac16_acordogrupo,ac02_descricao,ac16_numeroacordo,ac16_dataassinatura,ac16_datainicio,ac16_datafim,ac16_reajuste,ac16_criterioreajuste,ac16_datareajuste,ac16_periodoreajuste,ac16_indicereajuste,ac16_descricaoreajuste,ac16_descricaoindice,ac16_anousu", null, ""));

  db_fieldsmemory($result, 0);

  $rsPosicoes = db_query(
    "SELECT distinct ac26_sequencial as POSICAO
        FROM acordo
        inner join acordoposicao on  ac16_sequencial = ac26_acordo
        inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
        inner join acordovigencia on ac18_acordoposicao = ac26_sequencial
        inner join acordoposicaotipo on ac27_sequencial = ac26_acordoposicaotipo
        inner join acordoitem on ac20_acordoposicao = ac26_sequencial
        inner join acordoitemperiodo on ac20_sequencial = ac41_acordoitem
        WHERE ac16_sequencial = '$ac16_sequencial'"
  );

  if (pg_num_rows($rsPosicoes) > 1) {
    $aditivo = true;

    $rsAditivo = db_query(
      "select distinct
            ac26_sequencial as POSICAO,
                        ac18_sequencial,
                        ac18_datainicio,
                        ac18_datafim,
                        ac35_dataassinaturatermoaditivo,
                        ac35_datareferencia,
                        ac35_datapublicacao,
                        ac26_numeroaditamento
          from
            acordoposicao
          inner join acordo on
            acordo.ac16_sequencial = acordoposicao.ac26_acordo
            inner join acordoposicaotipo on
            acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
            inner join cgm on
            cgm.z01_numcgm = acordo.ac16_contratado
            inner join db_depart on
            db_depart.coddepto = acordo.ac16_coddepto
            inner join acordogrupo on
            acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
            inner join acordosituacao on
            acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
            inner join acordovigencia on
            ac26_sequencial = ac18_acordoposicao
            inner join acordoposicaoaditamento on
            ac26_sequencial = ac35_acordoposicao
            inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
            where ac16_sequencial = '$ac16_sequencial' order by posicao"
    );

    $rsApostilamento = db_query(
      " select * from apostilamento
      join acordoposicao on ac26_sequencial=si03_acordoposicao
      join acordovigencia on ac18_acordoposicao=ac26_sequencial
      where ac26_acordo='$ac16_sequencial';"
    );
  }

  db_fieldsmemory($rsAditivo, 0);

  $result = $clmanutencaoacordo->sql_record($clmanutencaoacordo->sql_query('', '*', '', "manutac_acordo = $chavepesquisa"));

  db_fieldsmemory($result, 0);

  $ac16_numeroacordo_old = $ac16_numeroacordo;

  $ac26_numeroaditamento_old = $ac26_numeroaditamento;
}

?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <?php
  db_app::load('scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js');
  db_app::load('widgets/windowAux.widget.js, widgets/DBToogle.widget.js');
  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
  <style>
    .fora {
      background-color: #d1f07c;
    }

    #fieldset_depart_inclusao,
    #fieldset_depart_responsavel {
      width: 500px;
    }

    #fieldset_depart_inclusao table,
    #fieldset_depart_responsavel table {
      margin: 0 auto;
    }

    #ac16_objeto {
      width: 100%;
    }
  </style>
</head>

<body bgcolor="#CCCCCC">
  <?php
  $sContass = explode('.', db_getsession('DB_login'));

  if ($sContass[1] != 'contass') {
    echo '<br><center><br><H2>Essa rotina apenas pode ser usada por usuários da contass</h2></center>';
  } else {
  ?>

    <form name='form1' method="post" action="">
      <div class="container">
        <fieldset>
          <legend><b></b></legend>
          <table>
            <tr>
              <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130">
                <?php db_ancora($Lac16_sequencial, 'js_acordo(true);', 1); ?>
              </td>
              <td colspan="2">
                <?php
                db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
                db_input('ac16_resumoobjeto', 40, $Iac16_resumoobjeto, true, 'text', 3); ?>
              </td>
            </tr>

            <tr>
              <td colspan="2">
                <fieldset>
                  <legend>
                    <b>Objeto</b>
                  </legend>
                  <table cellpadding="0" border="0" width="100%" class="table-vigencia">

                    <tr>


                      <td>
                        <?
                        db_textarea('ac16_objeto', 2, 2, $ac16_objeto, true, 'text', 2, "", "", "", "");
                        ?>
                      </td>

                    </tr>

                  </table>
                </fieldset>
              </td>
            </tr>

            <tr>
                <td nowrap title="Exercício do Contrato">
                    <strong>Exercício:</strong>
                </td>
                <td>
                    <?php
                        db_input('ac16_anousu', 10, 1, true, 'text', 2, "");
                    ?>
                </td>
            </tr>

            <tr>
              <td nowrap title="<?= @$Tac16_origem ?>">
                <?= @$Lac16_origem ?>
              </td>
              <td>
                <?
                if (db_getsession('DB_anousu') <= 2017) {
                  $aValores = array(
                    0 => 'Selecione',
                    1 => 'Processo de Compras',
                    2 => 'Licitação',
                    3 => 'Manual',
                    6 => 'Empenho'
                  );
                } else {
                  $aValores = array(
                    0 => 'Selecione',
                    1 => 'Processo de Compras',
                    2 => 'Licitação',
                    3 => 'Manual'
                  );
                }

                db_select('ac16_origem', $aValores, true, $db_opcao, "onchange='js_verificaorigem();'");

                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?= @$Tac16_tipoorigem ?>">
                <?= @$Lac16_tipoorigem ?>
              </td>
              <td>
                <?
                $aValores = array(
                  0 => 'Selecione',
                  1 => '1 - Não ou dispensa por valor',
                  2 => '2 - Licitação',
                  3 => '3 - Dispensa ou Inexigibilidade',
                  4 => '4 - Adesão à ata de registro de preços',
                  5 => '5 - Licitação realizada por outro órgão ou entidade',
                  6 => '6 - Dispensa ou Inexigibilidade realizada por outro órgão ou entidade',
                  7 => '7 - Licitação - Regime Diferenciado de Contratações Públicas - RDC',
                  8 => '8 - Licitação realizada por consorcio público',
                  9 => '9 - Licitação realizada por outro ente da federação',
                );
                db_select('ac16_tipoorigem', $aValores, true, $db_opcao, "onchange='js_verificatipoorigem()'", "");

                ?>
              </td>
            </tr>
            <? if ($db_opcao == 1) : ?>
              <tr id="credenciamento" style="display: none">
                <td>
                  <strong>Credenciamento/Chamada Pública:</strong>
                </td>
                <td>
                  <?
                  $aValores = array(
                    0 => 'Selecione',
                    1 => '1 - Sim',
                    2 => '2 - Não'
                  );
                  db_select('tipodispenca', $aValores, true, $db_opcao, "", "");
                  ?>
                </td>
              </tr>
            <? endif; ?>
            <tr id="trlicoutroorgao" style="display: none ">
              <td nowrap title="<? @$Tac16_licoutroorgao ?>">
                <?=
                db_ancora("Licitação Outro Órgão:", "js_pesquisaac16_licoutroorgao(true)", $db_opcao);
                ?>
              </td>
              <td>
                <?
                db_input('ac16_licoutroorgao', 10, $Iac16_licoutroorgao, true, 'text', $db_opcao, "onchange='js_pesquisaac16_licoutroorgao(false)';");
                db_input('z01_nome', 43, $Iac02_sequencial, true, 'text', 3);
                ?>
              </td>
            </tr>
            <tr id="tradesaoregpreco" style="display: none">
              <td nowrap title="<? @$Tac16_adesaoregpreco ?>">
                <?=
                db_ancora("Adesão de Registro Preço:", "js_pesquisaaadesaoregpreco(true)", $db_opcao);
                ?>
              </td>
              <td>
                <?
                db_input('ac16_adesaoregpreco', 10, $Iac16_adesaoregpreco, true, 'text', $db_opcao, "onchange='js_pesquisaaadesaoregpreco(false)';");
                db_input('si06_objetoadesao', 43, $Iac02_sequencial, true, 'text', 3);
                ?>
              </td>
            </tr>

            <tr id="trLicitacao" style="display: none ">
              <td nowrap>
                <?
                db_ancora('<b>Licitação:</b>', "js_pesquisa_liclicita(true)", 1);
                ?>
              </td>
              <td>
                <?
                db_input("ac16_licitacao", 10, $Iac16_licitacao, true, "text", 1, "onchange='js_pesquisa_liclicita(false)'");
                db_input("l20_objeto", 40, $Il20_objeto, true, "text", 3, '');
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?= @$Tac16_acordogrupo ?>">
                <?
                db_ancora("Natureza do Contrato:", "js_pesquisaac16_acordogrupo(true);", $db_opcao);
                ?>
              </td>
              <td>
                <?
                db_input(
                  'ac16_acordogrupo',
                  10,
                  $Iac16_acordogrupo,
                  true,
                  'text',
                  $db_opcao,
                  "onchange='js_pesquisaac16_acordogrupo(false);'"
                );
                db_input('ac02_descricao', 30, $Iac02_sequencial, true, 'text', 3);
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="Codunidsubanterior">
                <strong>Codunidsubanterior:</strong>
              </td>
              <td>
                <?
                db_input('manutac_codunidsubanterior', 10, $Imanutac_codunidsubanterior, true, 'text', 2, "");
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="">
                <strong>Nº Contrato Anterior:</strong>
              </td>
              <td>
                <?
                db_input('manutac_numeroant', 10, $Imanutac_numeroant, true, 'text', 2, "");
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?= @$Tac16_numeroacordo ?>">
                <?= @$Lac16_numeroacordo ?>
              </td>
              <td>
                <?php db_input('ac16_numeroacordo', 10, $Iac16_numeroacordo, true, 'text', $db_opcao);
                db_input('ac16_numeroacordo_old', 10, $Iac16_numeroacordo, true, 'hidden', 2, ''); ?>
              </td>
            </tr>
            <tr>
              <td nowrap><?= $Lac16_dataassinatura ?>
              </td>
              <td>
                <?=
                db_inputdata(
                  'ac16_dataassinatura',
                  @$ac16_dataassinatura_dia,
                  @$ac16_dataassinatura_mes,
                  @$ac16_dataassinatura_ano,
                  true,
                  'text',
                  $iOpcao
                ); ?>
              </td>
            </tr>
            <tr>
              <td nowrap><?php echo "<b>Data de Referência</b>"; ?>
              </td>
              <td>
                <?=

                db_inputdata(
                  'ac16_datareferencia',
                  @$ac16_datareferencia_dia,
                  @$ac16_datareferencia_mes,
                  @$ac16_datareferencia_ano,
                  true,
                  'text',
                  $iOpcao
                );
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap>
                <b>Data da Publicação</b>
              </td>
              <td>
                <?=
                db_inputdata(
                  'ac16_datapublicacao',
                  @$ac16_datapublicacao_dia,
                  @$ac16_datapublicacao_mes,
                  @$ac16_datapublicacao_ano,
                  true,
                  'text',
                  $iOpcao
                );
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap>
                <b>Veículo de Divulgação</b>
              </td>
              <td>
                <?=
                db_textarea('ac16_veiculodivulgacao', 0, 65, $Iac16_veiculodivulgacao, true, 'text', $db_opcao, "");
                ?>
              </td>
            </tr>


            <tr>
              <td nowrap><?= $Lac16_acordosituacao ?>
              </td>
              <td>
                <?=

                db_select('ac16_acordosituacao', array('1' => 'Ativo', '4' => 'Homologado'), true, $db_opcao, "", "");
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <fieldset class='fieldsetinterno'>
                  <legend>
                    <b>Vigência</b>
                  </legend>
                  <table cellpadding="0" border="0" width="100%" class="table-vigencia">
                    <tr>
                      <td width="1%">
                        <b>Inicio:</b>
                      </td>
                      <td>
                        <?php $iCampo = 2; ?>
                        <?=
                        db_inputdata(
                          'ac16_datainicio',
                          @$ac16_datainicio_dia,
                          @$ac16_datainicio_mes,
                          @$ac16_datainicio_ano,
                          true,
                          'text',
                          $iCampo
                        ); ?>
                      </td>
                      <td>
                        <b>Fim:</b>
                      </td>
                      <td>
                        <?=

                        db_inputdata(
                          'ac16_datafim',
                          @$ac16_datafim_dia,
                          @$ac16_datafim_mes,
                          @$ac16_datafim_ano,
                          true,
                          'text',
                          $iCampo,
                          "",
                          '',
                          '',
                          ''
                        ); ?>
                      </td>
                    </tr>
                  </table>
                </fieldset>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <table>
                  <tr>
                    <td id='tdpossuireajuste' width="300px">
                      <b>Possui Critério Reajuste:</b>

                        <?
                        $aPossui = array(
                          0 => 'Selecione',
                          "t" => 'Sim',
                          "f" => 'Não'
                        );
                          db_select('ac16_reajuste', $aPossui, true, $db_opcao, "onchange='js_possuireajuste()'", "");
                          ?>
                    </td>

                    <td width="23%" id='tdcriterioreajuste' style="display: none;">
                      <b>Critério de Reajuste:</b>

                      <?
                      $aCriterios = array(
                          0 => 'Selecione',
                          1 => 'Índice Único',
                          2 => 'Cesta de Índices',
                          3 => 'Índice Específico'
                      );
                      db_select('ac16_criterioreajuste', $aCriterios, true, $db_opcao, "onchange='js_criterio()'", "");
                      ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          <tr>
            <td colspan="2">
              <table border="0">
                <tr id='trdatareajuste' style="display: none;">
                  <td width="140px">
                    <b>Data Base Reajuste:</b>
                  </td>
                  <td width="160px">
                   <?
                    db_inputdata(
                        'ac16_datareajuste',
                         @$ac16_datareajuste_dia,
                         @$ac16_datareajuste_mes,
                         @$ac16_datareajuste_ano,
                         true,
                         'text',
                         $iCampo,
                         "onchange='return js_somardias();'",
                          "",
                          "",
                          "return parent.js_somardias();"
                          );
                          ?>
                  </td>

                  <td id='tdindicereajuste' style="display: none;">
                    <b>Índice de Reajuste:</b>

                      <?
                      $aIndice = array(
                          0 => 'Selecione',
                          1 => 'IPCA',
                          2 => 'INPC',
                          3 => 'INCC',
                          4 => 'IGP-M',
                          5 => 'IGP-DI',
                          6 => 'Outro'
                          );
                      db_select('ac16_indicereajuste', $aIndice, true, $db_opcao, "onchange='js_indicereajuste()'", "");
                      ?>
                  </td>
                </tr>
                <tr id='trperiodoreajuste' style="display: none;">
                  <td width="140px">
                    <b>Período do Reajuste:</b>
                  </td>
                  <td>
                    <?
                    db_input('ac16_periodoreajuste', 12, 1, true, $db_opcao, "", "", "", "", "", 2);
                    ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
            <tr id='trdescricaoreajuste' style="display: none;">
              <td>
                <b> Descrição do Critério de Reajuste </b>
              </td>
              <td>
                <?
                db_textarea('ac16_descricaoreajuste', 3, 69, '', true, 'text', $db_opcao, "", "", "", "300");
                ?>
              </td>
            </tr>
            <tr id='trdescricaoindicereajuste' style="display: none;">
              <td>
                <b> Descrição do Índice de Reajuste </b>
              </td>
              <td>
                <?
                db_textarea('ac16_descricaoindice', 3, 69, '', true, 'text', $db_opcao, "", "", "", "300");
                ?>
              </td>
            </tr>
            <?php

            if ($aditivo) :

              for ($i = 0; $i < pg_numrows($rsAditivo); $i++) {
                db_fieldsmemory($rsAditivo, $i); ?>
                <tr>
                  <td colspan="2">
                    <fieldset class='fieldsetinterno'>
                      <legend>
                        <b>Aditivo <?php echo $posicao ?></b>
                      </legend>
                      <table cellpadding="0" border="0" width="100%" class="table-vigencia">
                        <tr width="1%">
                          <td nowrap title="numero aditamento">
                            <strong>Nº Aditamento: </strong>
                          <td>
                            <?php
                            $numadtm = "ac26_numeroaditamento_{$ac18_sequencial}";
                            $numadtmOld = "ac26_numeroaditamento_old_{$ac18_sequencial}";
                            $$numadtm = $ac26_numeroaditamento;
                            $$numadtmOld = $ac26_numeroaditamento;
                            db_input("ac26_numeroaditamento_{$ac18_sequencial}", 10, 1, true, "text", 2, "");
                            db_input("ac26_numeroaditamento_old_{$ac18_sequencial}", 10, $Iac26_sequencial, true, 'hidden', 2, "");
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td width="1%">
                            <b>Inicio:</b>
                          </td>
                          <td>
                            <?php
                            $iCampo = 2;
                            db_inputdata(
                              "ac18_datainicio_$ac18_sequencial",
                              @$ac18_datainicio_dia,
                              @$ac18_datainicio_mes,
                              @$ac18_datainicio_ano,
                              true,
                              'text',
                              $iCampo
                            ); ?>
                          </td>
                          <td>
                            <b>Fim:</b>
                          </td>
                          <td>
                            <?php
                            db_inputdata(
                              "ac18_datafim_$ac18_sequencial",
                              @$ac18_datafim_dia,
                              @$ac18_datafim_mes,
                              @$ac18_datafim_ano,
                              true,
                              'text',
                              $iCampo
                            ); ?>
                          </td>
                          <td nowrap><?= $Lac16_dataassinatura ?>
                          </td>
                          <td>
                            <?php
                            db_inputdata(
                              "ac35_dataassinaturatermoaditivo_$ac18_sequencial",
                              @$ac35_dataassinaturatermoaditivo_dia,
                              @$ac35_dataassinaturatermoaditivo_mes,
                              @$ac35_dataassinaturatermoaditivo_ano,
                              true,
                              'text',
                              $iOpcao
                            ); ?>
                          </td>
                          <td nowrap><?php echo "<b>Data de Referência</b>"; ?>
                          </td>
                          <td>
                            <?php
                            db_inputdata(
                              "ac35_datareferencia_$ac18_sequencial",
                              @$ac35_datareferencia_dia,
                              @$ac35_datareferencia_mes,
                              @$ac35_datareferencia_ano,
                              true,
                              'text',
                              $iOpcao,
                              "class='numeroaditivo'"
                            ); ?>
                          </td>
                          <td><b>Data de Publicação:</b></td>
                          <td>
                          <?php
                            db_inputdata(
                              "ac35_datapublicacao_$ac18_sequencial",
                              @$ac35_datapublicacao_dia,
                              @$ac35_datapublicacao_mes,
                              @$ac35_datapublicacao_ano,
                              true,
                              'text',
                              $iOpcao,
                              "class='datapublicacaoaditamento'"
                             ); ?>
                          </td>
                        </tr>
                      </table>
                    </fieldset>
                  </td>
                </tr>
            <?php
              }
            endif; ?>
            <?php

            if (pg_numrows($rsApostilamento) > 0) :

              for ($i = 0; $i < pg_numrows($rsApostilamento); $i++) {
                db_fieldsmemory($rsApostilamento, $i); ?>
                <tr>
                  <td colspan="2">
                    <fieldset class='fieldsetinterno'>
                      <legend>
                        <b>Apostilamento <?php echo $ac26_sequencial; ?></b>
                      </legend>
                      <table cellpadding="0" border="0" width="100%" class="table-vigencia">
                        <tr width="1%">

                          <td nowrap title="numero aditamento">
                            <strong>Nº Apostilamento: </strong>
                          </td>
                          <td>
                            <?php
                            db_input("ac26_sequencial", 10, $ac26_sequencial, true, "hidden", 2, "class='ac26_sequencial'");
                            db_input("ac26_numeroapostilamento", 10, 1, true, "text", 2, "class='numeroapostilamento'");

                            ?>
                          </td>

                        </tr>
                        <tr>
                          <td width="1%">
                            <b>Inicio:</b>
                          <td>
                            <?php
                            $iCampo = 2;
                            db_inputdata(
                              "ac18_datainicio_$ac18_sequencial",
                              @$ac18_datainicio_dia,
                              @$ac18_datainicio_mes,
                              @$ac18_datainicio_ano,
                              true,
                              'text',
                              $iCampo,
                              " onkeypress='mascaraData(this)' class='datainicio'"
                            ); ?>
                          </td>


                          <td>
                            <b>Fim:</b>
                          </td>
                          <td>
                            <?php
                            db_inputdata(
                              "ac18_datafim_$ac18_sequencial",
                              @$ac18_datafim_dia,
                              @$ac18_datafim_mes,
                              @$ac18_datafim_ano,
                              true,
                              'text',
                              $iCampo,
                              "onkeypress='mascaraData(this)' class='datafim'"
                            ); ?>
                          </td>
                          <td nowrap>
                            <b> Data da apostila: </b>
                          </td>
                          <td>
                            <?php
                            db_inputdata(
                              "si03_dataapostila__$ac18_sequencial",
                              @$si03_dataapostila_dia,
                              @$si03_dataapostila_mes,
                              @$si03_dataapostila_ano,
                              true,
                              'text',
                              $iOpcao,
                              "onkeypress='mascaraData(this)' class='dataapostila'"

                            ); ?>
                          </td>
                          <td nowrap>
                            <b>Data de Referência</b>
                          </td>
                          <td>
                            <?php
                            db_inputdata(
                              "si03_datareferencia_$ac18_sequencial",
                              @$si03_datareferencia_dia,
                              @$si03_datareferencia_mes,
                              @$si03_datareferencia_ano,
                              true,
                              'text',
                              $iOpcao,
                              "onkeypress='mascaraData(this)' class='datareferenciaapostila'"
                            ); ?>
                          </td>
                        </tr>
                      </table>
                    </fieldset>
                  </td>
                </tr>
            <?php
              }
            endif; ?>
          </table>
        </fieldset>
        <input name="alterar" type="submit" id="alterar" value="Alterar" <?= ($db_botao == false ? 'disabled' : '') ?> onclick="return alteraAcordo();">
      </div>
    </form>
    </div>

</body>


</html>
<div style='position:absolute;top: 200px; left:15px;
            border:1px solid black;
            width:400px;
            text-align: left;
            padding:3px;
            z-index:10000;
            background-color: #FFFFCC;
            display:none;' id='ajudaItem'>

</div>
<script>
  function mascaraData(val) {
    var pass = val.value;
    var expr = /[0123456789]/;

    for (i = 0; i < pass.length; i++) {
      // charAt -> retorna o caractere posicionado no índice especificado
      var lchar = val.value.charAt(i);
      var nchar = val.value.charAt(i + 1);

      if (i == 0) {
        // search -> retorna um valor inteiro, indicando a posição do inicio da primeira
        // ocorrência de expReg dentro de instStr. Se nenhuma ocorrencia for encontrada o método retornara -1
        // instStr.search(expReg);
        if ((lchar.search(expr) != 0) || (lchar > 3)) {
          val.value = "";
        }

      } else if (i == 1) {

        if (lchar.search(expr) != 0) {
          // substring(indice1,indice2)
          // indice1, indice2 -> será usado para delimitar a string
          var tst1 = val.value.substring(0, (i));
          val.value = tst1;
          continue;
        }

        if ((nchar != '/') && (nchar != '')) {
          var tst1 = val.value.substring(0, (i) + 1);

          if (nchar.search(expr) != 0)
            var tst2 = val.value.substring(i + 2, pass.length);
          else
            var tst2 = val.value.substring(i + 1, pass.length);

          val.value = tst1 + '/' + tst2;
        }

      } else if (i == 4) {

        if (lchar.search(expr) != 0) {
          var tst1 = val.value.substring(0, (i));
          val.value = tst1;
          continue;
        }

        if ((nchar != '/') && (nchar != '')) {
          var tst1 = val.value.substring(0, (i) + 1);

          if (nchar.search(expr) != 0)
            var tst2 = val.value.substring(i + 2, pass.length);
          else
            var tst2 = val.value.substring(i + 1, pass.length);

          val.value = tst1 + '/' + tst2;
        }
      }

      if (i >= 6) {
        if (lchar.search(expr) != 0) {
          var tst1 = val.value.substring(0, (i));
          val.value = tst1;
        }
      }
    }

    if (pass.length > 10)
      val.value = val.value.substring(0, 10);
    return true;
  }

  // criando array dos campos referente ao apostilamento que serão enviados via POST

  ac26_numeroapostilamento = document.getElementsByClassName('numeroapostilamento');
  ac18_datainicio = document.getElementsByClassName('datainicio');
  ac18_datafim = document.getElementsByClassName('datafim');
  si03_dataapostila = document.getElementsByClassName('dataapostila');
  si03_datareferencia = document.getElementsByClassName('datareferenciaapostila');
  ac26_sequencial = document.getElementsByClassName('ac26_sequencial');
  for (i = 0; i < ac26_numeroapostilamento.length; i++) {
    ac26_numeroapostilamento[i].removeAttribute(" name");
    ac26_numeroapostilamento[i].setAttribute("name", "ac26_numeroapostilamento[]");
    ac18_datainicio[i].removeAttribute("name");
    ac18_datainicio[i].setAttribute("name", "ac18_datainicio[]");
    ac18_datafim[i].removeAttribute("name");
    ac18_datafim[i].setAttribute("name", "ac18_datafim[]");
    si03_dataapostila[i].removeAttribute("name");
    si03_dataapostila[i].setAttribute("name", "si03_dataapostila[]");
    si03_datareferencia[i].removeAttribute("name");
    si03_datareferencia[i].setAttribute("name", "si03_datareferencia[]");
    ac26_sequencial[i].removeAttribute("name");
    ac26_sequencial[i].setAttribute("name", "ac26_sequencial[]");
  }
  if ($('ac16_acordosituacao').value == 1) {
    $('ac16_acordosituacao').options[0].disabled = true;
  } else if ($('ac16_acordosituacao').value == 4) {
    $('ac16_acordosituacao').options[1].disabled = true;
  }

  function alteraAcordo() {

    if (!confirm("Deseja realmente alterar")) {
      return false;
    }

    if(js_validacoesReajuste() == false) return false;

    if (($('ac16_dataassinatura').value == "" || $('ac16_dataassinatura').value == null) && $('ac16_acordosituacao').value == 4) {
      alert("O preenchimento da Data de Assinatura é obrigatório ! ");
      return false;
    }
    if (($('ac16_datapublicacao').value == "" || $('ac16_datapublicacao').value == null) && $('ac16_acordosituacao').value == 4) {
      alert("O preenchimento da Data de Publicação é obrigatório ! ");
      return false;
    }
    if (($('ac16_veiculodivulgacao').value == "" || $('ac16_veiculodivulgacao').value == null) && $('ac16_acordosituacao').value == 4) {
      alert("O preenchimento da Veículo de Divulgação é obrigatório ! ");
      return false;
    }
    


    ac26_numeroapostilamento = document.getElementsByClassName('numeroapostilamento');
    ac16_numeroaditivo = document.getElementsByClassName('numeroaditivo');
    ac18_datainicio = document.getElementsByClassName('datainicio');
    ac18_datafim = document.getElementsByClassName('datafim');
    si03_dataapostila = document.getElementsByClassName('dataapostila');
    si03_datareferencia = document.getElementsByClassName('datareferenciaapostila');
    ac26_sequencial = document.getElementsByClassName('ac26_sequencial');
    aDatasDePublicacaoAditamento = document.getElementsByClassName('datapublicacaoaditamento');

    for(i = 0; i < aDatasDePublicacaoAditamento.length; i++){
      if(aDatasDePublicacaoAditamento[i].value == ""){
        return alert("O preenchimento da data de publicação do aditamento é obrigatório.");
      }
    }

    if (($('ac16_datareferencia').value == "" || $('ac16_datareferencia').value == null) && $('ac16_acordosituacao').value == 4) {
      alert("O preenchimento a data de referência do acordo é obrigatório !");
      return false;
    }
    for (i = 0; i < ac16_numeroaditivo.length; i++) {
      if ((ac16_numeroaditivo[i].value == "" || ac16_numeroaditivo[i].value == null) && $('ac16_acordosituacao').value == 4) {
        alert("O preenchimento a data de referência no aditamento é obrigatório !");
        return false;
      }
    }

    for (i = 0; i < ac26_numeroapostilamento.length; i++) {
      if (ac26_numeroapostilamento[i].value == "") {
        alert("O preenchimento do número do apostilamento é obrigatório !");
        return false;
      }
      if (ac18_datainicio[i].value == "") {
        alert("O preenchimento da data inicial é obrigatório !");
        return false;
      }
      if (ac18_datafim[i].value == "") {
        alert("O preenchimento da data final é obrigatório !");
        return false;
      }
      if (si03_dataapostila[i].value == "") {
        alert("O preenchimento da data de apostilamento é obrigatório !");
        return false;
      }
      if (si03_datareferencia[i].value == "") {
        alert("O preenchimento da data de referência é obrigatório !");
        return false;
      }
    }
  }

  function js_acordo(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_acordo', 'func_acordoinstit.php?funcao_js=parent.js_mostraAcordo1|ac16_sequencial|z01_nome', 'Pesquisa', true);
    } else {
      if ($F('ac16_sequencial').trim() != '') {
        js_OpenJanelaIframe('', 'db_iframe_depart', 'func_acordoinstit.php?pesquisa_chave=' + $F('ac16_sequencial') + '&funcao_js=parent.js_mostraAcordo' + '&descricao=true', 'Pesquisa', false);
      } else {
        $('ac16_resumoobjeto').value = '';
      }
    }
  }

  function js_preenchepesquisa(chave) {
    db_iframe_acordo.hide();
    <?
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>
  }

  function js_mostraAcordo(chave, descricao, erro) {
    $('ac16_resumoobjeto').value = descricao;
    if (erro == true) {
      $('ac16_sequencial').focus();
      $('ac16_sequencial').value = '';
    }
    <?php
    echo " location.href = '" . basename($GLOBALS['HTTP_SERVER_VARS']['PHP_SELF']) .
      "?chavepesquisa='+chave;";
    ?>
  }

  function js_mostraAcordo1(chave1, chave2) {
    $('ac16_sequencial').value = chave1;
    $('ac16_resumoobjeto').value = chave2;
    db_iframe_acordo.hide();
    <?php
    echo " location.href = '" . basename($GLOBALS['HTTP_SERVER_VARS']['PHP_SELF']) .
      "?chavepesquisa='+chave1;";
    ?>
  }

  function js_pesquisa_liclicita(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo.iframe_acordo', 'db_iframe_liclicita', 'func_liclicita.php?&funcao_js=parent.js_preencheLicitacao|l20_codigo|l20_objeto', 'Pesquisa Licitações', true);
    } else {
      if (document.form1.ac16_licitacao.value != '') {
        js_OpenJanelaIframe('top.corpo.iframe_acordo', 'db_iframe_liclicita', 'func_liclicita.php?&pesquisa_chave=' + document.form1.ac16_licitacao.value + '&funcao_js=parent.js_preencheLicitacao1', 'Pesquisa', false);
      } else {
        document.form1.ac16_licitacao.value = '';
      }
    }
  } /** * funcao para preencher licitacao da ancora */
  function js_preencheLicitacao(codigo, objeto) {
    document.form1.ac16_licitacao.value = codigo;
    document.form1.l20_objeto.value = objeto;
    db_iframe_liclicita.hide();
  }

  function js_preencheLicitacao1(objeto) {
    document.form1.l20_objeto.value = objeto;
  }

  function js_pesquisaac16_acordogrupo(mostra) {
    if (mostra == true) {
      var sUrl = 'func_acordogrupo.php?funcao_js=parent.js_mostraacordogrupo1|ac02_sequencial|ac02_descricao';
      js_OpenJanelaIframe('top.corpo.iframe_acordo', 'db_iframe_acordogrupo', sUrl, 'Pesquisar Grupos de Acordo', true, '0');
    } else {
      if ($('ac16_acordogrupo').value != '') {
        js_OpenJanelaIframe('top.corpo.iframe_acordo', 'db_iframe_acordogrupo', 'func_acordogrupo.php?pesquisa_chave=' + $('ac16_acordogrupo').value + '&funcao_js=parent.js_mostraacordogrupo', 'Pesquisar Grupos de Acordo', false, '0');
      } else {
        $('ac02_sequencial').value = '';
      }
    }
  }

  function js_mostraacordogrupo(chave, erro) {
    let chave1 = $('ac16_acordogrupo').value;
    $('ac02_descricao').value = chave;
    if (erro == true) {
      $('ac16_acordogrupo').focus();
      $('ac16_acordogrupo').value = '';
    } else {
      var oGet = js_urlToObject(); /* * Verifica se está sendo setada a variavel chavepesquisa na url. Caso sim, quer dizer que é um procedimento de alteração ou exclusão, * sendo assim o programa não pode chamar a nova numeração * if (!oGet.chavepesquisa) { oContrato.getNumeroAcordo(); }*/
    }
  }

  function js_mostraacordogrupo1(chave1, chave2) {
    $('ac16_acordogrupo').value = chave1;
    $('ac02_descricao').value = chave2;
    $('ac16_acordogrupo').focus();
    db_iframe_acordogrupo.hide();
  } /** *funçao para verificar tipo origem do acordo para listar ancorar relacionada */
  function js_verificatipoorigem() {
    iTipoOrigem = document.form1.ac16_tipoorigem.value;
    iOrigem = document.form1.ac16_origem.value;
    if (iOrigem == 1 && iTipoOrigem == 1) {
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
    if ((iOrigem == 1 && iTipoOrigem == 2) || (iOrigem == 1 && iTipoOrigem == 3)) {
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trLicitacao').style.display = "";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
    if (iOrigem == 1 && iTipoOrigem == 4) {
      document.getElementById('tradesaoregpreco').style.display = "";
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
    if ((iOrigem == 1 && iTipoOrigem == 5) || (iOrigem == 1 && iTipoOrigem == 6) || (iOrigem == 1 && iTipoOrigem == 7) || (iOrigem == 1 && iTipoOrigem == 8) || (iOrigem == 1 && iTipoOrigem == 9)) {
      document.getElementById('trlicoutroorgao').style.display = "";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trLicitacao').style.display = "none";
    }
    if (iOrigem == 2 && iTipoOrigem == 1) {
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
    if ((iOrigem == 2 && iTipoOrigem == 2) || (iOrigem == 2 && iTipoOrigem == 3)) {
      document.getElementById('trLicitacao').style.display = "";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
    if (iOrigem == 2 && iTipoOrigem == 4) {
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('tradesaoregpreco').style.display = "";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
    if ((iOrigem == 2 && iTipoOrigem == 5) || (iOrigem == 2 && iTipoOrigem == 6) || (iOrigem == 2 && iTipoOrigem == 7) || (iOrigem == 2 && iTipoOrigem == 8) || (iOrigem == 2 && iTipoOrigem == 9)) {
      document.getElementById('trlicoutroorgao').style.display = "";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trLicitacao').style.display = "none";
    }
    if (iOrigem == 3 && iTipoOrigem == 1) {
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
    if ((iOrigem == 3 && iTipoOrigem == 2) || (iOrigem == 3 && iTipoOrigem == 3)) {
      document.getElementById('trLicitacao').style.display = "";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
    if (iOrigem == 3 && iTipoOrigem == 4) {
      document.getElementById('tradesaoregpreco').style.display = "";
      document.getElementById('trlicoutroorgao').style.display = "none";
      document.getElementById('trLicitacao').style.display = "none";
    }
    if ((iOrigem == 3 && iTipoOrigem == 5) || (iOrigem == 3 && iTipoOrigem == 6) || (iOrigem == 3 && iTipoOrigem == 7) || (iOrigem == 3 && iTipoOrigem == 8) || (iOrigem == 3 && iTipoOrigem == 9)) {
      document.getElementById('trlicoutroorgao').style.display = "";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trLicitacao').style.display = "none";
    }
  }

  function js_verificaorigem() {
    iOrigem = document.form1.ac16_origem.value;
    if (iOrigem == 1 || iOrigem == 2) {
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
  }

  function js_pesquisaac16_licoutroorgao(mostra) {
    if (mostra == true) {
      var sUrl = 'func_liclicitaoutrosorgaos.php?funcao_js=parent.js_buscalicoutrosorgaos|lic211_sequencial|z01_nome';
      js_OpenJanelaIframe('', 'db_iframe_liclicitaoutrosorgaos', sUrl, 'Pesquisar', true, '0');
    } else {
      if (document.form1.ac16_licoutroorgao.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_liclicitaoutrosorgaos', 'func_liclicitaoutrosorgaos.php?poo=true&pesquisa_chave=' + document.form1.ac16_licoutroorgao.value + '&funcao_js=parent.js_mostrarlicoutroorgao', 'Pesquisar licitação Outro Órgão', false, '0');
      } else {
        $('z01_nome').value = '';
      }
    }
  }

  function js_pesquisaaadesaoregpreco(mostra) {
    if (mostra == true) {
      var sUrl = 'func_adesaoregprecos.php?funcao_js=parent.js_buscaadesaoregpreco|si06_sequencial|si06_objetoadesao';
      js_OpenJanelaIframe('', 'db_iframe_adesaoregprecos', sUrl, 'Pesquisar', true, '0');
    } else {
      if (document.form1.ac16_adesaoregpreco.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_adesaoregprecos', 'func_adesaoregprecos.php?par=true&pesquisa_chave=' + document.form1.ac16_adesaoregpreco.value + '&funcao_js=parent.js_mostraradesao', 'Pesquisar', false, '0');
      } else {
        $('si06_objetoadesao').value = '';
      }
    }
  }

  function js_validaCampoLicitacao() {
    var iOrigem = $('ac16_origem').value;
    if (iOrigem == 3) {
      $('tdLicitacao').style.display = 'block';
    }
  } /** * função para carregar os dados da licitação selecionada no campo */
  function js_buscalicoutrosorgaos(chave1, chave2) {
    $('ac16_licoutroorgao').value = chave1;
    $('z01_nome').value = chave2;
    db_iframe_liclicitaoutrosorgaos.hide();
  }

  function js_mostrarlicoutroorgao(chave, erro) {
    document.form1.z01_nome.value = chave;
    if (erro == true) {
      document.form1.z01_nome.focus();
    }
  } /** * funcao para carregar adesao de registro de preco escolhida no campo * */
  function js_buscaadesaoregpreco(chave1, chave2) {
    $('ac16_adesaoregpreco').value = chave1;
    $('si06_objetoadesao').value = chave2;
    db_iframe_adesaoregprecos.hide();
  }

  function js_mostraradesao(chave, erro) {
    document.form1.si06_objetoadesao.value = chave;
    if (erro == true) {
      document.form1.si06_objetoadesao.focus();
    }
  }

  function js_iniciaInformacoesReajuste() {

    iPossuicriterio = document.form1.ac16_reajuste.value;

    if (iPossuicriterio == "t") {
      document.getElementById("tdcriterioreajuste").style.display = "inline";
      document.getElementById("trdatareajuste").style.display = "inline";
      document.getElementById("trperiodoreajuste").style.display = "inline";

      icriterio = document.form1.ac16_criterioreajuste.value;

      if (icriterio == 1) {
        document.getElementById("tdindicereajuste").style.display = "inline";
        document.getElementById("trdescricaoreajuste").style.display = "none";
        document.getElementById("ac16_descricaoreajuste").value = "";
        js_indicereajuste();
        return;
      }
      if (icriterio == 2 || icriterio == 3) {
        document.getElementById("tdindicereajuste").style.display = "none";
        document.getElementById("trdescricaoreajuste").style.display = "";
        document.getElementById("ac16_indicereajuste").value = 0;
        document.getElementById("trdescricaoindicereajuste").style.display ="none";
        document.getElementById("ac16_descricaoindice").value = "";
        return;
      }
      document.getElementById("trdescricaoreajuste").style.display = "none";
      document.getElementById("tdindicereajuste").style.display = "none";
      document.getElementById("ac16_indicereajuste").value = 0;
      document.getElementById("trdescricaoindicereajuste").style.display = "none";
      document.getElementById("ac16_descricaoindice").value = "";
    }
  }

  function js_indicereajuste() {
    iIndicereajuste = document.form1.ac16_indicereajuste.value;
    if (iIndicereajuste == 6) {
      document.getElementById("trdescricaoindicereajuste").style.display = "";
      return;
    }
    document.getElementById("trdescricaoindicereajuste").style.display = "none";
    document.getElementById("ac16_descricaoindice").value = "";
  }

  function js_possuireajuste() {
    iPossuicriterio = document.form1.ac16_reajuste.value;
    if (iPossuicriterio == "t") {
      document.getElementById("tdcriterioreajuste").style.display = "inline";
      document.getElementById("trdatareajuste").style.display = "inline";
      document.getElementById("trperiodoreajuste").style.display = "inline";
      return;
    }
    document.getElementById("tdcriterioreajuste").style.display = "none";
    document.getElementById("trdatareajuste").style.display = "none";
    document.getElementById("trperiodoreajuste").style.display = "none";
    document.getElementById("trdescricaoreajuste").style.display = "none";
    document.getElementById("ac16_descricaoreajuste").value = "";
    document.getElementById("ac16_indicereajuste").value = 0;
    documentt.getElementById("ac16_criterioreajuste").value = 0;
    document.getElementById("ac16_periodoreajuste").value = "";
    document.getElementById("ac16_datareajuste").value = null;
  }

  function js_criterio() {
    icriterio = document.form1.ac16_criterioreajuste.value;

    if (icriterio == 1) {
      document.getElementById("tdindicereajuste").style.display = "inline";
      document.getElementById("trdescricaoreajuste").style.display = "none";
      document.getElementById("ac16_descricaoreajuste").value = "";
      return;
    }
    if (icriterio == 2 || icriterio == 3) {
      document.getElementById("tdindicereajuste").style.display = "none";
      document.getElementById("trdescricaoreajuste").style.display = "";
      document.getElementById("ac16_indicereajuste").value = "0";
      document.getElementById("trdescricaoindicereajuste").style.display = "none";
      document.getElementById("ac16_descricaoindice").value = "";
      return;
    }
    document.getElementById("trdescricaoreajuste").style.display = "none";
    document.getElementById("tdindicereajuste").style.display = "none";
    document.getElementById("ac16_indicereajuste").value = 0;
    document.getElementById("trdescricaoindicereajuste").style.display = "none";
    document.getElementById("ac16_descricaoindice").value = "";
  }

  function js_validacoesReajuste() {
    let iReajuste = $F("ac16_reajuste");
    let iCriterioreajuste = $F("ac16_criterioreajuste");
    let dtReajuste = $F("ac16_datareajuste");
    let sPeriodoreajuste = $F("ac16_periodoreajuste");
    let iIndicereajuste = $F("ac16_indicereajuste");
    let sDescricaoreajuste = $F("ac16_descricaoreajuste");
    let sDescricaoindice = $F("ac16_descricaoindice");

    if (iReajuste == 0) {
      alert("Usuário: Campo Possui Critério de Reajuste não informado.");
      return false;
    }

    if (iReajuste == "t") {

      if (iCriterioreajuste == 0) {
        alert("Usuário: Campo Critério de Reajuste não informado.");
        return false;
      }

      if (dtReajuste == "") {
        alert("Usuário: Campo Data Base de Reajuste não informado.");
        return false;
      }

      if (sPeriodoreajuste == "") {
        alert("Usuário: Campo Período de Reajuste não informado.");
        return false;
      }

      if (iCriterioreajuste == 1 && iIndicereajuste == 0) {
        alert("Usuário: Campo Índice de Reajuste não informado.");
        return false;
      }

      if (iIndicereajuste == 6 && sDescricaoindice == "") {
        alert("Usuário: Campo Descrição do Índice não informado.");
        return false;
      }

      if (iCriterioreajuste != 1 &&sDescricaoreajuste == "") {
        alert("Usuário: Campo Descrição de Reajuste não informado.");
        return false;
      }

      return true;

    }

  }

  js_iniciaInformacoesReajuste();
  js_verificaorigem();
  js_verificatipoorigem();
</script>
<?php
  }
