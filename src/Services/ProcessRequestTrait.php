<?php

namespace JoBins\APIGenerator\Services;

use Illuminate\Support\Arr;

trait ProcessRequestTrait
{
    /**
     * @var array
     */
    protected array $request;

    /**
     * @param  array  $request
     * @return $this
     */
    public function setRequest(array $request): self
    {
        $this->request = $request;

        return $this;
    }

    private function parseRequestBody(): ?array
    {
        $className = Arr::get($this->request, 'rule');

        if (empty($className)) {
            return null;
        }

        return [
            '$ref' => '#/components/requestBodies/'.getClassIdentifier($className),
        ];
    }
}
