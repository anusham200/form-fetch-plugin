<?php
namespace Custom\FormFetchPlugin\Controller\Adminhtml\Form;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Custom\FormFetchPlugin\Model\FormDataFactory;

class Submit extends Action
{
    protected $formDataFactory;
    protected $dataPersistor;

    /**
     * Constructor
     */
    public function __construct(
        Action\Context $context,
        FormDataFactory $formDataFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->formDataFactory = $formDataFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Execute method
     */
    public function execute()
    {
        // Retrieve the form data from the request
        $postData = $this->getRequest()->getPostValue();

        // Check if data is not empty
        if (!empty($postData)) {
            try {
                // Create a new instance of the model
                $formData = $this->formDataFactory->create();

                // Set the data (ensure keys match the form's input names)
                $formData->setData([
                    'email' => $postData['email'],
                    'first_name' => $postData['firstname'], // Adjusted key to match the form field
                    'last_name' => $postData['lastname'],   // Adjusted key to match the form field
                    'school_name' => $postData['schoolname'], // Adjusted key to match the form field
                ]);

                // Save the data to the database
                $formData->save();

                // Add success message
                $this->messageManager->addSuccessMessage(__('Form data has been saved successfully.'));
            } catch (\Exception $e) {
                // Add error message
                $this->messageManager->addErrorMessage(__('Unable to save form data. Error: %1', $e->getMessage()));
            }
        } else {
            // Add warning message if form data is empty
            $this->messageManager->addErrorMessage(__('No form data to save.'));
        }

        // Redirect back to the form or another page
        return $this->_redirect('formfetch/form/index');
    }
}
