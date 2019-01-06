# Laravel-translation

[![Latest Version](https://img.shields.io/badge/Latest%20Version-1.0.1-blue.svg?style=flat)](https://github.com/Mekaeil/Laravel-translation/releases)
[![Build](https://img.shields.io/badge/build-passing-green.svg?style=flat)](https://github.com/Mekaeil/Laravel-translation)
[![Admin Panel Template](https://img.shields.io/badge/Admin%20Panel-Gentelella-yellowgreen.svg?style=flat)](https://github.com/puikinsh/gentelella)


This package used for multilingual website in Laravel framework.

# Install

[ step : 1]
```
composer require mekaeil/laravel-translation
```  

### Vendor Publish [ step : 2]

This files would be published after run bottom command:

*   Resource files for admin panel
*   Asset files for admin panel in public path
*   Config file ( config > laravel-translation.php )
*   Route file ( routes > route.laratrans.php )
*   Translation Helper ( app > LaraTransHelper )

```
php artisan vendor:publish 
```

### Migration [ step : 3 ]
before migration you can change TABLE names in config file.
    
```
config > laravel-translation.php
```

After that you can migrate.
    
```
php artisan migrate
```

### SEEDS [ step : 4 ]
Creating requirement and sample data in your database. It's important before seeding migrate your project.

When run publishing files, you can add and change seeder file in this path <br>
<span style="background:#95a5a6;color:#000;padding:0.2em;display:inline-block;">**database > seeds >laravelTranslation**
    
```
php artisan db:seed --class=Mekaeil\\LaravelTranslation\\src\\database\\seeds\\LaravelTranslationSeeder
```
    
    
# MAIN URLS / ROUTES

```
* http://your-domain.com/admin/translation/languages-translation    (Route: admin.trans.lang.index)
* http://your-domain.com/admin/translation/base-translation/list    (Route: admin.trans.base.index)
* http://your-domain.com/admin/translation/modules-translation/list (Route: admin.trans.module.index)    
```

# Usage

:)

## Blade 

you can use it in your blade:

```
translation($text,$lang,$where)
```
* $lang and $where are optional. ( Default $lang set base your locale project )
* $where can be one of the 'file' or 'db' ( Default is 'file')
 
 Get translation from Database with key in English language:
```
translation('welcome','en','db')
```

search 'welcome' key in 'file' language.  
```
translation('welcome')
```

search 'welcome' in Database and display it, but if could not find
  it just call this method **translation('welcome')**
```
translation('welcome',null,'db')
```
It is important if you have html tag in your translation value when inserting in Database 
you should be use **{!! !!}** like this:

```
{!! translation('welcome','en','db') !!}
```

## Controller 

first you should use **TransHelper** in you controller.

```
use Mekaeil\LaravelTranslation\TransHelper\TransHelper;
```

#### Languages

Get all of the languages
``` 
$this->allLangs();
```
Get **Default** language
``` 
$this->defaultLang();
```

#### Base Translation Words

Get all of the words in database :
``` 
 $this->baseWords();
```
Get English words ( paginate : 15 )
 ``` 
  $this->baseWords(null ,'en' , 15);
 ```
Get welcome word in Persian language
 ``` 
  $this->baseWords('welcome' ,'fa');
 ```
Get welcome word base current local 
 ``` 
  $this->baseWords('welcome');
 ```


# Overwrite **trans()** method
    
if you used trans() or __() methods in your blade and want to overwrite this method
you can follow this step:

* (1) Require the plugin  

```
composer require funkjedi/composer-include-files:dev-master
```

* (2) Update your project's composer.json file, adding your helper file to "include_files".

```
// composer.json (project)
"autoload": {
    "files": [
        "app/Http/Helpers.php"
    ],
    "psr-4": {
        "App\\": "app/"
    }
}
```

* (3) Add trans() method in helpers.php file:
```
use Mekaeil\LaravelTranslation\TransHelper;


class Trans{
    use TransHelper;

    public function translator($word,$lang,$where){
        return $this->translation($word,$lang,$where);
    }
}

if (!function_exists('trans')){

    function trans($word, $lang=null, $where=null){
        $accessTrans = new Trans();
        return $accessTrans->translator($word,$lang,$where);
    }  
}

```
