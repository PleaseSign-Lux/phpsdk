<?
namespace PleaseSign;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class Client {
    
    /**
     * PleaseSign Europe production API URL
     */
    const PROD_BASE_URL = 'https://public.pleasesign.eu/';

    /**
     * PleaseSign Europe sandbox API URL
     */
    const SANDBOX_BASE_URL = 'https://public.pleasesign.ovh/';

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * @var string
     */
    private $url;

    /**
     * @param string $accessToken
     * @param bool $production
     */
    public function __construct($accessKey, $accessSecret, $production = false) {
        $this->client = new GuzzleClient(
            [
                'headers' => [
                    'X-PLEASESIGN-KEY' => $accessKey,
                    'X-PLEASESIGN-SECRET' => $accessSecret,
                ],
            ]
        );

        $this->url = $production ? self::PROD_BASE_URL : self::SANDBOX_BASE_URL;
    }
    
    /**
     * A paged list of available templates
     * @return  \PleaseSign\Response\TemplateList\Response
     */
    public function GetTemplates() {
        $response = $this->get('templates');
        $templateList = new Response\TemplateList\Result();
        $templateList->totalCount = $response['total_count'];
        $templateList->templates = [];
        foreach ($response["data"] as $templateData) {
            $template = new Response\TemplateList\Template();
            $template->id = $templateData['id'];
            $template->title = $templateData['title'];
            $template->name = $templateData['name'];
            $template->createdDate = $templateData['created_date'];
            array_push($templateList->templates, $template);
        }
        $templateList->nextResultSetToken = $response['next'];
        $templateList->previousResultSetToken = $response['prev'];
        
        return $templateList;
    }
    
    /**
     * A paged list of available templates
     * @return \PleaseSign\Response\TemplateDetail\Response
     */
    public function GetTemplate($templateId) {
        $response = $this->get("template/{$templateId}");
        $templateDetail = new Response\TemplateDetail\Result();
        $templateDetail->title = $response['title'];
        $templateDetail->name = $response['name'];
        $templateDetail->active = $response['active'] == 1 ? true : false;
        $templateDetail->folderId = $response['template_folder_id'];
        $templateDetail->folderName = $response['template_folder_name'];
        $templateDetail->brandId = $response['brand_id'];
        $templateDetail->brandName = $response['brand_name'];
        foreach ($response["pages"] as $pageData) {
            $page = new Response\TemplateDetail\Page();
            $page->page = $pageData['page'];
            $page->width = $pageData['width'];
            $page->height = $pageData['height'];
            array_push($templateDetail->pages, $page);
        }
        foreach ($response["recipients"] as $recipientData) {

            $recipient = new Response\TemplateDetail\Recipient();
            $recipient->order = $recipientData['order'];
            $recipient->role = $recipientData['role'];
            $recipient->firstName = $recipientData['first_name'];
            $recipient->lastName = $recipientData['last_name'];
            $recipient->email = $recipientData['email'];
            foreach ($recipientData["tabs"] as $tabData) {
                $tab = new Response\TemplateDetail\Tab();
                $tab->label = $tabData['label'];
                $tab->page = $tabData['page'];
                $tab->kind = $tabData['kind'];
                $tab->x = $tabData['x'];
                $tab->y = $tabData['y'];
                $tab->width = $tabData['width'];
                $tab->height = $tabData['height'];
                $tab->text_height = $tabData['text_height'];
                $tab->required = $tabData['required'];
                $tab->editable = $tabData['editable'] == true;
                $tab->options = $tabData['options'];
                $tab->group = $tabData['group'];
                $tab->collaborative = $tabData['collaborative'];
                $tab->value = $tabData['value'];
                $tab->tooltip = $tabData['tooltip'];
                array_push($recipient->tabs, $tab);
            }
            array_push($templateDetail->recipients, $recipient);
        }
        foreach ($response["carbons"] as $carbonData) {

            $carbon = new Response\TemplateDetail\Carbon();
            $carbon->role = $carbonData['role'];
            $carbon->firstName = $carbonData['first_name'];
            $carbon->lastName = $carbonData['last_name'];
            $carbon->email = $carbonData['email'];
            array_push($templateDetail->carbons, $carbon);
        }
        return $templateDetail;
    }
    
    /**
     * Creates a document from a template
     * @param \PleaseSign\Request\TemplateList\Request $method
     * @return  \PleaseSign\Response\TemplateList\Result
     */
    public function CreateFromTemplate($templateId, $documentRequest) {
        $requestData = $documentRequest->toApiRequest();
        $response = $this->post("template/{$templateId}/document", $requestData);
        $result = new \PleaseSign\Response\CreateDocumentFromTemplate\Result($response);
        return $result;
    }
    
    protected function get($path) {
        return $this->request('get', $path);
    }
    
    protected function post($path, $params) {
        return $this->request('post', $path, $params);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $params
     *
     * @return ResponseInterface
     */
    protected function request($method, $path, $params = []) {
        try {
            $responseText = $this->client->$method("$this->url$path", [  \GuzzleHttp\RequestOptions::JSON => $params ])->getBody();
            $response = json_decode($responseText, true);
        } catch (Exception $exception) {
            // Rethrow only for now
            throw new Exception($exception->getMessage());
        }

        return $response;
    }
}