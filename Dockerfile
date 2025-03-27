FROM php:8.2-fpm

# Instalar dependências básicas do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Node.js e npm - Usando a imagem oficial do Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer (se já não estiver presente)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho dentro do container
WORKDIR /var/www

# Expor a porta 9000 para o PHP-FPM
EXPOSE 9000

# Set timezone to São Paulo
RUN ln -sf /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime && \
    echo "America/Sao_Paulo" > /etc/timezone

#Instala o cron junto com outras dependências
RUN apt-get update && apt-get install -y cron

# Copia o crontab para dentro do container (se necessário)
COPY crontab /etc/cron.d/laravel-cron

# Defina permissões corretamente para o arquivo de crontab
RUN chmod 0644 /etc/cron.d/laravel-cron

# Carregue o crontab
RUN crontab /etc/cron.d/laravel-cron

# Inicia o cron junto com o PHP-FPM
CMD service cron start && php-fpm