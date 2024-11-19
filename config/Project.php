<?php

namespace config;

class Project
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO("mysql:host=localhost;dbname=portfolio;charset=utf8mb4", "root", "");
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    // CREATE
    public function createProject(string $title, string $description, string $image): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO projects (title, description, image) VALUES (:title, :description, :image)");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':image' => $image
        ]);
    }

    // READ
    public function getAllProjects(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProjectById(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM projects WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    // UPDATE
    public function updateProject(int $id, string $title, string $description, string $image): void
    {
        $stmt = $this->pdo->prepare("UPDATE projects SET title = :title, description = :description, image = :image WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':description' => $description,
            ':image' => $image
        ]);
    }

    // DELETE
    public function deleteProject(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM projects WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
