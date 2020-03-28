<?php


namespace App\Entity;


use App\Entity\Traits\EntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\Album;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GifRepository")
 * @Gedmo\SoftDeleteable
 */
class Gif
{

    use EntityTrait;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    private $tags;

    /**
     * @var Album
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="gifs")
     */
    private $album;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="gifs")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favoriteGifs")
     */
    private $fans;

    public function __construct()
    {
        $this->fans = new ArrayCollection();
    }

    /**
     * @return Album|null
     */
    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    /**
     * @param Album $album
     * @return self
     */
    public function setAlbum(Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return explode(',', $this->tags);
    }

    /**
     * @param string $tags
     * @return self
     */
    public function setTags(string $tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $user
     * @return Gif
     */
    public function setAuthor(User $user): Gif
    {
        $this->author = $user;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFans(): ArrayCollection
    {
        return $this->fans;
    }
}