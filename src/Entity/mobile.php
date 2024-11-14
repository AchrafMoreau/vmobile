<?php

namespace Vmobile\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ps_vala_mobile", indexes={
 *     @ORM\Index(name="id_vala_manufacturer_idx", columns={"id_vala_manufacturer"}),
 *     @ORM\Index(name="id_vala_mobile_type_idx", columns={"id_vala_mobile_type"}),
 *     @ORM\Index(name="active_idx", columns={"active"}),
 *     @ORM\Index(name="index_idx", columns={"index"}),
 *     @ORM\Index(name="id_parent_idx", columns={"id_parent"})
 * })
 */
class ValaMobile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_vala_mobile")
     */
    private int $idValaMobile;

    /**
     * @ORM\Column(type="integer", name="id_vala_manufacturer")
     */
    private int $idValaManufacturer;

    /**
     * @ORM\Column(type="integer", name="id_vala_mobile_type")
     */
    private int $idValaMobileType;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $model;

    /**
     * @ORM\Column(type="integer", name="year_start")
     */
    private int $yearStart;

    /**
     * @ORM\Column(type="integer", name="year_end")
     */
    private int $yearEnd;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $active;

    /**
     * @ORM\Column(type="boolean", name="index")
     */
    private bool $index;

    /**
     * @ORM\Column(type="integer", nullable=true, name="id_parent")
     */
    private ?int $idParent = null;

    /**
     * @ORM\Column(type="datetime", name="date_upd")
     */
    private \DateTimeInterface $dateUpd;

    /**
     * @ORM\Column(type="datetime", name="date_add")
     */
    private \DateTimeInterface $dateAdd;

    // Getters and setters for each property go here
}
