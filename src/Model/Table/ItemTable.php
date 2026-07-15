<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Item Model
 *
 * @property \App\Model\Table\CategoryTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\VendorTable&\Cake\ORM\Association\BelongsTo $Vendors
 * @property \App\Model\Table\RequisitionTable&\Cake\ORM\Association\BelongsToMany $Requisition
 *
 * @method \App\Model\Entity\Item newEmptyEntity()
 * @method \App\Model\Entity\Item newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Item> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Item findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Item> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Item>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Item>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Item>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Item> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Item>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Item>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Item>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Item> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ItemTable extends Table
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

        $this->setTable('item');
        $this->setDisplayField('item_name');
        $this->setPrimaryKey('item_id');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'className' => 'Category',
        ]);
        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
            'className' => 'Vendor',
        ]);
        $this->belongsToMany('Requisition', [
            'foreignKey' => 'item_id',
            'targetForeignKey' => 'requisition_id',
            'joinTable' => 'requisition_item',
        ]);
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
            ->scalar('item_name')
            ->maxLength('item_name', 100)
            ->requirePresence('item_name', 'create')
            ->notEmptyString('item_name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('category_id')
            ->allowEmptyString('category_id');

        $validator
            ->integer('vendor_id')
            ->allowEmptyString('vendor_id');

        $validator
            ->integer('quantity_available')
            ->allowEmptyString('quantity_available');

        $validator
            ->integer('minimum_stock')
            ->allowEmptyString('minimum_stock');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 50)
            ->allowEmptyString('unit');

        $validator
            ->scalar('item_image')
            ->maxLength('item_image', 255)
            ->allowEmptyFile('item_image');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['category_id'], 'Categories'), ['errorField' => 'category_id']);
        $rules->add($rules->existsIn(['vendor_id'], 'Vendors'), ['errorField' => 'vendor_id']);

        return $rules;
    }
}
