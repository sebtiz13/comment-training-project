<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

\define('IMAGE_NOT_EXIST', [86, 97, 105]);

class ItemFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($imageId = 10, $i = 0; $i < 20; ++$i, ++$imageId) {
            if (\in_array($imageId, IMAGE_NOT_EXIST)) {
                ++$imageId;
            }
            $item = new Item();
            $item->setTitle($faker->sentence(5, true))
                ->setDescription($faker->paragraph(3, true))
                ->setImage("https://picsum.photos/id/${imageId}/300/200");
            $manager->persist($item);
        }

        $manager->flush();
    }
}
