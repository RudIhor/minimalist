<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ChangeTitleColumnTypeInTasksTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $this->table('tasks')
            ->changeColumn('title', 'text')
            ->save();
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->table('tasks')
            ->changeColumn('title', 'string')
            ->save();
    }
}
