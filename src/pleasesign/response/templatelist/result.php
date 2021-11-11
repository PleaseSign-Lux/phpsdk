<?
namespace PleaseSign\Response\TemplateList;

/**
 * A response to a get templates request
 */
class Result {
    
    public $totalCount;
    
    public $templates;
    
    public $nextResultSetToken;
    
    public $previousResultSetToken;
}