<?php

/*
 * This file is part of the tuowt/mpms-hkep.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hkep;

/**
 * Class Factory.
 *
 * @method static \Hkep\Auth\Application auth(array $config)
 */
class Factory
{
    /**
     * @param string $name
     * @param array  $config
     *
     * @return \Hkep\\Kernel\ServiceContainer
     */
    public static function make($name, $config)
    {
        $namespace = Kernel\Support\Str::studly($name);
        $application = "\\Hkep\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, $arguments[0]);
    }
}
