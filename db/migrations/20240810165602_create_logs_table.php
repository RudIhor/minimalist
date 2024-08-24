<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateLogsTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('logs')
            ->addColumn('chat_id', 'biginteger')
            ->addColumn('data', 'json')
            ->addForeignKey('chat_id', 'users', 'chat_id', ['delete' => 'cascade'])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->save();
    }

    public function down(): void
    {
        $this->table('logs')->drop()->save();
    }
}
