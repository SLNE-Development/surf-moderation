<?php

namespace App\Models\Team;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TeamMemberNote extends Model
{
    protected $fillable = [
        'team_member_id',
        'author_id',
        'note',
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
