# Use a debian light image
FROM debian:stretch-slim

# Get needed packages for sf4
RUN apt-get update && \
	apt-get -y install wget apt-transport-https ca-certificates && \
	wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
	sh -c 'echo "deb https://packages.sury.org/php/ stretch main" > /etc/apt/sources.list.d/php.list' && \
	apt-get update && \
	apt-get install -y \
		php7.2-curl \
		php7.2 \
		php7.2-mysql \
		php7.2-common \
		php7.2-xml \
		php7.2-mbstring \
		php7.2-zip \
		libapache2-mod-php7.2 \
		apache2 \
		mysql-server \
		unzip \
		curl && \
		apt-get clean && \
		rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Enable php modules
RUN a2enmod php7.2
RUN a2enmod rewrite

# Get composer
RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

# Test file for the container
ADD docker-conf/apache2/index.php /var/www/html
# Conf file for mysql to enable outside connexion (bind adress 0.0.0.0)
COPY ./docker-conf/mysql/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf
# Copy the project inside the container
COPY ./ /var/www/html/tba-api
# Set the project workplace at main directory
WORKDIR /var/www/html/tba-api

# Composer install
RUN composer install
# Add x right to setup script
RUN chmod +x docker-conf/setup.sh

# Expose for outside the container http & mysql ports
EXPOSE 80
EXPOSE 3306

# Start apache2
# (il faut utiliser un supervisor car un seul service peut être lancé par conteneur)
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

