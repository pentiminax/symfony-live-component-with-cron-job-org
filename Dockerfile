FROM dunglas/frankenphp

ENV SERVER_NAME=localhost

WORKDIR /app

RUN set -eux; \
	install-php-extensions \
		@composer \
		apcu \
		intl \
		opcache \
        pdo_pgsql \
		zip \
	;

ENV COMPOSER_ALLOW_SUPERUSER=1

ENV APP_ENV=prod

COPY --link . ./

# prevent the reinstallation of vendors at every changes in the source code
COPY --link composer.* symfony.* ./
RUN set -eux; \
	composer install --no-cache --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer dump-env prod; \
	composer run-script --no-dev post-install-cmd; \
	chmod +x bin/console; sync;