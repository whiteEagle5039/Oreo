<?php

namespace System\Console;

use System\Database\SchemaBuilder;
use App\Core\AutoView;

class OreoCommand
{
    private $templates;

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
            case 'vue:create':
                self::generateViews();
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

    public static function generateViews()
    {
        echo "🚀 Génération des vues standards...\n";
        $templates = require __DIR__ . '/../../config/view_templates.php';
        $viewDir = __DIR__ . '/../../ressources/views';
    
        $autoView = new AutoView();
        
        // Vérification et création du répertoire
        if (!is_dir($viewDir)) {
            echo "Tentative de création du répertoire: $viewDir\n";
            if (mkdir($viewDir, 0755, true)) {
                echo "✅ Répertoire créé avec succès.\n";
            } else {
                echo "❌ Échec de la création du répertoire.\n";
                return false;
            }
        }
        
        // Génération des vues pour chaque template
        foreach ($templates as $viewKey => $options) {
            $filename = $viewDir . '/' . $options['page_name'] . '.php';
            // Utiliser $viewKey au lieu de $options
            $html = $autoView->renderForm($viewKey);
            
            if (file_put_contents($filename, $html)) {
                echo "✅ Vue '{$options['page_name']}.php' créée.\n";
            } else {
                echo "❌ Échec de la création de la vue '{$options['page_name']}.php'.\n";
            }
        }
    
        echo "✅ Toutes les vues ont été générées dans ressources/views.\n";
        return true;
    }
}