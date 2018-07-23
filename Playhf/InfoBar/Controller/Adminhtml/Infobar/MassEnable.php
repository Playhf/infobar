<?php

namespace Playhf\InfoBar\Controller\Adminhtml\Infobar;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Playhf\InfoBar\Controller\Adminhtml\Infobar;
use Playhf\InfoBar\Model\ResourceModel\InfoBar\CollectionFactory;

class MassEnable extends Infobar
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * MassDisable constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        \Magento\Framework\Registry $registry,
        CollectionFactory $collectionFactory
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context, $registry);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setIsActive(true);
            $item->save();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been enabled.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}