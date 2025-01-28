namespace Custom\FormFetchPlugin\Controller\Actions;

use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\ResourceConnection;

class Index extends Action
{
    protected $resultPageFactory;
    protected $request;
    protected $messageManager;
    protected $resource;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        PageFactory $resultPageFactory,
        RequestInterface $request,
        ManagerInterface $messageManager,
        ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->resource = $resource;
    }

    public function execute()
    {
        // Initialize the fetched data variable
        $fetchedData = null;

        // Check if the request is POST
        if ($this->getRequest()->isPost()) {
            try {
                // Retrieve POST parameters
                $params = $this->request->getPostValue();

                // Validate required parameters
                if (empty($params['email']) || empty($params['firstname']) || empty($params['lastname']) || empty($params['schoolname'])) {
                    throw new \Exception(__('All fields are required.'));
                }

                // Save data to the database
                $this->saveToDatabase($params);

                // Add success message
                $this->messageManager->addSuccessMessage(__('Data has been saved successfully.'));
            } catch (\Exception $e) {
                // Add error message
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        // Return the same page without redirect
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Frontend Form Fetch Plugin'));

        return $resultPage;
    }

    /**
     * Save data to the database
     *
     * @param array $params
     * @throws \Exception
     */
    private function saveToDatabase($params)
    {
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('form_fetch_plugin_data'); // Your table name

        $data = [
            'email' => $params['email'],
            'first_name' => $params['firstname'],
            'last_name' => $params['lastname'],
            'school_name' => $params['schoolname'],
        ];

        // Check if a record already exists
        $existingRecord = $connection->fetchOne(
            "SELECT COUNT(*) FROM $tableName WHERE email = :email",
            ['email' => $params['email']]
        );

        if ($existingRecord) {
            // Update record
            $connection->update($tableName, $data, ['email = ?' => $params['email']]);
        } else {
            // Insert new record
            $connection->insert($tableName, $data);
        }
    }

    public function fetchAction()
    {
        $email = $this->getRequest()->getPost('fetch_email');
        $response = ['success' => false, 'message' => 'No email provided.'];

        if ($email) {
            // Query the database to fetch the details
            $connection = $this->resource->getConnection();
            $tableName = $this->resource->getTableName('form_fetch_plugin_data');
            $userData = $connection->fetchRow(
                "SELECT * FROM $tableName WHERE email = :email",
                ['email' => $email]
            );

            if ($userData) {
                $response = ['success' => true, 'data' => $userData];
            } else {
                $response = ['success' => false, 'message' => 'No data found for this email.'];
            }
        }

        // Send the response as JSON
        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->getResponse()->setBody(json_encode($response));
    }
}
