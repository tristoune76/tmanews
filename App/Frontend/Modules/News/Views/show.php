<?php

//displaying the title and the news
?>
<h2><?= $news['titre']?></h2>
<p><?= nl2br ($news['contenu']); ?></p>
<h2>Les commentaires</h2>
<?php
foreach ($commentsList as $item )
{   
    ?>    
    <p>de <?= $item('auteur')?> le <?= $item('date')?></p>
    <p><?= nl2br ($item['contenu']); ?></p>
  <?php
}
?>
<p><a href = "add-comments-<?=$item['id'];?>.html">Ajoutez un commentaire</a></p>