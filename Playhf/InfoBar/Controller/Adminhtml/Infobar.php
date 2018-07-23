<?php

namespace Playhf\InfoBar\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;

abstract class Infobar extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Playhf_InfoBar::top_info_bar';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    public function __construct(Action\Context $context, Registry $registry)
    {
        $this->coreRegistry = $registry;

        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu(static::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Notifications'), __('Notifications'))
            ->addBreadcrumb(__('Top Information Bars'), __('Top Information Bars'));
        return $resultPage;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}