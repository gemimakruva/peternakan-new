FROM dunglas/frankenphp:1.10.1-php8.3

RUN install-php-extensions \
	pdo_mysql \
	redis \
	zip \
	opcache \
	intl \
	pcntl

#ENV FRANKENPHP_CONFIG="worker ./public/index.php"
ENV SERVER_NAME=:80

#COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
#RUN chmod +x /usr/local/bin/docker-entrypoint.sh

#EXPOSE 80

#CMD ["/usr/local/bin/docker-entrypoint.sh"]