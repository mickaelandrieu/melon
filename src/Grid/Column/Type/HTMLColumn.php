<?php

namespace FOP\Melon\Grid\Column\Type;

use PrestaShop\PrestaShop\Core\Grid\Column\AbstractColumn;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class HTMLColumn extends AbstractColumn
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'html';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setRequired([
                'field',
            ])
            ->setDefaults([
                'clickable' => true,
            ])
            ->setAllowedTypes('field', 'string')
            ->setAllowedTypes('clickable', 'bool')
        ;
    }
}
