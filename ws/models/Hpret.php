<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/Hclient.php';
require_once __DIR__ . '/../models/HtypePret.php';
require_once __DIR__ . '/../models/Hetablissement.php';

class Hpret
{
    private int $id_pret;
    private Hclient $client;
    private Hetablissement $etablissement;
    private HtypePret $type_pret;
    private float $montant;
    private string $date_pret;

    public function __construct(
        int $id_pret,
        int $id_client,
        int $id_etablissement,
        int $id_type_pret,
        float $montant,
        string $date_pret
    ) {
        $this->id_pret = $id_pret;
        $this->montant = $montant;
        $this->date_pret = $date_pret;
        
        $this->client = Hclient::getById($id_client);
        $this->etablissement = Hetablissement::getById($id_etablissement);
        $this->type_pret = HtypePret::getById($id_type_pret);
    }

    public function getIdPret(): int
    {
        return $this->id_pret;
    }

    public function getClient(): Hclient
    {
        return $this->client;
    }

    public function getEtablissement(): Hetablissement
    {
        return $this->etablissement;
    }

    public function getTypePret(): HtypePret
    {
        return $this->type_pret;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }

    public function getDatePret(): string
    {
        return $this->date_pret;
    }

    public function setClient(Hclient $client): void
    {
        $this->client = $client;
    }

    public function setEtablissement(Hetablissement $etablissement): void
    {
        $this->etablissement = $etablissement;
    }

    public function setTypePret(HtypePret $type_pret): void
    {
        $this->type_pret = $type_pret;
    }

    public function setMontant(float $montant): void
    {
        $this->montant = $montant;
    }

    public function setDatePret(string $date_pret): void
    {
        $this->date_pret = $date_pret;
    }

    public static function getAll()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM pret");
        $valeur = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $retour = [];
        foreach ($valeur as $val) {
            $retour[] = new Hpret(
                $val['id_pret'],
                $val['id_client'],
                $val['id_etablissement'],
                $val['id_type_pret'],
                $val['montant'],
                $val['date_pret']
            );
        }
        return $retour;
    }

    public static function getById($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM pret WHERE id_pret = ?");
        $stmt->execute([$id]);
        $valeur = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Hpret(
            $valeur['id_pret'],
            $valeur['id_client'],
            $valeur['id_etablissement'],
            $valeur['id_type_pret'],
            $valeur['montant'],
            $valeur['date_pret']
        );
    }

    public static function create($data) 
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO pret (id_client, id_etablissement, id_type_pret, montant, date_pret) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data->id_client, $data->id_etablissement, $data->id_type_pret, $data->montant, $data->date_pret]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) 
    {
        $db = getDB();
        $stmt = $db->prepare("UPDATE pret SET id_client = ?, id_etablissement = ?, id_type_pret = ?, montant = ?, date_pret = ? WHERE id_pret = ?");
        $stmt->execute([$data->id_client, $data->id_etablissement, $data->id_type_pret, $data->montant, $data->date_pret, $id]);
    }

    public static function delete($id) 
    {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM pret WHERE id_pret = ?");
        $stmt->execute([$id]);
    }
}