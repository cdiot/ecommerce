<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testIsTrue()
    {
        $category = new Category();

        $category->setName('Jeu Occasion');

        $this->assertTrue($category->getName() === 'Jeu Occasion');
    }

    public function testIsFalse()
    {
        $category = new Category();

        $category->setName('Jeu Neuf');

        $this->assertFalse($category->getName() === 'Jeu Occasion');
    }

    public function testIsEmpty()
    {
        $category = new Category();

        $this->assertEmpty($category->getName());
    }
}
