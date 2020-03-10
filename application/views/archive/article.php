<div class="row">
    <div class="col "><h1><?php use ItForFree\SimpleMVC\Url;
            $homepageTitle = $Article->title;
            echo $homepageTitle ?></h1>
        </div>
</div>
<div class="row">
    <div class="col ">
      <p class="lead"><?=$lead?></p>
    </div>
</div>

<div style="width: 100%; font-style: italic;"><?= htmlspecialchars( $Article->summary )?></div>
<div style="width: 100%;"><?= nl2br($Article->content) ?></div>
<?php setlocale(LC_ALL, 'ru_RU.UTF-8'); ?>
<p class="pubDate">Опубликована <?= strftime('%d %B \'%y', $Article->publicationDate)?>

    <?php if ( $Article->categoryId ) { ?>
        in
        <a href="./?action=archive&amp;categoryId=<?= $Article->categoryId?>">
            <?php echo htmlspecialchars($categories[$Article->categoryId]) ?>
        </a>
        <?php if ($Article->subcategoryId) { ?>
            <a href=".?action=archive&amp;subcategoryId=<?= $Article->subcategoryId?>">
                -> <?= htmlspecialchars($subcategories[$Article->subcategoryId] )?>
            </a>
        <?php } else {?>
            -> <a href=".?action=archive&amp;subcategoryId=none">Без подкатегорий</a>
        <?php } ?>
        <?php if ( $Article->authors) { ?>
            <span> by <?= implode(', ', $Article->authors)?></span>
        <?php } } ?>

</p>