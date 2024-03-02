<?php

namespace Api\Http\Controllers;

use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Domain\UuidGeneratorInterface;
use App\Users\Application\Create\CreateUserCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        Private readonly UuidGeneratorInterface $uuidGenerator
    ){}

    public function __invoke(Request $request): JsonResponse
    {
        $id = $request->get('id', $this->uuidGenerator->generate());

        $this->commandBus->dispatch(
            new CreateUserCommand(
                $id,
                $request->get('firstName'),
                $request->get('lastName'),
                $request->get('email'),
            )
        );

        return new JsonResponse(
            [
                'user' => [
                    'id' => $id
                ]
            ],
            Response::HTTP_CREATED,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
