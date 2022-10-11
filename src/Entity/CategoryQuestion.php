<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryQuestion
 *
 * @ORM\Table(name="category_question", indexes={@ORM\Index(name="status_id", columns={"status_id"}), @ORM\Index(name="question_type_id", columns={"question_type_id"}), @ORM\Index(name="question_id", columns={"question_id"}), @ORM\Index(name="category_id", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\CategoryQuestionRepository")
 */
class CategoryQuestion
{
    const CATEGORY_QUESTION_INPUT_TEXT = 1;
    const CATEGORY_QUESTION_INPUT_NUMBER = 2;
    const CATEGORY_QUESTION_SELECT = 3;
    const CATEGORY_QUESTION_INPUT_RADIO = 4;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $position;

    /**
     * @var bool
     *
     * @ORM\Column(name="required", type="boolean", nullable=false, options={"default"="1"})
     */
    private $required = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="values_entity", type="string", length=50, nullable=true)
     */
    private $valuesEntity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="values_entity_dependence", type="string", length=50, nullable=true)
     */
    private $valuesEntityDependence;

    /**
     * @var string|null
     *
     * @ORM\Column(name="placeholder", type="string", length=50, nullable=true)
     */
    private $placeholder;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \Status
     *
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var \QuestionType
     *
     * @ORM\ManyToOne(targetEntity="QuestionType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question_type_id", referencedColumnName="id")
     * })
     */
    private $questionType;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     * })
     */
    private $question;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function isRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function getValuesEntity(): ?string
    {
        return $this->valuesEntity;
    }

    public function setValuesEntity(?string $valuesEntity): self
    {
        $this->valuesEntity = $valuesEntity;

        return $this;
    }

    public function getValuesEntityDependence(): ?string
    {
        return $this->valuesEntityDependence;
    }

    public function setValuesEntityDependence(?string $valuesEntityDependence): self
    {
        $this->valuesEntityDependence = $valuesEntityDependence;

        return $this;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(?string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getQuestionType(): ?QuestionType
    {
        return $this->questionType;
    }

    public function setQuestionType(?QuestionType $questionType): self
    {
        $this->questionType = $questionType;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


}
