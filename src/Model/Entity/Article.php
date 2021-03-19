<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;

class Article extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'slug' => false,
        'tag_string' => true,
    ];

    protected function _getTagString()
    {
        if ( isset($this->_fields['tag_string']) ) {
            return $this->_fields['tag_string'];
        }
        if ( empty($this->tags) ) return '';
        $tags = new Collection($this->tags);
        return implode(', ', $tags->map(fn($tag)=>$tag->title)->toArray());
    }
}
