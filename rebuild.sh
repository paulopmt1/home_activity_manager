#!/bin/bash

replaceString='s/database_name:.*/database_name:     home_activity_manager/'
replaceFile=app/config/parameters.yml
unamestr=$(uname)

# troca o nome do banco para garantir
if [[ "$unamestr" == 'Linux' ]]; then
	sed -i "$replaceString" "$replaceFile"
else
	# o sed tem putaria diferente para MAC
	sed -i '' "$replaceString" "$replaceFile"
fi

# Exporta base em yaml (gera arquivos em metadados)
php bin/console doctrine:mapping:convert yaml ./src/AppBundle/Resources/config/doctrine/metadata/orm --from-database --force

# Cria classes de entidade
php bin/console doctrine:mapping:import AppBundle annotation
php bin/console doctrine:generate:entities AppBundle --no-backup

git add database/scripts
git add src/AppBundle/Entity
git add -f src/AppBundle/Resources/config/doctrine/metadata/orm
git checkout app/config/parameters.yml
