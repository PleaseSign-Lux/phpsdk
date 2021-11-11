<?
namespace PleaseSign\Response\TemplateDetail;

/**
 * A response to a get templates request
 */
class Result {
    
    public $title;
    
    public $name;
    
    public $message;
    
    public $active;
    
    public $folderId;
    
    public $folderName;
    
    public $brandId;
    
    public $brandName;
    
    public $pages = [];
    
    public $recipients = [];
    
    public $carbons = [];
    
    /**
     * Converts this response into a create document request
     
     * @return \PleaseSign\Request\CreateDocumentFromTemplate\Request
     */
    public function toCreateRequest() : \PleaseSign\Request\CreateDocumentFromTemplate\Request {
        $request = new \PleaseSign\Request\CreateDocumentFromTemplate\Request();
        $request->title = $this->title;
        $request->name = $this->name;
        $request->message = $this->message;
        $request->folderId = $this->folderId;
        $request->brandId = $this->brandId;
        $request->recipients = [];
        foreach ($this->recipients as $responseRecipient) {
            $recipient = new \PleaseSign\Request\CreateDocumentFromTemplate\Recipient();
            $recipient->order = $responseRecipient->order;
            $recipient->role = $responseRecipient->role;
            $recipient->firstName = $responseRecipient->firstName;
            $recipient->lastName = $responseRecipient->lastName;
            $recipient->mobile = $responseRecipient->mobile;
            $recipient->email = $responseRecipient->email;
            $recipient->tabs = [];
            foreach ($responseRecipient->tabs as $responseRecipientTab) {
                $tab = new \PleaseSign\Request\CreateDocumentFromTemplate\Tab();
                $tab->page = $responseRecipientTab->page;
                $tab->label = $responseRecipientTab->label;
                $tab->kind = $responseRecipientTab->kind;
                $tab->x = $responseRecipientTab->x;
                $tab->y = $responseRecipientTab->y;
                $tab->width = $responseRecipientTab->width;
                $tab->height = $responseRecipientTab->height;
                $tab->value = $responseRecipientTab->value;
                $tab->editable = $responseRecipientTab->editable == null ? true : $responseRecipientTab->editable;
                array_push($recipient->tabs, $tab);
            }
            array_push($request->recipients, $recipient);
        }
        $request->carbons = [];
        foreach ($this->carbons as $responseCarbon) {
            $carbon = new \PleaseSign\Request\CreateDocumentFromTemplate\Carbon();
            $carbon->role = $responseCarbon->role;
            $carbon->firstName = $responseCarbon->firstName;
            $carbon->lastName = $responseCarbon->lastName;
            $carbon->email = $responseCarbon->email;
            array_push($request->carbons, $carbon);
        }
        return $request;
    }
}