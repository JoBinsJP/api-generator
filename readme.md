# API Generator
Generator api docs while writing test case

### Installation
```shell
composer require jobins/api-generator --dev
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
            ->setRulesFromFormRequest(RegistrationRequest::class)
            ->jsond("post", route("registration.store"), $data)
            ->assertStatus(422)
            ->assertJsonFragment([])
            ->assertJsonStructure(["message"])
            ->generate($this, true);    
    }
}
```
