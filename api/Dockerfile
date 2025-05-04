# Usar imagem oficial do PHP com Apache
FROM php:8.1-apache

# Habilitar módulo de reescrita do Apache
RUN a2enmod rewrite

# Copiar os arquivos do projeto para o diretório padrão do Apache
COPY ./app /var/www/html/

# Definir permissões adequadas para os arquivos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expor a porta 80 para acesso HTTP
EXPOSE 80

# Iniciar o servidor Apache
CMD ["apache2-foreground"]