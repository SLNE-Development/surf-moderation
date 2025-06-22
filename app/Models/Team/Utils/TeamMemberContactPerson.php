<?php

namespace App\Models\Team\Utils;

use App\Models\Team\TeamMember;
use Illuminate\Database\Eloquent\Model;

class TeamMemberContactPerson extends Model
{
    protected $fillable = [
        'team_member_id',
        'contact_person_id',
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id');
    }

    public function contactPerson()
    {
        return $this->belongsTo(TeamMember::class, 'contact_person_id');
    }
}
