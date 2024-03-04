<?php

namespace Framework\Console\Commands;

use App\Shared\Infrastructure\Bus\RabbitMQService;
use App\Users\Application\Subscriber\UserCreatedSubscriber;
use Illuminate\Console\Command;
use PhpAmqpLib\Exception\AMQPSocketException;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'RabbitMQ Consumer';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle(): int
    {
        try {
            (new RabbitMQService())->consume((new UserCreatedSubscriber()));
        } catch (AMQPSocketException $e) {
            $this->info($e->getMessage());

            sleep(3);

            $this->info("Retrying connection");
        }

        return CommandAlias::SUCCESS;
    }
}
