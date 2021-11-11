<?
namespace PleaseSign\Request\CreateDocumentFromTemplate;

/**
 * A recipient defined in a template
 */
class Tab {
    
    /**
     * Page number in which this tab will be inserted
     * @var int
     */
    public $page;
    
    /**
     * Unique identifier of the tab
     * @var string
     */
    public $label;
    
    /**
     * Kind of tab
     * @var string
     */
    public $kind;
    
    /**
     * Horizontal position of the tab
     * @var int
     */
    public $x;
    
    /**
     * Vertical position of the tab
     * @var int
     */
    public $y;
    
    /**
     * Horizontal size of the tab
     * @var decimal
     */
    public $width;
    
    /**
     * Vertical size of the tab
     * @var decimal
     */
    public $height;
    
    /**
     * Value that will be prefill in the tab
     * @var int
     */
    public $value;
    
    /**
     * Set this tab as editable
     * @var bool
     */
    public $editable;
}