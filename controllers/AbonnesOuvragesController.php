<?php

class AbonnesOuvragesController {

    public function index() {

        $prets = AbonneOuvrage::findAll();

        view('abonnesOuvrages.index', compact('prets'));

    }

    public function show($id) {

        $pret = AbonneOuvrage::findOne($id);
        view('abonnesOuvrages.show', compact());

    }

    public function add() {

        $abonnes = Abonne::findAll();
        $ouvrages = Ouvrage::findAll();

        view('abonnesOuvrages.add', compact('abonnes', 'ouvrages'));

    }

    public function save() {
        $pret = new AbonneOuvrage($_POST['id_abonne'], $_POST['id_ouvrage'], $_POST['id']);
        $pret->save();

        Header('Location: '. url('prets'));
    }

    public function delete($id) {

        $pret = AbonneOuvrage::findOne($id);
        $pret->delete();

        Header('Location: '. url('prets'));
        exit();

    }

   /*  public function listeNomsEmprunteurs() {

        $data = EmprunteurDisque::listeNomsEmprunteurs();
        var_dump($data);
    }

    public function nombreDisquesParEmprunteur() {

        $data = EmprunteurDisque::nombreDisquesParEmprunteur();
        var_dump($data);

    } */
}