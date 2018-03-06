<?php
/**
 * Mud Eye plugin for Craft CMS 3.x
 *
 * Mud SEO plugin for Craft 3
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\mudeye\variables;

use ournameismud\mudeye\MudEye;

use Craft;

/**
 * @author    @cole007
 * @package   MudEye
 * @since     1.0.0
 */
class MudEyeVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
