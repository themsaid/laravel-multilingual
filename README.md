# Laravel 5 Multilingual Models

This laravel package makes Eloquent Models attributes translatable without the need to separate database tables for translation values.

You simply call `$country->name` and you get a value based on your application's current locale.

You can also call `$country->nameTranslations->en` to get the value of a specific locale.

You can check all the translations of a given attributes as easy as `$country->nameTranslations->toArray()`.

## Installation

Begin by installing the package through Composer. Run the following command in your terminal:

```
composer require themsaid/laravel-multilingual
```

Once composer is done, add the package service provider in the providers array in `config/app.php`

```
Themsaid\Multilingual\MultilingualServiceProvider::class
```

That's all, you are now good to go.

# Usage

First you need to make sure that the translatable attributes has a mysql field type of TEXT, if you are building the database from a migration file you may do this:

```
Schema::create('countries', function (Blueprint $table)
{
	$table->increments('id');
	$table->json('name');
});
```

Now that you have the database ready to save a JSON string, you need to prepare your models:

```
class Country extends Model
{
    use Themsaid\Multilingual\Translatable;

    protected $table = 'countries';
    public $translatable = ['name'];
}
```

- Add the `Translatable` trait to your model class
- Add a public class property `$translatable` as an array that holds the names of the translatable fields in your model.

