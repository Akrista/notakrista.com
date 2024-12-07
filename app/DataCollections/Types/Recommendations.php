<?php

declare(strict_types=1);

namespace App\DataCollections\Types;

use App\Extend\Concerns\DataCollectionType;
use Hyde\Markdown\Models\Markdown;

class Recommendations extends DataCollectionType
{
    public string $name;

    public ?string $title;

    public ?string $company;

    public ?string $company_url;

    public ?string $linkedin_link;

    public ?string $linkedin_username;

    public ?string $profile_image;

    public Markdown $markdown;
}
