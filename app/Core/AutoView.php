<?php
namespace App\Core;

use App\Core\Connect;

class AutoView
{
    private $templates;

    public function __construct()
    {
        $this->templates = require __DIR__ . '/../../config/view_templates.php';
    }

    public function viewExists($view)
    {
        return isset($this->templates[$view]);
    }

    public function renderForm($view)
    {
        if (!$this->viewExists($view)) {
            die("Vue '$view' non trouvée.");
        }
    
        $template = $this->templates[$view];
        $html = "<!DOCTYPE html>\n";
        $html .= "<html lang=\"fr\">\n";
        $html .= "<head>\n";
        $html .= "    <meta charset=\"UTF-8\">\n";
        $html .= "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
        $html .= "    <title>" . ucfirst($view) . "</title>\n";
        $html .= "</head>\n";
        $html .= "<body>\n";
        
        $html .= "<h1>" . ucfirst($view) . "</h1>\n";
        $html .= "<form method=\"POST\">\n";
        
        foreach ($template['inputs'] as $input) {
            $html .= "    <label for=\"$input\">" . ucfirst($input) . "</label><br>\n";
            $html .= "    <input type=\"text\" id=\"$input\" name=\"$input\" required><br><br>\n";
        }
        
        $html .= "    <button type=\"submit\">Envoyer</button>\n";
        $html .= "</form>\n";
        
        $html .= "</body>\n";
        $html .= "</html>";
        
        return $html;  
    }

    public function handleForm($view)
    {
        if (!$this->viewExists($view)) {
            die("Vue '$view' non trouvée.");
        }

        $template = $this->templates[$view];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les inputs
            $data = [];
            foreach ($template['inputs'] as $input) {
                $data[$input] = $_POST[$input] ?? null;
            }

            if ($view == 'login') {
                $this->handleLogin($data, $template['redirection']);
            } elseif ($view == 'signin') {
                $this->handleSignin($data, $template['redirection']);
            } else {
                echo "Traitement pour '$view' non défini.";
            }
        }
    }
    

    private function handleLogin($data, $redirect)
    {
        // Connexion à la base de données
        $db = Connect::getConnection();

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->execute([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if ($stmt->fetch()) {
            header("Location: /$redirect");
            exit();
        } else {
            echo "<p style='color:red;'>Identifiants incorrects</p>";
        }
    }

    private function handleSignin($data, $redirect)
    {
        $db = Connect::getConnection();

        $fields = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $stmt = $db->prepare("INSERT INTO users ($fields) VALUES ($placeholders)");
        $stmt->execute($data);

        header("Location: /public/index.php?view=$redirect");
        exit();
    }
}
