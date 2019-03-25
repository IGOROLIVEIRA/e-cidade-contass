#!/bin/bash
export LC_ALL=pt_BR.ISO-8859-1
export LANG="$LC_ALL"

HOSTNAME=$(hostname)
CAMINHO="$(pwd)/updatedb"

LOGS="${CAMINHO}/log"
EXECUTADOS="${CAMINHO}/scripts_executados"
DISPONIVEIS="${CAMINHO}/scripts_disponiveis"
BASES_LOCAIS="$(cat ${CAMINHO}/conn | grep -e "$HOSTNAME$")"
EXECUTADOS_TMP="/tmp/scripts_executados"
NAO_EXECUTADOS="${CAMINHO}/scripts_nao_executados"

mkdir -p $LOGS

cd $CAMINHO

echo "
# ${HOSTNAME}

- Rastreando scripts disponíveis..."

ls *.sql > $DISPONIVEIS 2> /dev/null

[ $? != 0 ] && {

  echo "  > Nenhum arquivo encontrado."
  exit 4

} || {

  count=$(wc -l < $DISPONIVEIS)
  echo "  > ${count} script(s) disponíveis."

}

echo "$(cat $DISPONIVEIS | sort | uniq)" > $DISPONIVEIS


echo "
- Atualizando bases de dados..."

echo "$BASES_LOCAIS" | while read BANCO PORTA CLIENTE
do

  momentoConsulta=$(date +%Y-%m-%d_%H:%M:%S)
  logConsulta="${LOGS}/${momentoConsulta}_consulta_updatedb.log"

  echo "  +> ${BANCO}"

  psql -U dbportal -p $PORTA $BANCO -f $CAMINHO/update_table.sh > $logConsulta 2> $logConsulta

  echo "$(cat $EXECUTADOS_TMP | sort | uniq)" > $EXECUTADOS

  diff --side-by-side --suppress-common-lines $DISPONIVEIS $EXECUTADOS | cut -d" " -f1 | grep '[a-zA-Z]' > $NAO_EXECUTADOS

  echo "  ├─ $(wc -l < $NAO_EXECUTADOS) script(s) a serem executados"

  abortou=0

  cat $NAO_EXECUTADOS | while read SCRIPT
  do

    dataScript=$(date +%Y-%m-%d)

    momentoScript="${dataScript}_$(date +%H:%M:%S)"

    logScript="${LOGS}/${momentoScript}_${BANCO}_${SCRIPT}.log"

    if [ -f "${CAMINHO}/${SCRIPT}" ]
    then

      psql -U dbportal \
        -p $PORTA $BANCO \
        -v ON_ERROR_STOP=on \
        -f "${CAMINHO}/${SCRIPT}" &> $logScript

      executouScript=$?

      if test $executouScript -eq 0
      then

        sqlUpdate="begin; INSERT INTO updatedb (nomescript,dataexec) VALUES ('${SCRIPT}','${dataScript}'); commit;"
        psql -U dbportal -p $PORTA $BANCO -c "${sqlUpdate}" &>> $logScript

      fi

    else
      continue
    fi

    if test $executouScript -eq 0
    then
      echo "  │  ├─ ${SCRIPT}: [ OK ]"
    else

      echo "  │  ├─ ${SCRIPT}: [ ERRO - consulte o log ]"
      abortou=1
      break

    fi

  done

  echo "  └─ Procedimento finalizado."

  echo ""
done

# rm $CAMINHO/conn

