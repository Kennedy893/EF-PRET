<?php
require_once __DIR__ . '/../db.php';
class HtypePret
{
    private int $id_type_pret;
    private string $nom_type_pret;
    private float $taux_interet;

    public function __construct(int $id_type_pret, string $nom_type_pret, float $taux_interet)
    {
        $this->id_type_pret = $id_type_pret;
        $this->nom_type_pret = $nom_type_pret;
        $this->taux_interet = $taux_interet;
    }

    public function getIdTypePret(): int
    {
        return $this->id_type_pret;
    }

    public function getNomTypePret(): string
    {
        return $this->nom_type_pret;
    }

    public function getTauxInteret(): float
    {
        return $this->taux_interet;
    }

    public function setNomTypePret(string $nom_type_pret): void
    {
        $this->nom_type_pret = $nom_type_pret;
    }

    public function setTauxInteret(float $taux_interet): void
    {
        $this->taux_interet = $taux_interet;
    }

    public static function getAll()
    {
        $db=$db = getDB();
        $stmt = $db->query("SELECT * FROM type_pret");
        $valeur=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $retour=[];
        foreach ($valeur as $val)
        {
            $retour[] = new HtypePret(
                $val['id_type_pret'],
                $val['nom_type_pret'],
                $val['taux_interet']
            );
        }
        return $retour;
    }

    public static function getById($id)
    {
        
        $db=$db = getDB();
        $stmt = $db->prepare("SELECT * FROM type_pret WHERE id_type_pret = ?");
        $stmt->execute([$id]);
        $valeur=$stmt->fetch(PDO::FETCH_ASSOC);
        return new HtypePret($valeur['id_type_pret'],$valeur['nom_type_pret'],$valeur['taux_interet']);

    }

    public static function create($data) 
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO type_pret (nom_type_pret, taux_interet) VALUES (?, ?)");
        $stmt->execute([$data->nom_type_pret, $data->taux_interet]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) 
    {
        $db = getDB();
        $stmt = $db->prepare("UPDATE type_pret SET nom_type_pret = ?, taux_interet = ? WHERE id_type_pret = ?");
        $stmt->execute([$data->nom_type_pret, $data->taux_interet, $id]);
    }

    public static function delete($id) 
    {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM type_pret WHERE id_type_pret = ?");
        $stmt->execute([$id]);
    }
}