<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502152438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_orders DROP FOREIGN KEY FK_631C76C4DE18E50B');
        $this->addSql('ALTER TABLE products_orders DROP FOREIGN KEY FK_631C76C4FCDAEAAA');
        $this->addSql('DROP INDEX IDX_631C76C4FCDAEAAA ON products_orders');
        $this->addSql('DROP INDEX IDX_631C76C4DE18E50B ON products_orders');
        $this->addSql('ALTER TABLE products_orders ADD order_id INT NOT NULL, ADD product_id INT NOT NULL, DROP order_id_id, DROP product_id_id');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C48D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C44584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_631C76C48D9F6D38 ON products_orders (order_id)');
        $this->addSql('CREATE INDEX IDX_631C76C44584665A ON products_orders (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_orders DROP FOREIGN KEY FK_631C76C48D9F6D38');
        $this->addSql('ALTER TABLE products_orders DROP FOREIGN KEY FK_631C76C44584665A');
        $this->addSql('DROP INDEX IDX_631C76C48D9F6D38 ON products_orders');
        $this->addSql('DROP INDEX IDX_631C76C44584665A ON products_orders');
        $this->addSql('ALTER TABLE products_orders ADD order_id_id INT NOT NULL, ADD product_id_id INT NOT NULL, DROP order_id, DROP product_id');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C4DE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C4FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES orders (id)');
        $this->addSql('CREATE INDEX IDX_631C76C4FCDAEAAA ON products_orders (order_id_id)');
        $this->addSql('CREATE INDEX IDX_631C76C4DE18E50B ON products_orders (product_id_id)');
    }
}
