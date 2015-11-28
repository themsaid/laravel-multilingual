# Laravel 5 Multilingual Models

This laravel package makes Eloquent Models attributes translatable without the need to separate database tables for translation values.

You simply call `$country->name` and you get a value based on your application's current locale.

You can also call `$country->nameTranslations->en` to get the value of a specific locale.

You can check all the translations of a given attributes as easy as `$country->nameTranslations->toArray()`.

## Installation

Begin by installing the package through Composer. Run the following command in your terminal:

```
composer require themsaid/laravel-multilingual:dev-master
```

Once composer is done, add the package service provider in the providers array in `config/app.php`

```
Themsaid\Multilingual\MultilingualServiceProvider::class
```

Finally publish the config file:

```
php artisan vendor:publish
```

That's all, you are now good to go.

# Usage

First you need to make sure that the translatable attributes has a mysql field type of TEXT, if you are building the database from a migration file you may do this:

```php
<?php

Schema::create('countries', function (Blueprint $table)
{
	$table->increments('id');
	$table->json('name');
});
```

Now that you have the database ready to save a JSON string, you need to prepare your models:

```php
<?php

class Country extends Model
{
    use Themsaid\Multilingual\Translatable;

    protected $table = 'countries';
    public $translatable = ['name'];
}
```

- Add the `Translatable` trait to your model class
- Add a public class property `$translatable` as an array that holds the names of the translatable fields in your model.

Now our model has the `name` attribute translatable, so on creating a new Model you may specify the name field as follow:

```php
<?php

Country::create([
	'name' => [
		'en' => "Spain",
		'sp' => 'España'
	]
]);
```

It'll be automatically converted to a JSON string and saved in the name field of the database, you can later retrieve the name like this:

```
$country->name
```

This will return the country name based on the current locale, if the current locale doesn't have a value then the `fallback_locale` defined in the config file will be used.

In case nothing can be found an empty string will be returned.

You may also want to return the value for a specific locale, you can do that using the following syntax:

```
$country->nameTranslations->en
```

This will return the English name of the country.

To return an array of all the available translations you may use:

```
$country->nameTranslations->toArray()
```

# Validation
A validation rule is included in this package that deals with required translation fields, for example if the name field is required and translatable you may use the following translation rule:

```php
<?php

$validator = Validator::make(
    ['name' => ['en'=>'One', 'sp'=>'Uno']],
    ['name' => 'translatable_required']
);
```

The `translatable_required` rule will make sure all the values of the available locales are set.

You may define the available locales as well as the fallback_locale from the package config file.

Now you only need to add the translated message of our new validation rule, add this to the `validation.php` translation file:

```
'translatable_required' => 'The :attribute translations must be provided.',
``` 
