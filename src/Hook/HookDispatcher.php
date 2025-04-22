<?php

declare(strict_types=1);

namespace Panniz\PsBaseModule\Hook;

use Panniz\PsBaseModule\AbstractModule;

class HookDispatcher
{
    public function __construct(private HookProvider $hookProvider)
    {
    }

    /**
     * Find hook and dispatch it
     *
     * @param string $hookName
     * @param array $params
     *
     * @return mixed
     */
    public function dispatch(string $hookName, AbstractModule $module, array ...$params)
    {
        $hookObj = $this->hookProvider->getHook($hookName);

        if ($hookObj !== null) {
            return $hookObj->exec($module, $params);
        }
    }
}
