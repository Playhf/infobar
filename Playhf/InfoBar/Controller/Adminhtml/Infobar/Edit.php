<?php

namespace Playhf\InfoBar\Controller\Adminhtml\Infobar;

use Magento\Backend\App\Action;
use Playhf\InfoBar\Controller\Adminhtml\Infobar;
use Playhf\InfoBar\Api\InfoBarRepositoryInterface;
use Playhf\InfoBar\Api\Data\InfoBarInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;


class Edit extends Infobar
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var InfoBarRepositoryInterfaceFactory
     */
    protected $infobarRepository;

    protected $infobarFactory;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param InfoBarInterfaceFactory $infoBarInterfaceFactory
     * @param InfoBarRepositoryInterface $repositoryFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Registry $registry,
        InfoBarRepositoryInterface $repositoryFactory,
        InfoBarInterfaceFactory $infoBarInterfaceFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->coreRegistry = $registry;
        $this->resultPageFactory = $resultPageFactory;
        $this->infobarRepository = $repositoryFactory;
        $this->infobarFactory = $infoBarInterfaceFactory;

        parent::__construct($context, $registry);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $infobar = $this->infobarFactory->create();
        $id = $this->getRequest()->getParam('entity_id');

        if ($id) {
            try {
                $infobar = $this->infobarRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while editing the information bar.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('notification/*/index');
                return $resultRedirect;
            }
        }

        $this->coreRegistry->register('infobar', $infobar);

        $this->initPage($resultPage);

        $resultPage->addBreadcrumb(
            $id ? __('Edit Top Information Bar') : __('New Top Information Bar'),
            $id ? __('Edit Top Information Bar') : __('New Top Information Bar')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Top Information Bar'));

        if ($id) {
            $resultPage->getConfig()->getTitle()->prepend($infobar->getTitle());
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Top Information Bar'));
        }

        return $resultPage;
    }
}