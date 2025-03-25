# FROM php:8.2-fpm

# # Instalar dependências básicas
# RUN apt-get update && apt-get install -y \
#     git \
#     unzip \
#     curl \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     && docker-php-ext-configure gd \
#     && docker-php-ext-install gd pdo pdo_mysql

# # Instalar Node.js e npm
# RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
# && apt-get install -y nodejs

# # Instalar Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Definir diretório de trabalho
# WORKDIR /var/www

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

# Definir comando para rodar o PHP-FPM
CMD ["php-fpm"]
