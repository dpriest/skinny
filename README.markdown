Skinny 
======

Skinny is a simple application to build lists. 
It is coded with [symfony](http://www.symfony-project.org/).

You can see it online at [http://listandcheck.com](http://listandcheck.com).

Installation
------------

Skinny is a symfony application. You can clone its repository by doing
  
  git clone git://github.com/nacmartin/skinny.git

and then congfigure a virtual hosts in apache:

	<VirtualHost *:80>
	    ServerName check.com
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

configure your database with:

	php symfony configure:database "mysql:host=localhost;dbname=jobeet" root mYsEcret

import the database struct with following command:

	php symfony doctrine:build --all

After that, you can proceed as usual with symfony.

License
-------

Skinny is licensed under [CC-by-sa-3.0](http://creativecommons.org/licenses/by-sa/3.0/) license.

It contains code from [symfonians](http://symfonians.org) and [symfony-check](http://symfony-check.org/). Its design obviously comes from symfony-check.

Skinny is open sourced to give ideas for projects using symfony. Although, of course, you can use the code for whatever you want if you respect the license.

Postscript
----------

In case you are curious, Skinny is a character of Breaking Bad (I name projects after BB characters).
