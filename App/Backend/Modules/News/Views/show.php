<?php

//displaying the title and the news
?>
<h2><?= $news['titre']?></h2>
<p><?= nl2br ($news['contenu']); ?></p>
<h2>Les commentaires</h2>
<?php
if(isset($commentsList))
{
  foreach ($commentsList as $item )
  {   
      ?>    
      <p>
        de <?= $item['auteur']?> le <?= $item['date']->format('d/m/Y')?> à <?= $item['date']->format('H:i')?></br>
        <?= nl2br ($item['contenu']); ?> </br>
        <a href ="comment-update-<?=$item['id'];?>-<?=$news['id'];?>.html">Modifier le commentaire</a>
        <a href ="comment-delete-<?=$item['id'];?>-<?=$news['id'];?>.html">Effacer le commentaire</a>
      </p>
    <?php
  }
}
elseif(isset($commentMessage))
{
  echo ($commentMessage);
}
?>
<p><a href = "add-comment-<?=$news['id'];?>.html">Ajoutez un commentaire</a></p>