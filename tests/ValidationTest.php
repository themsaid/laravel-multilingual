<?php

use Illuminate\Support\Facades\Validator;

class ValidationTest extends TestCase
{
    public function test_validation_fails_if_required_but_not_provided()
    {
        $validator = Validator::make(
            ['name' => ''],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_but_empty_array()
    {
        $validator = Validator::make(
            ['name' => []],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_but_string()
    {
        $validator = Validator::make(
            ['name' => 'This is not cool'],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_and_has_correct_keys_but_empty_values()
    {
        $validator = Validator::make(
            ['name' => ['en' => '']],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_and_has_missing_translations()
    {
        $validator = Validator::make(
            ['name' => ['en' => 'One']],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_fails_if_required_and_has_empty_translations()
    {
        $validator = Validator::make(
            ['name' => ['en' => 'One', 'sp' => '']],
            ['name' => 'translatable_required']
        );

        $this->assertTrue($validator->messages()->has('name'));
    }

    public function test_validation_succeed_if_required_and_OK()
    {
        $validator = Validator::make(
            ['name' => ['en' => 'One', 'sp' => 'Uno']],
            ['name' => 'translatable_required']
        );

        $this->assertFalse($validator->messages()->has('name'));
    }

    public function test_only_specific_locales_required()
    {
        $validator = Validator::make(
            ['name' => ['en' => 'One', 'sp' => 'Uno']],
            ['name.en' => 'required']
        );
        $this->assertTrue($validator->passes());

        $validator = Validator::make(
            ['name' => ['sp' => 'Uno']],
            ['name.en' => 'required']
        );
        $this->assertFalse($validator->passes());
    }
}
