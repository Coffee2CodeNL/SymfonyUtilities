<?php

namespace App\Util\Entity;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * AdderRemoverHelper is a class to help out with adders/removers in Symfony Entities.
 * Use at your own discretion!
 *
 * Example Usage:
 * Let's say we have a Store Entity, with a 1..n Association with People.
 * We want to add Person to the Store, so the Store entity has an addPerson(Person $person) method.
 * The Person entity has a setStore(Store $store) method to reverse the association.
 * These magic methods do the rest of the work now that we have the information.
 *
 * Here's how to use it:
 *
 *  public function addPerson(Person $person): self
 *  {
 *      AdderRemoverHelper::add($this->people, $person, 'Store');
 *
 *      return $this;
 *  }
 *
 * @package AdderRemoverHelper
 */
class AdderRemoverHelper
{
    /**
     * Adder helper.
     *
     * @param ArrayCollection $arrayCollection The ArrayCollection we want to work with
     * @param object          $entity          The (new) entity we want to add to the ArrayCollection
     * @param string          $entityMethod    The method to call on the entity to reverse the association
     */
    public static function add($arrayCollection, $entity, $entityMethod = null): void
    {
        if (!$arrayCollection->contains($entity)) {
            $arrayCollection->add($entity);
            if (null !== $entityMethod) {
                $entity->set{$entityMethod}($entity);
            }
        } else {
            return;
        }
    }

    /**
     * Remover helper.
     *
     * @param ArrayCollection $arrayCollection The ArrayCollection we want to work with
     * @param object          $entity          The (new) entity we want to add to the ArrayCollection
     * @param string          $entityMethod    The method to call on the entity to reverse the association
     */
    public static function remove($arrayCollection, $entity, $entityMethod = null): void
    {
        if ($arrayCollection->contains($entity)) {
            $arrayCollection->removeElement($entity);
            if (null !== $entityMethod) {
                if (null !== $entity->get{$entityMethod}()) {
                    $entity->set{$entityMethod}(null);
                }
            }
        } else {
            return;
        }
    }
}
