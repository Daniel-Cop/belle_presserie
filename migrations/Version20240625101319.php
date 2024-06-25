<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625101319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11C7F29C5E237E06 ON article_status (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5373C9665E237E06 ON country (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E5E237E06 ON item (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7CBE75955E237E06 ON material (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B61A1F65E237E06 ON payment_method (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E19D9AD25E237E06 ON service (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_11C7F29C5E237E06 ON article_status');
        $this->addSql('DROP INDEX UNIQ_64C19C15E237E06 ON category');
        $this->addSql('DROP INDEX UNIQ_5373C9665E237E06 ON country');
        $this->addSql('DROP INDEX UNIQ_1F1B251E5E237E06 ON item');
        $this->addSql('DROP INDEX UNIQ_7CBE75955E237E06 ON material');
        $this->addSql('DROP INDEX UNIQ_7B61A1F65E237E06 ON payment_method');
        $this->addSql('DROP INDEX UNIQ_E19D9AD25E237E06 ON service');
    }
}
