<?
//MODULO: sicom

$claditivoscontratos->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi174_sequencial?>">
       <?=@$Lsi174_sequencial?>
    </td>
    <td>
<?
db_input('si174_sequencial',12,$Isi174_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_codunidadesub?>">
       <?=@$Lsi174_codunidadesub?>
    </td>
    <td>
<?
$sql = "select distinct d.coddepto,d.descrdepto,u.db17_ordem
            from db_depusu u
                 inner join db_depart d on u.coddepto = d.coddepto
           where instit = ".db_getsession("DB_instit")."
             and u.id_usuario = ".db_getsession("DB_id_usuario") . "
           and (d.limite is null or d.limite >= '" . date("Y-m-d",db_getsession("DB_datausu")) . "')

           order by u.db17_ordem ";

    $result = db_query($sql) or die($sql);
    db_selectrecord('si174_codunidadesub',$result,true,2,'','','','','');
    //db_input('si174_codunidadesub',8,$Isi174_codunidadesub,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_nrocontrato?>">
       <?=@$Lsi174_nrocontrato?>
    </td>
    <td>
<?
/*$result = $clcontratos->sql_record($clcontratos->sql_query_novo(null,"si172_nrocontrato||'/'||si172_exerciciocontrato as nrocontrato, z01_nome
  "));

if (empty($nrocontrato) && $nrocontrato == "") {
  $nrocontrato                      = db_utils::fieldsMemory($result, 0)->nrocontrato;
}

db_selectrecord("nrocontrato",$result,true,$db_opcao);

$nrocontrato = explode('/', $nrocontrato);
$nrocontrato = $nrocontrato[0];
$result      = $clcontratos->sql_record($clcontratos->sql_query_novo(null,"si172_sequencial, si172_nrocontrato, si172_dataassinatura",null,"si172_nrocontrato = $nrocontrato;"));
$si174_nrocontrato                      = db_utils::fieldsMemory($result, 0)->si172_sequencial;
$dataassinatura                         = explode('-', db_utils::fieldsMemory($result, 0)->si172_dataassinatura);
$si174_dataassinaturacontoriginal_dia   = $dataassinatura[2];
$si174_dataassinaturacontoriginal_mes   = $dataassinatura[1];
$si174_dataassinaturacontoriginal_ano   = $dataassinatura[0];*/
db_input('si174_nrocontrato',20,$Isi174_nomeforn,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_dataassinaturacontoriginal?>">
       <?=@$Lsi174_dataassinaturacontoriginal?>
    </td>
    <td>
<?
db_inputdata('si174_dataassinaturacontoriginal',@$si174_dataassinaturacontoriginal_dia,@$si174_dataassinaturacontoriginal_mes,@$si174_dataassinaturacontoriginal_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_nroseqtermoaditivo?>">
       <?=@$Lsi174_nroseqtermoaditivo?>
    </td>
    <td>
<?
db_input('si174_nroseqtermoaditivo',2,$Isi174_nroseqtermoaditivo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_dataassinaturatermoaditivo?>">
       <?=@$Lsi174_dataassinaturatermoaditivo?>
    </td>
    <td>
<?
db_inputdata('si174_dataassinaturatermoaditivo',@$si174_dataassinaturatermoaditivo_dia,@$si174_dataassinaturatermoaditivo_mes,@$si174_dataassinaturatermoaditivo_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_tipoalteracaovalor?>">
       <?=@$Lsi174_tipoalteracaovalor?>
    </td>
    <td>
<?
$x = array("1"=>"Acréscimo de valor","2"=>"Decréscimo de valor","3"=>"Não houve alteração de valor");
db_select('si174_tipoalteracaovalor',$x,true,$db_opcao,"");
//db_input('si174_tipoalteracaovalor',1,$Isi174_tipoalteracaovalor,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_tipotermoaditivo?>">
       <?=@$Lsi174_tipotermoaditivo?>
    </td>
    <td>
<?
$x = array("04"=>"Reajuste","05"=>"Recomposição (Equilíbrio Financeiro)","06"=>"Outros","07"=>"Alteração de Prazo de Vigência",
           "08"=>"Alteração de Prazo de Execução","09"=>"Acréscimo de Item(ns)","10"=>"Decréscimo de Item(ns)",
           "11"=>"Acréscimo e Decréscimo de Item(ns)","12"=>"Alteração de Projeto/Especificação",
           "13"=>"Alteração de Prazo de vigência e Prazo de Execução","14"=>"Acréscimo/Decréscimo de item(ns) conjugado com
           outros tipos de termos aditivos");
db_select('si174_tipotermoaditivo',$x,true,$db_opcao,"");

//db_input('si174_tipotermoaditivo',2,$Isi174_tipotermoaditivo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_dscalteracao?>">
       <?=@$Lsi174_dscalteracao?>
    </td>
    <td>
<?
db_textarea('si174_dscalteracao',8,40,$Isi174_dscalteracao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_novadatatermino?>">
       <?=@$Lsi174_novadatatermino?>
    </td>
    <td>
<?
db_inputdata('si174_novadatatermino',@$si174_novadatatermino_dia,@$si174_novadatatermino_mes,@$si174_novadatatermino_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_valoraditivo?>">
       <?=@$Lsi174_valoraditivo?>
    </td>
    <td>
<?
db_input('si174_valoraditivo',14,$Isi174_valoraditivo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_datapublicacao?>">
       <?=@$Lsi174_datapublicacao?>
    </td>
    <td>
<?
db_inputdata('si174_datapublicacao',@$si174_datapublicacao_dia,@$si174_datapublicacao_mes,@$si174_datapublicacao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi174_veiculodivulgacao?>">
       <?=@$Lsi174_veiculodivulgacao?>
    </td>
    <td>
<?
db_input('si174_veiculodivulgacao',50,$Isi174_veiculodivulgacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
 <?
$si174_instit = db_getsession("DB_instit");
db_input('si174_instit',10,$Isi174_instit,true,'hidden',$db_opcao,"")
?>
<?
$controle = $db_opcao;
db_input('controle',10,$Icontrole,true,'hidden',$db_opcao,"")
//db_input('controle',10,$Icontrole,true,'hidden',$db_opcao,"")
?>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>

<script>

function addEventsToHTML(){

    document.form1.nrocontrato.onchange      = changeHandler1;
    document.form1.nrocontratodescr.onchange = changeHandler2;

    function changeHandler1(){

      js_ProcCod_nrocontrato('nrocontrato','nrocontratodescr');

      var param2  = document.form1.si174_codunidadesub.value;
      var param3  = document.form1.nrocontrato.value;

      //si172_dataassinatura
      var param4  = document.form1.si174_dataassinaturacontoriginal_dia.value;
      var param5  = document.form1.si174_dataassinaturacontoriginal_mes.value;
      var param6  = document.form1.si174_dataassinaturacontoriginal_ano.value;

      var param7  = document.form1.si174_nroseqtermoaditivo.value;

      var param8  = document.form1.si174_dataassinaturatermoaditivo_dia.value;
      var param9  = document.form1.si174_dataassinaturatermoaditivo_mes.value;
      var param10 = document.form1.si174_dataassinaturatermoaditivo_ano.value;
      var param11 = document.form1.si174_tipoalteracaovalor.value;
      var param12 = document.form1.si174_tipotermoaditivo.value;
      var param13 = document.form1.si174_dscalteracao.value;
      var param14 = document.form1.si174_novadatatermino_dia.value;
      var param15 = document.form1.si174_novadatatermino_mes.value;
      var param16 = document.form1.si174_novadatatermino_ano.value;
      var param17 = document.form1.si174_valoraditivo.value;
      var param18 = document.form1.si174_datapublicacao_dia.value;
      var param19 = document.form1.si174_datapublicacao_mes.value;
      var param20 = document.form1.si174_datapublicacao_ano.value;
      var param21 = document.form1.si174_veiculodivulgacao.value;
      var param22 = document.form1.nrocontratodescr.value;
      var param23 = document.form1.si174_sequencial.value;

      if ( document.form1.controle.value == 1 ) {

          CurrentWindow.corpo.iframe_aditivoscontratos.location.href='sic1_aditivoscontratos004.php?si174_codunidadesub='+param2+'&nrocontrato='+param3+
          '&si174_dataassinaturacontoriginal_dia='+param4+'&si174_dataassinaturacontoriginal_mes='+param5+'&si174_dataassinaturacontoriginal_ano='+param6+'&si174_nroseqtermoaditivo='+param7+
          '&si174_dataassinaturatermoaditivo_dia='+param8+'&si174_dataassinaturatermoaditivo_mes='+param9+'&si174_dataassinaturatermoaditivo_ano='+param10+
          '&si174_tipoalteracaovalor='+param11+'&si174_tipotermoaditivo='+param12+'&si174_dscalteracao='+param13+
          '&si174_novadatatermino_dia='+param14+'&si174_novadatatermino_mes='+param15+'&si174_novadatatermino_ano='+param16+
          '&si174_valoraditivo='+param17+'&si174_datapublicacao_dia='+param18+'&si174_datapublicacao_mes='+param19+
          '&si174_datapublicacao_ano='+param20+'&si174_veiculodivulgacao='+param21+'&nrocontratodescr='+param22+'&si174_sequencial='+param23;

      } else {

            CurrentWindow.corpo.iframe_aditivoscontratos.location.href='sic1_aditivoscontratos007.php?si174_codunidadesub='+param2+'&nrocontrato='+param3+
          '&si174_dataassinaturacontoriginal_dia='+param4+'&si174_dataassinaturacontoriginal_mes='+param5+'&si174_dataassinaturacontoriginal_ano='+param6+'&si174_nroseqtermoaditivo='+param7+
          '&si174_dataassinaturatermoaditivo_dia='+param8+'&si174_dataassinaturatermoaditivo_mes='+param9+'&si174_dataassinaturatermoaditivo_ano='+param10+
          '&si174_tipoalteracaovalor='+param11+'&si174_tipotermoaditivo='+param12+'&si174_dscalteracao='+param13+
          '&si174_novadatatermino_dia='+param14+'&si174_novadatatermino_mes='+param15+'&si174_novadatatermino_ano='+param16+
          '&si174_valoraditivo='+param17+'&si174_datapublicacao_dia='+param18+'&si174_datapublicacao_mes='+param19+
          '&si174_datapublicacao_ano='+param20+'&si174_veiculodivulgacao='+param21+'&nrocontratodescr='+param22+'&si174_sequencial='+param23;

      }


    }

    function changeHandler2(){

      js_ProcCod_nrocontrato('nrocontratodescr','nrocontrato');

      var param2  = document.form1.si174_codunidadesub.value;
      var param3  = document.form1.nrocontrato.value;
      //si172_dataassinatura
      var param4  = document.form1.si174_dataassinaturacontoriginal_dia.value;
      var param5  = document.form1.si174_dataassinaturacontoriginal_mes.value;
      var param6  = document.form1.si174_dataassinaturacontoriginal_ano.value;

      var param7  = document.form1.si174_nroseqtermoaditivo.value;

      var param8  = document.form1.si174_dataassinaturatermoaditivo_dia.value;
      var param9  = document.form1.si174_dataassinaturatermoaditivo_mes.value;
      var param10 = document.form1.si174_dataassinaturatermoaditivo_ano.value;
      var param11 = document.form1.si174_tipoalteracaovalor.value;
      var param12 = document.form1.si174_tipotermoaditivo.value;
      var param13 = document.form1.si174_dscalteracao.value;
      var param14 = document.form1.si174_novadatatermino_dia.value;
      var param15 = document.form1.si174_novadatatermino_mes.value;
      var param16 = document.form1.si174_novadatatermino_ano.value;
      var param17 = document.form1.si174_valoraditivo.value;
      var param18 = document.form1.si174_datapublicacao_dia.value;
      var param19 = document.form1.si174_datapublicacao_mes.value;
      var param20 = document.form1.si174_datapublicacao_ano.value;
      var param21 = document.form1.si174_veiculodivulgacao.value;
      var param22 = document.form1.nrocontratodescr.value;
      var param23 = document.form1.si174_sequencial.value;

      if ( document.form1.controle.value == 1 ) {

        CurrentWindow.corpo.iframe_aditivoscontratos.location.href='sic1_aditivoscontratos004.php?si174_codunidadesub='+param2+'&nrocontrato='+param3+
        '&si174_dataassinaturacontoriginal_dia='+param4+'&si174_dataassinaturacontoriginal_mes='+param5+'&si174_dataassinaturacontoriginal_ano='+param6+'&si174_nroseqtermoaditivo='+param7+
        '&si174_dataassinaturatermoaditivo_dia='+param8+'&si174_dataassinaturatermoaditivo_mes='+param9+'&si174_dataassinaturatermoaditivo_ano='+param10+
        '&si174_tipoalteracaovalor='+param11+'&si174_tipotermoaditivo='+param12+'&si174_dscalteracao='+param13+
        '&si174_novadatatermino_dia='+param14+'&si174_novadatatermino_mes='+param15+'&si174_novadatatermino_ano='+param16+
        '&si174_valoraditivo='+param17+'&si174_datapublicacao_dia='+param18+'&si174_datapublicacao_mes='+param19+
        '&si174_datapublicacao_ano='+param20+'&si174_veiculodivulgacao='+param21+'&nrocontratodescr='+param22+'&si174_sequencial='+param23;

      } else {

        CurrentWindow.corpo.iframe_aditivoscontratos.location.href='sic1_aditivoscontratos007.php?si174_codunidadesub='+param2+'&nrocontrato='+param3+
        '&si174_dataassinaturacontoriginal_dia='+param4+'&si174_dataassinaturacontoriginal_mes='+param5+'&si174_dataassinaturacontoriginal_ano='+param6+'&si174_nroseqtermoaditivo='+param7+
        '&si174_dataassinaturatermoaditivo_dia='+param8+'&si174_dataassinaturatermoaditivo_mes='+param9+'&si174_dataassinaturatermoaditivo_ano='+param10+
        '&si174_tipoalteracaovalor='+param11+'&si174_tipotermoaditivo='+param12+'&si174_dscalteracao='+param13+
        '&si174_novadatatermino_dia='+param14+'&si174_novadatatermino_mes='+param15+'&si174_novadatatermino_ano='+param16+
        '&si174_valoraditivo='+param17+'&si174_datapublicacao_dia='+param18+'&si174_datapublicacao_mes='+param19+
        '&si174_datapublicacao_ano='+param20+'&si174_veiculodivulgacao='+param21+'&nrocontratodescr='+param22+'&si174_sequencial='+param23;

      }

    }

}

var opcao  = document.form1.controle.value;

if (opcao == 1 || opcao == 2 || opcao == 22) {

window.onload = addEventsToHTML;

}

function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aditivoscontratos','db_iframe_aditivoscontratos','func_aditivoscontratos.php?funcao_js=parent.js_preenchepesquisa|si174_sequencial','Pesquisa',true,'0','1','1300','550');
}
function js_preenchepesquisa(chave){
  db_iframe_aditivoscontratos.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

</script>
