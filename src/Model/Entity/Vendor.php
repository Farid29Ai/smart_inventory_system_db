<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vendor Entity
 *
 * @property int $vendor_id
 * @property string $vendor_name
 * @property string|null $contact_person
 * @property string|null $phone_no
 * @property string|null $email
 * @property string|null $address
 */
class Vendor extends Entity
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
        'vendor_name' => true,
        'contact_person' => true,
        'phone_no' => true,
        'email' => true,
        'address' => true,
    ];
}
