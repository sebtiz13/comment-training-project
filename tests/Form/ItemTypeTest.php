<?php

declare(strict_types=1);

namespace App\Tests\Form;

use App\Entity\Item;
use App\Form\ItemType;
use Symfony\Component\Form\Test\TypeTestCase;

class ItemTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'title' => 'test title',
            'image' => 'testImage.jpg',
            'description' => 'test description',
        ];
        $expected = (new Item())
            ->setTitle($formData['title'])
            ->setImage($formData['image'])
            ->setDescription($formData['description']);

        $item = new Item();
        $form = $this->factory->create(ItemType::class, $item);
        $form->submit($formData);

        self::assertTrue($form->isSynchronized());
        self::assertEquals($expected, $item);
    }
}
