<h1><?php echo $title ?></h1>
<?php
//displaying one line per news with the title and the 200 first caracters
foreach ($newsList as $item )
{   
    ?>    
    <h2><a href = "news-<?= $item['id']?>.html"><?= $item['titre'] ?></a></h2>
    <p><?= nl2br ($item['contenu']); ?></p>
  <?php
}