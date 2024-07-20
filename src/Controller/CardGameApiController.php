<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\CardGame;
use App\Repository\CardGameRepository;
use App\Model\CardGameDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/v1/cardgame', name: 'api_v1_cardgame_')]
class CardGameApiController extends AbstractController
{
    /**
     * CardGameApiController constructor.
     *
     * @param CardGameRepository $cardGameRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private readonly CardGameRepository $cardGameRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * gets all cardgames
     *
     * description
     */
    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Tag(name: 'cardgame')]
    #[OA\Response(
        response: 200,
        description: 'Returns all card games',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CardGameDTO::class))
        )
    )]
    public function cardgameIndex(): Response
    {
        $cardGames = $this->cardGameRepository->findAll();

        if (!$cardGames) {
            return $this->json([
                'message' => 'No card games found',
            ], 404);
        }

        $cardGamesJson = $this->serializer->serialize($cardGames, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['cards']]);

        return $this->json([
            'cardGames' => $cardGamesJson,
        ]);
    }

    /**
     * get cardgame by id
     *
     * description
     */
    #[Route('/{id}', name: 'by_id', methods: ['GET'])]
    #[OA\Tag(name: 'cardgame')]
    #[OA\Response(
        response: 200,
        description: 'Returns a card game by id',
        content: new Model(type: CardGame::class)
    )]
    public function cardgameId(int $id): Response
    {
        $cardGame = $this->cardGameRepository->find($id);

        if (!$cardGame) {
            return $this->json([
                'message' => 'Card game not found',
            ], 404);
        }

        $cardGameJson = [];
        $cardGameJson['cardGame'] = $this->serializer->serialize($cardGame, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['cards']]);

        $cards = $cardGame->getCards();

        foreach ($cards as $card) {
            $cardGameJson['cards'][] = $this->serializer->serialize($card, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['CardGame']]);
        }

        return $this->json($cardGameJson);
    }

    /**
     * create cardgame
     *
     * description
     */
    #[Route('/', name: 'create', methods: ['POST'])]
    #[OA\Tag(name: 'cardgame')]
    #[OA\RequestBody(
        description: 'Data in Json format to create a new card game',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: CardGameDTO::class, groups: ['create']))
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the Id of the created card game',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer')
            ]
        )
    )]
    public function cardgameCreate(Request $request): Response
    {
        $cardGame = $this->serializer->deserialize($request->getContent(), CardGame::class, 'json');
        $this->cardGameRepository->save($cardGame);

        return $this->json(["id" => $cardGame->getId()]);
    }

    /**
     * update cardgame
     *
     * description
     */
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    #[OA\Tag(name: 'cardgame')]
    #[OA\RequestBody(
        description: 'Data in Json format to update a new card game',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: CardGameDTO::class, groups: ['create']))
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the Id of the updated card game',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer')
            ]
        )
    )]
    public function cardgameUpdate(Request $request, int $id): Response
    {
        $cardGame = $this->cardGameRepository->find($id);
        if (!$cardGame) {
            return $this->json([
                'message' => 'Card game not found',
            ], 404);
        }
        $data = $this->serializer->deserialize($request->getContent(), CardGame::class, 'json');
        $cardGame->setName($data->getName());
        $cardGame->setBackCoverImage($data->getBackCoverImage());

        $this->cardGameRepository->save($cardGame);

        return $this->json(["id" => $cardGame->getId()]);
    }

    /**
     * delete cardgame
     *
     * description
     */
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[OA\Tag(name: 'cardgame')]
    #[OA\Response(
        response: 200,
        description: 'Returns the Id of the updated card game',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'deleted', type: 'boolean')
            ]
        )
    )]
    public function cardgameDelete(int $id): Response
    {
        $cardGame = $this->cardGameRepository->find($id);
        if (!$cardGame) {
            return $this->json([
                'message' => 'Card game not found',
            ], 404);
        }
        $this->cardGameRepository->remove($cardGame);

        return $this->json(["deleted" => true]);
    }

    /**
     * get all cards from cardgame
     *
     * description
     */
    #[Route(
        '/{id}/cards',
        name: 'cards',
        methods: ['GET']
    )]
    #[OA\Tag(name: 'cardgame')]
    public function cardgameCard(int $id): Response
    {
        $cardGame = $this->cardGameRepository->find($id);
        $cards = $cardGame->getCards();

        if (!$cards) {
            return $this->json([
                'message' => 'Card not found',
            ], 404);
        }

        $cardsJson = $this->serializer->serialize($cards, 'json');

        return $this->json([
            'cards' => $cardsJson,
        ]);
    }
}
