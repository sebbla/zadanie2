<?php

namespace Sebbla\PostBundle\Model\Listeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Sebbla\PostBundle\Entity\Post;

/**
 * Post subscriber.
 */
class PostSubscriber implements EventSubscriber
{

    /**
     * Images dir path.
     * 
     * @var string
     */
    private $imagesDir;

    public function __construct($kernelRootDir, $imagesDir)
    {
        $this->imagesDir = $kernelRootDir . DIRECTORY_SEPARATOR . '..' . $imagesDir;
    }

    /**
     * Subscribed events.
     * 
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
            'postPersist',
            'postUpdate',
            'postRemove'
        );
    }

    /**
     * Checking if entity is instance of class Post.
     * 
     * @param  mixed $entity
     * @return boolean
     */
    private function isPostEntity($entity)
    {
        return $entity instanceof Post ? true : false;
    }

    /**
     * Pre persist.
     * 
     * @param  LifecycleEventArgs $args
     * @return mixed
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$this->isPostEntity($entity)) {
            return;
        }

        if (null !== $entity->getImage()) {
            $filename = substr(\md5(\time()), 0, 10);
            $entity->setFile($filename . '.' . $entity->getImage()->guessExtension());
        }
    }

    /**
     * Pre update.
     * 
     * @param  LifecycleEventArgs $args
     * @return [mixed
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->prePersist($args);
    }

    /**
     * Post persist.
     * 
     * @param  LifecycleEventArgs $args
     * @return mixed
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$this->isPostEntity($entity) || null === $entity->getImage()) {
            return;
        }

        // Moving file to selected location
        $entity->getImage()->move($this->getUploadImagesDir(), $entity->getFile());

        // If there is old file, remove it
        $previusFile = $entity->getPreviousFile();
        if (isset($previusFile)) {
            unlink($this->getUploadImagesDir() . '/' . $entity->getPreviousFile());
            $entity->setPreviousFile(null);
        }
        $entity->setImage(null);
    }

    /**
     * Post update.
     * 
     * @param  LifecycleEventArgs $args
     * @return mixed
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->postPersist($args);
    }

    /**
     * Post remove.
     * 
     * @param  LifecycleEventArgs $args
     * @return mixed
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$this->isPostEntity($entity)) {
            return;
        }

        if ($file = $entity->getFile()) {
            unlink($this->getUploadImagesDir() . '/' . $file);
        }
    }

    /**
     * Returning images dir.
     * 
     * @return string
     */
    protected function getUploadImagesDir()
    {
        return $this->imagesDir;
    }

}
