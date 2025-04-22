<?php

namespace Panniz\PsBaseModule\Install;

use Panniz\PsBaseModule\ModuleInterface;

class Installer
{
    public static function install(DbInterface $db, ModuleInterface $module, array $hooks, array $queries): bool
    {
        return
            (bool)$module->registerHook($hooks) &&
            self::executeQueries($db, $queries);
    }

    public static function uninstall(DbInterface $db, array $queries): bool
    {
        return self::executeQueries($db, $queries);
    }

    private static function executeQueries(DbInterface $db, array $queries): bool
    {
        foreach ($queries as $query) {
            if (!$db->execute((string)$query)) {
                return false;
            }
        }

        return true;
    }
}
