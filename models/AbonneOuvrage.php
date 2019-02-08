<?php

class AbonneOuvrage extends Db {
    
    protected $id;
    protected $idAbonne;
    protected $idOuvrage;

    const TABLE_NAME = "abonne_ouvrage";

    public function __construct($idAbonne, $idOuvrage, $id = null)
    {
        $this->setIdAbonne($idAbonne);
        $this->setIdOuvrage($idOuvrage);
        $this->setId($id);
    }
    /**
     * Get and Set the value of id
     */ 
    public function id()
    {
        return $this->id;
    }
 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get and Set the value of id_abonne
     */ 
    public function idAbonne()
    {
        return $this->idAbonne;
    }

    public function setIdAbonne($idAbonne)
    {
        $this->idAbonne = $idAbonne;

        return $this;
    }

    /**
     * Get and Set the value of id_ouvrage
     */ 
    public function idOuvrage()
    {
        return $this->idOuvrage;
    }
 
    public function setIdOuvrage($idOuvrage)
    {
        $this->idOuvrage = $idOuvrage;

        return $this;
    }

    /**
     * Méthodes CRUD :
     * - find
     * - findAll
     * - findOne
     * - save
     * - update
     * - delete
     */

    public function save() {

        $data = [
            "id_abonne"   => $this->idAbonne(),
            "id_ouvrage"       => $this->idOuvrage()
        ];

        if ($this->id > 0) return $this->update();

        $nouvelId = Db::dbCreate(self::TABLE_NAME, $data);

        $this->setId($nouvelId);

        return $this;
    }

    public function update() {

        if ($this->id > 0) {

            $data = [
                "id_abonne"     => $this->idAbonne(),
                "id_ouvrage"    => $this->idOuvrage(),
                "id"            => $this->id()
            ];

            Db::dbUpdate(self::TABLE_NAME, $data);

            return $this;
        }

        return;
    }

    public function delete() {
        $data = [
            'id' => $this->id(),
        ];
        
        Db::dbDelete(self::TABLE_NAME, $data);
        return;
    }

    public static function findAll($objects = true) {

        $data = Db::dbFind(self::TABLE_NAME);
        
        if ($objects) {
            $objectsList = [];

            foreach ($data as $d) {

                $objectsList[] = new AbonneOuvrage($d['id_abonne'], $d['id_ouvrage'], intval($d['id']));
            }

            return $objectsList;
        }

        return $data;
    }

    public static function find(array $request, $objects = true) {

        $data = Db::dbFind(self::TABLE_NAME, $request);

        if ($objects) {
            $objectsList = [];

            foreach ($data as $d) {
                $objectsList[] = new AbonneOuvrage($d['id_abonne'], $d['id_ouvrage'], intval($d['id']));

            }
            return $objectsList;
        }

        return $data;
    }

    public static function findOne(int $id, $object = true) {

        $request = [
            ['id', '=', $id]
        ];

        $data = Db::dbFind(self::TABLE_NAME, $request);

        if (count($data) > 0) $data = $data[0];
        else return;

        if ($object) {
            $article = new AbonneOuvrage($data['id_abonne'], $data['id_ouvrage'], intval($data['id']));
            return $article;
        }

        return $data;
    }


    public function abonne() {
        return Abonne::findOne($this->idAbonne());
    }

    public function ouvrage() {
        return Ouvrage::findOne($this->idOuvrage());
    }

}

    // Liste des noms des emprunteurs
   /*  public static function listeNomsEmprunteurs() {

        $req = 'SELECT nom, prenom
                FROM emprunteur_disque
                INNER JOIN emprunteur ON emprunteur.id = emprunteur_disque.id';

        return $data = Db::dbQuery($req);
    }

    // Nombre de disques par emprunteur
    public static function nombreDisquesParEmprunteur() {

        $req = 'SELECT prenom, nom, count(*)
                FROM emprunteur_disque
                INNER JOIN emprunteur ON emprunteur.id = emprunteur_disque.id_emprunteur
                GROUP BY emprunteur_disque.id_emprunteur
                ';

        return $data = Db::dbQuery($req);
    }

    // Nombre d'emprunteurs
    public static function nbEmprunteurs() {

        $req = 'SELECT count(DISTINCT id_emprunteurs)
                FROM emprunteur_disque
                ';

        return $data = Db::dbQuery($req);
    }

    // Nombre de disques différents empruntés
    public static function nbDisquesEmpruntes() {

        $req = 'SELECT count(DISTINCT id_disque)
                FROM emprunteur_disque
                ';

        return $data = Db::dbQuery($req);
    }

    // Nombre d'emprunts
    public static function nbEmprunts() {

        $req = 'SELECT count(*)
                FROM emprunteur_disque
                ';

        return $data = Db::dbQuery($req);
    }

    // Liste des disques non empruntés
    public static function listeDisquesNonEmpruntes() {

        $req = 'SELECT *
                FROM disque
                LEFT JOIN emprunteur_disque ON disque.id = emprunteur_disque.id_disque
                WHERE id_emprunteur IS NULL';

        return $data = Db::dbQuery($req);
    }


    // Nombre de disques non empruntés
    public static function nbDisquesNonEmpruntes() {

        $req = 'SELECT count(DISTINCT titre)
                FROM disque
                LEFT JOIN emprunteur_disque ON disque.id = emprunteur_disque.id_disque
                WHERE id_emprunteur IS NULL';

        return $data = Db::dbQuery($req);
    }

    // Liste d'emprunteurs n'ayant rien emprunté
    public static function listeEmprunteursSansPret() {

        $req = 'SELECT prenom, nom
                FROM emprunteur
                LEFT JOIN emprunteur_disque ON emprunteur.id = emprunteur_disque.id_emprunteur
                WHERE emprunteur_disque.id_disque IS NULL';

        return $data = Db::dbQuery($req);
    }

    // Nombre de disques empruntés par Han Solo
    public static function nbDisquesHanSolo() {

        $req = 'SELECT prenom, nom, count(*)
                FROM emprunteur
                INNER JOIN emprunteur_disque ON emprunteur.id = emprunteur_disque.id_emprunteur
                WHERE emprunteur.nom = "Solo"
                GROUP BY emprunteur_disque.id_emprunteur';

        return $data = Db::dbQuery($req);   
    }

    // Liste des disques empruntés par Han Solo
    public static function listeDisquesHanSolo() {

        $req = 'SELECT titre, artiste
                FROM emprunteur
                INNER JOIN emprunteur_disque ON emprunteur.id = emprunteur_disque.id_emprunteur
                INNER JOIN disque ON disque.id = emprunteur_disque.id_disque
                WHERE emprunteur.nom = "Solo"';

        return $data = Db::dbQuery($req);
    }

    // Liste des emprunteurs, avec le nom du disque, meme ceux qui n'ont pas emprunté de disque
    public static function listeEmprunteursDisques() {
        
        $req = 'SELECT titre, artiste, nom, prenom
                FROM disque
                LEFT JOIN emprunteur_disque ON disque.id = emprunteur_disque.id_disque
                LEFT JOIN emprunteur ON emprunteur.id = emprunteur_disque.id_emprunteur';

        return $data = Db::dbQuery($req);
    }

    // Liste des disques, avec le nom de l'emprunteur, meme ceux qui n'ont pas été empruntés
    public static function listeDisquesEmprunteur() {

        $req = 'SELECT nom, prenom, titre, artiste
                FROM emprunteur
                LEFT JOIN emprunteur_disque ON emprunteur.id = emprunteur_disque.id_emprunteur
                LEFT JOIN disque ON disque.id = emprunteur_disque.id_disque';

        return $data = Db::dbQuery($req);
    }

} */