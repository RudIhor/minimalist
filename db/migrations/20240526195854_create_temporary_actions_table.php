<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTemporaryActionsTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $this->table('temporary_actions')
            ->addColumn('chat_id', 'biginteger', ['signed' => false])
            ->addColumn('data', 'json')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex('chat_id', ['unique' => true])
            ->save();
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->table('temporary_actions')->drop()->save();
    }
}
