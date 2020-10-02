<form action = "" method = "post">
    <div>
        <?php echo(isset($erreurs) && in_array(\Entity\News::AUTEUR_INVALIDE, $erreurs) ? "L\'auteur est invalide" : ''); ?>
        <label for="auteur">Auteur: </label></br>
        <input type= "text" name="auteur" id="auteur" value ="<?php echo(isset($news) ? $news['auteur'] : "");?>" /></br></br>
    </div>
    <div>
        <?php echo(isset($erreurs) && in_array(\Entity\News::TITRE_INVALIDE, $erreurs) ? "Le titre est invalide" : ''); ?>
        <label for="titre">Titre: </label></br>
        <input type= "text" name="titre" id="titre" value ="<?php echo(isset($news) ? $news['titre'] : "");?>" /></br></br>
    </div>
    <div>
        <?php echo(isset($erreurs) && in_array(\Entity\News::CONTENU_INVALIDE, $erreurs) ? "Le contenu est invalide" : ''); ?>
        <label for="contenu">Contenu: </label></br>
        <textarea rows="20" cols="50" name="contenu" id="contenu" ><?php echo(isset($news) ? $news['contenu'] : '');?></textarea></br>
    </div>
    <div>
        <input id="id" name="id" type="hidden" value="<?php echo(isset($news) ? $news['id'] : '');?>">
        <button type="submit">Envoyer la news</button>
    </div>
</form>


