<?php
use \AcceptanceTester;

class GroupsCest
{

    public function _before()
    {
    }

    public function _after()
    {
    }

    // tests
    public function testIfICanCreateAGroup(AcceptanceTester $I)
    {
        $I->wantTo('see that i can create a group');
        $I->amOnPage('group/create');
        $I->canSee('Create a group');
        $I->fillField('name', 'Test group');
        $I->fillField('description', 'This is just a test group');
        $I->fillField('location', 'De Kluut, Netherlands');
        $I->click('Create');

        $I->see('Group index page.');
    }

    public function testThatICantCreateGroupWithoutName(AcceptanceTester $I)
    {
        $I->wantTo('see that i can\'t create a group without name');
        $I->amOnPage('group/create');
        $I->canSee('Create a group');
        $I->fillField('name', '');
        $I->fillField('description', 'This is just a test group');
        $I->fillField('location', 'De Kluut, Netherlands');
        $I->click('Create');

        $I->see('Create a group');
    }
}
