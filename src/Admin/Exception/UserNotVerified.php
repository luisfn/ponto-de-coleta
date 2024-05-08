<?php

declare(strict_types=1);

namespace Admin\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class UserNotVerified extends AuthenticationException
{
    private ?string $identifier = null;

    public function getMessageKey(): string
    {
        return 'User not verified.';
    }

    /**
     * Get the user identifier (e.g. username or email address).
     */
    public function getUserIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * Set the user identifier (e.g. username or email address).
     */
    public function setUserIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getMessageData(): array
    {
        return ['{{ username }}' => $this->identifier, '{{ user_identifier }}' => $this->identifier];
    }

    public function __serialize(): array
    {
        return [$this->identifier, parent::__serialize()];
    }

    public function __unserialize(array $data): void
    {
        [$this->identifier, $parentData] = $data;
        $parentData = \is_array($parentData) ? $parentData : unserialize($parentData);
        parent::__unserialize($parentData);
    }
}