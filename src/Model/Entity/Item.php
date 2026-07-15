<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $item_id
 * @property string $item_name
 * @property string|null $description
 * @property int|null $category_id
 * @property int|null $vendor_id
 * @property int|null $quantity_available
 * @property int|null $minimum_stock
 * @property string|null $unit
 * @property string|null $item_image
 * @property string|null $status
 * @property \Cake\I18n\DateTime|null $created_at
 * @property \Cake\I18n\DateTime|null $updated_at
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Vendor $vendor
 * @property \App\Model\Entity\Requisition[] $requisition
 */
class Item extends Entity
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
        'item_name' => true,
        'description' => true,
        'category_id' => true,
        'vendor_id' => true,
        'quantity_available' => true,
        'minimum_stock' => true,
        'unit' => true,
        'item_image' => true,
        'status' => true,
        'created_at' => true,
        'updated_at' => true,
        'category' => true,
        'vendor' => true,
        'requisition' => true,
    ];
}
