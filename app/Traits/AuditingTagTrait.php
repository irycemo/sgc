<?php

namespace App\Traits;

trait AuditingTagTrait
{

    public array $dynamicAuditTags = [];

    public function generateTags(): array
    {

        if ($this->getAuditEvent() === 'updated' && !empty($this->dynamicAuditTags)) {

            return $this->dynamicAuditTags;

        }

        return [];

    }

}
