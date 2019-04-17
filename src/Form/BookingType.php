<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 11/04/2019
 * Time: 18:38
 */

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('places', NumberType::class)
            ->add('save', SubmitType::class, array('label' => 'Valider'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Booking::class,
        ));
    }
}