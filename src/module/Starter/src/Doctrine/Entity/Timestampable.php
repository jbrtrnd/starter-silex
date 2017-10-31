<?php

namespace Starter\Doctrine\Entity;

/**
 * Timestampable Trait.
 *
 * Adds a creation date and an updated date in a Doctrine entity.
 *
 * @package Starter\Doctrine\Entity
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
trait Timestampable
{
    /**
     * @var \DateTime Creation date of the entity.
     * @Column(type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @var \DateTime Updated date of the entity.
     * @Column(type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * Return the creation date of the entity.
     *
     * @return \DateTime The creation date of the entity.
     */
    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    /**
     * Set the creation date of the entity.
     *
     * @param \DateTime $created The value to set.
     *
     * @return void
     */
    public function setCreated(?\DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * Return the updated date of the entity.
     *
     * @return \DateTime The updated date of the entity.
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    /**
     * Set the updated date of the entity.
     *
     * @param \DateTime $updated The value to set.
     *
     * @return void
     */
    public function setUpdated(?\DateTime $updated): void
    {
        $this->updated = $updated;
    }
}
