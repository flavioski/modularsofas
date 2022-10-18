<?php
/**
 * Modular Sofas
 * Copyright since 2022 Flavio Pellizzer and Contributors
 * <Flavio Pellizzer> Property
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to flappio.pelliccia@gmail.com so we can send you a copy immediately.
 *
 * @author    Flavio Pellizzer <flappio.pelliccia@gmail.com>
 * @copyright Since 2022 Flavio Pellizzer
 * @license   https://opensource.org/licenses/MIT
 */
declare(strict_types=1);

namespace Flavioski\Module\ModularSofas\Form;

use Currency;
use Flavioski\Module\ModularSofas\ConstraintValidator\Constraints\ModularProductAttributeRequired;
use Flavioski\Module\ModularSofas\Domain\Modular\Configuration\ModularConstraint;
use Flavioski\Module\ModularSofas\Form\Type\ProductChoiceType;
use PrestaShop\PrestaShop\Core\ConstraintValidator\Constraints\CleanHtml;
use PrestaShop\PrestaShop\Core\ConstraintValidator\Constraints\DefaultLanguage;
use PrestaShop\PrestaShop\Core\ConstraintValidator\Constraints\TypedRegex;
use PrestaShop\PrestaShop\Core\ConstraintValidator\TypedRegexValidator;
use PrestaShop\PrestaShop\Core\Form\ConfigurableFormChoiceProviderInterface;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Form\Admin\Type\TranslatableType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ModularType extends TranslatorAwareType
{
    /**
     * @var ConfigurableFormChoiceProviderInterface
     */
    private $productAttributeChoiceProvider;

    /**
     * @var Currency
     */
    private $defaultCurrency;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param TranslatorInterface $translator
     * @param array $locales
     * @param ConfigurableFormChoiceProviderInterface $productAttributeChoiceProvider
     * @param Currency $defaultCurrency
     * @param RouterInterface $router
     */
    public function __construct(
        TranslatorInterface $translator,
        array $locales,
        ConfigurableFormChoiceProviderInterface $productAttributeChoiceProvider,
        Currency $defaultCurrency,
        RouterInterface $router
    ) {
        parent::__construct($translator, $locales);
        $this->productAttributeChoiceProvider = $productAttributeChoiceProvider;
        $this->defaultCurrency = $defaultCurrency;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();

        $productId = 0 !== $data['id_product'] ? $data['id_product'] : 0;
        $productAttributeChoices = $this->productAttributeChoiceProvider->getChoices(['id_product' => $productId]);

        $showProductAttributes = !empty($productAttributeChoices);

        $builder
            ->add('code', TextType::class, [
                'label' => $this->trans('Code', 'Admin.Global'),
                'help' => 'Code modular (e.g. modular-12345).',
                'attr' => [
                    'readonly' => false,
                ],
                'constraints' => [
                    new Length([
                        'max' => ModularConstraint::MAX_CODE_LENGTH,
                        'maxMessage' => $this->trans(
                            'This field cannot be longer than %limit% characters',
                            'Admin.Notifications.Error',
                            ['%limit%' => ModularConstraint::MAX_CODE_LENGTH]
                        ),
                    ]),
                    new NotBlank(),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => $this->trans('Name', 'Admin.Global'),
                'help' => $this->trans(
                        'Invalid characters:',
                        'Admin.Notifications.Info'
                    ) . ' ' . TypedRegexValidator::NAME_CHARS,
                'attr' => [
                    'readonly' => false,
                ],
                'constraints' => [
                    new CleanHtml(),
                    new TypedRegex([
                        'type' => TypedRegex::TYPE_NAME,
                    ]),
                    new Length([
                        'max' => ModularConstraint::MAX_MODULAR_NAME_LENGTH,
                        'maxMessage' => $this->trans(
                            'This field cannot be longer than %limit% characters',
                            'Admin.Notifications.Error',
                            ['%limit%' => ModularConstraint::MAX_MODULAR_NAME_LENGTH]
                        ),
                    ]),
                    new NotBlank(),
                ],
            ])
            ->add('content', TranslatableType::class, [
                'label' => $this->trans('Content', 'Admin.Global'),
                'help' => 'Modular content (e.g. All for one, one for all).',
                'constraints' => [
                    new DefaultLanguage([
                        'message' => $this->trans(
                            'The field %field_name% is required at least in your default language.',
                            'Admin.Notifications.Error',
                            [
                                '%field_name%' => sprintf(
                                    '"%s"',
                                    $this->trans('Content', 'Modules.ModularSofas.Admin')
                                ),
                            ]
                        ),
                    ]),
                ],
            ])
            ->add('active', SwitchType::class, [
                'label' => $this->trans('Status', 'Admin.Global'),
                'help' => 'Modular is active?',
                'required' => true,
            ])
        ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'Modules.ModularSofas.Admin',
        ]);
    }
}
