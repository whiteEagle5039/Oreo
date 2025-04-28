<?php

return [
    "users" => [
        "id" => "INT PRIMARY KEY AUTO_INCREMENT",
        "nom" => "VARCHAR(255)",
        "prenom" => "VARCHAR(255)",
        "email" => "VARCHAR(255) UNIQUE",
        "password" => "VARCHAR(255)"
    ],
    "produits" => [
        "id" => "INT PRIMARY KEY AUTO_INCREMENT",
        "nom" => "VARCHAR(255)",
        "description" => "TEXT"
    ],
];
