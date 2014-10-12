<?php

namespace Sebbla\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="sebbla_post")
 * @ORM\Entity(repositoryClass="Sebbla\PostBundle\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Post
{

    const POST_ARCHIVAL = 'archiwalny';
    const POST_NEW = 'nowy';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="validation.post.name.notblank")
     * @Assert\Length(
     *      min=3, 
     *      max=50, 
     *      minMessage="validation.post.name.length.min", 
     *      maxMessage="validation.post.name.length.max"
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="text", length=50000, nullable=false)
     * @Assert\NotBlank(
     *      message="validation.post.text.notblank",
     *      groups="Default"
     * )
     * @Assert\Length(
     *      min=3, 
     *      max=50000, 
     *      minMessage="validation.post.text.length.min", 
     *      maxMessage="validation.post.text.length.max"
     * )
     */
    protected $text;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    protected $file;

    /**
     * @Assert\Image(
     *      maxSize="2M",
     *      mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg"
     *      },
     *      mimeTypesMessage="validation.post.image.mimetypes",
     *      maxSizeMessage="validation.post.image.maxsize"
     * )
     */
    protected $image;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Choice(
     *      groups="Default",
     *      callback="getPostTypes",
     *      message="validation.post.type.choices"
     * )
     */
    protected $type;

    /**
     * Previous file name
     * @var mixed
     */
    protected $previousFile;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Post
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Post
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set file
     *
     * @param string $file
     * @return Post
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Setting post type.
     * 
     * @param string
     */
    public function setType($type)
    {
        if (!\in_array($type, array(self::POST_ARCHIVAL, self::POST_NEW))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->type = $type;
    }

    /**
     * Returning available post types.
     * 
     * @return array
     */
    public static function getPostTypes()
    {
        return array(
            self::POST_ARCHIVAL => self::POST_ARCHIVAL,
            self::POST_NEW => self::POST_NEW
        );
    }

    /**
     * Set image
     *
     * @param UploadedFile $image
     * @return Post
     */
    public function setImage(UploadedFile $image = null)
    {
        $this->image = $image;
        if (isset($this->file)) {
            $this->previousFile = $this->file;
            $this->file = null;
        } else {
            $this->file = 'default';
        }

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Returning previous file name
     * @return mixed
     */
    public function getPreviousFile()
    {
        return $this->previousFile;
    }

    /**
     * Setting previous file name.
     * 
     * @param mixed $previousFile
     */
    public function setPreviousFile($previousFile)
    {
        $this->previousFile = $previousFile;

        return $this;
    }

}
