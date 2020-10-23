FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG USER
ARG UID

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libgmp-dev \
    libldap2-dev \
    libxpm-dev \
    libvpx-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd \
    --with-freetype=/usr/include/ \
    --with-webp=/usr/include/ \
    --with-jpeg=/usr/include/ \
    --with-xpm=/usr/include/ \
    && docker-php-ext-install gd pdo_mysql mbstring exif pcntl bcmath

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u ${UID} -d /home/${USER} ${USER}
RUN mkdir -p /home/${USER}/.composer && \
    chown -R ${USER}:${USER} /home/${USER}

# Set working directory
WORKDIR /var/www

USER ${USER}

