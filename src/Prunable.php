<?php


namespace CodencoDev\LaravelEloquentPruning;


use Illuminate\Support\Facades\Date;

trait Prunable
{

    /**
     * Get the base column for pruning
     */
    public function getPruningColumn(): string
    {
        if(property_exists($this,'pruningColumn')){
            return $this->pruningColumn;
        }

        return config('laravel-eloquent-pruning.pruning_column','created_at');
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
        if(property_exists($this,'hours')){
            return $this->hours;
        }

        return config('laravel-eloquent-pruning.hours','24');
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
        if(property_exists($this,'chunkSize')){
            return $this->chunkSize;
        }

        return config('laravel-eloquent-pruning.chunk_size',100);
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
     * Start deleting items that are too old
     */
    public function prune(DateTimeInterface $before = null)
    {
        if (is_null($before)) {
            $before = Date::now()->subHours($this->getHours());
        }
        $query = $this->where($this->getPruningColumn(), '<', $before);

        $totalDeleted = 0;
        do {
            $deleted = $query->take($this->getChunkSize())->delete();
            $totalDeleted += $deleted;
        } while ($deleted !== 0);

        return $totalDeleted;
    }
}