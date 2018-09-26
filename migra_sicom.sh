#!/bin/bash

migrar_arquivos(){
#	caminho=$(pwd)
	anoatual=`date +%Y`
	novoAno=$((anoatual+1))
	echo "-----------------------------------------------------"
	echo "	    Replicando Arquivos $anoatual --> $novoAno "
	echo "-----------------------------------------------------"
	caminho='./classes'
	replica_arquivos $caminho $anoatual $novoAno
	echo '-----------------------------------------------------'
	echo "	   Replicando Diretórios $anoatual --> $novoAno "
	echo '-----------------------------------------------------'
	caminho='./model'
	replica_diretorios $caminho $anoatual $novoAno
	#Remove Arquivo 0 Gerado
	find -type f -name '0' -delete
}

replica_arquivos(){
	caminho=$1
	anoatual=$2
	novoAno=$3

	if [ $caminho == './classes' ]; then
	for file in $(find $caminho -type f -name "*$anoatual*");
	 do
	     newname=$(echo $file| sed "s/$anoatual/$novoAno/")
	     directory=`(dirname ${file})`
	     newfile=`(basename ${newname})`
	   if [ -e $newname ]; then
		echo "$newfile Já Existe"
	   else
	     echo $file' --> '$newfile
             cat $file > $newname
	     alteraConteudo $anoatual $novoAno $newname
	   fi
	 done
	else
	   for file in $(find $caminho -type f -name "*");
	    do
	     alteraConteudo $anoatual $novoAno $file
	    done
	fi

}

replica_diretorios(){
	caminho=$1
	anoatual=$2
	novoAno=$3

	for dir in $(find $caminho -type d -name $anoatual);
	 do
	  newDir=$(echo $dir| sed "s/$anoatual/$novoAno/")
	  if [ -e $newDir ]; then
		echo "$newDir Já Existe"
	  else
		echo $dir' --> '$newDir
	  	cp $dir $newDir -R
	  	replica_arquivos $newDir $anoatual $novoAno
	  fi
	 done
}

alteraConteudo(){
	#Altera o Conteúdo dos Arquivos
	sed -i "s/$1/$2/g" $3
}

menu()
{
  opcao=1
  echo '*******************************'
  echo '*  Migração de Arquivos SICOM *'
  echo '*******************************'
  while [ $opcao == 1 ]
  do
  echo "	Começar Migração?	"
  echo "	1-Sim	2-Cancelar"
  echo -n 'Selecione: '
    read opcao
    case $opcao in
     1) migrar_arquivos;;
     2) exit ;;
    esac
  done
}
menu
