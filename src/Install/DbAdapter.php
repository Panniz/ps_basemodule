<?php
namespace Panniz\PsBaseModule\Install;

class DbAdapter implements DbInterface
{
    private \Db $db;

    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    public function execute(string $query): bool
    {
        return $this->db->execute($query);
    }
}