<?php

namespace Spatie\DbSnapshots\Commands;

use Illuminate\Console\Command;
use Spatie\DbSnapshots\Snapshot;
use Spatie\DbSnapshots\Helpers\Format;
use Spatie\DbSnapshots\SnapshotRepository;

class ListSnapshots extends Command
{
    protected $signature = 'snapshot:list';

    protected $description = 'List all the snapshots.';

    public function handle()
    {
        $snapshots = app(SnapshotRepository::class)->getAll();

        $rows = $snapshots->map(function (Snapshot $snapshot) {
            return [
                $snapshot->name,
                $snapshot->createdAt()->format('Y-m-d H:i:s'),
                Format::humanReadableSize($snapshot->size()),
            ];
        });

        $this->table(['Name', 'Created at', 'Size'], $rows);
    }
}
