<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class TeamMemberRole extends Model
{
    protected $casts = [
        "assigned_at" => "datetime",
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class, "team_member_id");
    }
}
