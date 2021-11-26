<?php

namespace App\Entity;

class BugReport extends Entity
{
    private $id;
    private $report_type;
    private $message;
    private $link;
    private $email;
    private $created_at;

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function setReportType(string $reportType)
    {
        $this->report_type = $reportType;
        return $this;
    }

    public function getReportType(): string
    {
        return $this->report_type;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function toArray(): array
    {
        return [
            'report_type' => $this->getReportType(),
            'email' => $this->getEmail(),
            'message' => $this->getMessage(),
            'link' => $this->getLink(),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }



    /**
     * Get the value of message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of link
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * Set the value of link
     *
     * @return  self
     */
    public function setLink(?string $link)
    {
        $this->link = $link;

        return $this;
    }
}
