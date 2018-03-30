<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Posts Model
 *
 * @property \App\Model\Table\TopicsTable|\Cake\ORM\Association\BelongsTo $Topics
 *
 * @method \App\Model\Entity\Post get($primaryKey, $options = [])
 * @method \App\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('posts');
        $this->setDisplayField('post_id');
        $this->setPrimaryKey('post_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Topics', [
            'foreignKey' => 'topic_id'
        ]);

        $this->db = ConnectionManager::get('default');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('post_id')
            ->allowEmpty('post_id', 'create');

        $validator
            ->scalar('message')
            ->notEmpty('message', 'Please fill this field');

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 256)
            ->notEmpty('nickname', 'Please fill this field');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 15)
            ->allowEmpty('ip');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['topic_id'], 'Topics'));

        return $rules;
    }

    public function getPosts($topic_id, $paginate)
    {
        $limit = $paginate['limit'];
        $page = $paginate['page'] == 0 ? 1 : $paginate['page'];
        $offset = $page * $limit - $limit;

        $query = "SELECT posts.nickname, topics.topic_id, message, posts.post_id, posts.created, posts.ip
        FROM topics
        LEFT JOIN posts on posts.topic_id = topics.topic_id
        WHERE topics.topic_id = '".$topic_id."' 
        LIMIT $offset, $limit";

        $result['result'] = $this->db->execute($query)->fetchAll('obj');
        $result['total'] = $this->db->execute("SELECT FOUND_ROWS() as total ")->fetch('obj')->total;
        $result['pageCount'] = ceil($result['total']/ $limit); 
        $result['limit'] = $limit;
        $result['page'] = $page;

        return $result;
    }
}
