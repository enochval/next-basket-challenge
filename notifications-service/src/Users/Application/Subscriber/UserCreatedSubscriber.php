<?php

declare(strict_types=1);

namespace App\Users\Application\Subscriber;

use App\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class UserCreatedSubscriber implements DomainEventSubscriberInterface
{
    public function __invoke($message)
    {
        info('Message packet received!');

        $this->logToFile($message->body);
    }

    public function logToFile(string $data)
    {
        $file = dirname(__FILE__, 5).'/consumer-log.json';

        $existingData = file_get_contents($file);
        $existingArray = json_decode($existingData, true) ?? [];
        $newData = json_decode($data, true);
        $existingArray[] = $newData;
        $updatedJsonData = json_encode($existingArray);

        file_put_contents($file, $updatedJsonData);
    }
}
