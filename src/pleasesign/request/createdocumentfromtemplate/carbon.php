<?
namespace PleaseSign\Request\CreateDocumentFromTemplate;

/**
 * A carbon copy recipient defined in a template
 */
class Carbon {
    
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
     * Email of the recipient
     * @var string
     */
    public $email;
}