# Use a debian light image
FROM debian:stretch-slim

# Install packages
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
		unzip \
		curl && \
		apt-get clean && \
		rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Enable php modules
RUN a2enmod php7.2
RUN a2enmod rewrite
RUN a2enmod headers

# Get composer
RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

# Apache2 conf
ADD tba-api.conf /etc/apache2/sites-available

# Apache2 modules
RUN a2enmod rewrite
RUN a2enmod headers

# Apache2 tba-api conf
RUN a2ensite tba-api
RUN a2dissite 000-default

# Copy the project inside the container
COPY ./ /var/www/html/tba-api

VOLUME /var/www/html/tba-api

# Open port for httpd access
EXPOSE 80

# Set the project workplace at main directory
WORKDIR /var/www/html/tba-api

# Composer install
#RUN composer install

# Start httpd when container runs
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
