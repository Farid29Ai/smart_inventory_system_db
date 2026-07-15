<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Requisition Entity
 *
 * @property int $requisition_id
 * @property int $staff_id
 * @property int|null $admin_id
 * @property \Cake\I18n\Date|null $request_date
 * @property \Cake\I18n\Date|null $required_date
 * @property string|null $purpose
 * @property string|null $status
 * @property string|null $remarks
 *
 * @property \App\Model\Entity\Staff $staff
 * @property \App\Model\Entity\Admin $admin
 * @property \App\Model\Entity\Item[] $item
 */
class Requisition extends Entity
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
        'staff_id' => true,
        'admin_id' => true,
        'request_date' => true,
        'required_date' => true,
        'purpose' => true,
        'status' => true,
        'remarks' => true,
        'staff' => true,
        'admin' => true,
        'item' => true,
    ];
}
