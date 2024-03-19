FROM ubuntu:22.04

LABEL maintainer="igor@contassconsultoria.com.br.com.br"
ENV GIT_SSH_COMMAND "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no"

# Habilita modo n�o interativo na instalação de pacotes
ENV DEBIAN_FRONTEND noninteractive

# Desabilita o cache do gerenciador de pacote
RUN echo "Acquire::http {No-Cache=True;};" > /etc/apt/apt.conf.d/no-cache

# Atualiza a lista de repositórios
RUN apt-get update

# Instala as dependências deste container
RUN apt-get install -y --no-install-recommends tzdata \
  locales \
  ca-certificates \
  sudo \
  software-properties-common \
  curl \
  unzip \
  zip \
  pigz \
  vim \
  sqlite3 \
  wget \
  language-pack-gnome-pt \
  language-pack-pt-base \
  myspell-pt \
  myspell-pt-br \
  wbrazilian \
  wportuguese \
  ghostscript \
  git \
  gnupg \
  gpg-agent \
  ssh \
  file \
  supervisor

# Instala o repositório do PostgreSQL
RUN wget -O- https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor | tee /usr/share/keyrings/postgresql.gpg && \
  echo "deb [arch=amd64,arm64,ppc64el signed-by=/usr/share/keyrings/postgresql.gpg] http://apt.postgresql.org/pub/repos/apt/ jammy-pgdg main" | tee /etc/apt/sources.list.d/postgresql.list

# Instala o repositório PPA do PHP
RUN apt-add-repository -y ppa:ondrej/php

# Configura a timezone do container para America/Sao_Paulo
ENV TZ America/Sao_Paulo
RUN echo $TZ > /etc/timezone && \
  cp /usr/share/zoneinfo/${TZ} /etc/localtime && \
  dpkg-reconfigure -f noninteractive tzdata

# Ajusta a codificação de ordenação para o LATIN1
RUN sed -i "s|copy \"iso14651_t1\"|copy \"iso14651_t1\"\nreorder-after <U00A0>\n<U0020><CAP>;<CAP>;<CAP>;<U0020>\nreorder-end|" /usr/share/i18n/locales/pt_BR

# Regera o locales
RUN localedef -i pt_BR -c -f ISO-8859-1 -A /usr/share/locale/locale.alias pt_BR && \
  locale-gen pt_BR && \
  echo "locales locales/default_environment_locale select pt_BR.UTF-8" | debconf-set-selections && \
  dpkg-reconfigure --frontend noninteractive locales

# Atualiza a lista de repositórios
RUN apt-get update

# Aceita os termos EULA para o pacote MS Core Fonts e instala o pacote
RUN echo ttf-mscorefonts-installer msttcorefonts/accepted-mscorefonts-eula select true | debconf-set-selections && \
  apt-get install -y --no-install-recommends ttf-mscorefonts-installer

# Instala o cliente PSQL
RUN apt-get install -y --no-install-recommends postgresql-client-12

# Instala o Libreoffice Writer
RUN apt-get install -y --no-install-recommends libreoffice-writer

# Instala o pacote do servidor web Apache2
RUN apt-get install -y --no-install-recommends \
  apache2

# Instala os pacotes do PHP como módulo FPM
RUN apt-get install -y --no-install-recommends \
  php7.4 \
  php7.4-bcmath \
  php7.4-bz2 \
  php7.4-cli \
  php7.4-common \
  php7.4-curl \
  php7.4-imagick \
  php7.4-gd \
  php7.4-interbase \
  php7.4-json \
  php7.4-mbstring \
  php7.4-pgsql \
  php7.4-soap \
  php7.4-sqlite3 \
  php7.4-xml \
  php7.4-xmlrpc \
  php7.4-zip \
  php7.4-intl \
  php7.4-opcache \
  php7.4-readline \
  php7.4-fpm \
  php7.4-xdebug

# Habilita o xdebug no PHP
RUN echo "xdebug.mode=develop,coverage,debug" >> /etc/php/7.4/mods-available/xdebug.ini && \
    echo "xdebug.remote_autostart=on" >> /etc/php/7.4/mods-available/xdebug.ini && \
    echo "xdebug.client_port=9003" >> /etc/php/7.4/mods-available/xdebug.ini && \
    echo "xdebug.log_level=0" >> /etc/php/7.4/mods-available/xdebug.ini && \
    echo "xdebug.idekey=PHPSTORM" >> /etc/php/7.4/mods-available/xdebug.ini && \
    echo "xdebug.client_host=host.docker.internal" >> /etc/php/7.4/mods-available/xdebug.ini && \
    echo "xdebug.log=/dev/stdout" >> /etc/php/7.4/mods-available/xdebug.ini
#    echo "xdebug.remote_handler=dbgp" >> /etc/php/7.4/mods-available/xdebug.ini

# Ajusta a permissão do imagick
RUN sed -i "s|<policy domain=\"coder\" rights=\"none\" pattern=\"PDF\" />|<policy domain=\"coder\" rights=\"read\|write\" pattern=\"PDF\" />|" /etc/ImageMagick-6/policy.xml

# Ajusta as configurações PHP como módulo FPM
RUN sed -i "s|^pm\ =.*|pm = ondemand|" /etc/php/7.4/fpm/pool.d/www.conf && \
  sed -i "s|^pm.max_children.*|pm.max_children = 300|" /etc/php/7.4/fpm/pool.d/www.conf && \
  sed -i "s|^pm.process_idle_timeout.*|pm.process_idle_timeout = 60s|" /etc/php/7.4/fpm/pool.d/www.conf && \
  sed -i "s|^pm.max_requests.*|pm.max_requests = 500|" /etc/php/7.4/fpm/pool.d/www.conf

# Ajusta as configurações do Apache2
RUN sed -i "s|^MaxRequestWorkers.*|MaxRequestWorkers         350|" /etc/apache2/mods-available/mpm_event.conf && \
  echo "umask 002" >> /etc/apache2/envvars && \
  a2enmod rewrite ssl proxy_fcgi setenvif && \
  a2enconf php7.4-fpm && \
  a2disconf serve-cgi-bin && \
  a2dissite 000-default.conf

# Instala o composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
  php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
  rm composer-setup.php

# Instala o node.js para suporte a módulos compilados com o NPM
#RUN curl -sS https://deb.nodesource.com/gpgkey/nodesource-repo.gpg
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
ENV NODE_MAJOR 20
RUN echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list
RUN apt-get install -y gcc g++ make nodejs

# Exporta variável que permite a execução do composer como root sem emitir avisos
#ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1

# Adiciona vhosts
ADD apache2/ecidade.conf /etc/apache2/sites-available/

# Configura o php.ini com os parâmetros necessários para o e-cidade
RUN ln -s /dev/stderr /var/log/php_errors.log && \
  chown www-data. /var/log/php_errors.log && \
  sed -i 's|^short_open_tag = .*|short_open_tag = On|g' /etc/php/7.4/fpm/php.ini && \
  sed -i 's|^session.gc_maxlifetime = .*|session.gc_maxlifetime = 7200|g' /etc/php/7.4/fpm/php.ini && \
  sed -i 's|^;date.timezone =.*|date.timezone = "America/Sao_Paulo"|g' /etc/php/7.4/fpm/php.ini && \
  sed -i 's|^;error_log.*|error_log = /var/log/php_errors.log|g' /etc/php/7.4/fpm/php.ini && \
  sed -i 's|^short_open_tag = .*|short_open_tag = On|g' /etc/php/7.4/cli/php.ini && \
  sed -i 's|^session.gc_maxlifetime = .*|session.gc_maxlifetime = 7200|g' /etc/php/7.4/cli/php.ini && \
  sed -i 's|^;date.timezone =.*|date.timezone = "America/Sao_Paulo"|g' /etc/php/7.4/cli/php.ini && \
  sed -i 's|^;error_log.*|error_log = /var/log/php_errors.log|g' /etc/php/7.4/cli/php.ini

# Configura o Supervisor
RUN mkdir -p /run/php/
COPY supervisord/supervisord.conf /etc/supervisor/supervisord.conf
COPY supervisord/conf.d/ /etc/supervisor/conf.d/

#RUN useradd -d /home/contass -g www-data -G sudo,adm,cdrom,dip,plugdev -k /etc/skel -m -s /bin/bash contass
RUN adduser --uid 1000 --disabled-password --gecos "" contass
RUN usermod -g www-data contass
#RUN  sed -i /etc/sudoers -re 's/^%sudo.*/%sudo all=(all:all) nopasswd: all/g' && \
#     sed -i /etc/sudoers -re 's/^root.*/root all=(all:all) nopasswd: all/g' && \
#     sed -i /etc/sudoers -re 's/^#includedir.*/## **removed the include directive** ##"/g' && \

RUN echo 'contass ALL=(ALL) NOPASSWD: ALL' >> /etc/sudoers

# Limpa os temporários
RUN apt-get clean && \
  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/*

# Adiciona o script de inicialiação
COPY ./scripts/iniciar.sh /iniciar.sh
RUN chmod 755 /iniciar.sh

EXPOSE 80

WORKDIR /var/www/html

#RUN chmod -R 775 /var/www/html/*

USER contass

#RUN chmod -R 777 /var/www/html/tmp/
#
#RUN /var/www/html/composer install

#CMD ["/bin/bash", "/iniciar.sh"]
