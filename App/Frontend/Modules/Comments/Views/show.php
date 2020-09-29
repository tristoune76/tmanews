<h2>Commentaire de <?php $comment['auteur']?></h2>
<p>Ecrit le <?= $comment['date']->format('d/m/Y')?> à <?=$comment['date']->format('h:i')?></p>
<p><?= $comment['contenu'] ?></p>
<a href="news-<?=$comment['news']?>.html">Retour à la news</a>