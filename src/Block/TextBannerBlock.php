<?php

declare(strict_types=1);

namespace App\Block;

use App\Entity\SonataMediaMedia;
use App\Repository\SonataMediaMediaRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Sonata\CoreBundle\Model\Metadata;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextBannerBlock extends AbstractAdminBlockService
{
    /**
     * @var SonataMediaMediaRepository
     */
    private $repository;

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $block = $blockContext->getBlock();
        $this->loadBackground($block);

        return $this->renderResponse($blockContext->getTemplate(), [
            'block' => $block,
            'settings' => $blockContext->getSettings(),
        ], $response);
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $this->loadBackground($block);

        $formMapper->add('settings', ImmutableArrayType::class, [
            'keys' => [
                ['title',TextType::class,[
                    'required' => false,
                ]],
                ['text',TextareaType::class,[
                    'required' => false,
                ]],
                ['background', MediaType::class, [
                    'provider' => 'sonata.media.provider.image',
                    'required' => false,
                    'context' => 'default',
                ]]
            ],
            'translation_domain' => 'AppBlocks',
        ]);
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        $errorElement
            ->with('settings[title]')
                ->assertNotNull([])
                ->assertNotBlank()
            ->end()
            ->with('settings[text]')
                ->assertNotNull([])
                ->assertNotBlank()
            ->end()
        ;
    }

    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'title' => '',
            'text' => '',
            'background' => null,
            'template' => 'Block/block_text_banner.html.twig',
        ]);
    }

    public function getBlockMetadata($code = null)
    {
        return new Metadata(
            $this->getName(), $code ?? $this->getName(), false, 'AppBlocks', [
                'class' => 'fa fa-file-text-o',
            ]
        );
    }

    public function prePersist(BlockInterface $block)
    {
        parent::prePersist($block);

        $this->saveBackground($block);
    }

    public function preUpdate(BlockInterface $block)
    {
        parent::preUpdate($block);

        $this->saveBackground($block);
    }

    /**
     * @required
     */
    public function setRepositry(SonataMediaMediaRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function loadBackground(BlockInterface $block)
    {
        $background = $block->getSetting('background');
        if (!is_null($background)) {
            if (is_numeric($background)) {
                $background = $this->repository->find($background);
            }
            if (!$background instanceof SonataMediaMedia) {
                $background = new SonataMediaMedia();
            }
            $block->setSetting('background', $background);
        }
    }

    protected function saveBackground(BlockInterface $block)
    {
        $background = $block->getSetting('background');
        if ($background instanceof SonataMediaMedia) {
            if ($background->getSize()) {
                $this->repository->save($background);

                $block->setSetting('background', $background->getId());
            }
        }
    }
}
