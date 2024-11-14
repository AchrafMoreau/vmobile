<?php

namespace Vmobile\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ps_vala_compatibility", indexes={
 *     @ORM\Index(name="id_product_idx", columns={"id_product"}),
 *     @ORM\Index(name="id_vala_mobile_idx", columns={"id_vala_mobile"}),
 *     @ORM\Index(name="year_idx", columns={"year"})
 * })
 */
class ValaCompatibility
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_product")
     */
    private int $idProduct;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_vala_mobile")
     */
    private int $idValaMobile;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250)
     */
    private string $year;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $indexed;

    /**
     * @ORM\Column(type="datetime", name="date_add")
     */
    private \DateTimeInterface $dateAdd;
}
