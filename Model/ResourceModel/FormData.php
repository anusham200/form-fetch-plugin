namespace Custom\FormFetchPlugin\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FormData extends AbstractDb
{
    protected function _construct()
    {
        // Initialize the table and primary key
        $this->_init('form_fetch_plugin_data', 'email');  // Table name and primary key field
    }
}
