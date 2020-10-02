<h1><?php $title ?></h1>
<p>Il y a <?= $count ?> news.</p>
<table>
  <tr>
    <th>Titre</th>
    <th>Auteur</th>
    <th>Date Ajout</th>
    <th>Date Modification</th>
  </tr>
<?php
foreach ($newsList as $item )
{   
    ?>
  <tr>
    <td><?= $item['titre'] ?></td>
    <td><?= $item['auteur'] ?></td>
    <td><?=$item['dateAjout']->format('d/m/Y à H\hi')?></td>
    <td><?=$item['dateModif']->format('d/m/Y à H\hi')?></td>
    <td><a href = "news-<?= $item['id']?>.html">Afficher la news</a></td>
    <td><a href = "news-update-<?= $item['id']?>.html">Modifier la news</a></td>
    <td><a href = "news-delete-<?= $item['id']?>.html">Effacer la news</a></td>
  </tr>
<?php
}
?>
</table>
