<?php

namespace App\Tests\Twig;

use App\Twig\AppExtension;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    /**
     * @dataProvider getSlugs
     */
    public function testSlugify(string $string, string $slug): void
    {
        $slugger = new AppExtension;
        $this->assertSame($slug, $slugger->slugify($string));
    }

    public function getSlugs()
    {
        yield ['Lorem Ipsum', 'lorem-ipsum'];
        yield ['   Lorem Ipsum', 'lorem-ipsum'];
        yield ['!Lorem Ipsum', 'lorem-ipsum'];
        yield ['Adults 60+', 'adults-60'];
        yield ['Children\'s books', 'childrens-books'];
    }
}
