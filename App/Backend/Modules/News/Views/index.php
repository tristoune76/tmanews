<h1><?php $title ?></h1>
<p>Il y a <?= $count ?> news.</p>
<?php
//displaying one line per news with the title and the news
foreach ($newsList as $item )
{   
    ?>    
    <h2><?= $item['titre'] ?></h2>
    <p>auteur: <?= $item['auteur'] ?></p>
    <p>Créée le: <?=$item['dateAjout']->format('d/m/Y à H\hi')?></p>
    <p>Modifiée le: <?=$item['dateModif']->format('d/m/Y à H\hi')?></p>
    <p><a href = "news-modif-<?= $item['id']?>.html">modifier la news</a></p>
    <p><?= nl2br ($item['contenu']); ?></p>
  <?php
}