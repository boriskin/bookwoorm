<?php

/*
 * Это мой первый проект Symfony
 * (c) Pavel Boriskin <paboriskin@gmail.com>
 */

namespace App\Serializer\Normalizer;

use App\Entity\Category;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Category normalizer.
 */
class CategoryNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
    ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Category;
    }
}
