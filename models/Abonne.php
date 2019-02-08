<?php

class Abonne extends Db {
    
    protected $id;
    protected $prenom;
    protected $nom;

    const TABLE_NAME = "abonne";

    public function __construct($prenom, $nom, $id = null)
    {
        $this->setPrenom($prenom);
        $this->setNom($nom);
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
     * Get and Set the value of prenom
     */ 
    public function prenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        /* $this->prenom = $prenom;

        return $this; */


        if (empty($prenom)) {
            Echo ("Le prénom doit être renseigné.");
        }

        elseif(strlen($prenom) > 150) {
            Echo ("Le prénom ne doit pas faire plus de 150 caractères.");
        }
        else {

            $this->prenom = $prenom;

            return $this;

        }
    }

    /**
     * Get and Set the value of nom
     */ 
    public function nom()
    {
        return $this->nom;
    }
 
    public function setNom($nom)
    {
        /* $this->nom = $nom;

        return $this; */

        if (empty($nom)) {
            Echo ("Le nom doit être renseigné.");
        }

        elseif(strlen($nom) > 150) {
            Echo ("Le nom ne doit pas faire plus de 150 caractères.");
        }
        else {

            $this->nom = $nom;

            return $this;
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
            "prenom"         => $this->prenom(),
            "nom"            => $this->nom()
        ];

        if ($this->id > 0) return $this->update();

        $nouvelId = Db::dbCreate(self::TABLE_NAME, $data);

        $this->setId($nouvelId);

        return $this;
    }

    public function update() {

        if ($this->id > 0) {

            $data = [
                "prenom"     => $this->prenom(),
                "nom"        => $this->nom(),
                "id"         => $this->id()
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

        // On supprime les ouvrages empruntés
        Db::dbDelete('abonne_ouvrage', [
            'id_abonne' => $this->id()
        ]);

        return;
    }


    public static function findAll($objects = true) {

        $data = Db::dbFind(self::TABLE_NAME);
        
        if ($objects) {
            $objectsList = [];

            foreach ($data as $d) {

                var_dump($d);
                $objectsList[] = new Abonne($d['prenom'], $d['nom'], intval($d['id']));
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
                $objectsList[] = new Abonne($d['prenom'], $d['nom'], intval($d['id']));

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
            $article = new Abonne($data['prenom'], $data['nom'], intval($data['id']));
            return $article;
        }

        return $data;
    }
}