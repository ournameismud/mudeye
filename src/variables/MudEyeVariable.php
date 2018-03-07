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
use ournameismud\mudeye\models\Settings;
use craft\web\UrlManager;
use craft\web\Request;
use craft\helpers\Template as TemplateHelper;

use Craft;

/**
 * @author    @cole007
 * @package   MudEye
 * @since     1.0.0
 */
class MudEyeVariable
{
    public $settings,
        $site,
        $baseUrl,
        $devMode = false;

    public function __construct()
    {
        $this->settings = MudEye::$plugin->getSettings();
        $this->devMode = Craft::$app->getConfig()->getGeneral()->devMode;
        $this->site = Craft::$app->sites->currentSite;
        $this->baseUrl = Craft::$app->request->hostInfo;
        // $this->devMode = (bool) $devMode;
    }

    
    public function tags($opts)
    {
        // abstract to service
        // move SEO to element?
        $robots = false;
        $url = $this->baseUrl;
        $element = Craft::$app->urlManager->getMatchedElement();
        $titleArray = array();
        $separator = ' ' . trim($this->settings['seoSeparator']) . ' ';
        
        if ($element && get_class($element) == 'craft\\elements\\Entry') {
            $title = $element->title;
            $seoFields = json_decode($element->seoFields);
            
            if($seoFields && property_exists($seoFields,'seoRobot') && $seoFields->seoRobot== 1) {
                $robots = true;
            }
            // need to make more reliable than dependence on named field
            // abstract to settings?
            if($seoFields && property_exists($seoFields,'seoTitle')) {
                $titleArray[] = $seoFields->seoTitle;
            } else {
                $titleArray[] = $element->title;
            }
        } elseif (array_key_exists('title',$opts)) {
            $titleArray[] = $opts['title'];
        }
        
        $titleArray[] = $this->site->name;
        $titleString = implode($separator,$titleArray);

        $url .= Craft::$app->request->url;

        $html = "";
        $html .= "<!-- MudEye SEO: start -->\r\n";

        $html .= "<title>" . $titleString . "</title>\r\n";
        $html .= "<link rel=\"canonical\" href=\"" . $url . "\" />\r\n";

        if ($this->devMode) {
            $html .= "<!-- robots: dev mode  -->\r\n";
        }
        if ($this->devMode OR $robots) {
            $html .= "<meta name=\"robots\" content=\"noindex\">\r\n";
            $html .= "<meta name=\"googlebot\" content=\"noindex\">\r\n";            
        }

        $html .= "<!-- MudEye SEO: end -->\r\n";
        
        return TemplateHelper::raw($html);
        
    }    
}
