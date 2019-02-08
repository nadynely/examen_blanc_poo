<?php ob_start(); ?>

<h1>Voir un abonné</h1>

<form action="<?= url('abonnes/save') ?>" method="post">

    <input type="hidden" name="id" value="<?= $abonne->id() ?>">    

    <input class="form-control" type="text" name="prenom" placeholder="prenom" value="<?= $abonne->prenom() ?>">
    <input class="form-control" type="text" name="nom" placeholder="nom" value="<?= $abonne->nom() ?>">

    <button class="btn btn-primary" type="submit">Editer un abonné</button>

    <a href="<?= url('emprunteurs/delete/' . $abonne->id()) ?>" class="btn btn-danger delete" type="submit">Supprimer l'abonné</a>

</form>

<?php $content = ob_get_clean(); ?>

<?php view('template', compact('content')); ?>