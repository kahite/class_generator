<?php

namespace App\Denormalizer;

use App\Model\Person;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PersonDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $person = new Person();

        if(isset($data['@id']))
            $person->setId($data['@id']);

        if(isset($data['name']))
            $person->setName($data['name']);
        if(isset($data['age']))
            $person->setAge($data['age']);
        if(isset($data['sportsperson']))
            $person->setSportsperson($data['sportsperson']);
        if(isset($data['createdAt']))
            $person->setCreatedAt($data['createdAt']);

        return $person;
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = array())
    {
        return 'App\Model\Person' === $type;
    }
}
