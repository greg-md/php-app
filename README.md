# Greg PHP Application

[![StyleCI](https://styleci.io/repos/72987376/shield?style=flat)](https://styleci.io/repos/72987376)
[![Build Status](https://travis-ci.org/greg-md/php-app.svg)](https://travis-ci.org/greg-md/php-app)
[![Total Downloads](https://poser.pugx.org/greg-md/php-app/d/total.svg)](https://packagist.org/packages/greg-md/php-app)
[![Latest Stable Version](https://poser.pugx.org/greg-md/php-app/v/stable.svg)](https://packagist.org/packages/greg-md/php-app)
[![Latest Unstable Version](https://poser.pugx.org/greg-md/php-app/v/unstable.svg)](https://packagist.org/packages/greg-md/php-app)
[![License](https://poser.pugx.org/greg-md/php-app/license.svg)](https://packagist.org/packages/greg-md/php-app)

The start is here.

# Instalation via Composer

`composer create-project greg-md/php-app`

# Nginx Configuration

```nginx
# Image resizing cache
location ~* @.+\.(png|jpe?g|gif)$ {
    if (!-f $document_root$uri) {
        rewrite ^/static/.+ /image.php last;
    }

    expires max;
    add_header Pragma public;
    add_header Cache-Control "public";
    add_header Vary "Accept-Encoding";
}

# Static files
location ~* .+\.(png|jpe?g|gif|css|txt|bmp|ico|flv|swf|pdf|woff|ttf|svg|eot|otf|xml|less|doc|rss|zip|mp3|rar|exe|wmv|doc|avi|ppt|mpg|mpeg|tif|wav|mov|psd|ai|xls|mp4|m4a|dat|dmg|iso|m4v|torrent)$ {
    expires max;
    add_header Pragma public;
    add_header Cache-Control "public";
    add_header Vary "Accept-Encoding";
}

location ~* .+\.(js)$ {
    expires max;
    add_header Pragma private;
    add_header Cache-Control "private";
    add_header Vary "Accept-Encoding";
}

location ~* .+\.(html?)$ {
    if (!-f $document_root$uri) {
        rewrite .+ /index.php?$args last;
    }

    expires max;
    add_header Pragma public;
    add_header Cache-Control "public";
    add_header Vary "Accept-Encoding";
}

# Main
location / {
    try_files $uri $uri/ /index.php?$args;
}
```