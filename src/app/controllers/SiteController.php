<?php
namespace app\controllers;

use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController
{
    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    public function __construct(\Twig_Environment $twig, FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    /**
     * Homepage
     * @param Request $request
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function actionIndex(Request $request)
    {
        $data = array(
            'ip' => '',
            'location' => '',
        );

        /** @var Form $form */
        $form = $this->formFactory->createBuilder(FormType::class, $data)
            ->add('ip', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'IP']
            ])
            ->add('location', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Location', 'readonly' => true]
            ])
            ->add('get_ip', ButtonType::class, [
                'label' => 'Get IP',
                'attr' => ['class' => 'btn btn-default'],
            ])
            ->add('get_location', ButtonType::class, [
                'label' => 'Get location',
                'attr' => ['class' => 'btn btn-default'],
            ])
            ->getForm();

        return $this->twig->render('site/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}