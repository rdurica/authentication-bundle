<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Form;

use Rd\AuthenticationBundle\Entity\User;
use Rd\AuthenticationBundle\Helper\BundleHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

/**
 * Class UserType
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Form
 */
class UserType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, [
            'label'              => 'ui.username',
            'translation_domain' => BundleHelper::TRANS_DOMAIN,
        ])->add('email', EmailType::class, [
            'label'              => 'ui.email',
            'translation_domain' => BundleHelper::TRANS_DOMAIN,
        ])->add('plainPassword', RepeatedType::class, [
            'type'           => PasswordType::class,
            'first_options'  => [
                'label'              => 'ui.password',
                'translation_domain' => BundleHelper::TRANS_DOMAIN,
            ],
            'second_options' => [
                'label'              => 'ui.password_repeat',
                'translation_domain' => BundleHelper::TRANS_DOMAIN,
            ],
        ])->add('termsAccepted', CheckboxType::class, [
            'mapped'             => false,
            'constraints'        => new IsTrue(),
            'label'              => 'ui.terms_accepted',
            'translation_domain' => BundleHelper::TRANS_DOMAIN,
        ]);
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
