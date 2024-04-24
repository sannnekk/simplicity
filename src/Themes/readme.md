# Themes directory

This directory contains all the theme files. It is the root directory of
the your theme

It should contain at least 3 files:

- `header.template.php` - The gobal header, which will be included in
  every page.
- `footer.template.php` - The gobal footer, which will be included in
  every page.
- `index.template.php` - The main page template.

And the views directory.

You can add more files if you need to, but you have to include them
manually in the page where you want to use them.

The whole structure looks like this (feel free to extend it):

```
 | - src
     | - Theme
         | - <your theme name in camelcase>
             | - Assertions
             | - Injectors
             | - Components
             | - Views *
             | - Settings
             | - assets
             | - index.template.php *
             | - header.template.php *
             | - footer.template.php *
```

[*] - Required

## Components

Simplicity uses template components to make the code more modular.
Components are reusable parts of the template. They can be included in
any template file. You can add them in the `components` directory. You
can also create subdirectories, those must be treated as namespaces.
Those will be included in every template file. Every component should be
a PHP file with a class inside, that implements the
`Simplicity/Core/Template/Component` interface. The method `render`
should return the HTML content of the component.

Example:

```php
// src/Template/components/MyComponent.php
<?php declare(strict_types=1);

namespace Simplicity\Template\Components;

use Simplicity\Core\Template\Component;

class MyComponent implements Component
{
    public function render(Context $context): string
    {
        return '<div>My component</div>';
    }
}
```

```php
// src/Template/index.template.php

// Using the component
<?php declare(strict_types=1);

$myComponent = new Simplicity\Template\Components\MyComponent();

?>

// somewhere in the template
<div class="my-component">
    <?= $myComponent->render($context); ?>
</div>
```

## Views

The views directory contains the template files that will be rendered to
the user. The name and path of the view file schould be the same as the
name of the route, example:

```
 | - src
     | - Theme
         | - <your theme name in camelcase>
             | - Views
                 | - home.template.php
                 | - gallery.template.php
                     | - [section].template.php
                 | - about.template.php
                 | - contact.template.php
```

#### File naming convention:

- The file name should be the same as the route name.
- Only the whole filename could be a parameter, in this case the file
  name should be in square brackets. Example: `[id].template.php`
  (post-[id].template.php WON'T WORK!). The parameter will be accessible
  in the context array.
- The file case will be ignored, so `home.template.php` and
  `Home.template.php` will be the same directory.
- The file extension should be `.template.php`.
- The file should be in the `Views` directory.
- The file named `index.template.php` will be the default template for
  the route.

Example:

```
 | - src
     | - Theme
         | - <your theme name in camelcase>
             | - Views
                 | - post
                     | - index.template.php
                     | - [id].template.php
```

## Context

The template files will have access to the `$context` variable, which is
an instance of `Simplicity\Core\Template\Context\TemplateContext`. This
class contains the data that will be passed to the template files. You
can add more data to the context using `Injector` objects.

The `Context` class has a `dump` method that will show all the data and
methods available in the context. This is useful for debugging.

## Assertions

Asserts are classes that can make checks on the context. They should
implement the `Simplicity\Core\Template\Assertion` interface. The method
`assert` should NOT modify the context, have to return void and throw an
exception if the assertion fails. The exception schould extend the
`Simplicity\Core\Template\AssertionFailedException` class. Otherwise,
the exception details will be lost. The exception message and code will
be displayed in the error page.

NOTE: Add assertions to the context before rendering the template.

Example:

```php
// src/Template/Assertions/MyAssertion.php
<?php declare(strict_types=1);

namespace Simplicity\Template\Assertions;

use Simplicity\Core\Template\Assertion;

class MyAssertion implements Assertion
{
    public function assert(array $context): void
    {
        if (!isset($context['my_key'])) {
            throw new Simplicity\Core\Template\AssertionFailedException(
                'The key "my_key" is not set in the context',
                400
            );
        }
    }
}
```

Usage in a template:

```php
// src/Template/index.template.php
<?php declare(strict_types=1);

$context->addAssertion(new Simplicity\Template\Assertions\MyAssertion());

?>
```

NOTE: The assertions will be executed in the order they were added to
the context.

## Injectors

Injectors are classes that can add data to the context. They should
implement the `Simplicity\Core\Template\Injector` interface. The method
`inject` should add data to the context, it will be incoked
automatically. The Data can be obtained from Services, Repositories or

Example:

```php
// src/Template/Injectors/MyInjector.php
<?php declare(strict_types=1);

namespace Simplicity\Template\Injectors;

use Simplicity\Core\Template\Injector;
use Simplicity\Core\Template\TemplateContext;

class MyInjector implements Injector
{
    private readonly ExampleService $exampleService;

    // The service will be injected automatically
    public function __construct(ExampleService $exampleService)
    {
        $this->exampleService = $exampleService;
    }

    public function inject(TemplateContext $context): void
    {
        $someData = $this->exampleService->getData();
        $context->extensions->add('my_key', $someData);
    }
}
```

Usage in a template:

```php
// src/Template/index.template.php
<?php declare(strict_types=1);

$context->addInjector(new Simplicity\Template\Injectors\MyInjector());

?>

// The data will be available in the context
<?= $context->extensions->get('my_key'); ?>
```
