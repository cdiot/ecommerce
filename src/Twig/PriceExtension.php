<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PriceExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('price', [$this, 'formatPrice'], ['is_safe' => ['html']]),
        ];
    }

    public function formatPrice($number, $decimals = 2, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format(($number / 100), $decimals, $decPoint, $thousandsSep);

        return $price;
    }
}
