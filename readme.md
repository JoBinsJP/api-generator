# API Generator

Generator api docs while writing test case

### Installation

```shell
composer require jobins/api-generator --dev
```

### Publish  assets

```shell
php artisan vendor:publish --provider="Jobins\APIGenerator\APIGeneratorServiceProvider"
```

### Basic Uses

```php
<?php

namespace Tests\Feature;

use App\Http\Requests\RegistrationRequest::class;

class RegistrationTest extends TestCase{
    
    /** @test */
    public function it_register_a_new_user()
    {
        $this->setSummary("Register a new user.")
            ->setId("Register")
            ->setSecurity(Security::BEARER)
            ->setRulesFromFormRequest(RegistrationRequest::class)
            ->jsond("post", route("registration.store"), $data)
            ->assertStatus(422)
            ->assertJsonFragment([])
            ->assertJsonStructure(["message"])
            ->defineResponseScheme([
                "data.*"=>["description"=>"User Collection", "schemeId"=>"User", "type"=>"array"],
                "data"=>["name"=>"User","type"=>"Object", "properties"=>[
                    "name"=>"First name of the user",
                    "lastname"=>"Last name of the user"
                ]],
                "message"=>["description"=>"Message for user", "type"=>"string"]
            ])->generate($this, true);    
    }
}
```

### Define parameters in descriptions method of FormRequest class.

```php

/**
 * Class ExampleFormRequest
 * @package Jobins\APIGenerator\Tests\Stubs
 */
class ExampleFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            "email"     => "required", // Required, String, 
            "nickname"  => "sometimes|required", // Optional Field, String
        ];
    }

    public function descriptions()
    {
        return [
            "email"     => "Email of a new user.",
            "nickname"  => "Nick name of a new user."
        ];
    }
}
```
