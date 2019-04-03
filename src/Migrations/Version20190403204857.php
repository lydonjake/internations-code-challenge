<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190403204857 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users_groups (users_id INT NOT NULL, groups_id INT NOT NULL, INDEX IDX_FF8AB7E067B3B43D (users_id), INDEX IDX_FF8AB7E0F373DCF (groups_id), PRIMARY KEY(users_id, groups_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E067B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0F373DCF FOREIGN KEY (groups_id) REFERENCES groups (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE groups_users');
        $this->addSql('DROP TABLE user_group');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE groups_users (groups_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_4520C24D67B3B43D (users_id), INDEX IDX_4520C24DF373DCF (groups_id), PRIMARY KEY(groups_id, users_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_group (users_id INT NOT NULL, groups_id INT NOT NULL, INDEX IDX_8F02BF9DF373DCF (groups_id), INDEX IDX_8F02BF9D67B3B43D (users_id), PRIMARY KEY(users_id, groups_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE groups_users ADD CONSTRAINT FK_4520C24D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groups_users ADD CONSTRAINT FK_4520C24DF373DCF FOREIGN KEY (groups_id) REFERENCES groups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DF373DCF FOREIGN KEY (groups_id) REFERENCES groups (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE users_groups');
    }
}
