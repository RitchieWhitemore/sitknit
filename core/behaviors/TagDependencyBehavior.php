<?php

namespace app\core\behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use yii\di\Instance;

/**
 * Class TagDependencyBehavior
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'TagDependencyBehavior' => TagDependencyBehavior::class,
 *     ];
 * }
 * ```
 *
 * use
 *
 * ```php
 * $dependency = new TagDependency([
 *      'tags' => [
 *          Model::class,
 *      ],
 * ]);
 * ```
 *
 */
class TagDependencyBehavior extends Behavior
{
    /**
     * @var string
     */
    public $cache = 'cache';

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'invalidate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'invalidate',
            ActiveRecord::EVENT_AFTER_DELETE => 'invalidate',
        ];
    }

    public function invalidate(Event $event)
    {
        $sender = $event->sender;

        /** @var Cache $cache */
        $cache = Instance::ensure($this->cache, Cache::class);
        TagDependency::invalidate($cache, [$sender::className()]);
    }
}
