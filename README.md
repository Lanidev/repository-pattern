# Lanidev / repository-pattern
Laravel package with improvement to framework by using repository pattern. This package will provides you some new command to generate code and the repository pattern will make your applications easier to maintain.

## Installation

Run the following command from your terminal:

 ```bash
 composer require lanidev/repository-pattern
 ```

## Configuration

Run the following command from your terminal:

 ```bash
 php artisan vendor:publish --provider="Lanidev\Pattern\Providers\ConfigServiceProvider"
 ```

This will generate a file : ```config/pattern.php```

In this file you can modify the namespace of models and repositories for the file generator

```php
return [
    'namespaces'  => [
        'models'       => 'App',
        'repositories' => 'App\Repositories'
    ]
];
```

## Console usage

This package provides an updated version of the command ```php artisan make:model``` with a new option : ```--repository```

#### Recommended way

Run the following command from your terminal

```bash
php artisan make:model Page --repository
```

This will generate a classic model in the folder with the namespace choosen in the config file

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
}

```

By using ```--repository``` option you will generate a repository for the given model :

```php
<?php

namespace App\Repositories;

use Lanidev\Pattern\Repositories\EloquentRepository as Repository;

class PageRepository extends Repository
{
    /**
     * The repository models
     *
     * @var string
     */
    protected $model = 'Page';
}

```

The ```$model``` variable is telling to the package what model will be manage by the generated repository

Note: No need to specify the namespace for the model because it will be automatically detected.

#### Alternative way

Some people like to use the reverse logic for example when the model already exist

So the package allows you to do it.

Run the following command from your terminal:

```bash
php artisan make:repository PageRepository --model=Page
```

This will generate the same repository file as the one shown previously. In this case the option ```--model=``` is used to specify the ```$model``` variable.

If you don't specify this option it will genrate the repository file with an empty ```$model```variable so you'll need to fill it manually.

If you specify a model who is not placed at the namespace chosen in the config file the terminal will ask you to create it.


## Repository usage

For this example:

You can create a controller and use the repository as dependency injection

```php
<?php

namespace App\Http\Controllers;

use App\Repositories\PageRepository as Page;

class PageController extends Controller {

    private $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function index()
    {
      // your code
    }
}
```

## Available Methods

The following BREAD methods are available:

##### Lanidev\Pattern\Contracts\RepositoryInterface

```php
public function browse($columns = array('*'))
public function read($field, $value, $columns = array('*'))
public function add(array $data)
public function edit(array $data, $id)
public function delete($id)
public function paginate($perPage = 15, $columns = array('*'));

```

### Example usage

Index all the pages:
```php
$this->page->browse();
```

Create a new page:

```php
$this->page->add(Input::all());
```

Update existing page:

```php
$this->page->edit(Input::all(), $id);
```

Delete page:

```php
$this->page->delete($id);
```

Get a single row by a single column criteria.

```php
$this->page->read('title', $title);
```

#### Note : For the browse, read and paginate method you can specify the columns to fetch by passing an array in parameters
