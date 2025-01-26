<?php

namespace Custom\FormFetchPlugin\Controller\Adminhtml\Customer;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Form extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
