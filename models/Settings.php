<?php namespace Rebel59\GDPRUser\Models;

use Model;

/**
 * Settings Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'rebel59_gdpruser_settings';

    public $settingsFields = 'fields.yaml';
}
