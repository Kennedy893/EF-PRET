<?php

require_once __DIR__ . '/../db.php';

class Hetablissement
{
    private int $id_etablissement;
    private string $nom_etablissement;
    private float $fond_total;

    public function __construct(int $id_etablissement, string $nom_etablissement, float $fond_total)
    {
        $this->id_etablissement = $id_etablissement;
        $this->nom_etablissement = $nom_etablissement;
        $this->fond_total = $fond_total;
    }

    public function getIdEtablissement(): int
    {
        return $this->id_etablissement;
    }

    public function getNomEtablissement(): string
    {
        return $this->nom_etablissement;
    }

    public function getFondTotal(): float
    {
        return $this->fond_total;
    }

    public function setNomEtablissement(string $nom_etablissement): void
    {
        $this->nom_etablissement = $nom_etablissement;
    }

    public function setFondTotal(float $fond_total): void
    {
        $this->fond_total = $fond_total;
    }

    public static function getAll()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM etablissement_financier");
        $valeur = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $retour = [];
        foreach ($valeur as $val) {
            $retour[] = new Hetablissement(
                $val['id_etablissement'],
                $val['nom_etablissement'],
                $val['fond_total']
            );
        }
        return $retour;
    }

    public static function getById($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM etablissement_financier WHERE id_etablissement = ?");
        $stmt->execute([$id]);
        $valeur = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Hetablissement($valeur['id_etablissement'], $valeur['nom_etablissement'], $valeur['fond_total']);
    }

    public static function create($data) 
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO etablissement_financier (nom_etablissement, fond_total) VALUES (?, ?)");
        $stmt->execute([$data->nom_etablissement, $data->fond_total]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) 
    {
        $db = getDB();
        $stmt = $db->prepare("UPDATE etablissement_financier SET nom_etablissement = ?, fond_total = ? WHERE id_etablissement = ?");
        $stmt->execute([$data->nom_etablissement, $data->fond_total, $id]);
    }

    public static function delete($id) 
    {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM etablissement_financier WHERE id_etablissement = ?");
        $stmt->execute([$id]);
    }
}