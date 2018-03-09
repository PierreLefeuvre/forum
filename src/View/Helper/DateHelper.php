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
     * Renvoi au format $todayFormat si la date est aujourd'hui. Renvoi au formt $pastFormat si la date est passé.
     */
    public function formatDate($date, $pastFormat = 'd/m/Y', $todayFormat = 'H:i:s'){
        if(date('Ymd', strtotime($date)) == date('Ymd'))
            return date($todayFormat, strtotime($date));
        else
            return date($pastFormat, strtotime($date));
    }
}
