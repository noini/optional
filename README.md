# Optional

Optional is multipurpose tool to reduce if-null checking in PHP code.

## Installation

Install via composer
    
    composer require noini/optional
    
## Usage

### Static create

    Optional::create($payload)->then(...);

### Function

With OptionalFunction.php you can define easy to use helper method

    optional($payload)->then(...);

### Simple example

Following example will run callable because $content value is not null. 

    $payload = "content string";
    $optional = new Optional($payload);
    $optional->then(function($data) {
        echo "Had content: " . $data;
    })->otherwise(function($data) {
        echo "I had null value";
    });
    
### has()

With has() method you can check if Optional payload meets requirement(s). 

**Null payload**

If Optional payload is null, then has() will fail and create false result.

    optional(null)->has(1)->getResult(); // false
    
Null value can be checked with type if needed

    optional(null)->has(Types::NULL)->getResult(); // true

**Using strict equals comparison**

Compares payload to has() parameter.

    optional(50)->has(50)->getResult(); // true
    optional("50")->has(50)->getResult(); // false
    
**Using type check**

With Types class constants you can check if payload data type meets requirement.

    optional("50")->has(Types::INTEGER)->getResult(); // false
    optional("50")->has(Types::STRING)->getResult(); // true

**Class checking**

Passing class you can check if payload is instance of given class.

    optional(new \stdClass())->has(\stdClass::class)->getResult(); // true;

**Using callback** 

With callback you can customize payload checking. Callback must return boolean.

    optional(50)->has(function($data) {
        return $data > 10;
    })->then(function($data) {
        echo "Value is over 10";
    });
    
### then()

You can directly call callback function if new instance of Optional has non null value:

    optional(1)->then(function($data) {
        echo "I had non null value: " . $data;
    });
    
Chained with has() then() will call callable only if latest has() comparison was successful.

    optional(50)
        ->has(Types::INTEGER)
        ->then(function($data) {
            echo "Data is a integer";
        });
    
### otherwise()

Otherwise callback will be called if latest has comparison fails.

    optional(50)
        ->has(function($data) {
            return $data > 9000;
        })->otherwise(function($data) {
            echo "Data was not over 9000";
        });
    
### if-else

You can skip has-then method chaining with if() -method. With if() you can define both condition and callback function with one method:

    optional("data")->if(Types::STRING, function($data) {
        echo "I had a string value: " . $data;
    });

You can use else() method chained with if

    optional(null)
        ->if(Types::STRING, function($data) {
            echo "I should not be called this time";
        })
        ->else(function($data) {
            echo "This means optional payload was not a string";
        });
    
**Notice** that you cannot use has-then after you use if.


