---
title: "Format Laravel with Pint"
description: "How to use the Laravel Pint console command to format all the files in your Laravel project, following best practices."
category: Guide
author: "Jorge Thomas"
date: "2023-02-13 02:32"
image: "posts/php-pint-format-13022023/cover.jpg"
tags: [PHP, Laravel]
---

## Using Pint on PHP

Have you ever found yourself working on a Laravel project only to realize that the code is messy and difficult to understand? This can be incredibly frustrating, especially if you’re not the original developer of the project. But don’t worry, in Laravel there’s a great package called Pint that allows you to format your code using the [PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) tool, following best practices.

However, using Pint from the command line can be a bit of a hassle, as you need to call the binary directly from `./vendor/bin/pint`. That’s why I’ve created a simple console command to make it easier to use.

In this post, you’ll learn how to use the Laravel Pint console command to format all the files in your Laravel project, following best practices. Get ready to have clean and organized code!

Before we start, it’s important to check what version of PHP and Composer you’re using, so you can replicate the same results. To do this, use these commands:

```console
php -v
composer -V
```

```console
#My PHP & Composer Version
echo shell_exec("php -v");
strrchr(shell_exec("composer -V"),"Composer");
```

```console
PHP 8.2.2 (cli) (built: Feb  7 2023 11:37:04) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.2.2, Copyright (c) Zend Technologies
    with Zend OPcache v8.2.2, Copyright (c), by Zend Technologies
'Composer 2.0.9 2021-01-27 16:09:27'
```

Laravel’s Artisan is more than just a simple command line interface, it’s a powerful tool that can help you streamline your workflow and make your life easier as a developer. With Artisan, you can create new projects, generate new controllers and models, and much more with just a few simple commands.

Let’s take a look at a basic example of how you can use Artisan to get information about your Laravel project. Simply run the following command in your terminal:

```console
php artisan about
```

```console
shell_exec("php artisan about");
```

```console
  Environment ................................................................
  Application Name ................................................... Laravel
  Laravel Version ..................................................... 9.51.0
  PHP Version .......................................................... 8.2.2
  Composer Version ..................................................... 2.0.9
  Environment .......................................................... local
  Debug Mode ......................................................... ENABLED
  URL .............................................................. localhost
  Maintenance Mode ....................................................... OFF

  Cache ......................................................................
  Config .......................................................... NOT CACHED
  Events .......................................................... NOT CACHED
  Routes .......................................................... NOT CACHED
  Views ........................................................... NOT CACHED

  Drivers ....................................................................
  Broadcasting ........................................................... log
  Cache ................................................................. file
  Database ............................................................. mysql
  Logs ........................................................ stack / single
  Mail .................................................................. smtp
  Queue ................................................................. sync
  Session ............................................................... file
```

And voilà! You’ll get all the details you need about your project.

But that’s not all! Artisan can do much more. For example, let’s say you want to use Pint to format your code. You can create a new Artisan command specifically for this purpose with just one line of code:

```console
php artisan make:command PintCommand
```

```console
#Let's create the console command inside Laravel
shell_exec("php artisan make:command PintCommand");
```

```console
   INFO  Console command [app/Console/Commands/PintCommand.php] created successfully.
```

Now that you’ve created the command, it’s time to make it do something. Open the file app/Console/Commands/PintCommand.php and add the following code:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PintCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pint:format {--p|preset=laravel : set of rules that can be used to fix code style issues in your code. currently supported presets are: laravel, psr12, and symfony.} {--c|config= : config file with presets, rules or exclusions for pint} {--v : verbose} {--t|test : inspect your code for style errors without actually changing the files} {--d|dirty : modify the files that have uncommitted changes according to Git}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Pint is an opinionated PHP code style fixer for minimalists';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Running Pint...');
        $options = $this->options();

        if (! is_null($options['config']) && (substr($options['config'], -5) !== '.json')) {
            $this->error('The --config option must be a .json file.');

            return Command::FAILURE;
        }

        if (! is_null($options['preset']) && ($options['preset'] !== 'laravel' && $options['preset'] !== 'psr12' && $options['preset'] !== 'symfony')) {
            $this->error('The --preset option must be one of these: laravel, psr12 or symfony.');

            return Command::FAILURE;
        }

        $configfile = $options['config'];

        $output = shell_exec('./vendor/bin/pint'.($options['config'] ? ' --config='.$configfile : '').($options['v'] ? ' -v' : '').($options['test'] ? ' --test' : '').($options['dirty'] ? ' --dirty' : ''));

        echo $output.PHP_EOL;

        return Command::SUCCESS;
    }
}
```

Here we’re creating a new command called pint:format, which will run the pint command from the vendor/bin folder. We’ve also added several options to the command, such as –config, –preset, –verbose, –test, and –dirty, to give you more control over how Pint formats your code. We’ve also added some validation to make sure the options passed to the command are valid.

To see if Artisan recognizes your new command, try running the following command in your terminal:

```console
php artisan -h pint:format
```

```console
shell_exec("php artisan -h pint:format");
```

```console
Description:
  Laravel Pint is an opinionated PHP code style fixer for minimalists

Usage:
  pint:format [options]

Options:
  -p, --preset[=PRESET]  set of rules that can be used to fix code style issues in your code. currently supported presets are: laravel, psr12, and symfony. [default: "laravel"]
  -c, --config[=CONFIG]  config file with presets, rules or exclusions for pint
      --v                verbose
  -t, --test             inspect your code for style errors without actually changing the files
  -d, --dirty            modify the files that have uncommitted changes according to Git
  -h, --help             Display help for the given command. When no command is given display help for the list command
  -q, --quiet            Do not output any message
  -V, --version          Display this application version
      --ansi|--no-ansi   Force (or disable --no-ansi) ANSI output
  -n, --no-interaction   Do not ask any interactive question
      --env[=ENV]        The environment the command should run under
  -v|vv|vvv, --verbose   Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

```

Artisan will now show you that you have a new command called pint:format with all the options you provided in the signature property of the command. And to actually run the command, simply type:

```console
php artisan pint:format
```

```console
shell_exec("php artisan pint:format");
```

```console
Running Pint...

  ................................✓......................

  ──────────────────────────────────────────────────────────────────── Laravel
    FIXED   .................................... 55 files, 1 style issue fixed
  ✓ app/Console/Commands/PintCommand.php concat_space, not_operator_with_succ…
```

The possibilities are endless when it comes to Artisan commands. You can create more complex commands by adding more options and validations, or you can add more properties to the command class. For more information, be sure to check out the [Laravel documentation](https://laravel.com/docs/master/artisan#writing-commands) on writing Artisan commands.

In conclusion, Artisan is a fantastic tool for streamlining your workflow and making your life as a developer much easier. Whether you’re working with a team, or taking over an already-created project, Artisan can help you ensure that your code is properly formatted and follows best practices.
