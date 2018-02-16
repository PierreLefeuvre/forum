<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Date helper
 */
class DateHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Renvoi au format $pastFormat si la date est aujourd'hui. Renvoi au farmt $todayFormat sinon.
     */
    public function formatDatetime($datetime, $pastFormat = 'd/m/Y', $todayFormat = 'H:i:s'){
        if(date('Ymd', strtotime($datetime)) == date('Ymd'))
            return date($todayFormat, strtotime($datetime));
        else
            return date($pastFormat, strtotime($datetime));
    }
}
