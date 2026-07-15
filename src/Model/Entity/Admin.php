<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Admin Entity
 *
 * @property int $admin_id
 * @property string $admin_name
 * @property string $email
 * @property string $password
 * @property string|null $phone_no
 * @property string|null $admin_level
 * @property string|null $profile_image
 * @property \Cake\I18n\DateTime|null $created_at
 */
class Admin extends Entity
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
        'admin_name' => true,
        'email' => true,
        'password' => true,
        'phone_no' => true,
        'admin_level' => true,
        'profile_image' => true,
        'created_at' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'password',
    ];
}
