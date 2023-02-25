<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130154254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE transport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, number_street INT NOT NULL, name_street VARCHAR(255) NOT NULL, local_code INT NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE payment (id INT NOT NULL, num_card INT NOT NULL, name_card VARCHAR(255) NOT NULL, date_limit DATE NOT NULL, crypto_num INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transport (id INT NOT NULL, label VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, mode VARCHAR(255) DEFAULT NULL, name_transporter VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE art DROP CONSTRAINT fk_fc35d6549777d11e');
        $this->addSql('DROP INDEX idx_fc35d6549777d11e');
        $this->addSql('ALTER TABLE art RENAME COLUMN category_id_id TO category_id');
        $this->addSql('ALTER TABLE art ADD CONSTRAINT FK_FC35D65412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FC35D65412469DE2 ON art (category_id)');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f52993981ffd30f4');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f52993989d86650f');
        $this->addSql('DROP INDEX idx_f52993989d86650f');
        $this->addSql('DROP INDEX idx_f52993981ffd30f4');
        $this->addSql('ALTER TABLE "order" ADD art_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP art_id_id');
        $this->addSql('ALTER TABLE "order" DROP user_id_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993988C25E51A FOREIGN KEY (art_id) REFERENCES art (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F52993988C25E51A ON "order" (art_id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON "order" (user_id)');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN num_card TO address_id');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649F5B7AF75 ON "user" (address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649F5B7AF75');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE transport_id_seq CASCADE');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE transport');
        $this->addSql('ALTER TABLE art DROP CONSTRAINT FK_FC35D65412469DE2');
        $this->addSql('DROP INDEX IDX_FC35D65412469DE2');
        $this->addSql('ALTER TABLE art RENAME COLUMN category_id TO category_id_id');
        $this->addSql('ALTER TABLE art ADD CONSTRAINT fk_fc35d6549777d11e FOREIGN KEY (category_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fc35d6549777d11e ON art (category_id_id)');
        $this->addSql('DROP INDEX IDX_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN address_id TO num_card');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993988C25E51A');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F52993988C25E51A');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395');
        $this->addSql('ALTER TABLE "order" ADD art_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP art_id');
        $this->addSql('ALTER TABLE "order" DROP user_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f52993981ffd30f4 FOREIGN KEY (art_id_id) REFERENCES art (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f52993989d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f52993989d86650f ON "order" (user_id_id)');
        $this->addSql('CREATE INDEX idx_f52993981ffd30f4 ON "order" (art_id_id)');
    }
}
