<?php

namespace Playhf\InfoBar\Block\Adminhtml\InfoBar\Edit;

use Magento\Backend\Block\Widget\Context;
use Playhf\InfoBar\Api\InfoBarRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var InfoBarRepositoryInterface
     */
    protected $infobarRepositoryInterface;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param InfoBarRepositoryInterface $infobarRepositoryInterface
     */
    public function __construct(
        Context $context,
        InfoBarRepositoryInterface $infobarRepositoryInterface
    ) {
        $this->context = $context;
        $this->infobarRepositoryInterface = $infobarRepositoryInterface;
    }

    /**
     * Return Information Bar ID
     *
     * @return int|null
     */
    public function getBarId()
    {
        try {
            return $this->infobarRepositoryInterface->getById(
                $this->context->getRequest()->getParam('entity_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            $this->context->getLogger()->error(__('Information bar doesn\'t exists. Via error message: %1', $e->getMessage()));
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}