<?php
$I = new AcceptanceTester($scenario);
$I->am('Guest');
$I->wantTo('see the homepage');
$I->amOnPage('/');
$I->see('Welcome to Zend Framework 2', 'h1');