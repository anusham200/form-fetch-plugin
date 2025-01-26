<?php
namespace Custom\FormFetchPlugin\Controller\Adminhtml\Form;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ObjectManager;
use Custom\FormFetchPlugin\Model\FormDataFactory;

class Submit extends Action
{
    protected $formDataFactory;
    protected $dataPersistor;

    public function __construct(
        Action\Context $context,
        FormDataFactory $formDataFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->formDataFactory = $formDataFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();

        if (!empty($postData)) {
            try {
                $formData = $this->formDataFactory->create();
                $formData->setData([
                    'email' => $postData['email'],
                    'first_name' => $postData['first_name'],
                    'last_name' => $postData['last_name'],
                    'school_name' => $postData['school_name'],
                ]);
                $formData->save();

                $this->messageManager->addSuccessMessage(__('Form data has been saved successfully.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Unable to save form data. Error: %1', $e->getMessage()));
            }
        }

        return $this->_redirect('*/*/index'); // Redirect to the form page or another page
    }
}
