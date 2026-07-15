<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vendor Model
 *
 * @method \App\Model\Entity\Vendor newEmptyEntity()
 * @method \App\Model\Entity\Vendor newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Vendor> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vendor get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Vendor findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Vendor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Vendor> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vendor|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Vendor saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Vendor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Vendor>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Vendor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Vendor> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Vendor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Vendor>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Vendor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Vendor> deleteManyOrFail(iterable $entities, array $options = [])
 */
class VendorTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('vendor');
        $this->setDisplayField('vendor_name');
        $this->setPrimaryKey('vendor_id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('vendor_name')
            ->maxLength('vendor_name', 100)
            ->requirePresence('vendor_name', 'create')
            ->notEmptyString('vendor_name');

        $validator
            ->scalar('contact_person')
            ->maxLength('contact_person', 100)
            ->allowEmptyString('contact_person');

        $validator
            ->scalar('phone_no')
            ->maxLength('phone_no', 20)
            ->allowEmptyString('phone_no');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        return $validator;
    }
}
