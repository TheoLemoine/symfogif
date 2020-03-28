<?php


namespace App\Form;


use App\Entity\Album;
use App\Entity\Gif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GifForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gif::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('album', EntityType::class, [
                'class' => Album::class,
                'choice_label' => 'title',
                'choice_value' => 'title',
            ])
            ->add('url', UrlType::class)
            ->add('tags', TextType::class)
            ->add('save', SubmitType::class);
    }
}