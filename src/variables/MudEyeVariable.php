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
        $uri,
        $devMode = false;

    public function __construct()
    {
        $this->settings = MudEye::$plugin->getSettings();
        $this->devMode = Craft::$app->getConfig()->getGeneral()->devMode;
        $this->site = Craft::$app->sites->currentSite;
        $this->baseUrl = Craft::$app->request->hostInfo;
        $this->uri = Craft::$app->request->url;
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

        $handle = $this->settings['seoField'];
        
        if ($element && get_class($element) == 'craft\\elements\\Entry' OR get_class($element) == 'craft\\elements\\Category') {
            $title = $element->title;
            $title = $element->title;
            $seoFields = json_decode($element->$handle);
            
            if($seoFields && property_exists($seoFields,'seoRobot') && $seoFields->seoRobot== 1) {
                $robots = true;
            }
            // need to make more reliable than dependence on named field
            // abstract to settings?
            $tmpTitle = $element->title;
            if($seoFields && property_exists($seoFields,'seoTitle')) {
                if (strlen(trim($seoFields->seoTitle))) $tmpTitle = $seoFields->seoTitle;
            } 
            $titleArray[] = $tmpTitle;
        } elseif (array_key_exists('title',$opts)) {
            $titleArray[] = $opts['title'];
        }
        
        if ($this->uri != '/' OR ($this->uri == '/' && (bool) $this->settings['homeSuffix'])) $titleArray[] = $this->site->name;
        $titleString = implode($separator,$titleArray);

        $url .= Craft::$app->request->url;

        $html = "";
        $html .= "\t<!-- MudEye SEO: start -->\r\n";

        $html .= "\t<title>" . $titleString . "</title>\r\n";
        $html .= "\t<link rel=\"canonical\" href=\"" . $url . "\" />\r\n";

        if ($this->devMode) {
            $html .= "\t<!-- robots: dev mode  -->\r\n";
        }
        if ($this->devMode OR $robots) {
            $html .= "\t<meta name=\"robots\" content=\"noindex\">\r\n";
            $html .= "\t<meta name=\"googlebot\" content=\"noindex\">\r\n";            
        }

        $html .= "\t<!-- MudEye SEO: end -->\r\n";
        
        return TemplateHelper::raw($html);
        
    }    
}
