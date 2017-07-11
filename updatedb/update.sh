#!/bin/bash
export LC_ALL=pt_BR.ISO-8859-1
export LANG="$LC_ALL"
HOSTNAME=`hostname`
CAMINHO="/var/www/e-cidade/updatedb"
EXECUTADOS="/tmp/scripts_executados.sh"
mkdir -p /var/www/e-cidade/updatedb/log/

cd $CAMINHO
for SCRIPTS in $(ls *.sql);
do
 echo $SCRIPTS >> $CAMINHO/scripts_disponiveis.sh	
done
cat $CAMINHO/scripts_disponiveis.sh | sort | uniq > $CAMINHO/scripts_disponiveis_ordenado.sh

cat $CAMINHO/conn | while read BANCO PORTA CLIENTE
do

   if [ $HOSTNAME != $CLIENTE ]; then
	continue
   fi

   psql -U dbportal -p $PORTA $BANCO -f $CAMINHO/update_table.sh
   
   cat $EXECUTADOS | sort | uniq > $CAMINHO/scripts_executados_ordenado.sh

   diff --side-by-side --suppress-common-lines $CAMINHO/scripts_disponiveis_ordenado.sh  $CAMINHO/scripts_executados_ordenado.sh | cut -d" " -f1 | grep '[a-zA-Z]' > $CAMINHO/scripts_nao_executados.sh

   cat $CAMINHO/scripts_nao_executados.sh | while read SCRIPT
   do
	if [ -f "$CAMINHO/$SCRIPT" ]
	then
cat <<EOF> "$CAMINHO/${SCRIPT}_exec"
begin;
INSERT INTO updatedb (nomescript,dataexec) VALUES ('$SCRIPT','`date +%Y-%m-%d`') ;
commit;
EOF
	else
cat <<EOF> "$CAMINHO/${SCRIPT}_exec"
begin;
DELETE FROM updatedb WHERE nomescript = '$SCRIPT' ;
commit;
EOF
	fi

echo "$CAMINHO/$SCRIPT"

	psql -U dbportal -p $PORTA $BANCO -f "$CAMINHO/$SCRIPT" &> $CAMINHO/log/`date +%Y-%m-%d_%H:%M:%S`_`echo $BANCO`_`echo $SCRIPT | cut -d"/" -f6`.log
	psql -U dbportal -p $PORTA $BANCO -f "$CAMINHO/${SCRIPT}_exec" &> $CAMINHO/log/`date +%Y-%m-%d_%H:%M:%S`_`echo $BANCO`_`echo $SCRIPT | cut -d"/" -f6`.log
   done

done

#rm $EXECUTADOS
rm $CAMINHO/*.sql $CAMINHO/*.sh $CAMINHO/conn $CAMINHO/*.csv $CAMINHO/*_exec

