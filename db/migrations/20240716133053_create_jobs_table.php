<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateJobsTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('jobs')
            ->addColumn('queue', 'string', ['length' => 255])
            ->addColumn('payload', 'json')
            ->addColumn('attempts', 'integer', ['default' => 0])
            ->addColumn('available_at', 'integer')
            ->addColumn('created_at', 'datetime')
            ->save();
    }

    public function down(): void
    {
        $this->table('jobs')->drop()->save();
    }
}
