<div class="row">
    <div class="col "><h1><?php use ItForFree\SimpleMVC\Url;
            echo $homepageTitle ?></h1>
        </div>
</div>
<div class="row">
    <div class="col ">
      <p class="lead"> Добро пожаловать в новостник, созданный на SimpleMVC! </p>
    </div>
</div>

<?php //vdie($articles);?>
<ul id="headlines">
    <?php foreach ($articles as $Article) { ?>
        <li class="article<?= $Article->id?>">
            <h2>
                <span class="pubDate">
                    <?php setlocale(LC_ALL, 'ru_RU.UTF-8'); ?>
                    <?= strftime('%d %B \'%y', $Article->publicationDate)?>
                </span>

                <a href="<?= Url::link('article&id=' . $Article->id)?>">
                    <?php echo htmlspecialchars( $Article->title )?>
                </a>

                <?php if (isset($Article->categoryId) && $Article->categoryId) { ?>
                    <span class="category">
                        in
                        <a href=".?route=category&amp;id=<?= $Article->categoryId?>">
                            <?= htmlspecialchars($categories[$Article->categoryId] )?>
                        </a>
                        <?php if ($Article->subcategoryId) { ?>
                            <a href=".?route=subcategory&amp;id=<?= $Article->subcategoryId?>">
                            -> <?= htmlspecialchars($subcategories[$Article->subcategoryId] )?>
                        </a>
                        <?php } else {?>
                            -> <a href=".?route=subcategory&amp;id=none">Без подкатегорий</a>
                        <?php } ?>
                    </span>
                <?php }
                else { ?>
                    <span class="category">
                        <a href=".?route=category&amp;id=0">Без категорий</a>
                    </span>
                <?php } ?>
                <button class="btn-show-author btn btn-sm btn-primary" data-articleId="<?= $Article->id?>">Show authors</button>
                <span class="category hidden" id="authors<?= $Article->id?>"></span>
            </h2>
            <p class="summary"><?php
                $position = mb_strlen($Article->content) > 50 ?  mb_strpos($Article->content, ' ', 50) : 50;
                echo htmlspecialchars(mb_substr($Article->content, 0, $position) . '...')?></p>
            <img id="loader-identity" src="JS/ajax-loader.gif" alt="gif">

            <ul class="ajax-load">
                <li><a href=".?route=viewArticle&amp;articleId=<?= $Article->id?>" class="ajaxArticleBodyByPost" data-contentId="<?= $Article->id?>">Показать продолжение (POST)</a></li>
                <li><a href=".?route=viewArticle&amp;articleId=<?= $Article->id?>" class="ajaxArticleBodyByGet" data-contentId="<?= $Article->id?>">Показать продолжение (GET)</a></li>
                <li><a href=".?route=viewArticle&amp;articleId=<?= $Article->id?>" class="ajaxNewPost" data-article-id="<?= $Article->id?>">(POST) -- NEW</a></li>
                <li><a href=".?route=viewArticle&amp;articleId=<?= $Article->id?>" class="ajaxNewGet" data-article-id="<?= $Article->id?>">(GET)  -- NEW</a></li>
            </ul>
            <a href=".?route=viewArticle&amp;articleId=<?= $Article->id?>" class="showContent" data-contentId="<?= $Article->id?>">Показать полностью</a>
        </li>
    <?php } ?>
</ul>