<?php
/**
 * Created by PhpStorm.
 * User: Valery Maslov
 * Date: 15.08.2018
 * Time: 19:55
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Locality;

final class LocalityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => [
                    'autofocus' => true,
                    'class' => 'form-control'
                ],
                'label' => 'label.name',
            ])
            ->add('slug', null, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'label.slug',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Locality::class,
        ]);
    }
}
