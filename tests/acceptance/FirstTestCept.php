<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('See Main and Login pages');
$I->amOnPage('/');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('Добро пожаловать в новостник');
$I->amOnPage('/index.php?route=login/login');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('Вход в систему');
