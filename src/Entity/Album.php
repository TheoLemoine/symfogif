<?php


namespace App\Entity;

use App\Entity\User;
use App\Entity\Traits\EntityTrait;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
{

    use EntityTrait;
    use TimestampableEntity;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(max=80)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gif", mappedBy="album")
     */
    private $gifs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="albums")
     */
    private $author;

    public function __construct()
    {
        $this->gifs = new ArrayCollection();
    }

    /**
     * @return Collection|Gif[]
     */
    public function getGifs(): Collection
    {
        return $this->gifs;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return self
     */
    public function setAuthor($author): self
    {
        $this->author = $author;
        return $this;
    }

}