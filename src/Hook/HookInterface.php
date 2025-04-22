<?php
namespace Panniz\PsBaseModule\Hook;

use Panniz\PsBaseModule\AbstractModule;

interface HookInterface
{
    public function exec(AbstractModule $module, array $params);

    public function getHookName(): string;
}