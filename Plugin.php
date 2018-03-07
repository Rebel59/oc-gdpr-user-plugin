<?php namespace Rebel59\GDPRUser;

use Backend;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;
use RainLab\User\Models\User;
use Rebel59\GDPRUser\Models\Settings;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;

/**
 * GDPRUser Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'GDPRUser',
            'description' => 'Encrypts user values as per GDPR law',
            'author'      => 'Rebel59',
            'icon'        => 'icon-shield'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        User::extend(function ($model) {
            $model->bindEvent('model.beforeSave', function() use ($model) {
                $columns = explode(' ', Settings::get('columns'));

                foreach($columns as $column){
                    try{
                        $model->$column = Crypt::encrypt($model->$column);

                    }catch(Exception $e)
                    {
                        Log::warning($e);
                    }
                }

            });

            $model->bindEvent('model.afterFetch', function() use ($model) {
                $columns = explode(' ', Settings::get('columns'));

                foreach($columns as $column){
                    try{
                        $model->$column = Crypt::decrypt($model->$column);

                    }catch(DecryptException $e)
                    {
                        $class = get_class($model);
                        Log::warning("$class #$model->id invalid payload for column: $column");
                    }
                }
            });

        });
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'GDPR Settings',
                'description' => 'Manage GDPR columns.',
                'category'    => SettingsManager::CATEGORY_USERS,
                'icon'        => 'icon-shield',
                'class'       => 'Rebel59\GDPRUser\Models\Settings',
                'order'       => 800,
                'keywords'    => 'security encryption',
            ]
        ];
    }
}
