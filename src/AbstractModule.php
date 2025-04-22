<?php

namespace Panniz\PsBaseModule;

use Panniz\PsBaseModule\Hook\HookDispatcher;
use Panniz\PsBaseModule\Install\DbAdapter;
use Panniz\PsBaseModule\Install\Installer;

abstract class AbstractModule extends \Module implements ModuleInterface
{
    protected \WeakReference $db;

    protected array $installQueries = [];

    protected array $uninstallQueries = [];

    public function __construct()
    {
        parent::__construct();
        $this->db = \WeakReference::create(\Db::getInstance());
    }

    public function install(): bool
    {
        return parent::install()
            && Installer::install(
                new DbAdapter($this->getDatabase()),
                $this,
                $this->getHooks(),
                $this->installQueries
            );
    }

    public function uninstall(): bool
    {
        return parent::uninstall() && Installer::uninstall(new DbAdapter($this->getDatabase()), $this->getUninstallQueries());
    }

    public function getContext(): \Context
    {
        return $this->context;
    }

    public function getDatabase(): \Db
    {
        $db = $this->db->get();

        if ($db === null) {
            $this->db = new \WeakReference(\Db::getInstance());
            $db = $this->db->get();
        }

        return $db;
    }

    abstract public function getHooks(): array;


    abstract public function getHookDispatcher(): HookDispatcher;

    public function __call($methodName, $arguments)
    {
        return $this->getHookDispatcher()->dispatch(
            (string)$methodName,
            $this,
            (array)($arguments[0] ?? [])
        );
    }

    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }

    public function getInstallQueries(): array
    {
        return $this->installQueries;
    }

    public function getUninstallQueries(): array
    {
        return $this->uninstallQueries;
    }
}
