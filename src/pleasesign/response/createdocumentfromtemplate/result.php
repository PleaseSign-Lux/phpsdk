<?
namespace PleaseSign\Response\CreateDocumentFromTemplate;

/**
 * A response to a get templates request
 */
class Result {
    
    function __construct($responseData) {
        $this->id = $responseData['id'];
        $this->creationDate = $responseData['created_date'];
    }
    
    /**
     * Id of the created document
     * @var string
     */
    public $id;
    
    /**
     * Creation date (in unix timestamp) of the document as it was registered in PleaseSign
     * @var integer
     */
    public $creationDate;
}