<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Utility\Text;
use Cake\Event\EventInterface;
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    public function initialize(array $config) : void
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags');
    }

    public function beforeSave(EventInterface $event, $entity, $options)
    {
        if ( $entity->isNew() && !$entity->slug ) {
            $sluggedTitle = Text::slug($entity->title);
            $entity->slug = substr($sluggedTitle, 0, 191);
            // TODO: slug should be unique
            // TODO: make 191 constant?
        }
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('title')
            ->minLength('title', 10)
            ->maxLength('title', 255)
            ->notEmptyString('body')
            ->minLength('body', 10);
        return $validator;
    }

    public function findTagged(Query $query, array $options)
    {
        $columns = [
            'Articles.id', 'Articles.user_id', 'Articles.title',
            'Articles.body', 'Articles.published', 'Articles.created',
            'Articles.slug',
        ];
        $query = $query->select($columns)
                       ->distinct($columns);
        if ( empty($options['tags']) ) {
            $query->leftJoinWith('Tags')->where(['Tags.title IS'=>null]);
        } else {
            $query->leftJoinWith('Tags')->where(['Tags.title IN'=>$options['tags']]);
        }
        return $query->group(['Articles.id']);
    }
}

