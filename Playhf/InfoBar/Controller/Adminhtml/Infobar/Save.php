<?php

namespace Playhf\InfoBar\Controller\Adminhtml\Infobar;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use Magento\Framework\Registry;
use Playhf\InfoBar\Api\Data\InfoBarInterfaceFactory;
use Playhf\InfoBar\Model\InfoBarRepository;
use Playhf\InfoBar\Controller\Adminhtml\Infobar;


class Save extends InfoBar
{
    /**
     * @var InfoBarInterfaceFactory
     */
    protected $infobarFactory;

    /**
     * @var InfoBarRepository
     */
    protected $infobarRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param Registry $registry
     * @param InfoBarInterfaceFactory $infoBarFactory
     * @param InfoBarRepository $infoBarRepository
     */
    public function __construct(
        Action\Context $context,
        Registry $registry,
        InfoBarInterfaceFactory $infoBarFactory,
        InfoBarRepository $infoBarRepository
    ) {
        $this->infobarFactory = $infoBarFactory;
        $this->infobarRepository = $infoBarRepository;

        return parent::__construct($context, $registry);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');
            $infoBar = $this->infobarRepository->get();

            if ($id) {
                $infoBar->load($id);
                if (!$infoBar->getId() && $id) {
                    $this->messageManager->addError(__('This Information Bar no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                $data['entity_id'] = null;
            }

            $infoBar->setData($data);

            try {
                $this->infobarRepository->save($infoBar);
                $this->messageManager->addSuccessMessage(__('You saved this bar.'));
                $this->_session->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $infoBar->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the information bar.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}