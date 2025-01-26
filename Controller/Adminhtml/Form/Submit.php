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
        // Retrieve form data from POST
        $postData = $this->getRequest()->getPostValue();

        if ($postData) {
            try {
                // Save form data to the database
                $formData = $this->formDataFactory->create();
                $formData->setEmail($postData['email'])
                         ->setFirstName($postData['first_name'])
                         ->setLastName($postData['last_name'])
                         ->setSchoolName($postData['school_name']);
                
                $formData->save();

                // Show success message
                $this->messageManager->addSuccessMessage(__('Form data saved successfully.'));
                
                // Redirect to the form page after saving
                return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
                                           ->setPath('formfetch/form/index');
            } catch (\Exception $e) {
                // Show error message if something goes wrong
                $this->messageManager->addErrorMessage(__('Error occurred: %1', $e->getMessage()));
            }
        }

        // Redirect back if no data is posted
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
                                   ->setPath('formfetch/form/index');
    }
}
