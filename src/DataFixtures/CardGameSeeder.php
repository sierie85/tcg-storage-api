<?php

namespace App\DataFixtures;

use App\Entity\CardGame;
use App\Entity\Card;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CardGameSeeder extends Fixture
{
    protected $faker;
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create("en_EN");

        $cardGame = new CardGame();
        $cardGame->setName($this->faker->name());

        $manager->persist($cardGame);

        for ($i = 0; $i < 20; $i++) {
            $card = new Card();
            $card->setCollectorNumber($i + 1);
            $card->setName($this->faker->name());
            $card->setDescription($this->faker->realText(100));
            $card->setCost($this->faker->numberBetween(1, 10));
            $card->setAttack($this->faker->numberBetween(1, 10));
            $card->setDefense($this->faker->numberBetween(1, 10));
            $card->setImage('http://localhost:8000/images/tcg_card_' . $i . '.jpg');
            $card->setTypeOrRarity($this->faker->numberBetween(1, 10));
            $card->setCardGame($cardGame);

            $manager->persist($card);
        }

        $manager->flush();
    }
}
