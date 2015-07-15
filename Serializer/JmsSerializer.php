<?php

/*
 * This file is part of the ElaoRestActionBundle.
 *
 * (c) 2014 Elao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\RestActionBundle\Serializer;

use JMS\Serializer\Context;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * JMS Serializer proxy
 */
class JmsSerializer implements SerializerInterface
{
    /**
     * JMS Serializer
     *
     * @var Serializer
     */
    private $serializer;

    /**
     * Cosntructor
     *
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize($data, $format, array $context = array())
    {
        $serializationContext = $this->getContext(new SerializationContext(), $context);

        return $this->serializer->serialize($data, $format, $serializationContext);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize($data, $type, $format, array $context = array())
    {
        $deserializationContext = $this->getContext(new DeserializationContext(), $context);

        return $this->serializer->deserialize($data, $type, $format, $deserializationContext);
    }

    /**
     * Get serialization/deserialization context
     *
     * @param Context $context
     * @param array $data
     *
     * @return Context
     */
    private function getContext(Context $context, array $data = array())
    {
        foreach ($data as $key => $value) {
            $context->setAttribute($key, $value);
        }

        return $context;
    }
}
