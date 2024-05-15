<form name="form1" method="post" action="" class="container">
    <center>
        <fieldset>
            <legend><b>Termo de Inscrição em Dívida Ativa</b></legend>
            <table border="0" class="form-container">
                <tr>
                    <td width="25%" nowrap="nowrap">
                        <?
                        db_ancora("<b>Nome Contribuinte :</b>", "js_mostranomes(true);", 1);
                        ?>
                    </td>
                    <td colspan="3">
                        <?
                        db_input('z01_numcgm', 5, $Iz01_numcgm, true, 'text', 1, "onchange='js_mostranomes(false);'");
                        db_input('z01_nome', 40, 0, true, 'text', 3, "", "z01_nomecgm");
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        <table>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="imprimir" id="imprimir" type="button" value="Imprimir"
                           onclick="js_validarGenerico(true);">
                </td>
            </tr>
        </table>
    </center>
</form>
<script>

    function js_mostranomes(mostra) {
        var obj = document.form1;
        var numcgm = obj.z01_numcgm.value;
        var sUrl1 = 'func_nome.php?funcao_js=parent.js_preenchenomes|z01_numcgm|z01_nome';
        var sUrl2 = 'func_nome.php?pesquisa_chave=' + numcgm + '&funcao_js=parent.js_preenchenomes1';

        if (mostra == true) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_nomes', sUrl1, 'Pesquisa Nome Contribuinte', true);
        } else {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_nomes', sUrl2, 'Pesquisa Nome Contribuinte', false);

            if (numcgm == '') {
                obj.z01_numcgm.value = '';
                obj.z01_nomecgm.value = '';
            }
        }
    }
    function js_preenchenomes(chave1, chave2) {
        var obj = document.form1;
        obj.z01_numcgm.value = chave1;
        obj.z01_nomecgm.value = chave2;
        db_iframe_nomes.hide();
    }
    function js_preenchenomes1(erro, chave) {
        var obj = document.form1;
        var numcgm = obj.z01_numcgm.value;

        if (erro == true) {
            obj.z01_numcgm.value = '';
            obj.z01_nomecgm.value = chave;
            obj.z01_numcgm.focus();
        } else {
            if (numcgm != '') {
                obj.z01_nomecgm.value = chave;
            } else {
                obj.z01_numcgm.value = '';
                obj.z01_nomecgm.value = '';
            }
        }
    }

    function js_mostramatriculas(mostra) {
        var obj = document.form1;
        var matri = obj.j01_matric.value;
        var sUrl1 = 'func_iptubase.php?funcao_js=parent.js_preenchematriculas|j01_matric|z01_nome';
        var sUrl2 = 'func_iptubase.php?pesquisa_chave=' + matri + '&funcao_js=parent.js_preenchematriculas1';

        if (mostra == true) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_matriculas', sUrl1, 'Pesquisa Matricula', true);
        } else {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_matriculas', sUrl2, 'Pesquisa Matricula', false);

            if (matri != '') {
                obj.z01_nomematri.value = chave;
            } else {
                obj.j01_matric.value = '';
                obj.z01_nomematri.value = '';
            }
        }
    }
    function js_preenchematriculas(chave1, chave2) {
        var obj = document.form1;
        obj.j01_matric.value = chave1;
        obj.z01_nomematri.value = chave2;
        db_iframe_matriculas.hide();
    }
    function js_preenchematriculas1(chave, erro) {
        var obj = document.form1;
        var matri = obj.j01_matric.value;

        if (erro == true) {
            obj.j01_matric.value = '';
            obj.z01_nomematri.value = chave;
            obj.j01_matric.focus();
        } else {
            if (matri != '') {
                obj.z01_nomematri.value = chave;
            } else {
                obj.j01_matric.value = '';
                obj.z01_nomematri.value = '';
            }
        }
    }

    function js_mostrainscricoes(mostra) {
        var obj = document.form1;
        var inscr = obj.q02_inscr.value;
        var sUrl1 = 'func_issbase.php?funcao_js=parent.js_preencheinscricoes|q02_inscr|z01_nome';
        var sUrl2 = 'func_issbase.php?pesquisa_chave=' + inscr + '&funcao_js=parent.js_preencheinscricoes1';

        if (mostra == true) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_inscricoes', sUrl1, 'Pesquisa Inscrição', true);
        } else {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_inscricoes', sUrl2, 'Pesquisa Inscrição', false);
        }
    }
    function js_preencheinscricoes(chave1, chave2) {
        var obj = document.form1;
        obj.q02_inscr.value = chave1;
        obj.z01_nomeinscr.value = chave2;
        db_iframe_inscricoes.hide();
    }
    function js_preencheinscricoes1(chave, erro) {
        var obj = document.form1;
        var inscr = obj.q02_inscr.value;

        if (erro == true) {
            obj.q02_inscr.value = '';
            obj.z01_nomeinscr.value = chave;
            obj.q02_inscr.focus();
        } else {
            if (inscr != '') {
                obj.z01_nomeinscr.value = chave;
            } else {
                obj.q02_inscr.value = '';
                obj.z01_nomeinscr.value = '';
            }
        }
    }

    function js_validarGenerico(param) {
        var obj = document.form1;
        var lParam = param;
        var numcgm = obj.z01_numcgm.value;

        if (lParam == true) {
            var sNome = '&z01_numcgm=' + numcgm;
            var sUrl = sNome ;

            jan = window.open('div2_termoinscrdiv002.php?' + sUrl, '',
                'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
            jan.moveTo(0, 0);

        }
    }
</script>
