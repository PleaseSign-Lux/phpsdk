<?
namespace PleaseSign\Request\CreateDocumentFromTemplate;

/**
 * A recipient defined in a template
 */
class Recipient {
    
    /**
     * Order in which the recipient must sign the document
     * @var int
     */
    public $order;
    
    /**
     * Role of the recipient in the template
     * @var string
     */
    public $role;
    
    /**
     * First name of the recipient
     * @var string
     */
    public $firstName;
    
    /**
     * Last name of the recipient
     * @var string
     */
    public $lastName;
    
    /**
     * If mobile is set an sms will be sent to the recipient to inform that there is a document to be signed
     * @var string
     */
    public $mobile;
    
    /**
     * Email of the recipient
     * @var string
     */
    public $email;
    
    /**
     * Tabs assigned to the recipient
     * @var PleaseSign\Request\CreateDocumentFromTemplate\Tab[]
     */
    public $tabs = [];
}