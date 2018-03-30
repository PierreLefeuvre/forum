<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Collection\Collection;

/**
 * Topic Controller
 *
 *
 * @method \App\Model\Entity\Topic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TopicController extends AppController
{
    var $topicsTable;
    var $postsTable;
    public $paginate = [
        'limit' => 10
    ];

    function initialize(){
        parent::initialize();
        $this->topicsTable = TableRegistry::get('Topics');
        $this->postsTable = TableRegistry::get('Posts');
        $this->loadComponent('Paginator');

        $this->paginate['page'] = $this->request->getQuery('page');
    }

    public function index()
    {
        $results = $this->topicsTable->getTopics($this->paginate);
        $this->set('topics', $results);
        $this->render('/Forum/index');
    }

    public function viewTopic($id = null)
    {
        //Récupération du topic
        $result = $this->topicsTable->getTopic($id);
        $this->set('topic', $result);

        //récupération des posts
        $this->paginate['limit'] = 20;
        $result = $this->postsTable->getPosts($id, $this->paginate);
        $this->set('posts', $result);
        $this->set('post_id', $id);

        $this->render('/Forum/view');
    }
    public function createTopic()
    {
        $this->render('/Forum/create');
    }
    public function addPost()
    {
        if ($this->request->is('post')) {

            $postData = $this->request->getData();
            $postData['ip'] = $_SERVER['REMOTE_ADDR'];

            $this->request->session()->write('user.nickname', $postData['nickname']);
            
            $posts = $this->postsTable->newEntity($postData);

            $okP = $this->postsTable->save($posts);

            if ($okP) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['_name' => 'viewTopic', 'id' => $postData['topic_id']]);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        return $this->redirect(['_name' => 'addPost']);
    }
    public function addTopic()
    {
        if ($this->request->is('post')) {
          
            $postData = $this->request->getData();

            //$collection = new Collection($this->request->getData());
            // $topics = $collection->filter(function($value, $key, $iterator){
            //     return in_array($key, ['title']);
            // });

            $topics = $this->topicsTable->newEntity($this->request->getData());

            $okT = $this->topicsTable->save($topics);
            
            $postData = $this->request->getData();
            $postData['ip'] =  $_SERVER['REMOTE_ADDR'];
            $postData['topic_id'] = $topics->topic_id;

            $posts = $this->postsTable->newEntity($postData);

            $okP = $this->postsTable->save($posts);
            
            if ($okP && $okT) {
                $this->Flash->success(__('The topic has been saved.'));
                return $this->redirect(['_name' => 'viewTopic', $topics->topic_id]);
            }
            $this->Flash->error(__('The topic could not be saved. Please, try again.'));
        }
        return $this->redirect(['_name' => 'createTopic']);
    }

    public function editPost($post_id, $topic_id )
    {
        $post = $this->postsTable
            ->find()
            ->where(['topic_id' => $topic_id, 'post_id' => $post_id, 'ip' => $_SERVER['REMOTE_ADDR']])
            ->first();

        if(!$post){
            $this->Flash->error(__('Failed data recovery. Please, try again.'));
            return $this->redirect(['_name' => 'viewTopic', $topic_id]);
        }

        if ($this->request->is(['patch', 'post', 'put']) && $post) {
            $post = $this->postsTable->patchEntity($post, $this->request->getData());
            if ($this->postsTable->save($post)) {
                $this->Flash->success(__('The topic has been saved.'));

                return $this->redirect(['_name' => 'viewTopic', $topic_id]);
            }
            $this->Flash->error(__('The topic could not be saved. Please, try again.'));
        }
        $this->set(compact('post'));
        $this->render('/Forum/edit/');
    }

    /**
     * Delete method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteTopic($topic_id = null)
    {
        $this->request->allowMethod(['GET','post', 'delete']);

        $this->topicsTable->newEntity();

        $post = $this->postsTable
        ->find('all',['fields'=>'ip'])
        ->where(['topic_id' => $topic_id])
        ->order(['created' => 'ASC'])
        ->first();

        if($post->ip != $_SERVER['REMOTE_ADDR']){
            $this->flash->error(_('You are not allowed to delete this.'));
            return $this->redirect(['_name' => 'indexForum']); 
        }

        $topic = $this->topicsTable->get($topic_id);

        if ($this->topicsTable->delete($topic)) {
            $this->Flash->success(__('The topic has been deleted.'));
        } else {
            $this->Flash->error(__('The topic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['_name' => 'indexForum']);
    }
}