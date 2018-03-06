<?php
/**
 * Mud Eye plugin for Craft CMS 3.x
 *
 * Mud SEO plugin for Craft 3
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\mudeye\assetbundles\MudEye;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    @cole007
 * @package   MudEye
 * @since     1.0.0
 */
class MudEyeAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@ournameismud/mudeye/assetbundles/mudeye/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/MudEye.js',
        ];

        $this->css = [
            'css/MudEye.css',
        ];

        parent::init();
    }
}
