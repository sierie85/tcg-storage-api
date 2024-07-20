<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Card;
use App\Entity\CardGame;
use App\Model\CardDTO;
use App\Repository\CardGameRepository;
use App\Repository\CardRepository;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api/v1/card', name: 'api_v1_card_')]
class CardApiController extends AbstractController
{

  /**
   * CardGameApiController constructor.
   *
   * @param CardRepository $cardRepository
   * @param CardGameRepository $cardGameRepository
   * @param SerializerInterface $serializer
   */
  public function __construct(
    private readonly CardRepository $cardRepository,
    private readonly CardGameRepository $cardGameRepository,
    private readonly SerializerInterface $serializer
  ) {
  }

  /**
   * get card by id
   *
   * description
   */
  #[Route(
    '/{cardId}',
    name: 'by_id',
    methods: ['GET']
  )]
  #[OA\Tag(name: 'card')]
  #[OA\Response(
    response: 200,
    description: 'Returns a card by id',
    content: new Model(type: CardDTO::class)
  )]
  public function cardgameCardId(SerializerInterface $serializer, CardRepository $cardRepository, int $cardId): Response
  {
    $card = $cardRepository->find($cardId);

    if (!$card) {
      return $this->json([
        'message' => 'Card not found',
      ], 404);
    }

    $cardJson = $serializer->serialize($card, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['CardGame']]);

    return $this->json([
      'card' => $cardJson,
    ]);
  }

  /**
   * create new card
   *
   * description
   */
  #[Route(
    '/',
    name: 'create',
    methods: ['POST']
  )]
  #[OA\Tag(name: 'card')]
  // #[OA\Response(
  //   response: 200,
  //   description: 'Returns a card by id',
  //   content: new Model(type: CardDTO::class)
  // )]
  public function cardCreate(Request $request, SerializerInterface $serializer, CardRepository $cardRepository, CardGameRepository $cardGameRepository): Response
  {
    // $s = $serializer->deserialize($request->getContent(), abc, type: 'json');
    // var_dump($request->getContent());
    // die();
    // dd($request->get('card_game'));
    // $cardGame = $cardGameRepository->find($request->get('card_game'));
    $card = $serializer->deserialize($request->getContent(), Card::class, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['card_game']]);
    // $card->setCardGame($cardGame);
    // dd($card);
    $cardRepository->save($card);

    return $this->json(["id" => $card->getId()]);
  }

  /**
   * update card
   *
   * description
   */
  #[Route(
    '/{id}',
    name: 'update',
    methods: ['PUT']
  )]
  #[OA\Tag(name: 'card')]
  // #[OA\Response(
  //   response: 200,
  //   description: 'Returns a card by id',
  //   content: new Model(type: CardDTO::class)
  // )]
  public function cardUpdate(Request $request, SerializerInterface $serializer, CardRepository $cardRepository, int $id): Response
  {
    $card = $cardRepository->find($id);
    if (!$card) {
      return $this->json([
        'message' => 'Card not found',
      ], 404);
    }

    $data = $serializer->deserialize($request->getContent(), Card::class, 'json');

    // update diff? - every singl field? is ths realy fuckig needed????
    $card->setCollectorNumber($data->getCollectorNumber());
    $card->setName($data->getName());
    $card->setDescription($data->getDescription());
    $card->setCost($data->getCost());
    $card->setAttack($data->getAttack());
    $card->setDefense($data->getDefense());
    $card->setImage($data->getImage());
    $card->setEffectImage($data->getEffectImage());
    $card->setTypeOrRarity($data->getTypeOrRarity());

    $cardRepository->save($card);

    return $this->json(["id" => $card->getId()]);
  }

  /**
   * delete new card
   *
   * description
   */
  #[Route(
    '/{id}',
    name: 'delete',
    methods: ['DELETE']
  )]
  #[OA\Tag(name: 'card')]
  // #[OA\Response(
  //   response: 200,
  //   description: 'Returns a card by id',
  //   content: new Model(type: CardDTO::class)
  // )]
  public function cardDelete(CardRepository $cardRepository, int $id): Response
  {
    $card = $cardRepository->find($id);
    if (!$card) {
      return $this->json([
        'message' => 'Card not found',
      ], 404);
    }
    $cardRepository->remove($card);

    return $this->json(["deleted" => true]);
  }
}
