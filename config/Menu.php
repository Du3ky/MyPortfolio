<?php

namespace config;

class Menu
{
    private array $menu = [];

    private $host = 'localhost';
    private $db_name = 'portfolio';
    private $username = 'root';
    private $password = '';
    private ?\PDO $connection = null;

    public function __construct() {
        $this->connectToDatabase();
    }

    private function connectToDatabase(): void
    {
        try {
            $this->connection = new \PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Chyba pri pripojení k databáze: " . $e->getMessage();
        }
    }

    /**
     * Generuje HTML kód pre menu
     * @return string
     */
    public function generateMenuHtml(): string
    {
        $html = "";
        foreach ($this->menu as $menuItem) {
            $html .= sprintf(
                '<li class="%s"><a class="%s" href="%s">%s</a></li>',
                htmlspecialchars($menuItem['class']),
                htmlspecialchars($menuItem['class_a']),
                htmlspecialchars($menuItem['href']),
                htmlspecialchars($menuItem['content'])
            );
        }
        return $html;
    }

    /**
     * Ukladá menu do databázy
     */
    public function saveMenuToDatabase(): void
    {
        if ($this->connection) {
            try {
                $this->connection->exec("TRUNCATE TABLE menu"); // Vyčistí tabuľku pred uložením
                $stmt = $this->connection->prepare("
                    INSERT INTO menu (class, class_a, href, content) 
                    VALUES (:class, :class_a, :href, :content)
                ");

                foreach ($this->menu as $menuItem) {
                    $stmt->execute([
                        ':class' => $menuItem['class'],
                        ':class_a' => $menuItem['class_a'],
                        ':href' => $menuItem['href'],
                        ':content' => $menuItem['content']
                    ]);
                }
                echo "Menu bolo úspešne uložené do databázy.";
            } catch (\PDOException $e) {
                echo "Chyba pri ukladaní menu do databázy: " . $e->getMessage();
            }
        } else {
            echo "Databázové pripojenie neexistuje.";
        }
    }

    /**
     * Načíta menu z databázy
     */
    public function loadMenuFromDatabase(): void
    {
        if ($this->connection) {
            try {
                $stmt = $this->connection->query("SELECT class, class_a, href, content FROM menu");
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                $this->menu = $result ?: []; // Ak je $result false, nastav prázdne pole
            } catch (\PDOException $e) {
                echo "Chyba pri načítavaní menu z databázy: " . $e->getMessage();
            }
        } else {
            echo "Databázové pripojenie neexistuje.";
        }
    }
}
