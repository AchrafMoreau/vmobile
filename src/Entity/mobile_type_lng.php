<?php

namespace Vmobile\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ps_vala_mobile_type_lang", indexes={
 *     @ORM\Index(name="id_vala_mobile_type_idx", columns={"id_vala_mobile_type"}),
 *     @ORM\Index(name="id_lang_idx", columns={"id_lang"})
 * })
 */
class ValaMobileTypeLang
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_vala_mobile_type")
     */
    private int $idValaMobileType;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_lang")
     */
    private int $idLang;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=250, name="url_rewrite")
     */
    private string $urlRewrite;
}
