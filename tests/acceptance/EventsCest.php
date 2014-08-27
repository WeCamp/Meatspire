<?php

class EventsCest
{
    public function testIfICantCreateAnEventWithoutBeingAuthenticated(AcceptanceTester $I)
    {
        $I->am('guest');
        $I->wantTo('see that i can\'t create an event');
        $I->amOnPage('event/create');
        $I->canSeeResponseCodeIs(301);
    }
}
