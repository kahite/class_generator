<?php

namespace App\Denormalizer;

use App\Model\Persons;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PersonsDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $denormalizer = new PersonDenormalizer();

        $personArray = [];
        foreach ($data['person'] as $elem) {
          $personArray[] = $denormalizer->denormalize(
              $elem,
              'App\Model\Person',
              $format,
              $context
          );
        }

        $persons = new Persons();
        $persons->setPersons($personArray);

        return $persons;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = array())
    {
        return 'App\Model\Persons' === $type;
    }
}
