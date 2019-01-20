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
before migration you should take a look the config file.
* define your users table, user model and user id 
* if you want to change the translation's table name you can change it.
* add or edit middleware routes.

**it is important to add <span style="background:#95a5a6;color:#000;padding:0 2px;display:inline;">lang_id</span> in your fillable columns in user model.**
    
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
```
_trans($text,$lang,$where)
```
* $lang and $where are optional. ( Default $lang set base your locale project )
* $where can be one of the 'file' or 'db' ( Default is 'file')
 
 Get translation from Database with key in English language:
```
translation('welcome','en','db')
```
```
_trans('welcome','en','db')
```

search 'welcome' key in 'file' language.  
```
translation('welcome')
```
```
_trans('welcome')
```

search 'welcome' in Database and display it, but if could not find
  it just call this method **translation('welcome')**
```
translation('welcome',null,'db')
```
```
_trans('welcome',null,'db')
```

It is important if you have html tag in your translation value when inserting in Database 
you should be use **{!! !!}** like this:

```
{!! translation('welcome','en','db') !!}
```
```
{!! _trans('welcome','en','db') !!}
```

<br>
<br>

```
{{ getLocale() }}
```

Language locale and Direction saving in cookie or session,
but if you want to getLocale you can use this method in your blade.

* first argument : $user [ if you want to get user local ]
* second argument : [ lang , dir ] if you don't set anything return language data with json format.
``` 
{{ getLocale(null,'lang') }} // output : en
```
Get direction 
``` 
{{ getLocale(null,'dir') }} // output : ltr
```
Get User Locale
``` 
{{ getLocale(\Auth::user()) }}
/// output:
{
    "id": 1,
    "name": "en",
    "display_name": "English",
    "status": 1,
    "default": 0,
    "created_at": "2019-01-03 08:40:32",
    "updated_at": "2019-01-17 11:00:50",
    "direction": "ltr"
}
```
And an other way to get user locale
```
{{ getLocale() }}

/// output :
{
    "id": 1,
    "name": "en",
    "display_name": "English",
    "status": 1,
    "default": 0,
    "created_at": "2019-01-03 08:40:32",
    "updated_at": "2019-01-17 11:00:50",
    "direction": "ltr"
}
```
**IMPORTANT**
<br>

if you want to use **getLocale()** don't pass any 
argument because if the user logged in his/her account return user's language 
otherwise returns the default language in your project. 




#### Create your own helper function in Blade theme

You can define your helper function for translate words in your blade theme.
use this in top of the file :
``` 
use Mekaeil\LaravelTranslation\Repository\Facade\Translation;
```
add this function in your **helper** file.
```
if (!function_exists('YOUR_FUNCTION_NAME'))
{

    /**
     * @param $word
     * @param null $lang
     * @param string $where
     * @return mixed
     */
    function YOUR_FUNCTION_NAME($word, $lang=null, $where='file')
    {
        return Translation::translation($word,$lang,$where);
    }

}
```
<br>
<br>

## Controller 

first you should use **TransHelper** in you controller.

```
use Mekaeil\LaravelTranslation\Repository\Facade\Translation;
```

#### Languages

Get all of the languages
``` 
Translation::allLangs();
```
Get **Default** language in the project.
``` 
Translation::defaultLang();
```

Get User Default Language, if the user selected language in the self-account, otherwise returns default language in the system.
```
$user = Auth::user();
return Translation::defaultLang($user->id);
```

#### Base Translation Words

Get all of the words in database :
``` 
Translation::baseWords();
```
Get English words ( paginate : 15 )
 ``` 
Translation::baseWords(null ,'en' , 15);
 ```
Get welcome word in Persian language
 ``` 
Translation::baseWords('welcome' ,'fa');
 ```
Get welcome word base current local 
 ``` 
Translation::baseWords('welcome');
 ```
 
Set User Language:
* $userID   : User id (int)
* $langID   : Language id (int) (default: null)
* $langWith : cookie or session, (string) (default:cookie)
```
Translation::setUserLocale($userID, $langID, $langWith)
```
Setting the user's language with id: 27 to the language that user selected before!
```
Translation::setUserLocale(27)
```
Set the user's language with id:27 to the language with id:3
```
Translation::setUserLocale(27,3)
```
Set the user's language with id:27 to the language with id:3 and use session for user
```
Translation::setUserLocale(27,3,'session')
```

#### Clear Cache
It's important before anything set config file, in laravel-translation config file you 
can set type of save user data in browser on **Cookie** or **Session**.

Clear Cache An Item In Session
``` 
Translation::clearCache('language','session');
```

Clear Cache An Array In Session
``` 
Translation::clearCache(['language','direction'],'session');
```
<br>

**If you set the storage save data, it doesn't need to pass second argument.** 
<br>

Clear Cache An Item
``` 
Translation::clearCache('language');
```
Clear Cache An Array
``` 
Translation::clearCache(['language','direction']);
```
Clear all of the **SESSION** exists in user's browser
``` 
Translation::clearCache('all','session');
```

#### ASSETS
Ger Assets function
* $where : default = front-end [ front-end, back-end]
* $type  : default = null [link_style,styleـcustom,link_script,scriptـcustom]
* $lang    : default = null, use default locale [en,fa]
``` 
Translation::getAssets($where, $type, $lang)
```

Get all of the assets added for Front-End
``` 
Translation::getAssets($where='front-end')
```

##### GET ASSET DEFINED IN COOKIE
Get and save style defined for language in blade
``` 
    @php
        setAssets();
        $asset =\Cookie::get('assets');
        $asset =json_decode($asset);
    @endphp

    @if($asset)
        ///// create style and script tags
        {!! $asset->link_style ?? '' !!}
        {!! $asset->link_script ?? '' !!}
    @endif
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
