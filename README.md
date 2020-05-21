# Melon

Melon is a module for Presta with one main purpose: get the features, improvements
and bug fixes refused or ignored by the Core team.

Obviously, installing this addon will provide you a better version of PrestaS***.

## Installation

Get the Zip archive or clone this repository.
Then use Composer to install setup the Composer autoloader and install the dependencies.

## Provided features

- Easier creation of moderns grids;
- ...

### Easier creation of moderns grids

```php
// in a modern Controller
<?php

use \Book; // in my-module/classes/Book.php which is an Object Model 


class BookController extends FrameworkBundleAdminController
{
    // liste des livres
    public function indexAction(SearchCriteria $searchCriteria = null)
    {
        $searchCriteria = new SearchCriteria(); // this is not managed "yet"
        $grid = $this->get('fop.console.grid_object_model.factory')
            ->setObjectModelClass(Book::class)
            ->getGrid($searchCriteria)
        ;

        return $this->render('@Modules/test/views/books/index.html.twig', [
            'grid' => $this->presentGrid($grid),
        ]);
    }
}
```

```yaml
# config/services.yml
services:

# no need to create your own services and or classes <3
# rely on hooks if you need to alter the generated Grid
```

```html
{# views/books/index.html.twig #}
{% extends '@PrestaShop/Admin/layout.html.twig' %}

{% block content %}
    <h1>Mes livres</h1>
   
    {% include '@PrestaShop/Admin/Common/Grid/grid_panel.html.twig' with {'grid': grid} %}
{% endblock %}
```

#### Constraints

* Only works for Object models which are located inside modules imho (WIP)
* Doesn't support the Javascript extensions (WIP)

#### Gains

* Average time to create a complete Grid from an Object Model: 1 or 2 days (depending on how good you are with the 1.7 modern stuff)
* Average time with my feature: how many minutes do you need to copy paste and adapt my example ? 👍 

### Notes

This module is licensed under GNU GPL v2.
