<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RequisitionItem Entity
 *
 * @property int $requisition_item_id
 * @property int $requisition_id
 * @property int $item_id
 * @property int $quantity_requested
 * @property int|null $quantity_approved
 *
 * @property \App\Model\Entity\Requisition $requisition
 * @property \App\Model\Entity\Item $item
 */
class RequisitionItem extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'requisition_id' => true,
        'item_id' => true,
        'quantity_requested' => true,
        'quantity_approved' => true,
        'requisition' => true,
        'item' => true,
    ];
}
