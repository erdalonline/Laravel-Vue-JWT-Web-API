<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = [];

    /**
     * Add a settings value
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function add($key, $val)
    {
        if ( self::has($key) ) {
            return self::set($key, $val);
        }

        return self::create(['option_name' => $key, 'option_value' => $val]) ? $val : false;
    }

    /**
     * Get a settings value
     *
     * @param $key
     * @param null $default
     * @return bool|int|mixed
     */
    public static function get($key, $default = null)
    {
        if ( self::has($key) ) {
            $setting = self::getAllSettings()->where('option_name', $key)->first();
            return $setting->option_value;
        }
        if ($default){
            return self::add ($key,$default);
        }
        return false;
    }

    /**
     * Set a value for setting
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function set($key, $val)
    {
        if ( $setting = self::getAllSettings()->where('option_name', $key)->first() ) {
            return $setting->update([
                'option_name' => $key,
                'option_value' => $val]) ? $val : false;
        }

        return self::add($key, $val);
    }

    /**
     * Remove a setting
     *
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        if( self::has($key) ) {
            return self::whereOptionName($key)->delete();
        }

        return false;
    }

    /**
     * Check if setting exists
     *
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return (boolean) self::getAllSettings()->whereStrict('option_name', $key)->count();
    }

    /**
     * Get all the settings
     *
     * @return mixed
     */
    public static function getAllSettings()
    {
        return Cache::rememberForever('settings.all', function() {
            return self::all();
        });
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('settings.all');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function() {
            self::flushCache();
        });
    }

}
