<?php
namespace App\Core;

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
        $html = "<h1>" . ucfirst($view) . "</h1>";
        $html .= "<form method='POST'>";

        foreach ($template['inputs'] as $input) {
            $html .= "<label>" . ucfirst($input) . "</label><br>";
            $html .= "<input type='text' name='$input' required><br><br>";
        }

        $html .= "<button type='submit'>Envoyer</button>";
        $html .= "</form>";

        echo $html;
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
        $db = new \PDO('mysql:host=localhost;dbname=oreo_db', 'root', '');

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->execute([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if ($stmt->fetch()) {
            header("Location: /public/index.php?view=$redirect");
            exit();
        } else {
            echo "<p style='color:red;'>Identifiants incorrects</p>";
        }
    }

    private function handleSignin($data, $redirect)
    {
        $db = new \PDO('mysql:host=localhost;dbname=oreo_db', 'root', '');

        $fields = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $stmt = $db->prepare("INSERT INTO users ($fields) VALUES ($placeholders)");
        $stmt->execute($data);

        header("Location: /public/index.php?view=$redirect");
        exit();
    }
}
