<?php
/**
 * Mud Eye plugin for Craft CMS 3.x
 *
 * Mud SEO plugin for Craft 3
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\mudeye\models;

use ournameismud\mudeye\MudEye;

use Craft;
use craft\base\Model;

/**
 * @author    @cole007
 * @package   MudEye
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $seoDesc;
    public $trackingCode;
    public $seoSeparator = '|';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['seoDesc', 'string'],
            ['trackingCode', 'string'],
            ['seoSeparator', 'string']
        ];
    }
}
