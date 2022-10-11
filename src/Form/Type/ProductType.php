<?php

namespace App\Form\Type;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\CategoryQuestion;
use App\Entity\Exception\CategoryQuestionException;
use App\Entity\Model;
use App\Entity\Platform;
use App\Entity\Product;
use App\Repository\BrandRepository;
use App\Repository\CategoryQuestionRepository;
use App\Repository\CategoryRepository;
use App\Repository\ModelRepository;
use App\Repository\PlatformRepository;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    private $categoryQuestionRepository;
    private $brandRepository;
    private $modelRepository;
    private $platformRepository;

    /**
     * ProductType constructor.
     * @param ContainerInterface $container
     */
    public function __construct(CategoryQuestionRepository $categoryQuestionRepository,
                                BrandRepository $brandRepository, ModelRepository $modelRepository,
                                PlatformRepository $platformRepository)
    {
        $this->categoryQuestionRepository = $categoryQuestionRepository;
        $this->brandRepository = $brandRepository;
        $this->modelRepository = $modelRepository;
        $this->platformRepository = $platformRepository;
    }

    /**
     * @throws CategoryQuestionException
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categoryQuestions = $this->categoryQuestionRepository->findBy(['category' => $options['categoryId'], 'status' => 1]);

        foreach ($categoryQuestions as $categoryQuestion) {

            $fieldChild = strtolower($categoryQuestion->getQuestion()->getName());
            $fieldType = null;
            $fieldOptions = [
                'label_html' => true,
                'label_attr' => ['class' => 'col-sm-3 control-label text-sm-end pt-2'],
                'label' => $categoryQuestion->getQuestion()->getName()
                    .($categoryQuestion->isRequired() ? '  <span class="required">*</span>' : ''),
                'attr' => [
                    'class' => 'form-control col-sm-9'
                ],
                'required' => $categoryQuestion->isRequired()
            ];

            switch ($categoryQuestion->getQuestionType()->getId()) {

                case CategoryQuestion::CATEGORY_QUESTION_INPUT_TEXT:
                    $fieldType = TextType::class;
                    $fieldOptions['attr'] = array_merge($fieldOptions['attr'], [
                        'placeholder' => $categoryQuestion->getPlaceholder()
                    ]);
                    break;

                case CategoryQuestion::CATEGORY_QUESTION_INPUT_NUMBER:
                    $fieldType = IntegerType::class;
                    $fieldOptions['attr'] = array_merge($fieldOptions['attr'], [
                        'placeholder' => $categoryQuestion->getPlaceholder()
                    ]);
                    break;

                case CategoryQuestion::CATEGORY_QUESTION_SELECT:
                    $fieldType = EntityType::class;
                    $fieldOptions['attr'] = array_merge($fieldOptions['attr'], [
                        'id' => 'product_'.$categoryQuestion->getValuesEntity()
                    ]);
                    $classEntity = null;
                    $choices = null;
                    switch ($categoryQuestion->getValuesEntity()) {
                        case 'brand':
                            $classEntity = Brand::class;
                            $choices = $this->brandRepository->findBy(['category' => $options['categoryId'], 'status' => 1]);
                            break;
                        case 'model':
                            $classEntity = Model::class;
                            $choices = $this->modelRepository->findBy(['status' => 1]);
                            break;
                        case 'platform':
                            $classEntity = Platform::class;
                            $choices = $this->platformRepository->findBy(['status' => 1]);
                            break;
                        default:
                            throw new CategoryQuestionException('Invalid ValuesEntity');
                    }
                    if($categoryQuestion->getValuesEntityDependence()) {
                        $choiceAttr = null;
                        switch ($categoryQuestion->getValuesEntityDependence()) {
                            case 'brand':
                                $choiceAttr = function (Model $model, $key, $index) {
                                    return ['data-brand' => $model->getBrand()->getId() ];
                                };
                                break;
                            default:
                                throw new CategoryQuestionException('Invalid ValuesEntityDependence');
                        }
                        $fieldOptions = array_merge($fieldOptions, [
                            'choice_attr' => $choiceAttr
                        ]);
                    }
                    $fieldOptions = array_merge($fieldOptions, [
                        'class' => $classEntity,
                        'placeholder' => $categoryQuestion->getPlaceholder(),
                        'choices' => $choices,
                        'multiple' => false,
                        'constraints' => array(new NotBlank())
                    ]);
                    break;

                case CategoryQuestion::CATEGORY_QUESTION_INPUT_RADIO:
                    // Disabled
                    break;

                default:
                    throw new CategoryQuestionException('Invalid QuestionType');
            }

            $builder->add($fieldChild, $fieldType, $fieldOptions);

        }

        $builder
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'mb-1 mt-1 mr-1 btn btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                'data_class' => Product::class,
                'categoryId' => null
        ]);
    }
}