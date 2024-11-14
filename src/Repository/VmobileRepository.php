<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

namespace Vmobile\Repository;

use Doctrine\ORM\EntityRepository;

class VmobileRepository extends EntityRepository
{
    public function getTypes()
    {
        return $this->createQueryBuilder('v')
            ->select('v.type')
            ->distinct()
            ->getQuery()
            ->getResult();
    }

    public function getMarque()
    {
        return $this->createQueryBuilder('v')
            ->select('v.marque')
            ->distinct()
            ->getQuery()
            ->getResult();
    }

    public function getManufacturers()
    {
        return $this->createQueryBuilder('v')
            ->select('v.manufacturer')
            ->distinct()
            ->getQuery()
            ->getResult();
    }

    public function findByCriteria($criteria)
    {
        $qb = $this->createQueryBuilder('v');

        if (isset($criteria['type'])) {
            $qb->andWhere('v.type = :type')
                ->setParameter('type', $criteria['type']);
        }

        if (isset($criteria['marque'])) {
            $qb->andWhere('v.marque = :marque')
                ->setParameter('marque', $criteria['marque']);
        }

        if (isset($criteria['annee'])) {
            $qb->andWhere('v.annee = := annee')
                ->setParameter('annee', $criteria['annee']);
        }

        if (isset($criteria['modele'])) {
            $qb->andWhere('v.modele = :modele')
                ->setParameter('modele', $criteria['modele']);
        }

        return $qb->getQuery()->getResult();
    }
}
