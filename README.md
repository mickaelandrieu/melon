# Melon

Melon is a module for PrestaShop who intent to speed up the generation of grids in 1.7.8.

## Installation

Get the Zip archive or clone this repository.
Then use Composer to install the dependencies.
Finally, use the console or the back office to install the module.

> This module is compatible with PHP 7.4 and 8.0.

### Easier creation of moderns grids

```php
<?php

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteria;
use DummyObjectModel;

class AppController extends FrameworkBundleAdminController
{
    public function indexAction()
    {
        $grid = $this->get('fop.melon.grid_object_model.factory')
            ->setObjectModelClass(DummyObjectModel::class)
            ->setFields(['name', 'description']) // If not defined, it will use all the fields
            ->getGrid(new SearchCriteria()) // This is not managed "yet"
        ;

        return $this->render('@Modules/melon/views/grid.html.twig', [
            'title' => 'Grid title',
            'grid' => $this->presentGrid($grid),
        ]);
    }
}
```

```yaml
# config/services.yml
services:

# No need to create your own services or classes <3
# You must rely on hooks if you need to alter the generated Grid (See PrestaShop devdocs)
# Create this file is not required
```

```yaml
# config/routes.yml
your_route_name:
  path: whatever
  methods: [GET]
  defaults:
    # of course, the path to the controller needs to be adapted
    _controller: 'FOP\Test\Controller\AppController::indexAction'
```

> Look at docs folder for a complete example of a module.

#### Constraints

* Doesn't support Search yet (WIP)
* Should enable CRUD actions by default without any generation of code (WIP)

#### Gains

* Average time to create a complete Grid from an Object Model: Days (depending on how good you are with the 1.7 modern stuff)
* Average time using Melon: How many minutes do you need to copy/paste and adapt the provided example ? 👍 

### Notes

This module is licensed under MIT license.
