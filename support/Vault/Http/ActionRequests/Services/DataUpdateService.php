<?php

namespace Support\Vault\Http\ActionRequests\Services;

use Carbon\Carbon;
use Support\Vault\Database\DB;
use Support\Vault\Sanctum\Log;

class DataUpdateService
{
    public function handle(array $payload, string $user)
    {
        foreach ($payload as $p) {
            match ($p['action']) {
                'update' => $this->update($p),
                'insert' => $this->insert($p),
                'delete' => $this->delete($p),
            };
            Log::info('Data updated', [
                'table' => $p['table'],
                'row_where' => $p['where'],
                'data' => $p['data'],
                'approved_by' => $user,
                'time' => Carbon::now(),
            ]);
        }
    }

    protected function update(array $p)
    {
        DB::table($p['table'])
            ->where($p['where'])
            ->update($p['data']);
    }
    protected function insert(array $p)
    {
        DB::table($p['table'])
            ->insert($p['data']);
    }
    protected function delete(array $p)
    {
        DB::table($p['table'])
            ->where($p['where'])
            ->delete();
    }
}
