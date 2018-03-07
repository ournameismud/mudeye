<?php
/**
 * Mud Eye plugin for Craft CMS 3.x
 *
 * Mud SEO plugin for Craft 3
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\mudeye;

use ournameismud\mudeye\services\MudEyeService as MudEyeServiceService;
use ournameismud\mudeye\variables\MudEyeVariable;
use ournameismud\mudeye\models\Settings;
use ournameismud\mudeye\fields\MudEyeField as MudEyeFieldField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class MudEye
 *
 * @author    @cole007
 * @package   MudEye
 * @since     1.0.0
 *
 * @property  MudEyeServiceService $mudEyeService
 */
class MudEye extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var MudEye
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = MudEyeFieldField::class;
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('mudEye', MudEyeVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'mud-eye',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        $fieldsService = Craft::$app->getFields();
        $fields = array();
        
        foreach(Craft::$app->fields->getAllFields() AS $field) {
            if (get_class($field) == 'ournameismud\mudeye\fields\MudEyeField') {
                $name = $field->name;
                $handle = $field->handle;
                $id = $field->id;
                $fieldGroup = $fieldsService->getGroupById($field->groupId);
                $group = $fieldGroup->name;
                $fields[$handle] = $group . ': ' . $name;
            }
        }
        // craft\records\Field
        // Craft::dd($fieldsService->getAllFields(['type' => 'ournameismud\mudeye\fields\MudEyeField']));
        return Craft::$app->view->renderTemplate(
            'mud-eye/settings',
            [
                'settings' => $this->getSettings(),
                'options' => $fields
            ]
        );
    }
}
