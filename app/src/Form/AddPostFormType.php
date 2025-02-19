<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use App\Entity\Keyword;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @template AddPostForm
 *
 * @extends AbstractType<AddPostForm>
 */
final class AddPostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu de l\'article',
            ])
            ->add('featuredImage', FileType::class, [
                'label' => 'Image de l\'article',
                'mapped' => false,
                'attr' => [
                    'accept' => 'image/png, image/jpeg, image/webp',
                ],
                'constraints' => [
                    new Image(
                        minWidth: 200,
                        maxWidth: 4000,
                        minHeight: 200,
                        maxHeight: 4000,
                        allowPortrait: false,
                        mimeTypes: [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ]
                    ),
                ],
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('keywords', EntityType::class, [
                'class' => Keyword::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
