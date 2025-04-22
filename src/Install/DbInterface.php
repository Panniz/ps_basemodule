<?php
namespace Panniz\PsBaseModule\Install;

interface DbInterface
{
    public function execute(string $query): bool;

}