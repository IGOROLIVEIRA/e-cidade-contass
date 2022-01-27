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
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */



$clpcorcam->rotulo->label();
$clpcorcamforne->rotulo->label();
$clpcorcamval->rotulo->label();
$clrotulo = new rotulocampo;

if(isset($_POST["processar"])) {
    $contTama = 1; 
   
    $dataI = $_POST["dataI"];
    $dataI = explode("/",$dataI);
    $dataI = $dataI[2]."-".$dataI[1]."-".$dataI[0];

    $dataF = $_POST["dataF"];
    $dataF = explode("/",$dataF);
    $dataF = $dataF[2]."-".$dataF[1]."-".$dataF[0];

   

    $novo_nome = $_FILES["uploadfile"]["name"];
    
    // Nome do novo arquivo
    $nomearq = $_FILES["uploadfile"]["name"];

    $extensao = strtolower(substr($nomearq,-5));

    $diretorio = "libs/Pat_xls_import/";

    // Nome do arquivo temporário gerado no /tmp
    $nometmp = $_FILES["uploadfile"]["tmp_name"];

    // Seta o nome do arquivo destino do upload
    $arquivoDocument = "$diretorio"."$novo_nome";

    
    if($extensao != ".xlsx"){
        db_msgbox("Arquivo inválido! O arquivo selecionado deve ser do tipo .xlsx");
        unlink($nometmp);
        $lFail = true;
        return false;
        
    }

    $files = glob('libs/Pat_xls_import/*');
    foreach($files as $file) {
        if (is_file($file)){
            unlink($file);
        }
    }

    // Faz um upload do arquivo para o local especificado
    if(  move_uploaded_file($_FILES["uploadfile"]["tmp_name"],$diretorio.$novo_nome)) {

        $href = $arquivoDocument;

    }else{

        db_msgbox("Erro ao enviar arquivo.");
        unlink($nometmp);
        $lFail = true;
        return false;
    }

    $dir = "libs/Pat_xls_import/";
    $files1 = scandir($dir,1);
    $arquivo = "libs/Pat_xls_import/".$files1[0];

    if (!file_exists($arquivo)) {
        echo "<script>alert('Arquivo não localizado')</script>";
    }else{
        
        $objPHPExcel = PHPExcel_IOFactory::load($arquivo);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();

        $highestRow = $highestRow;
        

        $i = 0;
        for($row=8;$row<=$highestRow;$row++){

            $cell = $objWorksheet -> getCellByColumnAndRow (0,$row);
            $nota = $cell->getValue();

            $cell = $objWorksheet -> getCellByColumnAndRow (1,$row);
            $data = $cell->getValue();
            if($data==""){
                break;
            }
            
            $data = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data+1));

            $cell = $objWorksheet -> getCellByColumnAndRow (2,$row);
            $hora = $cell->getValue();
            $hora = explode(":", $hora);
            $hora = $hora[0].":".$hora[1];

            $cell = $objWorksheet -> getCellByColumnAndRow (4,$row);
            $placa = $cell->getValue();
            $placa = explode("-", $placa);
            $placa = $placa[0]."".$placa[1];

            $cell = $objWorksheet -> getCellByColumnAndRow (23,$row);
            $valor = $cell->getValue();

            $cell = $objWorksheet -> getCellByColumnAndRow (6,$row);
            $secretaria = $cell->getValue();

            $cell = $objWorksheet -> getCellByColumnAndRow (9,$row);
            $motorista = $cell->getValue();

            $cell = $objWorksheet -> getCellByColumnAndRow (8,$row);
            $motoristaNome = $cell->getValue();

            $cell = $objWorksheet -> getCellByColumnAndRow (18,$row);
            $medidasaida = $cell->getValue();

            $cell = $objWorksheet -> getCellByColumnAndRow (19,$row);
            $litros = $cell->getValue();

            $cell = $objWorksheet -> getCellByColumnAndRow (20,$row);
            $vUnitario = $cell->getValue();

            $cell = $objWorksheet -> getCellByColumnAndRow (7,$row);
            $combust = $cell->getValue();

            if(strtotime($dataI) <= strtotime($data) && strtotime($data) <= strtotime($dataF) ){

                $dataArr[$i][0] = $data;
                $dataArr[$i][1] = $hora;
                $dataArr[$i][2] = $placa;
                $dataArr[$i][3] = $valor;
                $dataArr[$i][4] = $secretaria;
                $dataArr[$i][5] = $motorista;
                $dataArr[$i][6] = $medidasaida;
                $dataArr[$i][7] = $litros;
                $dataArr[$i][8] = $vUnitario;
                $dataArr[$i][9] = $combust; 
                $dataArr[$i][10] = $motoristaNome;
                $dataArr[$i][11] = $nota;


                $i++;

            }
            
        }
            $arrayItensPlanilha = array();

            foreach ($dataArr as $keyRow => $Row){
                   
                
                    $objItensPlanilha = new stdClass();
                    foreach ($Row as $keyCel => $cell){

                        if($keyCel == 0){
                            $objItensPlanilha->data              =  $cell;
                        }
                        
                        if($keyCel == 2){
                            $objItensPlanilha->placa    =  $cell;
                        }
                        if($keyCel == 3){
                            $objItensPlanilha->valor             =  $cell;
                        }
                        if($keyCel == 4){
                            $objItensPlanilha->secretaria        =  $cell;
                        }
                        if($keyCel == 5){
                            $objItensPlanilha->motorista         =  $cell;
                        }
                        if($keyCel == 1){
                            $objItensPlanilha->hora              =  $cell;
                        }
                        if($keyCel == 6){
                            $objItensPlanilha->medidasaida       =  $cell;
                        }
                        if($keyCel == 7){
                            $objItensPlanilha->litros            =  $cell;
                        }
                        if($keyCel == 8){
                            $objItensPlanilha->vUnitario         =  $cell;
                        }
                        if($keyCel == 9){
                            $objItensPlanilha->combust           =  $cell;
                        }
                        if($keyCel == 10){
                            $objItensPlanilha->motoristaNome     =  $cell;
                        }
                        if($keyCel == 11){
                            $objItensPlanilha->nota              =  $cell;
                        }
                    }
                    $arrayItensPlanilha[] = $objItensPlanilha;
                
            }
            
    }

    
}
?>



<style>
    #pc21_orcamfornedescr{
        width: 296;
    }
    #tdcontrol{
        width: 11%;
    }
    #dias_validade,#dias_prazo,#pc20_codorc,#Exportarxlsforne,#importar{
        width: 91px;
    }
    #uploadfile{
        height: 25px;
    }
    
</style>
<form name="form1" method="post" action="" enctype="multipart/form-data">
    <center>
        <table border="0" style="width: 30%; align:center;">
            <tr>
                <td>
                    <fieldset>
                        <legend>Imp. Movimentações</legend>
                        

                        <form name="form2" id="form2" method="post" action="db_frmabastimportacao.php" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td style="width: 100px">
                                        <b>Importar xls:</b>
                                    </td>
                                    <td>
                                        <?php
                                        db_input("uploadfile",30,0,true,"file",1);
                                        ?>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td id="myProgress">
                                        
                                        <input type="text" id="nomeArquivo" name="nomeArquivo" style="width:235px;" value="<? echo $nomearq; ?>" disabled>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                    <?php
                                       db_input("namefile",31,0,true,"hidden",1);
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <b> Periodo: </b> 
                                    </td>
                                    <td>
                                    <?
                                    db_inputdata("dataI",'',true,"text",1,"","dataI");
                                    db_inputdata("dataF",'',true,"text",1,"","dataf");
                                    ?>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="2" >
                                    <div style="margin-left: 150px;"><input name ='processar' type='submit' id="Processar" value="Processar"></div>
                                    </td>
                                    
                                </tr>
                            </table>
                        </form> 
                        
                        <div id='anexo' style=''></div>
                    </fieldset>
                    
                </td>
            </tr>
        </table>
    </center>
</form>
<form name="form1" id="form1" method="post" action="" enctype="multipart/form-data">
<table style="width: 70%; border: 0px solid black;" id="tableResult">
                        
                        
                        <tr>
                           <th style="border: 0px solid red; width:120px; background:#ffffff;">
                               Placa
                           </th>

                           <th style="border: 0px solid red; width:120px; background:#ffffff;">
                               Data
                           </th>
                            
                           <th style="border: 0px solid red; width:100px; background:#ffffff;">
                               Valor
                           </th>
                           
                           <th style="border: 0px solid red; width:200px; background:#ffffff;">
                               Secretária
                           </th>
                           <th style="background:#ffffff;">
                               Empenho
                           </th> 
                        </tr>

                        
                        <?php
                            $i = 1;
                            $tamanho = count($arrayItensPlanilha); 
                            if($contTama==1&&$tamanho==0){
                                echo "<script>alert('Nenhum registro encontrato!')</script>";
                            }
                            foreach($arrayItensPlanilha as $rown){
                                
                              echo "<tr style='background-color:#ffffff;'>";  
                                echo "<td style='text-align:center;'>";
                                 echo $rown->placa;
                                echo "</td>";

                                echo "<td style='text-align:center;'>";
                                $dataV = $rown->data;
                                $dataV = explode("-",$dataV);
                                 echo $dataV[2]."-".$dataV[1]."-".$dataV[0];  
                                echo "</td>";

                                echo "<td style='text-align:center;'>";
                                 echo $rown->valor;
                                echo "</td>";

                                echo "<td style='text-align:center;'>";
                                 echo $rown->secretaria;
                                echo "</td>";

                                echo "<td style='text-align:center; width:100px;'>";
                                 echo "<input type='text' style='text-align:center;' id='empenho$i' name='empenho$i' placeholder='num/ano' onkeypress='return onlynumber();'>";
                                echo "</td>";
                              echo "</tr>";
                              $i++;  
                            }

                        ?>
                        </tr>
                        
                        
                        
                        <?
                        
                        echo
                        "<tr>
                            <td colspan='5' align='center'>
                
                                    
                                <input type='button' id='db_opcao' value='Salvar'  ".($db_botao==false?"disabled":"")." onclick='js_verificarEmpenho();'>
                                
                                
                                
                            </td>
                        </tr>";
                                
                        $valor = array("valor" => 1, "teste" => 2);        
                     
                        ?>
                    </table>
                    <br><br><br>
                    <table style="width: 20%; border: 0px solid black; display: none;" id="tbl" >

                    <tr>
                            <th colspan="2" style="text-align: center;" >
                             Veículos possuem retirada sem devolução
                            </th>
                    <tr>
                    
                        <tr style='background-color:#ffffff;'>
                            <th style="width: 150px;">
                            Código 
                            </th>
                            <th style="width: 150px;">
                            Placa
                            </th>
                        </tr>
                    </table>
                    <table style="width: 20%; border: 0px solid black; display: none;" id="veiculosLancados" >

                    <tr>
                            <th colspan="4" style="text-align: center;" >
                             Veículos possuem abastecimentos já lançados
                            </th>
                    <tr>
                    
                        <tr style='background-color:#ffffff;'>
                            <th style="width: 150px;">
                            Cod. Abastecimento 
                            </th>
                            <th style="width: 150px;">
                            Data
                            </th>
                            <th style="width: 150px;">
                            Litros
                            </th>
                            <th style="width: 150px;">
                            Valor
                            </th>
                        </tr>
                    </table>
                    <table style="width: 40%; border: 0px solid black; display: none;" id="tblMotorista" >

                    <tr>
                            <th colspan="2" style="text-align: center;" >
                             Motoristas não encontrados
                            </th>
                    <tr>
                    
                        <tr style='background-color:#ffffff;'>
                            <th style="width: 150px;">
                            CPF 
                            </th>
                            <th style="width: 850px;">
                            Nome
                            </th>
                        </tr>
                    </table>
                    <table style="width: 20%; border: 0px solid black; display: none;" id="tblBaixa" >

                    <tr>
                            <th colspan="2" style="text-align: center;" >
                             Veículos foram baixados 
                            </th>
                    <tr>
                    
                        <tr style='background-color:#ffffff;'>
                            <th style="width: 150px;">
                            Codigo 
                            </th>
                            <th style="width: 150px;">
                            Placa
                            </th>
                        </tr>
                    </table>
                    <table style="width: 20%; border: 0px solid black; display: none;" id="tblKm" >

                    <tr>
                            <th colspan="4" style="text-align: center;" >
                             Erro de quilometragem 
                            </th>
                    <tr>
                    
                        <tr style='background-color:#ffffff;'>
                            <th style="width: 150px;">
                            Codigo 
                            </th>
                            <th style="width: 150px;">
                            Placa
                            </th>
                            <th style="width: 150px;">
                            km Final
                            </th>
                            <th style="width: 150px;">
                            km Lançamento
                            </th>
                        </tr>
                    </table>
                    <table style="width: 20%; border: 0px solid black; display: none;" id="tblVeic" >

                    <tr>
                            <th colspan="1" style="text-align: center;" >
                             Veiculos não encontrados 
                            </th>
                    <tr>
                    
                        <tr style='background-color:#ffffff;'>
                            
                            <th style="width: 150px;">
                            Placa
                            </th>  
                        </tr>
                    </table> 
                    <table style="width: 20%; border: 0px solid black; display: none;" id="tblComb" >

                    <tr>
                            <th colspan="2" style="text-align: center;" >
                             Combustível não encontrado na base 
                            </th>
                    <tr>
                    
                        <tr style='background-color:#ffffff;'>
                            
                            <th style="width: 150px;">
                            Placa
                            </th>
                            <th style="width: 150px;">
                            Combustível
                            </th>    
                        </tr>
                    </table>               
  </form>
    
<script>


    function js_verificarEmpenho(){
        var nControle = 0;
        nEmpenho = <?php echo json_encode($i-1)?>;
        var empenho = [];
        for(i = 0;i<nEmpenho; i++){
            nInput = i+1;
            empenho[i] = $F('empenho'+nInput);
            const myArr = empenho[i].split("/");
            if(empenho[i]==""){
                nControle = 1;
                alert("Preencher número de empenho");
                break;
            }
        }
        if(nControle == 0){
            js_importxlsfornecedor();
        }
    }

    function js_liberarButton(){
       
        document.getElementById("Processar").style.display="block";
    }
    
    $('uploadfile').observe("change",js_liberarButton); 

    /***
     * ROTINA PARA CARREGAR VALORES DA PLANILHA ANEXADA
     */
    function js_importxlsfornecedor() {
       
        var oParam                    = new Object();
        var empenho = [];
        oParam.exec                   = 'importar';
        
        oParam.valor = <?php echo json_encode($arrayItensPlanilha)?>;
        oParam.nEmpenho = <?php echo json_encode($i-1)?>; 

        oParam.dataI = <?php echo json_encode($dataI)?>;
        oParam.dataF = <?php echo json_encode($dataF)?>;
        
        for(i = 0;i<oParam.nEmpenho; i++){
            nInput = i+1;
            empenho[i] = $F('empenho'+nInput);
        }
        oParam.itensEmpenho = empenho;
        
        js_divCarregando('Aguarde... Carregando Arquivo','msgbox');
        
        var oAjax         = new Ajax.Request(
            'vei1_xlsabastecimento.RPC.php',
            { parameters: 'json='+Object.toJSON(oParam),
                asynchronous:false,
                method: 'post',
                onComplete : js_retornoimportarxls
            });
    }

    function onlynumber(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        var regex = /^[0-9.\\/]+$/;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }

    function js_retornoimportarxls(oAjax) {
        js_removeObj("msgbox");
        var valorC = [];
        var valorEmp = [];
        var id = 0;
        var opE = 0;
        var oRetorno = eval('('+oAjax.responseText+")");
        if (oRetorno.status == 2) {
            oRetorno.itens.forEach(function (oItem) {
               if(opE == 0){
                valorEmp[opE] = oItem;
                opE++;
               }else{
                oper = 0;   
                for(j = 0; j<opE; j++){
                    if(valorEmp[j]==oItem){
                        oper = 1;
                    }
                }
                if(oper==0){
                    valorEmp[opE] = oItem;
                    opE++;
                }
               }
            });
           
            alert(oRetorno.message.urlDecode()+""+valorEmp);
            
        }else if (oRetorno.status == 3) {
            alert(oRetorno.message.urlDecode());
            var url_atual = window.location.href;
            window.location.href = url_atual;

        }else if (oRetorno.status == 4) {
            alert(oRetorno.message.urlDecode());
            //var url_atual = window.location.href;
            //window.location.href = url_atual;

        }else{
            var cont = 1;
            oRetorno.itens.forEach(function (oItem) {

                var identificador = oItem.identificador;
                if(identificador==1){
                    if(cont==1){
                        alert("Veículos com Abastecimentos já lançados");
                        cont++;
                    } 
                    var vplaca = oItem.placa;
                    var data = oItem.data;
                    const myArr = data.split("-");
                    data = myArr[2]+"-"+myArr[1]+"-"+myArr[0]
                    var valor = oItem.valor;
                    var litros = oItem.litros;
                    document.getElementById("veiculosLancados").style.display="block"; 
                    document.getElementById("db_opcao").style.display="none";


                    var tabela = document.getElementById("veiculosLancados");

                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    var celula2 = linha.insertCell(1);
                    var celula3 = linha.insertCell(2);
                    var celula4 = linha.insertCell(3);   
                    celula1.innerHTML =  "<div style='text-align:center'>"+vplaca+"</div>"; 
                    celula2.innerHTML =  "<div style='text-align:center'>"+data+"</div>"; 
                    celula3.innerHTML =  "<div style='text-align:center'>"+litros+"</div>";
                    celula4.innerHTML =  "<div style='text-align:center'>"+valor+"</div>";  
                }else if(identificador==2){
                    op = 0;
                    if(cont==1){
                        alert("Veículos com retiradas sem devolução");
                        cont++;
                    } 
                
                    var vplaca = oItem.placa;
                    var vcodigo = oItem.codigo;
                    document.getElementById("tbl").style.display="block"; 
                    document.getElementById("db_opcao").style.display="none";

                    if(id>0){
                        for(i = 0; i<id; i++){
                            if(valorC[i]== vcodigo){
                                op = 1;
                            }
                        }
                        if(op == 0){
                            
                            valorC[id] = vcodigo;
                            id++;
                        }
                    }else{
                        valorC[id] = vcodigo;
                        id++;
                    }

                    if(op == 0 ){

                        var tabela = document.getElementById("tbl");
                        var numeroLinhas = tabela.rows.length;
                        var linha = tabela.insertRow(numeroLinhas);
                        var celula1 = linha.insertCell(0);
                        var celula2 = linha.insertCell(1); 
                        celula1.innerHTML =  "<div style='text-align:center'>"+vcodigo+"<div>"; 
                        celula2.innerHTML =  "<div style='text-align:center'>"+vplaca+"<div>";
                    }
                    
                    
                }else if(identificador==3){
                    op = 0;
                    if(cont==1){
                        alert("Motoristas não encontrados");
                        cont++;
                    }
                    
                    var vcpf = oItem.cpf;
                    var vmotorista = oItem.motorista;
                    document.getElementById("tblMotorista").style.display="block";

                    if(id>0){
                        for(i = 0; i<id; i++){
                            if(valorC[i]== vcpf){
                                op = 1;
                            }
                        }
                        if(op == 0){
                            
                            valorC[id] = vcpf;
                            id++;
                        }
                    }else{
                        valorC[id] = vcpf;
                        id++;
                    }
                    if(op == 0 ){
                    
                        var tabela = document.getElementById("tblMotorista");
                        var numeroLinhas = tabela.rows.length;
                        var linha = tabela.insertRow(numeroLinhas);
                        var celula1 = linha.insertCell(0);
                        var celula2 = linha.insertCell(1); 
                        celula1.innerHTML =  "<div style='text-align:center'>"+vcpf+"<div>"; 
                        celula2.innerHTML =  "<div style='text-align:center;'>"+vmotorista+"<div>";
                    }      
                }else if(identificador==4){
                    if(cont==1){
                        alert("Veiculos com Baixa");
                        cont++;
                    }
                    
                    var vcodigo = oItem.codigo;
                    var vplaca = oItem.placa;
                    document.getElementById("tblBaixa").style.display="block";

                    var tabela = document.getElementById("tblBaixa");
                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    var celula2 = linha.insertCell(1); 
                    celula1.innerHTML =  "<div style='text-align:center'>"+vcodigo+"<div>"; 
                    celula2.innerHTML =  "<div style='text-align:center;'>"+vplaca+"<div>";

                }else if(identificador==5){
                    if(cont==1){
                        alert("Quilometragem menor do que a última lançada!"); 
                        cont++;
                    }
                    
                    var vcodigo = oItem.codigo;
                    var vplaca = oItem.placa;
                    var vkm = oItem.km; 
                    var vkmfinal = oItem.kmfinal;
                    document.getElementById("tblKm").style.display="block";

                    var tabela = document.getElementById("tblKm");
                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    var celula2 = linha.insertCell(1);
                    var celula3 = linha.insertCell(2);
                    var celula4 = linha.insertCell(3);  
                    celula1.innerHTML =  "<div style='text-align:center'>"+vcodigo+"<div>"; 
                    celula2.innerHTML =  "<div style='text-align:center;'>"+vplaca+"<div>";
                    celula3.innerHTML =  "<div style='text-align:center;'>"+vkmfinal+"<div>";
                    celula4.innerHTML =  "<div style='text-align:center;'>"+vkm+"<div>";

                }else if(identificador==6){
                    if(cont==1){
                        alert("Veiculos não encontrados"); 
                        cont++;
                    }
                    
                    
                    var vplaca = oItem.placa;
                    document.getElementById("tblVeic").style.display="block";

                    var tabela = document.getElementById("tblVeic");
                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    celula1.innerHTML =  "<div style='text-align:center;'>"+vplaca+"<div>";
                    

                }else if(identificador==7){
                    if(cont==1){
                        alert("Combustivel não localizado na base!"); 
                        cont++;
                    }
                    
                    
                    var vplaca = oItem.placa;
                    var vcom = oItem.comb;
                    document.getElementById("tblComb").style.display="block";

                    var tabela = document.getElementById("tblComb");
                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    var celula2 = linha.insertCell(1);
                    celula1.innerHTML =  "<div style='text-align:center;'>"+vplaca+"<div>";
                    celula2.innerHTML =  "<div style='text-align:center;'>"+vcom+"<div>";
                    

                }
                

            });
        }
    }

</script>