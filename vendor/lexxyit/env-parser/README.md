`.env` file is used very often in projects. Especially when it comes to some kind of powerful framework. It would be very convenient to add variables from the `.env` file, for example, directly to the `$_ENV` array and use them from there. `EnvParser` is a very simple and fast class for adding some settings to global variables. `EnvParser` has no external dependencies, which guarantees that it is simplicity and fast. It's installation is very simple.

> **Note:** The minimum required `PHP` version is `7.4`

1. Install package:
```shell
composer require lexxyit/env-parser:dev-master
```

2. Create environment file `.env` at the root directory of your project:

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_USER=user
DB_PASSWORD=password
```

3. Now, let's try to use package. We need to call it's public `load()` method. This method needs only one `string ` parameter with path to your `.env` file. In my case I include it before the code with connecting to database. It can be done in several ways.

- Create extra variable to instantiate the `EnvParser` class and then use the `load()` method:

    ```php
    $envParser = new LeXxyIT\EnvParser\EnvParser();
    $envParser->load(__DIR__ . '/.env');

    // ... database connection ...
    ```

- Create an instance of the `EnvParser` class with a short notation to use quickly the `load()` method:

    ```php
    (new LeXxyIT\EnvParser\EnvParser())->load(__DIR__ . '/.env');

    // ... database connection ...
    ```

- Use `load()` as a static method:

    ```php
    LeXxyIT\EnvParser\EnvParser::load(__DIR__ . '/../_Packagist/EnvParser/.env');

    // ... database connection ...
    ```

As a result, the variables will be added to the global environment and you will be able to use it in your code. Now, you can check it:

```php
print_r($_ENV);
```

Result:

```
Array
(
    [DB_HOST] => 127.0.0.1
    [DB_PORT] => 3306
    [DB_USER] => user
    [DB_PASSWORD] => password
)
```

Enjoy it!
