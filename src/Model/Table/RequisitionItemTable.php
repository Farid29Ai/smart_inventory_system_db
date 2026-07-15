<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RequisitionItem Model
 *
 * @property \App\Model\Table\RequisitionTable&\Cake\ORM\Association\BelongsTo $Requisitions
 * @property \App\Model\Table\ItemTable&\Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\RequisitionItem newEmptyEntity()
 * @method \App\Model\Entity\RequisitionItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RequisitionItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RequisitionItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RequisitionItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RequisitionItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RequisitionItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RequisitionItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RequisitionItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RequisitionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RequisitionItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RequisitionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RequisitionItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RequisitionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RequisitionItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RequisitionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RequisitionItem> deleteManyOrFail(iterable $entities, array $options = [])
 */
class RequisitionItemTable extends Table
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

        $this->setTable('requisition_item');
        $this->setDisplayField('requisition_item_id');
        $this->setPrimaryKey('requisition_item_id');

        $this->belongsTo('Requisitions', [
            'foreignKey' => 'requisition_id',
            'className' => 'Requisition',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'className' => 'Item',
            'joinType' => 'INNER',
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
            ->integer('requisition_id')
            ->notEmptyString('requisition_id');

        $validator
            ->integer('item_id')
            ->notEmptyString('item_id');

        $validator
            ->integer('quantity_requested')
            ->requirePresence('quantity_requested', 'create')
            ->notEmptyString('quantity_requested')
            ->greaterThanOrEqual('quantity_requested', 1, __('Quantity requested must be at least 1.'));

        $validator
            ->integer('quantity_approved')
            ->allowEmptyString('quantity_approved');

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
        $rules->add($rules->existsIn(['requisition_id'], 'Requisitions'), ['errorField' => 'requisition_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
