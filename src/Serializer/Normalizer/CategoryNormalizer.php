<?php

namespace App\Serializer\Normalizer;

use App\Entity\Category;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


/**
 * Category normalizer
 */
class CategoryNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'id'     => $object->getId(),
            'name'   => $object->getName(),
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