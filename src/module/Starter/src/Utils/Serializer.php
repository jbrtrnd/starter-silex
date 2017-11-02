<?php

namespace Starter\Utils;

/**
 * Utilities function to serialize an object to an array from a list of properties.
 *
 * @package Starter\Utils
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Serializer
{
    /**
     * Return the array based representation of an object from an array of properties.
     *
     * To retrieve properties from the object, the Serialize will call the getters function, so if you want to
     * retrieve the property "bar", your object must have the "getBar" function accessible.
     *
     * You can chain getter methods, for example, you can retrieve properties of returned property
     * (useful for relations) with the dot syntax e.g. : "someCollection.someProperty,someCollection.someOtherProperty".
     *
     * @param object   $object     The object to serialize.
     * @param string[] $properties The properties to retrieve.
     *
     * @return array
     */
    public static function serialize($object, array $properties): array
    {
        $res = [];

        foreach ($properties as $property) {
            self::extract($object, $property, $res);
        }

        return $res;
    }

    /**
     * Retrieve the value from a property chain and affect the final array.
     *
     * @param object|array $object The object or array to serialize.
     * @param string       $chain  The property chain to retrieve.
     * @param array|null   $res    The final array to set values.
     *
     * @return array|null
     */
    protected static function extract($object, string $chain, ?array &$res)
    {
        $chain    = explode('.', $chain);
        $property = $chain[0];

        // We are in the case where a collection was retrieved at last call
        if (is_array($object)) {
            foreach ($object as $i => $item) {
                if (!isset($res[$i])) {
                    $res[$i] = [];
                }
                // Extract each each item in the corresponding final array entry
                self::extract($item, implode('.', $chain), $res[$i]);
            }
        } else {
            $value = $object->{'get' . ucfirst($property)}();
            // If we're on a chain with chaining properties, recall the function with the value and the shifted chain
            if (sizeof($chain) > 1) {
                array_shift($chain);
                $res[$property] = self::extract($value, implode('.', $chain), $res[$property]);
            } else {
                // Special case for DateTime
                if ($value instanceof \DateTime) {
                    $value = $value->format('Y-m-d H:i:s');
                }

                $res[$property] = $value;
            }
        }

        return $res;
    }
}
