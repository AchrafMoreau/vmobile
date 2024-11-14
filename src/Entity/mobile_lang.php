<?php

namespace Vmobile\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ps_vala_mobile_lang", indexes={
 *     @ORM\Index(name="id_lang_idx", columns={"id_lang"}),
 *     @ORM\Index(name="id_vala_mobile_idx", columns={"id_vala_mobile"})
 * })
 */
class ValaMobileLang
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_lang")
     */
    private int $idLang;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_vala_mobile")
     */
    private int $idValaMobile;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=250, name="url_rewrite")
     */
    private string $urlRewrite;

    /**
     * @ORM\Column(type="string", length=250, name="meta_title")
     */
    private string $metaTitle;

    /**
     * @ORM\Column(type="text", name="meta_desc")
     */
    private string $metaDesc;
}
