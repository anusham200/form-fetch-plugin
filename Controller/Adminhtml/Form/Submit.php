use Magento\Framework\App\Action\Context;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;
echo var_dump("Hello");
class Submit extends Action
{

    const ADMIN_RESOURCE = 'Custom_FormFetchPlugin::form_submit';
    protected $formDataFactory;
    protected $logger;

    public function __construct(
        Context $context,
        FormDataFactory $formDataFactory,
        LoggerInterface $logger
    ) {
        $this->formDataFactory = $formDataFactory;
        $this->logger = $logger;
        parent::__construct($context);
    }

    public function execute()
    {
        echo var_dump("Hello");
        $postData = $this->getRequest()->getPostValue(); // Get POST data from the form submission

        $this->logger->debug('Form data received: ', $postData); // Log the data

        if (!empty($postData)) {
            try {
                // Create a model instance
                $formData = $this->formDataFactory->create();
                
                // Set form data values
                $formData->setEmail($postData['email']);
                $formData->setFirstName($postData['firstname']);
                $formData->setLastName($postData['lastname']);
                $formData->setSchoolName($postData['schoolname']);
                
                // Save data to the database
                $formData->save();

                // Success message
                $this->messageManager->addSuccessMessage(__('Form data has been saved successfully.'));
            } catch (\Exception $e) {
                // Log error and show error message
                $this->logger->error('Error saving form data: ' . $e->getMessage());
                $this->messageManager->addErrorMessage(__('Unable to save form data. Error: %1', $e->getMessage()));
            }
        } else {
            $this->messageManager->addErrorMessage(__('No form data to save.'));
        }

        return $this->_redirect('formfetch/form/index');
    }
}
