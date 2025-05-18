<?php
namespace Symfony\Bundle\SecurityBundle\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class IsGranted
{
    public function __construct(string $expression) {}
}
