BEGIN;
update cms.menus set content = '<div id="consulta_dados">
   <p><br> </p>
   <p>   </p>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas">Despesas</a></legend>
      <div>
         <p>Define-se como Despesa P�blica o conjunto de disp�ndios do Municipio ou de outra pessoa de direito p�blico para o funcionamento dos servi�os p�blicos. Nesse sentido, a despesa � parte do or�amento, ou seja, aquela em que se encontram classificadas todas as autoriza��es para gastos com as v�rias atribui��es e fun��es governamentais. Em outras palavras, as despesas p�blicas formam o complexo da distribui��o e emprego das receitas para custeio de diferentes setores da administra��o.</p>
         <p></p>
         <p></p>
      </div>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/receitas">Receitas</a></legend>
      <p></p>
      <p>Receita P�blica � a soma de ingressos, impostos, taxas, contribui��es e outras fontes de recursos, arrecadados para atender �s despesas p�blicas.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas/loadDiarias">Di�rias</a></legend>
      <p></p>
      <p>Define-se como Di�ria a indeniza��o que faz jus o servidor ou agente pol�tico que se deslocar, temporariamente, da respectiva localidade onde tem exerc�cio, a servi�o ou para participar de evento de interesse da administra��o p�blica, pr�via e formalmente autorizada pelo ordenador de despesas ou pessoa delegada por ele, destinada a cobrir as despesas de alimenta��o, hospedagem e locomo��o urbana (realizada por qualquer meio de transporte de cunho local).</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/main/outras_informacoes">Outras Informa��es</a></legend>
      <p></p>
      <p>Espa�o destinado a publica��es da Entidade relacionadas a gest�o da transpar�ncia.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/folha_pagamentos">Folha de Pagamento / Pessoal</a></legend>
      <p></p>
      <p>Espa�o destinado a apresenta��o dos dados funcionais e salariais dos servidores (efetivos, cargo em comiss�o, cargos tempor�rios, aposentados e pensionistas)</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/licitacoes">Licitac�es</a></legend>
      <p></p>
      <p><div><p>Define-se c
omo Despesa P�blica o conjunto de disp�ndios do Municipio ou de outra pessoa de direito      p�blico para o funcionamento dos servi�os p�bl
icos. Nesse sentido, a despesa � parte do or�amento, ou seja,      aquela em que se encontram classificadas todas as autoriza��es para gasto
s com as v�rias atribui��es e fun��es      governamentais. Em outras palavras, as despesas p�blicas formam o complexo da distribui��o e
emprego das receitas      para custeio de diferentes setores da administra��o.</p></div></p>
      <p></p>
   </fieldset>
   <br>
</div>' where id = 1;

COMMIT;