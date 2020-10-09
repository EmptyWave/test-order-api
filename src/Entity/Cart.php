<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="orders_products")
 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Order
     *
     * @ORM\OneToOne(targetEntity="Order", inversedBy="orderCart", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *
     */
    private $order;

    /**
     * @var Product[]|Collection
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productOrders", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $products;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $sum;

    public function __toString()
    {
        return (string) $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getProducts(): ?array
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        $this->products[] = $product;

        return $this;
    }

    public function getQuantity(): int
    {
        return count($this->products);
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

    public function calculateCartPrice(): ?float
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }

        return $total;
    }
}