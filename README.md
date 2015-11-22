# Laravel 5 Multilingual Models

This laravel package makes Eloquent Models attributes translatable without the need to separate database tables for translation values.

You simply call `$country->name` and you get a value based on your application's current locale.

You can also call `$country->nameTranslations->en` to get the value of a specific locale.

You can check all the translations of a given attributes as easy as `$country->nameTranslations->toArray()`.

## Installation and Usage

### Step 3: Setup your models

To preoare your mo