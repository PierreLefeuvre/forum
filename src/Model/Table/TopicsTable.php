<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Topics Model
 *
 * @method \App\Model\Entity\Topic get($primaryKey, $options = [])
 * @method \App\Model\Entity\Topic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Topic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Topic|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Topic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Topic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Topic findOrCreate($search, callable $callback = null, $options = [])
 */
class TopicsTable extends Table
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

        $this->setTable('topics');
        $this->setDisplayField('title');
        $this->setPrimaryKey('topic_id');

        $this->addBehavior('Timestamp');

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
            ->integer('topic_id')
            ->allowEmpty('topic_id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 256)
            ->allowEmpty('title');

        return $validator;
    }

    public function getTopics($paginate)
    {
        $limit = $paginate['limit'];
        $page = $paginate['page'] == 0 ? 1 : $paginate['page'];
        $offset = $page * $limit - $limit;

        $query = "
        SELECT SQL_CALC_FOUND_ROWS topics.*, nickname , ip
        FROM topics 
        JOIN posts on posts.post_id = (
            SELECT post_id 
            FROM posts 
            WHERE posts.topic_id = topics.topic_id 
            ORDER BY post_id 
            LIMIT 1
        ) LIMIT $offset, $limit";

        $result['result'] = $this->db->execute($query)->fetchAll('obj');
        $result['total'] = $this->db->execute("SELECT FOUND_ROWS() as total ")->fetch('obj')->total;
        $result['pageCount'] = ceil($result['total']/ $limit); 
        $result['limit'] = $limit;
        $result['page'] = $page;
        
        return $result;
    }

    public function getTopic($topic_id)
    {
        $query = "SELECT topic_id, title 
        FROM topics
        WHERE topics.topic_id = '".$topic_id."' ";

        return $this->db->execute($query)->fetch('obj');
    }
}
