<?php

class OuvragesController {
    
    public function index() {

        $ouvrages = Ouvrage::findAll();
        view('ouvrages.index', compact('ouvrages'));

    }

    public function show($id) {

        $ouvrage = Ouvrage::findOne($id);
        view('ouvrages.show', compact('ouvrage'));

    }

    public function add() {

        view('ouvrages.add');

    }

    public function save() {

        $ouvrage = new Ouvrage($_POST['titre'], $_POST['auteur'], $_POST['id']);
        $ouvrage->save();

        Header('Location: '. url('ouvrages'));
    }

    public function delete($id) {

        $ouvrage = Ouvrage::findOne($id);
        $ouvrage->delete();

        Header('Location: '. url('ouvrages'));
        exit();

    }

}