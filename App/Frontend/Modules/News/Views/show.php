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
      <p>de <?= $item['auteur']?> le <?= $item['date']->format('d/m/Y')?> à <?= $item['date']->format('H:i')?></p>
      <p><?= nl2br ($item['contenu']); ?></p>
    <?php
  }
}
elseif(isset($commentMessage))
{
  echo ($commentMessage);
}
?>
<p><a href = "add-comments-<?=$news['id'];?>.html">Ajoutez un commentaire</a></p>