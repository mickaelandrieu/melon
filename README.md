# Melon

Melon is a module for PrestaShop who intent to speed up the generation of grids in 1.7.8.

## Installation

Get the Zip archive or clone this repository.
Then use Composer to install the dependencies.
Finally, use the console or the back office to install the module.

### Easier creation of moderns grids

```php
// in a modern Controller
<?php

use \Book; // in my-module/classes/Book.php which is an Object Model on in classes root folder


class BookController extends FrameworkBundleAdminController
{
    public function indexAction(SearchCriteria $searchCriteria = null)
    {
        $searchCriteria = new SearchCriteria(); // this is not managed "yet"
        $grid = $this->get('fop.melon.grid_object_model.factory')
            ->setObjectModelClass(Book::class)
            ->setFields(['name', 'description']) // If not defined, will use all fields
            ->getGrid($searchCriteria)
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

# no need to create your own services and or classes <3
# rely on hooks if you need to alter the generated Grid
```

> Look at docs folder for a complete exemple of a module.

#### Constraints

* Doesn't support Search yet (WIP)
* Should enable CRUD actions by default without any generation of code (WIP)

#### Gains

* Average time to create a complete Grid from an Object Model: 1 or 2 days (depending on how good you are with the 1.7 modern stuff)
* Average time with my feature: how many minutes do you need to copy paste and adapt my example ? 👍 

### Notes

This module is licensed under MIT license.
