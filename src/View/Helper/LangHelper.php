<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\I18n\I18n;

/**
 * Lang helper
 */
class LangHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getLang()
    {
        return I18n::getLocale();
    }

}
