<?php


namespace App\Eloquent;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BelongsToManyOrOne extends BelongsToMany
{
    /**
     * @var boolean
     */
    protected bool $isMany = true;

    /**
     * @return mixed
     */
    public function getResults(): mixed
    {
        return $this->isMany ? $this->get() : $this->first();
    }

    /**
     * @return $this
     */
    public function expectOne(): BelongsToManyOrOne
    {
        $this->isMany = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function expectMany(): BelongsToManyOrOne
    {
        $this->isMany = true;

        return $this;
    }
}
