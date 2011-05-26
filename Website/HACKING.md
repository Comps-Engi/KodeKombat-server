##Installation

to install combaticus on apache, set up a virtual host
by including apache-vhost.conf in your httpd.conf
(after editing apache-vhost.conf to suit your setup).

then setup a hostname in your /etc/hosts file by adding this line:

`127.0.0.1     kk.dev`

make sure that you have enabled mod_rewrite module by running

```
a2enmod
rewrite
```

create a mysql database and then run this command:

```
mysql -u username -p databasename < schema.sql
```
edit config.php to reflect your database settings.
restart apache and visit http://kk.dev to see if it is working

##Hacking

combaticus uses the Flourish:http://flourishlib.com unframework.
also Moor for routing and Twig for templating (google maadi)

the app logic is contained completely in app.php, that's the place
you're most likely looking for. lib/models.php contains models that
extend the fActiveRecord class of flourish. Please look at flourish
documentation for more on that.

some utility functions you can use in hacking app.php

```php
get('/url/:pattern', 'actionname', function () {
	/* figure out what to do here */
	view('argument', $value); // this sets a value for
				  // the twig template to consume

	render('templatename');   // this will render the twig template
				  // using the currently set values

	redirect('actionname', $urlparams); // this will redirect to a
					    // different action
});
```

The templates can be found in the views/ directory. For theming, you can
drop in your css/less code into themes/default/screen.less

Happy Hacking!

