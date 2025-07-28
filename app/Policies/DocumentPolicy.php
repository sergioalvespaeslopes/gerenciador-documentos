<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Document $document): bool { return $user->id === $document->user_id; }
    public function create(User $user): bool { return true; }
    public function update(User $user, Document $document): bool { return $user->id === $document->user_id; }
    public function delete(User $user, Document $document): bool { return $user->id === $document->user_id; }
    public function download(User $user, Document $document): bool { return $user->id === $document->user_id; }
}