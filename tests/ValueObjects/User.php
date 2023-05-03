<?php

namespace Kanagama\LaravelCollectionDeduplicate\Tests\ValueObjects;

/**
 * @method int getId()
 * @method string getName()
 * @method string getTel()
 * @method string getMail()
 *
 * @author k.nagama <k.nagama@gmail.com>
 */
class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $tel;

    /**
     * @var string
     */
    private $mail;

    /**
     * @param  array  $values
     */
    public function __construct(array $values)
    {
        $this->id = $values['id'];
        $this->name = $values['name'];
        $this->tel = $values['tel'];
        $this->mail = $values['mail'];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTel(): string
    {
        return $this->tel;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }
}