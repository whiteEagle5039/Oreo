<?php

namespace System\Database;

use App\Core\Connect;

class SchemaBuilder
{
    protected $pdo;
    protected $schemas;

    public function __construct()
    {
        $this->pdo = Connect::getConnection();
        $this->schemas = require __DIR__ . '/../../config/database.php';
    }

    public function migrate()
    {
        foreach ($this->schemas as $table => $columns) {
            $sql = "CREATE TABLE IF NOT EXISTS `$table` (";

            $fields = [];
            foreach ($columns as $column => $definition) {
                $fields[] = "`$column` $definition";
            }

            $sql .= implode(", ", $fields);
            $sql .= ") ENGINE=INNODB;";

            $this->pdo->exec($sql);
            echo "✅ Table `$table` créée avec succès.\n";
        }
    }
}
