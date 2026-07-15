<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StockTransaction Entity
 *
 * @property int $transaction_id
 * @property int $item_id
 * @property int $admin_id
 * @property string $transaction_type
 * @property int $quantity
 * @property \Cake\I18n\DateTime|null $transaction_date
 * @property string|null $remarks
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Admin $admin
 */
class StockTransaction extends Entity
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
        'item_id' => true,
        'admin_id' => true,
        'transaction_type' => true,
        'quantity' => true,
        'transaction_date' => true,
        'remarks' => true,
        'item' => true,
        'admin' => true,
    ];
}
