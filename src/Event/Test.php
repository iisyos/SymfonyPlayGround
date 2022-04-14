
<?php

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\Event;

class DecidePartyEvent extends Event
{
    public $date;
    public $storeName;
    public $entrantsNumber;
    public $price;
}

$event = new DecidePartyEvent();
$event->date = '2015-10-27';
$event->storeName = '地球のやまちゃん（居酒屋）';
$event->entrantsNumber = '25';
$event->price = '2000円';

class EntrantListener
{
    public function notify(DecidePartyEvent $event)
    {
        echo '飲み会開催のお知らせ' . PHP_EOL;
        echo sprintf('日時：%s', $event->date) . PHP_EOL;
        echo sprintf('会場：%s', $event->storeName) . PHP_EOL;
        echo sprintf('費用：%s/人', $event->price) . PHP_EOL;
    }
}
$entrantsListener = new EntrantListener();

$dispatcher = new EventDispatcher();
$dispatcher->addListener('decide.party', [$entrantsListener, 'notify']);

$dispatcher->dispatch($event, 'decide.party');
