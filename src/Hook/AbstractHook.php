<?php

namespace Panniz\PsBaseModule\Hook;

abstract class AbstractHook implements HookInterface
{

    public function __construct(private string $hookName) {}

    public function getHookName(): string
    {
        return $this->hookName;
    }
}
