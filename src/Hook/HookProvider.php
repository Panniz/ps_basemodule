<?php
namespace Panniz\PsBaseModule\Hook;

/**
 * @
 * @package Panniz\PsBaseModule\Hook
 */
class HookProvider
{
    /** @var array<string, HookInterface> */
    private array $hooks = [];
    public function __construct(array $hooks)
    {
        foreach($hooks as $hook) {
            $this->assertIsHook($hook);
            /** @var HookInterface $hook */
            $this->addHook($hook);
        }
    }

    public function getHooksNames(): array
    {
        return array_keys($this->hooks);
    }

    public function getHook(string $hookName): ?HookInterface
    {
        return $this->hooks[$hookName] ?? null;
    }

    public function addHook(HookInterface $hook): self
    {
        $this->hooks[$hook->getHookName()] = $hook;

        return $this;
    }

    private function assertIsHook(mixed $hook): void
    {
        if (!$hook instanceof HookInterface) {
            throw new \InvalidArgumentException(sprintf('Hook must implement %s', HookInterface::class));
        }
    }
}