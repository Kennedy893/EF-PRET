<?php
require_once __DIR__ . '/../models/Hpret.php';
require_once __DIR__ . '/../helpers/Utils.php';



class HpretController 
{
    public static function getAll() 
    {
        $pret = Hpret::getAll();
        Flight::json($pret);
    }

    public static function getById($id) 
    {
        $pret = Hpret::getById($id);
        Flight::json($pret);
    }

    public static function create() 
    {
        $data = Flight::request()->data;
        $id = Hpret::create($data);
        $dateFormatted = Utils::formatDate('2025-01-01');
        Flight::json(['message' => 'Pret ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Hpret::update($id, $data);
        Flight::json(['message' => 'Pret modifié']);
    }

    public static function delete($id) {
        Hpret::delete($id);
        Flight::json(['message' => 'Pret supprimé']);
    }
}
