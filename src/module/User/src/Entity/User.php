<?php

namespace User\Entity;

use Doctrine\ORM\EntityManager;
use Starter\Rest\RestEntity;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilterInterface;

/**
 * User entity.
 *
 * @package User\Entity
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 *
 * @Entity(repositoryClass="User\Repository\UserRepository")
 * @Table(name="user_user")
 */
class User extends RestEntity
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", unique=true)
     */
    protected $username;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $password;

    /**
     * Return the id property value.
     *
     * @return int The id property value.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the id property value.
     *
     * @param int $id The value to set.
     *
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Return the username property value.
     *
     * @return string The username property value.
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the username property value.
     *
     * @param string $username The value to set.
     *
     * @return void
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * Return the password property value.
     *
     * @return string The password property value.
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the password property value.
     *
     * Encrypt with the BCRYPT algorithm if the value is different of the current password.
     *
     * @param string $password The value to set.
     *
     * @return void
     */
    public function setPassword(?string $password): void
    {
        if ($this->password !== $password && $password) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $this->password = $password;
        }
    }
    
    /**
     * Convert the current object into json array.
     *
     * @return array The serialized entity.
     */
    public function jsonSerialize(): array
    {
        return [
            'id'       => $this->getId(),
            'username' => $this->getUsername()
        ];
    }
    
    /**
     * Return the User InputFilter for validating and filtering fields.
     *
     * @param EntityManager $entityManager The Doctrine entity manager.
     *
     * @return InputFilterInterface The InputFilter.
     */
    public function getInputFilter(EntityManager $entityManager): InputFilterInterface
    {
        $factory = new Factory();
        return $factory->createInputFilter([
            'id' => [
                'required' => false
            ],
            'username' => [
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags']
                ],
                'validators' => [
                    [
                        'name'    => 'Callback',
                        'options' => [
                            'callback' => function ($value, $context) use ($entityManager) {
                                $repository = $entityManager->getRepository(__CLASS__);
                                return $repository->usernameIsUnique($value, $context['id'] ?? null);
                            }
                        ]
                    ]
                ]
            ],
            'password' => [
                'required'   => true
            ]
        ]);
    }
}
