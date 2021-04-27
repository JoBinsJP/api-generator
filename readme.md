# API Generator

Generate api docs while writing test case (Laravel). 

### Idea
It generates api docs with [OpenAPI Specification](https://swagger.io/specification) while wiring test case in 
laravel application. The generated docs can preview on swagger ui either integrate laravel-swagger-ui on application 
or [Swagger Editor online](https://editor.swagger.io/).

##### Features
* All basic setup features as available in swagger api.
* Request body will define using Laravel FormRequest class.
* The Request body example will grab from test data that used on testing.
* Route parameters will define from Laravel route.
* Response example grabs from the test responses.


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
        $responseSchema = [
            "description" => "A User Object",
            "define"      => [
                "data.*"  => ["refSchema" => "UserSchema"],
                "message" => "Message for user",
            ],
        ];
        
        $this->setSummary("Register a new user.")
            ->setId("Register")
            ->setSecurity([Security::BEARER])
            ->setTags(["Posts"])
            ->setRulesFromFormRequest(RegistrationRequest::class)
            ->jsond("post", route("registration.store"), $data)
            ->assertStatus(422)
            ->assertJsonFragment([])
            ->assertJsonStructure(["message"])
            ->defineResponseSchema($responseSchema)
            ->generate($this, true);    
    }
}
```

### Define parameters in descriptions method of FormRequest class.

```php

/**
 * Class ExampleFormRequest
 * @package JoBins\APIGenerator\Tests\Stubs
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
