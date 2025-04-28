<?php

namespace System\Console;

use System\Database\SchemaBuilder;

class OreoCommand
{
    public static function handle($argv)
    {
        $command = $argv[1] ?? null;

        if (!$command) {
            echo "❌ Aucune commande fournie.\n";
            exit;
        }

        switch ($command) {
            case 'db:create':
                self::createDatabase();
                break;
            
            default:
                echo "❌ Commande inconnue : $command\n";
                break;
        }
    }

    protected static function createDatabase()
    {
        echo "🚀 Création des tables...\n";
        $schemaBuilder = new SchemaBuilder();
        $schemaBuilder->migrate();
        echo "✅ Base de données prête !\n";
    }
}
