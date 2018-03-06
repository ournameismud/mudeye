<?php
/**
 * Mud Eye plugin for Craft CMS 3.x
 *
 * Mud SEO plugin for Craft 3
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\mudeye\services;

use ournameismud\mudeye\MudEye;

use Craft;
use craft\base\Component;

/**
 * @author    @cole007
 * @package   MudEye
 * @since     1.0.0
 */
class MudEyeService extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (MudEye::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
