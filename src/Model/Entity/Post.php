<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $post_id
 * @property string $message
 * @property string $nickname
 * @property int $topic_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $ip
 *
 * @property \App\Model\Entity\Topic $topic
 */
class Post extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'message' => true,
        'nickname' => true,
        'topic_id' => true,
        'created' => true,
        'modified' => true,
        'ip' => true,
        'topic' => true
    ];
}
