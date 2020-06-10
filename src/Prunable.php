<?php


namespace CodencoDev\LaravelEloquentPruning;


use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;

trait Prunable
{

//    private ?string $pruningColumn = null;
//    private ?int $hours = null;
//    private ?int $chunkSize = null;
//    private ?bool $withDeleteEvents = null;

    /**
     * Get the base column for pruning
     */
    public function getPruningColumn(): string
    {
        return $this->pruningColumn ?? config('laravel-eloquent-pruning.pruning_column', 'created_at');
    }

    /**
     * Set the base column for pruning
     */
    public function setPruningColumn(string $pruningColumn): self
    {
        $this->pruningColumn = $pruningColumn;
        return $this;
    }

    /**
     * Get the number of hours for a record to be considered old
     */
    public function getHours(): int
    {
        return $this->hours ?? config('laravel-eloquent-pruning.hours', 24);
    }

    /**
     * Set the number of hours for a record to be considered old
     */
    public function setHours(int $hours): self
    {
        $this->hours = $hours;
        return $this;
    }


    /**
     * Get the count of records delete in one time
     */
    public function getChunkSize(): int
    {
        return $this->chunkSize ?? config('laravel-eloquent-pruning.chunk_size', 100);
    }

    /**
     * Set the count of records delete in one time
     */
    public function setChunkSize(int $chunkSize): self
    {
        $this->chunkSize = $chunkSize;
        return $this;
    }


    /**
     * Define if the active record can be pruned, if the ProcessWithDeleteEvents is true
     */
    public function canBePruned(): bool
    {
        return true;
    }


    /**
     * Scope that allows filter records for pruning
     */
    public function scopeCouldBePruned(Builder $query): Builder
    {
        return $query;
    }

    /**
     * Set then withDeleteEvent attribute for model
     */
    public function setWithDeleteEvents(bool $withDeleteEvents): self
    {
        $this->withDeleteEvents = $withDeleteEvents;
        return $this;
    }

    /**
     * Get then withDeleteEvent attribute for model
     */
    public function getWithDeleteEvents(): bool
    {
        return $this->withDeleteEvents ?? config('laravel-eloquent-pruning.with_delete_events', false);
    }

    /**
     * Get if the process must run with query or model
     */
    public function ProcessWithDeleteEvents(): bool
    {
        return $this->getWithDeleteEvents();
    }

    /**
     * Start deleting items that are too old
     */
    public function prune(DateTimeInterface $before = null): int
    {
        if (is_null($before)) {
            $before = Date::now()->subHours($this->getHours());
        }
        $query = $this->couldBePruned()->where($this->getPruningColumn(), '<', $before);
        $totalDeleted = 0;
        if ($this->ProcessWithDeleteEvents()) {
            foreach ($query->cursor() as $prunable) {
                if ($prunable->canBePruned()) {
                    $prunable->delete();
                    $totalDeleted++;
                }
            }
        } else {
            $totalDeleted = 0;
            do {
                $deleted = $query->take($this->getChunkSize())->delete();
                $totalDeleted += $deleted;
            } while ($deleted !== 0);
        }


        return $totalDeleted;
    }
}