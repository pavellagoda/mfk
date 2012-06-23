<?php
/**
 * @author valery
 *
 *
 */
class FW_Cache
{

    private static $_instance = array();

    private function __construct() {
    }

    private function __clone() {
    }

    /**
     * @return Zend_Cache_Core|Zend_Cache_Frontend
     */
    public static function getCore() {
        if (!array_key_exists('core', self::$_instance)) {
            self::$_instance['core'] = null;
        }
        if (self::$_instance['core'] === null) {
            self::$_instance['core'] = self::_createFileCache();
        }
        return self::$_instance['core'];
    }

    protected static function _createFileCache() {
        return Zend_Cache::factory(
            'Core',
            'File',
            array(
                'lifetime' => 60,
                'automatic_serialization' => true
            ),
            array(
            )
        );
    }

    protected static function _createMemcachedCache() {
        return Zend_Cache::factory(
            'Core',
            'Memcached',
            array(
                'lifetime' => 60,
                'automatic_serialization' => true
            ),
            array(
                'servers' => array(
                    array(
                        'host' => 'localhost',
                        'port' => 11211,
                        'persistent' => true
                    )
                )
            )
        );
    }

    protected static function _createXCacheCache() {
        return Zend_Cache::factory(
            'Core',
            'XCache',
            array(
                'lifetime' => 60,
                'automatic_serialization' => true
            ),
            array(
            )
        );
    }

    public static function getFile($masterFile) {
        if (!array_key_exists('file', self::$_instance)) {
            self::$_instance['file'] = array();
        }
        if (!array_key_exists($masterFile, self::$_instance['file'])) {
            self::$_instance['file'][$masterFile] = null;
        }

        if (self::$_instance['file'][$masterFile] === null) {
            self::$_instance['file'][$masterFile] = Zend_Cache::factory(
                'File',
                'Memcached',
                array(
                    'master_file' => $masterFile,
                    'automatic_serialization' => true
                ),
                array(
                    'servers' => array(
                        array(
                            'host' => 'localhost',
                            'port' => 11211,
                            'persistent' => true
                        )
                    )
                )
            );
        }
        return self::$_instance['file'][$masterFile];
    }

}
?>