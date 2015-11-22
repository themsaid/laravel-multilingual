<?php

use Illuminate\Support\Facades\Validator;
use Themsaid\Multilingual\Tests\Models\Planet;

class ValidationTest extends TestCase
{
    public function test_validation_fails_if_required_but_not_provided()
    {
        config(['multilingual.locales' => ['en','sp']]);

        $validator = Validator::make(
            ['name' => ''],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_but_empty_array()
    {
        config(['multilingual.locales' => ['en','sp']]);

        $validator = Validator::make(
            ['name' => []],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_but_string()
    {
        config(['multilingual.locales' => ['en','sp']]);

        $validator = Validator::make(
            ['name' => 'This is not cool'],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_and_has_correct_keys_but_empty_values()
    {
        config(['multilingual.locales' => ['en','sp']]);

        $validator = Validator::make(
            ['name' => ['en' => '']],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_and_has_missing_translations()
    {
        config(['multilingual.locales' => ['en','sp']]);

        $validator = Validator::make(
            ['name' => ['en' => 'One']],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_and_has_empty_translations()
    {
        config(['multilingual.locales' => ['en','sp']]);

        $validator = Validator::make(
            ['name' => ['en' => 'One', 'sp' => '']],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_succeed_if_required_and_OK()
    {
        config(['multilingual.locales' => ['en','sp']]);

        $validator = Validator::make(
            ['name' => ['en' => 'One', 'sp' => 'Uno']],
            ['name' => 'translatable_required']
        );

        $this->assertFalse($validator->messages()->has('name'));
    }
}
