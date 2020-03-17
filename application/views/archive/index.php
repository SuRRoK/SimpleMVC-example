<div class="row">
    <div class="col "><h1><?php use ItForFree\SimpleMVC\Url;
            echo $homepageTitle ?></h1>
        </div>
</div>
<div class="row">
    <div class="col ">
      <p class="lead"><?=$lead?></p>
    </div>
    <?php if (isset($description)) { ?>
    <div class="card" style="width: 100%; min-width: 320px">
        <div class="card-body">
            <p><?= $description ?></p>
        </div>
    </div>
    <?php } ?>
</div>

<?php //vdie($articles);?>
<ul id="headlines">
    <?php foreach ($articles as $Article) { ?>
        <li class="article<?= $Article->id?>">
            <h3>
                <span class="pubDate">
                    <?php setlocale(LC_ALL, 'ru_RU.UTF-8'); ?>
                    <?= strftime('%d %B \'%y', $Article->publicationDate)?>
                </span>

                <a href="<?= Url::link('archive/article&id=' . $Article->id)?>">
                    <?php echo htmlspecialchars( $Article->title )?>
                </a>

                <?php if (isset($Article->categoryId) && $Article->categoryId) { ?>
                    <span class="category">
                        in
                        <a href="<?= Url::link('archive/category&id=' . $Article->categoryId) ?>">
                            <?= htmlspecialchars($categories[$Article->categoryId] )?>
                        </a>
                        <?php if ($Article->subcategoryId) { ?>
                            <a href="<?= Url::link('archive/subcategory&id=' . $Article->subcategoryId)?>">
                            -> <?= htmlspecialchars($subcategories[$Article->subcategoryId] )?>
                        </a>
                        <?php } else {?>
                            -> <a href="<?= Url::link('archive/subcategory&id=none') ?>">Без подкатегорий</a>
                        <?php } ?>
                    </span>
                <?php }
                else { ?>
                    <span class="category">
                        <a href="<?= Url::link('archive/category&id=0') ?>">Без категорий</a>
                    </span>
                <?php } ?>
                <button class="btn-show-author btn btn-sm btn-primary" data-articleId="<?= $Article->id?>">Show authors</button>
                <span class="category hidden" id="authors<?= $Article->id?>"></span>
            </h3>
            <p class="summary"><?= $Article->summary ?></p>

            <ul class="ajax-load">
                <li><a href="<?= Url::link('archive/article&id=' . $Article->id)?>" class="ajaxArticleBodyByPost" data-contentId="<?= $Article->id?>">Показать продолжение (POST)</a></li>
                <li><a href="<?= Url::link('archive/article&id=' . $Article->id)?>" class="ajaxArticleBodyByGet" data-contentId="<?= $Article->id?>">Показать продолжение (GET)</a></li>
                <li><a href="<?= Url::link('archive/article&id=' . $Article->id)?>" class="ajaxNewPost" data-article-id="<?= $Article->id?>">(POST) -- NEW</a></li>
                <li><a href="<?= Url::link('archive/article&id=' . $Article->id)?>" class="ajaxNewGet" data-article-id="<?= $Article->id?>">(GET)  -- NEW</a></li>
            </ul>
            <a href="<?= Url::link('archive/article&id=' . $Article->id)?>" class="showContent" data-contentId="<?= $Article->id?>">Показать полностью</a>
        </li>
    <?php } ?>
</ul>