<?php

namespace Panniz\PsBaseModule;

use Panniz\PsBaseModule\Hook\HookDispatcher;
use Panniz\PsBaseModule\Hook\HookProvider;
use Panniz\PsBaseModule\Install\Installer;

class AbstractModule extends \Module implements ModuleInterface
{
    protected \WeakReference $db;

    protected array $hooks = [];

    protected array $installQueries = [];

    protected array $uninstallQueries = [];

    protected HookDispatcher $hookDispatcher;

    public function __construct()
    {
        $this->db = \WeakReference::create(\Db::getInstance());
        parent::__construct();
    }

    public function install(): bool
    {
        return parent::install() && Installer::install($this);
    }

    public function uninstall(): bool
    {
        return parent::uninstall() && Installer::uninstall($this);
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

    public function getHooks(): array
    {
        return $this->hooks;
    }

    public function getHookDispatcher(): HookDispatcher
    {
        if (!isset($this->hookDispatcher)) {
            $hookProvider = new HookProvider($this, $this->getHooks());
            $this->hookDispatcher = new HookDispatcher($hookProvider);
        }

        return $this->hookDispatcher;
    }

    public function __call($methodName, $arguments)
    {
        return $this->getHookDispatcher()->dispatch(
            $methodName,
            !empty($arguments[0]) ? (is_array($arguments[0]) ? $arguments[0] : [$arguments[0]]) : []
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
