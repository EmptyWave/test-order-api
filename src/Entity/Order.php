<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    const STATUS_NEW = 1;
    const STATUS_PAID = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $status;

    /**
     * @var Cart
     *
     * @ORM\OneToOne(targetEntity="Cart", mappedBy="order", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    private $cart;

    /**
     * @ORM\Column(type="money")
     *
     * @var float
     */
    private $sum;

    public function __construct()
    {
        $this->status = static::STATUS_NEW;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setCart(Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function isNew(): bool
    {
        return $this->getStatus() === static::STATUS_NEW;
    }

    public function setPaid(): void
    {
        $this->setStatus(static::STATUS_PAID);
    }

    public function toArray(): array
    {
        $class = new \ReflectionClass(static::class);
        $parameters = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PRIVATE) as $reflectionProperty) {
            $property = $reflectionProperty->getName();
            $parameters[$property] = $this->{$property};
        }

        return $parameters;
    }
}