<?php

namespace Playhf\InfoBar\Controller\Adminhtml\Infobar;

use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Playhf\InfoBar\Model\InfoBarRepository;
use Playhf\InfoBar\Controller\Adminhtml\Infobar;
use Playhf\InfoBar\Model\ResourceModel\InfoBar\CollectionFactory;

class MassDelete extends Infobar
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var InfoBarRepository
     */
    protected $infobarRepository;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param Registry $registry
     * @param InfoBarRepository $infoBarRepository
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        Registry $registry,
        InfoBarRepository $infoBarRepository,
        CollectionFactory $collectionFactory,
        Filter $filter
    )
    {
        $this->filter = $filter;
        $this->infobarRepository = $infoBarRepository;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context, $registry);
    }

    /**
     * Mass delete action
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $barsDeleted = 0;

        /** @var \Playhf\InfoBar\Model\InfoBar $infobar */
        foreach ($collection->getItems() as $infobar) {
            $this->infobarRepository->delete($infobar);
            $barsDeleted++;
        }
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $barsDeleted)
        );

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
}