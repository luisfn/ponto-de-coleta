<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240507211100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename verified column to is_verified in user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE verified is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE is_verified verified TINYINT(1) NOT NULL');
    }
}
