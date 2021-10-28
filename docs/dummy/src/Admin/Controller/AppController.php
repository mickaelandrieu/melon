<?php

namespace FOP\Dummy\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;

use DummyModel;

class AppController extends FrameworkBundleAdminController
{
    public function gridAction(SearchCriteria $searchCriteria = null) : Response
    {
        $searchCriteria = new SearchCriteria();
        $grid = $this->get('fop.melon.grid_object_model.factory')
            ->setObjectModelClass(DummyModel::class)
            ->setFields(['name', 'age', 'birthDate',])
            ->getGrid($searchCriteria)
        ;

        return $this->render('@Modules/melon/views/grid.html.twig', [
            'grid' => $this->presentGrid($grid),
            'title' => 'Grid title',
        ]);
    }
}
