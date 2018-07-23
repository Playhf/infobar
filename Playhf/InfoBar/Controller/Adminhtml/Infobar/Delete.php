<?php

namespace Playhf\InfoBar\Controller\Adminhtml\Infobar;

use Magento\Framework\Registry;
use Playhf\InfoBar\Controller\Adminhtml\Infobar;
use Magento\Backend\App\Action\Context;
use Playhf\InfoBar\Model\InfoBarRepository;

class Delete extends Infobar
{
    /**
     * @var InfoBarRepository
     */
    protected $infobarRepository;

    public function __construct(
        Context $context,
        Registry $registry,
        InfoBarRepository $infoBarRepository
    ) {
        $this->infobarRepository = $infoBarRepository;

        return parent::__construct($context, $registry);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $infobar = $this->infobarRepository->getById($id);
                $this->infobarRepository->delete($infobar);

                $this->messageManager->addSuccess(__('You deleted the information bar.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a information bar to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}