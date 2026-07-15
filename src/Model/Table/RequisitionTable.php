<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Requisition Model
 *
 * @property \App\Model\Table\StaffTable&\Cake\ORM\Association\BelongsTo $Staffs
 * @property \App\Model\Table\AdminTable&\Cake\ORM\Association\BelongsTo $Admins
 * @property \App\Model\Table\ItemTable&\Cake\ORM\Association\BelongsToMany $Item
 *
 * @method \App\Model\Entity\Requisition newEmptyEntity()
 * @method \App\Model\Entity\Requisition newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Requisition> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Requisition get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Requisition findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Requisition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Requisition> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Requisition|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Requisition saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Requisition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Requisition>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Requisition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Requisition> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Requisition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Requisition>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Requisition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Requisition> deleteManyOrFail(iterable $entities, array $options = [])
 */
class RequisitionTable extends Table
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

        $this->setTable('requisition');
        $this->setDisplayField('requisition_id');
        $this->setPrimaryKey('requisition_id');

        $this->belongsTo('Staffs', [
            'foreignKey' => 'staff_id',
            'className' => 'Staff',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Admins', [
            'foreignKey' => 'admin_id',
            'className' => 'Admin',
        ]);
        $this->belongsToMany('Item', [
            'foreignKey' => 'requisition_id',
            'targetForeignKey' => 'item_id',
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
            ->integer('staff_id')
            ->notEmptyString('staff_id');

        $validator
            ->integer('admin_id')
            ->allowEmptyString('admin_id');

        $validator
            ->date('request_date')
            ->allowEmptyDate('request_date');

        $validator
            ->date('required_date')
            ->allowEmptyDate('required_date');

        $validator
            ->scalar('purpose')
            ->allowEmptyString('purpose');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->scalar('remarks')
            ->allowEmptyString('remarks');

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
        $rules->add($rules->existsIn(['staff_id'], 'Staffs'), ['errorField' => 'staff_id']);
        $rules->add($rules->existsIn(['admin_id'], 'Admins'), ['errorField' => 'admin_id']);

        return $rules;
    }
}
