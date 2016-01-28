BEGIN;
update cms.menus set content = '<div id="consulta_dados">
   <p><br> </p>
   <p>   </p>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas">Despesas</a></legend>
      <div>
         <p>Define-se como Despesa Pública o conjunto de dispêndios do Municipio ou de outra pessoa de direito público para o funcionamento dos serviços públicos. Nesse sentido, a despesa é parte do orçamento, ou seja, aquela em que se encontram classificadas todas as autorizações para gastos com as várias atribuições e funções governamentais. Em outras palavras, as despesas públicas formam o complexo da distribuição e emprego das receitas para custeio de diferentes setores da administração.</p>
         <p></p>
         <p></p>
      </div>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/receitas">Receitas</a></legend>
      <p></p>
      <p>Receita Pública é a soma de ingressos, impostos, taxas, contribuições e outras fontes de recursos, arrecadados para atender às despesas públicas.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/despesas/loadDiarias">Diárias</a></legend>
      <p></p>
      <p>Define-se como Diária a indenização que faz jus o servidor ou agente político que se deslocar, temporariamente, da respectiva localidade onde tem exercício, a serviço ou para participar de evento de interesse da administração pública, prévia e formalmente autorizada pelo ordenador de despesas ou pessoa delegada por ele, destinada a cobrir as despesas de alimentação, hospedagem e locomoção urbana (realizada por qualquer meio de transporte de cunho local).</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/main/outras_informacoes">Outras Informações</a></legend>
      <p></p>
      <p>Espaço destinado a publicações da Entidade relacionadas a gestão da transparência.</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/folha_pagamentos">Folha de Pagamento / Pessoal</a></legend>
      <p></p>
      <p>Espaço destinado a apresentação dos dados funcionais e salariais dos servidores (efetivos, cargo em comissão, cargos temporários, aposentados e pensionistas)</p>
      <p></p>
   </fieldset>
   <br>
   <fieldset style="background: #FFF;">
      <legend><a href="{{url_base}}/licitacoes">Licitacões</a></legend>
      <p></p>
      <p><div><p>Define-se c
omo Despesa Pública o conjunto de dispêndios do Municipio ou de outra pessoa de direito      público para o funcionamento dos serviços públ
icos. Nesse sentido, a despesa é parte do orçamento, ou seja,      aquela em que se encontram classificadas todas as autorizações para gasto
s com as várias atribuições e funções      governamentais. Em outras palavras, as despesas públicas formam o complexo da distribuição e
emprego das receitas      para custeio de diferentes setores da administração.</p></div></p>
      <p></p>
   </fieldset>
   <br>
</div>' where id = 1;

COMMIT;