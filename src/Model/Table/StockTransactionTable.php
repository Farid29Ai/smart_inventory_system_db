<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StockTransaction Model
 *
 * @property \App\Model\Table\ItemTable&\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\AdminTable&\Cake\ORM\Association\BelongsTo $Admins
 *
 * @method \App\Model\Entity\StockTransaction newEmptyEntity()
 * @method \App\Model\Entity\StockTransaction newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\StockTransaction> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StockTransaction get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\StockTransaction findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\StockTransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\StockTransaction> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StockTransaction|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\StockTransaction saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\StockTransaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\StockTransaction>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\StockTransaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\StockTransaction> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\StockTransaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\StockTransaction>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\StockTransaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\StockTransaction> deleteManyOrFail(iterable $entities, array $options = [])
 */
class StockTransactionTable extends Table
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

        $this->setTable('stock_transaction');
        $this->setDisplayField('transaction_type');
        $this->setPrimaryKey('transaction_id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'className' => 'Item',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Admins', [
            'foreignKey' => 'admin_id',
            'className' => 'Admin',
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
            ->integer('item_id')
            ->notEmptyString('item_id');

        $validator
            ->integer('admin_id')
            ->notEmptyString('admin_id');

        $validator
            ->scalar('transaction_type')
            ->maxLength('transaction_type', 50)
            ->requirePresence('transaction_type', 'create')
            ->notEmptyString('transaction_type')
            ->inList('transaction_type', ['Stock In', 'Stock Out', 'Adjustment'], __('Please select a valid transaction type.'));

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity')
            ->greaterThanOrEqual('quantity', 1, __('Quantity must be at least 1.'));

        $validator
            ->dateTime('transaction_date')
            ->allowEmptyDateTime('transaction_date');

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
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);
        $rules->add($rules->existsIn(['admin_id'], 'Admins'), ['errorField' => 'admin_id']);

        return $rules;
    }
}
