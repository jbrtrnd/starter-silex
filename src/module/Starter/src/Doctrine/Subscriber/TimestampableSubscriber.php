<?php

namespace Starter\Doctrine\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Starter\Doctrine\Entity\Timestampable;

/**
 * The subscriber to manage Timestampable entities.
 *
 * @package Starter\Doctrine\Subscriber
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class TimestampableSubscriber implements EventSubscriber
{
    /**
     * Set timestamp dates.
     *
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args): void
    {
        $entityManager = $args->getEntityManager();
        $uow           = $entityManager->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($this->isTimestampable($entity)) {
                $entity->setCreated(new \DateTime());
                $uow->recomputeSingleEntityChangeSet($entityManager->getClassMetadata(get_class($entity)), $entity);
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($this->isTimestampable($entity)) {
                $entity->setUpdated(new \DateTime());
                $uow->recomputeSingleEntityChangeSet($entityManager->getClassMetadata(get_class($entity)), $entity);
            }
        }
    }

    /**
     * Return if the object use the Timestampable trait.
     *
     * @param object $object The object to test.
     *
     * @return bool If the object use the Timestampable trait.
     */
    protected function isTimestampable($object): bool
    {
        $traits = [];
        do {
            $traits = array_merge(class_uses($object), $traits);
        } while ($object = get_parent_class($object));

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait), $traits);
        }

        return in_array(Timestampable::class, $traits);
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array Events to listen.
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::onFlush
        ];
    }
}
