<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Themsaid\Multilingual\Tests\Models\Planet;
use Themsaid\Multilingual\Tests\Models\UntranslatablePlanet;

class TranslationsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *
     * @return void
     */
    public function test_model_attr_with_no_translatables_return_original_value()
    {
        $planet = UntranslatablePlanet::create([
            'name' => 'Mercury'
        ]);

        $this->assertEquals('Mercury', $planet->name);
    }

    public function test_translatable_attribute_casted_as_NOT_ARRAY_is_saved_as_json_still()
    {
        $planet = Planet::create([
            'order' => [
                'en' => 'One',
                'sp' => 'Uno'
            ]
        ]);

        $this->assertJson($planet->getOriginal('order'));
    }

    public function test_translatable_attribute_return_value_of_current_locale()
    {
        $planet = Planet::create([
            'name' => [
                'en' => 'Mercury',
                'sp' => 'Mercurio'
            ]
        ]);

        config(['app.locale' => 'sp']);

        $this->assertEquals('Mercurio', $planet->name);
    }

    public function test_translatable_attribute_return_empty_string_if_no_translations()
    {
        $planet = Planet::create();

        config(['app.locale' => 'en']);

        $this->assertEquals('', $planet->name);
    }

    public function test_translatable_attribute_return_default_value_if_current_locale_not_exist()
    {
        $planet = Planet::create([
            'name' => [
                'en' => 'Mercury',
                'sp' => 'Mercurio'
            ]
        ]);

        config(['multilingual.fallback_locale' => 'sp']);
        config(['app.locale' => 'ar']);

        $this->assertEquals('Mercurio', $planet->name);
    }

    public function test_translatable_attribute_return_default_value_if_current_locale_empty()
    {
        $planet = Planet::create([
            'name' => [
                'en' => '',
                'sp' => 'Mercurio'
            ]
        ]);

        config(['multilingual.fallback_locale' => 'sp']);
        config(['app.locale' => 'en']);

        $this->assertEquals('Mercurio', $planet->name);
    }

    public function test_returning_array_of_all_translations()
    {
        $planetName = [
            'en' => 'Mercury',
            'sp' => 'Mercurio'
        ];

        $planet = Planet::create([
            'name' => $planetName
        ]);

        config(['app.locale' => 'en']);

        $this->assertEquals($planetName, $planet->nameTranslations->toArray());
    }

    public function test_returning_the_value_of_specific_locale()
    {
        $planetName = [
            'en' => 'Mercury',
            'sp' => 'Mercurio'
        ];

        $planet = Planet::create([
            'name' => $planetName
        ]);

        config(['app.locale' => 'en']);

        $this->assertEquals('Mercurio', $planet->nameTranslations->sp);
    }

    public function test_returning_empty_string_if_NO_value_of_specific_locale()
    {
        $planetName = [
            'en' => 'Mercury',
            'sp' => ''
        ];

        $planet = Planet::create([
            'name' => $planetName
        ]);

        config(['app.locale' => 'en']);

        $this->assertEquals('', $planet->nameTranslations->sp);
    }

    public function test_returning_empty_string_if_value_not_array()
    {
        $planetId = Planet::insertGetId([
            'name' => 'Earth'
        ]);

        $planet = Planet::find($planetId);

        config(['app.locale' => 'en']);

        $this->assertEquals('', $planet->name);
    }

    public function test_returning_empty_string_for_a_specific_locale_if_value_not_array()
    {
        $planetId = Planet::insertGetId([
            'name' => 'Earth'
        ]);

        $planet = Planet::find($planetId);

        config(['app.locale' => 'en']);

        $this->assertEquals('', $planet->nameTranslations->sp);
    }

}
