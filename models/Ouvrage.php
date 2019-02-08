<?php

class Ouvrage extends Db {
    
    protected $id;
    protected $titre;
    protected $auteur;

    const TABLE_NAME = "ouvrage";

    public function __construct($titre, $auteur, $id = null)
    {
        $this->setTitre($titre);
        $this->setArtiste($auteur);
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
     * Get and Set the value of titre
     */ 
    public function titre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        /* $this->titre = $titre;

        return $this; */

        if (empty($_POST['titre'])) {
            echo formError("Le titre doit être renseigné.");
        }

        elseif(strlen($_POST['titre']) > 150) {
            echo formError("Le titre ne doit pas faire plus de 150 caractères.");
        }
        else {
            $titre = $_POST['titre'];

            return;
        }
    }

    /**
     * Get and Set the value of auteur
     */ 
    public function auteur()
    {
        return $this->auteur;
    }

    public function setAuteur($auteur)
    {
        /* $this->auteur = $auteur;

        return $this; */

        if (empty($_POST['auteur'])) {
            echo formError("L'auteur doit être renseigné.");
        }

        elseif(strlen($_POST['auteur']) > 150) {
            echo formError("Le auteur ne doit pas faire plus de 150 caractères.");
        }
        else {
            $auteur = $_POST['auteur'];

            return;
        }
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
            "titre"         => $this->titre(),
            "auteur"        => $this->auteur()
        ];

        if ($this->id > 0) return $this->update();

        $nouvelId = Db::dbCreate(self::TABLE_NAME, $data);

        $this->setId($nouvelId);

        return $this;
    }

    public function update() {

        if ($this->id > 0) {

            $data = [
                "titre"     => $this->titre(),
                "auteur"    => $this->auteur(),
                "id"        => $this->id()
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

        // On supprime tous les ouvrages empruntés
        Db::dbDelete('abonne_ouvrage', [
            'id_ouvrage' => $this->id()
        ]);

        return;
    }

    public static function findAll($objects = true) {

        $data = Db::dbFind(self::TABLE_NAME);
        
        if ($objects) {
            $objectsList = [];

            foreach ($data as $d) {

                $objectsList[] = new Ouvrage($d['titre'], $d['auteur'], intval($d['id']));
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
                $objectsList[] = new Ouvrage($d['titre'], $d['auteur'], intval($d['id']));

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
            $article = new Ouvrage($data['titre'], $data['auteur'], intval($data['id']));
            return $article;
        }

        return $data;
    }
}