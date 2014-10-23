NoConsoleComposer
=================

PHP script that can help you run composer even if you don't have SSH access to your server.


Installation
=================

Steps to use NoConsoleComposer :

 1. Download the source from above and put the `composer` folder where you can access it from web. For shared hosting, it would be under the `public_html` folder most probably. I'll assume that you put the `composer` folder directly under `public_html`. i.e, `public_html/composer`.
 2. Edit the `composer/password.php` file and set your own password. Let's take an example, you want to set your password to `99_66_88`, then you would see something like this in your `composer/password.php` file : `$password = "99_66_88"`.
 3. Access NoConsoleComposer from `http://yourhost.com/composer/index.php`. It will ask for your username and password. You can put any username, but be sure to put the password in the `composer/password.php` file, otherwise it will never stop asking you the password. You'll see a prompt like this : ![](http://i.imgur.com/jJqkh3B.png?1)
 4. After authentication, you'll see a screen like this :![](http://i.imgur.com/qXyrcr5.png?1)The screen is doing what it is saying, i.e, downloading composer from web. It will show updates and then the page will refresh. And the buttons will show up :![](http://i.imgur.com/c3KE4HE.png?1)

Usage
==================

 1. You will have to input the relative path(with respect to `composer/main.php`) or absolute path to the folder in which you want to run the command.
 2. Click the appropriate button and keep an eye on the log.