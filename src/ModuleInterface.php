<?php

namespace Panniz\PsBaseModule;

interface ModuleInterface
{
    /**
     *
     * @param string|string[] $hooks
     * @param array|null $shopList
     * @return bool
     */
    public function registerHook($hooks, $shopList = null);

    public function getHooks(): array;

    public function getContext(): \Context;

    public function getDatabase(): \Db;

    public function getInstallQueries(): array;

    public function getUninstallQueries(): array;

    /**
     * @return object|false If a container is not available it returns false
     */
    public function get(string $serviceName);

    /**
     * @return \PrestaShopBundle\Translation\TranslatorInterface
     */
    public function getTranslator();
}
