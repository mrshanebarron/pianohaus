<?php

namespace App\Services;

use App\Exceptions\InvalidStatusTransitionException;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StatusTransitionService
{
    public function canTransition(string $entity, string $from, string $to): bool
    {
        $transitions = config("piano_statuses.{$entity}", []);
        return in_array($to, $transitions[$from] ?? []);
    }

    public function allowedTransitions(string $entity, string $from): array
    {
        return config("piano_statuses.{$entity}.{$from}", []);
    }

    public function transition(Model $model, string $newStatus, ?int $userId = null): void
    {
        $entity = strtolower(class_basename($model));
        $oldStatus = $model->status;

        if (!$this->canTransition($entity, $oldStatus, $newStatus)) {
            throw new InvalidStatusTransitionException(
                ucfirst($entity) . " cannot transition from '{$oldStatus}' to '{$newStatus}'."
            );
        }

        DB::transaction(function () use ($model, $newStatus, $oldStatus, $userId) {
            $model->update(['status' => $newStatus]);

            ActivityLog::log(
                $model,
                'status_changed',
                "Status changed from {$oldStatus} to {$newStatus}",
                ['old' => $oldStatus, 'new' => $newStatus]
            );
        });
    }
}
