namespace Custom\FormFetchPlugin\Controller\Form;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Logger\Monolog;
use Custom\FormFetchPlugin\Model\FormDataFactory;

class Submit extends Action
{
    protected $formDataFactory;
    protected $messageManager;
    protected $logger;

    public function __construct(
        Context $context,
        FormDataFactory $formDataFactory,
        ManagerInterface $messageManager,
        Monolog $logger // Add logger here
    ) {
        parent::__construct($context);
        $this->formDataFactory = $formDataFactory;
        $this->messageManager = $messageManager;
        $this->logger = $logger; // Initialize logger
    }

    public function execute()
    {
        // Retrieve form data from POST request
        $postData = $this->getRequest()->getPostValue();

        // Log the form data to check if it's being received
        $this->logger->info('Form Data:', $postData); // Log form data

        if (!empty($postData)) {
            try {
                // Create an instance of the form data model
                $formData = $this->formDataFactory->create();

                // Set form data values
                $formData->setEmail($postData['email']);
                $formData->setFirstName($postData['firstname']);
                $formData->setLastName($postData['lastname']);
                $formData->setSchoolName($postData['schoolname']);

                // Save form data to the database
                $formData->save();

                // Add a success message
                $this->messageManager->addSuccessMessage(__('Form data has been saved successfully.'));
            } catch (\Exception $e) {
                // Log the error and add an error message
                $this->logger->error('Error Saving Form Data:', ['exception' => $e]);
                $this->messageManager->addErrorMessage(__('Unable to save form data.'));
            }
        }

        // Redirect back to the form page after submission
        return $this->_redirect('*/*/');
    }
}
