<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241006130449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_vehicle_like (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, vehicle_id INT NOT NULL, INDEX IDX_5E320FEDA76ED395 (user_id), INDEX IDX_5E320FED545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_vehicle_like ADD CONSTRAINT FK_5E320FEDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_vehicle_like ADD CONSTRAINT FK_5E320FED545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_vehicle_like DROP FOREIGN KEY FK_5E320FEDA76ED395');
        $this->addSql('ALTER TABLE user_vehicle_like DROP FOREIGN KEY FK_5E320FED545317D1');
        $this->addSql('DROP TABLE user_vehicle_like');
    }
}
