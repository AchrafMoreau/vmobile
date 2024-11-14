<?php

namespace Vmobile\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ps_vala_mobile_type", indexes={
 *     @ORM\Index(name="active_idx", columns={"active"})
 * })
 */
class ValaMobileType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_vala_mobile_type")
     */
    private int $idValaMobileType;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $active;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $position;

    /**
     * @ORM\Column(type="datetime", name="date_upd")
     */
    private \DateTimeInterface $dateUpd;

    /**
     * @ORM\Column(type="datetime", name="date_add")
     */
    private \DateTimeInterface $dateAdd;
}
