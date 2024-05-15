#!/bin/bash

if test $# -lt 4
then
	echo "\nForma de usar: \nsh $0 (changelist) (login) (cliente) (diretorio)\n";
	exit 1;
fi

CHANGELIST=$1
LOGIN=$2
CLIENTE=$3
DIRETORIO=$4
 
# read -p "Senha: " SENHA

for fil in $(svn status --changelist $CHANGELIST | tail -n+3 | cut -d' ' -f8)
  do scp $fil $LOGIN@$CLIENTE:/var/www/$DIRETORIO/$fil
done
