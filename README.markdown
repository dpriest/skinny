Skinny 
======

Skinny is a simple application to build lists. 
It is coded with [symfony](http://www.symfony-project.org/).

You can see it online at [http://http://www.quzuo.net/](http://http://www.quzuo.net/).

Installation
------------

Skinny is a symfony application. You can clone its repository by doing
  
  git clone git://github.com/nacmartin/skinny.git

and then congfigure a virtual hosts in apache:

	<VirtualHost *:80>
	    ServerName www.quzuo.com
	    DocumentRoot "/var/www/html/skinny/web"
	    DirectoryIndex index.php
	    <Directory "/var/www/html/skinny/web">
	        AllowOverride All
	        Allow from All
	    </Directory>
	    Alias /sf "/var/www/library/symfony/data/web/sf"
	    <Directory "/var/www/library/symfony/data/web/sf">
	        AllowOverride All 
	        Allow from All 
	    </Directory>
	</VirtualHost>

configure for nginx:

    #
    # The default server
    #
    server {
	    set $website_host "www.quzuo.net";
	    set $website_root "/var/www/html/skinny/web";
	    set $default_controller "index.php";
	    set $symfony_root "/var/www/html/skinny/lib/vendor/symfony";

	    listen 80;
	    server_name $website_host;

    # Gzip
	    gzip on;
	    gzip_min_length 1000;
	    gzip_types text/plain text/css application/x-javascript text/xml application/xml application/xml+rss text/javascript;
	    gzip_disable "MSIE [1-6]\.";

	    access_log /var/log/nginx/$website_host.access.log;
	    error_log  /var/log/nginx/www.quzuo.net.error.log;

	    root $website_root;

	    index $default_controller;

	    charset utf-8;

	    location /sf {
            # path to folder where all symfony assets are located
		    alias $symfony_root/data/web/sf;
		    expires max;
	    }

	    location / {
            # If the file exists as a static file serve it directly without
            # running all the other rewite tests on it
		    if (-f $request_filename) {
			    expires max;
			    break;
		    }

		    if ($request_filename !~ "\.(js|htc|ico|gif|jpg|png|css)$") {
			    rewrite ^(.*) /$default_controller$1 last;
		    }
	    }

	    location ~ "^(.+\.php)($|/)" {

		    set $script $uri;
		    set $path_info "/";

		    if ($uri ~ "^(.+\.php)($|/)") {
			    set $script $1;
		    }

		    if ($uri ~ "^(.+\.php)(/.+)") {
			    set $script $1;
			    set $path_info $2;
		    }

		    include /etc/nginx/fastcgi_params;
		    fastcgi_pass 127.0.0.1:9000;

		    fastcgi_param SCRIPT_FILENAME $website_root$script;
		    fastcgi_param SCRIPT_NAME $script;
		    fastcgi_param PATH_INFO $path_info;
	    }
    }

configure your database with:

	php symfony configure:database "mysql:host=localhost;dbname=jobeet" root mYsEcret

import the database struct with following command:

	php symfony doctrine:build --all

After that, you can proceed as usual with symfony.

You can disable the apc module by commenting the code in config/ProjectConfiguration.class.php, line 28, defined in the configureDoctrine:

	$manager->setAttribute(Doctrine::ATTR_QUERY_CACHE, new Doctrine_Cache_Apc());

Create admin user by typing following command:

	php symfony guard:create-user --is-super-admin wenhaoz100@gmail.com admin 123456

License
-------

Skinny is licensed under [CC-by-sa-3.0](http://creativecommons.org/licenses/by-sa/3.0/) license.

It contains code from [symfonians](http://symfonians.org) and [symfony-check](http://symfony-check.org/). Its design obviously comes from symfony-check.

Skinny is open sourced to give ideas for projects using symfony. Although, of course, you can use the code for whatever you want if you respect the license.

Postscript
----------

In case you are curious, Skinny is a character of Breaking Bad (I name projects after BB characters).
