<?php
namespace App\Traits;

trait CheckExistingEntriesTrait
{
    /**
     * Check if entries already exist in the specified model.
     *
     * @param  string  $modelClass
     * @return bool
     */
    protected function entriesExist($modelClass)
    {
        return $modelClass::count() > 0;
    }
}
