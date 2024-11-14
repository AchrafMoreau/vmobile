<?php

namespace Vmobile\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="ps_vala_manufacturer", indexes={
 *     @ORM\Index(name="highlight_idx", columns={"highlight"}),
 *     @ORM\Index(name="active_idx", columns={"active"})
 * })
 */
class ValaManufacturer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_vala_manufacturer")
     */
    private int $idValaManufacturer;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $image;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $website;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $highlight;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private bool $active;

    /**
     * @ORM\Column(type="datetime", name="date_upd")
     */
    private \DateTimeInterface $dateUpd;

    /**
     * @ORM\Column(type="datetime", name="date_add")
     */
    private \DateTimeInterface $dateAdd;
}
