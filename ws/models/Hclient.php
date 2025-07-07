<?php

require_once __DIR__ . '/../db.php';

class Hclient
{
    private int $id_client;
    private string $nom_client;
    private string $date_naissance;

    public function __construct(int $id_client, string $nom_client, string $date_naissance)
    {
        $this->id_client = $id_client;
        $this->nom_client = $nom_client;
        $this->date_naissance = $date_naissance;
    }

    public function getIdClient(): int
    {
        return $this->id_client;
    }

    public function getNomClient(): string
    {
        return $this->nom_client;
    }

    public function getDateNaissance(): string
    {
        return $this->date_naissance;
    }

    public function setNomClient(string $nom_client): void
    {
        $this->nom_client = $nom_client;
    }

    public function setDateNaissance(string $date_naissance): void
    {
        $this->date_naissance = $date_naissance;
    }

    public static function getAll()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM client");
        $valeur = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $retour = [];
        foreach ($valeur as $val) {
            $retour[] = new Hclient(
                $val['id_client'],
                $val['nom_client'],
                $val['date_naissance']
            );
        }
        return $retour;
    }

    public static function getById($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM client WHERE id_client = ?");
        $stmt->execute([$id]);
        $valeur = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Hclient($valeur['id_client'], $valeur['nom_client'], $valeur['date_naissance']);
    }

    public static function create($data) 
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO client (nom_client, date_naissance) VALUES (?, ?)");
        $stmt->execute([$data->nom_client, $data->date_naissance]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) 
    {
        $db = getDB();
        $stmt = $db->prepare("UPDATE client SET nom_client = ?, date_naissance = ? WHERE id_client = ?");
        $stmt->execute([$data->nom_client, $data->date_naissance, $id]);
    }

    public static function delete($id) 
    {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM client WHERE id_client = ?");
        $stmt->execute([$id]);
    }
}