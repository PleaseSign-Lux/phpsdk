<?
namespace PleaseSign\Request\CreateDocumentFromTemplate;

/**
 * A response to a get templates request
 */
class Request {
    
    /**
     * Document title
     * @var string
     */
    public $title;
    
    /**
     * Name of the document
     * @var string
     */
    public $name;
    
    /**
     * A message to help the recipients understand the purpose of the document
     * @var string
     */
    public $message;
    
    /**
     * Id of the folder where the document will be stored
     * @var string
     */
    public $folderId;
    
    /**
     * Id of the brand associated with the document
     * @var string
     */
    public $brandId;
    
    /**
     * Recipients of the document
     * @var PleaseSign\Request\CreateDocumentFromTemplate\Recipient[]
     */
    public $recipients = [];
    
    /**
     * Carbon copy recipients of the document
     * @var PleaseSign\Request\CreateDocumentFromTemplate\Carbon[]
     */
    public $carbons = [];
    
    /**
     * Converts this request into an API perceptible request
     * @return Array
     */
    public function toApiRequest() {
        $request = [];
        $request['title'] = $this->title;
        $request['name'] = $this->name;
        $request['message'] = $this->message;
        $request['folder_id'] = $this->folderId;
        $request['brand_id'] = $this->brandId;
        $request['recipients'] = [];
        $request['carbons'] = [];
        foreach ($this->recipients as $recipient)
        {
            $recipientData = [];
            $recipientData['order'] = $recipient->order;
            $recipientData['role'] = $recipient->role;
            $recipientData['first_name'] = $recipient->firstName;
            $recipientData['last_name'] = $recipient->lastName;
            $recipientData['mobile'] = $recipient->mobile;
            $recipientData['email'] = $recipient->email;
            $recipientData['tabs'] = [];
            
            foreach ($recipient->tabs as $tab) {
                $tabData = [];
                $tabData['page'] = $tab->page;
                $tabData['kind'] = $tab->kind;
                $tabData['x'] = $tab->x;
                $tabData['y'] = $tab->y;
                $tabData['width'] = strval(intval($tab->width));
                $tabData['height'] = strval(intval($tab->height));
                $tabData['value'] = $tab->value;
                $tabData['editable'] = $tab->editable;
                array_push($recipientData['tabs'], $tabData);
            }
            
            array_push($request['recipients'], $recipientData);
        }
        foreach ($this->carbons as $carbon)
        {
            $carbonData = [];
            $carbonData['role'] = $carbon->role;
            $carbonData['first_name'] = $carbon->firstName;
            $carbonData['last_name'] = $carbon->lastName;
            $carbonData['email'] = $carbon->email;
            array_push($request['carbons'], $carbonData);
        }
        return $request;
    }
    
    function findTabByLabel($searchLabel) {
        foreach ($this->recipients as $recipient) {
            foreach ($recipient->tabs as $tab) {
                if ($tab->label == $searchLabel){
                    return $tab;
                }
            }
        }
        return null;
    }
}